<?php

namespace App\Facades\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;


class Settings
{
    public function price($value)
    {
        if ($value) {
            return number_format($value, 2) . ' ' . $this->currency();
        }
        return 0 . $this->currency();
    }

    public function currency()
    {
        return 'Tk.';
    }
    public function site_title()
    {
        $siteTitle = Setting::where('key', 'site.title')->value('value');
        return $siteTitle;
    }
    public function site_logo()
    {
        $imagePath = Setting::where('key', 'site.logo')->value('value');
        return $imagePath;
    }
    public function site_email()
    {
        $siteEmail = Setting::where('key', 'site.email')->value('value');
        return $siteEmail;
    }
    public function site_phone()
    {
        $sitePhone = Setting::where('key', 'site.phone')->value('value');
        return $sitePhone;
    }
    public function option($param = null)
    {

        if ($param) {
            $settings = Cache::remember('settings', 5, function () {
                return Setting::firstOrNew();
            });
            return $settings->{$param};
        }
        return null;

    }
}
