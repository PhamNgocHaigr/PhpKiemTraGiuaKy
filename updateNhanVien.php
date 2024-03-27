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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];
        $Ten_NV = $_POST['Ten_NV'];
        $Phai = $_POST['Phai'];
        $Noi_Sinh = $_POST['Noi_Sinh'];
        $Ma_Phong = $_POST['Ma_Phong'];
        $Luong = $_POST['Luong'];

        // Cập nhật thông tin nhân viên vào cơ sở dữ liệu
        $sql = "UPDATE NHANVIEN SET Ten_NV='$Ten_NV', Phai='$Phai', Noi_Sinh='$Noi_Sinh', Ma_Phong='$Ma_Phong', Luong='$Luong' WHERE Ma_NV='$userId'";
        if ($conn->query($sql) === TRUE) {
            echo "Cập nhật thông tin nhân viên thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
header("Location: index.php"); // Chuyển hướng về trang index
exit;
?>
