@extends('layouts.sidebar')

@section('isi')
{{-- HAPUS TAG <!DOCTYPE html>, <html>, <head>, dan <body> DARI SINI --}}
{{-- Tag-tag tersebut sudah ada di layouts/sidebar.blade.php --}}

{{-- CSS Anda (jika ada yang spesifik untuk halaman ini) bisa diletakkan di sini,
         tetapi sebaiknya di file CSS terpisah atau di bagian <head> dari sidebar.blade.php --}}
<style>
.scrollable::-webkit-scrollbar {
    width: 6px;
}

.scrollable::-webkit-scrollbar-thumb {
    background-color: #4b5563;
    border-radius: 3px;
}

/* Styling for the main product image container (1:1 aspect ratio) */
.main-product-image-container {
    width: 100%;
    padding-bottom: 100%;
    position: relative;
    overflow: hidden;
    border-radius: 0.5rem;
    border: 2px solid white;
}

.main-product-image-container img.main-product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0.5rem;
}

/* Styling for thumbnail images (already 1:1 by w-16 h-16 classes) */
.thumbnail-image-container {
    width: 4rem;
    height: 4rem;
    position: relative;
    overflow: hidden;
    border: 2px solid white;
    border-radius: 0.5rem;
}

.thumbnail-image-container img.thumbnail-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0.5rem;
}

/* Style for Toast notifications (pastikan ini konsisten di seluruh aplikasi) */
.toast-container {
    position: fixed;
    bottom: 1rem;
    right: 1rem;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    align-items: flex-end;
}

.toast {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border-radius: 0.375rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    color: white;
    transform: translateX(100%);
    transition: transform 0.3s ease-out;
}

.toast.show {
    transform: translateX(0);
}
</style>

<main class="flex-1 px-6 py-8 ml-64 bg-[#10172A] min-h-screen">
    <div class="max-w-5xl mx-auto space-y-6">
        <a href="{{ route('customer.produk') }}" class="text-sm text-white hover:underline"><i
                class="fa-solid fa-arrow-left"></i> View Product</a>

        <div class="bg-[#1C2438] p-6 rounded-xl shadow-md space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="main-product-image-container bg-white">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name ?? 'Product Image' }}"
                            class="main-product-image" />
                        <div
                            class="absolute top-3 right-3 w-8 h-8 bg-orange-400 text-white rounded-full flex items-center justify-center shadow-lg ring-2 ring-white">
                            <i class="fa-solid fa-bookmark text-sm"></i>
                        </div>
                    </div>
                    <div class="flex gap-2 justify-center">
                        <div class="thumbnail-image-container bg-white">
                            <img src="{{ $product->image_url }}" alt="Thumbnail 1" class="thumbnail-image" />
                        </div>
                        <div class="thumbnail-image-container bg-white">
                            <img src="{{ $product->image_url }}" alt="Thumbnail 2" class="thumbnail-image" />
                        </div>
                        <div class="thumbnail-image-container bg-white">
                            <img src="{{ $product->image_url }}" alt="Thumbnail 3" class="thumbnail-image" />
                        </div>
                        <div class="thumbnail-image-container bg-white">
                            <img src="{{ $product->image_url }}" alt="Thumbnail 4" class="thumbnail-image" />
                        </div>
                        <div class="thumbnail-image-container bg-white">
                            <img src="{{ $product->image_url }}" alt="Thumbnail 5" class="thumbnail-image" />
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                {{-- Foto Profil Seller --}}
                                <div class="w-8 h-8 rounded-full overflow-hidden">
                                        <img src="{{ $product->seller->profile_picture_url ?? asset('img/default-profile.png') }}"
                                            alt="Seller Avatar" class="w-full h-full object-cover rounded-full" />
                                    </div>
                                {{-- Nama Toko/Seller --}}
                                <span class="font-semibold">{{ $product->seller->name ?? 'Toko Tidak Dikenal' }}</span>
                            </div>
                            <button class="bg-gray-700 px-3 py-1 text-sm rounded-md hover:bg-gray-600">
                                View Store
                            </button>
                        </div>

                        <h2 class="text-2xl font-bold">{{ $product->name ?? 'Nama Produk' }}</h2>

                        <div class="text-sm text-gray-400 max-h-64 overflow-y-auto pr-2 scrollable">
                            <p>
                                {{ $product->description ?? 'Deskripsi produk belum ada.' }}
                            </p>
                        </div>
                        <br />
                        <span class="text-2xl font-bold text-yellow-400">
                            Rp. {{ number_format($product->price ?? 0, 2, ',', '.') }}
                        </span>
                    </div>

                    <div class="mt-6 flex items-center justify-end">
                        <div class="flex gap-3">
                            {{-- Tombol Add to Wishlist --}}
                            @auth
                            <button id="addToWishlistBtn" data-product-id="{{ $product->id }}"
                                class="px-4 py-2 text-white rounded-md transition-colors duration-200
                                        {{ Auth::user()->hasInWishlist($product->id) ? 'bg-orange-500 hover:bg-orange-600' : 'bg-gray-600 hover:bg-gray-500' }}">
                                <i class="fa-solid fa-bookmark mr-2"></i>
                                <span id="wishlistButtonText">
                                    {{ Auth::user()->hasInWishlist($product->id) ? 'Remove from Wishlist' : 'Add to Wishlist' }}
                                </span>
                            </button>
                            @endauth
                            @guest
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-500">
                                <i class="fa-solid fa-bookmark mr-2"></i> Add to Wishlist
                            </a>
                            @endguest


                            <button id="addToCartBtn" data-product-id="{{ $product->id }}"
                                class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-500">
                                Add to cart
                            </button>
                            <button id="buyNowBtn" data-product-id="{{ $product->id }}"
                                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-400">
                                Buy Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="text-lg font-semibold">Comments</h3>

                {{-- Form untuk Menambah/Mengedit Komentar --}}
                @auth
                <form id="comment-form" action="{{ route('comments.store', $product->id) }}" method="POST"
                    class="flex items-center gap-2">
                    @csrf
                    <input type="hidden" name="_method" id="comment-method" value="POST"> {{-- Untuk PATCH --}}
                    <input type="hidden" name="product_id" value="{{ $product->id }}"> {{-- Pastikan product_id ada --}}

                    {{-- Foto Profil User Customer di Komentar --}}
                    <div class="w-10 h-10 rounded-full overflow-hidden">
                                {{-- Gunakan Auth::user() untuk gambar profil --}}
                                @php
                                $imagePath = Auth::user()->profile_picture
                                ? url('storage/profile/' . Auth::user()->profile_picture)
                                : asset('img/man.jpg');
                                @endphp
                                <img src="{{ url('profile/' . Auth::user()->profile_picture) . '?t=' . time() }}">
                            </div>
                    <input type="text" name="content" id="comment-input" placeholder="Write a comment..."
                        class="flex-1 p-3 rounded-md bg-[#1F2A40] text-white border border-gray-600 focus:outline-none @error('content') border-red-500 @enderror"
                        value="" {{-- Tidak perlu old() atau $existingComment di sini, akan diisi via JS untuk edit --}}
                        required />
                    <button type="submit" class="bg-green-500 px-4 py-2 rounded-md hover:bg-green-400">
                        <i class="fa-solid fa-paper-plane"></i> <span id="comment-button-text">Kirim</span>
                    </button>
                </form>
                @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @else
                <p class="text-gray-400 text-sm">Silakan <a href="{{ route('login') }}"
                        class="text-blue-400 hover:underline">login</a> untuk berkomentar.</p>
                @endauth

                {{-- Tampilkan Daftar Komentar --}}
                <div class="space-y-4">
                    @forelse ($product->comments->sortByDesc('created_at') as $comment)
                    {{-- Gunakan comments dari product yang sudah dimuat --}}
                    <div class="flex gap-3 bg-[#1F2A40] p-3 rounded-md" id="comment-item-{{ $comment->id }}">
                        {{-- Foto Profil Komentator --}}
                        <div class="w-10 h-10 rounded-full overflow-hidden">
                                {{-- Gunakan Auth::user() untuk gambar profil --}}
                                @php
                                $imagePath = Auth::user()->profile_picture
                                ? url('storage/profile/' . Auth::user()->profile_picture)
                                : asset('img/man.jpg');
                                @endphp
                                <img src="{{ url('profile/' . Auth::user()->profile_picture) . '?t=' . time() }}">
                            </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold">{{ $comment->user->name ?? 'User Tidak Dikenal' }}</p>
                                @auth
                                @if (Auth::id() === $comment->user_id)
                                <div class="text-xs text-gray-500 space-x-2">
                                    <button class="text-white/70 hover:text-white edit-comment-btn"
                                        data-comment-id="{{ $comment->id }}"
                                        data-comment-content="{{ $comment->content }}">
                                        <i class="fas fa-pen text-xs"></i> Edit
                                    </button>
                                    <button class="text-red-500 hover:text-red-400 delete-comment-btn"
                                        data-comment-id="{{ $comment->id }}">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </div>
                                @endif
                                @endauth
                            </div>
                            <p class="text-sm text-gray-300 mt-1" id="comment-content-display-{{ $comment->id }}">
                                {{ $comment->content }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $comment->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-400 text-center">Belum ada komentar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
// Fungsi showToast sudah benar, pastikan ada di layouts/sidebar.blade.php atau di sini
// Jika belum ada di layouts/sidebar.blade.php, tambahkan di sini
// function showToast(message, type = 'success') { ... }

document.addEventListener('DOMContentLoaded', function() {
    const addToCartBtn = document.getElementById('addToCartBtn');
    const buyNowBtn = document.getElementById('buyNowBtn');
    const addToWishlistBtn = document.getElementById('addToWishlistBtn');
    const productId = addToCartBtn.dataset.productId;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const wishlistButtonText = document.getElementById('wishlistButtonText');

    // Fungsi showToast (jika belum ada di layout utama, perlu didefinisikan di sini atau di file JS terpisah)
    // Saya asumsikan Anda akan memindahkannya ke layouts/sidebar.blade.php atau ke asset JS global
    // Untuk memastikan kode ini bekerja, saya sertakan definisinya di sini.
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


    // Handle Add to Wishlist button click (kode sudah benar)
    if (addToWishlistBtn) {
        addToWishlistBtn.addEventListener('click', function(event) {
            event.preventDefault();

            const url = '{{ route("wishlist.store") }}';

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.message ||
                                'Gagal mengubah status wishlist.');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (data.action === 'removed') {
                            this.classList.remove('bg-orange-500', 'hover:bg-orange-600');
                            this.classList.add('bg-gray-600', 'hover:bg-gray-500');
                            if (wishlistButtonText) {
                                wishlistButtonText.textContent = 'Add to Wishlist';
                            }
                            showToast('Produk dihapus dari wishlist.', 'success');
                        } else if (data.action === 'added') {
                            this.classList.remove('bg-gray-600', 'hover:bg-gray-500');
                            this.classList.add('bg-orange-500', 'hover:bg-orange-600');
                            if (wishlistButtonText) {
                                wishlistButtonText.textContent = 'Remove from Wishlist';
                            }
                            showToast('Produk ditambahkan ke wishlist.', 'success');
                        }
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error toggling wishlist:', error);
                    showToast('Gagal mengubah status wishlist: ' + error.message, 'error');
                });
        });
    }


    // Handle Add to Cart button click (kode sudah benar)
    addToCartBtn.addEventListener('click', function(event) {
        event.preventDefault();

        fetch('/cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message ||
                            'Gagal menambahkan produk ke keranjang.');
                    });
                }
                return response.json();
            })
            .then(data => {
                showToast(data.message, 'success');
                console.log('Respons server:', data);
            })
            .catch(error => {
                console.error('Ada masalah dengan operasi fetch:', error);
                showToast('Error: ' + error.message, 'error');
            });
    });

    // For "Buy Now" button (kode sudah benar)
    buyNowBtn.addEventListener('click', function(event) {
        event.preventDefault();
        fetch('/cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message ||
                            'Gagal menambahkan produk ke keranjang untuk pembelian.');
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Produk berhasil ditambahkan ke keranjang (untuk Buy Now):', data);
                window.location.href = "{{ route('checkout-customer.index') }}";
            })
            .catch(error => {
                console.error('Ada masalah saat Buy Now:', error);
                showToast('Error Buy Now: ' + error.message, 'error');
            });
    });

    // --- Logika Komentar: Edit dan Hapus ---
    const commentInput = document.getElementById('comment-input');
    const commentForm = document.getElementById('comment-form');
    const commentMethod = document.getElementById('comment-method');
    const commentButtonText = document.getElementById('comment-button-text');

    // Konsolidasikan event listener untuk pengiriman form (store dan update)
    // Ini menangani submit form baik saat POST (tambah baru) maupun PATCH (update)
    commentForm.addEventListener('submit', function(event) { //
        event.preventDefault(); // <-- Ini kunci untuk mencegah pengalihan

        const url = commentForm.action; //
        const method = commentMethod.value; //
        const content = commentInput.value; //
        const productId = commentForm.querySelector('input[name="product_id"]').value; //

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
                    // Update tampilan komentar yang sudah ada di DOM
                    const commentIdToUpdate = url.split('/').pop(); // Ambil ID dari URL
                    const commentContentDisplay = document.getElementById(`comment-content-display-${commentIdToUpdate}`);
                    if (commentContentDisplay) {
                        commentContentDisplay.textContent = content; // Perbarui teks komentar di DOM
                    }
                } else {
                    // Jika ini penambahan komentar baru
                    // Untuk saat ini, yang paling mudah adalah memuat ulang halaman
                    // karena mengupdate DOM untuk komentar baru lebih kompleks tanpa data lengkap dari server.
                    window.location.reload(); //
                }

                // Reset form setelah sukses
                commentInput.value = '';
                commentForm.action = `{{ route('comments.store', $product->id) }}`;
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

    // Logika Edit Komentar - Menggunakan event delegation untuk tombol edit
    // Ini hanya mengisi form untuk diedit, tidak mengirim form
    document.querySelectorAll('.edit-comment-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const commentContent = this.dataset.commentContent;

            commentInput.value =
            commentContent; // Isi input dengan konten komentar yang ingin diedit
            commentForm.action = `/comments/${commentId}`; // Ganti action ke rute update
            commentMethod.value = 'PATCH'; // Ganti method ke PATCH
            commentButtonText.textContent = 'Update'; // Ubah teks tombol
            commentInput.focus();
        });
    });

    // Reset form jika input dikosongkan setelah edit atau saat form dikirim
    commentInput.addEventListener('input', function() {
        if (this.value === '' && commentMethod.value === 'PATCH') {
            commentForm.action = `{{ route('comments.store', $product->id) }}`; // Kembali ke rute store
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
                            showToast('Komentar berhasil dihapus.', 'success');
                            // Hapus elemen komentar dari DOM tanpa reload halaman
                            document.getElementById(`comment-item-${commentId}`).remove();
                            // Optional: Reset form komentar jika yang dihapus adalah komentar yang sedang diedit
                            if (commentForm.action === `/comments/${commentId}` &&
                                commentMethod.value === 'PATCH') {
                                commentInput.value = '';
                                commentForm.action =
                                    `{{ route('comments.store', $product->id) }}`;
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
@endsection