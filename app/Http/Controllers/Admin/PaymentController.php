<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function list(Request $request)
    {
                $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];

            Payment::whereIn('id', $ids)->update($data);
            return back()->with('success', translate('updated_successfully'));
        }
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {
            Payment::whereIn('id', $ids)->delete();
            return back()->with('success', translate('deleted_successfully'));
        }

        $payments = Payment::orderBy("created_at", "desc")->with('tenant:id,name')->paginate(10);
        $data = [
            'payments' => $payments,
        ];
        return view("admin.payments.list", $data); 
    }
}
