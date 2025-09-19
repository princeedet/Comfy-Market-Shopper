<?php
include 'config.php';

// In future, fetch system settings from DB if needed
// Example: $settings = $conn->query("SELECT * FROM settings LIMIT 1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar sidebar-collapsed text-white h-screen flex flex-col py-4 transition-all duration-300 overflow-hidden bg-[#28433D]">
        <!-- Logo -->
        <div class="flex items-center space-x-2 px-4 mb-8">
            <img src="../img/Group 243 (1).png" alt="logo" class="w-8 h-8" style="width: fit-content; height: fit-content;">
        </div>
        <nav class="flex-1 w-full">
            <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700"><i class="fas fa-home"></i><span class="sidebar-text">Dashboard</span></a>
            <a href="order.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700"><i class="fas fa-shopping-bag"></i><span class="sidebar-text">Orders</span></a>
            <a href="users.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700"><i class="fas fa-users"></i><span class="sidebar-text">Users</span></a>
            <a href="products.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700"><i class="fas fa-box"></i><span class="sidebar-text">Products</span></a>
            <a href="payment.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-700"><i class="fas fa-credit-card"></i><span class="sidebar-text">Payments</span></a>
            <a href="settings.php" class="flex items-center space-x-3 px-4 py-3 bg-green-700"><i class="fas fa-cog"></i><span class="sidebar-text">Settings</span></a>
        </nav>
        <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-red-600">
            <i class="fas fa-sign-out-alt"></i>
            <span class="sidebar-text">Log Out</span>
        </a>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="flex justify-between items-center p-4 bg-white shadow">
            <h1 class="text-xl font-bold">Settings</h1>
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

        <!-- General Settings -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-bold mb-6">General Settings</h2>

            <form id="settingsForm" action="save_settings.php" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- System Language -->
                <div>
                    <label class="block text-gray-600 mb-2">System Language</label>
                    <select name="system_language" class="w-full border rounded px-3 py-2">
                        <option selected>English</option>
                        <option>French</option>
                        <option>Spanish</option>
                    </select>
                </div>

                <!-- Admin Dashboard Theme -->
                <div>
                    <label class="block text-gray-600 mb-2">Admin Dashboard Theme</label>
                    <select name="admin_theme" class="w-full border rounded px-3 py-2">
                        <option selected>Light</option>
                        <option>Dark</option>
                    </select>
                </div>

                <!-- Time Zone -->
                <div>
                    <label class="block text-gray-600 mb-2">Time Zone</label>
                    <select name="timezone" class="w-full border rounded px-3 py-2">
                        <option selected>GMT</option>
                        <option>WAT (West Africa Time)</option>
                        <option>CET (Central European Time)</option>
                        <option>EST (Eastern Time)</option>
                    </select>
                </div>

                <!-- Currency -->
                <div>
                    <label class="block text-gray-600 mb-2">Currency</label>
                    <select name="currency" class="w-full border rounded px-3 py-2">
                        <option selected>USD ($)</option>
                        <option>NGN (₦)</option>
                        <option>EUR (€)</option>
                    </select>
                </div>

                <!-- System Font -->
                <div>
                    <label class="block text-gray-600 mb-2">System Font</label>
                    <select name="system_font" class="w-full border rounded px-3 py-2">
                        <option selected>Default: Hanken Grotesk</option>
                        <option>Arial</option>
                        <option>Roboto</option>
                        <option>Open Sans</option>
                    </select>
                </div>

                <!-- User Sign Up -->
                <div>
                    <label class="block text-gray-600 mb-2">User Sign Up</label>
                    <label class="switch">
                        <input type="checkbox" name="allow_signup" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Default Theme for Users -->
                <div>
                    <label class="block text-gray-600 mb-2">Default Theme for Users</label>
                    <select name="user_theme" class="w-full border rounded px-3 py-2">
                        <option selected>Light</option>
                        <option>Dark</option>
                    </select>
                </div>

                <!-- Date & Time Format -->
                <div>
                    <label class="block text-gray-600 mb-2">Date & Time Format</label>
                    <select name="datetime_format" class="w-full border rounded px-3 py-2">
                        <option selected>DD/MM/YYYY</option>
                        <option>MM/DD/YYYY</option>
                        <option>YYYY-MM-DD</option>
                    </select>
                </div>

                <!-- Notifications -->
                <div>
                    <label class="block text-gray-600 mb-2">Notifications</label>
                    <label class="switch">
                        <input type="checkbox" name="notifications" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Admin Dashboard Layout -->
                <div>
                    <label class="block text-gray-600 mb-2">Admin Dashboard Layout</label>
                    <select name="dashboard_layout" class="w-full border rounded px-3 py-2">
                        <option selected>Spacious</option>
                        <option>Compact</option>
                    </select>
                </div>

                <!-- System Update Frequency -->
                <div>
                    <label class="block text-gray-600 mb-2">System Update Frequency</label>
                    <select name="update_frequency" class="w-full border rounded px-3 py-2">
                        <option>Daily</option>
                        <option selected>Monthly</option>
                        <option>Yearly</option>
                    </select>
                </div>

                <!-- Security Checks Frequency -->
                <div>
                    <label class="block text-gray-600 mb-2">Security Checks Frequency</label>
                    <select name="security_frequency" class="w-full border rounded px-3 py-2">
                        <option>Daily</option>
                        <option selected>Weekly</option>
                        <option>Monthly</option>
                    </select>
                </div>

                <!-- Logs/Reports Format -->
                <div>
                    <label class="block text-gray-600 mb-2">Logs/Reports File Format</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="log_format[]" value="CSV" checked>
                            CSV
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="log_format[]" value="PDF" checked>
                            PDF
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="log_format[]" value="XLS" checked>
                            XLS
                        </label>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="md:col-span-2 flex justify-end mt-6">
                    <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded shadow hover:bg-green-800">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
        </main>
    </div>
    <script>
        // Sidebar hover expand/collapse
        const sidebar = document.getElementById('sidebar');
        sidebar.addEventListener('mouseenter', () => {
            sidebar.classList.remove('sidebar-collapsed');
            sidebar.classList.add('w-56');
        });
        sidebar.addEventListener('mouseleave', () => {
            sidebar.classList.add('sidebar-collapsed');
            sidebar.classList.remove('w-56');
        });
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