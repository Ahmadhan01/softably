@extends('layouts.sidebar')

@section('isi')
    <div class="flex min-h-screen">
      <main class="flex-1 p-6 space-y-6 ml-64">
        {{-- Mengarahkan kembali ke daftar order, bukan hardcoded HTML --}}
        <a href="{{ route('order-customer') }}" class="text-sm text-white hover:underline">
          <i class="fa-solid fa-arrow-left"></i>&nbsp; Order Detail
        </a>

        <div class="bg-[#1e293b] p-6 rounded-lg space-y-6">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-gray-400">Order status</p>
              {{-- Menampilkan status dinamis dari transaksi --}}
              <p class="font-semibold text-white">{{ $transaction->status_label }}</p>
            </div>
            {{-- HAPUS TOMBOL "Give a Ratings" DI SINI --}}
          </div>
          <div>
            <p class="text-gray-400">Order id</p>
            {{-- Menampilkan nomor invoice dinamis --}}
            <p class="font-semibold">{{ $transaction->invoice_number }}</p>
          </div>

          {{-- Loop untuk menampilkan setiap produk dalam transaksi --}}
          @foreach($transaction->details as $detail)
          <div class="flex gap-4 border-b border-gray-700 pb-4 mb-4 last:border-b-0 last:pb-0">
            <div class="w-48 h-36 rounded-lg bg-white flex-shrink-0 overflow-hidden">
              <img
                src="{{ $detail->product_image ?? asset('img/default-product.jpg') }}" {{-- Gunakan product_image dari detail transaksi --}}
                alt="{{ $detail->product_name }}"
                class="w-full h-full object-cover rounded-lg"
              />    
            </div>

            <div class="flex-1 space-y-1">
              <p class="text-sm text-gray-400">
                {{-- Nama penjual dinamis. Menggunakan $detail->product->user karena di Product model relasinya 'user' --}}
                {{ $detail->product->user->name ?? 'Toko Tidak Dikenal' }}
              </p>
              <h2 class="text-lg font-bold">{{ $detail->product_name }}</h2> {{-- Nama produk dinamis --}}
              <p class="text-sm text-gray-400">
                {{ Str::limit($detail->product->description, 150) }} {{-- Deskripsi produk dinamis --}}
              </p>
            </div>

            <div class="flex flex-col items-end gap-2">
              {{-- Tombol "View Store" dinamis --}}
              @if($detail->product->user) {{-- Menggunakan $detail->product->user --}}
              <a href="{{ route('view-seller.show', $detail->product->user->id) }}" {{-- Mengarahkan ke profil seller --}}
                 class="border border-gray-500 text-white text-sm px-3 py-1 rounded hover:bg-gray-700">
                View Store
              </a>
              @endif

              <div class="flex flex-col items-end mt-2">
                <p class="text-sm text-gray-400">x{{ $detail->quantity }}</p> {{-- Kuantitas dinamis --}}
                <p class="text-white font-semibold">Rp. {{ number_format($detail->price, 0, ',', '.') }},00</p> {{-- Harga per unit dinamis --}}
              </div>
            </div>
          </div>

          {{-- Konten Produk (hanya ditampilkan jika transaksi selesai/completed) --}}
          @if($transaction->status === 'completed' || $transaction->status === 'finished')
          <div
            class="bg-[#334155] text-sm text-gray-200 p-3 rounded-lg flex items-center justify-between"
          >
            <span>
                {{-- PERBAIKAN DI SINI: Prioritaskan product_link, lalu download_link, lalu content_description --}}
                @if($detail->product->product_link)
                    <a href="{{ $detail->product->product_link }}" target="_blank" class="text-blue-400 hover:underline">
                        Akses Produk: {{ Str::limit($detail->product->product_link, 100) }}
                    </a>
                @elseif($detail->product->download_link)
                    <a href="{{ $detail->product->download_link }}" target="_blank" class="text-blue-400 hover:underline">
                        Unduh Konten: {{ $detail->product->name }}
                    </a>
                @elseif($detail->product->content_description)
                    {{ $detail->product->content_description }}
                @else
                    Konten digital akan tersedia di sini setelah pembayaran dikonfirmasi.
                @endif
            </span>
          </div>
          <div class="flex items-start justify-end">
            {{-- TOMBOL COPY DIHAPUS --}}
          </div>
          @endif
          @endforeach {{-- Akhir loop foreach details --}}


          <div class="text-sm text-gray-400 space-y-1 mt-6 pt-4 border-t border-gray-700">
            <div class="flex justify-between">
              <span>Payment method</span>
              <span class="text-white font-medium">{{ $transaction->payment_method }}</span> {{-- Metode pembayaran dinamis --}}
            </div>
            <div class="flex justify-between">
              <span>Discount</span>
              <span class="text-white font-medium">Rp. {{ number_format($transaction->discount, 0, ',', '.') }},00</span> {{-- Diskon dinamis --}}
            </div>
            <div class="flex justify-between">
              <span>Convenience fee</span>
              <span class="text-white font-medium">Rp. {{ number_format($transaction->convenience_fee, 0, ',', '.') }},00</span> {{-- Convenience fee dinamis --}}
            </div>
          </div>

          <div class="flex justify-between items-center text-lg font-bold mt-2">
            <span>Total</span>
            <span class="text-orange-400">Rp. {{ number_format($transaction->total_amount, 0, ',', '.') }},00</span> {{-- Total dinamis --}}
          </div>
        </div>

        {{-- Bagian Komentar - Asumsi untuk produk pertama dalam transaksi. Sesuaikan jika perlu --}}
        @php
            $firstProductDetail = $transaction->details->first(); // Ambil detail produk pertama untuk komentar
            // Variabel $existingComment ini TIDAK lagi digunakan untuk menampilkan komentar,
            // tetapi bisa tetap digunakan untuk mengisi nilai default di form input jika diperlukan.
            $existingComment = null;
            if ($firstProductDetail) {
                // Perbaikan: Pastikan $firstProductDetail->product tidak null sebelum mengakses comments
                if ($firstProductDetail->product) {
                    $existingComment = Auth::user()->comments()->where('product_id', $firstProductDetail->product->id)->first();
                }
            }
        @endphp

        @if($firstProductDetail && $firstProductDetail->product) {{-- Pastikan ada produk dan relasinya --}}

        {{-- --- BAGIAN UNTUK MENAMPILKAN DAFTAR KOMENTAR --- --}}
        <h2 class="text-xl font-semibold mt-8 mb-4 text-white">Komentar Produk</h2>
        <div class="space-y-4">
            {{-- UBAH INI: Pastikan komentar top-level dimuat, bukan semua komentar --}}
            @forelse($firstProductDetail->product->comments->whereNull('parent_id')->sortByDesc('created_at') as $comment)
                <div class="bg-[#1e293b] p-4 rounded-lg shadow-md flex items-start space-x-4" id="comment-item-{{ $comment->id }}">
                    <div class="w-10 h-10 rounded-full overflow-hidden">
                                {{-- Gunakan $comment->user->profile_picture_url --}}
                                <img src="{{ $comment->user->profile_picture_url ?? asset('img/default-profile.png') }}" alt="User Profile"
                                    class="w-full h-full object-cover">
                            </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-white">{{ $comment->user->name ?? 'Pengguna Anonim' }}</p>
                            <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                        <p class="text-sm text-gray-300 mt-1" id="comment-content-{{ $comment->id }}">{{ $comment->content }}</p>
                        {{-- Opsi Edit/Hapus Komentar (hanya untuk komentar milik user yang login) --}}
                        @if(Auth::id() === $comment->user_id)
                            <div class="mt-2 text-right space-x-2">
                                <button class="text-white/70 hover:text-white text-xs edit-comment-btn" data-comment-id="{{ $comment->id }}" data-comment-content="{{ $comment->content }}">
                                    <i class="fas fa-pen text-xs"></i> Edit
                                </button>
                                <button class="text-red-500 hover:text-red-600 text-xs delete-comment-btn" data-comment-id="{{ $comment->id }}">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </div>
                        @endif
                        {{-- Balasan Komentar --}}
                        @foreach($comment->replies->sortBy('created_at') as $reply)
                        <div class="flex space-x-4 ml-14 mt-4"> {{-- Indent untuk balasan --}}
                            <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-600 flex-shrink-0">
                                <img src="{{ $reply->user->profile_picture_url ?? asset('img/default-profile.png') }}" alt="User Profile"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="font-semibold text-white text-sm">{{ $reply->user->name ?? 'User Tidak Dikenal' }}</p>
                                    @auth
                                    <div class="text-xs text-gray-500 space-x-2">
                                        @if (Auth::id() === $reply->user_id)
                                        <button class="text-white/70 hover:text-white edit-comment-btn"
                                            data-comment-id="{{ $reply->id }}"
                                            data-comment-content="{{ $reply->content }}">
                                            <i class="fas fa-pen text-xs"></i> Edit
                                        </button>
                                        @endif
                                        @if (Auth::id() === $reply->user_id || Auth::id() === $firstProductDetail->product->user_id)
                                        <button class="text-red-500 hover:text-red-400 delete-comment-btn"
                                            data-comment-id="{{ $reply->id }}">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                        @endif
                                    </div>
                                    @endauth
                                </div>
                                <p class="text-xs text-gray-300 mt-1" id="comment-content-display-{{ $reply->id }}">
                                    {{ $reply->content }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $reply->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-center">Belum ada komentar untuk produk ini.</p>
            @endforelse
        </div>
        {{-- --- AKHIR BAGIAN DAFTAR KOMENTAR --- --}}


        {{-- Bagian Input Komentar Pengguna --}}
        <h2 class="text-xl font-semibold mt-8 mb-4 text-white">Berikan Komentar Anda</h2>

        {{-- Form untuk mengirim/mengedit komentar --}}
        <form id="comment-form" action="{{ route('comments.store', $firstProductDetail->product->id) }}" method="POST" class="flex items-center gap-2">
            @csrf
            <input type="hidden" name="product_id" value="{{ $firstProductDetail->product->id }}">
            <input type="hidden" name="_method" id="comment-method" value="POST"> {{-- Default POST, bisa jadi PATCH --}}

            <input
                type="text"
                name="content"
                id="comment-input"
                placeholder="Berikan Komentar Anda..."
                class="flex-1 p-3 rounded-md bg-[#1F2A40] text-white border border-gray-600 focus:outline-none"
                value=""
                required
            />
            <button type="submit" class="bg-green-500 px-4 py-2 rounded-md hover:bg-green-400">
                <i class="fa-solid fa-paper-plane"></i> <span id="comment-button-text">Kirim</span>
            </button>
        </form>
        @error('content')
            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
        @enderror
        @endif

      </main>
    </div>
    @endsection

    @push('scripts')
    <script>
        // Pastikan Anda memiliki fungsi showToast di layouts/sidebar.blade.php
        // atau definisi global di tempat lain. Jika tidak, tambahkan di sini.
        function showToast(message, type = 'success') {
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                const newToastContainer = document.createElement('div');
                newToastContainer.id = 'toast-container';
                newToastContainer.classList.add('fixed', 'bottom-4', 'right-4', 'z-[9999]', 'space-y-2');
                document.body.appendChild(newToastContainer);
                toastContainer = newToastContainer;
            }

            const toast = document.createElement('div');
            toast.classList.add(
                'flex', 'items-center', 'gap-2', 'px-4', 'py-2', 'rounded-md', 'shadow-md', 'text-white',
                type === 'success' ? 'bg-green-500' : 'bg-red-500',
                'transform', 'translate-x-full', 'transition-transform', 'duration-300'
            );
            toast.innerHTML =
                `<i class="fa-solid ${type === 'success' ? 'fa-check-circle' : 'fa-times-circle'}"></i> <span>${message}</span>`;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);

            setTimeout(() => {
                toast.classList.add('translate-x-full');
                toast.addEventListener('transitionend', () => toast.remove());
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Variabel-variabel untuk form komentar
            const commentInput = document.getElementById('comment-input');
            const commentForm = document.getElementById('comment-form');
            const commentMethod = document.getElementById('comment-method');
            const commentButtonText = document.getElementById('comment-button-text');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Logika Edit Komentar - Menggunakan event delegation untuk tombol edit
            // Ini hanya mengisi form untuk diedit, tidak mengirim form
            document.querySelectorAll('.edit-comment-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.dataset.commentId;
                    const commentContent = this.dataset.commentContent; // Ambil konten dari data attribute
                    
                    commentInput.value = commentContent; // Isi input dengan konten komentar yang ingin diedit
                    commentForm.action = `/comments/${commentId}`; // Ganti action ke update rute
                    commentMethod.value = 'PATCH'; // Ganti method ke PATCH
                    commentButtonText.textContent = 'Update'; // Ubah teks tombol
                    commentInput.focus();
                });
            });

            // Reset form jika input dikosongkan setelah edit atau saat form dikirim
            commentInput.addEventListener('input', function() {
                if (this.value === '' && commentMethod.value === 'PATCH') {
                    // Kembali ke action store dengan product ID
                    // Menggunakan $firstProductDetail->product->id dari PHP (pastikan tidak null)
                    commentForm.action = `{{ route('comments.store', $firstProductDetail->product->id ?? 0) }}`;
                    commentMethod.value = 'POST';
                    commentButtonText.textContent = 'Kirim';
                }
            });

            // Logika pengiriman form (baik untuk tambah baru maupun update)
            // Ini menangani submit form baik saat POST (tambah baru) maupun PATCH (update)
            commentForm.addEventListener('submit', function(event) {
                event.preventDefault(); // <-- INI KUNCI UTAMA UNTUK MENCEGAH PENGALIHAN

                const url = commentForm.action;
                const method = commentMethod.value;
                const content = commentInput.value;
                // Ambil product_id dari hidden input di form
                const productId = commentForm.querySelector('input[name="product_id"]').value; 

                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        content: content,
                        product_id: productId // Kirim product_id juga untuk update jika diperlukan di backend
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        // Tangani respons non-OK (misal: validasi gagal, unauthorized)
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || 'Gagal menyimpan komentar.');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');

                        if (method === 'PATCH') {
                            // Update tampilan komentar yang sudah ada di DOM
                            const commentIdToUpdate = url.split('/').pop(); // Ambil ID dari URL
                            const commentContentDisplay = document.getElementById(`comment-content-${commentIdToUpdate}`); // Gunakan ID yang benar
                            if (commentContentDisplay) {
                                commentContentDisplay.textContent = content; // Perbarui teks komentar di DOM
                            }
                        }
                        // Reset form setelah sukses
                        commentInput.value = '';
                        commentForm.action = `{{ route('comments.store', $firstProductDetail->product->id ?? 0) }}`;
                        commentMethod.value = 'POST';
                        commentButtonText.textContent = 'Kirim';
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error submitting comment:', error);
                    showToast('Terjadi kesalahan saat menyimpan komentar: ' + error.message, 'error');
                });
            });

            // Logika Hapus Komentar - Menggunakan event delegation
            document.querySelectorAll('.delete-comment-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.dataset.commentId;
                    if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
                        fetch(`/comments/${commentId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Komentar berhasil dihapus.', 'success');
                                // Hapus elemen komentar dari DOM tanpa reload halaman
                                document.getElementById(`comment-item-${commentId}`).remove();
                                // Optional: Reset form komentar jika yang dihapus adalah komentar yang sedang diedit
                                if (commentForm.action === `/comments/${commentId}` && commentMethod.value === 'PATCH') {
                                    commentInput.value = '';
                                    commentForm.action = `{{ route('comments.store', $firstProductDetail->product->id ?? 0) }}`;
                                    commentMethod.value = 'POST';
                                    commentButtonText.textContent = 'Kirim';
                                }
                            } else {
                                showToast('Gagal menghapus komentar: ' + data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting comment:', error);
                            showToast('Terjadi kesalahan saat menghapus komentar.', 'error');
                        });
                    }
                });
            });
        });
    </script>
    @endpush