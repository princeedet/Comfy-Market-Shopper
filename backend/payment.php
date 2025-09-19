<?php
include 'config.php';

// ================= Payment Summary =================
$totalRevenue = $conn->query("SELECT SUM(amount) AS total FROM payments")->fetch_assoc()['total'] ?? 0;
$successful   = $conn->query("SELECT COUNT(*) AS cnt FROM payments WHERE status='Successful'")->fetch_assoc()['cnt'];
$pending      = $conn->query("SELECT COUNT(*) AS cnt FROM payments WHERE status='Pending'")->fetch_assoc()['cnt'];
$failed       = $conn->query("SELECT COUNT(*) AS cnt FROM payments WHERE status='Failed'")->fetch_assoc()['cnt'];

// ================= Payments List =================
$payments = $conn->query("SELECT * FROM payments ORDER BY created_at DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../img/logo.png">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
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

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out;
        }
    </style>
</head>

<body class="bg-gray-100 flex collapsed">

    <!-- Sidebar -->
    <?php include "sidebar.php"; ?>

    <!-- Main Content -->
    <div class="main-content flex-1 ml-14 md:ml-56 transition-all">
        <header class="flex justify-between items-center p-4 bg-white shadow">
            <h1 class="text-xl font-bold">Payment Management</h1>
            <div class="flex items-center gap-6">
                <button class="relative">
                    <i class="fas fa-bell text-gray-700 text-lg"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 rounded-full">3</span>
                </button>
                <button class="flex items-center gap-2">
                    <i class="fas fa-user-circle text-gray-600 text-2xl"></i>
                    <div class="flex flex-col items-start">
                        <span class="hidden md:inline-block">Admin</span>
                        <span class="text-xs text-gray-500">Administrator</span>
                    </div>
                </button>
        </header>

        <!-- Dashboard Content -->
        <main class="p-6 space-y-6 flex-1 overflow-auto">

            <!-- Top Section -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-700">Payment Management</h2>

                <!-- Export Dropdown -->
                <div class="relative">
                    <button onclick="toggleExportMenu()" class="px-4 py-2 bg-green-700 text-white rounded-lg flex items-center gap-2 shadow">
                        <i class="fas fa-download"></i> Export History
                    </button>
                    <div id="exportMenu" class="hidden absolute right-0 mt-2 bg-white border rounded shadow w-40 z-50">
                        <a href="export.php?type=excel" class="block px-4 py-2 hover:bg-gray-100"><i class="fas fa-file-excel text-green-600"></i> Excel</a>
                        <a href="export.php?type=pdf" class="block px-4 py-2 hover:bg-gray-100"><i class="fas fa-file-pdf text-red-600"></i> PDF</a>
                        <a href="export.php?type=doc" class="block px-4 py-2 hover:bg-gray-100"><i class="fas fa-file-word text-blue-600"></i> Word</a>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div onclick="filterPayments('')" class="bg-white p-4 rounded shadow flex items-center gap-4 hover:shadow-lg cursor-pointer">
                    <div class="p-3 bg-green-100 text-green-700 rounded-full"><i class="fas fa-wallet text-xl"></i></div>
                    <div>
                        <p class="text-gray-600">Total Revenue</p>
                        <h2 class="text-2xl font-bold">₦<?= number_format($totalRevenue, 2) ?></h2>
                    </div>
                </div>
                <div onclick="filterPayments('Successful')" class="bg-white p-4 rounded shadow flex items-center gap-4 hover:shadow-lg cursor-pointer">
                    <div class="p-3 bg-blue-100 text-blue-700 rounded-full"><i class="fas fa-check-circle text-xl"></i></div>
                    <div>
                        <p class="text-gray-600">Successful Payment</p>
                        <h2 class="text-2xl font-bold"><?= $successful ?></h2>
                    </div>
                </div>
                <div onclick="filterPayments('Pending')" class="bg-white p-4 rounded shadow flex items-center gap-4 hover:shadow-lg cursor-pointer">
                    <div class="p-3 bg-yellow-100 text-yellow-700 rounded-full"><i class="fas fa-hourglass-half text-xl"></i></div>
                    <div>
                        <p class="text-gray-600">Pending Payment</p>
                        <h2 class="text-2xl font-bold"><?= $pending ?></h2>
                    </div>
                </div>
                <div onclick="filterPayments('Failed')" class="bg-white p-4 rounded shadow flex items-center gap-4 hover:shadow-lg cursor-pointer">
                    <div class="p-3 bg-red-100 text-red-700 rounded-full"><i class="fas fa-times-circle text-xl"></i></div>
                    <div>
                        <p class="text-gray-600">Failed Payment</p>
                        <h2 class="text-2xl font-bold"><?= $failed ?></h2>
                    </div>
                </div>
            </div>

            <!-- Payments Table -->
            <div class="bg-white rounded shadow overflow-x-auto mt-6">
                <h2 class="text-lg font-bold p-4 border-b">Payments</h2>
                <table id="paymentsTable" class="w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">Payment ID</th>
                            <th class="px-4 py-2">Customer & Order</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Payment Method</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($payments->num_rows > 0): ?>
                            <?php while ($p = $payments->fetch_assoc()): ?>
                                <tr class="border-b hover:bg-gray-50" data-status="<?= $p['status'] ?>">
                                    <td class="px-4 py-2">
                                        CMS-<?= str_pad($p['id'], 5, '0', STR_PAD_LEFT) ?><br>
                                        <span class="text-xs text-gray-500"><?= date('d-m-Y | H:i', strtotime($p['created_at'])) ?></span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?= htmlspecialchars($p['customer']) ?><br>
                                        <span class="text-xs text-gray-500">Order: <?= $p['order_id'] ?> | <?= htmlspecialchars($p['product']) ?></span>
                                    </td>
                                    <td class="px-4 py-2 font-bold">₦<?= number_format($p['amount'], 2) ?></td>
                                    <td class="px-4 py-2">
                                        <?= htmlspecialchars($p['method']) ?><br>
                                        <span class="text-xs text-gray-500">Txn ID: <?= $p['txn_id'] ?></span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?php if ($p['status'] == "Successful"): ?>
                                            <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">Successful</span>
                                        <?php elseif ($p['status'] == "Pending"): ?>
                                            <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">Failed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="invoice.php?id=<?= htmlspecialchars($p['id'], ENT_QUOTES) ?>"
                                            target="_blank"
                                            class="text-blue-700 hover:underline mr-2">Invoice</a>
                                        <a href="view.php?id=<?= htmlspecialchars($p['id'], ENT_QUOTES); ?>"
                                            class="text-green-700 hover:underline">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500">No payments found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg w-96 shadow-lg p-6 animate-fadeIn relative">
                <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
                <h2 class="text-xl font-bold mb-4">Payment Details</h2>
                <div id="paymentDetails" class="space-y-2 text-sm">Loading...</div>
                <div class="flex justify-between mt-4">
                    <a id="printBtn" href="#" target="_blank" class="px-3 py-1 bg-blue-600 text-white rounded">Print</a>
                    <a id="downloadBtn" href="#" class="px-3 py-1 bg-green-600 text-white rounded">Download</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        sidebar.addEventListener('mouseenter', () => document.body.classList.remove('collapsed'));
        sidebar.addEventListener('mouseleave', () => document.body.classList.add('collapsed'));

        function toggleExportMenu() {
            document.getElementById('exportMenu').classList.toggle('hidden');
        }

        function filterPayments(status) {
            const rows = document.querySelectorAll("#paymentsTable tbody tr");
            rows.forEach(row => {
                row.style.display = (!status || row.getAttribute("data-status") === status) ? "" : "none";
            });
        }

        // Modal Handling (AJAX)
        function viewPayment(id) {
            fetch(`view_payment.php?id=${id}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById("paymentDetails").innerHTML = html;
                    document.getElementById("printBtn").href = `invoice.php?id=${id}`;
                    document.getElementById("downloadBtn").href = `invoice.php?id=${id}&download=1`;
                    document.getElementById("paymentModal").classList.remove("hidden");
                })
                .catch(err => {
                    document.getElementById("paymentDetails").innerHTML =
                        `<p class="text-red-600">Error loading payment details.</p>`;
                    console.error("Error:", err);
                });
        }

        function closeModal() {
            document.getElementById("paymentModal").classList.add("hidden");
        }

        document.getElementById("paymentModal").addEventListener("click", function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>

</body>

</html>