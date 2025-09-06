<?php
include '../CONFIG/config.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch image before deleting
    $stmt = $conn->prepare("SELECT image FROM tourist_spots WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row) {
        $image = $row['image'];

        // Delete DB record
        $stmt = $conn->prepare("DELETE FROM tourist_spots WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Delete image file if exists
            $filePath = "uploads/tourist_spots/" . $image;
            if ($image && file_exists($filePath)) {
                unlink($filePath);
            }

            header("Location: managespot.php?msg=deleted");
            exit;
        } else {
            die("Error deleting record: " . $stmt->error);
        }
    } else {
        die("Tourist spot not found.");
    }
}
?>
