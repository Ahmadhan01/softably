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
      <main class="flex-1 p-6 space-y-6 ml-64">
        <div class="flex items-center justify-between">
          <h1 class="text-2xl font-semibold">Cart</h1>
          <div class="flex items-center space-x-2">
            <i class="fa-solid fa-filter"></i>
            <input
              type="text"
              placeholder="Search product"
              class="bg-[#1e293b] border border-gray-600 text-sm text-white px-3 py-2 rounded w-64 focus:outline-none"
            />
          </div>
        </div>

        <div class="bg-[#1e293b] p-4 rounded-lg shadow">
          <div
            class="flex items-center justify-between text-sm text-gray-400 border-b border-gray-600 pb-2 mb-4"
          >
            <div class="flex items-center space-x-2">
              <input type="checkbox" />
              <span>Product</span>
            </div>
            <span>Price</span>
          </div>

          <!-- Cart Item Start -->
          <div class="space-y-4">
            <!-- Item 1 -->
            <div
              class="flex items-center justify-between bg-[#0f172a] p-4 rounded-lg"
            >
              <div class="flex items-center space-x-4">
                <input type="checkbox" checked />
                <div class="w-24 h-24 bg-gray-700 rounded"></div>
                <div>
                  <p class="text-sm text-gray-300">Toko Ahmad</p>
                  <p class="text-lg font-semibold">Template canva</p>
                  <p class="text-sm text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed
                    egestas.
                  </p>
                </div>
              </div>
              <p class="text-[#f59e0b] font-bold">Rp. 59.999,00</p>
            </div>
            <div
              class="flex items-center justify-between bg-[#0f172a] p-4 rounded-lg"
            >
              <div class="flex items-center space-x-4">
                <input type="checkbox" />
                <div class="w-24 h-24 bg-gray-700 rounded"></div>
                <div>
                  <p class="text-sm text-gray-300">Toko Mamad</p>
                  <p class="text-lg font-semibold">Template canva</p>
                  <p class="text-sm text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed
                    egestas.
                  </p>
                </div>
              </div>
              <p class="text-[#f59e0b] font-bold">Rp. 89.999,00</p>
            </div>
           <div class="space-y-4">
            <!-- Item 1 -->
            <div
              class="flex items-center justify-between bg-[#0f172a] p-4 rounded-lg"
            >
              <div class="flex items-center space-x-4">
                <input type="checkbox" checked />
                <div class="w-24 h-24 bg-gray-700 rounded"></div>
                <div>
                  <p class="text-sm text-gray-300">Toko Ahmad</p>
                  <p class="text-lg font-semibold">Template canva</p>
                  <p class="text-sm text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed
                    egestas.
                  </p>
                </div>
              </div>
              <p class="text-[#f59e0b] font-bold">Rp. 59.999,00</p>
            </div>
            <div class="space-y-4">
            <!-- Item 1 -->
            <div
              class="flex items-center justify-between bg-[#0f172a] p-4 rounded-lg"
            >
              <div class="flex items-center space-x-4">
                <input type="checkbox" checked />
                <div class="w-24 h-24 bg-gray-700 rounded"></div>
                <div>
                  <p class="text-sm text-gray-300">Toko Ahmad</p>
                  <p class="text-lg font-semibold">Template canva</p>
                  <p class="text-sm text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed
                    egestas.
                  </p>
                </div>
              </div>
              <p class="text-[#f59e0b] font-bold">Rp. 59.999,00</p>
            </div>
            <div class="space-y-4">
            <!-- Item 1 -->
            <div
              class="flex items-center justify-between bg-[#0f172a] p-4 rounded-lg"
            >
              <div class="flex items-center space-x-4">
                <input type="checkbox" checked />
                <div class="w-24 h-24 bg-gray-700 rounded"></div>
                <div>
                  <p class="text-sm text-gray-300">Toko Ahmad</p>
                  <p class="text-lg font-semibold">Template canva</p>
                  <p class="text-sm text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed
                    egestas.
                  </p>
                </div>
              </div>
              <p class="text-[#f59e0b] font-bold">Rp. 59.999,00</p>
            </div>

            
       

          <!-- Footer -->
          <div
            class="flex items-center justify-between mt-6 pt-4 border-t border-gray-600 text-sm"
          >
            <div class="flex items-center space-x-4">
              <input type="checkbox" />
              <span>Select All</span>
              <button class="flex items-center text-green-500 hover:underline">
                <i class="fa-solid fa-bookmark mr-1"></i> Add to wishlist
              </button>
              <button class="flex items-center text-red-500 hover:underline">
                <i class="fa-solid fa-trash mr-1"></i> Delete
              </button>
            </div>
            <div class="flex items-center space-x-6">
              <span
                >Total (3 Product) :
                <span class="text-[#f59e0b] font-bold">Rp. 256.000,00</span></span
              >
              <a href="checkout_customer.html"
                class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-400 transition">
                Checkout
            </a>
            </div>
          </div>
        </div>
      </main>
    </div>
    <script src="js/index.js" defer></script>
  </body>
</html>
@endsection