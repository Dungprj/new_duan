<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     *
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];






    // Phương thức chuyển hướng theo vai trò người dùng
    public function redirect_roles()
    {
        // Kiểm tra vai trò và chuyển hướng
        if ($this->roles === "admin") {
            return redirect()->route('users.index');
        }

        if ($this->roles === "author") {
            return redirect()->route('blogs.index');
        }

        // Nếu không phải admin hay author, chuyển về trang chủ
        return redirect()->route('home');
    }



}
