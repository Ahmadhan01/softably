import "./bootstrap"; // Ini akan mengimpor file bootstrap.js Anda (biasanya di folder yang sama)

import Echo from "laravel-echo";

// Pastikan window.Pusher tersedia jika Anda menggunakan Pusher JS SDK
// Jika Anda menginstal 'pusher-js' via npm, pastikan itu diimpor di bootstrap.js atau di sini.
// Contoh di bootstrap.js:
// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

import Pusher from "pusher-js";
window.Pusher = Pusher;

// Inisialisasi Laravel Echo
window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY, // Mengambil APP_KEY dari .env (pastikan ada VITE_PUSHER_APP_KEY)
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER, // Mengambil CLUSTER dari .env (pastikan ada VITE_PUSHER_APP_CLUSTER)
    forceTLS: true, // Gunakan true jika Anda menggunakan koneksi HTTPS
});

// Anda bisa menambahkan listener global di sini jika diperlukan,
// tetapi listener spesifik channel lebih baik diletakkan di komponen frontend (misal: chat-customer.blade.php)

console.log("Laravel Echo (Pusher) initialized and ready.");

// Contoh mendengarkan channel publik (opsional, untuk debugging/demonstrasi)
// window.Echo.channel('public-channel')
//     .listen('SomePublicEvent', (e) => {
//         console.log('Received public event:', e);
//     });

// Contoh mendengarkan channel privat (opsional, untuk debugging/demonstrasi)
// Channel privat akan memerlukan otentikasi melalui routes/channels.php
// window.Echo.private('App.Models.User.' + window.App.user.id) // Asumsi Anda memiliki ID pengguna yang tersedia secara global
//     .notification((notification) => {
//         console.log('Received private notification:', notification);
//     });

// Tambahkan kode JavaScript lainnya yang dibutuhkan secara global oleh aplikasi Anda di sini
// Misalnya, untuk handling notifikasi atau fungsi umum lainnya.
