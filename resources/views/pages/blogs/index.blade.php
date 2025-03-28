@extends('layout.master')


@section('title')
    <title>Bài viết</title>
@endsection


@section('style')
    <style>
        /* CSS cho trạng thái "Hoạt động" */
        .active {
            color: green;
            font-weight: bold;
            background-color: #e0f7e0;
            /* Màu nền nhẹ cho trạng thái hoạt động */
        }

        /* CSS cho trạng thái "Đang xử lý" */
        .processing {
            color: orange;
            font-weight: bold;
            background-color: #fff3e0;
            /* Màu nền nhẹ cho trạng thái đang xử lý */
        }
    </style>
@endsection


@section('content')
    @can('Manage Blog')
        <div class="row">

            @can('Create Blog')
                <div class="col-md-12 mb-3 mt-3">
                    <div style="display: flex; justify-content: end;">
                        <a href="{{ route('blogs.create') }}" class="btn btn-primary "><i class="fa-solid fa-plus"></i> Thêm bài
                            viết</a>

                    </div>
                </div>
            @endcan

            <h1>Danh sách bài viết</h1>

            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Bài viết</th>
                        <th>Tên danh mục</th>
                        @if (auth()->user()->hasRole('Admin'))
                            <th>Keyword</th>
                        @endif
                        <th>Mô tả</th>
                        @if (auth()->user()->hasRole('Admin'))
                            <th>Người tạo</th>
                        @endif
                        <th>Lượt xem</th>
                        <th>Trạng thái</th>
                        @if (auth()->user()->hasRole('Admin'))
                            <th>Phê duyệt</th>
                        @endif
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $key => $blog)
                        <tr class="text-center">
                            <td>{{ $key }}</td> <!-- Tính số thứ tự chính xác -->
                            <td>{{ $blog->title }}</td>
                            <td>{{ $categories->FirstWhere('id', $blog->category_id)->title }}</td>
                            @if (auth()->user()->hasRole('Admin'))
                                <td>{{ $blog->keyword }}</td>
                            @endif

                            <td>{{ \Illuminate\Support\Str::words($blog->description, 40, '...') }}</td>
                            @if (auth()->user()->hasRole('Admin'))
                                <td>{{ $users->FirstWhere('id', $blog->user_id)->name ?? '' }}</td>
                            @endif
                            <td>
                                @if ($blog->views !== null)
                                    @php
                                        // Xử lý lượt xem
                                        $views = $blog->views;
                                        if ($views >= 1000000000) {
                                            $formattedViews = number_format($views / 1000000000, 1) . 'B';
                                        } elseif ($views >= 1000000) {
                                            $formattedViews = number_format($views / 1000000, 1) . 'M';
                                        } elseif ($views >= 1000) {
                                            $formattedViews = number_format($views / 1000, 1) . 'K';
                                        } else {
                                            $formattedViews = $views;
                                        }
                                    @endphp
                                    {{ $formattedViews }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                <p class="{{ $blog->status === 'active' ? 'badge bg-primary' : 'badge bg-secondary' }}">
                                    {{ $blog->status === 'active' ? 'Hoạt động' : 'Đang xử lý' }}
                                </p>
                            </td>
                            @if (auth()->user()->hasRole('Admin'))
                                <td>
                                    <form action="{{ route('blogs.status', $blog->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm {{ $blog->status === 'active' ? 'badge bg-secondary' : 'badge bg-primary' }}">
                                            {{ $blog->status === 'active' ? 'Tắt' : 'Bật' }}
                                        </button>
                                    </form>
                                </td>
                            @endif
                            <td>
                                @if ($blog->created_at !== null)
                                    @php
                                        $createdAt = \Carbon\Carbon::parse($blog->created_at);
                                        $now = \Carbon\Carbon::now();
                                        $diffInSeconds = $createdAt->diffInSeconds($now);
                                        $diffInMinutes = $createdAt->diffInMinutes($now);
                                        $diffInHours = $createdAt->diffInHours($now);
                                    @endphp
                                    @if ($diffInHours >= 24)
                                        {{ $createdAt->format('d-m-Y') }}
                                    @elseif ($diffInHours >= 1)
                                        {{ $diffInHours }} giờ trước
                                    @elseif ($diffInMinutes >= 1)
                                        {{ $diffInMinutes }} phút trước
                                    @else
                                        {{ $diffInSeconds }} giây trước
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @can('Edit Blog')
                                    <!-- Sửa -->
                                    <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-success">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @endcan
                                @can('Delete Blog')
                                    <!-- Xóa -->
                                    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="delete-form"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    @endcan
@endsection



@section('script')
    <script>
        $(document).ready(function() {
            // Xác nhận xóa
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);


                Swal.fire({
                    title: 'Bạn có chắc chắn?',
                    text: 'Danh mục này sẽ bị xóa vĩnh viễn!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // console.log('Submitting form to delete category:', form.attr('action'));
                        // Ngăn sự kiện submit lặp lại
                        form.off('submit');
                        form.submit();
                    }
                });
            });

            // Khởi tạo DataTable
            new DataTable('#example');
        });
    </script>
@endsection
