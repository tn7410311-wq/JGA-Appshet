@component('mail::message')
@if ($status === 'approved')
# Chào Mừng! Tài Khoản Đã Được Phê Duyệt

Xin chúc mừng, {{ $user->fullname }}!

Tài khoản của bạn đã được phê duyệt thành công. Bạn giờ đây có thể đăng nhập và sử dụng tất cả các tính năng của hệ thống.

@component('mail::button', ['url' => route('login')])
Đăng Nhập Ngay
@endcomponent

Nếu bạn gặp bất kỳ vấn đề nào, vui lòng liên hệ: tn7410311@gmail.com

@else
# Tài Khoản Không Được Phê Duyệt

Xin lỗi, {{ $user->fullname }}!

Tài khoản đăng ký của bạn không được phê duyệt. Lý do:

**{{ $rejectionReason }}**

Nếu bạn có câu hỏi hoặc muốn khắc phục, vui lòng liên hệ:

@component('mail::button', ['url' => 'mailto:tn7410311@gmail.com'])
Liên Hệ Admin
@endcomponent

@endif

---

Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.

@endcomponent
