<nav class="navbar navbar-expand-lg py-4">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <!-- <img src="assets/img/logo.jpg" alt="Logo"> -->
            <span>D NEWS</span>
        </a>




        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon "></span>
        </button>

        <!-- Search Box -->
        <div id="searchBox">
            <div class="input-group">

                <input type="text" class="form-control p-2 " name="query" id="search"
                    placeholder="Vui lòng nhập từ khóa">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

            <!-- Nơi hiển thị kết quả -->
            <ul id="searchResults" class="list-group mt-2"></ul>
        </div>



        <div class="collapse navbar-collapse" id="navbarNav">


            <ul class="navbar-nav ms-auto">

                <button class="btn text-white me-3" id="searchToggle">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>




                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Trang
                        chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('introduce') ? 'active' : '' }}"
                        href="{{ route('introduce') }}">Giới thiệu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('support') ? 'active' : '' }}" href="{{ route('support') }}">Hỗ
                        trợ</a>
                </li>





                @can(['Manage Blog'])
                    <li class="nav-item"><a class="nav-link {{ request()->is('admin/blogs') ? 'active' : '' }}"
                            href="{{ route('blogs.index') }}">Bài viết</a></li>
                @endcan




                {{-- -------admin----- --}}



                @can(['Manage Category'])
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/categories') ? 'active' : '' }}"
                            href="{{ route('categories.index') }}">Danh mục</a>
                    </li>
                @endcan







                @can(['Manage User'])
                    <li>
                        <a class="nav-link  {{ request()->is('admin/users') ? 'active' : '' }}"
                            href="{{ route('users.index') }}">Tài khoản</a>
                    </li>
                @endcan






                @if (Auth::check())
                    <!-- Nút đăng xuất nếu người dùng đã đăng nhập -->



                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle " data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false"> <i class="fa-solid fa-user "></i> <!-- User icon -->
                            {{ Auth::user()->name }} <!-- Display the user's name --></a>
                        <ul class="dropdown-menu">


                            {{-- <li>
                                <a class="nav-link dropdown-item text-black " href="#">
                                    <i class="fa-solid fa-circle-user p-2"></i>
                                    Vai trò</a>
                            </li> --}}
                            {{-- <li>
                                <a class="nav-link dropdown-item text-black " href="#">
                                    <i class="fa-solid fa-circle-user p-2"></i>
                                    Profile</a>
                            </li> --}}

                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fa-solid fa-sign-out-alt  p-2"></i> Đăng xuất
                                        <!-- Logout with icon -->
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>



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
