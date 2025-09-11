<?php
include '../CONFIG/config.php';

$district_id = intval($_GET['district_id']);
$result = mysqli_query($conn, "SELECT id, name FROM tourist_spots WHERE district_id=$district_id AND status='Approved' ORDER BY name ASC");

$spots = [];
while ($row = mysqli_fetch_assoc($result)) {
    $spots[] = $row;
}

echo json_encode($spots);
?>
