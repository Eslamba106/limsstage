<?php
namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

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
            'name' =>'required',
            'phone' =>'required',
            'email' =>'required',
        ]);
        $client        = new Client();
        $client->name  = $request->name;
        $client->phone = $request->phone;
        $client->email  = $request->email; 
        $client->save();
        return redirect()->route('client.list')->with('success', translate('client_added_successfully'));

    }
    public function update(Request $request)
    {
          $request->validate([
            'name' =>'required',
            'phone' =>'required',
            'email' =>'required',
        ]);
        $client        = Client::findOrFail($request->id);
        $client->name  = $request->name;
        $client->phone = $request->phone;
        $client->email  = $request->email; 
        $client->save();
        return redirect()->route('client.list')->with('success', translate('client_updated_successfully'));
    }
     public function  delete( $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('client.list')->with('success', translate('client_deleted_successfully'));
    }
}
