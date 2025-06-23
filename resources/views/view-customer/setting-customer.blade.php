@extends('layouts.sidebar')

@section('isi')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Setting Customer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Chart.js tidak relevan untuk halaman setting ini, bisa dihapus jika tidak digunakan --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    {{-- Tambahkan properti CSS untuk memastikan input date tidak disembunyikan --}}
    <style>
        /* Gaya dasar untuk input date */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1); /* Membalik warna ikon picker agar terlihat di tema gelap */
            cursor: pointer;
        }
        input[type="date"] {
            /* Pastikan background sesuai tema */
            background-color: #0f172a;
            color: white;
        }
    </style>
</head>

<body class="bg-[#0f172a] text-white font-sans">
    <div class="flex min-h-screen">
        <main class="flex-1 p-6 space-y-6 ml-64">
            <div class="text-white space-y-6">
                <h1 class="text-2xl font-semibold">Settings</h1>

                {{-- Pesan Sukses atau Error --}}
                @if(session('success'))
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="bg-red-500 text-white p-3 rounded mb-4">
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
                            <div class="text-gray-300">Apps settings</div>
                            <a href="#account" id="account-link"
                                class="text-blue-400 font-semibold cursor-pointer">Account</a>
                            <a href="#language" id="language-link" class="text-gray-300 cursor-pointer">Language &
                                Region</a>
                        </div>
                    </div>

                    <div class="w-5/6">
                        {{-- Form untuk Personal Info --}}
                        <div id="personal-info-section" class="bg-[#1e293b] p-6 rounded-md space-y-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h2 class="text-lg font-bold">Personal Info</h2>
                                    <p class="text-sm text-gray-400">
                                        Update your personal details
                                    </p>
                                </div>
                                <div class="space-x-2">
                                    {{-- Tombol Cancel akan me-reset form atau kembali --}}
                                    <a href="{{ route('setting-customer') }}"
                                        class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-1 rounded">
                                        Cancel
                                    </a>
                                    <button type="submit" form="personal-info-form"
                                        class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-1 rounded">
                                        Save
                                    </button>
                                </div>
                            </div>

                            {{-- Form Upload Foto Profil --}}
                            <form id="profile-picture-form" action="{{ route('profile.updateProfilePicture') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0 bg-gray-700"> {{-- Tambahkan kembali rounded-full overflow-hidden bg-gray-700 --}}
                                        {{-- Menampilkan gambar profil user atau gambar default --}}
                                        <img src="{{ $user->profile_picture_url }}" alt="Profile"
                                            class="w-full h-full object-cover" /> {{-- Hapus rounded dari img, sudah di div --}}
                                    </div>
                                    <div class="space-y-1">
                                        <label for="profile_picture_input"
                                            class="bg-[#334155] hover:bg-[#475569] text-white text-xs px-3 py-1 rounded cursor-pointer">
                                            Upload image
                                        </label>
                                        <input type="file" name="profile_picture" id="profile_picture_input"
                                            class="hidden"
                                            onchange="document.getElementById('profile-picture-form').submit();">
                                        <p class="text-[10px] text-gray-400">JPG or PNG. 2MB Max</p>
                                    </div>
                                </div>
                            </form>

                            <form id="personal-info-form" action="{{ route('profile.updatePersonal') }}" method="POST"
                                class="space-y-4 text-sm">
                                @csrf
                                <div>
                                    <label for="name" class="block text-gray-400 mb-1">Full name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                        class="w-full px-3 py-2 bg-[#0f172a] border border-[#334155] rounded text-white" />
                                </div>

                                <div>
                                    <label for="email" class="block text-gray-400 mb-1">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="w-full px-3 py-2 bg-[#0f172a] border border-[#334155] rounded text-white" />
                                </div>

                                <div>
                                    <label for="phone_number" class="block text-gray-400 mb-1">Phone number</label>
                                    <div class="flex space-x-2">
                                        <input type="text" id="phone_number" name="phone_number"
                                            value="{{ old('phone_number', $user->phone_number) }}"
                                            class="flex-1 px-3 py-2 bg-[#0f172a] border border-[#334155] rounded text-white" />
                                    </div>
                                </div>

                                <div>
                                    <label for="date_of_birth" class="block text-gray-400 mb-1">Date of birth</label>
                                    {{-- Perubahan penting ada di sini --}}
                                    <input type="date" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth', $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '') }}"
                                        class="w-full px-3 py-2 bg-[#0f172a] border border-[#334155] rounded text-white" />
                                </div>

                                <div>
                                    <label for="country" class="block text-gray-400 mb-1">Country</label>
                                    <input type="text" id="country" name="country"
                                        value="{{ old('country', $user->country ?? 'Indonesia') }}"
                                        class="w-full px-3 py-2 bg-[#0f172a] border border-[#334155] rounded text-white"
                                        disabled />
                                </div>
                            </form>
                        </div>

                        {{-- Bagian untuk Language & Region (contoh, sembunyikan dulu) --}}
                        <div id="language-region-section" class="bg-[#1e293b] p-6 rounded-md space-y-6 hidden mt-6">
                            <h2 class="text-lg font-bold">Language & Region</h2>
                            <p class="text-sm text-gray-400">Settings for language and regional preferences.</p>
                            {{-- Tambahkan form atau konten untuk pengaturan bahasa di sini --}}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Script untuk mengaktifkan tab --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accountLink = document.getElementById('account-link');
            const languageLink = document.getElementById('language-link');
            const personalInfoSection = document.getElementById('personal-info-section');
            const languageRegionSection = document.getElementById('language-region-section');

            function showSection(sectionToShow, sectionToHide, activeLink, inactiveLink) {
                sectionToShow.classList.remove('hidden');
                sectionToHide.classList.add('hidden');
                activeLink.classList.add('text-blue-400', 'font-semibold');
                activeLink.classList.remove('text-gray-300');
                inactiveLink.classList.add('text-gray-300');
                inactiveLink.classList.remove('text-blue-400', 'font-semibold');
            }

            accountLink.addEventListener('click', function(e) {
                e.preventDefault();
                showSection(personalInfoSection, languageRegionSection, accountLink, languageLink);
            });

            languageLink.addEventListener('click', function(e) {
                e.preventDefault();
                showSection(languageRegionSection, personalInfoSection, languageLink, accountLink);
            });

            @if($errors -> any())
            showSection(personalInfoSection, languageRegionSection, accountLink, languageLink);
            @else
            showSection(personalInfoSection, languageRegionSection, accountLink, languageLink);
            @endif
        });
    </script>
</body>

</html>
@endsection