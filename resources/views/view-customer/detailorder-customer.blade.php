@extends('layouts.sidebar')

@section('isi')
    <div class="flex min-h-screen">
      {{-- Hapus ml-64 dari main --}}
      <main class="flex-1 p-6 space-y-6 ml-64 bg-[#F8FAFC] text-[#333333]"> {{-- Mengarahkan kembali ke daftar order, bukan hardcoded HTML --}}
        <a href="{{ route('order-customer') }}" class="text-sm text-gray-700 hover:underline"> <i class="fa-solid fa-arrow-left"></i>&nbsp; Order Detail
        </a>

        <div class="bg-white p-6 rounded-lg space-y-6 shadow-md border border-gray-200"> <div class="flex items-start justify-between">
            <div>
              <p class="text-gray-600">Order status</p> {{-- Menampilkan status dinamis dari transaksi --}}
              <p class="font-semibold text-gray-800">{{ $transaction->status_label }}</p> </div>
            {{-- HAPUS TOMBOL "Give a Ratings" DI SINI --}}
          </div>
          <div>
            <p class="text-gray-600">Order id</p> {{-- Menampilkan nomor invoice dinamis --}}
            <p class="font-semibold text-gray-800">{{ $transaction->invoice_number }}</p> </div>

          {{-- Loop untuk menampilkan setiap produk dalam transaksi --}}
          @foreach($transaction->details as $detail)
          <div class="flex gap-4 border-b border-gray-300 pb-4 mb-4 last:border-b-0 last:pb-0">
            <div class="w-36 order-product-image-container bg-gray-100 flex-shrink-0"> <img src="{{ $detail->product->image_url ?? asset('img/default-product.jpg') }}" {{-- Gunakan accessor image_url dari model Product --}}
                alt="{{ $detail->product_name }}"
                class="w-full h-full object-cover rounded-lg"
              />    
            </div>

            <div class="flex-1 space-y-1">
              <p class="text-sm text-gray-600"> {{ $detail->product->user->name ?? 'Toko Tidak Dikenal' }}
              </p>
              <h2 class="text-lg font-bold text-gray-900">{{ $detail->product_name }}</h2> {{-- Nama produk dinamis, jadi hitam/sangat gelap --}}
              <p class="text-sm text-gray-600"> {{ Str::limit($detail->product->description, 150) }}
              </p>
            </div>

            <div class="flex flex-col items-end gap-2">
                {{-- Tombol "View Store" dinamis --}}
                @if($detail->product->user) {{-- Menggunakan $detail->product->user --}}
                <div class="flex gap-2"> {{-- Tombol Chat Seller --}}
                    <a href="{{ route('chat.withSellerRedirect', ['seller' => $detail->product->user->id]) }}"
                    class="border border-blue-500 text-blue-500 text-sm px-3 py-1 rounded hover:bg-blue-500 hover:text-white">
                    Chat
                    </a>
                    {{-- Tombol "View Store" dinamis --}}
                    <a href="{{ route('view-seller.show', $detail->product->user->id) }}" {{-- Mengarahkan ke profil seller --}}
                    class="border border-gray-300 text-gray-700 text-sm px-3 py-1 rounded hover:bg-gray-200"> View Store
                    </a>
                </div>
                @endif

              <div class="flex flex-col items-end mt-2">
                <p class="text-sm text-gray-600">x{{ $detail->quantity }}</p> <p class="text-gray-800 font-semibold">Rp. {{ number_format($detail->price, 0, ',', '.') }},00</p> </div>
            </div>
          </div>

          {{-- Konten Produk (hanya ditampilkan jika transaksi selesai/completed) --}}
          @if($transaction->status === 'completed' || $transaction->status === 'finished')
          <div
            class="bg-gray-100 text-gray-700 text-sm p-3 rounded-lg flex items-center justify-between border border-gray-300" >
            <span>
                {{-- PERBAIKAN DI SINI: Prioritaskan product_link, lalu download_link, lalu content_description --}}
                @if($detail->product->product_link)
                    <a href="{{ $detail->product->product_link }}" target="_blank" class="text-blue-600 hover:underline"> Akses Produk: {{ Str::limit($detail->product->product_link, 100) }}
                    </a>
                @elseif($detail->product->download_link)
                    <a href="{{ $detail->product->download_link }}" target="_blank" class="text-blue-600 hover:underline"> Unduh Konten: {{ $detail->product->name }}
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


          <div class="text-sm text-gray-600 space-y-1 mt-6 pt-4 border-t border-gray-300"> <div class="flex justify-between">
              <span>Payment method</span>
              <span class="text-gray-800 font-medium">{{ $transaction->payment_method }}</span> </div>
            <div class="flex justify-between">
              <span>Discount</span>
              <span class="text-gray-800 font-medium">Rp. {{ number_format($transaction->discount, 0, ',', '.') }},00</span>
            </div>
            <div class="flex justify-between">
              <span>Convenience fee</span>
              <span class="text-gray-800 font-medium">Rp. {{ number_format($transaction->convenience_fee, 0, ',', '.') }},00</span>
            </div>
          </div>

          <div class="flex justify-between items-center text-lg font-bold mt-2">
            <span>Total</span>
            <span class="text-[#2563EB]">Rp. {{ number_format($transaction->total_amount, 0, ',', '.') }},00</span> </div>
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
        <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">Komentar Produk</h2> <div class="space-y-4">
            {{-- UBAH INI: Pastikan komentar top-level dimuat, bukan semua komentar --}}
            @forelse($firstProductDetail->product->comments->whereNull('parent_id')->sortByDesc('created_at') as $comment)
                <div class="bg-white p-4 rounded-lg shadow-md flex items-start space-x-4 border border-gray-200"> <div class="w-10 h-10 rounded-full overflow-hidden">
                                {{-- Gunakan $comment->user->profile_picture_url --}}
                                <img src="{{ $comment->user->profile_picture_url ?? asset('img/default-profile.png') }}" alt="User Profile"
                                    class="w-full h-full object-cover">
                            </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-gray-800">{{ $comment->user->name ?? 'Pengguna Anonim' }}</p> <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p> </div>
                        <p class="text-sm text-gray-700 mt-1" id="comment-content-{{ $comment->id }}">{{ $comment->content }}</p> {{-- Opsi Edit/Hapus Komentar (hanya untuk komentar milik user yang login) --}}
                        @if(Auth::id() === $comment->user_id)
                            <div class="mt-2 text-right space-x-2">
                                <button class="text-gray-700 hover:text-gray-900 text-xs edit-comment-btn" data-comment-id="{{ $comment->id }}" data-comment-content="{{ $comment->content }}"> <i class="fas fa-pen text-xs"></i> Edit
                                </button>
                                <button class="text-red-600 hover:text-red-700 text-xs delete-comment-btn" data-comment-id="{{ $comment->id }}"> <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </div>
                        @endif
                        {{-- Balasan Komentar --}}
                        @foreach($comment->replies->sortBy('created_at') as $reply)
                        <div class="flex space-x-4 ml-14 mt-4 bg-gray-100 p-3 rounded-md border border-gray-200"> <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 flex-shrink-0"> <img src="{{ $reply->user->profile_picture_url ?? asset('img/default-profile.png') }}" alt="User Profile"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="font-semibold text-gray-800 text-sm">{{ $reply->user->name ?? 'User Tidak Dikenal' }}</p>
                                    @auth
                                    <div class="text-xs text-gray-600 space-x-2">
                                        @if (Auth::id() === $reply->user_id)
                                        <button class="text-gray-700 hover:text-gray-900 edit-comment-btn"
                                            data-comment-id="{{ $reply->id }}"
                                            data-comment-content="{{ $reply->content }}">
                                            <i class="fas fa-pen text-xs"></i> Edit
                                        </button>
                                        @endif
                                        @if (Auth::id() === $reply->user_id || Auth::id() === $firstProductDetail->product->user_id)
                                        <button class="text-red-600 hover:text-red-700 delete-comment-btn"
                                            data-comment-id="{{ $reply->id }}">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                        @endif
                                    </div>
                                    @endauth
                                </div>
                                <p class="text-xs text-gray-700 mt-1" id="comment-content-display-{{ $reply->id }}">
                                    {{ $reply->content }}</p>
                                <p class="text-xs text-gray-600 mt-1">
                                    {{ $reply->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-gray-600 text-center">Belum ada komentar untuk produk ini.</p> @endforelse
        </div>
        {{-- --- AKHIR BAGIAN DAFTAR KOMENTAR --- --}}


        {{-- Bagian Input Komentar Pengguna --}}
        <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">Berikan Komentar Anda</h2> {{-- Form untuk mengirim/mengedit komentar --}}
        <form id="comment-form" action="{{ route('comments.store', $firstProductDetail->product->id) }}" method="POST" class="flex items-center gap-2">
            @csrf
            <input type="hidden" name="product_id" value="{{ $firstProductDetail->product->id }}">
            <input type="hidden" name="_method" id="comment-method" value="POST"> {{-- Default POST, bisa jadi PATCH --}}

            <input
                type="text"
                name="content"
                id="comment-input"
                placeholder="Berikan Komentar Anda..."
                class="flex-1 p-3 py-2 rounded-md bg-gray-100 text-gray-800 border border-gray-300 focus:outline-none" value=""
                required
            />
            <button type="submit" class="bg-[#2563EB] px-4 py-2 rounded-md hover:bg-[#3B82F6] text-white"> <i class="fa-solid fa-paper-plane"></i> <span id="comment-button-text">Kirim</span>
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
                    const commentContent = this.dataset.commentContent;
                    
                    commentInput.value = commentContent;
                    commentForm.action = `/comments/${commentId}`;
                    commentMethod.value = 'PATCH';
                    commentButtonText.textContent = 'Update';
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
                event.preventDefault();

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
                        product_id: productId
                    })
                })
                .then(response => {
                    if (!response.ok) {
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
                            const commentIdToUpdate = url.split('/').pop();
                            const commentContentDisplay = document.getElementById(`comment-content-${commentIdToUpdate}`);
                            if (commentContentDisplay) {
                                commentContentDisplay.textContent = content;
                            }
                        }
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
                                document.getElementById(`comment-item-${commentId}`).remove();
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