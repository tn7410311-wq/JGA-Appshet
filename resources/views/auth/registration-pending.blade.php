@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <!-- Success Icon -->
        <div class="flex justify-center mb-8">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-clock text-4xl text-blue-600"></i>
            </div>
        </div>

        <!-- Message -->
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-white mb-4">Đơn Đăng Ký Đã Gửi</h1>
            <p class="text-gray-300 mb-8 text-lg">
                Cảm ơn bạn đã đăng ký! Tài khoản của bạn đang chờ phê duyệt từ quản trị viên.
            </p>

            <!-- Info Box -->
            <div class="bg-blue-900/30 border border-blue-500/30 rounded-xl p-6 mb-8">
                <p class="text-gray-200 mb-4">
                    <i class="fa-solid fa-info-circle text-blue-400 mr-2"></i>
                    Bạn sẽ nhận được email xác nhận khi tài khoản được duyệt.
                </p>
                <p class="text-gray-300 text-sm">
                    Thời gian xử lý thường từ 1-24 giờ.
                </p>
            </div>

            <!-- Contact Info -->
            <div class="bg-gray-800/50 rounded-xl p-6 mb-8">
                <p class="text-gray-300 mb-3">Nếu có vấn đề, vui lòng liên hệ:</p>
                <a href="mailto:tn7410311@gmail.com" class="text-red-500 hover:text-red-400 font-bold text-lg transition-colors">
                    tn7410311@gmail.com
                </a>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col gap-3">
                <a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-500 text-white font-bold py-3 px-6 rounded-xl transition-all">
                    Quay Lại Đăng Nhập
                </a>
                <a href="{{ route('home') }}" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-xl transition-all">
                    Trang Chủ
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
