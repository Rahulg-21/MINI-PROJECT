<?php
include '../CONFIG/config.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'] === 'Approved' ? 'Approved' : 'Pending';

    $stmt = $conn->prepare("UPDATE tourist_spots SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        header("Location: pending_spots.php?msg=status_updated");
        exit;
    } else {
        die("Error updating status: " . $stmt->error);
    }
} else {
    header("Location: managespot.php?msg=invalid");
    exit;
}
