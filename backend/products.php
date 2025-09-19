<?php
include 'config.php';

// Include activity logging function
function logActivity($conn, $type, $message, $reference_id = null, $details = null) {
    $stmt = $conn->prepare("INSERT INTO activity (type, message, reference_id, details) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $type, $message, $reference_id, $details);
    $stmt->execute();
    $stmt->close();
}

// ================= Add Product =================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {

    // ADD
    if($_POST['action'] === 'add'){
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $special_offer = isset($_POST['special_offer']) ? 'Yes' : 'No';

        $image = '';
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
            $targetDir = "uploads/";
            $image = $targetDir . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        }

        $stmt = $conn->prepare("INSERT INTO products (name, description, price, category, image, status, special_offer) VALUES (?, ?, ?, ?, ?, 'Available', ?)");
        $stmt->bind_param("ssdsss", $name, $description, $price, $category, $image, $special_offer);

        if($stmt->execute()){
            $product_id = $stmt->insert_id;
            logActivity($conn, 'product', "Product <b>$name</b> added", $product_id);
            header("Location: products.php?success=1");
            exit;
        } else {
            header("Location: products.php?error=" . urlencode($stmt->error));
            exit;
        }
    }

    // TOGGLE STOCK STATUS
    if($_POST['action'] === 'toggle'){
        $id = $_POST['id'];
        $product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
        $newStatus = $product['status'] === 'Available' ? 'Out of Stock' : 'Available';
        $conn->query("UPDATE products SET status='$newStatus' WHERE id=$id");
        logActivity($conn, 'product', "Product <b>{$product['name']}</b> status changed to <b>$newStatus</b>", $id, json_encode(['old_status'=>$product['status']]));
        echo json_encode(['success'=>true,'newStatus'=>$newStatus]);
        exit;
    }
}

// ================= Fetch Products =================
$result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
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
<link rel="icon" type="image/png" href="../img/logo.png"/>
</head>
<body class="bg-gray-100 flex">

<!-- Sidebar -->
<div id="sidebar" class="sidebar sidebar-collapsed text-white h-screen flex flex-col py-4 transition-all duration-300 overflow-hidden bg-[#28433D]">
   <!-- Logo -->
  <div class="flex items-center justify-center px-4 mb-8">
    <img src="../img/Group 243 (1).png" alt="logo" class="w-8 h-8" style="width: fit-content; height: fit-content;">
  </div>

  <!-- Nav Menu -->
  <nav class="flex-1 w-full">
    <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-home"></i><span class="sidebar-text">Dashboard</span></a>
    <a href="order.php" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-shopping-bag"></i><span class="sidebar-text">Orders</span></a>
    <a href="users.php" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-users"></i><span class="sidebar-text">Users</span></a>
    <a href="products.php" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-box"></i><span class="sidebar-text">Products</span></a>
    <a href="payment.php" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-credit-card"></i><span class="sidebar-text">Payments</span></a>
    <a href="settings.php" class="flex items-center space-x-3 px-4 py-3"><i class="fas fa-cog"></i><span class="sidebar-text">Settings</span></a>
  </nav>
  <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 hover:bg-red-600">
    <i class="fas fa-sign-out-alt"></i><span class="sidebar-text">Log Out</span>
  </a>
</div>

<!-- Main Content -->
<div class="flex-1 flex flex-col">
  <header class="flex justify-between items-center p-4 bg-white shadow">
    <h1 class="text-xl font-bold">Admin Portal</h1>
    <div class="flex items-center gap-4">
      <div class="relative">
        <button onclick="toggleProductDropdown()" class="bg-green-800 text-white px-4 py-2 rounded shadow flex items-center gap-2">
          <i class="fas fa-plus"></i> Create New Product
        </button>
        <div id="productDropdown" class="absolute left-0 mt-2 w-48 bg-white border rounded shadow hidden z-50">
          <a href="#" onclick="openProductModal()" class="block px-4 py-2 hover:bg-gray-100">+ New Product</a>
          <a href="#" class="block px-4 py-2 hover:bg-gray-100">+ New Meat-Sharing Order</a>
        </div>
      </div>
      <i class="fas fa-bell"></i>
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
  <!-- End of Header -->

  <!-- Search Box -->
  <div class="w-full bg-white p-4 rounded shadow border border-gray-200">
    <div class="flex items-center w-full space-x-2">
      <div class="relative flex-1">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
          <i class="fas fa-search"></i>
        </span>
        <input type="text" placeholder="Search Products..." class="w-full pl-10 pr-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div class="relative">
        <button class="flex items-center px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100">
          <i class="fas fa-filter text-green-600 mr-2"></i><span>All Status</span>
          <i class="fas fa-chevron-down ml-2 text-gray-400"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Add Product Modal -->
  <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-xl shadow-lg w-[28rem] relative">
      <button onclick="closeProductModal()" class="absolute top-2 right-2 text-gray-500 text-xl font-bold">&times;</button>
      <h2 class="text-lg font-bold mb-4 text-center">➕ Add New Product</h2>
      <form id="addProductForm" method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="hidden" name="action" value="add">
        <div>
          <label class="block text-sm font-medium">Product Name</label>
          <input type="text" name="name" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div>
          <label class="block text-sm font-medium">Description</label>
          <textarea name="description" rows="3" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium">Price (₦)</label>
          <input type="number" name="price" step="0.01" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div>
          <label class="block text-sm font-medium">Category</label>
          <select name="category" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
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
          <input type="file" name="image" accept="image/*" class="w-full border px-3 py-2 rounded">
        </div>
        <div>
          <label class="inline-flex items-center">
            <input type="checkbox" name="special_offer" value="Yes" class="mr-2">
            <span class="text-sm font-medium">Mark as Special Offer</span>
          </label>
        </div>
        <button type="submit" class="w-full bg-green-700 text-white py-2 rounded hover:bg-green-800">Save Product</button>
      </form>
    </div>
  </div>

  <!-- Edit Product Modal -->
  <div id="editProductModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-xl shadow-lg w-[28rem] relative">
      <button onclick="closeEditProductModal()" class="absolute top-2 right-2 text-gray-500 text-xl font-bold">&times;</button>
      <h2 class="text-lg font-bold mb-4 text-center">✏️ Edit Product</h2>
      <form id="editProductForm" method="POST" enctype="multipart/form-data" class="space-y-4" action="edit_product.php">
        <input type="hidden" name="id" id="editProductId">
        <div>
          <label class="block text-sm font-medium">Product Name</label>
          <input type="text" name="name" id="editProductName" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div>
          <label class="block text-sm font-medium">Description</label>
          <textarea name="description" id="editProductDescription" rows="3" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium">Price (₦)</label>
          <input type="number" name="price" id="editProductPrice" step="0.01" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div>
          <label class="block text-sm font-medium">Category</label>
          <select name="category" id="editProductCategory" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
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
          <input type="file" name="image" accept="image/*" class="w-full border px-3 py-2 rounded">
        </div>
        <div>
          <label class="inline-flex items-center">
            <input type="checkbox" name="special_offer" id="editProductSpecialOffer" value="Yes" class="mr-2">
            <span class="text-sm font-medium">Mark as Special Offer</span>
          </label>
        </div>
        <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800">Update Product</button>
      </form>
    </div>
  </div>

  <!-- Product List -->
  <div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Products</h2>
    <table class="w-full border-collapse border">
      <thead>
        <tr class="bg-gray-100">
          <th class="border p-2">Image</th>
          <th class="border p-2">Name</th>
          <th class="border p-2">Price</th>
          <th class="border p-2">Category</th>
          <th class="border p-2">Status</th>
          <th class="border p-2">Created</th>
          <th class="border p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=$result->fetch_assoc()):
            $status = $row['status'] ?? 'Available';
            $badgeColor = $status==='Available'?'bg-green-500':'bg-red-500';
        ?>
        <tr>
          <td class="border p-2"><img src="<?= $row['image'] ?>" class="w-12 h-12 object-cover"></td>
          <td class="border p-2">
            <?= $row['name'] ?>
            <?php if(($row['special_offer'] ?? 'No') === 'Yes'): ?>
              <span class="ml-2 px-2 py-1 text-xs bg-yellow-500 text-white rounded">Special Offer</span>
            <?php endif; ?>
          </td>
          <td class="border p-2">₦<?= number_format($row['price']) ?> / KG</td>
          <td class="border p-2"><?= $row['category'] ?></td>
          <td class="border p-2"><span class="px-2 py-1 text-xs font-bold <?= $badgeColor ?> text-white rounded-full"><?= $status ?></span></td>
          <td class="border p-2"><?= $row['created_at'] ?></td>
          <td class="border p-2 flex justify-center gap-2">
            <button onclick="openEditProductModal(<?= $row['id'] ?>)" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"><i class="fas fa-edit"></i> Edit</button>
            
            <form action="delete_product.php" method="POST" onsubmit="return confirm('Are you sure?');">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"><i class="fas fa-trash"></i> Delete</button>
            </form>

            <button onclick="toggleStockStatus(<?= $row['id'] ?>, this)" 
                class="<?= $status==='Available'?'bg-yellow-600 hover:bg-yellow-700':'bg-green-600 hover:bg-green-700' ?> text-white px-3 py-1 rounded">
                <i class="fas fa-exclamation-triangle"></i> <?= $status==='Available'?'Out of Stock':'Available' ?>
            </button>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
const sidebar = document.getElementById('sidebar');
sidebar.addEventListener('mouseenter', ()=>{ sidebar.classList.remove('sidebar-collapsed'); sidebar.classList.add('w-56'); });
sidebar.addEventListener('mouseleave', ()=>{ sidebar.classList.add('sidebar-collapsed'); sidebar.classList.remove('w-56'); });

function toggleProductDropdown(){ document.getElementById('productDropdown').classList.toggle('hidden'); }
function toggleProfileDropdown(){ document.getElementById('profileDropdown').classList.toggle('hidden'); }
function openProductModal(){ document.getElementById('productModal').classList.remove('hidden'); }
function closeProductModal(){ document.getElementById('productModal').classList.add('hidden'); }
function openEditProductModal(id){
    fetch(`get_product.php?id=${id}`).then(res=>res.json()).then(data=>{
        document.getElementById('editProductId').value = data.id;
        document.getElementById('editProductName').value = data.name;
        document.getElementById('editProductDescription').value = data.description;
        document.getElementById('editProductPrice').value = data.price;
        document.getElementById('editProductCategory').value = data.category;
        document.getElementById('editProductSpecialOffer').checked = (data.special_offer === 'Yes');
        document.getElementById('editProductModal').classList.remove('hidden');
    });
}
function closeEditProductModal(){ document.getElementById('editProductModal').classList.add('hidden'); }

// AJAX Toggle Stock Status
function toggleStockStatus(id, btn){
    let formData = new FormData();
    formData.append('id', id);
    formData.append('action', 'toggle');

    fetch('out_of_stock.php',{method:'POST',body:formData})
    .then(res=>res.json()).then(data=>{
        if(data.success){
            let row = btn.closest('tr');
            let statusCell = row.querySelector('td:nth-child(5)');
            let newStatus = data.newStatus;
            statusCell.innerHTML = `<span class="px-2 py-1 text-xs font-bold ${newStatus==='Available'?'bg-green-500':'bg-red-500'} text-white rounded-full">${newStatus}</span>`;
            btn.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${newStatus==='Available'?'Out of Stock':'Available'}`;
            btn.className = newStatus==='Available'?'bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded':'bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded';
        } else { alert('Failed: '+data.error); }
    });
}
</script>

<style>
.sidebar { transition: width 0.3s ease; overflow: hidden; background-color: #28433D; }
.sidebar-collapsed { width: 4rem; }
.sidebar-expanded { width: 14rem; }
.sidebar-collapsed .sidebar-text { display: none; }
</style>

</body>
</html>
