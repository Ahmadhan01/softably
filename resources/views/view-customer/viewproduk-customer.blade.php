@extends('layouts.sidebar')

@section('isi')
<style>
.scrollable::-webkit-scrollbar {
    width: 6px;
}

.scrollable::-webkit-scrollbar-thumb {
    background-color: #60A5FA; /* Biru terang untuk scrollbar internal */
    border-radius: 3px;
}

/* Styling for the main product image container (1:1 aspect ratio) */
.main-product-image-container {
    width: 100%;
    padding-bottom: 100%;
    position: relative;
    overflow: hidden;
    border-radius: 0.5rem;
    border: 2px solid #E0E0E0; /* Border gambar utama jadi abu-abu terang */
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
</style>

{{-- Pastikan main ini memiliki background terang yang konsisten --}}
<main class="flex-1 px-6 py-8 ml-64 bg-[#F8FAFC] min-h-screen"> <div class="max-w-5xl mx-auto space-y-6">
        <span class="text-2xl font-semibold text-gray-700">
            View Product
        </span>
            
        <div class="bg-white p-6 rounded-xl shadow-md space-y-8"> <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="main-product-image-container bg-white">
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                        class="absolute inset-0 w-full h-full object-cover rounded-lg mb-4">
                        <div
                            class="absolute top-3 right-3 w-8 h-8 bg-[#2563EB] text-white rounded-full flex items-center justify-center shadow-lg ring-2 ring-gray-200"> <i class="fa-solid fa-bookmark text-sm"></i>
                        </div>
                    </div>
                    {{-- Removed thumbnail images --}}
                </div>

                <div class="flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                {{-- Foto Profil Seller --}}
                                <div class="w-8 h-8 rounded-full overflow-hidden">
                                        {{-- UBAH INI: Dari $product->seller menjadi $product->user --}}
                                        <img src="{{ $product->user->profile_picture_url ?? asset('img/default-profile.png') }}"
                                            alt="Seller Avatar" class="w-full h-full object-cover rounded-full" />
                                    </div>
                                {{-- Nama Toko/Seller --}}
                                {{-- UBAH INI: Dari $product->seller menjadi $product->user --}}
                                <span class="font-semibold text-gray-800">{{ $product->user->name ?? 'Toko Tidak Dikenal' }}</span> </div>
                            {{-- PERUBAHAN DI SINI: Tombol "View Store" menjadi TAUTAN --}}
                            <a href="{{ route('view-seller.show', $product->user->id) }}" {{-- Menggunakan route langsung ke profil seller --}}
                               class="bg-gray-200 text-gray-800 px-3 py-1 text-sm rounded-md hover:bg-gray-300"> View Store
                            </a>
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900">{{ $product->name ?? 'Nama Produk' }}</h2> <div class="text-sm text-gray-600 max-h-64 overflow-y-auto pr-2 scrollable"> <p>
                                {{ $product->description ?? 'Deskripsi produk belum ada.' }}
                            </p>
                        </div>
                        <br />
                        <span class="text-2xl font-bold text-[#2563EB]"> Rp. {{ number_format($product->price ?? 0, 2, ',', '.') }}
                        </span>
                    </div>

                    <div class="mt-6 flex items-center justify-end">
                        <div class="flex gap-3">
                            {{-- Tombol Add to Wishlist --}}
                            @auth
                            <button id="addToWishlistBtn" data-product-id="{{ $product->id }}"
                                class="px-10 py-2 text-white rounded-md transition-colors duration-200
                                        {{ Auth::user()->hasInWishlist($product->id) ? 'bg-[#2563EB] hover:bg-[#3B82F6]' : 'bg-gray-300 hover:bg-[#2563EB]' }}"> <i class="fa-solid fa-bookmark mr-2"></i>
                                <span id="wishlistButtonText">
                                    {{ Auth::user()->hasInWishlist($product->id) ? 'Remove' : 'Add to Wishlist' }}
                                </span>
                            </button>
                            @endauth
                            @guest
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-[#2563EB] hover:text-white"> <i class="fa-solid fa-bookmark mr-2"></i> Add to Wishlist
                            </a>
                            @endguest

                            <button id="addToCartBtn" data-product-id="{{ $product->id }}"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-[#2563EB] hover:text-white"> Add to cart
                            </button>
                            <button id="buyNowBtn" data-product-id="{{ $product->id }}"
                                class="px-4 py-2 bg-[#2563EB] text-white rounded-md hover:bg-[#3B82F6]"> Buy Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800">Comments</h3> {{-- Form untuk Menambah/Mengedit Komentar --}}
                @auth
                <form id="comment-form" action="{{ route('comments.store', $product->id) }}" method="POST"
                    class="flex items-center gap-2">
                    @csrf
                    <input type="hidden" name="_method" id="comment-method" value="POST"> {{-- Untuk PATCH --}}
                    <input type="hidden" name="product_id" value="{{ $product->id }}"> {{-- Pastikan product_id ada --}}
                    <input type="hidden" name="parent_id" id="comment-parent-id" value=""> {{-- Untuk balasan --}}

                    {{-- Foto Profil User Customer di Komentar --}}
                    <div class="w-10 h-10 rounded-full overflow-hidden">
                                @php
                                $imagePath = Auth::user()->profile_picture_url;
                                @endphp
                                <img src="{{ Auth::user()->profile_picture_url }}" alt="User Profile" class="w-full h-full object-cover">
                            </div>
                    <input type="text" name="content" id="comment-input" placeholder="Write a comment..."
                        class="flex-1 p-3 py-2 rounded-md bg-gray-100 text-gray-800 border border-gray-300 focus:outline-none @error('content') border-red-500 @enderror" value=""
                        required />
                    <button type="submit" class="bg-[#2563EB] px-4 py-2 rounded-md hover:bg-[#3B82F6] text-white"> <i class="fa-solid fa-paper-plane"></i> <span id="comment-button-text">Kirim</span>
                        </button>
                </form>
                @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @else
                <p class="text-gray-600 text-sm">Silakan <a href="{{ route('login') }}"
                        class="text-blue-600 hover:underline">login</a> untuk berkomentar.</p> @endauth

                {{-- Tampilkan Daftar Komentar --}}
                <div class="space-y-4">
                    @forelse ($product->comments->sortByDesc('created_at') as $comment)
                    <div class="flex gap-3 bg-gray-100 p-3 rounded-md" id="comment-item-{{ $comment->id }}"> {{-- Foto Profil Komentator --}}
                        <div class="w-10 h-10 rounded-full overflow-hidden">
                                <img src="{{ $comment->user->profile_picture_url }}" alt="User Profile"class="w-full h-full object-cover">
                            </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-gray-800">{{ $comment->user->name ?? 'User Tidak Dikenal' }}</p> @auth
                                <div class="text-xs text-gray-600 space-x-2"> @if (Auth::id() === $comment->user_id)
                                    <button class="text-gray-700 hover:text-gray-900 edit-comment-btn"
                                        data-comment-id="{{ $comment->id }}"
                                        data-comment-content="{{ $comment->content }}">
                                        <i class="fas fa-pen text-xs"></i> Edit
                                    </button>
                                    @endif
                                    @if (Auth::id() === $comment->user_id || Auth::id() === $product->user_id)
                                    <button class="text-red-600 hover:text-red-700 delete-comment-btn"
                                        data-comment-id="{{ $comment->id }}">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                    @endif
                                    <button class="text-blue-600 hover:text-blue-700 reply-comment-btn"
                                        data-comment-id="{{ $comment->id }}"
                                        data-comment-user="{{ $comment->user->name ?? 'User' }}">
                                        <i class="fa-solid fa-reply"></i> Reply
                                    </button>
                                </div>
                                @endauth
                            </div>
                            <p class="text-sm text-gray-700 mt-1" id="comment-content-display-{{ $comment->id }}">
                                {{ $comment->content }}</p> <p class="text-xs text-gray-600 mt-1">
                                {{ $comment->created_at->diffForHumans() }}
                            </p>

                            {{-- Balasan Komentar --}}
                            @foreach($comment->replies->sortBy('created_at') as $reply)
                            <div class="flex gap-3 bg-gray-200 p-3 rounded-md mt-3 ml-8" id="comment-item-{{ $reply->id }}"> <div class="w-8 h-8 rounded-full overflow-hidden">
                                    <img src="{{ $reply->user->profile_picture_url ?? asset('img/default-profile.png') }}" alt="User Profile"
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
                                            @if (Auth::id() === $reply->user_id || Auth::id() === $product->user_id)
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
                    <p class="text-gray-600 text-center">Belum ada komentar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>


@push('scripts')
<script>
// Fungsi showToast (pertahankan jika belum ada di layouts/sidebar.blade.php)
// Disarankan untuk memindahkan ini ke file JS global atau layouts/sidebar.blade.php
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
    const addToCartBtn = document.getElementById('addToCartBtn');
    const buyNowBtn = document.getElementById('buyNowBtn');
    const addToWishlistBtn = document.getElementById('addToWishlistBtn');
    const productId = addToCartBtn.dataset.productId;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const wishlistButtonText = document.getElementById('wishlistButtonText');


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
                            // Mengubah warna tombol wishlist ketika dihapus dari wishlist (tema terang)
                            this.classList.remove('bg-[#2563EB]', 'hover:bg-[#3B82F6]');
                            this.classList.add('bg-gray-300', 'hover:bg-[#2563EB]');
                            if (wishlistButtonText) {
                                wishlistButtonText.textContent = 'Add to Wishlist';
                            }
                            showToast('Produk dihapus dari wishlist.', 'success');
                        } else if (data.action === 'added') {
                            // Mengubah warna tombol wishlist ketika ditambahkan ke wishlist (tema terang)
                            this.classList.remove('bg-gray-300', 'hover:bg-[#2563EB]');
                            this.classList.add('bg-[#2563EB]', 'hover:bg-[#3B82F6]');
                            if (wishlistButtonText) {
                                wishlistButtonText.textContent = 'Remove';
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

    // --- Logika Komentar: Edit, Hapus, dan Balas ---
    const commentInput = document.getElementById('comment-input');
    const commentForm = document.getElementById('comment-form');
    const commentMethod = document.getElementById('comment-method');
    const commentButtonText = document.getElementById('comment-button-text');
    const commentParentId = document.getElementById('comment-parent-id');

    // Konsolidasikan event listener untuk pengiriman form (store dan update)
    commentForm.addEventListener('submit', function(event) {
        event.preventDefault();

        // Tentukan URL berdasarkan apakah ini edit, balasan, atau komentar baru
        let url;
        if (commentMethod.value === 'PATCH') {
            url = commentForm.action;
        } else if (commentParentId.value) {
            url = `{{ route('comments.reply', ':commentId') }}`.replace(':commentId', commentParentId.value);
        } else {
            url = `{{ route('comments.store', $product->id) }}`;
        }

        const method = commentMethod.value;
        const content = commentInput.value;
        const productId = commentForm.querySelector('input[name="product_id"]').value;
        const parentId = commentParentId.value;

        const bodyData = {
            content: content,
            product_id: productId,
        };

        if (parentId) {
            bodyData.parent_id = parentId;
        }

        fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(bodyData)
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
                    location.reload();
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error submitting comment:', error);
                showToast('Terjadi kesalahan saat menyimpan komentar: ' + error.message, 'error');
            });
    });

    // Logika Edit Komentar
    document.querySelectorAll('.edit-comment-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const commentContent = this.dataset.commentContent;

            commentInput.value = commentContent;
            commentForm.action = `/comments/${commentId}`;
            commentMethod.value = 'PATCH';
            commentButtonText.textContent = 'Update';
            commentParentId.value = '';
            commentInput.focus();
        });
    });

    // Logika Reply Komentar
    document.querySelectorAll('.reply-comment-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const commentUser = this.dataset.commentUser;

            commentParentId.value = commentId;
            commentInput.value = `@${commentUser} `;
            commentForm.action = `{{ route('comments.reply', ':commentId') }}`.replace(':commentId', commentId);
            commentMethod.value = 'POST';
            commentButtonText.textContent = 'Balas';
            commentInput.focus();
        });
    });

    // Reset form jika input dikosongkan setelah edit/reply atau saat form dikirim
    commentInput.addEventListener('input', function() {
        if (this.value === '' && (commentMethod.value === 'PATCH' || commentParentId.value !== '')) {
            commentForm.action = `{{ route('comments.store', $product->id) }}`;
            commentMethod.value = 'POST';
            commentButtonText.textContent = 'Kirim';
            commentParentId.value = '';
        }
    });

    // Logika Hapus Komentar
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
                            if (commentForm.action.includes(`/comments/${commentId}`) &&
                                (commentMethod.value === 'PATCH' || commentParentId.value === commentId)) {
                                commentInput.value = '';
                                commentForm.action = `{{ route('comments.store', $product->id) }}`;
                                commentMethod.value = 'POST';
                                commentParentId.value = '';
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