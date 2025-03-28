<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::orderBy('id','desc')->get();
        return view('pages.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|min:2|max:255|unique:categories,title'
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('categories.create')  // Quay lại trang thêm danh mục
                ->withErrors($validator)  // Trả về lỗi validation
                ->withInput();  // Giữ lại dữ liệu đã
        }

        $slug = Str::slug($request->title, "-");



        Category::create([
            'title' => $request->title,
            'slug' =>  $slug,

        ]);

        // Hiển thị thông báo thành công với SweetAlert2
        Alert::success( 'Danh mục đã được thêm thành công!');


        // Chuyển hướng về danh sách danh mục với thông báo thành công
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
       return view('404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        return view('pages.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => [
                    'required',
                    'min:2',
                    'max:255',
                    Rule::unique('categories', 'title')->ignore($id),
                ],
                'status'  => 'required|string|in:active,inactive'
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('categories.create')  // Quay lại trang thêm danh mục
                ->withErrors($validator)  // Trả về lỗi validation
                ->withInput();  // Giữ lại dữ liệu đã nh
        }

        $slug = Str::slug($request->title, "-");

        $category = Category::findOrFail($id);
        $category->update([
            'title' => $request->title,
            'slug' =>  $slug,
            'status' =>  $request->status,
        ]);


        // Hiển thị thông báo thành công
        Alert::success( 'Danh mục đã được cập nhật thành công!');
        // Chuyển hướng về danh sách danh mục với thông báo thành công
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        // Hiển thị thông báo thành công
        Alert::success( 'Danh mục đã được xóa thành công!');
        return redirect()->route('categories.index');
    }
}
