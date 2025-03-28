@extends('layout.master')

@section('title')
    <title>Cập nhật danh mục</title>
@endsection

@section('content')
    <h1  class="mt-3">Cập nhật danh mục</h1>

    <!-- Cập nhật form -->
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Dùng PUT để cập nhật -->

        <div class="form-group mb-3">
            <label for="title">Tên danh mục</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $category->title) }}"
                required>

            <!-- Hiển thị lỗi nếu có -->
            @if ($errors->has('title'))
                <div class="text-danger">
                    <p>{{ $errors->first('title') }}</p> <!-- Hiển thị lỗi đầu tiên cho trường title -->
                </div>
            @endif
        </div>


        <div class="form-group mb-3">
            <label for="status">Trạng thái</label>
            <select name="status" id="status" class="form-control" required>
                <option value="">Chọn trạng thái</option> <!-- Optional: Placeholder option -->
                <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <!-- Hiển thị lỗi nếu có -->
            @if ($errors->has('status'))
                <div class="text-danger">
                    <p>{{ $errors->first('status') }}</p> <!-- Hiển thị lỗi đầu tiên cho trường status -->
                </div>
            @endif
        </div>



        <button type="submit" class="btn btn-success mt-3">Cập nhật</button>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Quay lại</a>

    </form>
@endsection
