<?php
namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }
    public function create()
    {
        return view('clients.create');
    }
    public function edit($id)
    {
        $client = Client::findOrFail($id);

        return view('clients.edit', compact('client'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:clients,email',
        ]);
        
        try {
            $client = Client::create([
                'name'  => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
            
            return redirect()->route('client.list')->with('success', translate('client_added_successfully'));
        } catch (\Exception $e) {
            Log::error('Error creating client: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token', 'password'])
            ]);
            
            return back()->withErrors(['error' => translate('something_went_wrong')])
                ->withInput();
        }
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'id'    => 'required|exists:clients,id',
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:clients,email,' . $request->id,
        ]);
        
        try {
            $client = Client::findOrFail($request->id);
            $client->update([
                'name'  => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
            
            return redirect()->route('client.list')->with('success', translate('client_updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Error updating client: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'client_id' => $request->id,
                'request' => $request->except(['_token', 'password'])
            ]);
            
            return back()->withErrors(['error' => translate('something_went_wrong')])
                ->withInput();
        }
    }
    public function delete($id)
    {
        try {
            $client = Client::findOrFail($id);
            $client->delete();
            
            return redirect()->route('client.list')->with('success', translate('client_deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Error deleting client: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'client_id' => $id
            ]);
            
            return back()->withErrors(['error' => translate('something_went_wrong')]);
        }
    }
}
