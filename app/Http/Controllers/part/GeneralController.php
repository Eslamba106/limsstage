<?php

namespace App\Http\Controllers\part;

use App\Models\WebEmail;
use App\Models\part\Unit;
use Illuminate\Http\Request;
use App\Models\part\ResultType;
use App\Models\part\ToxicDegree;
use App\Http\Controllers\Controller;
use App\Models\second_part\Frequency;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class GeneralController extends Controller
{
    use AuthorizesRequests;
    
    public function frequency_index(Request $request)
    {
        $frequencys = Frequency::select('id', 'name' , 'time_by_hours' )->orderBy("created_at", "desc")->paginate(10);
        $data = [
            'main' => $frequencys,
            'route' => 'frequency',
        ];
        return view('general_part.index' , $data);
    }

    public function frequency_create()
    {
        $this->authorize('create_frequency');
        
        $data = [
            'route' => 'frequency',
        ];
        return view('general_part.create' , $data);
    }

    public function frequency_store(Request $request)
    {
        $this->authorize('create_frequency');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'time_by_hours' => 'required|numeric|min:1',
        ]);
        
        try {
            $frequency = Frequency::create([
                'name' => $request->name,
                'time_by_hours' => $request->time_by_hours,
            ]);
            
            return redirect()->route('admin.frequency')->with('success', __('general.added_successfully'));
        } catch (\Exception $e) {
            Log::error('Error creating frequency: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }
    public function frequency_edit($id)
    {
        $this->authorize('edit_frequency');
        
        $frequency = Frequency::findOrFail($id); 
        $data = [
            'main' => $frequency,
            'route' => 'frequency',
        ];
        return view('general_part.edit', $data);
    }
    public function frequency_update(Request $request, $id)
    {
        $this->authorize('edit_frequency');
        
        $request->validate([
            'name' => 'required|string|max:255|unique:frequencies,name,'.$id.',id',
            'time_by_hours' => 'required|numeric|min:1',
        ]);
        
        try {
            $frequency = Frequency::findOrFail($id);
            $frequency->update([
                'name' => $request->name,
                'time_by_hours' => $request->time_by_hours,
            ]);
            
            return redirect()->route('admin.frequency')->with('success', __('general.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Error updating frequency: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'frequency_id' => $id,
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }
    public function frequency_destroy($id)
    {
        $this->authorize('delete_frequency');
        
        try {
            $frequency = Frequency::findOrFail($id);
            $frequency->delete();
            
            return redirect()->route('admin.frequency')->with('success', __('general.deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Error deleting frequency: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'frequency_id' => $id
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')]);
        }
    }
    public function toxic_degree_index(Request $request)
    {
        $toxic_degrees = ToxicDegree::select('id', 'name' )->orderBy("created_at", "desc")->paginate(10);
        $data = [
            'main' => $toxic_degrees,
            'route' => 'toxic_degree',
        ];
        return view('general_part.index' , $data);
    }

    public function toxic_degree_create()
    {
        $this->authorize('create_toxic_degree');
        
        $data = [
            'route' => 'toxic_degree',
        ];
        return view('general_part.create' , $data);
    }

    public function toxic_degree_store(Request $request)
    {
        $this->authorize('create_toxic_degree');
        
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        try {
            $toxic_degree = ToxicDegree::create([
                'name' => $request->name,
            ]);
            
            return redirect()->route('admin.toxic_degree')->with('success', __('general.added_successfully'));
        } catch (\Exception $e) {
            Log::error('Error creating toxic degree: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }
    public function toxic_degree_edit($id)
    {
        $this->authorize('edit_toxic_degree');
        
        $toxic_degree = ToxicDegree::findOrFail($id); 
        $data = [
            'main' => $toxic_degree,
            'route' => 'toxic_degree',
        ];
        return view('general_part.edit', $data);
    }
    public function toxic_degree_update(Request $request, $id)
    {
        $this->authorize('edit_toxic_degree');
        
        $request->validate([
            'name' => 'required|string|max:255|unique:toxic_degrees,name,'.$id.',id',
        ]);
        
        try {
            $toxic_degree = ToxicDegree::findOrFail($id);
            $toxic_degree->update([
                'name' => $request->name,
            ]);
            
            return redirect()->route('admin.toxic_degree')->with('success', __('general.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Error updating toxic degree: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'toxic_degree_id' => $id,
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }
    public function toxic_degree_destroy($id)
    {
        $this->authorize('delete_toxic_degree');
        
        try {
            $toxic_degree = ToxicDegree::findOrFail($id);
            
            // Check if toxic degree is being used in samples
            if ($toxic_degree->isInUse()) {
                $usageCount = $toxic_degree->getUsageCount();
                return back()->withErrors([
                    'error' => __('general.cannot_delete_toxic_degree_in_use', ['count' => $usageCount])
                ])->with('error', __('general.cannot_delete_toxic_degree_in_use', ['count' => $usageCount]));
            }
            
            $toxic_degree->delete();
            
            return redirect()->route('admin.toxic_degree')->with('success', __('general.deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Error deleting toxic degree: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'toxic_degree_id' => $id
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')]);
        }
    }
    public function unit_index(Request $request)
    {
        $units = Unit::select('id', 'name' )->orderBy("created_at", "desc")->paginate(10);
        $data = [
            'main' => $units,
            'route' => 'unit',
        ];
        return view('general_part.index' , $data);
    }

    public function unit_create()
    {
        $this->authorize('create_unit');
        
        $data = [
            'route' => 'unit',
        ];
        return view('general_part.create' , $data);
    }

    public function unit_store(Request $request)
    {
        $this->authorize('create_unit');
        
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        try {
            $unit = Unit::create([
                'name' => $request->name,
            ]);
            
            return redirect()->route('admin.unit')->with('success', __('general.added_successfully'));
        } catch (\Exception $e) {
            Log::error('Error creating unit: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }
    public function unit_edit($id)
    {
        $this->authorize('edit_unit');
        
        $unit = Unit::findOrFail($id); 
        $data = [
            'main' => $unit,
            'route' => 'unit',
        ];
        return view('general_part.edit', $data);
    }
    public function unit_update(Request $request, $id)
    {
        $this->authorize('edit_unit');
        
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name,'.$id.',id',
        ]);
        
        try {
            $unit = Unit::findOrFail($id);
            $unit->update([
                'name' => $request->name,
            ]);
            
            return redirect()->route('admin.unit')->with('success', __('general.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Error updating unit: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'unit_id' => $id,
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }
    public function unit_destroy($id)
    {
        $this->authorize('delete_unit');
        
        try {
            $unit = Unit::findOrFail($id);
            
            // Check if unit is being used in test method items
            if ($unit->isInUse()) {
                $usageCount = $unit->test_method_items()->count();
                return back()->withErrors([
                    'error' => __('general.cannot_delete_unit_in_use', ['count' => $usageCount])
                ])->with('error', __('general.cannot_delete_unit_in_use', ['count' => $usageCount]));
            }
            
            $unit->delete();
            
            return redirect()->route('admin.unit')->with('success', __('general.deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Error deleting unit: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'unit_id' => $id
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')]);
        }
    }
    public function email_index(Request $request)
    {
        $emails = WebEmail::select('id', 'email' )->orderBy("created_at", "desc")->paginate(10);
        $data = [
            'main' => $emails,
            'route' => 'email',
        ];
        return view('general_part.index' , $data);
    }

    public function email_create()
    {
        $data = [
            'route' => 'email',
        ];
        return view('general_part.create' , $data);
    }

    public function email_store(Request $request)
    {
        $this->authorize('create_email');
        
        $request->validate([
            'name' => 'required|email|max:255|unique:web_emails,email',
        ], [
            'name.required' => __('general.email_required'),
            'name.email' => __('general.invalid_email_format'),
        ]);
        
        try {
            $email = WebEmail::create([
                'email' => $request->name,
            ]);
            
            return redirect()->route('admin.email')->with('success', __('general.added_successfully'));
        } catch (\Exception $e) {
            Log::error('Error creating email: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }
    public function email_edit($id)
    {
        $this->authorize('edit_email');
        
        $email = WebEmail::findOrFail($id); 
        $data = [
            'main' => $email,
            'route' => 'email',
        ];
        return view('general_part.edit', $data);
    }
    public function email_update(Request $request, $id)
    {
        $this->authorize('edit_email');
        
        $request->validate([
            'name' => 'required|email|max:255|unique:web_emails,email,'.$id.',id',
        ], [
            'name.required' => __('general.email_required'),
            'name.email' => __('general.invalid_email_format'),
        ]);
        
        try {
            $email = WebEmail::findOrFail($id);
            $email->update([
                'email' => $request->name,
            ]);
            
            return redirect()->route('admin.email')->with('success', __('general.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Error updating email: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'email_id' => $id,
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }
    public function email_destroy($id)
    {
        $this->authorize('delete_email');
        
        try {
            $email = WebEmail::findOrFail($id);
            $email->delete();
            
            return redirect()->route('admin.email')->with('success', __('general.deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Error deleting email: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'email_id' => $id
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')]);
        }
    }
    public function result_type_index(Request $request)
    {
        $result_types = ResultType::select('id', 'name' )->orderBy("created_at", "desc")->paginate(10);
        $data = [
            'main' => $result_types,
            'route' => 'result_type',
        ];
        return view('general_part.index' , $data);
    }

    public function result_type_create()
    {
        $data = [
            'route' => 'result_type',
        ];
        return view('general_part.create' , $data);
    }

    public function result_type_store(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $result_type = ResultType::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.result_type')->with('success', __('general.added_successfully'));
    }
    public function result_type_edit($id)
    {
        $result_type = ResultType::findOrFail($id); 
        $data = [
            'main' => $result_type,
            'route' => 'result_type',
        ];
        return view('general_part.edit', $data);
    }
    public function result_type_update(Request $request, $id)
    {
        $result_type = ResultType::findOrFail($id);
       
        $request->validate([
            'name' => 'required|string|max:255|unique:result_types,name,'.$id.',id',
        ]);
        $result_type->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.result_type')->with('success', __('general.updated_successfully'));
    }
    public function result_type_destroy($id)
    {
        $this->authorize('delete_result_type');
        
        try {
            $result_type = ResultType::findOrFail($id);
            
            // Check if result type is being used in test method items
            if ($result_type->isInUse()) {
                $usageCount = $result_type->test_method_items()->count();
                return back()->withErrors([
                    'error' => __('general.cannot_delete_result_type_in_use', ['count' => $usageCount])
                ])->with('error', __('general.cannot_delete_result_type_in_use', ['count' => $usageCount]));
            }
            
            $result_type->delete();
            
            return redirect()->route('admin.result_type')->with('success', __('general.deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Error deleting result type: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'result_type_id' => $id
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')]);
        }
    }
}
