@extends('layouts.sidebar-seller')

@section('isi')
<div class="flex min-h-screen">
    <main class="flex-1 p-8 ml-64 bg-[#0f172a] text-white">
        <div class="flex items-center mb-6">
            <a href="javascript:history.back()" class="text-gray-400 hover:text-white mr-4">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold">Edit Product: {{ $product->name }}</h1>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-[#1e293b] p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-6 border-b border-gray-700 pb-4">Details</h2>
                <form action="{{ route('seller.products.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        {{-- Kolom Kiri: Image dan Category (di bawahnya) --}}
                        <div class="md:col-span-2">
                            <label for="product_image"
                                class="block text-gray-400 text-sm font-medium mb-2">Image</label>
                            <div class="w-full relative" style="padding-top: 100%;">
                                <div class="absolute inset-0 border-2 border-dashed border-gray-600 rounded-lg flex items-center justify-center cursor-pointer hover:border-blue-500 transition-colors overflow-hidden"
                                    id="image-preview-container"
                                    onclick="document.getElementById('product_image').click()">
                                    <input type="file" name="product_image" id="product_image" class="hidden"
                                        accept="image/*">
                                    {{-- Tampilkan gambar yang sudah ada atau placeholder --}}
                                    {{-- PERUBAHAN DI SINI: --}}
                                    <span id="add-image-text"
                                        class="text-gray-500 @if($product->image_path && $product->image_path !== 'img/default-product.jpg') hidden @endif">Add
                                        image</span>
                                    <img id="preview-image" src="{{ asset('storage/' . $product->image_path) }}"
                                        {{-- Menggunakan asset() untuk path storage --}} alt="Image Preview"
                                        class="@if(!$product->image_path || $product->image_path === 'img/default-product.jpg') hidden @endif absolute inset-0 w-full h-full object-cover">
                                </div>
                            </div>
                            @error('product_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <div class="mt-6">
                                <label class="block text-gray-400 text-sm font-medium mb-2">Category</label>
                                <div class="space-y-2">
                                    @php
                                    $categories = ['digital content', 'digital assets', 'online courses', 'digital
                                    content creator'];
                                    @endphp
                                    @foreach($categories as $categoryOption)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="categories[]"
                                            id="{{ Str::slug($categoryOption, '_') }}" value="{{ $categoryOption }}"
                                            class="form-checkbox h-4 w-4 text-green-600 transition duration-150 ease-in-out bg-[#2d3748] border-gray-600 rounded"
                                            {{ in_array($categoryOption, $product->categories) ? 'checked' : '' }}>
                                        <label for="{{ Str::slug($categoryOption, '_') }}"
                                            class="ml-2 text-gray-300">{{ ucwords($categoryOption) }}</label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('categories')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Kolom Kanan: Title, Description, Product Link, Price, dan Currency --}}
                        <div class="md:col-span-4 space-y-4">
                            <div>
                                <label for="title" class="block text-gray-400 text-sm font-medium mb-2">Title</label>
                                <input type="text" name="title" id="title" placeholder="Title"
                                    value="{{ old('title', $product->name) }}"
                                    class="w-full px-4 py-2 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description"
                                    class="block text-gray-400 text-sm font-medium mb-2">Description</label>
                                <textarea name="description" id="description" placeholder="Description" rows="5"
                                    class="w-full px-4 py-2 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="product_link" class="block text-gray-400 text-sm font-medium mb-2">Product
                                    Link</label>
                                <input type="url" name="product_link" id="product_link" placeholder="Product link"
                                    value="{{ old('product_link', $product->product_link) }}"
                                    class="w-full px-4 py-2 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('product_link')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-5 gap-4 pt-4">
                                <div class="col-span-3">
                                    <label for="price"
                                        class="block text-gray-400 text-sm font-medium mb-2">Price</label>
                                    <input type="number" name="price" id="price" placeholder="Price" step="0.01"
                                        value="{{ old('price', $product->price) }}"
                                        class="w-full px-4 py-2 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('price')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-span-2">
                                    <label for="currency"
                                        class="block text-gray-400 text-sm font-medium mb-2">Currency</label>
                                    <select name="currency" id="currency"
                                        class="w-full px-4 py-2 bg-[#2d3748] border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="USD"
                                            {{ old('currency', $product->currency) == 'USD' ? 'selected' : '' }}>USD
                                        </option>
                                        <option value="IDR"
                                            {{ old('currency', $product->currency) == 'IDR' ? 'selected' : '' }}>IDR
                                        </option>
                                    </select>
                                    @error('currency')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-700">
                        <button type="button" onclick="window.history.back()"
                            class="px-6 py-2 rounded-lg text-gray-300 border border-gray-600 hover:bg-gray-700 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold transition-colors">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
document.getElementById('product_image').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        const previewImage = document.getElementById('preview-image');
        const addImageText = document.getElementById('add-image-text');

        previewImage.src = URL.createObjectURL(file);
        previewImage.classList.remove('hidden');
        addImageText.classList.add('hidden');
    }
});
</script>
@endsection