<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "QL_NhanSu";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    // Xóa nhân viên từ cơ sở dữ liệu
    $sql = "DELETE FROM NHANVIEN WHERE Ma_NV='$userId'";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa nhân viên thành công";
        echo "<a href='index.php'>Quay về trang người dùng</a>";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
