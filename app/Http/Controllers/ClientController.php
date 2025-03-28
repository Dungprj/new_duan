<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function home()
    {
        $categories = Category::where('status', 'active')->get();
        $blog_views = Blog::where('status', 'active')
            ->orderBy('views', 'desc')
            ->limit(10)
            ->get();

        $background_blogs = Blog::where('status', 'active')->orderBy('id', 'desc')->limit(4)->get();


        //! take(PHP_INT_MAX) đảm bảo lấy hết các bài viết còn lại sau khi bỏ qua bài đầu tiên.
        // $blogs = Blog::where('status', 'active')->orderBy('id', 'desc')->skip(4)->take(PHP_INT_MAX)->get();

        $blogs = Blog::where('status', 'active')->orderBy('id', 'desc')->get();


        return view('pages.home', compact('categories', 'blogs', 'blog_views', 'background_blogs'));
    }

    public function introduce()
    {
        return view('pages.introduce');
    }

    public function support()
    {
        return view('pages.support');
    }

    public function category($slug)
    {
        // dd($slug);
        $categories = Category::where('status', 'active')->get();

        $category_title = Category::where('slug', $slug)->first();



        $blog_views = Blog::where('status', 'active')
            ->where('category_id', $category_title->id)
            ->orderBy('views', 'desc')
            ->limit(10)
            ->get();

        $background_blogs = Blog::where('status', 'active')->orderBy('id', 'desc')->limit(4)->get();

        $blogs = Blog::where('status', 'active')->where('category_id', $category_title->id)->get();

        return view('pages.category', compact('categories', 'category_title', 'blogs', 'blog_views', 'background_blogs'));
    }




    public function detail($category_slug, $blog_slug)
    {

        $categories = Category::where('status', 'active')->get();
        $blog = Blog::where('slug', $blog_slug)->first();


        $categories_blog = Category::where('status', 'active')->where('slug', $category_slug)->first();
        $related_blogs = Blog::where('status', 'active')->where('category_id', $categories_blog->id)->where('slug', '!=', $blog_slug)->inRandomOrder()->limit(8)->get();


        $blog->increment('views'); // Tăng lượt xem


        return view('pages.detail', compact('categories', 'blog', 'related_blogs', 'categories_blog'));
    }
}
