<?php
namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\CoaSettings;
use Illuminate\Http\Request;

class CoaSettingsController extends Controller
{
    // app/Http/Controllers/CoaSettingController.php

    public function create()
    {
        $samplePoints = Sample::all();
        return view('part_three.template_settings.coa-settings', compact('samplePoints'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string',
            'frequency'        => 'required|string',
            'day'              => 'required|string',
            'execution_time'   => 'required',
            'condition'        => 'required|string',
            'sample_points'    => 'required|array',
            'email_recipients' => 'required|string',
        ]);

        $validated['sample_points'] = json_encode($validated['sample_points']);

        CoaSettings::create($validated);

        return redirect()->back()->with('success', 'Saved successfully!');
    }

}
