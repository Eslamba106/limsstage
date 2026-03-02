<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function view()
    {
        try {
            $userId = auth()->id();
            if (!$userId) {
                return redirect()->route('login')->with('error', translate('please_login_first'));
            }
            
            $data = User::where('id', $userId)->first();
            if (!$data) {
                return redirect()->route('login')->with('error', translate('user_not_found'));
            }
            
            return view('user-views.profile.view', compact('data'));
        } catch (\Exception $e) {
            Log::error('Error loading profile view: ' . $e->getMessage());
            return back()->with('error', translate('something_went_wrong'));
        }
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
        try {
            $userId = auth()->id();
            if (!$userId || $userId != $id) {
                Toastr::warning(translate('you_can_not_change_others_profile'));
                return back();
            }

            $request->validate([
                'name'      => 'required|string|max:255',
                'email'     => 'required|email|max:255|unique:users,email,' . $id . ',id',
                'phone'     => 'required|string|max:20',
                'user_name' => 'required|string|max:255',
                'slug'      => 'required|string|max:255|unique:users,slug,' . $id . ',id',
            ], [
                'name.required'  => 'name is required!',
                'email.required' => 'email is required!',
                'email.email'    => 'email must be valid!',
                'phone.required' => 'Phone number is required!',
            ]);

            $user = User::find($userId);
            if (!$user) {
                Toastr::error(translate('user_not_found'));
                return back();
            }

            $old_slug        = $user->slug;
            $user->name      = $request->name;
            $user->email     = $request->email;
            $user->phone     = $request->phone;
            $user->slug      = $request->slug;
            $user->user_name = $request->user_name;
            
            if ($request->filled('signature')) {
                $signatureData = $request->input('signature');
                
                if (strpos($signatureData, ';') !== false && strpos($signatureData, ',') !== false) {
                    list($type, $data) = explode(';', $signatureData);
                    list(, $data)      = explode(',', $data);
                    $data              = base64_decode($data);

                    $signaturePath = main_path() . 'signature';

                    if (! file_exists($signaturePath)) {
                        mkdir($signaturePath, 0777, true);
                    }

                    if (! empty($user->signature) && file_exists($signaturePath . '/' . $user->signature)) {
                        @unlink($signaturePath . '/' . $user->signature);
                    }
                    $imageNameSignature = uniqid('sign_') . '.png';
                    file_put_contents($signaturePath . '/' . $imageNameSignature, $data);

                    $user->signature = $imageNameSignature;
                }
            }

            $user->save();

            Toastr::info(translate('Profile_updated_successfully'));
            return back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);
            Toastr::error(translate('something_went_wrong'));
            return back()->withInput();
        }
    }

    public function settings_password_update(Request $request)
    {
        try {
            $request->validate([
                'password'         => 'required|same:confirm_password|min:5',
                'confirm_password' => 'required',
            ]);

            $userId = auth('user')->id();
            if (!$userId) {
                Toastr::error(translate('please_login_first'));
                return back();
            }

            $user = User::find($userId);
            if (!$user) {
                Toastr::error(translate('user_not_found'));
                return back();
            }

            $user->password = bcrypt($request['password']);
            $user->save();
            
            Toastr::success(translate('User_password_updated_successfully'));
            return back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating password: ' . $e->getMessage());
            Toastr::error(translate('something_went_wrong'));
            return back();
        }
    }

    public function bank_update(Request $request, $id)
    {
        try {
            $userId = auth('user')->id();
            if (!$userId || $userId != $id) {
                Toastr::warning(translate('you_can_not_change_others_info'));
                return back();
            }

            $request->validate([
                'bank_name'   => 'nullable|string|max:255',
                'branch'      => 'nullable|string|max:255',
                'holder_name' => 'nullable|string|max:255',
                'account_no'  => 'nullable|string|max:255',
            ]);

            $bank = User::find($userId);
            if (!$bank) {
                Toastr::error(translate('user_not_found'));
                return back();
            }

            $bank->bank_name   = $request->bank_name;
            $bank->branch      = $request->branch;
            $bank->holder_name = $request->holder_name;
            $bank->account_no  = $request->account_no;
            $bank->save();
            
            Toastr::success(translate('Bank_Info_updated'));
            return redirect()->route('user.profile.view');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating bank info: ' . $e->getMessage());
            Toastr::error(translate('something_went_wrong'));
            return back()->withInput();
        }
    }

    public function bank_edit($id)
    {
        try {
            $userId = auth('user')->id();
            if (!$userId || $userId != $id) {
                Toastr::warning(translate('you_can_not_change_others_info'));
                return back();
            }
            
            $data = User::where('id', $userId)->first();
            if (!$data) {
                Toastr::error(translate('user_not_found'));
                return back();
            }
            
            return view('user-views.profile.bankEdit', compact('data'));
        } catch (\Exception $e) {
            Log::error('Error loading bank edit: ' . $e->getMessage());
            Toastr::error(translate('something_went_wrong'));
            return back();
        }
    }

}
