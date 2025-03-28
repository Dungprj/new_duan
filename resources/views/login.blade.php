<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" sizes="64x64" type="image/png">


    <title>Đăng nhập</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- --  gg font  ------------ --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sora:wght@100..800&display=swap"
        rel="stylesheet">

    <style>
        body {
            background-color: #06D7A0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            font-family: "Roboto", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-variation-settings:
                "wdth" 100;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-primary {
            border-radius: 20px;
            padding: 10px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #0044cc;
        }

        .invalid-feedback {
            font-size: 0.875rem;
        }
    </style>
</head>

<body>


    <div class="login-container">
        <h2>Đăng nhập</h2>
        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            @if (session('login_error'))
                {{-- <div class="invalid-feedback">{{ session('login_error') }}</div> --}}
                <span>{{ session('login_error') }}</span>
            @endif

            <!-- Email input -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" placeholder="Nhập email" value="{{ old('email') }}" required>
                @error('email')
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
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>

        <hr>

        <a href="{{ route('register') }}" class="text-center">Đăng ký</a>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Thêm SweetAlert2 -->
    @include('sweetalert::alert')
</body>

</html>
