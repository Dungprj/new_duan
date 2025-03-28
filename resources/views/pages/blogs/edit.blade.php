@extends('layout.master')

@section('title')
    <title>Cập nhật bài viết</title>
@endsection

@section('content')
    <h1>Cập nhật bài viết</h1>

    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Thêm method PUT cho update -->

        <!-- Thông tin cơ bản -->
        <div class="form-group mb-3">
            <label for="title">Tiêu đề</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $blog->title) }}"
                required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="category_id">Danh mục</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Chọn danh mục</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nội dung -->
        <div class="form-group mb-3">
            <label for="description">Mô tả</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $blog->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group mb-3">
            <label for="content">Nội dung</label>
            <textarea name="content" id="example" class="form-control" rows="5">{{ old('content', $blog->content) }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        {{-- {!! $blog->content !!} --}}


        {{-- <x-forms.tinymce-editor :value="old('content', $blog->content)" /> --}}



        <!-- Hình ảnh -->
        <div class="form-group mb-3">
            <label for="thumbnail">Ảnh thumbnail</label>
            <input type="file" name="thumbnail" id="thumbnail" class="form-control-file" accept="image/*"
                onchange="previewImage(event, 'thumbnail-preview')">

            <div class="mt-2">
                <img id="thumbnail-preview" src="{{ $blog->thumbnail ? asset('storage/' . $blog->thumbnail) : '' }}"
                    alt="Thumbnail" style="max-width: 200px; {{ $blog->thumbnail ? '' : 'display: none;' }}">
            </div>

            @error('thumbnail')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="banner">Ảnh banner</label>
            <input type="file" name="banner" id="banner" class="form-control-file" accept="image/*"
                onchange="previewImage(event, 'banner-preview')">

            <div class="mt-2">
                <img id="banner-preview" src="{{ $blog->banner ? asset('storage/' . $blog->banner) : '' }}" alt="Banner"
                    style="max-width: 200px; {{ $blog->banner ? '' : 'display: none;' }}">
            </div>

            @error('banner')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <!-- SEO -->
        <div class="form-group mb-3">
            <label for="keyword">Từ khóa</label>
            <input type="text" name="keyword" id="keyword" class="form-control"
                value="{{ old('keyword', $blog->keyword) }}">
            @error('keyword')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nút hành động -->
        <div class="mt-3">
            <button type="submit" class="btn btn-success">Cập nhật</button>
            <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
@endsection

@section('script')
    <script>
        var editor = new FroalaEditor('#example');
    </script>

    <script>
        function previewImage(event, previewId) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function() {
                var img = document.getElementById(previewId);
                img.src = reader.result;
                img.style.display = 'block';
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
