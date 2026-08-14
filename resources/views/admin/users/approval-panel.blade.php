@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-white mb-2">Panel Phê Duyệt Đăng Ký</h1>
        <p class="text-gray-400">Quản lý các yêu cầu đăng ký từ người dùng mới</p>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-900/30 border border-green-500/30 rounded-lg p-4">
            <p class="text-green-400"><i class="fa-solid fa-check-circle mr-2"></i>{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-900/30 border border-red-500/30 rounded-lg p-4">
            <p class="text-red-400"><i class="fa-solid fa-exclamation-circle mr-2"></i>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Tabs -->
    <div class="mb-8">
        <div class="flex gap-4 border-b border-gray-700">
            <button onclick="showTab('pending')" class="pending-tab px-6 py-3 border-b-2 border-red-600 text-white font-bold cursor-pointer">
                <i class="fa-solid fa-hourglass-end mr-2"></i>
                Đợi Phê Duyệt
                <span class="ml-2 bg-red-600 text-white px-3 py-1 rounded-full text-sm">{{ $pendingUsers->total() }}</span>
            </button>
            <button onclick="showTab('approved')" class="approved-tab px-6 py-3 border-b-2 border-transparent text-gray-400 hover:text-white font-bold cursor-pointer">
                <i class="fa-solid fa-check-double mr-2"></i>
                Đã Phê Duyệt
                <span class="ml-2 bg-green-600 text-white px-3 py-1 rounded-full text-sm">{{ $approvedUsers->total() }}</span>
            </button>
        </div>
    </div>

    <!-- Pending Users -->
    <div id="pending-content" class="tab-content">
        @if ($pendingUsers->count() > 0)
            <div class="space-y-6">
                @foreach ($pendingUsers as $user)
                    <div class="bg-gray-900 border border-gray-700 rounded-lg p-6 hover:border-gray-600 transition-all">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <!-- User Info -->
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-white mb-2">{{ $user->fullname }}</h3>
                                <div class="space-y-1 text-gray-300">
                                    <p>
                                        <i class="fa-solid fa-envelope text-red-500 mr-2"></i>
                                        <a href="mailto:{{ $user->email }}" class="hover:text-red-400">{{ $user->email }}</a>
                                    </p>
                                    @if ($user->phone)
                                        <p>
                                            <i class="fa-solid fa-phone text-blue-500 mr-2"></i>
                                            {{ $user->phone }}
                                        </p>
                                    @endif
                                    <p>
                                        <i class="fa-solid fa-calendar text-gray-500 mr-2"></i>
                                        Đăng ký: {{ $user->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3">
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-500 text-white font-bold py-2 px-6 rounded-lg transition-all flex items-center gap-2">
                                        <i class="fa-solid fa-check"></i>
                                        Phê Duyệt
                                    </button>
                                </form>
                                <button onclick="showRejectModal({{ $user->id }}, '{{ $user->fullname }}')" class="bg-red-600 hover:bg-red-500 text-white font-bold py-2 px-6 rounded-lg transition-all flex items-center gap-2">
                                    <i class="fa-solid fa-times"></i>
                                    Từ Chối
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $pendingUsers->links() }}
            </div>
        @else
            <div class="bg-gray-900 border border-gray-700 rounded-lg p-12 text-center">
                <i class="fa-solid fa-inbox text-5xl text-gray-600 mb-4"></i>
                <p class="text-gray-400 text-lg">Không có yêu cầu đăng ký nào đang chờ phê duyệt</p>
            </div>
        @endif
    </div>

    <!-- Approved Users -->
    <div id="approved-content" class="tab-content hidden">
        @if ($approvedUsers->count() > 0)
            <div class="space-y-6">
                @foreach ($approvedUsers as $user)
                    <div class="bg-gray-900 border border-green-700/30 rounded-lg p-6 hover:border-green-600/50 transition-all">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <!-- User Info -->
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-white mb-2 flex items-center gap-2">
                                    {{ $user->fullname }}
                                    <span class="bg-green-600 text-white text-xs px-3 py-1 rounded-full">
                                        <i class="fa-solid fa-check-circle mr-1"></i>
                                        Đã Phê Duyệt
                                    </span>
                                </h3>
                                <div class="space-y-1 text-gray-300">
                                    <p>
                                        <i class="fa-solid fa-envelope text-red-500 mr-2"></i>
                                        {{ $user->email }}
                                    </p>
                                    @if ($user->phone)
                                        <p>
                                            <i class="fa-solid fa-phone text-blue-500 mr-2"></i>
                                            {{ $user->phone }}
                                        </p>
                                    @endif
                                    <p>
                                        <i class="fa-solid fa-check-double text-green-500 mr-2"></i>
                                        Phê duyệt: {{ $user->approved_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $approvedUsers->links() }}
            </div>
        @else
            <div class="bg-gray-900 border border-gray-700 rounded-lg p-12 text-center">
                <i class="fa-solid fa-inbox text-5xl text-gray-600 mb-4"></i>
                <p class="text-gray-400 text-lg">Chưa có người dùng nào được phê duyệt</p>
            </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center">
    <div class="bg-gray-900 border border-gray-700 rounded-lg p-8 max-w-md w-full mx-4">
        <h2 class="text-2xl font-bold text-white mb-4">Từ Chối Đăng Ký</h2>
        <p class="text-gray-300 mb-6">
            Bạn sắp từ chối tài khoản của <span id="rejectUserName" class="font-bold text-red-400"></span>. Vui lòng nhập lý do:
        </p>

        <form id="rejectForm" method="POST" class="space-y-4">
            @csrf
            <textarea name="rejection_reason" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 text-white rounded-lg focus:border-red-500 focus:outline-none" rows="4" placeholder="Lý do từ chối..." required></textarea>
            <div class="flex gap-3">
                <button type="button" onclick="closeRejectModal()" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-all">
                    Hủy
                </button>
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-500 text-white font-bold py-2 px-4 rounded-lg transition-all">
                    Từ Chối
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showTab(tab) {
    // Hide all content
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    // Remove active state from all tabs
    document.querySelectorAll('.pending-tab, .approved-tab').forEach(el => {
        el.classList.remove('border-red-600', 'border-green-600', 'text-white');
        el.classList.add('border-transparent', 'text-gray-400', 'hover:text-white');
    });

    // Show selected content
    document.getElementById(tab + '-content').classList.remove('hidden');

    // Mark tab as active
    if (tab === 'pending') {
        document.querySelector('.pending-tab').classList.add('border-red-600', 'text-white');
    } else {
        document.querySelector('.approved-tab').classList.add('border-green-600', 'text-white');
    }
}

function showRejectModal(userId, userName) {
    document.getElementById('rejectUserName').textContent = userName;
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectForm').action = `/admin/users/${userId}/reject`;
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectForm').reset();
}

// Close modal when clicking outside
document.getElementById('rejectModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>

<style>
    .tab-content {
        transition: opacity 0.3s ease;
    }
    .tab-content.hidden {
        display: none;
    }
</style>
@endsection
