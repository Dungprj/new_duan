@extends('layout.master')


@section('title')
    <title>Tài khoản</title>
@endsection





@section('content')
    @can('Manage User')
        <div class="row">


            @can('Create User')
                <div class="col-md-12 mb-3 mt-3">
                    <div style="display: flex; justify-content: end;">
                        <a href="{{ route('users.create') }}" class="btn btn-primary "><i class="fa-solid fa-plus"></i> Thêm tài
                            khoản</a>
                    </div>
                </div>
            @endcan

            <div class="col-md-12 mb-3">
                <h1>Danh sách tài khoản</h1>

                <div class="row">
                    @foreach ($users as $key => $user)
                        <div class="col-md-3 mb-3 ">
                            <div class="card">
                                <div class="card-body">


                                    <div class="d-flex  justify-content-between">
                                        <h5 class="card-title">{{ $user->name }}</h5>
                                        <div>
                                            @if (implode(', ', $user->getRoleNames()->toArray()) !== 'Admin')
                                                @if ($user->status === 'active')
                                                    <form action="{{ route('users.status', [$user->id, 'check']) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit"
                                                            style="background:none; border:none; cursor:pointer;">
                                                            <i id="check-icon" class="fa-solid fa-check"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('users.status', [$user->id, 'xmark']) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit"
                                                            style="background:none; border:none; cursor:pointer;">
                                                            <i id="xmark-icon" class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif

                                        </div>
                                    </div>
                                    <img style="width: 100%;" src="{{ asset('assets/img/user..png') }}" alt="user">


                                    {{-- Nút Xem chi tiết --}}
                                    <button class="btn btn-info" data-bs-toggle="collapse"
                                        data-bs-target="#details-{{ $user->id }}" aria-expanded="false"
                                        aria-controls="details-{{ $user->id }}">
                                        Xem chi tiết
                                    </button>

                                    {{-- Thông tin chi tiết (ẩn đi ban đầu) --}}
                                    <div class="collapse" id="details-{{ $user->id }}">
                                        <div class="mt-2">
                                            <strong>Email:</strong> {{ $user->email }}<br>
                                            <strong>Vai trò:</strong> {{ implode(', ', $user->getRoleNames()->toArray()) }}<br>
                                            <strong>Trạng thái:</strong>
                                            <span
                                                class="badge {{ $user->status === 'active' ? 'bg-primary' : 'bg-secondary' }}">
                                                {{ $user->status === 'active' ? 'Hoạt động' : 'Ngưng hoạt động' }}
                                            </span><br>
                                            <strong>Ngày tạo:</strong>
                                            {{-- {{ $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : 'N/A' }} --}}

                                            @if ($user->created_at !== null)
                                                @php
                                                    $createdAt = \Carbon\Carbon::parse($user->created_at);
                                                    $now = \Carbon\Carbon::now();
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


                                        </div>
                                    </div>


                                    @if (implode(', ', $user->getRoleNames()->toArray()) !== 'Admin')
                                        {{-- Biểu tượng cài đặt --}}
                                        <button class="btn mt-2" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#settings-{{ $user->id }}" aria-expanded="false"
                                            aria-controls="settings-{{ $user->id }}">
                                            <i class="fa-solid fa-gear"></i>
                                        </button>


                                        {{-- Nút Edit và Delete (ẩn đi ban đầu) --}}
                                        <div class="collapse" id="settings-{{ $user->id }}">
                                            <div class="mt-3">

                                                @can('Edit User')
                                                    <!-- Sửa -->
                                                    <a href="{{ $user->email !== 'admin@gmail.com' ? route('users.edit', $user->id) : '#' }}"
                                                        class="btn btn-success"
                                                        @if ($user->email === 'admin@gmail.com') style="pointer-events: none; display: none;" @endif>
                                                        <i class="fa-solid fa-pen-to-square"></i> Sửa
                                                    </a>
                                                @endcan


                                                @can('Delete User')
                                                    <!-- Xóa -->
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            @if ($user->email === 'admin@gmail.com') style="pointer-events: none; display: none;" @endif>
                                                            <i class="fa-solid fa-trash"></i> Xóa
                                                        </button>
                                                    </form>
                                                @endcan

                                            </div>
                                        </div>
                                    @endif



                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Hiển thị phân trang -->
                {{ $users->links('pagination::bootstrap-5', ['nextText' => '<i class="fas fa-arrow-right"></i>', 'prevText' => '<i class="fas fa-arrow-left"></i>']) }}
            </div>
        </div>
    @endcan
@endsection


@section('script')
@endsection
