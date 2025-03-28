<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected  $guarded = [];




    // $blog->formatted_time gọi được vì Laravel tự động ánh xạ nó tới getFormattedTimeAttribute() thông qua cơ chế accessor.
    // Đây là thiết kế của Eloquent để tăng tính tiện lợi và dễ đọc.
    public function getFormattedTimeAttribute()
    {
        $createdAt = Carbon::parse($this->created_at);
        $now = Carbon::now();
        $diffInMinutes = $createdAt->diffInMinutes($now);
        $diffInHours = $createdAt->diffInHours($now);
        $diffInSeconds = $createdAt->diffInSeconds($now);

        if ($diffInHours >= 24) {
            return $createdAt->format('d-m-Y');
        } elseif ($diffInHours >= 1) {
            return $diffInHours . ' giờ trước';
        } elseif ($diffInMinutes >= 1) {
            return $diffInMinutes . ' phút trước';
        } else {
            return $diffInSeconds . ' giây trước';
        }
    }

    public function getFormattedViewsAttribute()
    {
        $views = $this->views;
        if ($views >= 1000000000) {
            return number_format($views / 1000000000, 1) . 'B';
        } elseif ($views >= 1000000) {
            return number_format($views / 1000000, 1) . 'M';
        } elseif ($views >= 1000) {
            return number_format($views / 1000, 1) . 'K';
        }
        return $views;
    }
}
