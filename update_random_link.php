<?php
session_start();
include 'db_connection.php';
// Cập nhật liên kết ngẫu nhiên trong session
$_SESSION['random_link'] = $new_random_link;

if (!isset($_POST['new_random_link']) || empty($_POST['new_random_link'])) {
    echo 'error';
    exit();
}

$newRandomLink = $_POST['new_random_link'];
$userId = $_SESSION['user_id'];




$stmt = $conn->prepare('UPDATE user_random_links SET random_code = ? WHERE user_id = ?');
$stmt->bind_param('si', $newRandomLink, $userId);

if ($stmt->execute()) {
    echo 'success';
} else {
    echo 'error';
}

$stmt->close();
$conn->close();
?>
