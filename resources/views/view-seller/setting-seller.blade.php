@extends('layouts.sidebar-seller')

@section('title', 'Pengaturan Profil Seller')

@section('isi')
    {{-- Hapus div container mx-auto px-4 py-6 dan main tag ml-64 karena sudah ditangani oleh sidebar-seller.blade.php --}}
    <div class="bg-[#F8FAFC] text-gray-800 p-6 rounded-lg shadow-md h-full">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Settings</h2>

        {{-- Pesan Sukses atau Error --}}
        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 border border-green-200">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 border border-red-200">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex bg-white rounded-md overflow-hidden shadow-md border border-gray-200">
            <div class="w-1/4 border-r border-gray-200 p-6 space-y-6 flex-shrink-0">
                <div class="space-y-4">
                    {{-- Navigasi Panel --}}
                    <a href="#app-description-section" id="apps-settings-link"
                        class="text-gray-600 cursor-pointer help-topic-link" data-target="app-description-section">About Softably</a>
                        <div></div>
                    <a href="#personal-info-section" id="personal-info-link"
                        class="text-blue-600 font-semibold cursor-pointer help-topic-link" data-target="personal-info-section">Account</a>
                    <div></div>
                    <a href="#change-password-section" id="change-password-link"
                        class="text-gray-600 cursor-pointer help-topic-link" data-target="change-password-section">Password</a>
                    {{-- Tambahkan link lain di sini jika ada seperti About Softably --}}                    
                </div>
            </div>

            <div class="w-3/4 p-6 flex-grow">
                {{-- Bagian untuk Personal Info --}}
                <div id="personal-info-section" class="space-y-6 help-content-panel active"> {{-- Aktif secara default --}}
                    <h3 class="text-xl font-semibold mb-1 text-gray-800">Personal Info</h3>
                    <p class="text-gray-600 text-sm mb-6">Update your personal details</p>

                    <form method="POST" action="{{ route('seller.setting.update') }}" enctype="multipart/form-data"
                        class="space-y-5">
                        @csrf
                        @method('PUT') {{-- Penting: Gunakan method PUT untuk update --}}

                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
                                @php
                                    $profilePicture = Auth::user()->profile_picture;
                                    $imageUrl = ($profilePicture && file_exists(public_path($profilePicture))) // Cek file fisik
                                        ? asset($profilePicture)
                                        : asset('img/man.jpg');
                                @endphp
                                <img src="{{ $imageUrl }}" alt="Foto Profil" class="w-full h-full object-cover">
                            </div>

                            <label
                                class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg border border-blue-600 cursor-pointer hover:bg-blue-700 transition">
                                Upload Image
                                <input type="file" name="profile_picture" accept="image/*" class="hidden">
                            </label>
                            <span class="text-xs text-gray-600">JPG or PNG. 1MB Max</span>
                        </div>

                        <div>
                            <label for="name" class="block text-sm mb-1 text-gray-700">Full name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                        </div>

                        <div>
                            <label for="username" class="block text-sm mb-1 text-gray-700">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username', Auth::user()->username) }}"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                        </div>

                        <div>
                            <label for="email" class="block text-sm mb-1 text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm mb-1 text-gray-700">Phone number</label>
                            <input type="text" id="phone_number" name="phone_number"
                                value="{{ old('phone_number', Auth::user()->phone_number) }}"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                        </div>

                        <div>
                            <label for="date_of_birth" class="block text-sm mb-1 text-gray-700">Date of birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth"
                                value="{{ old('date_of_birth', Auth::user()->date_of_birth ? \Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('Y-m-d') : '') }}"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                        </div>

                        <div>
                            <label for="country" class="block text-sm mb-1 text-gray-700">Country</label>
                            <input type="text" id="country" name="country"
                                value="{{ old('country', Auth::user()->country ?? 'Indonesia') }}"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-gray-600 cursor-not-allowed shadow-sm"
                                disabled>
                        </div>

                        <div class="flex justify-end gap-4 mt-6">
                            <button type="reset" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Save</button>
                        </div>
                    </form>
                </div>

                {{-- Bagian untuk Ganti Password --}}
                <div id="change-password-section" class="space-y-6 help-content-panel hidden">
                    <h3 class="text-xl font-semibold mb-1 text-gray-800">Change Password</h3>
                    <p class="text-gray-600 text-sm mb-6">Update your password</p>

                    <form method="POST" action="{{ route('seller.setting.updatePassword') }}" class="space-y-4 text-sm">
                        @csrf
                        @method('PUT') {{-- Penting: Gunakan method PUT untuk update --}}

                        <div>
                            <label for="current_password" class="block text-gray-700 mb-1">Current Password</label>
                            <input type="password" id="current_password" name="current_password"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" required>
                            @error('current_password')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-gray-700 mb-1">New Password</label>
                            <input type="password" id="password" name="password"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" required>
                            @error('password')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" required>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Update Password</button>
                        </div>
                    </form>
                </div>

                {{-- Bagian untuk About Softably (jika ada, mirip dengan customer) --}}
                <div id="app-description-section" class="space-y-6 help-content-panel hidden">
                    <h2 class="text-lg font-bold text-gray-800">About Softably</h2>
                    <p class="text-sm text-gray-700">
                        Softably adalah platform inovatif yang dirancang untuk membantu Anda mengelola produk, melacak notifikasi, berinteraksi melalui chat, dan banyak lagi. Kami berkomitmen untuk menyediakan pengalaman pengguna yang lancar dan efisien.
                    </p>
                    <p class="text-sm text-gray-700">
                        Versi Aplikasi: 1.0.0 <br>
                        Hak Cipta &copy; 2023 Softably. Semua hak dilindungi undang-undang.
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- Script untuk mengaktifkan tab --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const personalInfoLink = document.getElementById('personal-info-link');
            const changePasswordLink = document.getElementById('change-password-link');
            const appsSettingsLink = document.getElementById('apps-settings-link'); // Untuk About Softably
            
            const personalInfoSection = document.getElementById('personal-info-section');
            const changePasswordSection = document.getElementById('change-password-section');
            const appDescriptionSection = document.getElementById('app-description-section'); // Untuk About Softably

            const helpTopicLinks = document.querySelectorAll('.help-topic-link');
            const helpContentPanels = document.querySelectorAll('.help-content-panel');

            function showSection(sectionToShow, activeLinkElement) {
                helpContentPanels.forEach(panel => {
                    panel.classList.add('hidden');
                });
                helpTopicLinks.forEach(link => {
                    link.classList.remove('text-blue-600', 'font-semibold');
                    link.classList.add('text-gray-600');
                });

                sectionToShow.classList.remove('hidden');
                activeLinkElement.classList.add('text-blue-600', 'font-semibold');
                activeLinkElement.classList.remove('text-gray-600');
            }

            personalInfoLink.addEventListener('click', function(e) {
                e.preventDefault();
                showSection(personalInfoSection, personalInfoLink);
            });

            changePasswordLink.addEventListener('click', function(e) {
                e.preventDefault();
                showSection(changePasswordSection, changePasswordLink);
            });

            appsSettingsLink.addEventListener('click', function(e) {
                e.preventDefault();
                showSection(appDescriptionSection, appsSettingsLink);
            });

            // Logika untuk menampilkan bagian yang benar saat halaman dimuat atau ada error
            @if($errors->any())
                // Jika ada error (misalnya dari form Personal Info atau Password), deteksi field error
                const errorFields = Object.keys(@json($errors->messages()));
                if (errorFields.includes('current_password') || errorFields.includes('password')) {
                    showSection(changePasswordSection, changePasswordLink);
                } else {
                    // Defaultnya Personal Info jika error di field personal info lainnya
                    showSection(personalInfoSection, personalInfoLink);
                }
            @else
                // Default saat halaman dimuat, tampilkan Personal Info
                showSection(personalInfoSection, personalInfoLink);
            @endif
        });
    </script>
@endsection