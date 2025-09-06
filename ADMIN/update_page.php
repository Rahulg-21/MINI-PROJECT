<?php
include '../CONFIG/config.php';

// Enable error reporting for debugging 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = intval($_POST['id']);
    $category   = $_POST['category'];
    $title      = $_POST['title'];
    $description= $_POST['description'];

    // Handle image upload
    $image_sql = "";
    if (!empty($_FILES['image']['name'])) {
        $imageName  = time() . "_" . basename($_FILES['image']['name']);
        $targetPath = "uploads/pages/" . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image_sql = ", image='$imageName'";
        } else {
            die("Error uploading image.");
        }
    }

    $sql = "UPDATE pages SET 
                category='$category', 
                title='$title', 
                description='$description'
                $image_sql
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: managepage.php?success=1");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
