<?php
session_start();

// Thiết lập thông tin kết nối đến cơ sở dữ liệu MySQL
$servername = "localhost";
$username = "root";
$password = "";
$database = "QL_NhanSu";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Kiểm tra xem có ID người dùng được gửi từ trang danh sách người dùng không
if (isset($_GET['id'])) {
    // Lấy ID của người dùng cần xóa
    $userId = $_GET['id'];

    // Xóa người dùng từ cơ sở dữ liệu
    $sql = "DELETE FROM users WHERE id='$userId'";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa người dùng thành công. ";
        echo "<a href='user.php'>Quay về trang người dùng</a>";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>
