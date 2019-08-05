<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class checkMkController extends Controller
{
     public function admin_credential_rules(array $data)
    {
        $messages = [
            'current_password.required' => 'Nhập mật khẩu hiện tại',
            'password.required' => 'Nhập mật khẩu mới',
        ];

        $validator = Validator::make($data, [
            'current_password' => 'required',
            'password' => 'required|same:password',
            'password_confirmation' => 'required|same:password',
        ], $messages);

        return $validator;
    }

    public function postCredentials(Request $request)
    {
        if (Auth::check()) {
            $request_data = $request->all();
            $validator = $this->admin_credential_rules($request_data);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                $current_password = Auth::user()->password;
                if (Hash::check($request->current_password, $current_password)) {
                    $user_id = Auth::user()->id;
                    $objUser = User::find($user_id);
                    $objUser->password = Hash::make($request->password);
                    $objUser->active = 1;
                    $objUser->save();
                    return redirect()->route('admin.user.index');
                } else {
                    return redirect()->back()->with('error', 'Nhập mật khẩu hiện tại');
                }
            }
        } else {
            return redirect()->to('/');
        }
    }
}
