@extends('layouts.sidebar')

@section('isi')
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>

  <body class="bg-[#10172A] text-white font-sans">
    <main class="flex-1 p-6 space-y-6 ml-64">
      <div class="flex items-center justify-between mb-6">
        <!-- Kiri: Judul -->
        <h1 class="text-2xl font-bold">My Order</h1>

        <!-- Kanan: Ikon Bookmark dan Cart -->
        <div class="flex items-center space-x-4">
          <a href="#" class="text-lg hover:text-blue-400">
            <i class="fa-solid fa-bookmark"></i>
          </a>
          <a href="cart_customer.html" class="text-lg hover:text-blue-400">
            <i class="fa-solid fa-cart-shopping"></i>
          </a>
        </div>
      </div>

      <!-- Filter & Search -->
      <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-2">
          <label class="text-gray-300">Filter by</label>
          <div
            class="flex items-center gap-1 px-3 py-1 bg-gray-700 rounded-full text-sm"
          >
            Purchased
            <button class="ml-1 text-gray-400 hover:text-white">✕</button>
          </div>
          <button class="text-gray-400 hover:text-white">
            <i class="fa-solid fa-filter"></i> Sorting
          </button>
        </div>
        <div class="relative w-full max-w-xs">
          <input
            type="text"
            placeholder="Search product"
            class="w-full px-4 py-2 bg-gray-800 text-sm text-white rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <i
            class="fa fa-search absolute right-3 top-2 text-gray-400 text-sm"
          ></i>
        </div>
      </div>

      <!-- Orders -->
      <div class="space-y-4">
        <!-- Order Card -->
        <template id="order-card">
          <div class="bg-gray-800 p-4 rounded-lg flex items-center gap-6">
            <!-- Gambar lebih besar -->
            <div class="w-48 h-36 rounded-lg bg-white flex-shrink-0">
              <img
                src="img/download.jpeg"
                alt=""
                class="w-full h-full object-cover rounded-lg"
              />
            </div>

            <div class="flex-1">
              <a href="#" class="text-sm text-gray-400">Toko Ahmad</a>
              <h2 class="font-bold text-lg">Template Canva</h2>
              <p class="text-sm text-gray-400 line-clamp-2 mb-2">
                Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                suspendisse lorem. Mauris neque amet purus commodo nulla tellus
                massa. Amet nisi nibh fermentum cras tincidunt feugiat leo id. A
                odio leo gravida lectus ipsum.
              </p>
              <a
                href="detailorder_customer.html"
                class="text-sm px-3 py-1 border border-gray-500 text-white rounded hover:bg-gray-700"
                type="button"
                >Check Details</a
              >
            </div>

            <div
              class="flex flex-col items-end justify-between h-full ml-auto text-right"
            >
              <span class="text-green-400 font-semibold mb-9">✔ Success</span>
              <span class="text-orange-400 font-bold text-lg mt-9"
                >Rp. 59.999,00</span
              >
            </div>
          </div>
        </template>

        <script>
          const grid = document.currentScript.parentElement;
          const cardTemplate = document.getElementById("order-card").content;
          for (let i = 0; i < 5; i++) {
            grid.appendChild(cardTemplate.cloneNode(true));
          }
        </script>
      </div>
    </main>
  </body>
</html>
@endsection