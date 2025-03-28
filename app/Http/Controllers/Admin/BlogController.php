<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class BlogController extends Controller
{


    public function index()
    {
        $categories = Category::where('status', 'active')->get();

        // Lấy danh sách ID của Bài viết có status 'no'
        $no_category_ids = Category::where('status', 'inactive')->pluck('id')->toArray();

        // Nếu có danh mục cần vô hiệu hóa bài viết
        if (!empty($no_category_ids)) {
            foreach ($no_category_ids as $item) {
                $blogs_temp = Blog::where('category_id', $item)->first();
                if ($blogs_temp) { // Kiểm tra nếu có bài viết
                    $blogs_temp->update([
                        'status' => 'inactive',
                    ]);
                }
            }
        }

        if (auth()->user()->hasRole('Admin')) {
            // Lấy danh sách blog, loại trừ các danh mục có status 'no'
            $blogs = Blog::whereNotIn('category_id', $no_category_ids)
                ->orderBy('id', 'desc')
                ->get();
            $users = User::all();

            return view('pages.blogs.index', compact('categories', 'blogs', 'users'));
        }

        // Nếu không phải Admin, chỉ lấy bài viết của user hiện tại
        $blogs = Blog::where('user_id', Auth::id())->orderBy('id', 'desc')->get();

        return view('pages.blogs.index', compact('categories', 'blogs'));
    }


    public function create()
    {
        // dd("Đây là blogs");
        $categories = Category::where('status', 'active')->get();
        return view('pages.blogs.create', compact('categories'));
    }


    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'category_id' => 'required|exists:categories,id', // Kiểm tra category_id tồn tại trong bảng categories
            'title' => 'required|string|max:255|min:3', // Bắt buộc, tối đa 255 ký tự
            'description' => 'required|string', // Không bắt buộc
            'content' => 'required|string', // Không bắt buộc
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // File ảnh, tối đa 2MB
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // File ảnh, tối đa 2MB
            // 'status' => 'nullable|in:inactive,active', // Bắt buộc, chỉ nhận inactive hoặc active
            'keyword' => 'required|string|max:255', // Không bắt buộc, tối đa 255 ký tự
        ]);
        // dd($request->all());


        try {


            // Xử lý upload file thumbnail
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            }

            // Xử lý upload file banner
            $bannerPath = null;
            if ($request->hasFile('banner')) {
                $bannerPath = $request->file('banner')->store('banners', 'public');
            }






            // Tạo slug từ tiêu đề gốc
            $slug = Str::slug($request->title);





            // Tạo mới bài viết
            blog::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'thumbnail' => $thumbnailPath,
                'banner' => $bannerPath,
                'status' => "inactive",
                'keyword' => $request->keyword,
                'slug' => $slug . '-' . strtolower(base64_encode(date('YmdHis'))),
                'views' => 0, // Giá trị mặc định
                'user_id' => Auth::id()
            ]);


            // Hiển thị thông báo thành công với SweetAlert2
            Alert::success('Bài viết đã được thêm thành công!');
            return redirect()->route('blogs.index');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi thêm bài viết: ' . $e->getMessage());
        }
    }

    // public function uploadImage(Request $request)
    // {
    //     // Validation cho file ảnh
    //     $request->validate([
    //         'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Tối đa 2MB
    //     ]);

    //     try {
    //         // Lưu ảnh vào thư mục froala_images trong public disk
    //         $path = $request->file('file')->store('froala_images', 'public');

    //         // Tạo URL cho ảnh
    //         $url = Storage::disk('public')->url($path);

    //         // Trả về JSON với URL của ảnh
    //         return response()->json([
    //             'link' => $url
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Không thể upload ảnh: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function edit($id)
    {


        $blog  =  Blog::findOrFail($id);
        $categories = Category::where('status', 'active')->get();




        return view('pages.blogs.edit',  compact('blog', 'categories'));
    }




    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keyword' => 'nullable|string|max:255',

        ]);



        try {
            $slug = Str::slug($request->title);

            $data = [
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'keyword' => $request->keyword,
                'slug' => $slug . '-' . strtolower(base64_encode(date('YmdHis'))),
                'user_id' => Auth::id()


            ];

            if ($request->hasFile('thumbnail')) {
                if ($blog->thumbnail) {
                    Storage::disk('public')->delete($blog->thumbnail);
                }
                $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
            }

            if ($request->hasFile('banner')) {
                if ($blog->banner) {
                    Storage::disk('public')->delete($blog->banner);
                }
                $data['banner'] = $request->file('banner')->store('banners', 'public');
            }

            $blog->update($data);

            Alert::success('Bài viết đã được cập nhật thành công!');


            return redirect()->route('blogs.index');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Cập nhật thất bại: ' . $e->getMessage());
        }
    }



    public function  status(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        // Toggle trạng thái
        $newStatus = $blog->status === 'active' ? 'inactive' : 'active';

        // Cập nhật trạng thái
        $blog->update([
            'status' => $newStatus
        ]);

        // Hiển thị thông báo thành công
        Alert::success('Cập nhật trạng thái thành công!');
        return redirect()->back();
    }



    public function destroy($id)
    {


        $blog  =  Blog::findOrFail($id);

        $blog->delete();
        Alert::success('Bài viết đã được xóa thành công!');


        return redirect()->route('blogs.index');
    }
}
