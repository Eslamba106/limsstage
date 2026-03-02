<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\Client;
use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CertificateController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    
    public function index(Request $request)
    {
        $this->authorize('view_certificates');
        
        $query = Certificate::with(['result.sample.sample_plant', 'client', 'authorized_By']);
        
        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('coa_number', 'like', "%{$search}%")
                  ->orWhere('id', $search)
                  ->orWhereHas('result.sample.sample_plant', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Plant filter
        if ($request->has('plant_id') && $request->plant_id) {
            $query->whereHas('result.sample', function($q) use ($request) {
                $q->where('plant_id', $request->plant_id);
            });
        }
        
        // Client filter
        if ($request->has('client_id') && $request->client_id) {
            $query->where('client_id', $request->client_id);
        }
        
        // Date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('generated_Date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('generated_Date', '<=', $request->date_to);
        }
        
        // Status filter (from result)
        if ($request->has('status') && $request->status) {
            $query->whereHas('result', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        
        $certificates = $query->orderBy('created_at', 'desc')->paginate(15)->appends($request->query());
        
        $clients = Client::select('id', 'name')->get();
        $plants  = Plant::select('id', 'name')->whereNull('plant_id')->get();
        
        $data = [
            'certificates' => $certificates,
            'search'       => $request->search ?? '',
            'clients'      => $clients,
            'plants'       => $plants,
            'filters'      => array_merge(
                $request->only(['plant_id', 'client_id', 'date_from', 'date_to', 'status']),
                ['search' => $request->search ?? '']
            ),
        ];
        
        return view("part_three.certificates.certificate_list", $data);
    }
    
    /**
     * Send certificate via email
     */
    public function sendEmail(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        
        try {
            $certificate = Certificate::with(['result', 'client'])->findOrFail($id);
            
            // TODO: Implement email sending logic here
            // You can use Laravel Mail facade or a service
            
            return back()->with('success', translate('Certificate_sent_successfully'));
        } catch (\Exception $e) {
            Log::error('Error sending certificate email: ' . $e->getMessage());
            return back()->with('error', translate('something_went_wrong'));
        }
    }
    
    /**
     * Download certificate
     */
    public function download($id)
    {
        try {
            $certificate = Certificate::with(['result', 'certificate_items'])->findOrFail($id);
            
            // TODO: Implement PDF generation and download
            // You can use a library like dompdf or barryvdh/laravel-dompdf
            
            return back()->with('info', translate('Download_functionality_will_be_implemented'));
        } catch (\Exception $e) {
            Log::error('Error downloading certificate: ' . $e->getMessage());
            return back()->with('error', translate('something_went_wrong'));
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            "result_id" => "required|exists:results,id",
            "client_id" => "required|exists:clients,id",
        ]);
        
        try {
            $user = auth()->user();
            
            if (!$user) {
                return back()->withErrors(['error' => __('general.user_not_authenticated')])
                    ->withInput();
            }
            
            $certificate = Certificate::create([
                'result_id' => $request->result_id,
                'client_id' => $request->client_id,
                'authorized_id' => $user->id,
            ]);

            return redirect()->route('certificate.list')->with('success', translate('added_successfully'));
        } catch (\Exception $e) {
            Log::error('Error creating certificate: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }
    
}
