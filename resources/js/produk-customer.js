// public/js/produk-customer.js

document.addEventListener("DOMContentLoaded", function () {
    const cartButtons = document.querySelectorAll(".product-card .cart-icon");

    cartButtons.forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Mencegah perilaku default tombol (jika ada)

            const productId = this.dataset.productId; // Ambil product ID dari data-product-id
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

            fetch("/cart", {
                // Kirim permintaan POST ke rute /cart
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken, // Sertakan CSRF token
                    Accept: "application/json", // Minta respons JSON
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1, // Default quantity 1
                }),
            })
                .then((response) => {
                    if (!response.ok) {
                        // Jika respons bukan 2xx (misal 401 Unauthorized, 422 Validation error)
                        return response.json().then((errorData) => {
                            throw new Error(
                                errorData.message ||
                                    "Gagal menambahkan produk ke keranjang."
                            );
                        });
                    }
                    return response.json();
                })
                .then((data) => {
                    alert(data.message); // Tampilkan pesan sukses dari server
                    console.log("Respons server:", data);
                    // Opsional: Perbarui jumlah item di keranjang pada UI (misal: di sidebar)
                    // if (data.cartCount !== undefined) {
                    //     const cartCountElement = document.querySelector('#cart-count'); // Ganti dengan ID/class yang sesuai
                    //     if (cartCountElement) {
                    //         cartCountElement.textContent = data.cartCount;
                    //     }
                    // }
                })
                .catch((error) => {
                    console.error("Ada masalah dengan operasi fetch:", error);
                    alert("Error: " + error.message);
                });
        });
    });
});
