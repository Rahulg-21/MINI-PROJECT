<?php
include '../config.php'; // Your DB connection file

// Enable error reporting for debugging 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch image path before delete
    $imgResult = $conn->query("SELECT image FROM pages WHERE id=$id");
    if ($imgResult->num_rows > 0) {
        $row = $imgResult->fetch_assoc();
        $imgPath = "uploads/pages/" . $row['image'];
        
        // Delete from DB
        if ($conn->query("DELETE FROM pages WHERE id=$id") === TRUE) {
            // Delete image file
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
            header("Location: managepage.php?deleted=1");
            exit;
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}
?>
