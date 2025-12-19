<?php

namespace App\Http\Controllers\part;

use App\Models\WebEmail;
use App\Models\part\Unit;
use Illuminate\Http\Request;
use App\Models\part\ResultType;
use App\Models\part\ToxicDegree;
use App\Http\Controllers\Controller;
use App\Models\second_part\Frequency;

class GeneralController extends Controller
{
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
        $data = [
            'route' => 'frequency',
        ];
        return view('general_part.create' , $data);
    }

    public function frequency_store(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $frequency = Frequency::create([
            'name' => $request->name,
            'time_by_hours' => $request->time_by_hours,
        ]);
        return redirect()->route('admin.frequency')->with('success', __('general.added_successfully'));
    }
    public function frequency_edit($id)
    {
        $frequency = Frequency::findOrFail($id); 
        $data = [
            'main' => $frequency,
            'route' => 'frequency',
        ];
        return view('general_part.edit', $data);
    }
    public function frequency_update(Request $request, $id)
    {
        $frequency = Frequency::findOrFail($id);
       
        $request->validate([
            'name' => 'required|string|max:255|unique:frequencies,name,'.$id.',id',
        ]);
        $frequency->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.frequency')->with('success', __('general.updated_successfully'));
    }
    public function frequency_destroy($id)
    {
        $frequency = Frequency::findOrFail($id);
        $frequency->delete();
        return redirect()->route('admin.frequency')->with('success', __('general.deleted_successfully'));
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
        $data = [
            'route' => 'toxic_degree',
        ];
        return view('general_part.create' , $data);
    }

    public function toxic_degree_store(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $toxic_degree = ToxicDegree::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.toxic_degree')->with('success', __('general.added_successfully'));
    }
    public function toxic_degree_edit($id)
    {
        $toxic_degree = ToxicDegree::findOrFail($id); 
        $data = [
            'main' => $toxic_degree,
            'route' => 'toxic_degree',
        ];
        return view('general_part.edit', $data);
    }
    public function toxic_degree_update(Request $request, $id)
    {
        $toxic_degree = ToxicDegree::findOrFail($id);
       
        $request->validate([
            'name' => 'required|string|max:255|unique:toxic_degrees,name,'.$id.',id',
        ]);
        $toxic_degree->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.toxic_degree')->with('success', __('general.updated_successfully'));
    }
    public function toxic_degree_destroy($id)
    {
        $toxic_degree = ToxicDegree::findOrFail($id);
        $toxic_degree->delete();
        return redirect()->route('admin.toxic_degree')->with('success', __('general.deleted_successfully'));
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
        $data = [
            'route' => 'unit',
        ];
        return view('general_part.create' , $data);
    }

    public function unit_store(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $unit = Unit::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.unit')->with('success', __('general.added_successfully'));
    }
    public function unit_edit($id)
    {
        $unit = Unit::findOrFail($id); 
        $data = [
            'main' => $unit,
            'route' => 'unit',
        ];
        return view('general_part.edit', $data);
    }
    public function unit_update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);
       
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name,'.$id.',id',
        ]);
        $unit->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.unit')->with('success', __('general.updated_successfully'));
    }
    public function unit_destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();
        return redirect()->route('admin.unit')->with('success', __('general.deleted_successfully'));
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $email = WebEmail::create([
            'email' => $request->name,
        ]);
        return redirect()->route('admin.email')->with('success', __('general.added_successfully'));
    }
    public function email_edit($id)
    {
        $email = WebEmail::findOrFail($id); 
        $data = [
            'main' => $email,
            'route' => 'email',
        ];
        return view('general_part.edit', $data);
    }
    public function email_update(Request $request, $id)
    {
        $email = WebEmail::findOrFail($id);
       
        $request->validate([
            'name' => 'required|string|max:255|unique:emails,name,'.$id.',id',
        ]);
        $email->update([
            'email' => $request->name,
        ]);
        return redirect()->route('admin.email')->with('success', __('general.updated_successfully'));
    }
    public function email_destroy($id)
    {
        $email = WebEmail::findOrFail($id);
        $email->delete();
        return redirect()->route('admin.email')->with('success', __('general.deleted_successfully'));
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
        $result_type = ResultType::findOrFail($id);
        $result_type->delete();
        return redirect()->route('admin.result_type')->with('success', __('general.deleted_successfully'));
    }
}
