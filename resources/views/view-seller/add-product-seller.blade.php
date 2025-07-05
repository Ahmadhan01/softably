@extends('layouts.sidebar-seller')

@section('isi')
<div class="flex min-h-screen">
    <main class="flex-1 p-8 ml-64 bg-[#0f172a] text-white">
        <div class="flex items-center mb-6">
            <a href="{{ url()->previous() }}" class="text-gray-400 hover:text-white mr-4">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold">Add Product</h1>
        </div>

        {{-- Bungkus container Details agar bisa diatur lebarnya dan ditengah --}}
        <div class="max-w-4xl mx-auto"> {{-- Menambahkan max-w-4xl (atau 5xl/3xl) dan mx-auto --}}
            <div class="bg-[#1e293b] p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-6 border-b border-gray-700 pb-4">Details</h2>
                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf {{-- Tambahkan CSRF token untuk keamanan --}}

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
                                    <span id="add-image-text" class="text-gray-500">Add image</span>
                                    <img id="preview-image" src="#" alt="Image Preview"
                                        class="hidden absolute inset-0 w-full h-full object-cover">
                                </div>
                            </div>
                            @error('product_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            {{-- Menu Category (Checkboxes) - Di bawah input foto, tetap Vertikal --}}
                            <div class="mt-6"> {{-- Margin top untuk jarak dari input foto --}}
                                <label class="block text-gray-400 text-sm font-medium mb-2">Category</label>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="categories[]" id="digital_content"
                                            value="digital content"
                                            class="form-checkbox h-4 w-4 text-green-600 transition duration-150 ease-in-out bg-[#2d3748] border-gray-600 rounded">
                                        <label for="digital_content" class="ml-2 text-gray-300">Digital Content</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="categories[]" id="digital_assets"
                                            value="digital assets"
                                            class="form-checkbox h-4 w-4 text-green-600 transition duration-150 ease-in-out bg-[#2d3748] border-gray-600 rounded">
                                        <label for="digital_assets" class="ml-2 text-gray-300">Digital Assets</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="categories[]" id="online_courses"
                                            value="online courses"
                                            class="form-checkbox h-4 w-4 text-green-600 transition duration-150 ease-in-out bg-[#2d3748] border-gray-600 rounded">
                                        <label for="online_courses" class="ml-2 text-gray-300">Online Courses</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="categories[]" id="digital_content_creator"
                                            value="digital content creator"
                                            class="form-checkbox h-4 w-4 text-green-600 transition duration-150 ease-in-out bg-[#2d3748] border-gray-600 rounded">
                                        <label for="digital_content_creator" class="ml-2 text-gray-300">Digital Content
                                            Creator</label>
                                    </div>
                                </div>
                                @error('categories')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- End of Category Menu --}}
                        </div>

                        {{-- Kolom Kanan: Title, Description, Product Link, Price, dan Currency --}}
                        <div class="md:col-span-4 space-y-4">
                            <div>
                                <label for="title" class="block text-gray-400 text-sm font-medium mb-2">Title</label>
                                <input type="text" name="title" id="title" placeholder="Title"
                                    class="w-full px-4 py-2 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description"
                                    class="block text-gray-400 text-sm font-medium mb-2">Description</label>
                                <textarea name="description" id="description" placeholder="Description" rows="5"
                                    class="w-full px-4 py-2 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                                @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="product_link" class="block text-gray-400 text-sm font-medium mb-2">Product
                                    Link</label>
                                <input type="url" name="product_link" id="product_link" placeholder="Product link"
                                    class="w-full px-4 py-2 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('product_link')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Bagian Price dan Currency (di bawah Product Link) --}}
                            <div class="grid grid-cols-5 gap-4 pt-4">
                                {{-- Tambahkan padding-top untuk sedikit jarak --}}
                                <div class="col-span-3"> {{-- Price mengambil 3 dari 5 kolom --}}
                                    <label for="price"
                                        class="block text-gray-400 text-sm font-medium mb-2">Price</label>
                                    <input type="number" name="price" id="price" placeholder="Price" step="0.01"
                                        class="w-full px-4 py-2 bg-[#2d3748] border border-gray-600 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('price')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-span-2"> {{-- Currency mengambil 2 dari 5 kolom --}}
                                    <label for="currency"
                                        class="block text-gray-400 text-sm font-medium mb-2">Currency</label>
                                    <select name="currency" id="currency"
                                        class="w-full px-4 py-2 bg-[#2d3748] border border-gray-600 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="USD">USD</option>
                                        <option value="IDR" selected>IDR</option>
                                    </select>
                                    @error('currency')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-700">
                        <button type="button"
                            class="px-6 py-2 rounded-lg text-gray-300 border border-gray-600 hover:bg-gray-700 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold transition-colors">
                            Add Product
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