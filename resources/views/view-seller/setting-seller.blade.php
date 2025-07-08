@extends('layouts.sidebar-seller') {{-- Pastikan menggunakan layouts.sidebar-seller --}}

@section('isi')
{{-- Hapus div class="flex-1 p-8" --}}
{{-- Ganti dengan div wrapper, karena main sudah diatur di parent layout --}}
<div class="bg-[#10172A] text-white font-sans flex-grow"> {{-- flex-grow agar mengisi tinggi vertikal --}}
    <div class="p-3"> {{-- Sesuaikan padding keseluruhan jika p-5 di main parent terasa terlalu banyak --}}
        <h1 class="text-3xl font-bold mb-6">Settings</h1>

        <div class="bg-[#1e293b] p-6 rounded-lg shadow-md">
            <div class="border-b border-gray-700 pb-4 mb-6">
                <h2 class="text-xl font-semibold mb-2">Apps settings</h2>
                <div class="flex space-x-8 text-gray-400">
                    <a href="#" class="text-white font-medium border-b-2 border-green-500 pb-1">Account</a>
                    <a href="#" class="hover:text-white pb-1">Chat with Softably</a>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-semibold mb-4 text-white">Store Info</h2>
                <p class="text-gray-400 mb-6">Update your store details</p>

                <div class="space-y-6">
                    {{-- Your Photo --}}
                    <div class="flex items-center space-x-6">
                        <div class="w-24 h-24 rounded-full bg-gray-700 flex items-center justify-center text-gray-300 overflow-hidden">
                            {{-- Placeholder for user's photo --}}
                            <img src="{{ Auth::user()->profile_picture_url ?? asset('img/man.jpg') }}" alt="User Photo" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <button class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200">Upload image</button>
                            <p class="text-sm text-gray-400 mt-1">JPG or PNG. 1MB Max</p>
                        </div>
                    </div>

                    {{-- Store Name --}}
                    <div>
                        <label for="storeName" class="block text-gray-300 text-sm font-medium mb-2">Store Name</label>
                        <input type="text" id="storeName" value="Toko Ahmad" class="w-full p-3 rounded-md bg-[#0f172a] border border-gray-700 text-white focus:ring focus:ring-green-500 focus:border-green-500">
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-gray-300 text-sm font-medium mb-2">Description</label>
                        <textarea id="description" rows="4" class="w-full p-3 rounded-md bg-[#0f172a] border border-gray-700 text-white focus:ring focus:ring-green-500 focus:border-green-500">Lorem ipsum dolor sit amet consectetur. Sed consequat venenatis pretium euismod urna eget purus quis. Lobortis enim facilisis vel consequat at nunc est montes. Tortor lacus amet suspendisse fermentum volutpat eu vel.</textarea>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-gray-300 text-sm font-medium mb-2">Email</label>
                        <input type="email" id="email" value="fuad@gmail.com" class="w-full p-3 rounded-md bg-[#0f172a] border border-gray-700 text-white focus:ring focus:ring-green-500 focus:border-green-500">
                    </div>

                    {{-- Phone Number --}}
                    <div>
                        <label for="phoneNumber" class="block text-gray-300 text-sm font-medium mb-2">Phone number</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-700 bg-[#0f172a] text-gray-400 text-sm">+62</span>
                            <input type="text" id="phoneNumber" value="8765 2324 2342" class="flex-1 p-3 rounded-r-md bg-[#0f172a] border border-gray-700 text-white focus:ring focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    {{-- Date of Birth --}}
                    <div>
                        <label for="dob" class="block text-gray-300 text-sm font-medium mb-2">Date of birth</label>
                        <div class="relative">
                            <input type="text" id="dob" value="2001/02/21" class="w-full p-3 rounded-md bg-[#0f172a] border border-gray-700 text-white focus:ring focus:ring-green-500 focus:border-green-500 pr-10">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-calendar-days text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex justify-end space-x-4 pt-4">
                        <button class="px-6 py-2 rounded-md text-white bg-red-600 hover:bg-red-700 transition duration-200">Cancel</button>
                        <button class="px-6 py-2 rounded-md text-white bg-green-500 hover:bg-green-600 transition duration-200">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection