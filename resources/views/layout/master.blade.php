<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->


    @yield('meta')

    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" sizes="64x64" type="image/png">





    @yield('title')



    {{-- bootstrap --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">




    {{-- icon  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    {{-- --  gg font  ------------ --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sora:wght@100..800&display=swap"
        rel="stylesheet">




    {{-- froala edit   --}}
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet"
        type="text/css" />




    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.css') }}" />

    <link rel="manifest" href="{{ asset('manifest.json') }}">


    {{-- <x-head.tinymce-config/> --}}

    @yield('style')
</head>

<body>

    @include('layout.header')





    <div class="container-fluid content  ">
        @yield('content')
    </div>




    @include('layout.footer')




    <!-- Thêm SweetAlert2 -->
    @include('sweetalert::alert')






    <!-- Bao gồm Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>


    <!-- Bao gồm Froala JS (chỉ 1 lần) -->
    <script src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>





    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @yield('script')






    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchToggle = document.getElementById("searchToggle");
            const searchBox = document.getElementById("searchBox");
            const searchInput = document.getElementById("search");
            const btn_search = document.getElementById("btn_search");


            let searchResults = document.createElement("ul");
            searchResults.id = "searchResults";
            searchBox.appendChild(searchResults);

            const blogs = @json($blogs); // Dữ liệu từ backend
            const categories = @json($categories); // Dữ liệu từ backend


            // Xử lý mở/đóng search box (Chỉ cho Desktop)
            searchToggle.addEventListener("click", function(event) {
                if (window.innerWidth <= 768) return; // Không hiển thị trên mobile
                event.stopPropagation();

                const isSearchBoxVisible = searchBox.style.display === "block";

                searchBox.style.display = isSearchBoxVisible ? "none" : "block";
                searchToggle.style.display = isSearchBoxVisible ? "block" : "none";


            });

            // Xử lý tìm kiếm khi nhập từ khóa
            searchInput.addEventListener("input", function() {
                const query = searchInput.value.trim().toLowerCase();
                searchResults.innerHTML = ""; // Xóa kết quả cũ

                if (query === "") {
                    searchResults.style.display = "none"; // Ẩn nếu input rỗng
                    return;
                }

                // Lọc kết quả phù hợp
                const filteredBlogs = blogs.filter(blog => blog.title.toLowerCase().includes(query));

                // Hiển thị danh sách kết quả
                if (filteredBlogs.length > 0) {
                    searchResults.style.display = "block"; // Hiện kết quả

                    filteredBlogs.forEach(blog => {
                        const li = document.createElement("li");

                        categories.filter(category => {
                            if (category.id === blog.category_id) {
                                li.innerHTML = `
                            <a href="/detail/${category.slug}/${blog.slug}">
                                <img src="${blog.thumbnail}" alt="Thumbnail">
                                <span>${blog.title}</span>
                            </a>
                        `;
                            }

                            searchResults.appendChild(li);
                        })

                    });
                } else {
                    searchResults.style.display = "none"; // Không có kết quả thì ẩn
                }
            });

            // Đóng search box khi click ra ngoài (Desktop)
            document.addEventListener("click", function(event) {
                if (window.innerWidth > 768 && !searchBox.contains(event.target) && event.target !==
                    searchToggle) {
                    searchBox.style.display = "none";
                    searchInput.value = ""; // Xóa nội dung nhập
                    searchResults.innerHTML = ""; // Xóa danh sách kết quả
                    searchResults.style.display = "none"; // Ẩn danh sách
                    searchToggle.style.display = "block";
                }
            });
        });
    </script>






    {{-- <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/serviceworker.js')
                .then(() => console.log("Service Worker Registered"))
                .catch((err) => console.log("Service Worker Failed", err));
        }
    </script> --}}

</body>

</html>
