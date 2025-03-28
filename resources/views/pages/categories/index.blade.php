@extends('layout.master')


@section('title')
    <title>Danh mục</title>
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
    @can('Manage Category')
        <div class="row">

            @can('Create Category')
                <div class="col-md-12 mb-3 mt-3">
                    <div style="display: flex; justify-content: end;">
                        <a href="{{ route('categories.create') }}" class="btn btn-primary "><i class="fa-solid fa-plus"></i> Thêm danh
                            mục</a>

                    </div>
                </div>
            @endcan

            <div class="col-md-12 mb-3 mt-3">
                <h1>Danh sách danh mục</h1>

                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Tên danh mục</th>

                            @if (auth()->user()->hasRole('Admin'))
                                <th>Slug</th>
                            @endif

                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>


                            @if (auth()->user()->hasRole('Admin'))
                                <th>Hành động</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($categories as $key => $category)
                            <tr class="text-center">
                                <td>{{ $key }}</td>
                                <td>{{ $category->title }}</td>



                                @if (auth()->user()->hasRole('Admin'))
                                    <td>{{ $category->slug }}</td>
                                @endif


                                <td>
                                    <p class="{{ $category->status === 'active' ? 'badge bg-primary' : 'badge bg-secondary' }}">
                                        {{ $category->status === 'active' ? 'Hoạt động' : 'Đang xử lý' }}
                                    </p>
                                </td>


                                <td>
                                    @if ($category->created_at !== null)
                                        @php
                                            $createdAt = \Carbon\Carbon::parse($category->created_at);
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




                                @if (auth()->user()->hasRole('Admin'))
                                    <td>

                                        @can('Edit Category')
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-success">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endcan


                                        {{-- @can('Delete Category')
                                            <form action="{{ route('categories.destroy', $category->id) }}" class="delete-form"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan --}}


                                        @can('Delete Category')
                                            <form action="{{ route('categories.destroy', $category->id) }}" class="delete-form"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan

                                    </td>
                                @endif



                            </tr>
                        @endforeach




                    </tbody>

                </table>
            </div>



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
