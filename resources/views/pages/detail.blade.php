@extends('layout.master')


@section('meta')
    {{-- SEO meta tags --}}

    <!-- SEO meta tags for Bing, Yahoo,... -->
    <meta name="keywords" content="{{ $blog->keyword ?? '' }}">
    <!-- SEO meta tags for Google -->
    <meta name="title" content="{{ $blog->title ?? '' }}" />
    <meta name="description" content="{{ $blog->description ?? '' }}">

    {{-- Share link url --}}
    <!-- Open Graph meta tags for Facebook, LinkedIn, Telegram, Twitter, etc. -->
    <meta property="og:title" content="{{ $blog->title ?? '' }}" />
    <meta property="og:description" content="{{ $blog->description ?? '' }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image"
        content="{{ $blog->thumbnail ? url($blog->thumbnail) : asset(Storage::url('logo/placeholder.png')) }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:alt" content="{{ $blog->description ?? '' }}" />
@endsection




@section('title')
    <title>{{ $blog->title }}</title>
@endsection


@section('style')
    <style>
        /* ------------- Bài viết ---------------- */

        #img-background {
            width: 100%;
            height: 450px;
            object-fit: cover;
        }

        #img-item {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        #img-ads {
            /* margin-top: 30px; */
            width: 100%;
            height: auto;
            object-fit: cover;
            /* transition: transform 0.3s ease; */
            animation: fadeInScale 2s ease-out infinite;
            /* Áp dụng animation lặp vô hạn */

        }




        /* Định nghĩa animation cho fade-in và scale */
        @keyframes fadeInScale {
            0% {
                opacity: 1;
                transform: scale(0.9);
                /* Bắt đầu nhỏ hơn */
            }

            50% {
                opacity: 1;
                /* Giữa animation ảnh sẽ rõ hơn */
                transform: scale(1);
                /* Kích thước bình thường */
            }

            100% {
                opacity: 1;
                transform: scale(0.9);
                /* Kết thúc nhỏ lại */
            }
        }

        /* -------------------imgage-item-list---------------- */
        #imgage-item-list {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }




        /* ------------ banner ads --------------------  */

        /* Banner container */
        /* Banner ở cuối trang */
        .banner {
            position: fixed;
            bottom: 0;
            /* Đặt banner ở cuối trang */
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            text-align: center;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: slideIn 0.5s ease-out;
            /* Hiệu ứng xuất hiện */
        }

        /* Nội dung banner */
        .banner-content {
            position: relative;
        }

        /* Tiêu đề banner */
        .banner-title {
            font-size: 24px;
            font-weight: bold;
        }

        /* Mô tả banner */
        .banner-description {
            font-size: 16px;
            margin-bottom: 10px;
        }

        /* Nút "Mua ngay" */
        .btn-banner {
            padding: 10px 20px;
            background-color: #f39c12;
            color: white;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        /* Nút đóng banner */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
            color: white;
        }

        /* Hiệu ứng khi đóng banner */
        @keyframes slideIn {
            from {
                transform: translateY(100%);
                /* Vào từ dưới lên */
            }

            to {
                transform: translateY(0);
                /* Đến vị trí cuối trang */
            }
        }

        @keyframes slideOut {
            from {
                transform: translateY(0);
                /* Ban đầu ở vị trí cuối trang */
            }

            to {
                transform: translateY(100%);
                /* Di chuyển xuống dưới khỏi màn hình */
            }
        }




        /* ---------------- description ------------------ */
        .italic-text {
            font-style: italic;
            color: #666;
            line-height: 1.6;
            text-align: center;
        }
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="row">


                {{-- ---------------- img background --------------  --}}

                <div class="col-12  mt-3">



                    <h2 class="card-title card-title-h2 mb-3">{{ $blog->title }}</h2>
                    <p style="opacity: 0.7" class="card-title mb-3">{{ $blog->formatted_time }} - Lượt xem :
                        {{ $blog->formatted_views }}<sp>



                            <img id="img-background" src="{{ $blog->banner ? asset('storage/' . $blog->banner) : '' }}"
                                class="card-img-top mt-2" alt="Hình ảnh bài viết">


                            <p><em class="italic-text">{{ $blog->description }}</em></p>

                            {{-- <hr> --}}
                            <p class="mt-4">

                                {!! $blog->content !!}

                            </p>

                </div>


            </div>




            <hr>
            <div class="col-12  mt-3">
                <h4 class="mb-3">Bài viết liên quan</h4>
                <div class="row">



                    @if ($related_blogs->isNotEmpty())
                        @foreach ($related_blogs as $item)
                            <div class="col-md-4 mb-4">

                                <div class="card">
                                    <a href="{{ route('detail', [$categories_blog->slug, $item->slug]) }}"
                                        style="text-decoration: none; color: black;">

                                        <img id="img-item"
                                            src="{{ $item->thumbnail ? asset('storage/' . $item->thumbnail) : '' }}"
                                            class="card-img-top" alt="Hình ảnh bài viết">
                                        <div class="card-body">
                                            <h2 class="card-title">{{ $item->title }}</h2>
                                            <p class="card-text">
                                                {{ \Illuminate\Support\Str::words($blog->description, 40, '...') }}</p>
                                            <p style="opacity: 0.5">
                                                {{ $blog->formatted_time }}
                                                <span>-</span>
                                                Lượt xem : {{ $blog->formatted_views }}
                                            </p>
                                        </div>
                                    </a>

                                </div>


                            </div>
                        @endforeach
                    @else
                        <p class="text-center mt-3 ">Không có bài viết nào.</p>
                    @endif





                </div>
            </div>
        </div>










        {{-- -----------  danh mục ----------- --}}


        <div class="col-md-3">
            <div class="row">
                <div class="card mb-4 col-md-12">
                    <div class="card-header">Danh mục</div>
                    <ul class="list-group list-group-flush">
                        @if ($categories)
                            @foreach ($categories as $item)
                                <li class="list-group-item"><a style="text-decoration: none"
                                        href="{{ route('category', $item->slug) }}">{{ $item->title }}</a></li>
                            @endforeach
                        @endif

                    </ul>
                </div>


                {{-- f-88  --}}
                <div class="card mb-4 col-md-12">
                    <div>
                        <a href="#">
                            <img id="img-ads"
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTBaMCiAxx8d0_QxHwTA1mdFR-szxAe65o4zQ&s"
                                alt="">
                        </a>
                    </div>
                </div>

                {{-- f-88  --}}
                <div class="card mb-4 col-md-12">
                    <div>
                        <a href="#">
                            <img id="img-ads"
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7J1SIwI4f0UPHYNkWh3-PNkA-n9NED0hvOA&s"
                                alt="">
                        </a>
                    </div>
                </div>

                {{-- f-88  --}}
                <div class="card mb-4 col-md-12">
                    <div>
                        <a href="#">
                            <img id="img-ads"
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJiCXqajn9Go5LzjdvAa6_PkyPt5znoDXzSg&s"
                                alt="">
                        </a>
                    </div>
                </div>




                {{-- sellphone  --}}
                <div class="card mb-4 col-md-12">
                    <div>
                        <a href="#">
                            <img id="img-ads"
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ7EJ1Y2cyQjOHV4ytdyPek9tyLncziHTHegA&s"
                                alt="">
                        </a>
                    </div>
                </div>




                {{-- <div class="border-bottom border-success mt-5"></div> --}}
                {{-- slider  --}}
                {{-- <div class="card mb-4 mt-3 col-md-12">
                    <div class="card-header">Xu hướng</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="#">Bài viết 1</a></li>
                        <li class="list-group-item"><a href="#">Bài viết 2</a></li>
                        <li class="list-group-item"><a href="#">Bài viết 3</a></li>
                    </ul>
                </div> --}}
            </div>
        </div>

    </div>







    {{-- ------------------ banner ads --------------- --}}
    <div class="banner" id="banner">
        <div class="banner-content">
            <h2 class="banner-title">Khuyến mãi đặc biệt!</h2>
            <p class="banner-description">Mua Samsung Galaxy M55 5G với giá chỉ 9.19 triệu đồng, giảm thêm đến 600K cho
                sinh viên.</p>
            <a href="#" class="btn-banner">Mua ngay</a>
            <span class="close-btn" id="closeBtn">X</span> <!-- Nút đóng -->
        </div>
    </div>

@endsection


@section('script')
    <script>
        // Lấy phần tử banner và nút đóng
        const banner = document.getElementById('banner');
        const closeBtn = document.getElementById('closeBtn');

        // Thêm sự kiện khi nhấn nút "X"
        closeBtn.addEventListener('click', function() {
            // Áp dụng hiệu ứng slideOut khi đóng banner
            banner.style.animation = 'slideOut 0.5s ease-out';

            // Sau khi animation kết thúc, ẩn banner
            setTimeout(function() {
                banner.style.display = 'none'; // Ẩn hoàn toàn sau khi animation
            }, 500); // Thời gian chờ bằng với độ dài của animation
        });
    </script>
@endsection
