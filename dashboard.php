<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comfy Dashboard</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <link rel="icon" type="image/png" href="img/logo.png"/>
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
      <h1 class="text-xl font-bold">Admin Dashboard</h1>
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
            <i class="fas fa-person rounded-full bg-gray-500 p-2"></i>
            <span class="hidden md:inline-block">Admin</span>
          </button>
          <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white border rounded shadow hidden p-4">
            <span class="font-medium block">Admin</span>
            <span class="text-xs text-gray-500">Super Admin</span>
            <div class="border-t my-2"></div>
            <a href="settings.php" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
            <a href="settings.php" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
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
      <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-bold">Recent Orders</h2>
          <a href="order.php" class="text-green-700 text-sm font-medium hover:underline">View all</a>
        </div>
        <table class="w-full text-sm">
          <thead>
            <tr class="text-left border-b">
              <th class="py-2">Order ID</th>
              <th class="py-2">Product</th>
              <th class="py-2">Progress</th>
              <th class="py-2">Status</th>
              <th class="py-2">Value</th>
              <th class="py-2"></th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr>
              <td>ORD-001</td>
              <td>Grass-Fed Beef Bundle<br><span class="text-xs text-gray-500">Deadline: 2024-01-15</span></td>
              <td>12/15</td>
              <td><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">Active</span></td>
              <td>₦32,400</td>
              <td><a href="#" class="text-green-700 hover:underline" onclick="openOrderModal('ORD-001')">View Details</a></td>
            </tr>
            <tr>
              <td>ORD-002</td>
              <td>Fresh Pineapple<br><span class="text-xs text-gray-500">Deadline: 2024-01-18</span></td>
              <td>8/10</td>
              <td><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">Active</span></td>
              <td>₦31,200</td>
              <td><a href="#" class="text-green-700 hover:underline" onclick="openOrderModal('ORD-002')">View Details</a></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Activity Feed -->
      <div class="bg-white p-4 rounded shadow flex flex-col">
        <h2 class="text-lg font-bold mb-4">Activity</h2>
        <ul id="activityFeed" class="space-y-3 text-sm overflow-y-auto max-h-64 pr-2">
          <li class="flex items-start gap-2">
            <span class="w-2 h-2 mt-2 rounded-full bg-red-500"></span>
            <div>3 orders closing in 24 hours need attention <span class="text-gray-400 text-xs">2h ago</span></div>
          </li>
          <li class="flex items-start gap-2">
            <span class="w-2 h-2 mt-2 rounded-full bg-blue-500"></span>
            <div>New product <b>Fresh Pineapple</b> was added <span class="text-gray-400 text-xs">6h ago</span></div>
          </li>
        </ul>
        <button class="mt-4 w-full text-green-700 text-sm font-medium hover:underline">View All Alerts</button>
      </div>

    </main>
  </div>

  <!-- Product Modal -->
  <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl shadow-lg w-[28rem] relative">
      <button onclick="closeProductModal()" class="absolute top-2 right-2 text-gray-500 text-xl font-bold">&times;</button>
      <h2 class="text-lg font-bold mb-4 text-center">➕ Add New Product</h2>
      <p class="text-sm text-gray-500 mb-3">Add clear photos of your product. Good photos get more views!</p>

      <form id="productForm" enctype="multipart/form-data" class="space-y-4">
        <div>
          <label class="block text-sm font-medium">Product Name</label>
          <input type="text" name="name" required
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div>
          <label class="block text-sm font-medium">Description</label>
          <textarea name="description" rows="3"
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium">Price (₦)</label>
          <input type="number" name="price" step="0.01" required
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div>
          <label class="block text-sm font-medium">Category</label>
          <select name="category" required
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            <option value="">-- Select Category --</option>
            <option value="Fruits">Fruits</option>
            <option value="Farm">Farm Crops</option>
            <option value="Protein">Protein</option>
            <option value="Vegetable">Vegetable</option>
            <option value="Spices">Spices</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium">Product Image</label>
          <input type="file" name="image" accept="image/*"
            class="w-full border px-3 py-2 rounded">
        </div>
        <button type="submit"
          class="w-full bg-green-700 text-white py-2 rounded hover:bg-green-800">Save Product</button>
      </form>
    </div>
  </div>

  <!-- Order Details Modal -->
  <div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl shadow-lg w-[28rem] relative">
      <button onclick="closeOrderModal()" class="absolute top-2 right-2 text-gray-500 text-xl font-bold">&times;</button>
      <h2 class="text-lg font-bold mb-4 text-center">Order Details</h2>
      <div id="orderDetails" class="text-sm space-y-2">
        <!-- Dynamic order info -->
      </div>
      <button onclick="closeOrderModal()"
        class="mt-4 w-full bg-green-700 text-white py-2 rounded hover:bg-green-800">Close</button>
    </div>
  </div>

  <?php
    include "db.php";
    $result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
  ?>

  <!-- Scripts -->
  <script>
    // Sidebar hover
    const sidebar = document.getElementById('sidebar');
    sidebar.addEventListener('mouseenter', () => { sidebar.classList.remove('sidebar-collapsed'); sidebar.classList.add('w-56'); });
    sidebar.addEventListener('mouseleave', () => { sidebar.classList.add('sidebar-collapsed'); sidebar.classList.remove('w-56'); });

    // Dropdowns
    function toggleProductDropdown() { document.getElementById('productDropdown').classList.toggle('hidden'); }
    function toggleProfileDropdown() { document.getElementById('profileDropdown').classList.toggle('hidden'); }

    // Product Modal
    function openProductModal() { document.getElementById('productModal').classList.remove('hidden'); }
    function closeProductModal() { document.getElementById('productModal').classList.add('hidden'); }

    // Order Modal
    function openOrderModal(orderId) {
      const modal = document.getElementById('orderModal');
      const detailsDiv = document.getElementById('orderDetails');
      const orders = {
        'ORD-001': {
          product: 'Grass-Fed Beef Bundle',
          quantity: '12/15',
          deadline: '2024-01-15',
          status: 'Active',
          value: '₦32,400',
          customer: 'John Doe',
          address: '123 Main Street',
        },
        'ORD-002': {
          product: 'Fresh Pineapple',
          quantity: '8/10',
          deadline: '2024-01-18',
          status: 'Active',
          value: '₦31,200',
          customer: 'Jane Smith',
          address: '456 Pineapple Lane',
        }
      };
      const order = orders[orderId];
      if(order) {
        detailsDiv.innerHTML = `
          <p><b>Order ID:</b> ${orderId}</p>
          <p><b>Product:</b> ${order.product}</p>
          <p><b>Quantity:</b> ${order.quantity}</p>
          <p><b>Deadline:</b> ${order.deadline}</p>
          <p><b>Status:</b> ${order.status}</p>
          <p><b>Value:</b> ${order.value}</p>
          <p><b>Customer:</b> ${order.customer}</p>
          <p><b>Address:</b> ${order.address}</p>
        `;
      }
      modal.classList.remove('hidden');
    }
    function closeOrderModal() { document.getElementById('orderModal').classList.add('hidden'); }

    // AJAX Product Form Submission
    const productForm = document.getElementById('productForm');
    productForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch('add_product.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
          if(data.success) {
            const feed = document.getElementById("activityFeed");
            const li = document.createElement("li");
            li.className = "flex items-start gap-2";
            li.innerHTML = `<span class="w-2 h-2 mt-2 rounded-full bg-blue-500"></span>
                            <div>New product <b>${data.name}</b> was added <span class="text-gray-400 text-xs">Just now</span></div>`;
            feed.prepend(li);
            closeProductModal();
            productForm.reset();
          } else {
            alert("Error adding product: " + data.error);
          }
        }).catch(err => console.error(err));
    });
  </script>

  <style>
    .sidebar { transition: width 0.3s ease; overflow: hidden; background-color: #28433D; }
    .sidebar-collapsed { width: 4rem; }
    .sidebar-expanded { width: 14rem; }
    .sidebar-collapsed .sidebar-text { display: none; }
  </style>
</body>
</html>
