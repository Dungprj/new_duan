<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function login()
    {
        return view('login');
    }
    // Xử lý đăng nhập
    public function logined(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',  // Kiểm tra email có hợp lệ hay không
            'password' => 'required|min:2', // Kiểm tra password có tối thiểu 6 ký tự
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        // Lấy thông tin đăng nhập
        $credentials = $request->only('email', 'password');

        // Thực hiện xác thực người dùng
        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->status === 'inactive') {
                Auth::logout();
                // Hiển thị thông báo thành công với SweetAlert2
                Alert::warning('Tài khoản không hoạt động.');
                return redirect()->back();
            }


            $request->session()->regenerate(); // Tạo lại session ID để tăng bảo mật

            // Chuyển hướng người dùng theo vai trò của họ
            return $user->redirect_roles();
        } else {

            // Hiển thị thông báo thành công với SweetAlert2
            Alert::warning('Thông tin đăng nhập không chính xác.');
            return redirect()->back();
        }

    }



    public function register()
    {
        return view('register');
    }

    public function registered(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6', // Đảm bảo mật khẩu có ít nhất 6 ký tự
            'confirm_password' => 'required_with:password|same:password', // Xác nhận mật khẩu phải trùng với mật khẩu
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.min' => 'Tên phải có ít nhất 3 ký tự.',

            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',


            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',

            'confirm_password.required_with' => 'Vui lòng xác nhận mật khẩu.',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp.',
        ]);


        $user = new User();

        $user->name =  $request->name;
        $user->email =  $request->email;
        $user->password =  bcrypt($request->password);
        $user->status =  "active";



        $user->syncRoles('Guest');



        $user->save();

        // Hiển thị thông báo thành công với SweetAlert2
        Alert::success('Đăng ký tài khoản thành công.');
        return redirect()->route('login');
    }





    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate(); // Hủy session hiện tại
        $request->session()->regenerateToken(); // Tạo lại CSRF token  / Giúp tránh bị đánh cắp session cũ

        return redirect()->route('home');
    }
}
