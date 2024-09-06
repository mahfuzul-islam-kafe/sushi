<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Restaurant;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Payment
{
    const INTERFACE_VERSION = "HP_3.2";
    const CURRENCY_CODE = 978;

    protected $order;
    protected $credentials;
    protected $amount;
    protected $transactionReference;




    protected function validateCredentials()
    {
        if (
            (isset($this->credentials['secretKey'])  && !empty($this->credentials['secretKey'])) &&
            (isset($this->credentials['merchantId'])  && !empty($this->credentials['merchantId'])) &&
            (isset($this->credentials['key_version'])  && !empty($this->credentials['key_version']))
        ) {
            return true;
        } else {
            throw new Exception('API key missing');
        }
    }

    protected function body()
    {
        return 'amount=' . $this->amount . '|s10TransactionReference.s10TransactionId=' . $this->transactionReference . '|currencyCode=' . $this::CURRENCY_CODE . '|merchantId=' . $this->credentials['merchantId'] . '|normalReturnUrl=' . route('payment.callback', $this->order->restaurent) . '|orderId=' . $this->order->id . '|keyVersion=' . $this->credentials['key_version'];
    }

    protected function seal()
    {
        return hash('sha256', mb_convert_encoding($this->body(), 'UTF-8') . $this->credentials['secretKey']);
    }

    public static function make(Order $order)
    {
        if ($order->payment_method == 'Card') {
            return (new self)->makeRequest($order);
        } else {
            return redirect()->route('thank_you')->with('success', 'Thankyou for your order');
        }
    }
    public static function confirm(Restaurant $restaurant, $data, $seal)
    {
        return (new self)->resolve($restaurant, $data, $seal);
    }

    public function makeRequest($order)
    {
        $this->order = $order;
        $this->credentials = json_decode($this->order->restaurent->api_key, true);
        $this->validateCredentials();
        $this->amount = $this->order->total * 100;

        $this->transactionReference = str_pad($order->id * now()->format('ymdhis'), 6, '0', STR_PAD_LEFT);

        $response =   Http::asForm()->post('https://sherlocks-payment-webinit.secure.lcl.fr/paymentInit', [
            'DATA' => $this->body(),
            'SEAL' => $this->seal(),
            'interfaceVersion' => $this::INTERFACE_VERSION,
        ]);

        return $response->body();
    }


    protected function validateSeal($secretKey, $data, $seal)
    {
        $calculatedSeal = hash('sha256', mb_convert_encoding($data, 'UTF-8') . $secretKey);
        if ($calculatedSeal !== $seal) throw new Exception('Invalid response');
        return true;
    }

    protected function decodeData(string $data): array
    {
        $decodedData = urldecode($data);
        $responseData = array_map(function ($part) {
            return explode('=', $part, 2);
        }, explode('|', $decodedData));
        $responseData = array_column($responseData, 1, 0);
        return $responseData;
    }
    public function resolve(Restaurant $restaurant,  $data,  $seal)
    {
        $secretKey = $restaurant->getPaymentCreds('secretKey');

        $this->validateSeal($secretKey, $data, $seal);

        // Decode and store the response data in the database
        $responseData = $this->decodeData($data);



        Log::info('Response Data:' . json_encode($responseData));

        // Create a new array with only the keys you're interested in
        $keysToStore = ['acquirerResponseCode', 'responseCode', 'amount', 'orderId', 's10TransactionId', 'merchantId', 'transactionReference', 'currencyCode', 'paymentMethod', 'paymentMeanBrand', 'transactionDateTime', 'cardNumber', 'cardNetwork', 'cardCountry'];
        $filteredData = array_filter($keysToStore, function ($key) use ($responseData) {
            return array_key_exists($key, $responseData);
        });

        // Get values for the filtered keys
        $filteredData = array_intersect_key($responseData, array_flip($filteredData));
        Log::info('Filtered Data:' . json_encode($filteredData));

        // Store $filteredData in the database

        //   $paymentrespone = PaymentResponse::create($filteredData);

        $orderId = $filteredData['orderId'];

        $order = Order::where('id', $orderId)->first();

        // $user = $order->user_id;
        // Log::info('User:' . $user);
        // // if (!auth()->check()) {
        // //     $userInstance = User::find($user);
        // //     Auth::loginAs($userInstance);
        // // }
        if ($filteredData['responseCode'] == '00') {
            $order->status = 'PAID';
            $order->transaction_id = $filteredData['s10TransactionId'];
            $order->transaction_body = json_encode($filteredData);
            $order->payment_status = 'confirmed';

            $order->save();
            $statusMessage = 'Payment processed successfully';
            return redirect()->route('thank_you')
                ->with('success', $statusMessage);
        } else {
            $order->status = 'UNPAID';
            $order->payment_status = 'failed';
            $order->response = json_encode($filteredData);
            $order->save();
            $statusMessage = 'Payment failed. Please try again';
            return redirect()->route('thank_you')
                ->withErrors($statusMessage);
        }
    }
}