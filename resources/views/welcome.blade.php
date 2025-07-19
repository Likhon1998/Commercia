<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Shopverse</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Top Bar -->
  <div class="bg-gradient-to-r from-green-700 to-emerald-500 text-white text-sm px-6 py-2 flex justify-end items-center space-x-4">
    <button class="hover:underline">My Account</button>
    <button class="hover:underline">Flash Sale</button>
    <button class="hover:underline">Track Order</button>
  </div>

  <!-- Header -->
  <header class="bg-white shadow py-4 px-6 flex flex-wrap justify-between items-center">
    <!-- Logo + Categories -->
    <div class="flex items-center space-x-4">
      <img src="/logo.png" alt="Shopverse" class="h-10">
      <select class="border px-3 py-2 rounded-md shadow-sm text-sm">
        <option>All Categories</option>
        <option>Electronics</option>
        <option>Fashion</option>
        <option>Home & Kitchen</option>
      </select>
    </div>

    <!-- Search Bar -->
    <form class="flex flex-1 mx-6 max-w-2xl" action="#" method="GET">
      <input type="text" placeholder="Search for products..." class="w-full px-4 py-2 border border-gray-300 rounded-l focus:outline-none">
      <button class="bg-emerald-600 text-white px-4 rounded-r hover:bg-emerald-700">
        <i class="fas fa-search"></i>
      </button>
    </form>

    <!-- Language + Auth + Icons -->
    <div class="flex items-center space-x-4 text-sm">
      <span class="cursor-pointer hover:text-emerald-600">ENG / BN</span>
      <a href="/login" class="text-blue-600 hover:underline">Login</a>
      <a href="/register" class="text-blue-600 hover:underline">Register</a>
      <a href="/wishlist"><i class="fas fa-heart text-gray-600 hover:text-red-500 text-lg"></i></a>
      <a href="/cart"><i class="fas fa-shopping-cart text-gray-600 hover:text-emerald-600 text-lg"></i></a>
    </div>
  </header>

  <!-- Promo Banner -->
  <div class="bg-yellow-100 text-center py-2 font-medium text-yellow-800 shadow-inner">
    🎉 Get 20% off your first order! Use code: <strong>SHOP20</strong>
  </div>

  <!-- Filters -->
  <div class="bg-white px-6 py-3 shadow flex flex-wrap gap-4 mt-2">
    <select class="border px-3 py-1 rounded shadow-sm text-sm">
      <option>Filter by Category</option>
      <option>Shirts</option>
      <option>Phones</option>
    </select>
    <select class="border px-3 py-1 rounded shadow-sm text-sm">
      <option>Filter by Brand</option>
      <option>Samsung</option>
      <option>Apple</option>
    </select>
    <select class="border px-3 py-1 rounded shadow-sm text-sm">
      <option>Sort by</option>
      <option>Newest</option>
      <option>Best Selling</option>
    </select>
  </div>

  <!-- Products Grid -->
  <section class="p-6 bg-gray-50">
    <h2 class="text-2xl font-bold mb-4 text-emerald-700">Top Deals</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @foreach(range(1, 8) as $i)
      <div class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
        <div class="h-48 bg-gray-100 flex items-center justify-center rounded-t">
          <img src="https://via.placeholder.com/150" alt="Product {{ $i }}" class="object-contain h-full p-4">
        </div>
        <div class="p-4">
          <h3 class="font-semibold text-lg text-gray-800">Product {{ $i }}</h3>
          <p class="text-emerald-600 font-bold text-sm mb-3">৳ {{ 1000 + $i * 100 }}</p>
          <div class="flex justify-between items-center">
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm px-4 py-2 rounded shadow">
              <i class="fas fa-cart-plus mr-1"></i> Add to Cart
            </button>
            <i class="fas fa-star text-yellow-400 text-sm"></i>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>

  <!-- Newsletter -->
  <section class="bg-emerald-600 text-white py-10 text-center">
    <h2 class="text-2xl font-semibold mb-2">Subscribe to our Newsletter</h2>
    <p class="mb-4 text-sm">Get updates on sales, new products and more.</p>
    <form class="flex justify-center max-w-md mx-auto">
      <input type="email" placeholder="Enter your email" class="w-full px-4 py-2 rounded-l focus:outline-none text-gray-800">
      <button class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-semibold px-4 rounded-r">
        Subscribe
      </button>
    </form>
  </section>

  <!-- Footer -->
  <footer class="bg-white border-t mt-12">
    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-sm text-gray-700">
      <div>
        <h4 class="font-bold text-gray-900 mb-2">About Shopverse</h4>
        <p>Trusted Bangladeshi online shopping platform with variety, quality, and speed.</p>
      </div>
      <div>
        <h4 class="font-bold text-gray-900 mb-2">Customer Service</h4>
        <ul class="space-y-1">
          <li><a href="#" class="hover:underline">FAQs</a></li>
          <li><a href="#" class="hover:underline">Return Policy</a></li>
          <li><a href="#" class="hover:underline">Shipping Info</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold text-gray-900 mb-2">Company</h4>
        <ul class="space-y-1">
          <li><a href="#" class="hover:underline">About Us</a></li>
          <li><a href="#" class="hover:underline">Careers</a></li>
          <li><a href="#" class="hover:underline">Contact</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold text-gray-900 mb-2">Follow Us</h4>
        <div class="flex space-x-3 text-lg">
          <a href="#" class="hover:text-blue-600"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="hover:text-sky-400"><i class="fab fa-twitter"></i></a>
          <a href="#" class="hover:text-pink-600"><i class="fab fa-instagram"></i></a>
          <a href="#" class="hover:text-red-600"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </div>
    <div class="text-center text-xs text-gray-500 py-4 border-t">
      &copy; {{ date('Y') }} Shopverse. All rights reserved.
    </div>
  </footer>

</body>
</html>
