<?php
include 'config.php';

// ================= Dashboard Counts =================
// Total revenue
$totalRevenue = $conn->query("SELECT SUM(value) AS total FROM orders")->fetch_assoc()['total'] ?? 0;

// Completed orders
$completedOrders = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status='Completed'")->fetch_assoc()['count'];

// Active orders
$activeOrders = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status IN ('Pending','Processing')")->fetch_assoc()['count'];

// Total users
$totalUsers = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];

// ================= Activity Feed =================
$activities = [];

// Products
$prodRes = $conn->query("SELECT name, created_at, updated_at FROM products ORDER BY created_at DESC LIMIT 5");
while ($p = $prodRes->fetch_assoc()) {
  $activities[] = [
    'type' => 'product',
    'name' => $p['name'],
    'message' => $p['updated_at'] ? "Product updated: <strong>{$p['name']}</strong>" : "New product added: <strong>{$p['name']}</strong>",
    'created_at' => $p['updated_at'] ?? $p['created_at']
  ];
}

// Users
$userRes = $conn->query("SELECT username, created_at, updated_at FROM users ORDER BY created_at DESC LIMIT 5");
while ($u = $userRes->fetch_assoc()) {
  $activities[] = [
    'type' => 'user',
    'name' => $u['username'],
    'message' => $u['updated_at'] ? "User updated: <strong>{$u['username']}</strong>" : "New user registered: <strong>{$u['username']}</strong>",
    'created_at' => $u['updated_at'] ?? $u['created_at']
  ];
}

// Orders
$orderRes = $conn->query("
    SELECT o.id, o.product, o.status, o.created_at
    FROM orders o
    ORDER BY o.created_at DESC LIMIT 5
");
while ($o = $orderRes->fetch_assoc()) {
  $activities[] = [
    'type' => 'order',
    'name' => $o['product'],
    'message' => "New order (#{$o['id']}) for <strong>{$o['product']}</strong> - Status: {$o['status']}",
    'created_at' => $o['created_at']
  ];
}

// Sort by time descending
usort($activities, function ($a, $b) {
  return strtotime($b['created_at']) - strtotime($a['created_at']);
});

// Top 10
$activities = array_slice($activities, 0, 10);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comfy Dashboard</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="../img/logo.png" />
  <style>
    /* Sidebar & layout */
    .sidebar {
      transition: width 0.3s ease;
      overflow: hidden;
      background-color: #28433D;
      min-height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 50;
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

    .main-content {
      margin-left: 14rem;
      transition: margin-left 0.3s ease;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    body.collapsed .main-content {
      margin-left: 4rem;
    }

    /* Dashboard cards hover */
    .dashboard-card {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      cursor: pointer;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
    }

    .dashboard-card.revenue:hover {
      box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
    }

    .dashboard-card.completed:hover {
      box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }

    .dashboard-card.active:hover {
      box-shadow: 0 8px 20px rgba(234, 179, 8, 0.3);
    }

    .dashboard-card.users:hover {
      box-shadow: 0 8px 20px rgba(168, 85, 247, 0.3);
    }
  </style>
</head>

<body class="bg-gray-100 flex collapsed">

  <?php include "sidebar.php"; ?>

  <div class="main-content">
    <div class="flex-1 flex flex-col">
      <!-- Header -->
      <header class="flex justify-between items-center p-4 bg-white shadow">
        <h1 class="text-xl font-bold">Admin Portal</h1>
        <div class="flex items-center gap-6">
          <button class="relative">
            <i class="fas fa-bell text-gray-700 text-lg"></i>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 rounded-full">3</span>
          </button>
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

      <!-- Dashboard Content -->
      <main class="p-6 space-y-6 flex-1 overflow-auto">

        <!-- Overview & create product -->
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold text-gray-700">Dashboard Overview</h2>
          <a href="products.php" class="bg-green-800 text-white px-4 py-2 rounded shadow flex items-center gap-2">
            <i class="fas fa-plus"></i> Create New Product
          </a>
        </div>

        <!-- Top Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <div class="dashboard-card revenue bg-white p-4 rounded shadow flex items-center gap-4">
            <div class="p-3 rounded-full bg-green-100 text-green-600"><i class="fas fa-wallet text-xl"></i></div>
            <div>
              <p class="text-gray-600">Total Revenue</p>
              <h2 class="text-2xl font-bold">₦<?= number_format($totalRevenue, 2) ?></h2>
            </div>
          </div>
          <div class="dashboard-card completed bg-white p-4 rounded shadow flex items-center gap-4">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600"><i class="fas fa-check-circle text-xl"></i></div>
            <div>
              <p class="text-gray-600">Completed Orders</p>
              <h2 class="text-2xl font-bold"><?= $completedOrders ?></h2>
            </div>
          </div>
          <div class="dashboard-card active bg-white p-4 rounded shadow flex items-center gap-4">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600"><i class="fas fa-tasks text-xl"></i></div>
            <div>
              <p class="text-gray-600">Active Orders</p>
              <h2 class="text-2xl font-bold"><?= $activeOrders ?></h2>
            </div>
          </div>
          <div class="dashboard-card users bg-white p-4 rounded shadow flex items-center gap-4">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600"><i class="fas fa-users text-xl"></i></div>
            <div>
              <p class="text-gray-600">Total Users</p>
              <h2 class="text-2xl font-bold"><?= $totalUsers ?></h2>
            </div>
          </div>
        </div>

        <!-- Recent Orders & Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

          <!-- Recent Orders -->
          <div class="bg-white p-4 rounded shadow col-span-2">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-lg font-bold">Recent Orders</h2>
              <a href="order.php" class="text-[#F29D14] underline hover:text-[#d18210]">
                View All
              </a>
            </div>
            <div class="overflow-x-auto">
              <table class="w-full text-sm text-left border-collapse">
                <thead>
                  <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2">Order ID</th>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Deadline</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Value</th>
                    <th class="px-4 py-2"></th>
                  </tr>
                </thead>
                <tbody id="ordersTable">
                  <?php
                  $orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");
                  if ($orders->num_rows > 0):
                    while ($o = $orders->fetch_assoc()):
                  ?>
                      <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">ORD-<?= str_pad($o['id'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($o['product']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($o['quantity']) ?></td>
                        <td class="px-4 py-2"><?= date('Y-m-d', strtotime($o['deadline'])) ?></td>
                        <td class="px-4 py-2">
                          <?php if ($o['status'] == "Pending"): ?>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">Pending</span>
                          <?php elseif ($o['status'] == "Processing"): ?>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">Processing</span>
                          <?php elseif ($o['status'] == "Completed"): ?>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">Completed</span>
                          <?php endif; ?>
                        </td>
                        <td class="px-4 py-2">₦<?= number_format($o['value'], 2) ?></td>
                        <td class="px-4 py-2"><button onclick="openOrderModal(<?= $o['id'] ?>)" class="text-green-600 hover:underline">View Details</button></td>
                      </tr>
                    <?php endwhile;
                  else: ?>
                    <tr>
                      <td colspan="7" class="px-4 py-3 text-center text-gray-500">No recent orders found</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Activity -->
          <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-bold mb-4">Activity</h2>
            <ul id="activityFeed" class="space-y-3 text-sm overflow-y-auto max-h-80 pr-2">
              <?php
              foreach ($activities as $act):
                $icon = $act['type'] == 'product' ? 'fa-box' : ($act['type'] == 'user' ? 'fa-user' : 'fa-shopping-cart');

                // Calculate time ago
                $now = new DateTime();
                $created = new DateTime($act['created_at']);
                $diff = $now->diff($created);

                if ($diff->y > 0) {
                  $timeAgo = $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
                } elseif ($diff->m > 0) {
                  $timeAgo = $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
                } elseif ($diff->d > 0) {
                  $timeAgo = $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
                } elseif ($diff->h > 0) {
                  $timeAgo = $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
                } elseif ($diff->i > 0) {
                  $timeAgo = $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
                } else {
                  $timeAgo = 'Just now';
                }
              ?>
                <li class="flex justify-between items-start p-3 border rounded hover:bg-gray-50">
                  <div class="flex items-start gap-2">
                    <i class="fas <?= $icon ?> text-green-600 mt-1"></i>
                    <span class="text-green-700"><?= $act['message'] ?>
                      <span class="text-gray-400 text-xs">(<?= $timeAgo ?>)</span>
                    </span>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
            <button class="mt-4 w-full text-green-700 text-sm font-medium hover:underline" onclick="loadActivity()">View All Alerts</button>
          </div>
          <!-- End Activity -->

          <script>
            const sidebar = document.getElementById('sidebar');
            sidebar.addEventListener('mouseenter', () => document.body.classList.remove('collapsed'));
            sidebar.addEventListener('mouseleave', () => document.body.classList.add('collapsed'));

            function loadActivity() {
              alert("Load all activities - function to implement");
            }

            function toggleProfileDropdown() {
              document.getElementById('profileDropdown').classList.toggle('hidden');
            }
          </script>

</body>

</html>