@extends('layouts.sidebar-seller')

@section('title', 'Notifikasi Penjual - Softably')

@section('isi')
<main class="ml-64 min-h-screen flex flex-col bg-[#10172A] text-white font-sans">
    <div class="p-8 flex-grow">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-white">Notifikasi Penjual</h1>
            <form action="{{ route('notif-seller.markAllAsRead') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-transform transform hover:scale-105">
                    <i class="fa-solid fa-check-double"></i>
                    <span>Mark as read</span>
                </button>
            </form>
        </div>

        <div class="bg-[#1E293B] p-6 rounded-lg shadow-md">
            @if($notifications->isEmpty())
            <p class="text-gray-400 text-center py-8">Belum ada notifikasi transaksi untuk produk Anda.</p>
            @else
            <div class="space-y-4">
                @foreach($notifications as $notification)
                {{-- Pastikan relasi dan data tidak null --}}
                @php
                // Mengambil data dari SellerNotification model
                $title = $notification->title;
                $message = $notification->message;
                $isRead = $notification->is_read;
                $timeAgo = $notification->created_at->diffForHumans();
                $iconClass = 'fa-solid fa-info-circle text-gray-400'; // Default icon

                if ($notification->type === 'transaction_alert') {
                $iconClass = 'fa-solid fa-receipt text-green-400';
                }
                // Tambahkan logika untuk tipe notifikasi lain jika ada
                @endphp

                <div class="bg-[#2D3A4F] p-4 rounded-lg flex justify-between items-start space-x-4
                            {{ $isRead ? 'opacity-60' : 'opacity-100' }}" {{-- Opacity berdasarkan status --}}
                    id="notification-{{ $notification->id }}">
                    <div class="flex items-start space-x-4 flex-grow">
                        <div class="flex-shrink-0 w-12 h-12 bg-gray-700 rounded-lg flex items-center justify-center">
                            <i class="{{ $iconClass }} text-2xl"></i>
                        </div>
                        <div class="flex-grow">
                            <h2 class="font-semibold text-white">{{ $title }}</h2>
                            <p class="text-sm text-gray-400 mt-1">
                                {{ $message }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $timeAgo }}
                            </p>
                        </div>
                    </div>
                    <div class="flex-shrink-0 flex items-center">
                        @if(!$isRead)
                        <button
                            class="mark-as-read-btn bg-white text-xs text-black font-semibold px-3 py-1 rounded hover:bg-gray-300 transition"
                            data-notification-id="{{ $notification->id }}">
                            Check
                        </button>
                        @else
                        <span class="text-xs text-gray-500">Read</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const markAsReadButtons = document.querySelectorAll('.mark-as-read-btn');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Event listener untuk tombol "Check" (Mark as Read per notifikasi)
    markAsReadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const notificationId = this.dataset.notificationId;
            const notificationElement = document.getElementById(
                `notification-${notificationId}`);

            fetch(`/notif-seller/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (notificationElement) {
                            notificationElement.classList.remove('opacity-100');
                            notificationElement.classList.add('opacity-60');
                            this.remove(); // Hapus tombol "Check"
                            const parentDiv = this.closest('.flex.items-center');
                            if (parentDiv) {
                                const readSpan = document.createElement('span');
                                readSpan.classList.add('text-xs', 'text-gray-500');
                                readSpan.textContent = 'Read';
                                parentDiv.appendChild(readSpan);
                            }
                        }
                        console.log(data.message);
                        // Opsional: Perbarui counter notifikasi di sidebar jika ada
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                });
        });
    });

    // Event listener untuk tombol "Mark All As Read"
    const markAllAsReadForm = document.querySelector('form[action="{{ route('notif-seller.markAllAsRead') }}"]');
    if (markAllAsReadForm) {
        markAllAsReadForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah submit form default

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Perbarui semua notifikasi di UI
                        document.querySelectorAll('.bg-[#2D3A4F]').forEach(element => {
                            element.classList.remove('opacity-100');
                            element.classList.add('opacity-60');
                            // Hapus semua tombol "Check" dan ganti dengan "Read"
                            const checkButton = element.querySelector('.mark-as-read-btn');
                            if (checkButton) {
                                const parentDiv = checkButton.closest('.flex.items-center');
                                checkButton.remove();
                                if (parentDiv && !parentDiv.querySelector(
                                        '.text-gray-500')) { // Hindari duplikasi "Read"
                                    const readSpan = document.createElement('span');
                                    readSpan.classList.add('text-xs', 'text-gray-500');
                                    readSpan.textContent = 'Read';
                                    parentDiv.appendChild(readSpan);
                                }
                            }
                        });
                        console.log(data.message);
                        // Opsional: Perbarui counter notifikasi di sidebar jika ada
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error marking all notifications as read:', error);
                });
        });
    }
});
</script>
@endpush