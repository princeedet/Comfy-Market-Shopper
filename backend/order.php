<?php
include 'config.php';

// Helper to fetch product name
function getProductName($conn, $product_id)
{
    $stmt = $conn->prepare("SELECT name FROM products WHERE id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['name'] ?? 'Unknown';
}

// Get tab, search, and status from URL
$tab = $_GET['tab'] ?? 'orders'; // 'orders' or 'meat'
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

// Build query
$sql = "SELECT * FROM orders WHERE 1";
$params = [];
$types = "";

// Tab filter
if ($tab === 'meat') {
    $sql .= " AND product_id IN (SELECT id FROM products WHERE category='Meat')";
}

// Search filter
if ($search) {
    $sql .= " AND (customer LIKE ? OR product LIKE ?)";
    $searchTerm = "%$search%";
    $params[] = &$searchTerm;
    $params[] = &$searchTerm;
    $types .= "ss";
}

// Status filter
if ($status) {
    $sql .= " AND status=?";
    $params[] = &$status;
    $types .= "s";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Preload all orders for modal
$allOrders = [];
$res2 = $conn->query("SELECT * FROM orders");
while ($r = $res2->fetch_assoc()) {
    $allOrders[$r['id']] = $r;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Comfy Dashboard - Orders</title>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="icon" type="image/png" href="../img/logo.png" />
<style>
.sidebar { transition: width 0.3s; overflow: hidden; background-color: #28433D; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 50; }
.sidebar-collapsed { width:4rem; }
.sidebar-expanded { width:14rem; }
.main-content { margin-left:14rem; transition:margin-left 0.3s; flex:1; display:flex; flex-direction:column; }
body.collapsed .main-content { margin-left:4rem; }
table th, table td { padding: 0.75rem 1rem; text-align:left; }
table th { background-color: #f3f4f6; }
table tr:hover { background-color: #f9fafb; }
.tab-btn { padding-bottom: 0.5rem; font-weight: 500; cursor: pointer; }
.tab-active { border-b-2 border-[#F29D14]; color:#F29D14; font-semibold; }
.tab-inactive { color: #555; }
/* Modal Animations */
#orderModal { transition: opacity 0.3s ease; backdrop-filter: blur(4px); }
#orderModalContent { transition: transform 0.3s ease; transform: scale(0.9); }
</style>
</head>
<body class="bg-gray-100 flex collapsed">

<?php include 'sidebar.php'; ?>

<div class="main-content">

<!-- Header -->
<header class="bg-white shadow">
<div class="flex justify-between items-center p-4">
    <h1 class="text-xl font-bold">Admin Dashboard</h1>
    <div class="flex items-center gap-4">
        <button class="relative">
            <i class="fas fa-bell text-gray-700 text-lg"></i>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 rounded-full">3</span>
        </button>
        <div class="relative">
            <button onclick="toggleProfileDropdown()" class="flex items-center gap-2">
                <i class="fas fa-user-circle text-gray-600 text-2xl"></i>
                <span class="hidden md:inline-block">Admin</span>
            </button>
            <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white border rounded shadow hidden p-4">
                <span class="font-medium block">Admin</span>
                <span class="text-xs text-gray-500">Super Admin</span>
                <div class="border-t my-2"></div>
                <a href="settings.php" class="block px-4 py-2 hover:bg-gray-100"><i class="fas fa-user-cog mr-2"></i> Profile</a>
                <a href="settings.php" class="block px-4 py-2 hover:bg-gray-100"><i class="fas fa-cog mr-2"></i> Settings</a>
                <a href="logout.php" class="block px-4 py-2 hover:bg-gray-100"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
            </div>
        </div>
    </div>
</div>
</header>

<main class="p-6">

<!-- Filters -->
<form method="get" class="mb-4 flex flex-wrap gap-2">
    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search orders..." class="flex-1 px-4 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    <select name="status" class="px-3 py-2 border rounded-md text-sm">
        <option value="">All Status</option>
        <option value="Completed" <?= $status=='Completed'?'selected':'' ?>>Completed</option>
        <option value="Processing" <?= $status=='Processing'?'selected':'' ?>>Processing</option>
        <option value="Pending" <?= $status=='Pending'?'selected':'' ?>>Pending</option>
    </select>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm">Filter</button>
</form>

<!-- Tabs -->
<div class="bg-white shadow-md rounded-lg p-4 mb-4 flex gap-6">
    <a href="?tab=orders&search=<?= urlencode($search) ?>&status=<?= urlencode($status) ?>" class="tab-btn <?= $tab=='orders'?'tab-active':'tab-inactive' ?>">Orders</a>
    <a href="?tab=meat&search=<?= urlencode($search) ?>&status=<?= urlencode($status) ?>" class="tab-btn <?= $tab=='meat'?'tab-active':'tab-inactive' ?>">Meat-Sharing Options</a>
</div>

<!-- Orders Table -->
<div class="bg-white shadow-md rounded-lg overflow-x-auto">
<table class="w-full min-w-[800px] text-sm">
<thead>
<tr>
    <th>Order ID</th>
    <th>Product</th>
    <th>Customer</th>
    <th>Quantity</th>
    <th>Total</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php while($row=$result->fetch_assoc()):
    $productName = $row['product_id'] ? getProductName($conn,$row['product_id']) : ($row['product']??'Unknown');
    $statusColor = match($row['status']){
        'Completed'=>'bg-green-600',
        'Processing'=>'bg-yellow-500',
        'Pending'=>'bg-red-600',
        default=>'bg-gray-500'
    };
?>
<tr>
    <td><?= 'ORD-'.str_pad($row['id'],3,'0',STR_PAD_LEFT) ?></td>
    <td><?= htmlspecialchars($productName) ?></td>
    <td><?= htmlspecialchars($row['customer']??'Unknown') ?></td>
    <td><?= htmlspecialchars($row['quantity']??1) ?></td>
    <td>₦<?= number_format($row['value']??0) ?></td>
    <td><span class="px-2 py-1 text-white rounded <?= $statusColor ?>"><?= $row['status']??'Unknown' ?></span></td>
    <td>
        <a href="#" onclick="openOrderModal(<?= $row['id'] ?>)" class="text-blue-600 hover:underline">View</a> |
        <a href="delete-order.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this order?')" class="text-red-600 hover:underline">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
<?php if($result->num_rows==0): ?>
<tr>
    <td colspan="7" class="text-center py-4 text-gray-500">No orders found</td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>

</main>
</div>

<!-- Order Modal -->
<div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm opacity-0">
<div id="orderModalContent" class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md relative transform scale-90">
    <button onclick="closeOrderModal()" class="absolute top-2 right-2 text-gray-500 text-xl font-bold">&times;</button>
    <h2 class="text-lg font-bold mb-4 text-center">Order Details</h2>
    <div id="orderDetails" class="text-sm space-y-2"></div>
    <button onclick="closeOrderModal()" class="mt-4 w-full bg-green-700 text-white py-2 rounded hover:bg-green-800">Close</button>
</div>
</div>

<script>
const ordersData = <?= json_encode($allOrders) ?>;

function openOrderModal(orderId){
    const order = ordersData[orderId];
    if(!order) return alert('Order not found');

    const productName = order.product_id?"<?= getProductName($conn,0) ?>".replace('0',order.product_id):(order.product??'Unknown');

    let html = `
        <p><strong>Order ID:</strong> ORD-${String(order.id).padStart(3,'0')}</p>
        <p><strong>Product:</strong> ${productName}</p>
        <p><strong>Customer Name:</strong> ${order.customer??'Unknown'}</p>
        <p><strong>Quantity:</strong> ${order.quantity??1}</p>
        <p><strong>Total:</strong> ₦${Number(order.value??0).toLocaleString()}</p>
        <p><strong>Delivery Address:</strong> ${order.address??'Unknown'}</p>
        <p><strong>Status:</strong> ${order.status??'Unknown'}</p>
        <p><strong>Created At:</strong> ${order.created_at??'Unknown'}</p>
    `;
    const modal = document.getElementById('orderModal');
    const modalContent = document.getElementById('orderModalContent');
    document.getElementById('orderDetails').innerHTML = html;

    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-90');
    }, 10);
}

function closeOrderModal(){
    const modal = document.getElementById('orderModal');
    const modalContent = document.getElementById('orderModalContent');
    modal.classList.add('opacity-0');
    modalContent.classList.add('scale-90');
    setTimeout(() => modal.classList.add('hidden'), 300);
}
</script>

</body>
</html>
