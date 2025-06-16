@extends('layouts.sidebar')

@section('isi')
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart Customer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>

  <body class="bg-[#0f172a] text-white font-sans">
    <div class="flex min-h-screen">
      <main class="flex w-full h-screen bg-[#0f172a] text-white ml-64">
        <!-- Chat Sidebar -->
        <div class="w-full md:w-1/4 xl:w-2/6 border-r border-gray-700 p-4">
          <h1 class="text-2xl font-semibold mb-4">Chat</h1>

          <!-- Search -->
          <div class="relative mb-4">
            <input
              type="text"
              placeholder="Search people"
              class="w-full bg-[#1e293b] text-white py-2 px-4 rounded focus:outline-none"
            />
            <span class="absolute right-4 top-2 text-sm text-gray-400"
              >All</span
            >
          </div>

          <!-- Chat List -->
          <ul class="space-y-3 overflow-y-auto max-h-[calc(100vh-200px)] pr-2">
            <li
              class="flex items-center gap-3 cursor-pointer hover:bg-[#1e293b] p-2 rounded"
            >
              <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-700">
                <img
                  src="img/man.jpg"
                  alt="Profile"
                  class="w-full h-full object-cover"
                  onerror="this.onerror=null; this.src='img/default-user.jpg';"
                />
              </div>
              <div class="flex-1">
                <p class="font-semibold text-white">Toko Ahmad</p>
                <p class="text-sm text-gray-400 truncate">
                  Hai aku ahmad te....
                </p>
              </div>
              <span class="text-sm text-gray-400">21.22</span>
            </li>
            <li
              class="flex items-center gap-3 cursor-pointer hover:bg-[#1e293b] p-2 rounded"
            >
              <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-700">
                <img
                  src="img/man.jpg"
                  alt="Profile"
                  class="w-full h-full object-cover"
                  onerror="this.onerror=null; this.src='img/default-user.jpg';"
                />
              </div>
              <div class="flex-1">
                <p class="font-semibold text-white">Toko Ahmad</p>
                <p class="text-sm text-gray-400 truncate">
                  Hai aku ahmad te....
                </p>
              </div>
              <span class="text-sm text-gray-400">21.22</span>
            </li>
            <li
              class="flex items-center gap-3 cursor-pointer hover:bg-[#1e293b] p-2 rounded"
            >
              <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-700">
                <img
                  src="img/man.jpg"
                  alt="Profile"
                  class="w-full h-full object-cover"
                  onerror="this.onerror=null; this.src='img/default-user.jpg';"
                />
              </div>
              <div class="flex-1">
                <p class="font-semibold text-white">Toko Ahmad</p>
                <p class="text-sm text-gray-400 truncate">
                  Hai aku ahmad te....
                </p>
              </div>
              <span class="text-sm text-gray-400">21.22</span>
            </li>
            <li
              class="flex items-center gap-3 cursor-pointer hover:bg-[#1e293b] p-2 rounded"
            >
              <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-700">
                <img
                  src="img/man.jpg"
                  alt="Profile"
                  class="w-full h-full object-cover"
                  onerror="this.onerror=null; this.src='img/default-user.jpg';"
                />
              </div>
              <div class="flex-1">
                <p class="font-semibold text-white">Toko Ahmad</p>
                <p class="text-sm text-gray-400 truncate">
                  Hai aku ahmad te....
                </p>
              </div>
              <span class="text-sm text-gray-400">21.22</span>
            </li>
            <li
              class="flex items-center gap-3 cursor-pointer hover:bg-[#1e293b] p-2 rounded"
            >
              <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-700">
                <img
                  src="img/man.jpg"
                  alt="Profile"
                  class="w-full h-full object-cover"
                  onerror="this.onerror=null; this.src='img/default-user.jpg';"
                />
              </div>
              <div class="flex-1">
                <p class="font-semibold text-white">Toko Ahmad</p>
                <p class="text-sm text-gray-400 truncate">
                  Hai aku ahmad te....
                </p>
              </div>
              <span class="text-sm text-gray-400">21.22</span>
            </li>
            <li
              class="flex items-center gap-3 cursor-pointer hover:bg-[#1e293b] p-2 rounded"
            >
              <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-700">
                <img
                  src="img/man.jpg"
                  alt="Profile"
                  class="w-full h-full object-cover"
                  onerror="this.onerror=null; this.src='img/default-user.jpg';"
                />
              </div>
              <div class="flex-1">
                <p class="font-semibold text-white">Toko Ahmad</p>
                <p class="text-sm text-gray-400 truncate">
                  Hai aku ahmad te....
                </p>
              </div>
              <span class="text-sm text-gray-400">21.22</span>
            </li>
            <li
              class="flex items-center gap-3 cursor-pointer hover:bg-[#1e293b] p-2 rounded"
            >
              <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-700">
                <img
                  src="img/man.jpg"
                  alt="Profile"
                  class="w-full h-full object-cover"
                  onerror="this.onerror=null; this.src='img/default-user.jpg';"
                />
              </div>
              <div class="flex-1">
                <p class="font-semibold text-white">Toko Ahmad</p>
                <p class="text-sm text-gray-400 truncate">
                  Hai aku ahmad te....
                </p>
              </div>
              <span class="text-sm text-gray-400">21.22</span>
            </li>
          </ul>
        </div>

        <!-- Chat Content -->
        <div class="flex-1 p-4 space-y-6 flex flex-col bg-[#0f172a]">
          <!-- Chat Header -->
          <div
            class="flex justify-between items-center border-b border-gray-700 pb-4"
          >
            <div>
              <p class="font-bold text-lg">Template Canva</p>
              <p class="text-sm text-gray-400">Selesai pada 2-21-2025</p>
            </div>
            <button
              class="bg-[#1d4ed8] hover:bg-[#2563eb] px-4 py-1 text-sm rounded text-white"
            >
              Check Details
            </button>
          </div>

          <!-- Date Separator -->
          <div class="text-center">
            <span class="bg-[#1e293b] text-sm px-4 py-1 rounded-full"
              >Hari ini</span
            >
          </div>

          <!-- Chat Messages -->
          <div
            class="flex flex-col space-y-4 overflow-y-auto max-h-[calc(100vh-300px)] pr-2"
          >
            <!-- Message from other -->
            <div class="bg-[#1e293b] p-4 rounded max-w-xl">
              <p class="text-sm leading-relaxed text-gray-200">
                Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                suspendisse lorem. Mauris neque amet purus commodo nulla tellus
                massa. Amet nisi nibh fermentum cras tincidunt feugiat leo id. A
                odio leo gravida lectus ipsum.
              </p>
            </div>

            <!-- Message from user -->
            <div class="bg-[#1e293b] p-4 rounded self-end max-w-xl">
              <p class="text-sm leading-relaxed text-gray-200">
                Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                suspendisse lorem. Mauris neque amet purus commodo nulla tellus
                massa. Amet nisi nibh fermentum cras tincidunt feugiat leo id. A
                odio leo gravida lectus ipsum.
              </p>
            </div>
            <div class="bg-[#1e293b] p-4 rounded max-w-xl">
              <p class="text-sm leading-relaxed text-gray-200">
                Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                suspendisse lorem. Mauris neque amet purus commodo nulla tellus
                massa. Amet nisi nibh fermentum cras tincidunt feugiat leo id. A
                odio leo gravida lectus ipsum.
              </p>
            </div>

            <!-- Message from user -->
            <div class="bg-[#1e293b] p-4 rounded self-end max-w-xl">
              <p class="text-sm leading-relaxed text-gray-200">
                Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                suspendisse lorem. Mauris neque amet purus commodo nulla tellus
                massa. Amet nisi nibh fermentum cras tincidunt feugiat leo id. A
                odio leo gravida lectus ipsum.
              </p>
            </div>
            <div class="bg-[#1e293b] p-4 rounded max-w-xl">
              <p class="text-sm leading-relaxed text-gray-200">
                Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                suspendisse lorem. Mauris neque amet purus commodo nulla tellus
                massa. Amet nisi nibh fermentum cras tincidunt feugiat leo id. A
                odio leo gravida lectus ipsum.
              </p>
            </div>

            <!-- Message from user -->
            <div class="bg-[#1e293b] p-4 rounded self-end max-w-xl">
              <p class="text-sm leading-relaxed text-gray-200">
                Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                suspendisse lorem. Mauris neque amet purus commodo nulla tellus
                massa. Amet nisi nibh fermentum cras tincidunt feugiat leo id. A
                odio leo gravida lectus ipsum.
              </p>
            </div>
            <div class="bg-[#1e293b] p-4 rounded max-w-xl">
              <p class="text-sm leading-relaxed text-gray-200">
                Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                suspendisse lorem. Mauris neque amet purus commodo nulla tellus
                massa. Amet nisi nibh fermentum cras tincidunt feugiat leo id. A
                odio leo gravida lectus ipsum.
              </p>
            </div>

            <!-- Message from user -->
            <div class="bg-[#1e293b] p-4 rounded self-end max-w-xl">
              <p class="text-sm leading-relaxed text-gray-200">
                Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                suspendisse lorem. Mauris neque amet purus commodo nulla tellus
                massa. Amet nisi nibh fermentum cras tincidunt feugiat leo id. A
                odio leo gravida lectus ipsum.
              </p>
            </div>
          </div>

          <!-- Chat Input (Opsional) -->

          <div class="mt-auto pt-4 border-t border-gray-700">
            <div class="flex gap-2">
              <input
                type="text"
                placeholder="Ketik pesan..."
                class="flex-1 px-4 py-2 bg-[#1e293b] text-white rounded focus:outline-none"
              />
              <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded"
              >
                 <i class="fa-solid fa-paper-plane"></i>
              </button>
            </div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>
@endsection