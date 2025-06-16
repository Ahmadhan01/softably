@extends('layouts.sidebar')

@section('isi')
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<main class="flex-1 p-6 space-y-6 ml-64">

            <div class="sticky top-[25px] z-40 bg-[#1e293b] p-2 flex justify-between items-center shadow-md rounded-lg">

                <div class="relative max-w-md w-full">
                    <input type="text" id="simple-search"
                        class="
                            bg-gray-700 border border-gray-600 text-white text-sm rounded-lg
                            focus:ring-blue-500 focus:border-blue-500 block w-full
                            pl-10 pr-4 py-2.5 h-10
                        "
                        placeholder="Search product..." required />
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>

                <div class="flex-1"></div>

                <div class="flex gap-4 items-center">
                    <a href="/wishlist_customer" class="text-green-500 text-lg hover:text-green-400">
                        <i class="fa-solid fa-bookmark"></i>
                    </a>
                    <a href="/cart_customer" class="text-white text-lg hover:text-blue-400">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                </div>
            </div>


            <div class="flex justify-between items-center"> <h2 class="text-5xl font-bold">Temukan produk<br>yang kamu sukai</h2>
                <p class="text-sm text-gray-300 max-w-xl text-right"> Lorem ipsum dolor sit amet consectetur. Nunc hac viverra
                    aliquam malesuada. Pulvinar facilisis aliquam urna ut hendrerit urna in. Lorem ipsum dolor sit amet,
                    consectetur adipisicing elit. Voluptas repellendus repellat voluptate itaque recusandae, error earum ab
                    id eos. Unde harum illum atque magni incidunt rerum adipisci sequi necessitatibus. Explicabo?
                </p>
            </div>  
            <div class="grid grid-cols-4 grid-rows-2 gap-4 mt-6">
                <!-- Kiri besar -->
                <div class="col-span-2 row-span-2 bg-gray-300 rounded h-[343px] rounded-lg">
                    <img src="img/promosi.png" alt="" class="w-full h-full object-cover rounded-lg">
                </div>

                <!-- Kanan atas 2 kotak kecil -->
                <div class="col-span-1 bg-gray-300 rounded h-[160px] rounded-lg">
                    <img src="img/belanja.png" alt="" class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="col-span-1 bg-gray-300 rounded h-[160px] rounded-lg">
                    <img src="img/berjualan.png" alt="" class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="col-span-1 bg-gray-300 rounded h-[163px] rounded-lg">
                    <img src="img/semua.png" alt="" class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="col-span-1 bg-gray-300 rounded h-[163px] rounded-lg">
                    <img src="img/bisa.png" alt="" class="w-full h-full object-cover rounded-lg">
                </div>

            </div>



            <!-- Filters -->
            <div class="flex justify-between items-center mt-6">
                <div class="flex gap-4 sm:gap-6">
                    <details class="group relative">
                        <summary
                        class="flex items-center gap-2 border-b border-gray-300 pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 dark:border-gray-600 dark:text-gray-200 dark:hover:border-gray-700 dark:hover:text-white [&::-webkit-details-marker]:hidden"
                        >
                        <span class="text-sm"> Category </span>

                        <span class="transition-transform group-open:-rotate-180">
                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-4"
                            >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </span>
                        </summary>

                        <div
                        class="z-50 w-64 divide-y divide-gray-300 rounded border border-gray-300 bg-white shadow-sm group-open:absolute group-open:start-0 group-open:top-8 dark:divide-gray-600 dark:border-gray-600 dark:bg-gray-900"
                        >
                        <div class="flex items-center justify-between px-3 py-2">
                            <span class="text-sm text-gray-700 dark:text-gray-200"> 0 Selected </span>

                            <button
                            type="button"
                            class="text-sm text-gray-700 underline transition-colors hover:text-gray-900 dark:text-gray-200 dark:hover:text-white"
                            >
                            Reset
                            </button>
                        </div>

                        <fieldset class="p-3">
                            <legend class="sr-only">Checkboxes</legend>

                            <div class="flex flex-col items-start gap-3">
                            <label for="Option1" class="inline-flex items-center gap-3">
                                <input
                                type="checkbox"
                                class="size-5 rounded border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-900 dark:ring-offset-gray-900 dark:checked:bg-blue-600"
                                id="Option1"
                                />

                                <span class="text-sm text-gray-700 dark:text-gray-200"> Option 1 </span>
                            </label>

                            <label for="Option2" class="inline-flex items-center gap-3">
                                <input
                                type="checkbox"
                                class="size-5 rounded border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-900 dark:ring-offset-gray-900 dark:checked:bg-blue-600"
                                id="Option2"
                                />

                                <span class="text-sm text-gray-700 dark:text-gray-200"> Option 2 </span>
                            </label>

                            <label for="Option3" class="inline-flex items-center gap-3">
                                <input
                                type="checkbox"
                                class="size-5 rounded border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-900 dark:ring-offset-gray-900 dark:checked:bg-blue-600"
                                id="Option3"
                                />

                                <span class="text-sm text-gray-700 dark:text-gray-200"> Option 3 </span>
                            </label>
                            </div>
                        </fieldset>
                        </div>
                    </details>

                    <details class="group relative">
                        <summary
                        class="flex items-center gap-2 border-b border-gray-300 pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 dark:border-gray-600 dark:text-gray-200 dark:hover:border-gray-700 dark:hover:text-white [&::-webkit-details-marker]:hidden"
                        >
                        <span class="text-sm"> Price </span>

                        <span class="transition-transform group-open:-rotate-180">
                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-4"
                            >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </span>
                        </summary>

                        <div
                        class="z-50 w-64 divide-y divide-gray-300 rounded border border-gray-300 bg-white shadow-sm group-open:absolute group-open:start-0 group-open:top-8 dark:divide-gray-600 dark:border-gray-600 dark:bg-gray-900"
                        >
                        <div class="flex items-center justify-between px-3 py-2">
                            <span class="text-sm text-gray-700 dark:text-gray-200"> Max price is $600 </span>

                            <button
                            type="button"
                            class="text-sm text-gray-700 underline transition-colors hover:text-gray-900 dark:text-gray-200 dark:hover:text-white"
                            >
                            Reset
                            </button>
                        </div>

                        <div class="flex items-center gap-3 p-3">
                            <label for="MinPrice">
                            <span class="text-sm text-gray-700 dark:text-gray-200"> Min </span>

                            <input
                                type="number"
                                id="MinPrice"
                                value="0"
                                class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                            />
                            </label>

                            <label for="MaxPrice">
                            <span class="text-sm text-gray-700 dark:text-gray-200"> Max </span>

                            <input
                                type="number"
                                id="MaxPrice"
                                value="600"
                                class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                            />
                            </label>
                        </div>
                        </div>
                    </details>
                    </div>

                <div class="flex gap-2 items-center">
                    <label for="sort" class="text-sm mb-1">Sort by:</label>
                    <select id="sort" class="bg-[#1E293B] border border-[#334155] text-white text-sm px-2 py-1 rounded">
                        <option>Best Seller</option>
                        <option>Newest</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <!-- Bungkus Sort by dan Showing agar 1 baris dan sejajar tengah -->
                    <div class="flex flex-col text-right justify-center leading-snug">

                        <div>Showing 12 out of 20 results.</div>
                    </div>

                    <!-- Ikon grid -->
                    <div class="flex gap-2">
                        <a class="w-6 h-6 bg-gray-600 rounded flex items-center justify-center">
                            <i class="fa-solid fa-border-all"></i>
                        </a>
                        <a class="w-6 h-6 bg-gray-600 rounded flex items-center justify-center">
                            <i class="fa-solid fa-grip"></i>
                        </a>
                    </div>
                </div>
            </div>


            <!-- Product grid -->
            <div class="grid grid-cols-5 gap-4 mt-6">
                <!-- Card Product -->
                <template id="product-card">
                    <a href="/viewproduk-customer" class="block">
                        <div
                            class="bg-[#1E293B] p-4 rounded-lg relative shadow-md hover:shadow-lg transition-shadow duration-300">

                            <!-- Bookmark Ikon -->
                            <div
                                class="absolute top-3 right-3 w-8 h-8 bg-orange-400 text-white rounded-full flex items-center justify-center shadow-lg ring-2 ring-white">
                                <i class="fa-solid fa-bookmark text-sm"></i>
                            </div>

                            <!-- Gambar -->
                            <div class="overflow-hidden rounded-lg border-2 border-white mb-3">
                                <img src="img/novel.png" alt="Template CapCut" class="w-full object-cover" />
                            </div>

                            <!-- Harga -->
                            <p class="text-orange-400 font-bold mb-1">Rp.59.999,00</p>

                            <!-- Judul -->
                            <p class="font-semibold">Template CapCut</p>

                            <!-- Deskripsi -->
                            <p class="text-sm text-gray-400 leading-tight">
                                Description Description Description Description Description
                            </p>

                            <!-- Keranjang -->
                            <div class="absolute bottom-4 right-4 text-white">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>
                        </div>
                    </a>
                </template>



                <!-- Duplicate cards -->
                <script>
                    const grid = document.currentScript.parentElement;
                    const cardTemplate = document.getElementById("product-card").content;
                    for (let i = 0; i < 15; i++) {
                        grid.appendChild(cardTemplate.cloneNode(true));
                    }
                </script>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-6 space-x-2">
                <button class="px-2 py-1 bg-[#1E293B] rounded">&#x3c;</button>
                <button class="px-3 py-1 bg-blue-600 rounded text-white">1</button>
                <button class="px-2 py-1 bg-[#1E293B] rounded">2</button>
                <button class="px-2 py-1 bg-[#1E293B] rounded">3</button>
                <button class="px-2 py-1 bg-[#1E293B] rounded">4</button>
                <button class="px-2 py-1 bg-[#1E293B] rounded">5</button>
                <button class="px-2 py-1 bg-[#1E293B] rounded">6</button>
            </div>
        </main>
    </div>
    <script src="js/index.js" defer></script>
@endsection