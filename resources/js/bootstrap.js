import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time features.
 */

import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? "mt1",
    // forceTLS: true, // Uncomment if you face issues with secure connection
    encrypted: true,
    // authEndpoint: '/broadcasting/auth', // Default, bisa dikonfirmasi di BroadcastServiceProvider
});

// Anda mungkin perlu otentikasi channel privat jika menggunakan Pusher
// Pastikan ini dikonfigurasi di routes/channels.php
// Private channels memerlukan otentikasi server
// Contoh: Echo.private(`chat.${conversationId}`).listen(...)

// Pastikan Anda memanggil ini dari Laravel Echo dalam blade Anda:
// <script src="{{ asset('build/assets/app.js') }}" defer></script>
// atau yang sesuai dengan konfigurasi Vite/Mix Anda.
