<?php
include 'config.php';

// Get payment ID
if (!isset($_GET['id'])) {
    die("No invoice selected.");
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM payments WHERE id = $id");

if (!$result || $result->num_rows === 0) {
    die("Invoice not found.");
}

$p = $result->fetch_assoc();

// Handle download as PDF
if (isset($_GET['download']) && $_GET['download'] == "1") {
    header("Content-type: application/vnd.ms-word");
    header("Content-Disposition: attachment;Filename=invoice-" . $p['id'] . ".doc");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice CMS-<?= str_pad($p['id'], 5, '0', STR_PAD_LEFT) ?></title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    .invoice-box {
      max-width: 800px; margin: auto; padding: 20px;
      border: 1px solid #eee; box-shadow: 0 0 10px rgba(0,0,0,0.15);
      font-size: 14px; line-height: 24px; color: #555;
    }
    .title { font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px; }
    table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
    table td { padding: 8px; vertical-align: top; }
    table th { padding: 8px; background: #f4f4f4; border-bottom: 1px solid #ddd; }
    .total { font-weight: bold; font-size: 16px; }
    .footer { margin-top: 20px; font-size: 12px; text-align: center; color: #777; }
    .btn-print { margin-top: 15px; display: inline-block; padding: 8px 12px; background: #007bff; color: #fff; text-decoration: none; border-radius: 4px; }
  </style>
</head>
<body>
  <div class="invoice-box">
    <div class="title">Invoice</div>

    <table>
      <tr>
        <td><strong>Invoice ID:</strong> CMS-<?= str_pad($p['id'], 5, '0', STR_PAD_LEFT) ?></td>
        <td><strong>Date:</strong> <?= date("F j, Y, g:i a", strtotime($p['created_at'])) ?></td>
      </tr>
      <tr>
        <td><strong>Customer:</strong> <?= htmlspecialchars($p['customer']) ?></td>
        <td><strong>Txn ID:</strong> <?= htmlspecialchars($p['txn_id']) ?></td>
      </tr>
      <tr>
        <td><strong>Order ID:</strong> <?= htmlspecialchars($p['order_id'] ?? '-') ?></td>
        <td><strong>Product:</strong> <?= htmlspecialchars($p['product'] ?? '-') ?></td>
      </tr>
    </table>

    <table style="margin-top: 20px; border: 1px solid #ddd;">
      <tr>
        <th>Method</th>
        <th>Status</th>
        <th>Amount</th>
      </tr>
      <tr>
        <td><?= htmlspecialchars($p['method']) ?></td>
        <td><?= htmlspecialchars($p['status']) ?></td>
        <td class="total">₦<?= number_format($p['amount'], 2) ?></td>
      </tr>
    </table>

    <div class="footer">
      <p>Thank you for your payment!<br>Comfy Market Shopper</p>
      <a href="javascript:window.print()" class="btn-print">🖨 Print</a>
      <a href="invoice.php?id=<?= $p['id'] ?>&download=1" class="btn-print" style="background: green;">⬇ Download</a>
    </div>
  </div>
</body>
</html>
