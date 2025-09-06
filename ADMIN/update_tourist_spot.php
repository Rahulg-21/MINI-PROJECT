<?php
include '../CONFIG/config.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = intval($_POST['id']);
    $district_id = intval($_POST['district_id']);
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);

    // Fetch current image
    $stmt = $conn->prepare("SELECT image FROM tourist_spots WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $oldImage = $stmt->get_result()->fetch_assoc()['image'];
    $stmt->close();

    // Handle new image if uploaded
    $newImage = $oldImage;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/tourist_spots/";
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        // Move uploaded file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $newImage = $fileName;

            // Optional: delete old image if exists
            if ($oldImage && file_exists($targetDir . $oldImage)) {
                unlink($targetDir . $oldImage);
            }
        }
    }

    // Update DB
    $stmt = $conn->prepare("UPDATE tourist_spots 
        SET district_id = ?, name = ?, description = ?, image = ? 
        WHERE id = ?");
    $stmt->bind_param("isssi", $district_id, $name, $description, $newImage, $id);

    if ($stmt->execute()) {
        header("Location: managespot.php?msg=updated");
        exit;
    } else {
        die("Error updating tourist spot: " . $stmt->error);
    }
}
?>
