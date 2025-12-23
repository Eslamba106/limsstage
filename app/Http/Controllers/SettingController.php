<?php

namespace App\Http\Controllers;

use App\Models\UiSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
     public function ui_settings(Request $request, $position = 'dashboard')
    {
        $words = UiSettings::where('position', $position)->get();

        $data = [
            'word'     => $words,
            'position' => $position,
        ];
        return view('settings.ui_settings.ui_settings', $data);
    }

    public function translate_submit(Request $request, $position)
    {
        DB::connection('tenant')->table('ui_settings')
            ->where('key', $request->key)
            ->where('position', $position)
            ->update([
                'value' => $request->value,
            ]);
    }
    public function translate_key_remove(Request $request, $position)
    {
        DB::connection('tenant')->table('ui_settings')
            ->where('key', $request->key)
            ->where('position', $position)
            ->delete();
    }

    public function translate_list($position)
{
    $words = (new UiSettings())->setConnection('tenant')->where('position', $position)->get();

    $data = [];  

    foreach ($words as $item) {
        $data[] = [
            'key'   => $item->key,
            'value' => $item->value,
        ];
    }
     return response()->json($data);
}

    // public function translate_list($position ='dashboard')
    // {
    //     $data = [];
    //      $words = (new UiSettings())->setConnection('tenent')->where('position', $position)->get(['key', 'value']);

    // return response()->json($words);
    //     // return response()->json($data);

    // }
}
