<div class="form-group mb-3">
    <label for="example">Nội dung</label>
    <textarea name="content" id="content" class="form-control" rows="5">{!! $value ?? '' !!}</textarea>

    <!-- Hiển thị lỗi validation (nếu có) -->
    @error('content')
        <div class="text-danger">{{ $message }}</div>
    @enderror


</div>
