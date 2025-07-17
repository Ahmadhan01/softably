@extends('layouts.sidebar-seller')

@section('title', 'Notifikasi Penjual - Softably')

@section('isi')

    <style>
        /* CSS untuk Animasi Notifikasi */
        .notification-item {
            /* Gaya dasar notifikasi Anda */
            background-color: #FFFFFF; /* Background item notifikasi jadi putih */
            border: 1px solid #E0E0E0; /* Border abu-abu terang */
            border-radius: 0.5rem; /* rounded-lg */
            padding: 1rem; /* p-4 */
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem; /* space-y-4 */
            box-shadow: 0 1px 3px rgba(0,0,0,0.05); /* Sedikit shadow */

            /* Properti untuk animasi */
            opacity: 0; /* Mulai dengan tidak terlihat */
            transform: translateY(40px); /* Mulai sedikit di bawah */
            transition: opacity 0.7s ease-out, transform 0.7s ease-out; /* Durasi dan jenis transisi */
        }

        .notification-item.show {
            opacity: 1; /* Tampilkan */
            transform: translateY(0); /* Geser ke posisi normal */
        }

        .notification-item.read {
            opacity: 0.7; /* 70% opacity untuk notifikasi yang sudah dibaca, lebih terang dari 0.6 */
        }
    </style>

{{-- Kontainer utama untuk halaman notifikasi --}}
<div class="bg-[#F8FAFC] text-gray-800 h-full flex flex-col p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Notifikasi Penjual</h1>
        <form action="{{ route('notif-seller.markAllAsRead') }}" method="POST">
            @csrf
            <button type="submit"
                class="text-sm text-blue-600 hover:text-blue-700"> {{-- Sesuaikan dengan notif-customer: text-sm text-blue-600 hover:text-blue-700 --}}
                Mark as read
            </button>
        </form>
    </div>

    {{-- Kontainer Notifikasi (mengisi sisa ruang dan bisa discroll) --}}
    <div class="bg-white p-6 rounded-lg shadow-md flex-1 overflow-y-auto border border-gray-200" id="notifications-container"> {{-- Tambahkan ID ini --}}
        @if($notifications->isEmpty())
        <p class="text-gray-600 text-center py-8">Belum ada notifikasi transaksi untuk produk Anda.</p>
        @else
        <div class="space-y-4">
            @foreach($notifications as $notification)
            @php
            $title = $notification->title;
            $message = $notification->message;
            $isRead = $notification->is_read;
            $timeAgo = $notification->created_at->diffForHumans();
            $iconClass = 'fa-solid fa-info-circle text-gray-500'; // Default icon

            if ($notification->type === 'transaction_alert') {
            $iconClass = 'fa-solid fa-receipt text-blue-600'; // Ubah warna ikon transaksi
            } elseif ($notification->type == 'chat') { // Tambahkan tipe 'chat' jika ada di notifikasi seller
            $iconClass = 'fa-solid fa-comments text-blue-600';
            }
            @endphp

            <div class="notification-item {{ $isRead ? 'read' : '' }}" id="notification-{{ $notification->id }}"> {{-- Gunakan class 'notification-item' --}}
                <div class="flex items-start space-x-4 flex-grow">
                    <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200"> {{-- Ukuran ikon dan background mirip notif customer --}}
                        <i class="{{ $iconClass }} text-3xl"></i> {{-- Ukuran ikon --}}
                    </div>
                    <div class="flex-grow">
                        <h2 class="font-semibold text-gray-800">{{ $title }}</h2>
                        <p class="text-sm text-gray-600 mt-1"> {{ $message }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1"> {{ $timeAgo }}
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0 flex items-center">
                    @if(!$isRead)
                    <button
                        class="mark-as-read-btn bg-[#2563EB] text-white text-xs font-semibold px-3 py-1 rounded hover:bg-[#3B82F6] transition" {{-- Warna tombol seperti notif customer --}}
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
        {{-- Pagination Links --}}
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const markAsReadButtons = document.querySelectorAll('.mark-as-read-btn');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // --- Logika Animasi Notifikasi ---
    const notificationsContainer = document.getElementById('notifications-container');
    if (notificationsContainer) {
        const notificationItems = notificationsContainer.querySelectorAll('.notification-item');
        notificationItems.forEach((item, index) => {
            setTimeout(() => {
                item.classList.add('show'); // Tambahkan kelas 'show' setelah penundaan
            }, index * 100); // Penundaan 100ms untuk setiap item (bisa disesuaikan)
        });
    }

    // --- Logika Mark As Read ---
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
                            notificationElement.classList.add('read'); // Tambahkan kelas 'read'
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
                        // if (window.updateNotificationBadge) { window.updateNotificationBadge(); }
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
                        document.querySelectorAll('.notification-item').forEach(element => { // Ubah selektor menjadi .notification-item
                            element.classList.add('read');
                            const checkButton = element.querySelector('.mark-as-read-btn');
                            if (checkButton) {
                                const parentDiv = checkButton.closest('.flex.items-center');
                                checkButton.remove();
                                if (parentDiv && !parentDiv.querySelector(
                                        '.text-gray-500')) {
                                    const readSpan = document.createElement('span');
                                    readSpan.classList.add('text-xs', 'text-gray-500');
                                    readSpan.textContent = 'Read';
                                    parentDiv.appendChild(readSpan);
                                }
                            }
                        });
                        console.log(data.message);
                        // Opsional: Perbarui counter notifikasi di sidebar jika ada
                        // if (window.updateNotificationBadge) { window.updateNotificationBadge(); }
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