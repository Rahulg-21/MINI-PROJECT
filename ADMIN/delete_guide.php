<?php
include '../CONFIG/config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Delete guide
    $stmt = $conn->prepare("DELETE FROM guides WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: manageGuide.php");
exit;
