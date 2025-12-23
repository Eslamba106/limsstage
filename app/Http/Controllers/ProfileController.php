<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function view()
    {
        $data = User::where('id', auth()->id())->first();
        return view('user-views.profile.view', compact('data'));
    }

    public function edit($id)
    {
        if (auth()->id() != $id) {
            Toastr::warning(translate('you_can_not_change_others_profile'));
            return back();
        }
        $data = User::where('id', auth()->id())->first();

        return view('user-views.profile.edit', compact('data', ));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'user_name' => 'required',
            'slug'      => 'required|unique:users,slug,' . $id . ',id',
        ], [
            'name.required'  => 'name is required!',
            'email.required' => 'email is required!',
            'phone.required' => 'Phone number is required!',
        ]);
        $signature_image = null;

        $user            = User::find(auth()->id());
        $old_slug        = $user->slug;
        $user->name      = $request->name;
        $user->email     = $request->email;
        $user->phone     = $request->phone;
        $user->slug      = $request->slug;
        $user->user_name = $request->user_name;
        if ($request->filled('signature')) {
            $signatureData = $request->input('signature');

            list($type, $data) = explode(';', $signatureData);
            list(, $data)      = explode(',', $data);
            $data              = base64_decode($data);

            $signaturePath = main_path() . 'signature';

            if (! file_exists($signaturePath)) {
                mkdir($signaturePath, 0777, true);
            }

            if (! empty($user->signature) && file_exists($signaturePath . '/' . $user->signature)) {
                unlink($signaturePath . '/' . $user->signature);
            }
            $imageNameSignature = uniqid('sign_') . '.png';
            file_put_contents($signaturePath . '/' . $imageNameSignature, $data);

            $user->update(['signature' => $imageNameSignature]);
        }

        //    if ($request->hasFile('signature')) {
        //     dd("fsfg");
        //             $signaturePath = main_path('signature/' . $request->name);
        //             if (! empty($user->signature) && file_exists($signaturePath . '/' . $user->signature)) {
        //                 unlink($signaturePath . '/' . $user->signature);
        //             }
        //             $signature          = $request->file('signature');
        //             $signature_image    = $signature->getClientOriginalName();
        //             $imageNameSignature = $signature_image;
        //             if (! file_exists($signaturePath)) {
        //                 mkdir($signaturePath, 0777, true);
        //             }
        //             $signature->move($signaturePath, $imageNameSignature);
        //             $user->update(['signature' => $imageNameSignature]);
        //         }
        $user->save();

        Toastr::info(translate('Profile_updated_successfully'));
        // if ($old_slug != $request->slug) {
        //     $newDomain = $request->getScheme() . '://' . $request->slug . '.' . str_replace('www.', '', parse_url(config('app.url'), PHP_URL_HOST)).'/ecommerce';

        //     return redirect()->away($newDomain);
        // }
        return back();
    }

    public function settings_password_update(Request $request)
    {
        $request->validate([
            'password'         => 'required|same:confirm_password|min:5',
            'confirm_password' => 'required',
        ]);

        $user           = User::find(auth('user')->id());
        $user->password = bcrypt($request['password']);
        $user->save();
        Toastr::success(translate('User_password_updated_successfully'));
        return back();
    }

    public function bank_update(Request $request, $id)
    {
        $bank              = User::find(auth('user')->id());
        $bank->bank_name   = $request->bank_name;
        $bank->branch      = $request->branch;
        $bank->holder_name = $request->holder_name;
        $bank->account_no  = $request->account_no;
        $bank->save();
        Toastr::success(translate('Bank_Info_updated'));
        return redirect()->route('user.profile.view');
    }

    public function bank_edit($id)
    {
        if (auth('user')->id() != $id) {
            Toastr::warning(translate('you_can_not_change_others_info'));
            return back();
        }
        $data = User::where('id', auth('user')->id())->first();
        return view('user-views.profile.bankEdit', compact('data'));
    }

}
