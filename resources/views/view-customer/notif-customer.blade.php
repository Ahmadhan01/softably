@extends('layouts.sidebar')

@section('isi')

    <div class="flex min-h-screen">
      <main class="flex-1 p-6 space-y-6 ml-64">
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold">Notification</h1>
          <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm text-gray-300 hover:text-white">
              Mark as read
            </button>
          </form>
        </div>

        <div class="space-y-4">
          @forelse ($notifications as $notification)
          <div
            class="bg-[#1e293b] border border-gray-700 rounded-lg p-4 flex justify-between items-start
            {{ $notification->is_read ? 'opacity-60' : '' }}" {{-- Opacity jika sudah dibaca --}}
            id="notification-{{ $notification->id }}"
          >
            <div class="flex items-start space-x-4">
              {{-- Gambar Notifikasi (Opsional, bisa disesuaikan berdasarkan type) --}}
              <div class="w-20 h-20 bg-gray-700 rounded-lg flex-shrink-0 flex items-center justify-center">
                @if($notification->type == 'transaction')
                    <i class="fa-solid fa-receipt text-3xl text-green-400"></i>
                @elseif($notification->type == 'chat')
                    <i class="fa-solid fa-comments text-3xl text-blue-400"></i>
                @else
                    <i class="fa-solid fa-info-circle text-3xl text-gray-400"></i>
                @endif
              </div>
              <div>
                <h2 class="font-semibold text-white">{{ $notification->title }}</h2>
                <p class="text-sm text-gray-400">
                  {{ $notification->message }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $notification->created_at->diffForHumans() }}
                </p>
              </div>
            </div>
            <div class="flex items-center">
              @if(!$notification->is_read)
              <button
                class="mark-as-read-btn bg-white text-xs text-black font-semibold px-3 py-1 rounded hover:bg-gray-300 transition"
                data-notification-id="{{ $notification->id }}"
              >
                Check
              </button>
              @else
              <span class="text-xs text-gray-500">Read</span>
              @endif
            </div>
          </div>
          @empty
          <p class="text-gray-400 text-center">Tidak ada notifikasi baru.</p>
          @endforelse
        </div>

        {{-- Pagination Links --}}
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
      </main>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const markAsReadButtons = document.querySelectorAll('.mark-as-read-btn');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            markAsReadButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const notificationId = this.dataset.notificationId;
                    const notificationElement = document.getElementById(`notification-${notificationId}`);

                    fetch(`/notifications/${notificationId}/mark-as-read`, {
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
                                notificationElement.classList.add('opacity-60');
                                this.remove(); // Hapus tombol "Check"
                                // Opsional: Tambahkan tulisan "Read"
                                const parentDiv = this.closest('.flex.items-center');
                                if (parentDiv) {
                                    const readSpan = document.createElement('span');
                                    readSpan.classList.add('text-xs', 'text-gray-500');
                                    readSpan.textContent = 'Read';
                                    parentDiv.appendChild(readSpan);
                                }
                            }
                            console.log(data.message);
                            // Opsional: Perbarui counter notifikasi di sidebar
                        } else {
                            console.error(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error marking notification as read:', error);
                    });
                });
            });
        });
    </script>
    @endpush
@endsection