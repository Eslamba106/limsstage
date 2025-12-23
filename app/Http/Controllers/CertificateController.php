<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\Client;
use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
           $ids         = $request->bulk_ids;
        $search      = $request['search'];
        $query_param = $search ? ['search' => $request['search']] : '';
        $certificates     = Certificate::when($request['search'], function ($q) use ($request) {
            $key = explode(' ', $request['search']);
            foreach ($key as $value) {
                $q->Where('certificate_no', 'like', "%{$value}%")
                    ->orWhere('id', $value);
            }
        }) 
            ->latest()->orderBy('created_at', 'asc')->paginate()->appends($query_param);
        // if ($request->bulk_action_btn === 'filter') {
        //     $data         = ['status' => 1];
        //     $report_query = Certificate::query();
        //     if ($request->sample_name && ! is_null($request->sample_name)) {
        //         $report_query->whereHas('plant_sample', function ($q) use ($request) {
        //             $q->where('name', 'LIKE', '%' . $request->sample_name . '%');
        //         });
        //     }
        //     if ($request->sample_id && ! is_null($request->sample_id)) {
        //         $report_query->where('submission_number', $request->sample_id);
        //     }
        //     if ($request->plant_id && ! is_null($request->plant_id)) {
        //         $report_query->where('plant_id', $request->plant_id);
        //     }
        //     if ($request->collection_date && ! is_null($request->collection_date)) {
        //         $report_query->whereDate('sampling_date_and_time', $request->collection_date);
        //     }
        //     if ($request->priority && ! is_null($request->priority)) {
        //         $report_query->where('priority', $request->priority);
        //     }

        //     $certificates = $report_query->where('status', 'pending')->orderBy('created_at', 'desc')->paginate();
        // }
        $clients = Client::select('id', 'name')->get();
        $plants  = Plant::select('id', 'name')->get();
        $data    = [
            'certificates' => $certificates,
            'search'  => $search,
            'clients' => $clients,
            'plants'  => $plants,
        ];
        return view("part_three.certificates.certificate_list", $data);
    }
    public function store(Request $request)
    { 
        $request->validate([
                "result_id" => "required",
                "client_id" => "required",
        ]);
        $certificate = new Certificate();
        $certificate->result_id = $request->result_id;
        $certificate->authorized_id = auth()->user()->id;
        

        return redirect()->route('certificate.list')->with('success', translate('added_successfully'));

    }
    
}
