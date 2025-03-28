@extends('layout.master')

@section('title')
    <title>Thêm tài khoản</title>
@endsection

@section('content')
    <h1 class="mt-3">Thêm tài khoản</h1>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        @if (session('login_error'))
            {{-- <div class="invalid-feedback">{{ session('login_error') }}</div> --}}
            <span>{{ session('login_error') }}</span>
        @endif


        <!-- name input -->
        <div class="mb-3">
            <label for="role" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                placeholder="Nhập tên" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <!-- Email input -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                placeholder="Nhập email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Vai trò</label>
            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                <option value="">Chọn vai trò</option> <!-- Placeholder option -->
                @if ($roles)
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                @endif

            </select>

            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password input -->
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" placeholder="Nhập mật khẩu" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>





        <!-- Submit button -->
        <button type="submit" class="btn btn-primary ">Thêm</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
