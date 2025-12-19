<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingSettings;

class LandingPageSettingsController extends Controller
{
    public function list()
    {
        return view('admin.landing_page.landing-side');
    }

    public function header()
    {
        $favicon = LandingSettings::where('type', 'header_settings')->where('key' , 'header_favicon')->select('key', 'value' ,'type')->first();
        $logo = LandingSettings::where('type', 'header_settings')->where('key' , 'header_logo')->select('key', 'value' ,'type')->first();
        $data =[
            'favicon' => $favicon, 
            'logo' => $logo,
        ];
        return view('admin.landing_page.header' , $data);
    }

    public function header_update(Request $request)
    {
        // Logic to store landing page settings
            if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/landing_page/header/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $oldImage = LandingSettings::where('key', 'header_logo' )->where('type' , 'header_settings')->first();
            if ($oldImage && file_exists(public_path($oldImage->value))) {
                unlink(public_path($oldImage->value));
            }
            $file->move($path, $filename);

            LandingSettings::updateOrCreate(
                ['key' => 'header_logo'],
                [
                    'value' => 'uploads/landing_page/header/' . $filename,
                    'type' => 'header_settings'
                ]
            );
        }
             if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/landing_page/header/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $oldImage = LandingSettings::where('key', 'header_favicon' )->where('type' , 'header_settings')->first();
            if ($oldImage && file_exists(public_path($oldImage->value))) {
                unlink(public_path($oldImage->value));
            }
            $file->move($path, $filename);

            LandingSettings::updateOrCreate(
                ['key' => 'header_favicon'],
                [
                    'value' => 'uploads/landing_page/header/' . $filename,
                    'type' => 'header_settings'
                ]
            );
        }
        return redirect()->back()->with('success' , translate('updated_successfully'));
    }
    public function home()
    {
        $title = LandingSettings::where('type', 'home_settings')->where('key' , 'home_title')->select('key', 'value' ,'type')->first();
        $subtitle = LandingSettings::where('type', 'home_settings')->where('key' , 'home_subtitle')->select('key', 'value' ,'type')->first();
        $image = LandingSettings::where('type', 'home_settings')->where('key' , 'home_image')->select('key', 'value' ,'type')->first();
        $data =[
            'title' => $title,
            'subtitle' => $subtitle,
            'image' => $image,
        ];
        return view('admin.landing_page.home', $data);
    }

    public function home_update(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/landing_page/home/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $oldImage = LandingSettings::where('key', 'home_image' )->where('type' , 'home_settings')->first();
            if ($oldImage && file_exists(public_path($oldImage->value))) {
                unlink(public_path($oldImage->value));
            }
            $file->move($path, $filename);

            LandingSettings::updateOrCreate(
                ['key' => 'home_image'],
                [
                    'value' => 'uploads/landing_page/home/' . $filename,
                    'type' => 'home_settings'
                ]
            );
        }
        $title = LandingSettings::updateOrCreate(  ['key' => 'home_title'],[
            'key' => 'home_title',
            'value' => $request->title,
            'type' => 'home_settings'
        ]);
        $subtitle = LandingSettings::updateOrCreate(  ['key' => 'home_subtitle'],[
            'key' => 'home_subtitle',
            'value' => $request->subtitle,
            'type' => 'home_settings'
        ]);

        return redirect()->back()->with('success', translate('Home settings updated successfully.'));
    }
    public function feature()
    {
        $title = LandingSettings::where('type', 'feature_settings')->where('key' , 'feature_title')->select('key', 'value' ,'type')->first();
        $subtitle = LandingSettings::where('type', 'feature_settings')->where('key' , 'feature_subtitle')->select('key', 'value' ,'type')->first();
        $image = LandingSettings::where('type', 'feature_settings')->where('key' , 'feature_image')->select('key', 'value' ,'type')->first();
        $data =[
            'title' => $title,
            'subtitle' => $subtitle,
            'image' => $image,
        ];
        return view('admin.landing_page.feature', $data);
    }

    public function feature_update(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/landing_page/feature/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $oldImage = LandingSettings::where('key', 'feature_image' )->where('type' , 'feature_settings')->first();
            if ($oldImage && file_exists(public_path($oldImage->value))) {
                unlink(public_path($oldImage->value));
            }
            $file->move($path, $filename);

            LandingSettings::updateOrCreate(
                ['key' => 'feature_image'],
                [
                    'value' => 'uploads/landing_page/feature/' . $filename,
                    'type' => 'feature_settings'
                ]
            );
        }
        $title = LandingSettings::updateOrCreate(  ['key' => 'feature_title'],[
            'key' => 'feature_title',
            'value' => $request->title,
            'type' => 'feature_settings'
        ]);
        $subtitle = LandingSettings::updateOrCreate(  ['key' => 'feature_subtitle'],[
            'key' => 'feature_subtitle',
            'value' => $request->subtitle,
            'type' => 'feature_settings'
        ]);

        return redirect()->back()->with('success', translate('Feature settings updated successfully.'));
    }
    public function contact()
    {
        $title = LandingSettings::where('type', 'contact_settings')->where('key' , 'contact_title')->select('key', 'value' ,'type')->first();
        $subtitle = LandingSettings::where('type', 'contact_settings')->where('key' , 'contact_subtitle')->select('key', 'value' ,'type')->first();
        $email = LandingSettings::where('type', 'contact_settings')->where('key' , 'contact_email')->select('key', 'value' ,'type')->first();
        $data =[
            'title' => $title,
            'subtitle' => $subtitle,
            'email' => $email,
        ];
        return view('admin.landing_page.contact', $data);
    }

    public function contact_update(Request $request)
    {
      
        $title = LandingSettings::updateOrCreate(  ['key' => 'contact_title'],[
            'key' => 'contact_title',
            'value' => $request->title,
            'type' => 'contact_settings'
        ]);
        $subtitle = LandingSettings::updateOrCreate(  ['key' => 'contact_subtitle'],[
            'key' => 'contact_subtitle',
            'value' => $request->subtitle,
            'type' => 'contact_settings'
        ]);
        $email = LandingSettings::updateOrCreate(  ['key' => 'contact_email'],[
            'key' => 'contact_email',
            'value' => $request->email,
            'type' => 'contact_settings'
        ]);

        return redirect()->back()->with('success', translate('Contact us settings updated successfully.'));
    }
}
