<nav class="navbar navbar-expand-lg py-4 ">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center " href="#">
            {{-- <img src="assets/img/logo.jpg" alt="Logo"> --}}
            <span>D NEWS</span>
        </a>


        <form action="#" class="navbar-nav ms-auto">
            <input type="text">
        </form>

        <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon "></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">


            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link   {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Trang
                        chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link   {{ request()->is('introduce') ? 'active' : '' }}"
                        href="{{ route('introduce') }}">Giới thiệu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link   {{ request()->is('support') ? 'active' : '' }}"
                        href="{{ route('support') }}">Hỗ trợ</a>
                </li>


                @if (Auth::check())
                    <!-- Kiểm tra nếu người dùng đã đăng nhập -->

                    @if (Auth::user()->roles === 'author')
                        <!-- Kiểm tra vai trò 'author' -->
                        <li class="nav-item"><a
                                class="nav-link   {{ request()->is('admin/categories-author') ? 'active' : '' }}"
                                href="{{ route('categories-author.index') }}">Danh
                                mục</a></li>
                        <li class="nav-item"><a class="nav-link  " href="#">Bài viết</a></li>
                    @elseif (Auth::user()->roles === 'admin')
                        <!-- Kiểm tra vai trò 'admin' -->

                        <li class="nav-item">
                            <a class="nav-link   {{ request()->is('admin/categories') ? 'active' : '' }}"
                                href="{{ route('categories.index') }}">Danh mục</a>
                        </li>

                        <li class="nav-item"><a
                                class="nav-link    {{ request()->is('admin/approval') ? 'active' : '' }}"
                                href="{{ route('approval.index') }}">Phê
                                duyệt</a></li>
                        <li class="nav-item"><a class="nav-link   {{ request()->is('admin/users') ? 'active' : '' }}"
                                href="{{ route('users.index') }}">Tài
                                khoản</a></li>
                    @endif

                    <!-- Nút đăng xuất nếu người dùng đã đăng nhập -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-light ms-3">Đăng xuất</button>
                        </form>
                    </li>
                @else
                    <!-- Nếu người dùng chưa đăng nhập -->


                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-light ms-3">Đăng nhập</a>
                    </li>
                @endif

            </ul>





        </div>




    </div>
</nav>
