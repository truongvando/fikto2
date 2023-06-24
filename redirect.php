<?php
session_start();
include 'db_connection.php';

$id = $_GET['id'];

$sql = "SELECT * FROM links WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing select query: " . $conn->error);
}

$stmt->bind_param('i', $id);
$success = $stmt->execute();
if (!$success) {
    die("Error fetching link: " . $stmt->error);
}

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $link = $row['link'];
    $count = $row['count'] + 1;
    $new_total_visits = $row['total_visits'] + 1; // Tăng số lượt truy cập tổng cộng

    $sql = "UPDATE links SET count = ?, total_visits = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing update query: " . $conn->error);
    }

    $stmt->bind_param('iii', $count, $new_total_visits, $id);
    $success = $stmt->execute();
    if (!$success) {
        die("Error updating count: " . $stmt->error);
    }

    header("Location: " . $link);
} else {
    echo "Link not found";
}

$stmt->close();
$conn->close();
?>
