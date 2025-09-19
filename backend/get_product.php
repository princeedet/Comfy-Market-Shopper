<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    // Ensure status & special_offer always exist
    if (!isset($result['status'])) {
        $result['status'] = 'Available';
    }
    if (!isset($result['special_offer'])) {
        $result['special_offer'] = 'No';
    }

    echo json_encode($result);
}
?>
