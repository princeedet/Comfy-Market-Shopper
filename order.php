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
      <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-home"></i><span class="sidebar-text">Dashboard</span></a>
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
      <h1 class="text-xl font-bold">Order Management</h1>
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
    </header>

    <!-- Dashboard Content -->
    <main class="orders-container">
      <h2>Orders</h2>

      <!-- Order Card -->
      <div class="order-card" data-id="1001">
        <div class="order-info">
          <p><strong>Order ID:</strong> 1001</p>
          <p><strong>Customer:</strong> John Doe</p>
          <p><strong>Date:</strong> 2024-10-01</p>
          <p><strong>Address:</strong> 123 Lagos Street, Nigeria</p>
          <p><strong>Items:</strong> iPhone 14 Pro</p>
          <p><strong>Quantity:</strong> 2</p>
          <p><strong>Amount:</strong> ₦450,000</p>
          <p><strong>Status:</strong> <span class="status processing">Processing</span></p>
        </div>
        <div class="order-actions">
          <button class="btn view" onclick="openOrderDetails('1001')">View</button>
          <button class="btn delete" onclick="deleteOrder('1001')">Delete</button>
        </div>
      </div>

      <!-- More order-cards can go here -->
    </main>

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

    <!-- Popup Modal -->
    <div id="orderModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Order Details</h3>
        <div id="modalBody"></div>
      </div>
    </div>

    <!-- More rows as needed -->

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


      // Open order details
      function openOrderDetails(orderId) {
        const orderCard = document.querySelector(`.order-card[data-id="${orderId}"]`);
        const details = orderCard.querySelector(".order-info").innerHTML;

        document.getElementById("modalBody").innerHTML = details;
        document.getElementById("orderModal").style.display = "block";
      }

      // Close modal
      function closeModal() {
        document.getElementById("orderModal").style.display = "none";
      }

      // Delete order
      function deleteOrder(orderId) {
        if (confirm("Are you sure you want to delete this order?")) {
          const orderCard = document.querySelector(`.order-card[data-id="${orderId}"]`);
          if (orderCard) orderCard.remove();
        }
      }

      // Close modal when clicking outside
      window.onclick = function(event) {
        const modal = document.getElementById("orderModal");
        if (event.target === modal) {
          modal.style.display = "none";
        }
      };
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

  /* Dashboard Layout */
  main {
    padding: 1rem;
    flex: 1;
    overflow-y: auto;
    font-family: Arial, Helvetica, sans-serif;
    background: #f9fafb;
  }

  main h2 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #111827;
  }

  /* Card container */
  .bg-white {
    background: #ffffff;
    padding: 1rem;
    border-radius: 0.5rem;
    box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
  }




  /* Order cards */
  .orders-container {
    padding: 1rem;
    background: #f9fafb;
    font-family: Arial, Helvetica, sans-serif;
  }

  .order-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
  }

  .order-info p {
    margin: 0.3rem 0;
    color: #374151;
    font-size: 0.95rem;
  }

  .status {
    padding: 0.2rem 0.6rem;
    border-radius: 0.4rem;
    font-size: 0.8rem;
    font-weight: bold;
  }

  .status.processing {
    background: #fef3c7;
    color: #92400e;
  }

  .status.completed {
    background: #dcfce7;
    color: #166534;
  }

  .status.cancelled {
    background: #fee2e2;
    color: #991b1b;
  }

  /* Buttons */
  .btn {
    padding: 0.5rem 0.9rem;
    border-radius: 0.4rem;
    border: none;
    cursor: pointer;
    font-size: 0.85rem;
    font-weight: 500;
    color: #fff;
  }

  .btn.view {
    background: #2563eb;
  }

  .btn.view:hover {
    background: #1d4ed8;
  }

  .btn.delete {
    background: #dc2626;
  }

  .btn.delete:hover {
    background: #b91c1c;
  }

  /* Modal */
  .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
  }

  .modal-content {
    background: #fff;
    margin: 10% auto;
    padding: 1.5rem;
    border-radius: 0.5rem;
    width: 400px;
    max-width: 90%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .close {
    float: right;
    font-size: 1.5rem;
    font-weight: bold;
    cursor: pointer;
  }

  .close:hover {
    color: red;
  }
</style>