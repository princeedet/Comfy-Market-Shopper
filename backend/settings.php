<?php
include 'config.php';

// Check if system_settings table has a row
$result = $conn->query("SELECT * FROM system_settings LIMIT 1");

if ($result && $result->num_rows > 0) {
    $settings = $result->fetch_assoc();
} else {
    // Table empty or doesn't exist, insert default settings
    $defaultSettings = [
        'system_language' => 'English',
        'admin_theme' => 'Light',
        'timezone' => 'GMT',
        'currency' => 'USD ($)',
        'system_font' => 'Hanken Grotesk',
        'allow_signup' => 1,
        'user_theme' => 'Light',
        'datetime_format' => 'DD/MM/YYYY',
        'notifications' => 1,
        'dashboard_layout' => 'Spacious',
        'update_frequency' => 'Monthly',
        'security_frequency' => 'Weekly',
        'log_format' => 'CSV,PDF,XLS'
    ];

    $stmt = $conn->prepare("INSERT INTO system_settings (system_language, admin_theme, timezone, currency, system_font, allow_signup, user_theme, datetime_format, notifications, dashboard_layout, update_frequency, security_frequency, log_format) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssssisisssss",
        $defaultSettings['system_language'],
        $defaultSettings['admin_theme'],
        $defaultSettings['timezone'],
        $defaultSettings['currency'],
        $defaultSettings['system_font'],
        $defaultSettings['allow_signup'],
        $defaultSettings['user_theme'],
        $defaultSettings['datetime_format'],
        $defaultSettings['notifications'],
        $defaultSettings['dashboard_layout'],
        $defaultSettings['update_frequency'],
        $defaultSettings['security_frequency'],
        $defaultSettings['log_format']
    );
    $stmt->execute();
    $stmt->close();

    $settings = $defaultSettings;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin Portal</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../img/logo.png" />
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

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }
    </style>
</head>

<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar sidebar-collapsed text-white h-screen flex flex-col py-4 overflow-hidden">
        <div class="flex items-center space-x-2 px-4 mb-8">
            <img src="../img/Group 243 (1).png" alt="logo" class="w-8 h-8" style="width: fit-content; height: fit-content;">
        </div>
        <nav class="flex-1 w-full">
            <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition"><i class="fas fa-home"></i><span class="sidebar-text">Dashboard</span></a>
            <a href="order.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition"><i class="fas fa-shopping-bag"></i><span class="sidebar-text">Orders</span></a>
            <a href="users.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition"><i class="fas fa-users"></i><span class="sidebar-text">Users</span></a>
            <a href="products.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition"><i class="fas fa-box"></i><span class="sidebar-text">Products</span></a>
            <a href="payment.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition"><i class="fas fa-credit-card"></i><span class="sidebar-text">Payments</span></a>
            <a href="settings.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-green-900 transition"><i class="fas fa-cog"></i><span class="sidebar-text">Settings</span></a>
        </nav>
        <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-red-600"><i class="fas fa-sign-out-alt"></i><span class="sidebar-text">Log Out</span></a>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
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

        <!-- Tab Navigation -->
        <div class="bg-white rounded shadow p-6 flex-1 flex flex-col">
            <nav class="flex gap-6 border-b border-gray-200 mb-6">
                <button id="employeeTab" class="pb-2 text-gray-500 hover:text-green-700 transition">Employee Central</button>
                <button id="settingsTab" class="pb-2 text-green-700 border-b-2 border-green-700 transition">General Settings</button>
            </nav>

            <!-- Tab Content -->
            <div class="relative flex-1 overflow-hidden">
                <!-- Employee Central -->
                <div id="employeeContent" class="absolute top-0 left-0 w-full h-full bg-white transform -translate-x-full transition-transform duration-500 p-4">
                    <div class="flex justify-between mb-4">
                        <button id="createBtn" class="bg-green-700 text-white px-4 py-2 rounded shadow hover:bg-green-800">Create New Employee</button>
                        <input type="text" id="employeeSearch" placeholder="Search employees..." class="border rounded px-3 py-2 w-1/3">
                    </div>
                    <div class="overflow-auto">
                        <table class="min-w-full border border-gray-200 rounded">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b">ID</th>
                                    <th class="py-2 px-4 border-b">Name</th>
                                    <th class="py-2 px-4 border-b">Email</th>
                                    <th class="py-2 px-4 border-b">Phone</th>
                                    <th class="py-2 px-4 border-b">Status</th>
                                    <th class="py-2 px-4 border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="employeeTable" class="text-gray-700">
                                <!-- Rows are dynamically loaded from DB -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- General Settings -->
                <div id="settingsContent" class="absolute top-0 left-0 w-full h-full bg-white transform translate-x-0 transition-transform duration-500 p-4">
                    <form id="settingsForm" action="save_settings.php" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-600 mb-2">System Language</label>
                            <select name="system_language" class="w-full border rounded px-3 py-2">
                                <option <?= $settings['system_language'] == 'English' ? 'selected' : '' ?>>English</option>
                                <option <?= $settings['system_language'] == 'French' ? 'selected' : '' ?>>French</option>
                                <option <?= $settings['system_language'] == 'Spanish' ? 'selected' : '' ?>>Spanish</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">Admin Dashboard Theme</label>
                            <select name="admin_theme" class="w-full border rounded px-3 py-2">
                                <option <?= $settings['admin_theme'] == 'Light' ? 'selected' : '' ?>>Light</option>
                                <option <?= $settings['admin_theme'] == 'Dark' ? 'selected' : '' ?>>Dark</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">Time Zone</label>
                            <select name="timezone" class="w-full border rounded px-3 py-2">
                                <option <?= $settings['timezone'] == 'GMT' ? 'selected' : '' ?>>GMT</option>
                                <option <?= $settings['timezone'] == 'WAT (West Africa Time)' ? 'selected' : '' ?>>WAT (West Africa Time)</option>
                                <option <?= $settings['timezone'] == 'CET (Central European Time)' ? 'selected' : '' ?>>CET (Central European Time)</option>
                                <option <?= $settings['timezone'] == 'EST (Eastern Time)' ? 'selected' : '' ?>>EST (Eastern Time)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">Currency</label>
                            <select name="currency" class="w-full border rounded px-3 py-2">
                                <option <?= $settings['currency'] == 'USD ($)' ? 'selected' : '' ?>>USD ($)</option>
                                <option <?= $settings['currency'] == 'NGN (₦)' ? 'selected' : '' ?>>NGN (₦)</option>
                                <option <?= $settings['currency'] == 'EUR (€)' ? 'selected' : '' ?>>EUR (€)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">System Font</label>
                            <select name="system_font" class="w-full border rounded px-3 py-2">
                                <option <?= $settings['system_font'] == 'Hanken Grotesk' ? 'selected' : '' ?>>Default: Hanken Grotesk</option>
                                <option <?= $settings['system_font'] == 'Arial' ? 'selected' : '' ?>>Arial</option>
                                <option <?= $settings['system_font'] == 'Roboto' ? 'selected' : '' ?>>Roboto</option>
                                <option <?= $settings['system_font'] == 'Open Sans' ? 'selected' : '' ?>>Open Sans</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">User Sign Up</label>
                            <label class="switch">
                                <input type="checkbox" name="allow_signup" <?= $settings['allow_signup'] ? 'checked' : '' ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">Default Theme for Users</label>
                            <select name="user_theme" class="w-full border rounded px-3 py-2">
                                <option <?= $settings['user_theme'] == 'Light' ? 'selected' : '' ?>>Light</option>
                                <option <?= $settings['user_theme'] == 'Dark' ? 'selected' : '' ?>>Dark</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">Date & Time Format</label>
                            <select name="datetime_format" class="w-full border rounded px-3 py-2">
                                <option <?= $settings['datetime_format'] == 'DD/MM/YYYY' ? 'selected' : '' ?>>DD/MM/YYYY</option>
                                <option <?= $settings['datetime_format'] == 'MM/DD/YYYY' ? 'selected' : '' ?>>MM/DD/YYYY</option>
                                <option <?= $settings['datetime_format'] == 'YYYY-MM-DD' ? 'selected' : '' ?>>YYYY-MM-DD</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">Notifications</label>
                            <label class="switch">
                                <input type="checkbox" name="notifications" <?= $settings['notifications'] ? 'checked' : '' ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">Admin Dashboard Layout</label>
                            <select name="dashboard_layout" class="w-full border rounded px-3 py-2">
                                <option <?= $settings['dashboard_layout'] == 'Spacious' ? 'selected' : '' ?>>Spacious</option>
                                <option <?= $settings['dashboard_layout'] == 'Compact' ? 'selected' : '' ?>>Compact</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">System Update Frequency</label>
                            <select name="update_frequency" class="w-full border rounded px-3 py-2">
                                <option <?= $settings['update_frequency'] == 'Daily' ? 'selected' : '' ?>>Daily</option>
                                <option <?= $settings['update_frequency'] == 'Monthly' ? 'selected' : '' ?>>Monthly</option>
                                <option <?= $settings['update_frequency'] == 'Yearly' ? 'selected' : '' ?>>Yearly</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">Security Checks Frequency</label>
                            <select name="security_frequency" class="w-full border rounded px-3 py-2">
                                <option <?= $settings['security_frequency'] == 'Daily' ? 'selected' : '' ?>>Daily</option>
                                <option <?= $settings['security_frequency'] == 'Weekly' ? 'selected' : '' ?>>Weekly</option>
                                <option <?= $settings['security_frequency'] == 'Monthly' ? 'selected' : '' ?>>Monthly</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2">Logs/Reports File Format</label>
                            <div class="flex gap-4">
                                <?php $log_formats = explode(',', $settings['log_format']); ?>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="log_format[]" value="CSV" <?= in_array('CSV', $log_formats) ? 'checked' : '' ?>> CSV
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="log_format[]" value="PDF" <?= in_array('PDF', $log_formats) ? 'checked' : '' ?>> PDF
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="log_format[]" value="XLS" <?= in_array('XLS', $log_formats) ? 'checked' : '' ?>> XLS
                                </label>
                            </div>
                        </div>
                        <div class="md:col-span-2 flex justify-end mt-6">
                            <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded shadow hover:bg-green-800">Save Settings</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Employee Modal -->
    <div id="employeeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-2xl shadow-lg w-[40rem] relative">
            <!-- Close button -->
            <button onclick="closeEmployeeModal()" class="absolute top-2 right-2 text-gray-500 text-2xl font-bold">&times;</button>

            <!-- Title -->
            <h2 id="modalTitle" class="text-xl font-bold mb-4 text-gray-800">Create New Employee</h2>

            <form id="employeeForm" class="space-y-6">
                <!-- Profile Picture Upload -->
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <label for="empPhoto" class="cursor-pointer flex flex-col items-center gap-2">
                        <i class="fas fa-camera text-green-700 text-2xl"></i>
                        <span class="text-green-700 font-medium">Upload Profile Picture</span>
                        <input type="file" id="empPhoto" name="photo" class="hidden" accept="image/*">
                    </label>
                    <p class="text-sm text-gray-500 mt-2">Add clear photos of employee for visual identification.</p>
                </div>

                <!-- Employee Details -->
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-600 mb-1">Employee Name <span class="text-red-500">*</span></label>
                            <input type="text" id="empName" name="name" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-700" required>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1">Assign Role</label>
                            <select id="empRole" name="role" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-700">
                                <option value="">Select Role...</option>
                                <option value="admin">Administrator</option>
                                <option value="manager">Manager</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-600 mb-1">Email Address</label>
                            <input type="email" id="empEmail" name="email" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-700">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1">Phone Number</label>
                            <input type="text" id="empPhone" name="phone" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-700">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-600 mb-1">Employee Address</label>
                        <textarea id="empAddress" name="address" rows="3" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-700"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-600 mb-1">Status</label>
                        <select id="empStatus" name="status" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-700">
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between mt-6">
                    <button type="button" onclick="closeEmployeeModal()" class="px-6 py-2 rounded-lg border border-green-700 text-green-700 hover:bg-green-50">Cancel</button>
                    <button type="submit" class="px-6 py-2 rounded-lg bg-green-700 text-white hover:bg-green-800">Create Employee</button>
                </div>
            </form>
        </div>
    </div>

    <!-- =======================
 View Employee Modal
======================= -->
    <div id="viewEmployeeModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
            <h2 class="text-xl font-bold mb-4">Employee Details</h2>
            <div class="space-y-2">
                <p><strong>ID:</strong> <span id="viewEmpId"></span></p>
                <p><strong>Name:</strong> <span id="viewEmpName"></span></p>
                <p><strong>Email:</strong> <span id="viewEmpEmail"></span></p>
                <p><strong>Phone:</strong> <span id="viewEmpPhone"></span></p>
                <p><strong>Status:</strong> <span id="viewEmpStatus"></span></p>
            </div>
            <div class="flex justify-end mt-4">
                <button id="closeViewModal" class="bg-gray-500 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>
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

    // Tab switching
    const employeeTab = document.getElementById('employeeTab');
    const settingsTab = document.getElementById('settingsTab');
    const employeeContent = document.getElementById('employeeContent');
    const settingsContent = document.getElementById('settingsContent');

    employeeTab.addEventListener('click', () => {
        employeeContent.classList.remove('-translate-x-full');
        employeeContent.classList.add('translate-x-0');
        settingsContent.classList.remove('translate-x-0');
        settingsContent.classList.add('translate-x-full');
        employeeTab.classList.add('text-green-700', 'border-b-2', 'border-green-700');
        settingsTab.classList.remove('text-green-700', 'border-b-2', 'border-green-700');
        settingsTab.classList.add('text-gray-500');
    });

    settingsTab.addEventListener('click', () => {
        settingsContent.classList.remove('translate-x-full');
        settingsContent.classList.add('translate-x-0');
        employeeContent.classList.remove('translate-x-0');
        employeeContent.classList.add('-translate-x-full');
        settingsTab.classList.add('text-green-700', 'border-b-2', 'border-green-700');
        employeeTab.classList.remove('text-green-700', 'border-b-2', 'border-green-700');
        employeeTab.classList.add('text-gray-500');
    });

    // Employee Modal
    const modal = document.getElementById('employeeModal');
    const modalTitle = document.getElementById('modalTitle');
    const empForm = document.getElementById('employeeForm');
    let editRow = null;

    function openEmployeeModal() {
        modal.classList.remove('hidden');
        modalTitle.textContent = 'Create New Employee';
        empForm.reset();
        editRow = null;
    }

    function closeEmployeeModal() {
        modal.classList.add('hidden');
        editRow = null;
    }

    // Load employees from DB
    function loadEmployees() {
        fetch('get_employees.php')
            .then(res => res.json())
            .then(data => {
                const table = document.getElementById('employeeTable');
                table.innerHTML = ''; // clear old rows
                data.forEach(emp => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="py-2 px-4 border-b">${emp.employee_id}</td>
                        <td class="py-2 px-4 border-b">${emp.name}</td>
                        <td class="py-2 px-4 border-b">${emp.email}</td>
                        <td class="py-2 px-4 border-b">${emp.phone}</td>
                        <td class="py-2 px-4 border-b"><span class="${emp.status==='Active'?'text-green-600':'text-red-600'} font-semibold">${emp.status}</span></td>
                        <td class="py-2 px-4 border-b flex gap-2">
                            <button class="viewBtn text-purple-600 hover:underline">View</button>
                            <button class="editBtn text-blue-600 hover:underline">Edit</button>
                            <button class="deleteBtn text-red-600 hover:underline">Delete</button>
                        </td>
                    `;
                    table.appendChild(row);
                    attachRowEvents(row);
                });
            })
            .catch(err => console.error("❌ Failed to load employees:", err));
    }

    // Save / Update Employee
    empForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(empForm);

        fetch('save_employee.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text()) // read raw
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    alert(`✅ ${data.message}\nEmployee ID: ${data.emp_id}\nTemporary password: ${data.password}`);
                    loadEmployees();
                    closeEmployeeModal();
                } else {
                    alert("❌ Error: " + data.message);
                }
            } catch (err) {
                console.error("Invalid JSON:", text);
                alert("❌ Server returned invalid JSON. Check save_employee.php output.");
            }
        })
        .catch(err => console.error("❌ Request failed:", err));
    });

    // Attach row events (edit, delete, view)
    function attachRowEvents(row) {
        // Edit
        row.querySelector('.editBtn').addEventListener('click', () => {
            editRow = row;
            modal.classList.remove('hidden');
            modalTitle.textContent = 'Edit Employee';
            document.getElementById('empName').value = row.cells[1].textContent;
            document.getElementById('empEmail').value = row.cells[2].textContent;
            document.getElementById('empPhone').value = row.cells[3].textContent;
            document.getElementById('empStatus').value = row.cells[4].textContent.trim() === 'Active' ? 'Active' : 'Inactive';
        });

        // Delete
        row.querySelector('.deleteBtn').addEventListener('click', () => {
            const empId = row.cells[0].textContent;
            if (confirm("Are you sure you want to delete this employee?")) {
                fetch('delete_employee.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `employee_id=${encodeURIComponent(empId)}`
                })
                .then(res => res.text())
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        if (data.success) {
                            alert("✅ " + data.message);
                            row.remove();
                        } else {
                            alert("❌ Error deleting: " + data.message);
                        }
                    } catch (err) {
                        console.error("Invalid JSON:", text);
                        alert("❌ Server returned invalid JSON. Check delete_employee.php output.");
                    }
                })
                .catch(err => alert("❌ Request failed: " + err));
            }
        });

        // View
        row.querySelector('.viewBtn').addEventListener('click', () => {
            const cells = row.querySelectorAll('td');
            document.getElementById('viewEmpId').textContent = cells[0].textContent;
            document.getElementById('viewEmpName').textContent = cells[1].textContent;
            document.getElementById('viewEmpEmail').textContent = cells[2].textContent;
            document.getElementById('viewEmpPhone').textContent = cells[3].textContent;
            document.getElementById('viewEmpStatus').textContent = cells[4].innerText;
            document.getElementById('viewEmployeeModal').classList.remove('hidden');
        });
    }

    // Create button
    document.getElementById('createBtn').addEventListener('click', openEmployeeModal);

    // Close view modal
    document.getElementById('closeViewModal').addEventListener('click', () => {
        document.getElementById('viewEmployeeModal').classList.add('hidden');
    });

    // Employee search
    const searchInput = document.getElementById('employeeSearch');
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('#employeeTable tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
        });
    });

    // Load employees on page load
    window.addEventListener('DOMContentLoaded', loadEmployees);
</script>


</body>

</html>