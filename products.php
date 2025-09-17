

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
  <!-- End Sidebar -->

  <!-- Main Content -->
  <div class="flex-1 flex flex-col">

    <!-- Header -->
    <header class="flex justify-between items-center p-4 bg-white shadow">
      <h1 class="text-xl font-bold">Product Management</h1>
      <div class="flex items-center gap-4">

        <!-- Create New Product Dropdown -->
        <div class="relative">
          <button onclick="toggleProductDropdown()" class="bg-green-800 text-white px-4 py-2 rounded shadow flex items-center gap-2">
            <i class="fas fa-plus"></i> Create New Product
          </button>
          <div id="productDropdown" class="absolute left-0 mt-2 w-48 bg-white border rounded shadow hidden z-50">
            <a href="#" onclick="openProductModal()" class="block px-4 py-2 hover:bg-gray-100">+ New Product</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100">+ New Meat-Sharing Order</a>
          </div>
        </div>


        <!-- Notifications -->
        <i class="fas fa-bell"></i>

        <!-- Profile Dropdown -->
        <div class="relative">
          <button onclick="toggleProfileDropdown()" class="flex items-center gap-2">
            <i class="fas fa-person rounded-full bg-gray-300 p-2"></i>
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
    <!-- End Header -->

    <!-- Search Box -->
    <div class="w-full bg-white p-4 rounded shadow border border-gray-200">
      <div class="flex items-center w-full space-x-2">
        <div class="relative flex-1">
          <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
            <i class="fas fa-search"></i>
          </span>
          <input type="text" placeholder="Search Products..."
            class="w-full pl-10 pr-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <div class="relative">
          <button class="flex items-center px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100">
            <i class="fas fa-filter text-green-600 mr-2"></i>
            <span>All Status</span>
            <i class="fas fa-chevron-down ml-2 text-gray-400"></i>
          </button>
        </div>
      </div>
    </div>
    <!-- End Search Box -->

    <!-- Product Modal -->
    <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
      <div class="bg-white p-6 rounded-xl shadow-lg w-[28rem] relative">
        <button onclick="closeProductModal()" class="absolute top-2 right-2 text-gray-500 text-xl font-bold">&times;</button>
        <h2 class="text-lg font-bold mb-4 text-center">➕ Add New Product</h2>
        <p class="text-sm text-gray-500 mb-3">Add clear photos of your product. Good photos get more views!</p>

        <form action="add_product.php" method="POST" enctype="multipart/form-data" class="space-y-4">
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
    <!-- End Product Modal -->

    <?php
    include "db.php";
    $result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
    ?>

    <!-- Product List -->
    <div class="p-6 bg-white rounded shadow">
      <h2 class="text-xl font-bold mb-4">Products</h2>

      <!-- Success Message -->
      <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
          ✅ Product deleted successfully.
        </div>
      <?php endif; ?>

      <table class="w-full border-collapse border">
        <thead>
          <tr class="bg-gray-100">
            <th class="border p-2">Image</th>
            <th class="border p-2">Name</th>
            <th class="border p-2">Price</th>
            <th class="border p-2">Category</th>
            <th class="border p-2">Created</th>
            <th class="border p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td class="border p-2"><img src="<?= $row['image'] ?>" class="w-12 h-12 object-cover"></td>
              <td class="border p-2"><?= $row['name'] ?></td>
              <!-- <td class="border p-2">₦<?= number_format($row['price'], 2) ?></td> -->
              <td class="border p-2">₦<?= number_format($row['price']) ?> / KG</td>
              <td class="border p-2"><?= $row['category'] ?></td>
              <td class="border p-2"><?= $row['created_at'] ?></td>
              <td class="border p-2 text-center">
                <form action="delete_product.php" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <button type="submit"
                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                    <i class="fas fa-trash"></i> Delete
                  </button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <!-- End Product List -->

  </div>
  <!-- End Main Content -->

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
  </script>

  <style>
    .sidebar {
      transition: width 0.3s ease;
      overflow: hidden;
      background-color: #28433D;
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

</body>

</html>