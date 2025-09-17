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
            <h1 class="text-xl font-bold">User Management</h1>
            <div class="flex items-center gap-4">

                <!-- Create New Product Dropdown -->

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
                    <p class="text-gray-600">Total Users</p>
                    <h2 class="text-2xl font-bold text-green-700">172</h2>
                    <p class="text-sm text-green-500">+12.5% from last month</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-600">Active Users</p>
                    <h2 class="text-2xl font-bold">171</h2>
                    <p class="text-sm text-green-500">+8.3% from last month</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-600">Total Orders</p>
                    <h2 class="text-2xl font-bold">342</h2>
                    <p class="text-sm text-green-500">+5.1% from last month</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-600">New This Month</p>
                    <h2 class="text-2xl font-bold">23</h2>
                    <p class="text-sm text-green-500">+15.0% from last month</p>
                </div>
            </div>

            <!-- Search Box Container -->
            
            <div class="w-full bg-white p-4 rounded shadow border border-gray-200">
      <div class="flex items-center w-full space-x-2">
        <!-- Search Input with Icon -->
        <div class="relative flex-1">
          <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
            <i class="fas fa-search"></i>
          </span>
          <input
            type="text"
            placeholder="Search Users..."
            class="w-full pl-10 pr-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Status Dropdown -->
        <div class="relative">
          <button
            class="flex items-center px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100">
            <i class="fas fa-filter text-green-600 mr-2"></i>
            <span>All Status</span>
            <i class="fas fa-chevron-down ml-2 text-gray-400"></i>
          </button>
        </div>
      </div>
    </div>

            <!-- End Search Box Container -->

            <!-- Registered Users Table -->
            <div class="bg-white p-6 rounded shadow mt-6">
                <h2 class="text-lg font-bold mb-4">Registered Users</h2>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">User</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Phone</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="p-3">Chidi Nwafor</td>
                            <td class="p-3">chidimike@gmail.com</td>
                            <td class="p-3">08033287236</td>
                            <td class="p-3"><span class="bg-green-100 text-green-600 px-2 py-1 rounded">Active</span></td>
                            <td class="p-3">
                                <button onclick="openUserModal('Chidi Nwafor','chidimike@gmail.com','08033287236','Active','213, Commercial Avenue, Yaba, Lagos',13)"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    View
                                </button>
                            </td>
                        </tr>
                        <!-- Repeat rows dynamically with PHP/MySQL -->
                    </tbody>
                </table>
            </div>
            <!-- End Registered Users Table -->

            <!-- User Modal -->
            <div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
                <div class="bg-white p-6 rounded shadow w-96 relative">
                    <button onclick="closeUserModal()" class="absolute top-2 right-2 text-gray-500">&times;</button>
                    <h2 class="text-lg font-bold mb-4">View User Profile</h2>
                    <div id="userDetails"></div>

                    <div class="flex justify-between mt-6">
                        <button onclick="suspendUser()" class="px-4 py-2 bg-yellow-500 text-white rounded">Suspend</button>
                        <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
                    </div>
                </div>
            </div>
            <!-- End User Modal -->

            <div id="confirmDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
                <div class="bg-white p-6 rounded shadow w-96 text-center">
                    <h2 class="text-lg font-bold mb-4">Disable User</h2>
                    <p>Are you sure you want to disable this user?</p>
                    <div class="flex justify-between mt-6">
                        <button onclick="closeConfirmDelete()" class="px-4 py-2 border rounded">Cancel</button>
                        <button onclick="deleteUser()" class="px-4 py-2 bg-red-600 text-white rounded">Disable</button>
                    </div>
                </div>
            </div>
            <!-- End User Modal -->



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

                function openUserModal(name, email, phone, status, address, orders) {
                    document.getElementById("userDetails").innerHTML = `
    <p><strong>User:</strong> ${name}</p>
    <p><strong>Email:</strong> ${email}</p>
    <p><strong>Phone:</strong> ${phone}</p>
    <p><strong>Address:</strong> ${address}</p>
    <p><strong>Total Orders:</strong> ${orders}</p>
    <p><strong>Status:</strong> <span class="px-2 py-1 rounded ${status==='Active'?'bg-green-100 text-green-600':'bg-red-100 text-red-600'}">${status}</span></p>
  `;
                    document.getElementById("userModal").classList.remove("hidden");
                }

                function closeUserModal() {
                    document.getElementById("userModal").classList.add("hidden");
                }

                function confirmDelete() {
                    document.getElementById("confirmDeleteModal").classList.remove("hidden");
                }

                function closeConfirmDelete() {
                    document.getElementById("confirmDeleteModal").classList.add("hidden");
                }

                function deleteUser() {
                    alert("User deleted successfully!");
                    closeConfirmDelete();
                    closeUserModal();
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