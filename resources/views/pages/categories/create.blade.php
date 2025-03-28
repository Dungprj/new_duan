@extends('layout.master')

@section('title')
    <title>Thêm danh mục</title>
@endsection

@section('content')
    <h1  class="mt-3">Thêm danh mục</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Tên danh mục</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>

            <!-- Hiển thị lỗi nếu có -->
            @if ($errors->has('title'))
                <div class="text-danger">
                    <p>{{ $errors->first('title') }}</p> <!-- Hiển thị lỗi đầu tiên cho trường title -->
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-success mt-3">Thêm</button>
        <a href="{{route('categories.index')}}"  class="btn btn-secondary mt-3">Quay  lại</a>

    </form>
@endsection
