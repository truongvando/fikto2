<?php
// Kết nối đến cơ sở dữ liệu (thay đổi thông tin kết nối nếu cần)
$servername = "localhost";
$username = "ngoncc_daongon";
$password = "Qwer7896!";
$dbname = "ngoncc_daongon";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE links SET count = 1";
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error";
}

$conn->close();
?>
