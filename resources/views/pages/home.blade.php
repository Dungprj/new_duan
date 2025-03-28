@extends('layout.master')

@section('meta')
    {{-- SEO meta tags --}}
    <meta name="title" content="Trang chủ">
    <meta name="description" content="Trang chủ về D NEWS">
@endsection

@section('title')
    <title>Trang chủ</title>
@endsection


@section('style')
    <style>
        /* ------------- Bài viết ---------------- */




        #img-ads {
            /* margin-top: 30px; */
            width: 100%;
            height: auto;
            object-fit: cover;
            /* transition: transform 0.3s ease; */
            animation: fadeInScale 2s ease-out infinite;
            /* Áp dụng animation lặp vô hạn */

        }

        .italic-text {
            font-style: italic;
            color: #666;
            line-height: 1.6;
            text-align: center;
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

        /* -------------------image-item---------------- */
        .card-img-left {
            width: 100%;
            height: 100%;
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



        /* ------------background--------- */

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="row">


                {{-- ---------------- img background --------------  --}}

                <div class="col-12 mb-4" style="height: 600px">
                    <!-- Swiper -->
                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"  class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/bg-1.jpg') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/bg-2.jpg') }}" alt="">
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/bg-6.jpg') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/bg-7.jpg') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/bg-3.jpg') }}" alt="">
                            </div>

                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/bg-5.jpg') }}" alt="">
                            </div>




                        </div>
                        <div class="swiper-pagination"></div>
                    </div>

                </div>


            </div>



            {{-- ------------------------------ --}}

            <div class="row mt-4">
                <!-- Image item -->

                @if ($blogs !== null)
                    @foreach ($blogs as $blog)
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                @php
                                    $category = $categories->FirstWhere('id', $blog->category_id)->first();
                                @endphp

                                <a href="{{ route('detail', [$category->slug, $blog->slug]) }}"
                                    class="text-black  fw-normal" style="text-decoration: none"  >
                                    <div class="row">
                                        <!-- Image -->
                                        <div class="col-md-4">
                                            <img
                                                src="{{ $blog->thumbnail ? asset('storage/' . $blog->thumbnail) : '' }}"
                                                class="card-img-left" alt="No image">
                                        </div>

                                        <!-- Text content -->
                                        <div class="card-body col-md-8">
                                            <h2 class="card-title" style="font-size: 1.2rem;">{{ $blog->title }}</h2>
                                            <p class="card-text"><em
                                                    class="italic-text">{{ \Illuminate\Support\Str::words($blog->description, 40, '...') }}</em>
                                            </p>

                                            <p style="opacity: 0.7" class="card-text card-meta">


                                                {{ $blog->formatted_time }}
                                                <span>-</span>
                                                Lượt xem : {{ $blog->formatted_views }}
                                            </p>


                                        </div>

                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <span class="text-center mt-3">Không có bài viết nào.</span>
                @endif


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
                                <li class="list-group-item "><a class="text-dark" style="text-decoration: none"
                                        href="{{ route('category', $item->slug) }}">{{ $item->title }}</a></li>
                            @endforeach
                        @endif

                    </ul>
                </div>
                <div class="card mb-4 col-md-12">
                    <div class="card-header">Bài viết phổ biến</div>
                    <ul class="list-group list-group-flush">

                        @if ($blog_views !== null)
                            @foreach ($blog_views as $item)
                                @php
                                    $category = $categories->FirstWhere('id', $item->category_id)->first();
                                @endphp

                                <li class="list-group-item "><a  class="text-dark" href="{{ route('detail', [$category->slug, $item->slug]) }}"
                                        style="text-decoration: none">{{ $item->title }}</a></li>
                            @endforeach
                        @else
                            <span class="text-center mt-3">Không có bài viết nào.</span>
                        @endif

                    </ul>
                </div>



                {{-- --------------------ads------------- --}}
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
            var swiper = new Swiper(".mySwiper", {
                direction: "vertical",
                slidesPerView: 1,
                autoplay: { // Thêm tự động chạy
                    delay: 2000, // Thời gian chờ giữa các slide (3000ms = 3 giây)
                    disableOnInteraction: false, // Tiếp tục chạy ngay cả khi người dùng tương tác
                },
                spaceBetween: 30,
                mousewheel: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        </script>

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
