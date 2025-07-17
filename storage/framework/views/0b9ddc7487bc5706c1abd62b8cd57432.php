<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Softably - Seller Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
    /* CSS untuk Sidebar */
    .sidebar-link {
        display: flex;
        align-items: center;
        width: 100%;
        text-align: left;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        color: white;
        transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, transform 0.2s ease-in-out;
        transform: scale(1);
        text-decoration: none;
    }

    .sidebar-link i.fa-solid {
        color: white;
        transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
    }

    .sidebar-link:hover {
        background-color: white;
        color: #2563EB;
        transform: scale(1.02);
    }

    .sidebar-link:hover i.fa-solid {
        color: #2563EB;
        transform: scale(1.05);
    }

    .sidebar-link.active {
        background-color: #ffffff;
        color: #2563EB;
        transform: scale(1.02);
        font-weight: 600;
    }

    .sidebar-link.active i.fa-solid {
        color: #2563EB;
        transform: scale(1.05);
    }


    .sidebar-footer-link {
        display: flex;
        align-items: center;
        width: 100%;
        text-align: left;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        color: white;
        transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
        transform: scale(1);
        text-decoration: none;
    }

    .sidebar-footer-link i.fa-solid {
        color: white;
        transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
    }

    .sidebar-footer-link:hover {
        background-color: white;
        color: #2563EB;
        transform: scale(1.02);
    }

    .sidebar-footer-link:hover i.fa-solid {
        color: #2563EB;
        transform: scale(1.05);
    }

    .user-profile-link {
            color: white;
            text-decoration: none;
            transition: transform 0.2s ease-in-out;
        }
        .user-profile-link:hover {
            transform: scale(1.02);
        }
        .user-profile-link:hover .font-medium {
            color: #2563EB;
        }
        .user-profile-link:hover .text-gray-400 {
            color: #2563EB;
        }

    .softably-logo {
        width: 50%;
        height: auto;
    }

    /* --- Gaya Scrollbar yang Diperbarui --- */
    /* Untuk WebKit (Chrome, Safari, Edge, Opera) */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #60A5FA;
        border-radius: 10px;
        border: 2px solid #F8FAFC;
    }

    ::-webkit-scrollbar-thumb:hover {
        background-color: #3B82F6;
    }

    ::-webkit-scrollbar-track {
        background-color: #F8FAFC;
        border-radius: 10px;
    }

    body {
        background-color: #F8FAFC;
        color: #333333;
        font-family: "Poppins", sans-serif;
        /* Tambahkan ini untuk mencegah scrollbar di body/html */
        overflow: hidden; 
    }

    html {
        height: 100%; /* Pastikan html mengambil tinggi penuh */
    }
    </style>
</head>

<body class="bg-[#F8FAFC] text-gray-800">
    <div class="flex h-screen">
        <aside class="w-64 flex-shrink-0 flex flex-col justify-between fixed top-0 left-0 h-full"
           style="background: linear-gradient(to top, #2D3A4F, #2563EB);">
            <div>
                <div class="flex justify-center p-4 text-xl font-bold flex-shrink-0">
                    <img src="<?php echo e(asset('img/softably-baru.png')); ?>" alt="Softably Logo" class="softably-logo">
                </div>
                <nav class="p-4 space-y-2 text-sm overflow-y-auto flex-1">

                    
                    <a href="<?php echo e(route('seller.dashboard')); ?>" class="sidebar-link" data-path="/seller/dashboard">
                        <i class="fa-solid fa-house-chimney"></i><span>Dashboard</span>
                    </a>

                    
                    <a href="<?php echo e(route('seller.products.index')); ?>" class="sidebar-link" data-path="/seller/products">
                        <i class="fa-solid fa-box"></i><span>My Product</span>
                    </a>

                    
                    <a href="<?php echo e(route('seller.chat')); ?>" class="sidebar-link" data-path="/seller/chat">
                        <i class="fa-solid fa-comments"></i><span>Chat</span>
                        <span class="ml-auto bg-[#ff483bff] text-white text-xs px-2 py-0.5 rounded-full">10</span>
                    </a>

                    
                    <a href="<?php echo e(route('seller.notif-seller')); ?>" class="sidebar-link" data-path="/seller/notifications">
                        <i class="fa-solid fa-bell"></i><span>Notification</span>
                    </a>

                    
                    <a href="<?php echo e(route('seller.softpay.dashboard')); ?>" class="sidebar-link" data-path="/seller/softpay">
                        <i class="fas fa-wallet"></i><span>SoftPay</span>
                    </a>

                    
                    <a href="<?php echo e(route('seller.bantuan-seller')); ?>" class="sidebar-link" data-path="/seller/help">
                        <i class="fa-solid fa-circle-question"></i><span>Help Center</span>
                    </a>
                </nav>
            </div>
            <div class="p-4 space-y-2 flex-shrink-0">
                <div class="p-4 py-5">
                    <a href="/setting-seller" class="user-profile-link" data-path="/setting-seller">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                <?php
                                $loggedInUser = Auth::user();
                                ?>
                                <img src="<?php echo e($loggedInUser->profile_picture_url ?? asset('img/man.jpg')); ?>"
                                    alt="Profile" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <div class="font-medium"><?php echo e($loggedInUser->name ?? 'Guest'); ?></div>
                                <div class="text-sm text-gray-400">Account settings</div>
                            </div>
                        </div>
                    </a>
                </div>
                <a href="/setting-seller" class="sidebar-footer-link" data-path="/setting-seller">
                    <i class="fa-solid fa-gear"></i><span>Settings</span>
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="sidebar-footer-link" data-path="/logout">
                    <i class="fa-sharp fa-solid fa-right-from-bracket"></i> <span>Log Out</span>
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
        </aside>

        
        
        <main class="flex-1 ml-64 overflow-y-auto"> 
            <?php echo $__env->yieldContent('isi'); ?>
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const sidebarLinks = document.querySelectorAll(
            '.sidebar-link, .user-profile-link, .sidebar-footer-link');

        sidebarLinks.forEach(link => {
            const linkPath = link.dataset.path;

            link.classList.remove('active');

            if (linkPath && currentPath.startsWith(linkPath)) {
                if (linkPath === '/seller/settings') {
                    link.classList.add('active');
                } else if (linkPath !== '/logout') {
                    link.classList.add('active');
                }
            }
        });
    });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH E:\Aplikasi\laragon\www\softably\resources\views/layouts/sidebar-seller.blade.php ENDPATH**/ ?>