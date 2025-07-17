@extends('layouts.sidebar')

@section('isi')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Wishlist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Styling untuk toast notification */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .toast {
            background-color: #333;
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .toast.show {
            opacity: 1;
        }
        .toast.success { background-color: #28a745; }
        .toast.error { background-color: #dc3545; }

        /* Custom scrollbar (disesuaikan untuk tema cerah) */
        .scrollable-wishlist::-webkit-scrollbar {
            width: 6px;
        }
        .scrollable-wishlist::-webkit-scrollbar-thumb {
            background-color: #cbd5e0; /* Warna abu-abu terang */
            border-radius: 3px;
        }
        .scrollable-wishlist::-webkit-scrollbar-track {
            background-color: #f8fafc; /* Warna background terang */
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-gray-800"> {{-- Ubah body menjadi cerah dan teks gelap --}}
    <div class="flex min-h-screen">
        <main class="flex-1 p-6 space-y-6 ml-64 bg-[#F8FAFC]"> {{-- Ubah background main menjadi cerah --}}
            <span class="text-2xl font-semibold text-gray-700">
                Wishlist
            </span>
                <!-- <div class="flex space-x-4 items-center">
                    <a class="text-lg" href="{{ route('wishlist-customer.index') }}">
                        <i class="fa-solid fa-bookmark text-green-500"></i>
                    </a>
                    <a class="text-lg" href="{{ route('cart-customer.index') }}">
                        <i class="fa-solid fa-cart-shopping text-gray-700"></i> {{-- Ubah ikon keranjang menjadi gelap --}}
                    </a>
                </div> -->
            <!-- </div> -->

            {{-- Form untuk Filter dan Pencarian --}}
            <form action="{{ route('wishlist-customer.index') }}" method="GET" class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-2">
                    {{-- Sorting --}}
                    <label for="sort-by" class="text-gray-700">Sort by</label> {{-- Ubah teks label --}}
                    <select name="sort_by" id="sort-by" onchange="this.form.submit()"
                        class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"> {{-- Ubah background select --}}
                        <option value="newest" {{ $sortBy == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ $sortBy == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="price_asc" {{ $sortBy == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ $sortBy == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>

                {{-- Input Pencarian --}}
                <div class="relative w-full max-w-xs">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search product"
                        value="{{ $searchQuery }}"
                        class="w-full px-4 py-2 bg-white text-sm text-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 border border-gray-300" {{-- Ubah background input --}}
                    />
                    <button type="submit" class="fa fa-search absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></button> {{-- Ubah warna ikon search --}}
                </div>
            </form>

            <div class="space-y-6 scrollable-wishlist max-h-[calc(100vh-200px)] overflow-y-auto">
                @forelse ($wishlistItems as $item)
                    <div class="bg-[#fff] p-5 border border-gray-200 rounded-xl flex justify-between items-start wishlist-item shadow-md" data-wishlist-id="{{ $item->id }}" data-product-id="{{ $item->product->id }}"> {{-- Ubah background item wishlist --}}
                        <div class="flex items-start gap-5">
                            <div class="w-48 h-48 bg-gray-100 rounded relative flex-shrink-0 overflow-hidden"> {{-- Ubah background gambar produk --}}
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                {{-- Tombol Hapus dari Wishlist --}}
                                <button type="button"
                                    class="delete-wishlist-btn absolute top-2 right-2 text-red-500 hover:text-red-600 text-lg"
                                    data-product-id="{{ $item->product->id }}">
                                    <i class="fa-solid fa-bookmark-slash"></i>
                                </button>
                                {{-- Tombol Add to Cart --}}
                                <button type="button"
                                    class="add-to-cart-btn absolute bottom-2 left-2 bg-blue-600 hover:bg-blue-700 text-white rounded p-2 text-sm"
                                    data-product-id="{{ $item->product->id }}">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">{{ $item->product->seller->name ?? 'Toko Tidak Dikenal' }}</p> {{-- Ubah teks seller --}}
                                <h2 class="text-lg font-bold mb-2 text-gray-800">{{ $item->product->name }}</h2> {{-- Pastikan teks judul gelap --}}
                                <p class="text-sm text-gray-500 max-w-md leading-snug mb-6">
                                    {{ Str::limit($item->product->description, 150) }}
                                </p>
                                <a href="{{ route('view-product.show', $item->product->id) }}"
                                    class="px-4 py-1 text-sm rounded border border-gray-300 text-blue-600 hover:bg-blue-50 hover:text-blue-700 transition"> {{-- Ubah warna tombol --}}
                                    Check Details
                                </a>
                            </div>
                        </div>
                        <div class="text-[#2563EB] font-bold text-lg">Rp. {{ number_format($item->product->price, 0, ',', '.') }},00</div> {{-- Warna harga --}}
                    </div>
                @empty
                    <p class="text-center text-gray-600 p-6">Wishlist Anda kosong.</p> {{-- Warna teks kosong --}}
                @endforelse
            </div>

            {{-- Pagination Links --}}
            <div class="mt-8">
                {{ $wishlistItems->links() }}
            </div>
        </main>
    </div>

    <script>
        // Fungsi untuk menampilkan toast notifications
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                const newToastContainer = document.createElement('div');
                newToastContainer.id = 'toast-container';
                newToastContainer.classList.add('fixed', 'top-4', 'right-4', 'z-[999]', 'space-y-2');
                document.body.appendChild(newToastContainer);
            }

            const toast = document.createElement('div');
            toast.classList.add(
                'flex', 'items-center', 'gap-2', 'px-4', 'py-2', 'rounded', 'shadow-md', 'text-white', 'opacity-0', 'transition-opacity', 'duration-300'
            );

            if (type === 'success') {
                toast.classList.add('bg-green-500');
                toast.innerHTML = `<i class="fa-solid fa-check-circle"></i> <span>${message}</span>`;
            } else if (type === 'error') {
                toast.classList.add('bg-red-500');
                toast.innerHTML = `<i class="fa-solid fa-times-circle"></i> <span>${message}</span>`;
            } else {
                toast.classList.add('bg-blue-500');
                toast.innerHTML = `<i class="fa-solid fa-info-circle"></i> <span>${message}</span>`;
            }
            document.getElementById('toast-container').appendChild(toast);

            setTimeout(() => {
                toast.classList.add('opacity-100');
            }, 100);

            setTimeout(() => {
                toast.classList.remove('opacity-100');
                toast.addEventListener('transitionend', () => toast.remove());
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.querySelectorAll('.delete-wishlist-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const productId = this.dataset.productId;
                    const url = `/wishlist/${productId}`;

                    if (confirm('Apakah Anda yakin ingin menghapus produk ini dari wishlist?')) {
                        fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(errorData => {
                                    throw new Error(errorData.message || 'Gagal menghapus produk dari wishlist.');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                showToast(data.message, 'success');
                                this.closest('.wishlist-item').remove();
                            } else {
                                showToast(data.message || 'Terjadi kesalahan.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting from wishlist:', error);
                            showToast('Gagal menghapus dari wishlist: ' + error.message, 'error');
                        });
                    }
                });
            });

            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const productId = this.dataset.productId;
                    const url = '{{ route("cart.store") }}';

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ product_id: productId, quantity: 1 })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.message || 'Gagal menambahkan produk ke keranjang.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        showToast(data.message, 'success');
                    })
                    .catch(error => {
                        console.error('Error adding to cart:', error);
                        showToast('Gagal menambahkan ke keranjang: ' + error.message, 'error');
                    });
                });
            });
        });
    </script>
</body>
</html>
@endsection