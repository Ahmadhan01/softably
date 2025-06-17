@extends('layouts.sidebar')

@section('isi')
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Penting untuk AJAX POST --}}

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
        padding-bottom: 100%; /* Creates 1:1 aspect ratio */
        position: relative;
        overflow: hidden; /* Penting untuk memotong gambar */
        border-radius: 0.5rem; /* rounded-md dari Tailwind */
        border: 2px solid white; /* Border putih */
      }
      .main-product-image-container img.main-product-image { /* Target img di dalam container */
        position: absolute; /* Penting agar gambar mengisi parent */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover; /* Penting untuk menjaga rasio aspek dan mengisi ruang */
        border-radius: 0.5rem; /* Pastikan gambar juga rounded */
      }


      /* Styling for thumbnail images (already 1:1 by w-16 h-16 classes) */
      .thumbnail-image-container {
          width: 4rem; /* w-16 */
          height: 4rem; /* h-16 */
          position: relative; /* Penting untuk absolut img di dalamnya */
          overflow: hidden;
          border: 2px solid white;
          border-radius: 0.5rem;
      }
      .thumbnail-image-container img.thumbnail-image { /* Target img di dalam container */
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          object-fit: cover;
          border-radius: 0.5rem;
      }
    </style>
  </head>

  <body class="bg-[#10172A] text-white font-sans">
    
    <main class="flex-1 px-6 py-8 ml-64 bg-[#10172A] min-h-screen">
      <div class="max-w-5xl mx-auto space-y-6">
        <a
          href="{{ route('produk-customer.index') }}" {{-- Tautan kembali ke halaman daftar produk --}}
          class="text-sm text-white hover:underline"
          ><i class="fa-solid fa-arrow-left"></i> View Product</a
        >

        <div class="bg-[#1C2438] p-6 rounded-xl shadow-md space-y-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-4">
              {{-- Container utama gambar produk, pastikan rasio 1:1 --}}
              <div class="main-product-image-container bg-white">
                {{-- Hapus div main-product-image-wrapper karena sudah tidak diperlukan dengan CSS baru --}}
                  <img
                    src="{{ $product->image_path }}"
                    alt="{{ $product->name ?? 'Product Image' }}"
                    class="main-product-image"
                  />
                <div
                  class="absolute top-3 right-3 w-8 h-8 bg-orange-400 text-white rounded-full flex items-center justify-center shadow-lg ring-2 ring-white"
                >
                  <i class="fa-solid fa-bookmark text-sm"></i>
                </div>
              </div>
              <div class="flex gap-2 justify-center">
                {{-- Thumbnails --}}
                <div class="thumbnail-image-container bg-white">
                  <img src="{{ $product->image_path }}" alt="Thumbnail 1" class="thumbnail-image" />
                </div>
                <div class="thumbnail-image-container bg-white">
                    <img src="{{ $product->image_path }}" alt="Thumbnail 2" class="thumbnail-image" />
                </div>
                <div class="thumbnail-image-container bg-white">
                    <img src="{{ $product->image_path }}" alt="Thumbnail 3" class="thumbnail-image" />
                </div>
                <div class="thumbnail-image-container bg-white">
                    <img src="{{ $product->image_path }}" alt="Thumbnail 4" class="thumbnail-image" />
                </div>
                <div class="thumbnail-image-container bg-white">
                    <img src="{{ $product->image_path }}" alt="Thumbnail 5" class="thumbnail-image" />
                </div>
              </div>
            </div>

            <div class="flex flex-col justify-between">
              <div class="space-y-4">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-400 rounded-full">
                      <img src="{{ asset('img/man.jpg') }}" alt="" class="rounded-full" />
                    </div>
                    <span class="font-semibold">Toko Ahmad</span>
                  </div>
                  <button
                    class="bg-gray-700 px-3 py-1 text-sm rounded-md hover:bg-gray-600"
                  >
                    View Store
                  </button>
                </div>

                <h2 class="text-2xl font-bold">{{ $product->name ?? 'Nama Produk' }}</h2>

                <div
                  class="text-sm text-gray-400 max-h-64 overflow-y-auto pr-2 scrollable"
                >
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
                  <button
                    id="addToCartBtn" {{-- Tambahkan ID ini --}}
                    data-product-id="{{ $product->id }}" {{-- Tambahkan product ID --}}
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-500"
                  >
                    Add to cart
                  </button>
                  <button
                        id="buyNowBtn" {{-- Tambahkan ID ini --}}
                        data-product-id="{{ $product->id }}" {{-- Tambahkan product ID --}}
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-400">
                    Buy Now
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="space-y-6">
            <h3 class="text-lg font-semibold">Comments</h3>

            {{-- Form untuk Menambah Komentar --}}
            @auth
            <form action="{{ route('comments.store', $product->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                <div class="w-10 h-10 bg-gray-400 rounded-full">
                    <img src="{{ asset('img/man.jpg') }}" alt="User Avatar" class="rounded-full" />
                </div>
                <input
                    type="text"
                    name="content"
                    placeholder="Write a comment..."
                    class="flex-1 p-3 rounded-md bg-[#1F2A40] text-white border border-gray-600 focus:outline-none @error('content') border-red-500 @enderror"
                    required
                />
                <button
                    type="submit"
                    class="bg-green-500 px-4 py-2 rounded-md hover:bg-green-400"
                >
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            @else
                <p class="text-gray-400 text-sm">Silakan <a href="{{ route('login') }}" class="text-blue-400 hover:underline">login</a> untuk berkomentar.</p>
            @endauth

            {{-- Tampilkan Daftar Komentar --}}
            <div class="space-y-4">
                @forelse ($product->comments()->latest()->get() as $comment)
                    <div class="flex gap-3">
                        <div class="w-10 h-10 bg-gray-400 rounded-full">
                            <img src="{{ asset('img/man.jpg') }}" alt="Commenter Avatar" class="rounded-full" />
                        </div>
                        <div class="bg-[#1F2A40] p-3 rounded-md flex-1">
                            <p class="font-semibold">{{ $comment->user->name ?? 'User Tidak Dikenal' }}</p>
                            <p class="text-sm text-gray-300">
                                {{ $comment->content }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $comment->created_at->diffForHumans() }}
                            </p>
                            @auth
                                @if (Auth::id() === $comment->user_id)
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400 text-xs mt-1">Hapus</button>
                                    </form>
                                @endif
                            @endauth
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartBtn = document.getElementById('addToCartBtn');
            const buyNowBtn = document.getElementById('buyNowBtn');
            const productId = addToCartBtn.dataset.productId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function handleAddToCart(event) {
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
                            throw new Error(errorData.message || 'Gagal menambahkan produk ke keranjang.');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                    console.log('Respons server:', data);
                    // Opsional: Perbarui jumlah item di keranjang pada UI (misal: di sidebar)
                    // if (data.cartCount !== undefined) { ... }
                })
                .catch(error => {
                    console.error('Ada masalah dengan operasi fetch:', error);
                    alert('Error: ' + error.message);
                });
            }

            addToCartBtn.addEventListener('click', handleAddToCart);

            // For "Buy Now" button: add to cart then redirect to checkout
            buyNowBtn.addEventListener('click', function(event) {
                event.preventDefault();
                // Panggil handleAddToCart, lalu redirect
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
                            throw new Error(errorData.message || 'Gagal menambahkan produk ke keranjang untuk pembelian.');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Produk berhasil ditambahkan ke keranjang (untuk Buy Now):', data);
                    window.location.href = "{{ route('checkout-customer') }}"; // Redirect to checkout
                })
                .catch(error => {
                    console.error('Ada masalah saat Buy Now:', error);
                    alert('Error Buy Now: ' + error.message);
                });
            });
        });
    </script>
  </body>
</html>
@endsection