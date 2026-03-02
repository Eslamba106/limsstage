<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConversationRequest;
use Illuminate\Support\Facades\Log;

class ConversationRequestController extends Controller
{

        public function list(Request $request){
         $ids = $request->bulk_ids; 
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status]; 
          
            ConversationRequest::whereIn('id', $ids)->update($data);
            return back()->with('success', translate('updated_successfully'));
        }  
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) { 
            ConversationRequest::whereIn('id', $ids)->delete();
            return back()->with('success', translate('deleted_successfully'));
        }

        $conversation_requests = ConversationRequest::orderBy("created_at","desc")->paginate(10);
        return view("admin.conversation-requests.list", compact("conversation_requests"  ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        try {
            ConversationRequest::create($request->all());

            return redirect()->back()->with('success', translate('Your message has been sent successfully!'));
        } catch (\Exception $e) {
            Log::error('Error storing conversation request: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => translate('something_went_wrong')])
                ->withInput();
        }
    }

    public function delete($id)
    {
        try {
            $conversation_request = ConversationRequest::findOrFail($id);
            $conversation_request->delete();

            return redirect()->back()->with('success', translate('Conversation request deleted successfully!'));
        } catch (\Exception $e) {
            Log::error('Error deleting conversation request: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'conversation_request_id' => $id
            ]);

            return back()->withErrors(['error' => translate('something_went_wrong')]);
        }
    }
}
