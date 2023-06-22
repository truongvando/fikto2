<?php
session_start();
include 'db_connection.php';

$id = $_POST['id'];
$link = $_POST['link'];
$notes = $_POST['notes']; // Thêm dòng này

$sql = "UPDATE links SET link = ?, notes = ? WHERE id = ?"; // Cập nhật câu lệnh SQL này
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing update query: " . $conn->error);
}

$stmt->bind_param('ssi', $link, $notes, $id); // Cập nhật dòng này
$success = $stmt->execute();
if ($success) {
    echo "success";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
