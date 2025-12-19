<?php

namespace App\helper;

use App\Models\BusinessSetting;
use App\Models\Schema;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Helpers
{

    public static function default_lang()
    {
        if (strpos(url()->current(), '/api')) {
            $lang = App::getLocale();
        } elseif (session()->has('local')) {
            $lang = session('local');
        } else {
            $data      = Helpers::get_business_settings('language');
            $code      = 'en';
            $direction = 'ltr';
            if (isset($data) && is_array($data)) {
                foreach ($data as $ln) {
                    if (array_key_exists('default', $ln) && $ln['default']) {
                        $code = $ln['code'];
                        if (array_key_exists('direction', $ln)) {
                            $direction = $ln['direction'];
                        }
                    }
                }
            }
            session()->put('local', $code);
            Session::put('direction', $direction);
            $lang = $code;
        }
        return $lang;
    }
    public static function pagination_limit()
    {
        $pagination_limit = BusinessSetting::where('type', 'pagination_limit')->first();
        if ($pagination_limit != null) {
            return $pagination_limit->value;
        } else {
            return 25;
        }
    }
    public static function get_business_settings($name)
    {
        $config = null;
        $check  = ['currency_model', 'currency_symbol_position', 'system_default_currency', 'language', 'company_name', 'decimal_point_settings', 'product_brand', 'digital_product', 'company_email'];

        if (in_array($name, $check) == true && session()->has($name)) {
            $config = session($name);
        } else {
            $data = BusinessSetting::where(['type' => $name])->first();
            if (isset($data)) {
                $config = json_decode($data['value'], true);
                if (is_null($config)) {
                    $config = $data['value'];
                }
            }

            if (in_array($name, $check) == true) {
                session()->put($name, $config);
            }
        }

        return $config;
    }
    public static function remove_invalid_charcaters($str)
    {
        return str_ireplace(['\'', '"', ',', ';', '<', '>', '?'], ' ', preg_replace('/\s\s+/', ' ', $str));
    }
    public static function module_check($mod_name)
    {
        if (auth()->user()->role_id == 2) {
            return true;
        }
        if (auth('admins')->check()) {
            return true;
        }
        $currentTenant = app('current_tenant');

        $module = Schema::find($currentTenant->schema_id);

        if ($module && isset($module->$mod_name) && $module->$mod_name == 1) {
            return true;
        }
        return false;
    }
    
}

function auto_translator($q, $sl, $tl)
{
    $res = file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&ie=UTF-8&oe=UTF-8&dt=bd&dt=ex&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=ss&dt=t&dt=at&sl=" . $sl . "&tl=" . $tl . "&hl=hl&q=" . urlencode($q), $_SERVER['DOCUMENT_ROOT'] . "/transes.html");
    $res = json_decode($res);
    return str_replace('_', ' ', $res[0][0][0]);
}

function getLanguageCode(string $country_code): string
{
    $locales = [
        'af-ZA',
        'am-ET',
        'ar-AE',
        'ar-BH',
        'ar-DZ',
        'ar-EG',
        'ar-IQ',
        'ar-JO',
        'ar-KW',
        'ar-LB',
        'ar-LY',
        'ar-MA',
        'ar-OM',
        'ar-QA',
        'ar-SA',
        'ar-SY',
        'ar-TN',
        'ar-YE',
        'az-Cyrl-AZ',
        'az-Latn-AZ',
        'be-BY',
        'bg-BG',
        'bn-BD',
        'bs-Cyrl-BA',
        'bs-Latn-BA',
        'cs-CZ',
        'da-DK',
        'de-AT',
        'de-CH',
        'de-DE',
        'de-LI',
        'de-LU',
        'dv-MV',
        'el-GR',
        'en-AU',
        'en-BZ',
        'en-CA',
        'en-GB',
        'en-IE',
        'en-JM',
        'en-MY',
        'en-NZ',
        'en-SG',
        'en-TT',
        'en-US',
        'en-ZA',
        'en-ZW',
        'es-AR',
        'es-BO',
        'es-CL',
        'es-CO',
        'es-CR',
        'es-DO',
        'es-EC',
        'es-ES',
        'es-GT',
        'es-HN',
        'es-MX',
        'es-NI',
        'es-PA',
        'es-PE',
        'es-PR',
        'es-PY',
        'es-SV',
        'es-US',
        'es-UY',
        'es-VE',
        'et-EE',
        'fa-IR',
        'fi-FI',
        'fil-PH',
        'fo-FO',
        'fr-BE',
        'fr-CA',
        'fr-CH',
        'fr-FR',
        'fr-LU',
        'fr-MC',
        'he-IL',
        'hi-IN',
        'hr-BA',
        'hr-HR',
        'hu-HU',
        'hy-AM',
        'id-ID',
        'ig-NG',
        'is-IS',
        'it-CH',
        'it-IT',
        'ja-JP',
        'ka-GE',
        'kk-KZ',
        'kl-GL',
        'km-KH',
        'ko-KR',
        'ky-KG',
        'lb-LU',
        'lo-LA',
        'lt-LT',
        'lv-LV',
        'mi-NZ',
        'mk-MK',
        'mn-MN',
        'ms-BN',
        'ms-MY',
        'mt-MT',
        'nb-NO',
        'ne-NP',
        'nl-BE',
        'nl-NL',
        'pl-PL',
        'prs-AF',
        'ps-AF',
        'pt-BR',
        'pt-PT',
        'ro-RO',
        'ru-RU',
        'rw-RW',
        'sv-SE',
        'si-LK',
        'sk-SK',
        'sl-SI',
        'sq-AL',
        'sr-Cyrl-BA',
        'sr-Cyrl-CS',
        'sr-Cyrl-ME',
        'sr-Cyrl-RS',
        'sr-Latn-BA',
        'sr-Latn-CS',
        'sr-Latn-ME',
        'sr-Latn-RS',
        'sw-KE',
        'tg-Cyrl-TJ',
        'th-TH',
        'tk-TM',
        'tr-TR',
        'uk-UA',
        'ur-PK',
        'uz-Cyrl-UZ',
        'uz-Latn-UZ',
        'vi-VN',
        'wo-SN',
        'yo-NG',
        'zh-CN',
        'zh-HK',
        'zh-MO',
        'zh-SG',
        'zh-TW'
    ];

    foreach ($locales as $locale) {
        $locale_region = explode('-', $locale);
        if (strtoupper($country_code) == $locale_region[1]) {
            return $locale_region[0];
        }
    }

    return "en";
}
