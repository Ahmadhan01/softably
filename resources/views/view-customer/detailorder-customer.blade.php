<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>

  <body class="bg-[#0f172a] text-white font-sans">
    <div class="flex min-h-screen">
      <aside
        class="w-64 bg-[#1e293b] flex flex-col justify-between fixed top-0 left-0 h-full"
      >
        <div>
          <div class="p-4 text-xl font-bold border-b border-gray-700">
            <img src="img/logo-softably.png" alt="" width="120px" />
          </div>
          <nav class="p-4 space-y-2 text-sm text-gray-300">
            <a
              href="/produk_customer"
              class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"
            >
              <i class="fa-solid fa-box" style="color: #ffffff"></i
              ><span>Product</span>
            </a>
            <a
              href="/cart_customer"
              class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"
            >
              <i class="fa-solid fa-cart-shopping"></i><span>Cart</span>
            </a>
            <a
              href="/order_customer"
              class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"
            >
              <i class="fa-solid fa-list-ul"></i><span>My Orders</span>
            </a>
            <a
              href="/notif_customer"
              class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"
            >
              <i class="fa-solid fa-bell"></i><span>Notification</span>
              <span
                class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full"
                >4</span
              >
            </a>
            <a
              href="/chat_customer"
              class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"
            >
              <i class="fa-solid fa-comments"></i><span>Chat</span>
              <span
                class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full"
                >10</span
              >
            </a>
            <a
              href="/faq_customer"
              class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"
            >
              <i class="fa-solid fa-circle-question"></i><span>FAQ</span>
            </a>
          </nav>
          <div class="p-4 border-t border-gray-700">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 rounded-full overflow-hidden">
                <img
                  src="img/man.jpg"
                  alt=""
                  class="w-full h-full object-cover"
                />
              </div>
              <div>
                <div class="font-medium">Fuad Pharaoh</div>
                <div class="text-sm text-gray-400">
                  <a href="setting_customer.html">Account settings</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="p-4 space-y-2">
          <a
            href="/setting_customer"
            class="flex items-center space-x-2 text-gray-400 hover:text-white"
          >
            <span>⚙️</span><span>Settings</span>
          </a>
          <a
            href="/login"
            class="flex items-center space-x-2 text-gray-400 hover:text-white"
          >
            <span>🚪</span><span>Log Out</span>
          </a>
        </div>
      </aside>

      <main class="flex-1 p-6 space-y-6 ml-64">
        <a href="order_customer.html" class="text-sm text-white hover:underline"
          ><i class="fa-solid fa-arrow-left"></i>&nbsp; Order Detail</a
        >

        <div class="bg-[#1e293b] p-6 rounded-lg space-y-6">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-gray-400">Order status</p>
              <p class="font-semibold text-white">Finished</p>
            </div>
            <button
              class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm font-semibold"
            >
              Give a Ratings
            </button>
          </div>
          <div>
            <p class="text-gray-400">Order id</p>
            <p class="font-semibold">1234</p>
          </div>

          <div class="flex gap-4">
            <!-- Gambar produk -->
            <div class="w-48 h-36 rounded-lg bg-white flex-shrink-0">
              <img
                src="img/download.jpeg"
                alt=""
                class="w-full h-full object-cover rounded-lg"
              />
            </div>

            <!-- Info produk -->
            <div class="flex-1 space-y-1">
              <p class="text-sm text-gray-400">Toko Ahmad</p>
              <h2 class="text-lg font-bold">Template canva</h2>
              <p class="text-sm text-gray-400">
                Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                suspendisse lorem. Mauris neque amet purus commodo nulla tellus
                massa. Amet nisi nibh fermentum cras tincidunt feugiat leo id. A
                odio leo gravida lectus ipsum.
              </p>
            </div>

            <div class="flex flex-col items-end gap-2">
              <button
                class="border border-gray-500 text-white text-sm px-3 py-1 rounded hover:bg-gray-700"
              >
                View Store
              </button>

              <div class="flex flex-col items-end mt-2">
                <p class="text-sm text-gray-400">x2</p>
                <p class="text-white font-semibold">Rp. 59.999,00</p>
              </div>
            </div>
          </div>

          <div
            class="bg-[#334155] text-sm text-gray-200 p-3 rounded-lg flex items-center justify-between"
          >
            <span
              >https://Lorem ipsum dolor sit amet consectetur. Pulvinar sed
              egestas suspendisse lorem. Mauris neque amet purus commodo nulla
              tellus massa. Amet nisi nibh fermentum cras tincidunt feugiat leo
              id. A odio leo gravida lectus ipsum.</span
            >
          </div>
          <div class="flex items-start justify-end">
            <button
              class="border border-gray-500 text-white text-sm px-3 py-1 rounded hover:bg-gray-700"
            >
              <i class="fa-solid fa-clipboard"></i> Copy
            </button>
          </div>

          <!-- Rincian pembayaran -->
          <div class="text-sm text-gray-400 space-y-1">
            <div class="flex justify-between">
              <span>Payment method</span>
              <span class="text-white font-medium">Rp. 59.999,00</span>
            </div>
            <div class="flex justify-between">
              <span>Discount</span>
              <span class="text-white font-medium">0</span>
            </div>
            <div class="flex justify-between">
              <span>Convenience fee</span>
              <span class="text-white font-medium">Rp. 15.000,00</span>
            </div>
          </div>

          <div class="flex justify-between items-center text-lg font-bold mt-2">
            <span>Total</span>
            <span class="text-orange-400">Rp. 133.999,00</span>
          </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-end mt-6">
          <div
            class="bg-[#1e293b] p-4 rounded-lg flex items-center relative w-[80%] max-w-3xl"
          >
            <!-- Bagian kiri: nama dan komentar -->
            <div class="flex-1 pr-4">
              <div class="flex items-center justify-between mb-1">
                <p class="text-sm font-semibold">Fuad Pharaoh</p>
                <button class="text-white/70 hover:text-white">
                  <i class="fas fa-pen text-xs"></i>
                </button>
              </div>
              <p class="text-sm text-gray-400">
                Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                suspendisse lorem. Mauris neque amet purus commodo nulla tellus
                massa. Amet nisi nibh fermentum cras tincidunt feugiat leo id. A
                odio leo gravida lectus ipsum.
              </p>
            </div>

            <!-- Avatar kanan -->
            <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0">
              <img
                src="img/man.jpg"
                alt="Avatar"
                class="w-full h-full object-cover"
              />
            </div>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <input
            type="text"
            placeholder="Give A Ratings..."
            class="flex-1 p-3 rounded-md bg-[#1F2A40] text-white border border-gray-600 focus:outline-none"
          />
          <button class="bg-green-500 px-4 py-2 rounded-md hover:bg-green-400">
            <i class="fa-solid fa-paper-plane"></i>
          </button>
        </div>
      </main>
    </div>
    <script src="js/index.js" defer></script>
  </body>
</html>
