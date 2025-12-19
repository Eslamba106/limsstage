<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConversationRequest;

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

         ConversationRequest::create($request->all());

        return redirect()->back()->with('success', translate('Your message has been sent successfully!'));
    }

    public function delete($id)
    {
        $conversation_request = ConversationRequest::findOrFail($id);
        $conversation_request->delete();

        return redirect()->back()->with('success', translate('Conversation request deleted successfully!'));
    }
}
