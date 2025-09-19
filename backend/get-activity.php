<?php
include 'config.php';

$activities = [];

// ================= Products Activity =================
$productQuery = $conn->query("
    SELECT id, name, created_at, updated_at, deleted_at, stock_status 
    FROM products
    ORDER BY GREATEST(
        IFNULL(created_at,'1970-01-01'), 
        IFNULL(updated_at,'1970-01-01'), 
        IFNULL(deleted_at,'1970-01-01')
    ) DESC
    LIMIT 10
");

while ($row = $productQuery->fetch_assoc()) {
    if (!empty($row['deleted_at'])) {
        $activities[] = [
            'type' => 'product_deleted',
            'message' => "Product deleted: <strong>{$row['name']}</strong>",
            'time' => $row['deleted_at']
        ];
    } elseif (!empty($row['updated_at'])) {
        $activities[] = [
            'type' => 'product_edited',
            'message' => "Product edited: <strong>{$row['name']}</strong>",
            'time' => $row['updated_at']
        ];
    } elseif ($row['stock_status'] === 'out_of_stock') {
        $activities[] = [
            'type' => 'product_out',
            'message' => "Product out of stock: <strong>{$row['name']}</strong>",
            'time' => $row['updated_at'] ?? $row['created_at']
        ];
    } else {
        $activities[] = [
            'type' => 'product',
            'message' => "New product added: <strong>{$row['name']}</strong>",
            'time' => $row['created_at']
        ];
    }
}

// ================= Users Activity =================
$userQuery = $conn->query("
    SELECT id, username, created_at, updated_at, deleted_at, status
    FROM users
    ORDER BY GREATEST(
        IFNULL(created_at,'1970-01-01'),
        IFNULL(updated_at,'1970-01-01'),
        IFNULL(deleted_at,'1970-01-01')
    ) DESC
    LIMIT 10
");

while ($row = $userQuery->fetch_assoc()) {
    if (!empty($row['deleted_at'])) {
        $activities[] = [
            'type' => 'user_deleted',
            'message' => "User deleted: <strong>{$row['username']}</strong>",
            'time' => $row['deleted_at']
        ];
    } elseif ($row['status'] === 'suspended') {
        $activities[] = [
            'type' => 'user_suspended',
            'message' => "User suspended: <strong>{$row['username']}</strong>",
            'time' => $row['updated_at']
        ];
    } elseif ($row['status'] === 'disabled') {
        $activities[] = [
            'type' => 'user_disabled',
            'message' => "User disabled: <strong>{$row['username']}</strong>",
            'time' => $row['updated_at']
        ];
    } elseif ($row['status'] === 'enabled') {
        $activities[] = [
            'type' => 'user_enabled',
            'message' => "User enabled: <strong>{$row['username']}</strong>",
            'time' => $row['updated_at']
        ];
    } else {
        $activities[] = [
            'type' => 'user',
            'message' => "New user registered: <strong>{$row['username']}</strong>",
            'time' => $row['created_at']
        ];
    }
}

// ================= Orders Activity =================
$orderQuery = $conn->query("
    SELECT o.id, p.name AS product_name, o.status, o.created_at
    FROM orders o
    LEFT JOIN products p ON o.product_id = p.id
    ORDER BY o.created_at DESC
    LIMIT 10
");

while ($row = $orderQuery->fetch_assoc()) {
    $activities[] = [
        'type' => 'order',
        'message' => "New order (#{$row['id']}) for <strong>{$row['product_name']}</strong> - Status: {$row['status']}",
        'time' => $row['created_at']
    ];
}

// ================= Sort and Limit =================
usort($activities, function($a, $b) {
    return strtotime($b['time']) - strtotime($a['time']);
});

$activities = array_slice($activities, 0, 10);

// ================= Render Activities =================
foreach ($activities as $act) {
    switch ($act['type']) {
        case 'product': $icon = 'fa-box text-green-600'; break;
        case 'product_edited': $icon = 'fa-edit text-yellow-600'; break;
        case 'product_deleted': $icon = 'fa-trash text-red-600'; break;
        case 'product_out': $icon = 'fa-box-open text-gray-600'; break;
        case 'user': $icon = 'fa-user text-blue-600'; break;
        case 'user_enabled': $icon = 'fa-user-check text-green-600'; break;
        case 'user_disabled': $icon = 'fa-user-slash text-yellow-600'; break;
        case 'user_suspended': $icon = 'fa-user-clock text-red-600'; break;
        case 'user_deleted': $icon = 'fa-user-times text-red-700'; break;
        case 'order': $icon = 'fa-shopping-cart text-purple-600'; break;
        default: $icon = 'fa-info-circle text-gray-500';
    }

    echo "<li class='flex items-start gap-2 mb-2'>
            <i class='fas {$icon} mt-1'></i>
            <span>{$act['message']} <span class='text-gray-400 text-xs'>(" . date('M d, H:i', strtotime($act['time'])) . ")</span></span>
          </li>";
}
?>
