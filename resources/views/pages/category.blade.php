@extends('layout.master')



@section('meta')
    {{-- SEO meta tags --}}
    <meta name="title" content="{{ $category_title->title ?? '' }}">
    <meta name="description" content="{{ $category_title->title ?? '' }}">
@endsection


@section('title')
    <title>{{ $category_title->title }}</title>
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


        #imgage-item-list {
            width: 100%;
            height: 100%;
            object-fit: cover;
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

        .italic-text {
            font-style: italic;
            color: #666;
            line-height: 1.6;
            text-align: center;
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
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="row">

                <div class="col-12 mb-4">

                    @if ($blogs->isNotEmpty())
                        @foreach ($blogs as $blog)
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <a href="{{ route('detail', [$category_title->slug, $blog->slug]) }}"
                                        class="text-black  fw-normal" style="text-decoration: none">
                                        <div class="row">
                                            <!-- Image -->
                                            <div class="col-md-4">
                                                <img id="imgage-item-list"
                                                    src="{{ $blog->thumbnail ? asset('storage/' . $blog->thumbnail) : '' }}"
                                                    class="card-img-left" alt="No image">
                                            </div>

                                            <!-- Text content -->
                                            <div class="card-body col-md-8">
                                                <h2 class="card-title">{{ $blog->title }}</h2>
                                                <p class="card-text"> <em
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







        </div>









        {{-- -----------  danh mục ----------- --}}


        <div class="col-md-3">
            <div class="row">
                <div class="card mb-4 col-md-12">
                    <div class="card-header">Danh mục</div>
                    <ul class="list-group list-group-flush">
                        @if ($categories)
                            @foreach ($categories as $item)
                                <li class="list-group-item"><a style="text-decoration: none" class="text-dark"
                                        href="{{ route('category', $item->slug) }}">{{ $item->title }}</a></li>
                            @endforeach
                        @endif

                    </ul>
                </div>
                <div class="card mb-4 col-md-12">
                    <div class="card-header">Bài viết phổ biến</div>
                    <ul class="list-group list-group-flush">

                        @if ($blog_views)
                            @foreach ($blog_views as $item)
                                <li class="list-group-item"><a class="text-dark"
                                        href="{{ route('detail', [$category_title->slug, $item->slug]) }}"
                                        style="text-decoration: none">{{ $item->title }}</a></li>
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



    {{-- <script>
        let currentPage = 1; // Biến để theo dõi số trang hiện tại
        const perPage = 5; // Số bài viết tải mỗi lần
        let isLoading = false; // Kiểm tra xem có đang tải bài viết hay không

        // Hàm để tải thêm bài viết
        function loadArticles(page) {
            // Thêm lớp 'loading' để tránh tải lại khi đang tải
            isLoading = true;

            // Giả sử bạn có một API để lấy bài viết, ở đây chúng ta sẽ dùng setTimeout để giả lập việc tải bài viết
            setTimeout(() => {
                const articles = [{
                        title: `Bài viết ${page * perPage - 4}`,
                        description: "Mô tả bài viết"
                    },
                    {
                        title: `Bài viết ${page * perPage - 3}`,
                        description: "Mô tả bài viết"
                    },
                    {
                        title: `Bài viết ${page * perPage - 2}`,
                        description: "Mô tả bài viết"
                    },
                    {
                        title: `Bài viết ${page * perPage - 1}`,
                        description: "Mô tả bài viết"
                    },
                    {
                        title: `Bài viết ${page * perPage}`,
                        description: "Mô tả bài viết"
                    },
                ];

                // // Thêm bài viết vào container
                // const container = document.getElementById('news-container');
                // articles.forEach(article => {
                //     const articleDiv = document.createElement('div');
                //     articleDiv.classList.add('article');
                //     articleDiv.innerHTML = `
            //     <div class="card mb-4">
            //         <div class="card-body">
            //             <h2 class="card-title">${article.title}</h2>
            //             <p class="card-text">${article.description}</p>
            //         </div>
            //     </div>
            // `;
                //     container.appendChild(articleDiv);
                // });

                // Cập nhật lại trạng thái loading
                isLoading = false;
            }, 1000); // Giả lập thời gian tải
        }

        // Hàm để kiểm tra khi cuộn đến cuối trang
        function checkScroll() {
            const scrollHeight = document.documentElement.scrollHeight;
            const scrollTop = document.documentElement.scrollTop;
            const clientHeight = document.documentElement.clientHeight;

            // Khi cuộn đến gần cuối trang, tải thêm bài viết
            if (scrollTop + clientHeight >= scrollHeight - 50 && !isLoading) {
                currentPage++;
                loadArticles(currentPage);
            }
        }

        // Lắng nghe sự kiện cuộn trang
        window.addEventListener('scroll', checkScroll);

        // Tải bài viết lần đầu khi trang tải
        loadArticles(currentPage);
    </script> --}}
@endsection
