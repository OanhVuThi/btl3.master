<?php

namespace App\Http\Controllers;
use App\User;
use App\Depot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\UserEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Exports\UserExport;
use Excel;
use Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;



class UserController extends Controller
{
    protected $model;
    public function __construct(User $user)
    {
        $this->middleware('checkrole')->except('index');
        $this->middleware('checkMK');       
        $this->model = $user;
    }
    public function index()
    {
        $data['users'] = $this->model->getUsers();
        unset($data['users'][0]);
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['depots'] = Depot::all();
        return view('admin.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
        ], [
            'name.required' => 'Vui lòng nhập Họ Tên',
            'email.required' => 'Vui lòng nhập Email',
            'email.email' => 'Không đúng định dạng Email',
            'email.unique' => 'Email này đã trùng vui lòng chọn Email khác',
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            // dd($request->all());
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt(123456789),
                'remember_token' => Str::random(10),
            ]);
            Mail::to($user->email)->send(new UserEmail($user));
            $user->save();
            return redirect()->route('admin.user.index')->with('message', "Thêm nhân viên $user->name thành công");
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $data['user'] = User::find($id);
        $data['depots'] = Depot::all();
        if ($data['user'] !== null) {
            return view('admin.user.show', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function editUser(Request $request)
    {
        return $this->model->getUpdate($request->user_id, $request->name);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|unique:users,name',
        ], [
            'name.required' => 'Vui lòng nhập Họ Tên',

        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $user = User::find($id);
            if ($user !== null) {
                $user->name = $request->name;
                $user->save();
                return redirect()->route('admin.user.index')->with('message', "Sửa nhân viên $user->name thành công");
            }
        
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {       
        $user = User::find($id);
        if ($user !== null) {
            $user->delete();
            return redirect()->route('admin.user.index')->with('message', "Xóa người dùng $user->name thành công");
        }
        return redirect()->route('admin.user.index')->with('error', 'Không tìm thấy người dùng này');
    }
    public function export()
    {       
        return Excel::download(new UserExport(), 'users.xls');
    }
}
