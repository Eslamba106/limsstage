<?php

namespace App\Http\Controllers;

use App\Events\CompanyCreated;
use App\Models\Order;
use App\Models\Schema;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentsController extends Controller
{
    /*public function form(Order $order)
    {
        return view('payments.form', [
            'order' => $order,
        ]);
    }*/

    // public function callback(Schema $schema)
    // { 
    //     $id = request()->query('id');

    //     $token = base64_encode(config('services.moyasar.secret') . ':');

    //     $payment = Http::baseUrl('https://api.moyasar.com/v1')

    //         ->withBasicAuth(config('services.moyasar.secret'), '')
    //         ->get("payments/{$id}")
    //         ->json();

    //     if (isset($payment['type']) && $payment['type'] == 'invalid_request_error') {
    //         return redirect()->route('landing-page')->with('error', $payment['message']);
    //     }

    //     if ($payment['status'] == 'paid') {
    //         $tenant = Tenant::where('id', request()->tenant_id)->first();
    //         $tenant->expire = now()->addMonth();
    //         $tenant->save();
    //         event(new CompanyCreated($tenant));
    //         $capture = Http::baseUrl('https://api.moyasar.com/v1')
    //             ->withHeaders([
    //                 'Authorization' => "Basic {$token}",
    //             ])
    //             ->post("payments/{$id}/capture")
    //             ->json();


    //              return redirect()->away("http://{$tenant->tenant_id}.limsstage.com")
    //                 ->with("success", __('general.added_successfully'));

    //     }

    // }

    // public function callback(Schema $schema)
    // {
    //     $id = request()->query('id');
    //     $tenant_id = request()->query('tenant_id');  

    //     if (!$id || !$tenant_id) {
    //         return redirect()->route('landing-page')->with('error', 'Invalid payment callback.');
    //     }

    //     $token = base64_encode(config('services.moyasar.secret') . ':');

    //     $payment = Http::baseUrl('https://api.moyasar.com/v1')
    //         ->withBasicAuth(config('services.moyasar.secret'), '')
    //         ->get("payments/{$id}")
    //         ->json();

    //     if (isset($payment['type']) && $payment['type'] == 'invalid_request_error') {
    //         return redirect()->route('landing-page')->with('error', $payment['message']);
    //     }

    //     if ($payment['status'] == 'paid') {
    //         $tenant = Tenant::find($tenant_id);

    //         if (!$tenant) {
    //             return redirect()->route('landing-page')->with('error', 'Tenant not found.');
    //         }

    //         $tenant->expire = now()->addMonth();
    //         $tenant->save();

    //         event(new CompanyCreated($tenant));

    //         $capture = Http::baseUrl('https://api.moyasar.com/v1')
    //             ->withBasicAuth(config('services.moyasar.secret'), '')
    //             ->post("payments/{$id}/capture")
    //             ->json(); 
    //         return redirect()->away("http://{$tenant->tenant_id}.limsstage.com")
    //             ->with("success", __('general.added_successfully'));
    //     }

    //     return redirect()->away("https://limsstage.com")->with('error', 'Payment not completed.');
    // }
    public function callback(Schema $schema)
    {
        $tenant_id = request()->query('tenant_id');
        $payment_id = request()->query('id');

        if (!$tenant_id || !$payment_id) {
            return redirect()->route('landing-page')->with('error', 'Invalid payment callback.');
        }

        $tenant = Tenant::find($tenant_id);

        if (!$tenant) {
            return redirect()->route('landing-page')->with('error', 'Tenant not found.');
        }

        $token = base64_encode(config('services.moyasar.secret') . ':');

        $payment = Http::baseUrl('https://api.moyasar.com/v1')
            ->withBasicAuth(config('services.moyasar.secret'), '')
            ->get("payments/{$payment_id}")
            ->json();

        if (isset($payment['type']) && $payment['type'] == 'invalid_request_error') {
            return redirect()->route('landing-page')->with('error', $payment['message']);
        }

        if ($payment['status'] === 'paid') {
            $tenant->expire = now()->addMonth();
            $tenant->save();

            event(new CompanyCreated($tenant));

            // Capture الدفع
            $capture = Http::baseUrl('https://api.moyasar.com/v1')
                ->withBasicAuth(config('services.moyasar.secret'), '')
                ->post("payments/{$payment_id}/capture")
                ->json();

            return redirect()->away("http://{$tenant->tenant_id}.limsstage.com")
                ->with("success", __('general.added_successfully'));
        }

        return redirect()->away("https://limsstage.com")->with('error', 'Payment not completed.');;
    }
}
