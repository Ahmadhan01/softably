@extends('layouts.sidebar')

@section('isi')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Setting Customer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        /* Hapus atau ubah styling khusus untuk input[type="date"] jika tidak lagi diperlukan tema gelap */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: none; /* Kembalikan ke warna default browser */
            cursor: pointer;
        }
        input[type="date"] {
            background-color: white; /* Ubah background menjadi putih */
            color: #333333; /* Ubah teks menjadi gelap */
            border: 1px solid #d1d5db; /* Tambahkan border terang */
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-gray-800"> {{-- Ubah background body menjadi cerah dan teks gelap --}}
    <div class="flex min-h-screen">
        <main class="flex-1 p-6 space-y-6 ml-64 bg-[#F8FAFC]"> {{-- Ubah background main menjadi cerah --}}
            <div class="text-gray-800 space-y-6"> {{-- Ubah warna teks default di sini --}}
                <h1 class="text-2xl font-semibold">Settings</h1>

                {{-- Pesan Sukses atau Error --}}
                @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 border border-green-200"> {{-- Ubah warna alert sukses --}}
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 border border-red-200"> {{-- Ubah warna alert error --}}
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="flex space-x-10">
                    <div class="w-1/6 text-sm space-y-6">
                        <div class="space-y-4">
                            {{-- Tautan "Apps settings" --}}
                            <a href="#app-description" id="apps-settings-link"
                                class="text-blue-600 font-semibold cursor-pointer">Apps settings</a> {{-- Ubah warna link aktif --}}
                                <div>
                                </div>
                            {{-- Tautan "Account" sekarang di bawah "Apps settings" --}}
                            <a href="#account" id="account-link"
                                class="text-gray-600 cursor-pointer">Account</a> {{-- Ubah warna link tidak aktif --}}
                        </div>
                    </div>

                    <div class="w-5/6">
                        {{-- Bagian untuk Deskripsi Aplikasi --}}
                        <div id="app-description-section" class="bg-white p-6 rounded-md shadow-md space-y-6"> {{-- Ubah background card dan tambahkan shadow --}}
                            <h2 class="text-lg font-bold text-gray-800">About Softably</h2> {{-- Ubah warna teks --}}
                            <p class="text-sm text-gray-700"> {{-- Ubah warna teks --}}
                                Softably adalah platform inovatif yang dirancang untuk membantu Anda mengelola pesanan, melacak notifikasi, berinteraksi melalui chat, dan banyak lagi. Kami berkomitmen untuk menyediakan pengalaman pengguna yang lancar dan efisien.
                            </p>
                            <p class="text-sm text-gray-700"> {{-- Ubah warna teks --}}
                                Versi Aplikasi: 1.0.0 <br>
                                Hak Cipta &copy; 2023 Softably. Semua hak dilindungi undang-undang.
                            </p>
                        </div>

                        {{-- Form untuk Personal Info (Account) --}}
                        <div id="personal-info-section" class="bg-white p-6 rounded-md shadow-md space-y-6 hidden mt-6"> {{-- Ubah background card dan tambahkan shadow --}}
                            <div class="flex justify-between items-center">
                                <div>
                                    <h2 class="text-lg font-bold text-gray-800">Personal Info</h2> {{-- Ubah warna teks --}}
                                    <p class="text-sm text-gray-700"> {{-- Ubah warna teks --}}
                                        Update your personal details
                                    </p>
                                </div>
                                <div class="space-x-2">
                                    <a href="{{ route('setting-customer') }}"
                                        class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-1 rounded"> {{-- Ubah warna tombol --}}
                                        Cancel
                                    </a>
                                    <button type="submit" form="personal-info-form"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-1 rounded"> {{-- Ubah warna tombol --}}
                                        Save
                                    </button>
                                </div>
                            </div>

                            {{-- Form Upload Foto Profil --}}
                            <form id="profile-picture-form" action="{{ route('profile.updateProfilePicture') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0 bg-gray-200"> {{-- Ubah background placeholder gambar --}}
                                        <img src="{{ $user->profile_picture_url }}" alt="Profile"
                                            class="w-full h-full object-cover" />
                                    </div>
                                    <div class="space-y-1">
                                        <label for="profile_picture_input"
                                            class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded cursor-pointer"> {{-- Ubah warna tombol upload --}}
                                            Upload image
                                        </label>
                                        <input type="file" name="profile_picture" id="profile_picture_input"
                                            class="hidden"
                                            onchange="document.getElementById('profile-picture-form').submit();">
                                        <p class="text-[10px] text-gray-500">JPG or PNG. 2MB Max</p> {{-- Ubah warna teks --}}
                                    </div>
                                </div>
                            </form>

                            <form id="personal-info-form" action="{{ route('profile.updatePersonal') }}" method="POST"
                                class="space-y-4 text-sm">
                                @csrf
                                <div>
                                    <label for="name" class="block text-gray-700 mb-1">Full name</label> {{-- Ubah warna teks label --}}
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" /> {{-- Ubah input --}}
                                </div>

                                <div>
                                    <label for="email" class="block text-gray-700 mb-1">Email</label> {{-- Ubah warna teks label --}}
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" /> {{-- Ubah input --}}
                                </div>

                                <div>
                                    <label for="phone_number" class="block text-gray-700 mb-1">Phone number</label> {{-- Ubah warna teks label --}}
                                    <div class="flex space-x-2">
                                        <input type="text" id="phone_number" name="phone_number"
                                            value="{{ old('phone_number', $user->phone_number) }}"
                                            class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" /> {{-- Ubah input --}}
                                    </div>
                                </div>

                                <div>
                                    <label for="date_of_birth" class="block text-gray-700 mb-1">Date of birth</label> {{-- Ubah warna teks label --}}
                                    <input type="date" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth', $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '') }}"
                                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" /> {{-- Ubah input --}}
                                </div>

                                <div>
                                    <label for="country" class="block text-gray-700 mb-1">Country</label> {{-- Ubah warna teks label --}}
                                    <input type="text" id="country" name="country"
                                        value="{{ old('country', $user->country ?? 'Indonesia') }}"
                                        class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded text-gray-600 cursor-not-allowed" {{-- Ubah input disabled --}}
                                        disabled />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Script untuk mengaktifkan tab --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const appsSettingsLink = document.getElementById('apps-settings-link');
            const accountLink = document.getElementById('account-link');
            const appDescriptionSection = document.getElementById('app-description-section');
            const personalInfoSection = document.getElementById('personal-info-section');

            function showSection(sectionToShow, activeLink) { // Hapus parameter inactiveLink1, inactiveLink2
                // Sembunyikan semua bagian konten
                appDescriptionSection.classList.add('hidden');
                personalInfoSection.classList.add('hidden');

                // Tampilkan bagian yang dipilih
                sectionToShow.classList.remove('hidden');

                // Reset semua tautan ke warna tidak aktif
                appsSettingsLink.classList.remove('text-blue-600', 'font-semibold');
                appsSettingsLink.classList.add('text-gray-600'); // Ubah ke gray-600
                accountLink.classList.remove('text-blue-600', 'font-semibold');
                accountLink.classList.add('text-gray-600'); // Ubah ke gray-600

                // Aktifkan tautan yang dipilih
                activeLink.classList.add('text-blue-600', 'font-semibold');
                activeLink.classList.remove('text-gray-600'); // Ubah ke gray-600
            }

            appsSettingsLink.addEventListener('click', function(e) {
                e.preventDefault();
                showSection(appDescriptionSection, appsSettingsLink);
            });

            accountLink.addEventListener('click', function(e) {
                e.preventDefault();
                showSection(personalInfoSection, accountLink);
            });

            // Logika untuk menampilkan bagian yang benar saat halaman dimuat atau ada error
            @if($errors->any())
                // Jika ada error (misalnya dari form Personal Info), tetap tampilkan Personal Info dan aktifkan tautan Account
                showSection(personalInfoSection, accountLink);
            @else
                // Default saat halaman dimuat, tampilkan Deskripsi Aplikasi dan aktifkan tautan Apps settings
                showSection(appDescriptionSection, appsSettingsLink);
            @endif
        });
    </script>
</body>

</html>
@endsection