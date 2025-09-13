<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include '../CONFIG/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $guide_id = intval($_POST['guide_id']);
    $spot_id = intval($_POST['spot_id']);
    $date = $_POST['booking_date'];
    $time = $_POST['booking_time'];

    // Combine date & time into a single timestamp
    $booking_datetime = strtotime($date . ' ' . $time);
    $now = time();

    // ✅ Validation: Check if booking is in the future
    if ($booking_datetime < $now) {
        echo "<script>alert('❌ You cannot book a guide in the past. Please choose a valid date & time.'); window.history.back();</script>";
        exit();
    }

    // ✅ Optional: Limit bookings (e.g., only next 6 months)
    $six_months_later = strtotime("+6 months");
    if ($booking_datetime > $six_months_later) {
        echo "<script>alert('⚠️ You can only book guides within the next 6 months.'); window.history.back();</script>";
        exit();
    }

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO guide_bookings (user_id, guide_id, spot_id, booking_date, booking_time) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiss", $user_id, $guide_id, $spot_id, $date, $time);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Guide booked successfully!'); window.location='guide_details.php?id=$guide_id';</script>";
    } else {
        echo "<script>alert('❌ Something went wrong, try again.'); window.history.back();</script>";
    }
    $stmt->close();
}
?>
