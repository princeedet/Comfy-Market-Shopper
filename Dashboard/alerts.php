<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Alerts</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a2e0e6ad65.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

  <!-- Success Modal -->
  <?php if (isset($_GET['status']) && $_GET['status'] === 'updated'): ?>
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full text-center">
      <div class="text-green-600 mb-4">
        <i class="fas fa-check-circle text-4xl"></i>
      </div>
      <h2 class="text-lg font-bold mb-2">Product Updated Successfully!</h2>
      <p class="text-sm text-gray-600 mb-4">Product order has been created and will be updated on the available channels.</p>
      <a href="order.php" class="px-6 py-2 border border-green-600 text-green-700 rounded hover:bg-green-50">Back to products</a>
    </div>
  <?php elseif (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full text-center">
      <div class="text-green-600 mb-4">
        <i class="fas fa-trash text-4xl"></i>
      </div>
      <h2 class="text-lg font-bold mb-2">Product Deleted Successfully!</h2>
      <p class="text-sm text-gray-600 mb-4">Product order has been deleted and will be removed from the available channels.</p>
      <a href="order.php" class="px-6 py-2 border border-green-600 text-green-700 rounded hover:bg-green-50">Back to products</a>
    </div>
  <?php endif; ?>

</body>
</html>
