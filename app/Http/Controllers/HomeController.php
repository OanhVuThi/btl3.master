<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\User;
use Mail;
use App\Mail\PassEmail;


class HomeController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('checkrole')->except('index','export');
        $this->middleware('checkMK');
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return view('admin.master');
    }
    
      public function resetPassword(Request $request)
    {
        if ($request->reset) {
        foreach ($request->reset as $id) {
            $result = $this->userRepository->find($id);
            if ($result) {
                $pass = str_random(8);
                $pass1 = ['password' => bcrypt($pass)];
                $result->update($pass1);
                \Mail::to($result->email)->send(new PassEmail($pass));
            }
        }
         return redirect()->route('admin.user.index')->with('message', 'Reset mật khẩu người dùng thành công');
    }   else {
            return redirect()->route('admin.user.index')->with('error', 'Chưa chọn tài khoản reset');
        }
    }
}
