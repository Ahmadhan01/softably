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
                {{-- Nama penjual dinamis --}}
                {{ $detail->product->seller->name ?? 'Toko Tidak Dikenal' }}
              </p>
              <h2 class="text-lg font-bold">{{ $detail->product_name }}</h2> {{-- Nama produk dinamis --}}
              <p class="text-sm text-gray-400">
                {{ Str::limit($detail->product->description, 150) }} {{-- Deskripsi produk dinamis --}}
              </p>
            </div>

            <div class="flex flex-col items-end gap-2">
              {{-- Tombol "View Store" dinamis --}}
              @if($detail->product->seller)
              <a href="{{ route('view-seller.show', $detail->product->seller->id) }}" {{-- Mengarahkan ke profil seller --}}
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
            {{-- Mengambil link download atau deskripsi kedua dari produk --}}
            <span>
                @if($detail->product->download_link)
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
                $existingComment = Auth::user()->comments()->where('product_id', $firstProductDetail->product->id)->first();
            }
        @endphp

        @if($firstProductDetail) {{-- Pastikan ada produk untuk dikomentari --}}

        {{-- --- BAGIAN UNTUK MENAMPILKAN DAFTAR KOMENTAR --- --}}
        <h2 class="text-xl font-semibold mt-8 mb-4 text-white">Komentar Produk</h2>
        <div class="space-y-4">
            @forelse($firstProductDetail->product->comments->sortByDesc('created_at') as $comment)
                <div class="bg-[#1e293b] p-4 rounded-lg shadow-md flex items-start space-x-4" id="comment-item-{{ $comment->id }}">
                    <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                        <img src="{{ $comment->user->profile_picture_url ?? asset('img/man.jpg') }}" alt="{{ $comment->user->name ?? 'Pengguna' }}" class="w-full h-full object-cover">
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
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-center">Belum ada komentar untuk produk ini.</p>
            @endforelse
        </div>
        {{-- --- AKHIR BAGIAN DAFTAR KOMENTAR --- --}}


        {{-- Bagian Input Komentar Pengguna --}}
        <h2 class="text-xl font-semibold mt-8 mb-4 text-white">Berikan Komentar Anda</h2>
        {{-- HAPUS BLOK DIV INI YANG MUNCUL DI GAMBAR DENGAN KOMENTAR SAYA SENDIRI --}}
        {{-- <div class="flex justify-end mt-6"> ... </div> --}}
        {{-- Kode di atas sudah dihapus. --}}

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
                value="{{ old('content', $existingComment->content ?? '') }}"
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
        document.addEventListener('DOMContentLoaded', function() {
            const commentInput = document.getElementById('comment-input');
            const commentForm = document.getElementById('comment-form');
            const commentMethod = document.getElementById('comment-method');
            const commentButtonText = document.getElementById('comment-button-text');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Logika Edit Komentar - Menggunakan event delegation karena tombol edit ada di dalam loop
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
                    const productId = commentForm.querySelector('input[name="product_id"]').value;
                    commentForm.action = `{{ route('comments.store', $firstProductDetail->product->id ?? 0) }}`;
                    commentMethod.value = 'POST';
                    commentButtonText.textContent = 'Kirim';
                }
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
                                alert('Komentar berhasil dihapus.');
                                // Hapus elemen komentar dari DOM tanpa reload halaman
                                document.getElementById(`comment-item-${commentId}`).remove();
                                // Optional: Reset form komentar jika yang dihapus adalah komentar yang sedang diedit
                                const productId = commentForm.querySelector('input[name="product_id"]').value;
                                if (commentForm.action === `/comments/${commentId}` && commentMethod.value === 'PATCH') {
                                    commentInput.value = '';
                                    commentForm.action = `{{ route('comments.store', $firstProductDetail->product->id ?? 0) }}`;
                                    commentMethod.value = 'POST';
                                    commentButtonText.textContent = 'Kirim';
                                }
                            } else {
                                alert('Gagal menghapus komentar: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting comment:', error);
                            alert('Terjadi kesalahan saat menghapus komentar.');
                        });
                    }
                });
            });
        });
    </script>
    @endpush