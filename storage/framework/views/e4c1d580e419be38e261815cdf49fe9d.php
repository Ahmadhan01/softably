

<?php $__env->startSection('isi'); ?>



<div class="bg-[#F8FAFC] text-gray-800 min-h-screen p-6 rounded-lg shadow-md"> 
    <h1 class="text-2xl font-bold mb-6 text-gray-800">My Product</h1> 

    <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
        <div class="flex items-center gap-4 w-full md:w-auto">
            <label for="filter-by" class="text-gray-600">Filter by</label> 
            <div class="relative">
                <select id="filter-by"
                    class="appearance-none bg-white border border-gray-300 text-gray-800 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm"> 
                    <option>Best seller</option>
                    <option>Newest</option>
                    <option>Oldest</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600"> 
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3C.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
            <button
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-full text-sm flex items-center gap-1"> 
                Best seller <i class="fa-solid fa-times text-xs ml-1"></i>
            </button>
            <button class="text-gray-600 hover:text-gray-800 flex items-center gap-1"> 
                <i class="fa-solid fa-sort text-lg"></i>
                <span>Sorting</span>
            </button>
        </div>

        
        <form action="<?php echo e(route('seller.products.index')); ?>" method="GET" class="relative w-full md:w-1/3">
            <input type="text" name="search" placeholder="Search product"
                value="<?php echo e(request('search')); ?>" 
                class="w-full bg-white border border-gray-300 text-gray-800 py-2 pl-10 pr-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm"> 
            <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-600"> 
                <i class="fa-solid fa-search"></i>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        
        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col border border-gray-200"> 
            <div class="w-full relative aspect-square"> 
                <?php if($product->image_path): ?>
                <img src="<?php echo e(asset('storage/' . $product->image_path)); ?>" alt="<?php echo e($product->name); ?>"
                    class="absolute inset-0 w-full h-full object-cover rounded-lg"> 

                <?php else: ?>
                <div
                    class="absolute inset-0 w-full h-full bg-gray-200 rounded-lg flex items-center justify-center text-gray-500"> 
                    No Image
                </div>
                <?php endif; ?>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mt-4 mb-2 line-clamp-1"><?php echo e($product->name); ?></h3> 
            
            <p class="text-gray-600 text-sm mb-2 line-clamp-2"> 
                <?php echo e($product->description); ?> 
            </p>
            <p class="text-gray-800 font-bold text-lg mb-4 mt-auto"> 
                <?php echo e($product->currency); ?> <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                
            </p>
            
            <div class="flex gap-2">
                <a href="<?php echo e(route('seller.products.details', $product->id)); ?>"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium text-center transition-colors">
                    Check Details
                </a>
                <form action="<?php echo e(route('seller.products.destroy', $product->id)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg font-medium text-center transition-colors"> 
                        Delete
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full text-center text-gray-600 py-10 bg-white rounded-lg shadow-md border border-gray-200"> 
            <p>Tidak ada produk yang ditemukan.</p> 
            <a href="<?php echo e(route('seller.products.create')); ?>"
                class="text-blue-600 hover:underline mt-4 inline-block">Tambahkan Produk Sekarang</a> 
        </div>
        <?php endif; ?>
    </div>

    <div class="fixed bottom-8 right-8">
        <a href="<?php echo e(route('seller.products.create')); ?>"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-lg font-semibold transition-colors">
            Add Product
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sidebar-seller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Aplikasi\laragon\www\softably\resources\views/view-seller/my-products-seller.blade.php ENDPATH**/ ?>