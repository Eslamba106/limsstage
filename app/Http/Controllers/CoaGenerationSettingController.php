<?php
namespace App\Http\Controllers;

use App\Models\CoaGenerationSetting;
use App\Models\Plant;
use App\Models\Sample;
use App\Models\second_part\Frequency;
use App\Models\WebEmail;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoaGenerationSettingController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {

        $this->authorize('coa_generation_settings');

        $ids = $request->bulk_ids;
        // $now = Carbon::now()->toDateTimeString();
        // if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
        //     $data = ['status' => $request->status];
        //     $this->authorize('change_submissions_status');

        //     SampleRoutineScheduler::whereIn('id', $ids)->update($data);
        //     return back()->with('success', translate('updated_successfully'));
        // }
        // if ($request->bulk_action_btn === 'delete' && is_array($ids) && count($ids)) {

        //     SampleRoutineScheduler::whereIn('id', $ids)->delete();
        //     return back()->with('success', translate('deleted_successfully'));
        // }

        $coa_generation_settings = CoaGenerationSetting::orderBy("created_at", "desc")->paginate(10);
        return view("coa_generation_settings.index", compact("coa_generation_settings"));
    }

    public function create()
    {
        $plants      = Plant::select('id', 'name')->get();
        $samples     = Sample::select('id', 'plant_sample_id')->with('sample_plant:id,name')->get();
        $frequencies = Frequency::select('id', 'name')->get();
        $emails      = WebEmail::select('id', 'email')->get();
        $data        = [
            'plants'      => $plants,
            'samples'     => $samples,
            'emails'      => $emails,
            'frequencies' => $frequencies,
        ];
        return view("coa_generation_settings.create", $data);

    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                 => 'required',
            'frequency_id'         => 'required',
            'generation_condition' => 'required',
            'emails'               => 'required',
            'sample_points'        => 'required',
        ]);

        DB::beginTransaction();
        try {
            $coa_generation_setting = CoaGenerationSetting::create([
                'name'                 => $request->name,
                'frequency'            => $request->frequency_id,
                'execution_time'       => $request->execution_time,
                'generation_condition' => $request->generation_condition,
            ]);
            if ($request->has('emails')) {
                $coa_generation_setting->emails()->sync($request->emails);
            }
            if ($request->has('sample_points')) {
                $coa_generation_setting->Sample()->sync($request->sample_points);
            }
            DB::commit();
            return redirect()->route('coa_generation_setting.list')->with('success', translate('Added_Successfully'));
        } catch (Exception $ex) {
            DB::rollBack();
            return back()->with('errors', $ex->getMessage());
        }

    }
    public function edit($id)
    {
        $coa_generation_setting = CoaGenerationSetting::findOrFail($id);
        $plants                 = Plant::select('id', 'name')->get();
        $samples                = Sample::select('id', 'plant_sample_id')->with('sample_plant:id,name')->get();
        $frequencies            = Frequency::select('id', 'name')->get();
        $emails                 = WebEmail::select('id', 'email')->get();
        $data                   = [
            'plants'                 => $plants,
            'samples'                => $samples,
            'emails'                 => $emails,
            'frequencies'            => $frequencies,
            'coa_generation_setting' => $coa_generation_setting,
        ];
        return view("coa_generation_settings.edit", $data);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'                 => 'required',
            'frequency_id'         => 'required',
            'generation_condition' => 'required',
            'emails'               => 'required|array',
            'sample_points'        => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $coa_generation_setting = CoaGenerationSetting::findOrFail($id);

            $coa_generation_setting->update([
                'name'                 => $request->name,
                'frequency'            => $request->frequency_id,
                'execution_time'       => $request->execution_time,
                'generation_condition' => $request->generation_condition,
            ]);

            // sync emails
            if ($request->has('emails')) {
                $coa_generation_setting->emails()->sync($request->emails);
            } else {
                $coa_generation_setting->emails()->sync([]);
            }

            // sync samples
            if ($request->has('sample_points')) {
                $coa_generation_setting->Sample()->sync($request->sample_points);
            } else {
                $coa_generation_setting->Sample()->sync([]);
            }

            DB::commit();
            return redirect()->route('coa_generation_setting.list')
                ->with('success', translate('Updated_Successfully'));
        } catch (Exception $ex) {
            DB::rollBack();
            return back()->with('errors', $ex->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $coa_generation_setting = CoaGenerationSetting::findOrFail($id);
            $coa_generation_setting->emails()->detach();
            $coa_generation_setting->Sample()->detach();

            $coa_generation_setting->delete();

            DB::commit();
            return redirect()->route('coa_generation_setting.list')
                ->with('success', translate('Deleted_Successfully'));
        } catch (Exception $ex) {
            DB::rollBack();
            return back()->with('errors', $ex->getMessage());
        }
    }

}
