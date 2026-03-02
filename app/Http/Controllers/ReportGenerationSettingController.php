<?php
namespace App\Http\Controllers;

use App\Models\ReportGenerationSetting;
use App\Models\Plant;
use App\Models\Sample;
use App\Models\second_part\Frequency;
use App\Models\WebEmail;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Brian2694\Toastr\Facades\Toastr;

class ReportGenerationSettingController extends Controller
{
    use AuthorizesRequests;
    
    public function index(Request $request)
    {
        $this->authorize('coa_generation_settings'); // Using same permission for now
        
        $report_generation_settings = ReportGenerationSetting::with(['frequency_master', 'emails', 'samples'])
            ->orderBy("created_at", "desc")
            ->paginate(10);
            
        return view("report_generation_settings.index", compact("report_generation_settings"));
    }

    public function create()
    {
        $this->authorize('coa_generation_settings');
        
        $plants      = Plant::select('id', 'name')->get();
        $samples     = Sample::select('id', 'plant_sample_id')->with('sample_plant:id,name')->get();
        $frequencies = Frequency::select('id', 'name')->get();
        $emails      = WebEmail::select('id', 'email')->get();
        
        $data = [
            'plants'      => $plants,
            'samples'     => $samples,
            'emails'      => $emails,
            'frequencies' => $frequencies,
        ];
        
        return view("report_generation_settings.create", $data);
    }

    public function store(Request $request)
    {
        $this->authorize('coa_generation_settings');
        
        $request->validate([
            'name'                 => 'required|string|max:255',
            'frequency_id'         => 'required|exists:frequencies,id',
            'generation_condition' => 'required|in:1,2', // 1: all results, 2: out of spec only
            'report_type'         => 'required|in:1,2', // 1: all results, 2: out of spec only
            'emails'              => 'required|array|min:1',
            'sample_points'        => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $report_generation_setting = ReportGenerationSetting::create([
                'name'                 => $request->name,
                'frequency_id'         => $request->frequency_id,
                'execution_time'       => $request->execution_time,
                'generation_condition' => $request->generation_condition,
                'report_type'          => $request->report_type,
            ]);
            
            if ($request->has('emails')) {
                $report_generation_setting->emails()->sync($request->emails);
            }
            
            if ($request->has('sample_points')) {
                $report_generation_setting->samples()->sync($request->sample_points);
            }
            
            DB::commit();
            Toastr::success(translate('Added_Successfully'));
            return redirect()->route('report_generation_setting.list');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('Error creating report generation setting: ' . $ex->getMessage(), [
                'trace' => $ex->getTraceAsString()
            ]);
            Toastr::error(translate('something_went_wrong'));
            return back()->withInput();
        }
    }
    
    public function edit($id)
    {
        $this->authorize('coa_generation_settings');
        
        $report_generation_setting = ReportGenerationSetting::with(['emails', 'samples'])->findOrFail($id);
        $plants                     = Plant::select('id', 'name')->get();
        $samples                    = Sample::select('id', 'plant_sample_id')->with('sample_plant:id,name')->get();
        $frequencies                = Frequency::select('id', 'name')->get();
        $emails                     = WebEmail::select('id', 'email')->get();
        
        $data = [
            'plants'                     => $plants,
            'samples'                    => $samples,
            'emails'                     => $emails,
            'frequencies'                => $frequencies,
            'report_generation_setting'  => $report_generation_setting,
        ];
        
        return view("report_generation_settings.edit", $data);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('coa_generation_settings');
        
        $request->validate([
            'name'                 => 'required|string|max:255',
            'frequency_id'         => 'required|exists:frequencies,id',
            'generation_condition' => 'required|in:1,2',
            'report_type'         => 'required|in:1,2',
            'emails'              => 'required|array|min:1',
            'sample_points'        => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $report_generation_setting = ReportGenerationSetting::findOrFail($id);

            $report_generation_setting->update([
                'name'                 => $request->name,
                'frequency_id'         => $request->frequency_id,
                'execution_time'       => $request->execution_time,
                'generation_condition' => $request->generation_condition,
                'report_type'          => $request->report_type,
            ]);

            // sync emails
            if ($request->has('emails')) {
                $report_generation_setting->emails()->sync($request->emails);
            } else {
                $report_generation_setting->emails()->sync([]);
            }

            // sync samples
            if ($request->has('sample_points')) {
                $report_generation_setting->samples()->sync($request->sample_points);
            } else {
                $report_generation_setting->samples()->sync([]);
            }

            DB::commit();
            Toastr::success(translate('Updated_Successfully'));
            return redirect()->route('report_generation_setting.list');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('Error updating report generation setting: ' . $ex->getMessage(), [
                'trace' => $ex->getTraceAsString(),
                'id' => $id
            ]);
            Toastr::error(translate('something_went_wrong'));
            return back()->withInput();
        }
    }

    public function delete($id)
    {
        $this->authorize('coa_generation_settings');
        
        DB::beginTransaction();
        try {
            $report_generation_setting = ReportGenerationSetting::findOrFail($id);
            $report_generation_setting->emails()->detach();
            $report_generation_setting->samples()->detach();
            $report_generation_setting->delete();

            DB::commit();
            Toastr::success(translate('Deleted_Successfully'));
            return redirect()->route('report_generation_setting.list');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('Error deleting report generation setting: ' . $ex->getMessage(), [
                'trace' => $ex->getTraceAsString(),
                'id' => $id
            ]);
            Toastr::error(translate('something_went_wrong'));
            return back();
        }
    }
}
