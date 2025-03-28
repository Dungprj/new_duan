<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        View::composer('layout.master', function ($view) {
            $blogs = Blog::all()->map(function ($blog) {
                $blog->thumbnail = url('storage/' . $blog->thumbnail); // Thêm đường dẫn ảnh đầy đủ
                return $blog;
            });

            $view->with([
                'blogs' => $blogs,
                'categories' => Category::all(),
            ]);
        });

    }
}
