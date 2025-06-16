<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Softably</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="relative text-white font-sans min-h-screen flex flex-col">
    <div
      class="absolute inset-0 bg-[url('img/digiproduct.jpg')] bg-cover bg-center z-0"
    ></div>

    <div class="absolute inset-0 bg-black opacity-60 z-10"></div>

    <div class="relative z-20 flex flex-col flex-grow">
      <header class="flex justify-between items-center px-8 py-6">
        <div class="text-lg font-bold">
          <img src="img/logo-softably.png" alt="" width="120" />
        </div>
        <div class="space-x-4">
          <button
            class="bg-white text-black px-4 py-1 rounded-full text-sm font-semibold"
          >
            Daftar
          </button>
          <button
            class="border border-white px-4 py-1 rounded-full text-sm font-semibold"
          >
            Masuk
          </button>
        </div>
      </header>

      <section
        class="text-center px-4 py-16 max-w-2xl mx-auto flex flex-col justify-center items-center min-h-screen">
        <p class="text-m mb-2">Selamat datang di Softably</p>
        <h1 class="text-3xl sm:text-4xl font-bold leading-tight mb-4">
          Temukan produk digital<br />yang kamu mau disini
        </h1>
        <p class="text-sm text-gray-200">
          Lorem ipsum dolor sit amet consectetur. Eget nisi in fermentum amet
          aenean orci. Tristique at elit malesuada ut. Adipiscing laoreet sed
          mus magna viverra ut vulputate.
        </p>
      </section>

      <section
        class="text-center px-4 py-12 flex flex-col justify-center items-center min-h-screen flex-grow"
      >
        <h2 class="text-2xl font-semibold mb-2">Mau jadi apa nih ?</h2>
        <p class="max-w-md mx-auto text-sm text-gray-200">
          Lorem ipsum dolor sit amet consectetur. Sollicitudin ornare in diam
          faucibus. Ut tellus nullam convallis non lectus sit tellus id quam.
        </p>

        <div
          class="flex flex-col md:flex-row justify-center items-center gap-8 mt-10 px-4"
        >
          <div class="bg-[#222831] p-6 rounded-xl max-w-sm w-full">
            <div class="bg-white h-48 rounded mb-4"></div>
            <h3 class="text-xl font-bold mb-2">Seller</h3>
            <p class="text-sm text-gray-200 mb-4">
              Lorem ipsum dolor sit amet consectetur. Sollicitudin ornare in
              diam faucibus. Ut tellus nullam convallis non lectus sit tellus id
              quam.
            </p>
            <button class="bg-white text-black px-6 py-2 rounded font-semibold">
              Daftar
            </button>
          </div>

          <div class="bg-[#222831] p-6 rounded-xl max-w-sm w-full">
            <div class="bg-white h-48 rounded mb-4"></div>
            <h3 class="text-xl font-bold mb-2">Customer</h3>
            <p class="text-sm text-gray-200 mb-4">
              Lorem ipsum dolor sit amet consectetur. Sollicitudin ornare in
              diam faucibus. Ut tellus nullam convallis non lectus sit tellus id
              quam.
            </p>
            <button class="bg-white text-black px-6 py-2 rounded font-semibold">
              Daftar
            </button>
          </div>
        </div>
      </section>

      <footer class="bg-[#222831] text-white text-sm px-8 py-10">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-8">
          <div>
            <h4 class="font-bold mb-2">Softably</h4>
            <p class="mb-4 text-gray-300 text-sm">
              Lorem ipsum dolor sit amet consectetur adipiscing elit aliquam
              mauris sed ma
            </p>
            <div class="flex space-x-3">
              <a href="#"
                ><img
                  src="https://img.icons8.com/ios-filled/20/ffffff/facebook-new.png"
              /></a>
              <a href="#"
                ><img
                  src="https://img.icons8.com/ios-filled/20/ffffff/twitter.png"
              /></a>
              <a href="#"
                ><img
                  src="https://img.icons8.com/ios-filled/20/ffffff/instagram-new.png"
              /></a>
              <a href="#"
                ><img
                  src="https://img.icons8.com/ios-filled/20/ffffff/linkedin.png"
              /></a>
              <a href="#"
                ><img
                  src="https://img.icons8.com/ios-filled/20/ffffff/youtube-play.png"
              /></a>
            </div>
          </div>

          <div>
            <h5 class="font-semibold mb-2">About us</h5>
            <ul class="space-y-1 text-gray-300">
              <li>Mission</li>
              <li>Our team</li>
              <li>Awards</li>
              <li>Testimonials</li>
              <li>Privacy policy</li>
            </ul>
          </div>

          <div>
            <h5 class="font-semibold mb-2">Services</h5>
            <ul class="space-y-1 text-gray-300">
              <li>Web design</li>
              <li>Web development</li>
              <li>Mobile design</li>
              <li>UI/UX design</li>
              <li>Branding design</li>
            </ul>
          </div>

          <div>
            <h5 class="font-semibold mb-2">Contact us</h5>
            <ul class="space-y-1 text-gray-300">
              <li>Information</li>
              <li>Request a quote</li>
              <li>Consultation</li>
              <li>Help center</li>
              <li>Terms and conditions</li>
            </ul>
          </div>
        </div>

        <div
          class="border-t border-gray-600 mt-10 pt-4 text-center text-gray-400"
        >
          Copyright © 2025 Softably | All Rights Reserved |
          <a href="#" class="underline">Terms and Conditions</a> |
          <a href="#" class="underline">Privacy Policy</a>
        </div>
      </footer>
    </div>
  </body>
</html>