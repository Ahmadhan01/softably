const allProducts = Array.from({ length: 20 }, (_, i) => ({
            price: "$30.00",
            title: `Template canva ${i + 1}`,
            description: "Description Description Description Description Description Description Description"
        }));

        const productsPerPage = 8;
        let currentPage = 1;

        const productGrid = document.querySelector(".grid");
        const paginationContainer = document.querySelector(".pagination");

        function renderProducts() {
            productGrid.innerHTML = "";
            const start = (currentPage - 1) * productsPerPage;
            const end = start + productsPerPage;
            const productsToShow = allProducts.slice(start, end);

            productsToShow.forEach(product => {
                const productHTML = `
                <div class="bg-[#1e293b] p-4 rounded relative">
                    <div class="absolute top-2 right-2 text-white">🔖</div>
                    <div class="text-orange-400 font-bold mb-1">${product.price}</div>
                    <h3 class="text-lg font-semibold">${product.title}</h3>
                    <p class="text-sm text-gray-400">${product.description}</p>
                    <button class="flex items-center justify-center mt-4 w-full border border-gray-500 rounded py-1 hover:bg-white hover:text-black transition">
                        🛒 Add to cart
                    </button>
                </div>
            `;
                productGrid.insertAdjacentHTML("beforeend", productHTML);
            });
        }

        function renderPagination() {
            paginationContainer.innerHTML = "";
            const totalPages = Math.ceil(allProducts.length / productsPerPage);

            const createButton = (pageNum, label = pageNum) => {
                const isActive = pageNum === currentPage;
                return `<button class="px-3 py-1 ${isActive ? "bg-white text-black" : "bg-[#1e293b] text-white"} rounded hover:bg-white hover:text-black" data-page="${pageNum}">${label}</button>`;
            };


            if (currentPage > 1) {
                paginationContainer.innerHTML += createButton(currentPage - 1, "&lt;");
            }


            for (let i = 1; i <= totalPages; i++) {
                paginationContainer.innerHTML += createButton(i);
            }


            if (currentPage < totalPages) {
                paginationContainer.innerHTML += createButton(currentPage + 1, "&gt;");
            }


            document.querySelectorAll(".pagination button").forEach(btn => {
                btn.addEventListener("click", () => {
                    const selectedPage = parseInt(btn.getAttribute("data-page"));
                    if (selectedPage !== currentPage) {
                        currentPage = selectedPage;
                        renderProducts();
                        renderPagination();
                    }
                });
            });
        }

        renderProducts();
        renderPagination();



        