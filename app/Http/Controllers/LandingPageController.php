<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingSettings;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $host = request()->getHost();
        $mainDomain = 'limsstage.com';
        $mainDomain = 'localhost';
        $subdomain = null;
        $isSubdomain = false; 
        if ($host != $mainDomain) { 
            $parts = explode('.', $host);
            $lastTwo = implode('.', array_slice($parts, -1));
            if ($lastTwo === $mainDomain) {
                $subdomain = implode('.', array_slice($parts, 0, -1));
                $isSubdomain = true;
            }
            if ($isSubdomain) {
                return redirect()->route('login-page' );
            }
        }
        $home_image = LandingSettings::where('type', 'home_settings')->where('key', 'home_image')->select('key', 'value', 'type')->first();
        $home_title = LandingSettings::where('type', 'home_settings')->where('key', 'home_title')->select('key', 'value', 'type')->first();
        $home_subtitle = LandingSettings::where('type', 'home_settings')->where('key', 'home_subtitle')->select('key', 'value', 'type')->first();
        $feature_image = LandingSettings::where('type', 'feature_settings')->where('key', 'feature_image')->select('key', 'value', 'type')->first();
        $feature_title = LandingSettings::where('type', 'feature_settings')->where('key', 'feature_title')->select('key', 'value', 'type')->first();
        $feature_subtitle = LandingSettings::where('type', 'feature_settings')->where('key', 'feature_subtitle')->select('key', 'value', 'type')->first();
        $favicon = LandingSettings::where('type', 'header_settings')->where('key', 'header_favicon')->select('key', 'value', 'type')->first();
        $logo = LandingSettings::where('type', 'header_settings')->where('key', 'header_logo')->select('key', 'value', 'type')->first();
        $contact_title = LandingSettings::where('type', 'contact_settings')->where('key', 'contact_title')->select('key', 'value', 'type')->first();
        $contact_subtitle = LandingSettings::where('type', 'contact_settings')->where('key', 'contact_subtitle')->select('key', 'value', 'type')->first();
        $contact_email = LandingSettings::where('type', 'contact_settings')->where('key', 'contact_email')->select('key', 'value', 'type')->first();


        $data = [
            'home_image' => $home_image,
            'home_title' => $home_title,
            'home_subtitle' => $home_subtitle,
            'feature_image' => $feature_image,
            'feature_title' => $feature_title,
            'feature_subtitle' => $feature_subtitle,
            'favicon'           => $favicon,
            'logo'               => $logo,
            'contact_title' => $contact_title,
            'contact_subtitle' => $contact_subtitle,
            'contact_email' => $contact_email,
        ];
        return view('landing', $data);
    }
}
