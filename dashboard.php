<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comfy Dashboard</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex">

  <!-- Sidebar -->
  <div id="sidebar" class="sidebar sidebar-collapsed text-white h-screen flex flex-col py-4 transition-all duration-300 overflow-hidden bg-[#28433D]">
    <!-- Logo -->
    <div class="flex items-center space-x-2 px-4 mb-8">
      <img src="img/Group 243 (1).png" alt="logo" class="w-8 h-8" style="width: fit-content; height: fit-content;">
    </div>

    <!-- Menu -->
    <nav class="flex-1 w-full">
      <a href="#" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-home"></i><span class="sidebar-text">Dashboard</span></a>
      <a href="order.php" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-shopping-bag"></i><span class="sidebar-text">Orders</span></a>
      <a href="users.php" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-users"></i><span class="sidebar-text">Users</span></a>
      <a href="products.php" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-box"></i><span class="sidebar-text">Products</span></a>
      <a href="payment.php" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-credit-card"></i><span class="sidebar-text">Payments</span></a>
      <a href="settings.php" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-cog"></i><span class="sidebar-text">Settings</span></a>
    </nav>

    <!-- Logout -->
    <a href="logout.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-red-600">
      <i class="fas fa-sign-out-alt"></i>
      <span class="sidebar-text">Log Out</span>
    </a>

  </div>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col">

    <!-- Header -->
    <header class="flex justify-between items-center p-4 bg-white shadow">
      <h1 class="text-xl font-bold">Admin Portal</h1>
      <div class="flex items-center gap-4">

        <!-- Create New Product Dropdown -->
        <div class="relative">
          <button onclick="toggleProductDropdown()" class="bg-green-800 text-white px-4 py-2 rounded shadow flex items-center gap-2">
            <i class="fas fa-plus"></i> Create New Product
          </button>
          <div id="productDropdown" class="absolute right-0 mt-2 w-48 bg-white border rounded shadow hidden">
            <a href="#" onclick="openProductModal()" class="block px-4 py-2 hover:bg-gray-100">+ New Product</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100">+ New Meat-Sharing Order</a>
          </div>
        </div>

        <!-- Notifications -->
        <i class="fas fa-bell"></i>

        <!-- Profile Dropdown -->
        <div class="relative">
          <button onclick="toggleProfileDropdown()" class="flex items-center gap-2">
            <img src="https://via.placeholder.com/30" class="rounded-full" alt="Admin">
          </button>
          <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white border rounded shadow hidden p-4">
            <span class="font-medium block">Admin</span>
            <span class="text-xs text-gray-500">Super Admin</span>
            <div class="border-t my-2"></div>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
            <a href="logout.php" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
          </div>
        </div>
      </div>
    </header>

    <!-- Dashboard Content -->
    <main class="p-6 space-y-6">
      <!-- Top Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-4 rounded shadow">
          <p class="text-gray-600">Total Revenue</p>
          <h2 class="text-2xl font-bold text-green-700">₦4,147,392</h2>
          <p class="text-sm text-green-500">+12.5% from last month</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
          <p class="text-gray-600">Completed Orders</p>
          <h2 class="text-2xl font-bold">342</h2>
          <p class="text-sm text-green-500">+8.2% from last month</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
          <p class="text-gray-600">Active Orders</p>
          <h2 class="text-2xl font-bold">23</h2>
          <p class="text-sm text-green-500">+8.2% from last month</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
          <p class="text-gray-600">Total Users</p>
          <h2 class="text-2xl font-bold">173</h2>
          <p class="text-sm text-green-500">+5.1% from last month</p>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="lg:col-span-2 bg-white rounded shadow p-4">
        <h3 class="font-semibold text-lg mb-4">Recent Orders</h3>
        <table class="w-full text-left">
          <thead class="border-b">
            <tr>
              <th class="p-2">Order ID</th>
              <th class="p-2">Product</th>
              <th class="p-2">Progress</th>
              <th class="p-2">Status</th>
              <th class="p-2">Value</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b">
              <td class="p-2">ORD-001</td>
              <td class="p-2">Grass-Fed Beef Bundle</td>
              <td class="p-2">12/15</td>
              <td class="p-2"><span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">Active</span></td>
              <td class="p-2">₦32,400</td>
              <td class="p-2"><button onclick="openOrderDetails('ORD-001')" class="text-blue-600 hover:underline">View Details</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <!-- Product Modal -->
  <div id="productModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl">

      <!-- Header -->
      <div class="flex justify-between items-center border-b pb-3 mb-4">
        <h2 class="text-xl font-bold">Create New Product</h2>
        <button onclick="closeProductModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
      </div>

      <!-- Form -->
      <form class="space-y-6">

        <!-- Product Pictures -->
        <div>
          <h3 class="font-semibold mb-2">Product Pictures</h3>
          <p class="text-sm text-gray-500 mb-3">Add clear photos of your product. Good photos get more views!</p>
          <label class="flex items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-green-600">
            <div class="flex flex-col items-center">
              <i class="fas fa-camera text-3xl text-gray-400"></i>
              <span class="mt-2 text-sm text-gray-500">Upload Main Picture</span>
            </div>
            <input type="file" class="hidden" />
          </label>
        </div>

        <!-- Product Details -->
        <div>
          <h3 class="font-semibold mb-2">Product Details</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" placeholder="Enter product name" class="border rounded p-2 w-full" required>
            <input type="text" placeholder="Enter unit" class="border rounded p-2 w-full">

            <input type="number" placeholder="Price (₦)" class="border rounded p-2 w-full">
            <select class="border rounded p-2 w-full">
              <option>Select category</option>
              <option>Meat</option>
              <option>Vegetables</option>
              <option>Dairy</option>
            </select>
          </div>

          <textarea placeholder="Enter storage/farm location" class="border rounded p-2 w-full mt-3"></textarea>
        </div>

        <!-- Actions -->
        <div class="flex justify-between mt-6">
          <button type="button" onclick="closeProductModal()" class="px-6 py-2 bg-gray-200 rounded hover:bg-gray-300">
            Cancel
          </button>
          <button type="submit" class="px-6 py-2 bg-green-800 text-white rounded hover:bg-green-900">
            Create Order
          </button>
        </div>
      </form>
    </div>
  </div>


  <script>
    // Sidebar toggle
    const sidebar = document.getElementById('sidebar');
    sidebar.addEventListener('mouseenter', () => {
      sidebar.classList.remove('sidebar-collapsed');
      sidebar.classList.add('w-56');
    });
    sidebar.addEventListener('mouseleave', () => {
      sidebar.classList.add('sidebar-collapsed');
      sidebar.classList.remove('w-56');
    });

    // Dropdowns
    function toggleProductDropdown() {
      document.getElementById('productDropdown').classList.toggle('hidden');
    }

    function toggleProfileDropdown() {
      document.getElementById('profileDropdown').classList.toggle('hidden');
    }

    // Product Modal
    function openProductModal() {
      document.getElementById('productModal').classList.remove('hidden');
    }

    function closeProductModal() {
      document.getElementById('productModal').classList.add('hidden');
    }

    // Order Modal
    function openOrderDetails(orderId) {
      document.getElementById('orderDetailsContent').innerText = "Details for " + orderId;
      document.getElementById('orderModal').classList.remove('hidden');
    }

    function closeOrderModal() {
      document.getElementById('orderModal').classList.add('hidden');
    }
  </script>

</body>

</html>
<style>
  .sidebar {
    transition: width 0.3s ease;
    overflow: hidden;
    background-color: #28433D;
    /* Sidebar background */
  }

  .sidebar-collapsed {
    width: 4rem;
  }

  .sidebar-expanded {
    width: 14rem;
  }

  .sidebar-collapsed .sidebar-text {
    display: none;
  }
</style>