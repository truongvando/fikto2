<?php
include 'db_connection.php';

$user_id = $_GET['user_id'];

$sql = "SELECT * FROM links WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $links = array();

    while ($row = $result->fetch_assoc()) {
        for ($i = 0; $i < $row['percentage']; $i++) {
            $links[] = $row['link'];
        }
    }

    $selected_link = $links[array_rand($links)];

    // Cập nhật số lượt truy cập
    $sql = "UPDATE links SET count = count + 1 WHERE link = '$selected_link'";
    $conn->query($sql);

    // Chuyển hướng đến liên kết được chọn
    header("Location: " . $selected_link);
    exit;
} else {
    echo "Không có liên kết nào cho tài khoản này.";
}

$conn->close();
?>
