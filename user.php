<?php
session_start();

// // Kiểm tra xem người dùng đã đăng nhập chưa và vai trò của họ
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
//     // Nếu không phải admin hoặc chưa đăng nhập, chuyển hướng đến trang đăng nhập
//     header("Location: login.php");
//     exit; // Dừng việc thực hiện script
// }

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$database = "QL_NhanSu";

$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Lấy dữ liệu người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Danh sách người dùng</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Fullname</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["fullname"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["role"] . "</td>";
                echo "<td><a href='edituser.php?id=" . $row["id"] . "'>Edit</a> | <a href='deleteuser.php?id=" . $row["id"] . "'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có người dùng nào</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="adduser.php">Thêm Người Dùng Mới</a>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
