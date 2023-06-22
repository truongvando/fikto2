<?php
session_start();
include 'db_connection.php';

$user_id = $_SESSION['user_id']; // Lấy user_id từ session

if ($user_id == 0) {
    // Nếu user_id là 0 (admin), lấy tất cả các liên kết
    $sql = "SELECT id, link, count, percentage, notes FROM links";
} else {
    // Nếu không phải admin, chỉ lấy liên kết của người dùng hiện tại
    $sql = "SELECT id, link, count, percentage, notes FROM links WHERE user_id = ?";
}


$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing select query: " . $conn->error);
}

if ($user_id != 0) {
    $stmt->bind_param('i', $user_id);
}

$success = $stmt->execute();
if (!$success) {
    die("Error fetching links: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td><input type='text' class='link-input' data-id='".$row["id"]."' value='".$row["link"]."'></td>
                <td>".$row["count"]."</td>
                <td>
                    <input type='text' class='percentage-input' step='0.01' min='0' max='100' data-id='".$row["id"]."' value='".$row["percentage"]."'/>
                </td>
                <td><input type='text' class='notes-input' data-id='".$row["id"]."' value='".$row["notes"]."'></td> <!-- Thêm dòng này -->
                <td>
                    <button class='delete-link' data-id='".$row["id"]."'>Delete</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>0 results</td></tr>";
}

$stmt->close();
$conn->close();
?>
