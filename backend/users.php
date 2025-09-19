<?php
include "db.php";

// Fetch users
$users = [];
$result = $conn->query("SELECT id, username, email, phone, location, created_at, status FROM users ORDER BY id DESC");
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $users[] = $row;
  }
} else {
  die("Query Error: " . $conn->error);
}

// Dashboard counts
$totalUsers   = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$activeUsers  = $conn->query("SELECT COUNT(*) AS count FROM users WHERE status='Active'")->fetch_assoc()['count'];
$newThisMonth = $conn->query("SELECT COUNT(*) AS count FROM users WHERE MONTH(created_at)=MONTH(CURRENT_DATE()) AND YEAR(created_at)=YEAR(CURRENT_DATE())")->fetch_assoc()['count'];
$totalOrders  = $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comfy Dashboard - Users</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="../img/logo.png" />
</head>

<body class="bg-gray-100 flex">

  <!-- Sidebar -->
  <div id="sidebar" class="sidebar sidebar-collapsed text-white h-screen flex flex-col py-4 transition-all duration-300 overflow-hidden bg-[#28433D]">
    <!-- Logo -->
    <div class="flex items-center space-x-2 px-4 mb-8">
      <img src="../img/Group 243 (1).png" alt="logo" class="w-8 h-8" style="width: fit-content; height: fit-content;">
    </div>
    <nav class="flex-1 w-full">
      <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition">
        <i class="fas fa-home"></i><span class="sidebar-text">Dashboard</span>
      </a>
      <a href="order.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition">
        <i class="fas fa-shopping-bag"></i><span class="sidebar-text">Orders</span>
      </a>
      <a href="users.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition">
        <i class="fas fa-users"></i><span class="sidebar-text">Users</span>
      </a>
      <a href="products.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition">
        <i class="fas fa-box"></i><span class="sidebar-text">Products</span>
      </a>
      <a href="payment.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition">
        <i class="fas fa-credit-card"></i><span class="sidebar-text">Payments</span>
      </a>
      <a href="settings.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition">
        <i class="fas fa-cog"></i><span class="sidebar-text">Settings</span>
      </a>
    </nav>
    <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-red-600">
      <i class="fas fa-sign-out-alt"></i>
      <span class="sidebar-text">Log Out</span>
    </a>
  </div>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col">
    <header class="flex justify-between items-center p-4 bg-white shadow">
      <h1 class="text-xl font-bold">Admin Portal</h1>

      <!-- Right Section: Bell + Admin -->
      <div class="flex items-center gap-6">
        <!-- Notifications -->
        <button class="relative">
          <i class="fas fa-bell text-gray-700 text-lg"></i>
          <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 rounded-full">3</span>
        </button>

        <!-- Admin -->
        <div class="relative">
          <button class="flex items-center gap-2">
            <i class="fas fa-user-circle text-gray-600 text-2xl"></i>
            <div class="flex flex-col items-start">
              <span class="hidden md:inline-block">Admin</span>
              <span class="text-xs text-gray-500">Administrator</span>
            </div>
          </button>
        </div>
      </div>
    </header>


    <main class="p-6 space-y-6 flex-1 overflow-auto">

      <!-- Top Section: Dashboard Overview & Create Button -->
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-700">User Management</h2>
        <button onclick="openAddUserModal()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
          <i class="fas fa-user-plus mr-2"></i> Add User
        </button>
      </div>

      <main class="p-6 space-y-6">

        <!-- Dashboard Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
          <div class="bg-white p-6 rounded shadow flex items-center gap-4">
            <i class="fas fa-users text-3xl text-green-600"></i>
            <div>
              <p class="text-gray-500 text-sm">Total Users</p>
              <p class="text-xl font-bold" id="totalUsers"><?= $totalUsers ?></p>
            </div>
          </div>
          <div class="bg-white p-6 rounded shadow flex items-center gap-4">
            <i class="fas fa-user-check text-3xl text-blue-600"></i>
            <div>
              <p class="text-gray-500 text-sm">Active Users</p>
              <p class="text-xl font-bold" id="activeUsers"><?= $activeUsers ?></p>
            </div>
          </div>
          <div class="bg-white p-6 rounded shadow flex items-center gap-4">
            <i class="fas fa-shopping-bag text-3xl text-purple-600"></i>
            <div>
              <p class="text-gray-500 text-sm">Total Orders</p>
              <p class="text-xl font-bold" id="totalOrders"><?= $totalOrders ?></p>
            </div>
          </div>
          <div class="bg-white p-6 rounded shadow flex items-center gap-4">
            <i class="fas fa-calendar-alt text-3xl text-red-600"></i>
            <div>
              <p class="text-gray-500 text-sm">New This Month</p>
              <p class="text-xl font-bold" id="newThisMonth"><?= $newThisMonth ?></p>
            </div>
          </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white p-6 rounded shadow mt-6">
          <h2 class="text-lg font-bold mb-4">Registered Users</h2>
          <table class="w-full border-collapse">
            <thead>
              <tr class="bg-gray-100 text-left">
                <th class="p-3">User</th>
                <th class="p-3">Email</th>
                <th class="p-3">Phone</th>
                <th class="p-3">Location</th>
                <th class="p-3">Created At</th>
                <th class="p-3">Status</th>
                <th class="p-3">Actions</th>
              </tr>
            </thead>
            <tbody id="usersTableBody">
              <?php foreach ($users as $user): ?>
                <tr class="border-b" data-id="<?= $user['id'] ?>">
                  <td class="p-3 font-semibold"><?= htmlspecialchars($user['username']) ?></td>
                  <td class="p-3"><?= htmlspecialchars($user['email']) ?></td>
                  <td class="p-3"><?= htmlspecialchars($user['phone']) ?></td>
                  <td class="p-3"><?= htmlspecialchars($user['location']) ?></td>
                  <td class="p-3"><?= htmlspecialchars($user['created_at']) ?></td>
                  <td class="p-3"><span class="px-2 py-1 rounded text-white <?= $user['status'] === 'Active' ? 'bg-green-600' : 'bg-gray-500' ?>"><?= $user['status'] ?></span></td>
                  <td class="p-3 space-x-2">
                    <button onclick="toggleStatus(<?= $user['id'] ?>)" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Enable/Disable</button>
                    <button onclick="suspendUser(<?= $user['id'] ?>)" class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700">Suspend</button>
                    <button onclick="deleteUser(<?= $user['id'] ?>)" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Add User Modal -->
        <div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
          <div class="bg-white p-6 rounded shadow w-96 relative">
            <button onclick="closeAddUserModal()" class="absolute top-2 right-2 text-gray-500">&times;</button>
            <h2 class="text-lg font-bold mb-4">Add New User</h2>
            <form id="addUserForm" class="space-y-4">
              <input type="text" name="username" placeholder="Username" required class="w-full px-3 py-2 border rounded" />
              <input type="email" name="email" placeholder="Email" class="w-full px-3 py-2 border rounded" />
              <input type="text" name="phone" placeholder="Phone Number" class="w-full px-3 py-2 border rounded" />
              <input type="text" name="location" placeholder="Location" class="w-full px-3 py-2 border rounded" />
              <div class="flex items-center justify-between">
                <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded" />
              </div>
              <div class="flex items-center justify-between">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Add User</button>
              </div>
            </form>
          </div>
        </div>

      </main>
  </div>

  <script>
    // Sidebar hover
    const sidebar = document.getElementById('sidebar');
    sidebar.addEventListener('mouseenter', () => {
      sidebar.classList.remove('sidebar-collapsed');
      sidebar.classList.add('w-56');
    });
    sidebar.addEventListener('mouseleave', () => {
      sidebar.classList.add('sidebar-collapsed');
      sidebar.classList.remove('w-56');
    });

    // Modal functions
    function openAddUserModal() {
      document.getElementById("addUserModal").classList.remove("hidden");
    }

    function closeAddUserModal() {
      document.getElementById("addUserModal").classList.add("hidden");
    }

    // Add User
    document.getElementById("addUserForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const form = new FormData(this);

      fetch('add_user.php', {
          method: 'POST',
          body: form
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            alert("User added successfully!");
            location.reload();
          } else {
            alert("Error: " + data.message);
          }
        }).catch(err => console.error(err));
    });

    // Toggle status
    function toggleStatus(userId) {
      fetch('toggle_status.php', {
          method: 'POST',
          body: new URLSearchParams({
            id: userId
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') location.reload();
          else alert("Error: " + data.message);
        });
    }

    // Suspend user
    function suspendUser(userId) {
      fetch('suspend_user.php', {
          method: 'POST',
          body: new URLSearchParams({
            id: userId
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') location.reload();
          else alert("Error: " + data.message);
        });
    }

    // Delete user
    function deleteUser(userId) {
      if (!confirm("Are you sure you want to delete this user?")) return;
      fetch('delete_user.php', {
          method: 'POST',
          body: new URLSearchParams({
            id: userId
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') location.reload();
          else alert("Error: " + data.message);
        });
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

    .sidebar-collapsed .sidebar-text {
      display: none;
    }
  </style>
</body>

</html>