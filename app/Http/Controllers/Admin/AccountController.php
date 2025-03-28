<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = User::orderBy('id', 'desc')->paginate(8);

        // $user = User::where('id', '1')->first();


        // dd($user->getRoleNames());

        return view('pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $roles  = Role::all();

        return view('pages.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6', // Đảm bảo mật khẩu có ít nhất 6 ký tự
            'role' => 'required'

        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.min' => 'Tên phải có ít nhất 3 ký tự.',

            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',


            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',

            'role.required' => 'Vai trò là bắt buộc.',
        ]);


        $user = new User();

        $user->name =  $request->name;
        $user->email =  $request->email;
        $user->password =  bcrypt($request->password);
        $user->status =  "active";




        $user->assignRole($request->role);

        $user->save();

        // Hiển thị thông báo thành công với SweetAlert2
        Alert::success('Tài khoản đã được thêm thành công!');

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function status(string $id, $param)
    {
        $user = User::findOrFail($id);

        if ($param === "check") {
            $user->update([
                'status' => "inactive"
            ]);
        } else {
            $user->update([
                'status' => "active"
            ]);
        }


        // Hiển thị thông báo thành công với SweetAlert2
        Alert::success('Trạng thái đã thay đổi thành công!');
        return redirect()->back();
    }

    public function show(string $id)
    {
        return view('404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $roles  = Role::all();
        $user = User::findOrFail($id);
        return view('pages.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id)
            ],
            'password' => 'nullable|min:6', // Đảm bảo mật khẩu có ít nhất 6 ký tự
            'role' => 'required'

        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.min' => 'Tên phải có ít nhất 3 ký tự.',

            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',


            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',

            'role.required' => 'Vai trò là bắt buộc.',


        ]);

        $user = User::findOrFail($id);


        if (!empty($request->password)) {



            $user->name =  $request->name;
            $user->email =  $request->email;
            $user->password =  bcrypt($request->password);
            $user->status =  "active";
        } else {
            $user->name =  $request->name;
            $user->email =  $request->email;
        }


        $user->syncRoles($request->role);

        $user->save();

        // Hiển thị thông báo thành công với SweetAlert2
        Alert::success('Tài khoản đã cập nhật thành công!');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        // Hiển thị thông báo thành công với SweetAlert2
        Alert::success('Tài khoản đã được xoá thành công!');
        return redirect()->back();
    }
}
