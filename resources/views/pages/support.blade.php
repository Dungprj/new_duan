@extends('layout.master')

@section('meta')
    {{-- SEO meta tags --}}
    <meta name="title" content="Hỗ trợ">
    <meta name="description" content="Hỗ trợ về D NEWS">
@endsection

@section('title')
    <title>Hỗ trợ</title>
@endsection


@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Hỗ trợ về D NEWS</h2>
            </div>
            <div class="card-body">
                <h4>Liên hệ với chúng tôi</h4>
                <p>Để nhận được sự hỗ trợ từ chúng tôi, vui lòng liên hệ qua các phương thức sau:</p>
                <ul>
                    <li><strong>Email:</strong> support@dnews.com</li>
                    <li><strong>Số điện thoại:</strong> 1800-123-456</li>
                    {{-- <li><strong>Chat trực tuyến:</strong> <a href="#">Nhấn vào đây để chat trực tuyến với chúng tôi</a></li> --}}
                </ul>

                <p>Để tạo tài khoản tác giả, vui lòng liên hệ qua các phương thức sau: </p>
                <ul>
                    <li><strong>Email:</strong> Taotaikhoan@gmail.com</li>
                    <li><strong>Số điện thoại:</strong> 123456789</li>
                </ul>

                <h4>Câu hỏi thường gặp (FAQ)</h4>
                <p>Dưới đây là một số câu hỏi thường gặp giúp bạn giải quyết vấn đề nhanh chóng:</p>
                <ul>
                    <li><strong>Cách đăng nhập vào tài khoản:</strong> Vui lòng vào trang Đăng nhập và nhập thông tin tài khoản của bạn. Nếu bạn quên mật khẩu, hãy sử dụng tính năng "Quên mật khẩu" để lấy lại tài khoản.</li>
                    <li><strong>Khôi phục tài khoản:</strong> Nếu bạn gặp vấn đề khi đăng nhập, vui lòng liên hệ với bộ phận hỗ trợ qua email hoặc chat trực tuyến.</li>
                    <li><strong>Cách thay đổi thông tin cá nhân:</strong> Truy cập vào trang tài khoản và chọn "Cập nhật thông tin" để thay đổi thông tin cá nhân của bạn.</li>
                </ul>

                <h4>Hỗ trợ kỹ thuật</h4>
                <p>Chúng tôi cam kết hỗ trợ bạn trong việc sử dụng trang web và giải quyết các vấn đề kỹ thuật như sau:</p>
                <ul>
                    <li><strong>Sự cố không thể tải trang:</strong> Hãy thử làm mới trình duyệt hoặc kiểm tra kết nối mạng của bạn.</li>
                    <li><strong>Trang web bị lỗi hiển thị:</strong> Vui lòng thử sử dụng trình duyệt khác hoặc xóa bộ nhớ cache của trình duyệt hiện tại.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
