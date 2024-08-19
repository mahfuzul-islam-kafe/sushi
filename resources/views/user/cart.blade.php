<x-user>
    @php
        $firstItem = Cart::getContent()->first();
        $restaurant = $firstItem ? App\Models\Restaurant::find($firstItem->attributes->restaurent) : null;
        // $zone = $restaurant ? $restaurant->zones->get() : null;
    @endphp
    @push('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
        <style>
            .cart_submit {
                background-color: var(--accent-color);
                border: none;
                color: var(--heading-color);
                border-radius: 4px;
                font-size: small;
            }
        </style>
    @endpush

    <section id="about" class="cart_section pb-5">
        <div class="container section-title aos-init aos-animate mt-4" data-aos="fade-up">
            <h2>Menu</h2>
            <p>Check Our Products</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">
                <div class="col-lg-8 col-sm-12">
                    <div class="table-responsive">
                        <table class="cart_table  table-responsive">
                            <thead class="table_head text-dark">
                                <th class="cart-product-remove" style="padding-left:20px;">Remove</th>
                                <th class="cart-product-image">Image</th>
                                <th class="cart-product-info text-center">Name</th>
                                <th class="cart-product-price">Price</th>
                                <th class="cart-product-quantity text-center">Quantity</th>
                                <th class="cart-product-subtotal text-center">Subtotal</th>
                            </thead>
                            <tbody class="table_body">
                                {{-- @dd(Cart::getContent()) --}}
                                @forelse (Cart::getContent() as $item)
                                    {{-- @dd($item) --}}
                                    <tr>
                                        <td class="cart-product-remove text-start ps-4">
                                            <a class="cart-product-remove text-center"
                                                href="{{ url('/cart-destroy/' . $item->id) }}">x</a>
                                        </td>
                                        {{-- @dd($item) --}}
                                        @if (isset($item->attributes['restaurent']))
                                            @php
                                                $restuarant = App\Models\Restaurant::find(
                                                    $item->attributes['restaurent'],
                                                );
                                            @endphp
                                            <td class="cart-product-image">
                                                <a
                                                    href="{{ route('single.restaurant', ['restaurant' => $restuarant->slug, 'product' => $item->model->id]) }}">
                                                    <img src="{{ Storage::url($item->image ?? '') }}"
                                                        alt="{{ $item->name }}">
                                                </a>
                                            </td>

                                            <td class="cart-product-info text-center">
                                                <h4><a
                                                        href="{{ route('single.restaurant', ['restaurant' => $restuarant->slug, 'product' => $item->model->id]) }}">{{ $item->name }}</a>
                                                </h4>
                                            </td>
                                        @endif

                                        <td class="cart-product-price">{{ $item->price }}€</td>

                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->id }}" />
                                            <td class="cart-product-quantity d-flex justify-content-center mt-3">
                                                <div class="text-start d-flex cart_quantity">
                                                    <div class="cart_quantity_item">
                                                        <input type="text" value="{{ $item->quantity }}"
                                                            name="quantity" class="text-center"
                                                            style="width: 100% !important; height: 100% !important; background-color: transparent !important;  border: 0 !important;outline: none; color:var(--heading-color);">
                                                    </div>
                                                    <div class="cart_quantity_item1">
                                                        <button type="submit" class="update_btn"><i class="fa-solid fa-floppy-disk"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                        </form>
                                        <td class="cart-product-subtotal text-center">
                                            {{ $item->price * $item->quantity }} €</td>
                                    </tr>

                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-12 order-2 order-lg-1 content p-md-0" style="height: 226px;">
                    <div class="">
                        <h4 class="ms-3 pt-2" style="">Cart Totals</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table-responsive" style="width: 100%;">
                            <tbody class="me-2 ms-2">
                                <tr style="height: 40px; ">
                                    <td class="ps-4">Cart Subtotal</td>
                                    <td>{{ Cart::getSubTotal() }} €</td>
                                </tr>
                                <tr style="height: 40px;">
                                    <td class="ps-4">Shipping and Handing</td>
                                    <td>$00.00</td>
                                </tr>
                                <tr style="height: 40px;">
                                    <td class="ps-4">Vat</td>
                                    <td>$00.00</td>
                                </tr>
                                <tr style="height: 40px;">
                                    <td class="ps-4"><strong>Order Total</strong></td>
                                    <td><strong id="order_total_display">{{ Cart::getTotal() }} €</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="btn-wrapper text-center pe-md-3">
                        @if (Cart::isEmpty())
                            <a href="{{ route('restaurant.home') }}" class="checkout_btn">Proceed to checkout</a>
                        @else
                            <a href="{{ route('restaurant.checkout') }}" class="checkout_btn">Proceed to checkout</a>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </section>
    <section id="" class="extra_section pt-1">
        <div class="container section-title aos-init aos-animate mt-5" data-aos="fade-up">
            <h2>Menu</h2>
            <p>Choose Our Extra Menu</p>
        </div>
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-12">
                    <div class="row text-center p-2">
                        @foreach ($extras as $extra)
                            {{-- @dd($extra); --}}

                            <div class="col-md-2 col-sm-6 d-flex align-items-center subcart2"
                                style="flex-direction: column; justify-content: space-between;">
                                <h5 class="ft-16 p-2 seccolr">{{ $extra->name }}</h5>
                                <form action="{{ route('extra.store') }}" method="post">
                                    @csrf
                                    <div class="cart-product-quantity d-flex justify-content-center">
                                        <div class="cart-plus-minus">
                                            <div class="dec qtybutton"
                                                onclick="changeQuantity(-1, '{{ $extra->id }}', {{ $extra->price }}, '{{ $extra->name }}')">
                                                -</div>
                                            {{-- @dd($extra) --}}
                                            <input type="text" value="0"
                                                name="quantity"
                                                class="cart-plus-minus-box" id="extra_quantity_{{ $extra->id }}"
                                                min="1" placeholder="0" data-price="{{ $extra->price }}"
                                                data-name="{{ $extra->name }}" readonly>

                                            <div class="inc qtybutton"
                                                onclick="changeQuantity(1, '{{ $extra->id }}', {{ $extra->price }}, '{{ $extra->name }}')">
                                                +</div>
                                        </div>
                                    </div>
                                    <div class="pricetag justify-content-center">
                                        <div class="centerinput" style="width: 100px">
                                            <p style="font-weight: 100;" class="mb-0">
                                                {{-- <input name="" id="price_{{ $extra->id }}"
                                                    style="width: 100px" class="p-0 text-center" readonly
                                                    value="0"> --}}
                                                {{ $extra->price }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mb-2">

                                        {{-- <input type="hidden" name="quantity" id="form_quantity_{{ $extra->id }}"
                                            value="1"> --}}
                                        <input type="hidden" name="product_id" value="{{ $extra->id }}">
                                        <input type="hidden" name="price" id="form_price_{{ $extra->id }}" value="{{ $extra->price }}"> 
                                        <input type="hidden" name="restaurent_id" value="{{ $restaurant->id ?? '' }}">
                                        <button type="submit" class="cart_submit">Add Cart</button>

                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('js')
        <script>
            function changeQuantity(change, id, price, name) {
                const quantityInput = document.getElementById(`extra_quantity_${id}`);
                const currentQuantity = Math.max(0, parseInt(quantityInput.value) + change);

                quantityInput.value = currentQuantity;
                // document.getElementById(`price_${id}`).value = `${(currentQuantity * price).toFixed(2)}€`;

                // Update hidden form fields
                document.getElementById(`form_quantity_${id}`).value = currentQuantity;
                // document.getElementById(`form_price_${id}`).value = currentQuantity * price;
            }
        </script>


        {{-- <script>
            function checkLoginStatus() {
                @if (auth()->check())
                    return true; // Allow form submission
                @else
                    alert('Please log in to proceed to checkout.');
                    return false; // Prevent form submission
                @endif
            }
        </script> --}}
    @endpush

</x-user>
