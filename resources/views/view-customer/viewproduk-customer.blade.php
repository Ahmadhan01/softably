@extends('layouts.sidebar')

@section('isi')
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

/* Modal styles */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
}

.modal.show {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background-color: #1C2438;
    padding: 2rem;
    border-radius: 0.75rem;
    width: 90%;
    max-width: 500px;
    position: relative;
    transform: translateY(-20px);
    transition: transform 0.3s ease-in-out;
}

.modal.show .modal-content {
    transform: translateY(0);
}

.close-button {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #9ca3af;
    cursor: pointer;
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
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                        class="absolute inset-0 w-full h-full object-cover rounded-lg mb-4">
                        <div
                            class="absolute top-3 right-3 w-8 h-8 bg-orange-400 text-white rounded-full flex items-center justify-center shadow-lg ring-2 ring-white">
                            <i class="fa-solid fa-bookmark text-sm"></i>
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
                                <span class="font-semibold">{{ $product->user->name ?? 'Toko Tidak Dikenal' }}</span>
                            </div>
                            {{-- KEMBALIKAN TOMBOL "View Store" INI --}}
                            <button id="viewStoreBtn" class="bg-gray-700 px-3 py-1 text-sm rounded-md hover:bg-gray-600"
                                    data-seller-id="{{ $product->user->id ?? '' }}"> {{-- UBAH INI: data-seller-id ke $product->user->id --}}
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
                            {{-- Tombol Add to Wishlist ... (tidak ada perubahan) --}}
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
                    <input type="hidden" name="parent_id" id="comment-parent-id" value=""> {{-- Untuk balasan --}}

                    {{-- Foto Profil User Customer di Komentar --}}
                    <div class="w-10 h-10 rounded-full overflow-hidden">
                                @php
                                $imagePath = Auth::user()->profile_picture_url;
                                @endphp
                                <img src="{{ Auth::user()->profile_picture_url }}" alt="User Profile" class="w-full h-full object-cover">
                            </div>
                    <input type="text" name="content" id="comment-input" placeholder="Write a comment..."
                        class="flex-1 p-3 rounded-md bg-[#1F2A40] text-white border border-gray-600 focus:outline-none @error('content') border-red-500 @enderror"
                        value=""
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
                    <div class="flex gap-3 bg-[#1F2A40] p-3 rounded-md" id="comment-item-{{ $comment->id }}">
                        {{-- Foto Profil Komentator --}}
                        <div class="w-10 h-10 rounded-full overflow-hidden">
                                <img src="{{ $comment->user->profile_picture_url }}" alt="User Profile"class="w-full h-full object-cover">
                            </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold">{{ $comment->user->name ?? 'User Tidak Dikenal' }}</p>
                                @auth
                                <div class="text-xs text-gray-500 space-x-2">
                                    @if (Auth::id() === $comment->user_id)
                                    <button class="text-white/70 hover:text-white edit-comment-btn"
                                        data-comment-id="{{ $comment->id }}"
                                        data-comment-content="{{ $comment->content }}">
                                        <i class="fas fa-pen text-xs"></i> Edit
                                    </button>
                                    @endif
                                    @if (Auth::id() === $comment->user_id || Auth::id() === $product->user_id)
                                    <button class="text-red-500 hover:text-red-400 delete-comment-btn"
                                        data-comment-id="{{ $comment->id }}">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                    @endif
                                    <button class="text-blue-400 hover:text-blue-300 reply-comment-btn"
                                        data-comment-id="{{ $comment->id }}"
                                        data-comment-user="{{ $comment->user->name ?? 'User' }}">
                                        <i class="fa-solid fa-reply"></i> Reply
                                    </button>
                                </div>
                                @endauth
                            </div>
                            <p class="text-sm text-gray-300 mt-1" id="comment-content-display-{{ $comment->id }}">
                                {{ $comment->content }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $comment->created_at->diffForHumans() }}
                            </p>

                            {{-- Balasan Komentar --}}
                            @foreach($comment->replies->sortBy('created_at') as $reply)
                            <div class="flex gap-3 bg-[#2A354D] p-3 rounded-md mt-3 ml-8" id="comment-item-{{ $reply->id }}"> {{-- Indent for replies --}}
                                <div class="w-8 h-8 rounded-full overflow-hidden">
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
                                            @if (Auth::id() === $reply->user_id || Auth::id() === $product->user_id)
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
                    <p class="text-gray-400 text-center">Belum ada komentar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>

{{-- KEMBALIKAN MODAL POP-UP PROFIL TOKO INI --}}
<div id="storeProfileModal" class="modal">
    <div class="modal-content text-white">
        <button class="close-button" id="closeModalBtn">&times;</button>
        <div class="flex flex-col items-center gap-4">
            <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-600 flex-shrink-0">
                <img id="sellerProfilePicture" src="{{ asset('img/default-profile.jpg') }}" alt="Seller Profile"
                    class="w-full h-full object-cover">
            </div>
            <h3 id="sellerName" class="text-xl font-bold">Nama Toko</h3>
            <p id="sellerStatus" class="text-green-500 text-sm">Online</p>
            <p id="sellerDescription" class="text-gray-400 text-center text-sm">Deskripsi toko...</p>

            <div class="grid grid-cols-2 gap-4 w-full mt-4">
                <div class="bg-[#2A354D] rounded-lg p-4 flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-white/20 mb-2 flex items-center justify-center">
                        <i class="fa-solid fa-check-circle text-green-400 text-2xl"></i>
                    </div>
                    <span class="text-lg font-semibold" id="successTransactions">0</span>
                    <span class="text-xs text-gray-400">Success Transactions</span>
                </div>
                <div class="bg-[#2A354D] rounded-lg p-4 flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-white/20 mb-2 flex items-center justify-center">
                        <i class="fa-solid fa-times-circle text-red-400 text-2xl"></i>
                    </div>
                    <span class="text-lg font-semibold" id="failedTransactions">0</span>
                    <span class="text-xs text-gray-400">Failed Transactions</span>
                </div>
            </div>
        </div>
    </div>
</div>


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


    // --- Logika Modal Pop-up Profil Toko ---
    const viewStoreBtn = document.getElementById('viewStoreBtn');
    const storeProfileModal = document.getElementById('storeProfileModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const sellerProfilePicture = document.getElementById('sellerProfilePicture');
    const sellerName = document.getElementById('sellerName');
    const sellerStatus = document.getElementById('sellerStatus');
    const sellerDescription = document.getElementById('sellerDescription');
    // HAPUS INI: Tidak perlu lagi elemen-elemen ini
    // const successTransactions = document.getElementById('successTransactions');
    // const failedTransactions = document.getElementById('failedTransactions');

    if (viewStoreBtn) {
        viewStoreBtn.addEventListener('click', function() {
            const sellerId = this.dataset.sellerId;
            if (sellerId) {
                // Fetch seller data
                fetch(`/api/seller-info/${sellerId}`)
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => { // Pastikan parsing error
                                throw new Error(errorData.message || 'Gagal memuat data seller.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success && data.user) { // Data sekarang ada di 'user'
                            sellerProfilePicture.src = data.user.profile_picture_url || '{{ asset("img/default-profile.jpg") }}';
                            sellerName.textContent = data.user.name;
                            sellerStatus.textContent = data.user.is_online ? 'Online' : 'Offline';
                            sellerStatus.className = '';
                            sellerStatus.classList.add('text-sm', data.user.is_online ? 'text-green-500' : 'text-red-500');
                            sellerDescription.textContent = data.user.description || 'Belum ada deskripsi toko.';

                            // HAPUS INI: Tidak perlu memperbarui elemen transaksi
                            // successTransactions.textContent = data.success_transactions;
                            // failedTransactions.textContent = data.failed_transactions;

                            storeProfileModal.classList.add('show');
                        } else {
                            showToast(data.message || 'Gagal memuat data seller.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching seller info:', error);
                        showToast('Terjadi kesalahan saat memuat informasi toko: ' + error.message, 'error');
                    });
            } else {
                showToast('Informasi seller tidak tersedia.', 'error');
            }
        });
    }


    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            storeProfileModal.classList.remove('show');
        });
    }

    // Tutup modal jika klik di luar konten modal
    if (storeProfileModal) {
        storeProfileModal.addEventListener('click', function(e) {
            if (e.target === storeProfileModal) {
                storeProfileModal.classList.remove('show');
            }
        });
    }
});
</script>
@endpush
@endsection