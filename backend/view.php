<?php
include 'config.php';

if (!isset($_GET['id'])) {
    echo "<p class='text-red-600'>No payment selected.</p>";
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM payments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='text-red-600'>Payment not found.</p>";
    exit;
}

$p = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Details</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

  <div class="bg-white w-full max-w-2xl rounded-2xl shadow-lg p-6">
    <!-- Back Button -->
    <a href="payment.php" 
       class="inline-flex items-center text-blue-600 hover:underline mb-6">
      ← Back to Payments
    </a>

    <!-- Title -->
    <h2 class="text-lg font-semibold text-gray-700 mb-6">Payment Details</h2>

    <!-- Grid Layout -->
    <div class="grid grid-cols-2 gap-6 text-sm">
      <div>
        <p class="text-gray-500">User</p>
        <p class="font-semibold"><?= htmlspecialchars($p['customer']) ?></p>
      </div>
      <div>
        <p class="text-gray-500">Order ID</p>
        <p class="font-semibold">CMS-<?= str_pad($p['order_id'], 5, '0', STR_PAD_LEFT) ?></p>
      </div>
      <div>
        <p class="text-gray-500">Amount</p>
        <p class="font-semibold">₦<?= number_format($p['amount'], 2) ?></p>
      </div>
      <div>
        <p class="text-gray-500">Payment Method</p>
        <p class="flex items-center gap-2 font-semibold text-green-700">
          <i class="fas fa-credit-card"></i> <?= htmlspecialchars($p['method']) ?>
        </p>
      </div>
      <div>
        <p class="text-gray-500">Transaction ID</p>
        <p class="font-semibold"><?= htmlspecialchars($p['txn_id'] ?? '-') ?></p>
      </div>
      <div>
        <p class="text-gray-500">Payment Status</p>
        <?php if ($p['status'] === 'Successful'): ?>
          <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">Successful</span>
        <?php elseif ($p['status'] === 'Pending'): ?>
          <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Pending</span>
        <?php else: ?>
          <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">Failed</span>
        <?php endif; ?>
      </div>
    </div>

    <!-- Date -->
    <div class="mt-6">
      <p class="text-gray-500">Date</p>
      <p class="font-semibold"><?= date("F j, Y, g:i a", strtotime($p['created_at'])) ?></p>
    </div>

    <!-- Invoice Button -->
    <div class="mt-8 flex justify-center">
      <a href="download_invoice.php?id=<?= $p['id'] ?>" 
         class="flex items-center gap-2 px-6 py-3 border border-green-600 text-green-700 rounded-xl hover:bg-green-600 hover:text-white transition">
        <i class="fas fa-download"></i> Download Invoice
      </a>
    </div>
  </div>

</body>
</html>
