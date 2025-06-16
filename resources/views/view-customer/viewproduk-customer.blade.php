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

    <style>
      .scrollable::-webkit-scrollbar {
        width: 6px;
      }

      .scrollable::-webkit-scrollbar-thumb {
        background-color: #4b5563;
        border-radius: 3px;
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
          <!-- Top Section: Image & Info -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="space-y-4">
              <div class="relative w-full aspect-square bg-white rounded-md">
                <div
                  class="overflow-hidden rounded-lg border-2 border-white mb-3"
                >
                  {{-- PERBAIKAN: Menggunakan image_path dari database untuk gambar utama --}}
                  <img
                    src="{{ $product->image_path }}"
                    alt="{{ $product->name ?? 'Product Image' }}"
                    class="w-full object-cover"
                  />
                </div>
                <div
                  class="absolute top-3 right-3 w-8 h-8 bg-orange-400 text-white rounded-full flex items-center justify-center shadow-lg ring-2 ring-white"
                >
                  <i class="fa-solid fa-bookmark text-sm"></i>
                </div>
              </div>
              <div class="flex gap-2 justify-center">
                {{-- PERBAIKAN: Gunakan image_path dari database untuk thumbnail --}}
                {{-- Jika Anda hanya memiliki satu image_path utama, Anda bisa menampilkannya berulang kali sebagai thumbnail --}}
                {{-- Jika Anda memiliki kolom 'thumbnail_paths' (misal, JSON string) atau relasi 'product_images', Anda akan loop di sini --}}
                <div class="w-16 h-16 bg-white rounded-md">
                  <div class="overflow-hidden rounded-lg border-2 border-white mb-3">
                    <img src="{{ $product->image_path }}" alt="Thumbnail" class="w-full object-cover" />
                  </div>
                </div>
                <div class="w-16 h-16 bg-white rounded-md">
                  <div class="overflow-hidden rounded-lg border-2 border-white mb-3">
                    <img src="{{ $product->image_path }}" alt="Thumbnail" class="w-full object-cover" />
                  </div>
                </div>
                <div class="w-16 h-16 bg-white rounded-md">
                  <div class="overflow-hidden rounded-lg border-2 border-white mb-3">
                    <img src="{{ $product->image_path }}" alt="Thumbnail" class="w-full object-cover" />
                  </div>
                </div>
                <div class="w-16 h-16 bg-white rounded-md">
                  <div class="overflow-hidden rounded-lg border-2 border-white mb-3">
                    <img src="{{ $product->image_path }}" alt="Thumbnail" class="w-full object-cover" />
                  </div>
                </div>
                <div class="w-16 h-16 bg-white rounded-md">
                  <div class="overflow-hidden rounded-lg border-2 border-white mb-3">
                    <img src="{{ $product->image_path }}" alt="Thumbnail" class="w-full object-cover" />
                  </div>
                </div>
              </div>
            </div>

            <!-- Product Info -->
            <div class="flex flex-col justify-between">
              <div class="space-y-4">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-400 rounded-full">
                      <img src="{{ asset('img/man.jpg') }}" alt="" class="rounded-full" /> {{-- Avatar toko/penjual --}}
                    </div>
                    <span class="font-semibold">Toko Ahmad</span>
                  </div>
                  <button
                    class="bg-gray-700 px-3 py-1 text-sm rounded-md hover:bg-gray-600"
                  >
                    View Store
                  </button>
                </div>

                {{-- Tampilkan data produk dari variabel $product --}}
                <h2 class="text-2xl font-bold">{{ $product->name ?? 'Nama Produk' }}</h2> {{-- Asumsi ada kolom 'name' --}}

                <div
                  class="text-sm text-gray-400 max-h-64 overflow-y-auto pr-2 scrollable"
                >
                  <p>
                    {{ $product->description ?? 'Deskripsi produk belum ada.' }} {{-- Asumsi ada kolom 'description' --}}
                  </p>
                </div>
                <br />
                <span class="text-2xl font-bold text-yellow-400">
                  Rp. {{ number_format($product->price ?? 0, 2, ',', '.') }} {{-- Asumsi ada kolom 'price' --}}
                </span>
              </div>

              <div class="mt-6 flex items-center justify-end">
                <div class="flex gap-3">
                  <button
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-500"
                  >
                    Add to cart
                  </button>
                  <a href="{{ route('checkout-customer') }}"><button
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-400">
                    Buy Now
                  </button>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Comments Section -->
          <div class="space-y-6">
            <h3 class="text-lg font-semibold">Comments</h3>

            {{-- Form untuk Menambah Komentar --}}
            @auth {{-- Pastikan user login untuk bisa berkomentar --}}
            <form action="{{ route('comments.store', $product->id) }}" method="POST" class="flex items-center gap-2">
                @csrf {{-- CSRF token wajib untuk form POST Laravel --}}
                <div class="w-10 h-10 bg-gray-400 rounded-full">
                    <img src="{{ asset('img/man.jpg') }}" alt="User Avatar" class="rounded-full" /> {{-- Avatar user yang sedang login --}}
                </div>
                <input
                    type="text"
                    name="content" {{-- Atribut name penting untuk dikirim ke controller --}}
                    placeholder="Write a comment..."
                    class="flex-1 p-3 rounded-md bg-[#1F2A40] text-white border border-gray-600 focus:outline-none @error('content') border-red-500 @enderror"
                    required
                />
                <button
                    type="submit" {{-- Type submit untuk tombol form --}}
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
                @forelse ($product->comments()->latest()->get() as $comment) {{-- Ambil komentar terbaru --}}
                    <div class="flex gap-3">
                        <div class="w-10 h-10 bg-gray-400 rounded-full">
                            <img src="{{ asset('img/man.jpg') }}" alt="Commenter Avatar" class="rounded-full" /> {{-- Ganti dengan avatar user komentar jika tersedia --}}
                        </div>
                        <div class="bg-[#1F2A40] p-3 rounded-md flex-1">
                            <p class="font-semibold">{{ $comment->user->name ?? 'User Tidak Dikenal' }}</p> {{-- Tampilkan nama user --}}
                            <p class="text-sm text-gray-300">
                                {{ $comment->content }} {{-- Tampilkan isi komentar --}}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $comment->created_at->diffForHumans() }} {{-- Waktu komentar --}}
                            </p>
                            @auth
                                @if (Auth::id() === $comment->user_id) {{-- Jika komentar ini milik user yang sedang login --}}
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
  </body>
</html>
@endsection
