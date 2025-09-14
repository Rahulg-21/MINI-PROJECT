<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include '../CONFIG/config.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $hotel_id = intval($_POST['hotel_id']);
    $room_id = intval($_POST['room_id']);
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $notes = isset($_POST['notes']) ? mysqli_real_escape_string($conn, $_POST['notes']) : '';

    // Check if room exists and has available rooms
    $stmt = $conn->prepare("SELECT available_rooms, room_type FROM hotel_rooms WHERE id = ? AND hotel_id = ?");
    $stmt->bind_param("ii", $room_id, $hotel_id);
    $stmt->execute();
    $room = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$room) {
        echo "<script>alert('Invalid room selection.'); window.history.back();</script>";
        exit();
    }

    if ($room['available_rooms'] <= 0) {
        echo "<script>alert('No rooms available for this type.'); window.history.back();</script>";
        exit();
    }

    // Insert booking
    $stmt = $conn->prepare("
        INSERT INTO hotel_bookings (user_id, hotel_id, room_id, booking_date, booking_time, notes, status)
        VALUES (?, ?, ?, ?, ?, ?, 'Pending')
    ");
    $stmt->bind_param("iiisss", $user_id, $hotel_id, $room_id, $booking_date, $booking_time, $notes);

    if ($stmt->execute()) {
        // Decrement available rooms
        $stmt_update = $conn->prepare("UPDATE hotel_rooms SET available_rooms = available_rooms - 1 WHERE id = ?");
        $stmt_update->bind_param("i", $room_id);
        $stmt_update->execute();
        $stmt_update->close();

        echo "<script>alert('Booking confirmed for {$room['room_type']}!'); window.location='hotel_details.php?id=$hotel_id';</script>";
    } else {
        echo "<script>alert('Booking failed. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    header("Location: index.php");
    exit();
}
?>
