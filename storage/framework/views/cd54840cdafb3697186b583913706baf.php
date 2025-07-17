

<?php $__env->startSection('title', 'Notifikasi Penjual - Softably'); ?>

<?php $__env->startSection('isi'); ?>

    <style>
        /* CSS untuk Animasi Notifikasi */
        .notification-item {
            /* Gaya dasar notifikasi Anda */
            background-color: #FFFFFF; /* Background item notifikasi jadi putih */
            border: 1px solid #E0E0E0; /* Border abu-abu terang */
            border-radius: 0.5rem; /* rounded-lg */
            padding: 1rem; /* p-4 */
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem; /* space-y-4 */
            box-shadow: 0 1px 3px rgba(0,0,0,0.05); /* Sedikit shadow */

            /* Properti untuk animasi */
            opacity: 0; /* Mulai dengan tidak terlihat */
            transform: translateY(40px); /* Mulai sedikit di bawah */
            transition: opacity 0.7s ease-out, transform 0.7s ease-out; /* Durasi dan jenis transisi */
        }

        .notification-item.show {
            opacity: 1; /* Tampilkan */
            transform: translateY(0); /* Geser ke posisi normal */
        }

        .notification-item.read {
            opacity: 0.7; /* 70% opacity untuk notifikasi yang sudah dibaca, lebih terang dari 0.6 */
        }
    </style>


<div class="bg-[#F8FAFC] text-gray-800 h-full flex flex-col p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Notifikasi Penjual</h1>
        <form action="<?php echo e(route('notif-seller.markAllAsRead')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit"
                class="text-sm text-blue-600 hover:text-blue-700"> 
                Mark as read
            </button>
        </form>
    </div>

    
    <div class="bg-white p-6 rounded-lg shadow-md flex-1 overflow-y-auto border border-gray-200" id="notifications-container"> 
        <?php if($notifications->isEmpty()): ?>
        <p class="text-gray-600 text-center py-8">Belum ada notifikasi transaksi untuk produk Anda.</p>
        <?php else: ?>
        <div class="space-y-4">
            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $title = $notification->title;
            $message = $notification->message;
            $isRead = $notification->is_read;
            $timeAgo = $notification->created_at->diffForHumans();
            $iconClass = 'fa-solid fa-info-circle text-gray-500'; // Default icon

            if ($notification->type === 'transaction_alert') {
            $iconClass = 'fa-solid fa-receipt text-blue-600'; // Ubah warna ikon transaksi
            } elseif ($notification->type == 'chat') { // Tambahkan tipe 'chat' jika ada di notifikasi seller
            $iconClass = 'fa-solid fa-comments text-blue-600';
            }
            ?>

            <div class="notification-item <?php echo e($isRead ? 'read' : ''); ?>" id="notification-<?php echo e($notification->id); ?>"> 
                <div class="flex items-start space-x-4 flex-grow">
                    <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200"> 
                        <i class="<?php echo e($iconClass); ?> text-3xl"></i> 
                    </div>
                    <div class="flex-grow">
                        <h2 class="font-semibold text-gray-800"><?php echo e($title); ?></h2>
                        <p class="text-sm text-gray-600 mt-1"> <?php echo e($message); ?>

                        </p>
                        <p class="text-xs text-gray-500 mt-1"> <?php echo e($timeAgo); ?>

                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0 flex items-center">
                    <?php if(!$isRead): ?>
                    <button
                        class="mark-as-read-btn bg-[#2563EB] text-white text-xs font-semibold px-3 py-1 rounded hover:bg-[#3B82F6] transition" 
                        data-notification-id="<?php echo e($notification->id); ?>">
                        Check
                    </button>
                    <?php else: ?>
                    <span class="text-xs text-gray-500">Read</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
        
        <div class="mt-6">
            <?php echo e($notifications->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const markAsReadButtons = document.querySelectorAll('.mark-as-read-btn');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // --- Logika Animasi Notifikasi ---
    const notificationsContainer = document.getElementById('notifications-container');
    if (notificationsContainer) {
        const notificationItems = notificationsContainer.querySelectorAll('.notification-item');
        notificationItems.forEach((item, index) => {
            setTimeout(() => {
                item.classList.add('show'); // Tambahkan kelas 'show' setelah penundaan
            }, index * 100); // Penundaan 100ms untuk setiap item (bisa disesuaikan)
        });
    }

    // --- Logika Mark As Read ---
    markAsReadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const notificationId = this.dataset.notificationId;
            const notificationElement = document.getElementById(
                `notification-${notificationId}`);

            fetch(`/notif-seller/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (notificationElement) {
                            notificationElement.classList.add('read'); // Tambahkan kelas 'read'
                            this.remove(); // Hapus tombol "Check"
                            const parentDiv = this.closest('.flex.items-center');
                            if (parentDiv) {
                                const readSpan = document.createElement('span');
                                readSpan.classList.add('text-xs', 'text-gray-500');
                                readSpan.textContent = 'Read';
                                parentDiv.appendChild(readSpan);
                            }
                        }
                        console.log(data.message);
                        // Opsional: Perbarui counter notifikasi di sidebar jika ada
                        // if (window.updateNotificationBadge) { window.updateNotificationBadge(); }
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                });
        });
    });

    // Event listener untuk tombol "Mark All As Read"
    const markAllAsReadForm = document.querySelector('form[action="<?php echo e(route('notif-seller.markAllAsRead')); ?>"]');
    if (markAllAsReadForm) {
        markAllAsReadForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah submit form default

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelectorAll('.notification-item').forEach(element => { // Ubah selektor menjadi .notification-item
                            element.classList.add('read');
                            const checkButton = element.querySelector('.mark-as-read-btn');
                            if (checkButton) {
                                const parentDiv = checkButton.closest('.flex.items-center');
                                checkButton.remove();
                                if (parentDiv && !parentDiv.querySelector(
                                        '.text-gray-500')) {
                                    const readSpan = document.createElement('span');
                                    readSpan.classList.add('text-xs', 'text-gray-500');
                                    readSpan.textContent = 'Read';
                                    parentDiv.appendChild(readSpan);
                                }
                            }
                        });
                        console.log(data.message);
                        // Opsional: Perbarui counter notifikasi di sidebar jika ada
                        // if (window.updateNotificationBadge) { window.updateNotificationBadge(); }
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error marking all notifications as read:', error);
                });
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.sidebar-seller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Aplikasi\laragon\www\softably\resources\views/view-seller/notif-seller.blade.php ENDPATH**/ ?>