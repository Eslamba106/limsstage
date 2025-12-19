<?php
namespace App\Http\Controllers\second_part;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\Sample;
use App\Models\SampleTestMethod;
use App\Models\second_part\Submission;
use App\Models\second_part\SubmissionItem;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {

        $this->authorize('submission_management');

        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_submissions_status');

            Submission::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }
        if ($request->bulk_action_btn === 'delete' && is_array($ids) && count($ids)) {

            Submission::whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $submissions = Submission::orderBy("created_at", "desc")->paginate(10);
        return view("second_part.submission.index", compact("submissions"));
    }

    public function create()
    {
        $this->authorize('create_sample');

        $plants = Plant::select('id', 'name', 'plant_id')->whereNull('plant_id')->get();
        $data   = [
            'plants' => $plants,
        ];
        return view("second_part.submission.create", $data);
    }

    public function store(Request $request)
    {
        $this->authorize('create_submission');
        $request->validate([
            'plant_id'               => 'required|exists:plants,id',
            'sub_plant_id'           => 'nullable|exists:plants,id',
            'plant_sample_id'        => 'required|exists:plant_samples,id',
            'priority'               => 'required|in:high,normal,critical',
            'sampling_date_and_time' => 'nullable|date',
            'comment'                => 'nullable|string|max:255',
        ]);
        $date       = Carbon::createFromFormat('Y-m-d\TH:i', $request->sampling_date_and_time);
        $sample     = Sample::where('plant_sample_id', $request->plant_sample_id)->first();
        $submission = Submission::create([
            'plant_id'               => $request->plant_id,
            'sub_plant_id'           => $request->sub_plant_id,
            'plant_sample_id'        => $request->plant_sample_id,
            'sample_id'              => $sample->id,
            'priority'               => $request->priority,
            'sampling_date_and_time' => $date,
            'comment'                => $request->comment,
        ]);
        $submission->submission_number = 'SUB-' . str_pad($submission->id, 6, '0', STR_PAD_LEFT);
        $submission->save();
        // dd($request->sample_test_method_item_id);
        foreach ($request->input("sample_test_method_item_id") as $key => $sample_test_method_item_main) {
            // dd($sample_test_method_item);
            DB::table('submission_items')->insert([
                'sample_test_method_item_id' => $sample_test_method_item_main,
                'submission_id'              => $submission->id,
            ]);
        }

        return redirect()->route('admin.submission')->with('success', __('general.created_successfully'));
    }

    public function edit($id)
    {
        $this->authorize('edit_submission');
        $submission = Submission::findOrFail($id);
        $plants     = Plant::select('id', 'name', 'plant_id')->whereNull('plant_id')->get();
        $data       = [
            'submission' => $submission,
            'plants'     => $plants,
        ];
        return view("second_part.submission.edit", $data);
    }
    public function update(Request $request, $id)
    {
        $this->authorize('edit_submission');
        // dd($request->all());
        $submission = Submission::findOrFail($id);
        $request->validate([
            'plant_id'               => 'required|exists:plants,id',
            'sub_plant_id'           => 'nullable|exists:plants,id',
            'plant_sample_id'        => 'required|exists:plant_samples,id',
            'priority'               => 'required|in:high,normal,critical',
            'sampling_date_and_time' => 'nullable|date',
            'comment'                => 'nullable|string|max:255',
        ]);
        $date = Carbon::createFromFormat('Y-m-d\TH:i', $request->sampling_date_and_time);
        $submission->update([
            'plant_id'               => $request->plant_id,
            'sub_plant_id'           => $request->sub_plant_id,
            'plant_sample_id'        => $request->plant_sample_id,
            'priority'               => $request->priority,
            'sampling_date_and_time' => $date,
            'comment'                => $request->comment,
        ]);
        $submission_items = SubmissionItem::where('submission_id', $id)->get();

        foreach ($submission_items as $submission_item) {
            $inputKey = "sample_test_method_item_id-" . $submission_item->id;
            if (! array_key_exists($inputKey, $request->all())) {
                $submission_item->delete();
            }
        }
        if (isset($request->sample_test_method_item_id)) {
            foreach ($request->sample_test_method_item_id as $sample_test_method_item) {
                DB::table('submission_items')->insert([
                    'sample_test_method_item_id' => $sample_test_method_item,
                    'submission_id'              => $submission->id,
                ]);
            }
        }
        return redirect()->route('admin.submission')->with('success', __('general.updated_successfully'));
    }

    public function destroy($id)
    {
        $this->authorize('delete_submission');
        $submission = Submission::findOrFail($id);
        $submission->delete();
        return redirect()->route('admin.submission')->with('success', __('general.deleted_successfully'));
    }

    public function get_test_method_by_sample_id($id)
    {
        $this->authorize('create_sample');
        $sample      = Sample::where('plant_sample_id', $id)->select('id')->first();
        $test_method = SampleTestMethod::where('sample_id', $sample->id)->with('master_test_method')->get();

        return response()->json([
            'status'       => 200,
            "test_methods" => $test_method,
        ]);
    }

    // schedule submission
    public function updateStatusByBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        $submission = Submission::where('submission_number', $request->barcode)->first();

        if (! $submission) {
            return response()->json(['success' => false, 'message' => translate('barcode_not_found')]);
        }

        $submission->status = 'second_step';
        $submission->save();

        return response()->json(['success' => true, 'message' => translate('The_sample_has_been_received')]);
    }

    public function scanPage(Request $request){
        return view('second_part.submission.read_barcode');
    }

    public function change_status($id , $status){
        
        $submission = Submission::findOrFail($id); 

        $submission->status = $status;
        $submission->save();
        return redirect()->back()->with('success' , translate('updated_successfully'));
    }
    public function change_status_without_qr($id ){
        
        $submission = Submission::findOrFail($id); 

        $submission->status = 'second_step';
        $submission->save();
        return redirect()->back()->with('success' , translate('updated_successfully'));
    }

}
