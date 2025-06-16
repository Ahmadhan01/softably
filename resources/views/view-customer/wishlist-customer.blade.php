<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product</title>
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
        <div class="flex items-center justify-between mb-6">
          <a
            href="produk_customer.html"
            class="text-md text-white hover:underline"
            ><i class="fa-solid fa-arrow-left"></i>&nbsp; Wishlist</a
          >
          <div class="flex space-x-4 items-center">
            <a class="text-lg" href="wishlist_customer.html">
              <i class="fa-solid fa-bookmark text-green-500"></i>
            </a>
            <a class="text-lg" href="cart_customer.html">
              <i class="fa-solid fa-cart-shopping"></i>
            </a>
          </div>
        </div>

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

        <div class="space-y-6">
          <!-- Product Card -->
          <template id="wishlist-card">
            <div
              class="bg-[#1e293b] p-5 rounded-xl flex justify-between items-start"
            >
              <div class="flex items-start gap-5">
                <div
                  class="w-48 h-48 bg-[#0f172a] rounded-xl relative flex items-center justify-center"
                >
                  <!-- Bookmark -->
                  <div class="absolute top-2 right-2 text-green-400 text-md">
                    <i class="fa-solid fa-bookmark"></i>
                  </div>
                  <!-- Image Placeholder -->
                  <i class="fa-solid fa-image text-2xl text-gray-500"></i>
                  <!-- Cart Icon -->
                  <div class="absolute bottom-2 right-2 text-white text-md">
                    <i class="fa-solid fa-cart-shopping"></i>
                  </div>
                </div>
                <div>
                  <p class="text-sm text-gray-300 mb-1">Toko Ahmad</p>
                  <h2 class="text-lg font-bold mb-2 text-white">
                    Template canva
                  </h2>
                  <p class="text-sm text-gray-400 max-w-md leading-snug mb-6">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                    suspendisse lorem. Mauris neque amet purus commodo nulla
                    tellus massa. Amet nisi nibh fermentum cras tincidunt
                    feugiat leo id. A odio leo gravida lectus ipsum.
                  </p>
                  <a
                    href="/viewproduk_customer"
                    class="px-4 py-1 text-sm rounded border border-white hover:bg-white hover:text-[#0f172a] transition"
                  >
                    Check Details
                  </a>
                </div>
              </div>
              <!-- Price -->
              <div class="text-orange-400 font-bold text-lg">Rp. 39.999,00</div>
            </div>
          </template>

          <script>
            const grid = document.currentScript.parentElement;
            const cardTemplate =
              document.getElementById("wishlist-card").content;
            for (let i = 0; i < 6; i++) {
              grid.appendChild(cardTemplate.cloneNode(true));
            }
          </script>
        </div>
      </main>
    </div>
  </body>
</html>
