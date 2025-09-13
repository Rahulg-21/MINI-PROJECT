<?php
include '../CONFIG/config.php';
session_start();

if (!isset($_SESSION['guide_id'])) {
    die("Unauthorized access.");
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];
    $allowed = ['Accepted', 'Rejected'];

    if (in_array($status, $allowed)) {
        $stmt = $conn->prepare("UPDATE guide_bookings SET status = ? WHERE id = ? AND guide_id = ?");
        $stmt->bind_param("sii", $status, $id, $_SESSION['guide_id']);
        $stmt->execute();
    }
}

header("Location: viewBooking.php");
exit;
