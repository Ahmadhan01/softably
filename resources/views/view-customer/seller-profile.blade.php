@extends('layouts.sidebar')

@section('isi')
    <div class="flex min-h-screen">
        <main class="flex-1 p-6 space-y-6 ml-64">
            <a href="{{ url()->previous() }}" class="text-sm text-white hover:underline">
                <i class="fa-solid fa-arrow-left"></i>&nbsp; Kembali
            </a>

            <div class="bg-[#1e293b] p-6 rounded-lg shadow-md mt-4">
                <div class="flex items-center space-x-6 mb-6">
                    <div class="w-24 h-24 rounded-full overflow-hidden flex-shrink-0">
                        <img src="{{ $user->profile_picture_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
                        <p class="text-gray-400">Email: {{ $user->email }}</p>
                        <p class="text-gray-400">Bergabung sejak: {{ $user->created_at->format('d M Y') }}</p>
                        {{-- Anda bisa menambahkan informasi lain tentang penjual di sini --}}
                    </div>
                </div>

                <h2 class="text-xl font-semibold mt-8 mb-4 text-white">Produk dari {{ $user->name }}</h2>
                @if($products->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-[#0f172a] p-4 rounded-lg shadow">
                                <img src="{{ $product->image_path }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-md mb-2">
                                <h3 class="font-semibold text-lg text-white">{{ $product->name }}</h3>
                                <p class="text-gray-400 text-sm">{{ Str::limit($product->description, 100) }}</p>
                                <p class="font-bold text-orange-400 mt-2">Rp. {{ number_format($product->price, 0, ',', '.') }},00</p>
                                <a href="{{ route('view-product.show', $product->id) }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Lihat Produk</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-center">Penjual ini belum memiliki produk.</p>
                @endif
            </div>
        </main>
    </div>
@endsection