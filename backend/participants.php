<?php
include 'config.php';
$orderId = intval($_GET['order_id']);

// For now, fake participants (replace with DB query)
$participants = [
  ["name" => "Chidi Nwafor", "shares" => 1, "amount" => 32400],
  ["name" => "Tolu Olalere", "shares" => 2, "amount" => 64800],
  ["name" => "Jeremiah Jacob", "shares" => 1, "amount" => 32400],
  ["name" => "Angel Hannah", "shares" => 1, "amount" => 32400],
];
?>

<h2 class="text-lg font-bold mb-4">Participants - Order #<?= str_pad($orderId, 6, '0', STR_PAD_LEFT) ?></h2>
<div class="space-y-4">
  <?php foreach($participants as $p): ?>
    <div class="flex justify-between border-b pb-2">
      <div>
        <p class="font-semibold"><?= $p['name'] ?></p>
        <p class="text-sm text-gray-500"><?= $p['shares'] ?> Share(s)</p>
      </div>
      <p class="font-bold">₦<?= number_format($p['amount'], 2) ?></p>
    </div>
  <?php endforeach; ?>
</div>
