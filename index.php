<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php"); // Chuyển hướng người dùng chưa đăng nhập về trang đăng nhập
    exit;
}
// Thiết lập thông tin kết nối đến cơ sở dữ liệu MySQL
$servername = "localhost"; // Tên máy chủ MySQL
$username = "root"; // Tên người dùng MySQL
$password = ""; // Mật khẩu MySQL
$database = "QL_NhanSu"; // Tên cơ sở dữ liệu MySQL
// Kiểm tra xem người dùng đã đăng nhập chưa
// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}
// Xử lý đăng xuất nếu người dùng nhấp vào nút đăng xuất
if (isset($_POST["logout"])) {
    session_destroy(); // Hủy bỏ phiên đăng nhập
    header("location: login.php"); // Chuyển hướng người dùng về trang đăng nhập sau khi đăng xuất
    exit;
}


// Xác định trang hiện tại
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 5;
$start_from = ($current_page - 1) * $records_per_page;

// Truy vấn dữ liệu từ bảng NHANVIEN với phân trang
$sql = "SELECT * FROM NHANVIEN LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng thông tin nhân viên</title>
    <!-- Nút đăng xuất -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="submit" value="Đăng xuất" name="logout" class="logout-button">
    </form>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
        }

        h2 {
            color: #006633;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #006633;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e6e6e6;
        }

        a {
            color: #006633;
            text-decoration: none;
        }

        a:hover {
            color: #003300;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="submit"] {
            background-color: #006633;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #003300;
        }

        .logout-button {
            float: right;
            background-color: #006633;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #003300;
        }
        .btn-add-nhanvien {
            float: left;
        }
        .btn-add-phongban {
            float: left;
        }
    </style>
</head>

<body>
    <h2>Bảng thông tin nhân viên</h2>
    </form>
    <!-- Form thêm nhân viên -->
    <form action="addNhanVien.php" method="post">
        <!-- Các trường nhập thông tin nhân viên -->
        <input class="btn-add-nhanvien" type="submit" value="Thêm Nhân Viên">
    </form>
    <!-- Form thêm phòng ban -->
    <form action="addPhongBan.php" method="post">
        <!-- Các trường nhập thông tinphòng ban -->
        <input class="btn-add-phongban" type="submit" value="Thêm Phòng Ban">
    </form>

    <table>
        <tr>
            <th>Mã NV</th>
            <th>Tên NV</th>
            <th>Phái</th>
            <th>Nơi Sinh</th>
            <th>Mã Phòng</th>
            <th>Lương</th>
            <th>Thao tác</th> <!-- Cột mới cho các liên kết Xóa và Sửa -->
        </tr>
        <?php
        // Hiển thị dữ liệu từ bảng NHANVIEN
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Ma_NV"] . "</td>";
                echo "<td>" . $row["Ten_NV"] . "</td>";
                echo "<td>";
                // Kiểm tra giới tính và chèn hình ảnh tương ứng
                if ($row["Phai"] === "NU") {
                    echo '<img src="image/woman.jpg" alt="Nữ" width="50" height="50">';
                } else {
                    echo '<img src="image/man.jpg" alt="Nam" width="50" height="50">';
                }
                echo "</td>";
                echo "<td>" . $row["Noi_Sinh"] . "</td>";
                echo "<td>" . $row["Ma_Phong"] . "</td>";
                echo "<td>" . $row["Luong"] . "</td>";
                echo "<td>";
                // Liên kết Sửa
                echo "<a href='editNhanVien.php?id=" . $row["Ma_NV"] . "'>Sửa</a> | ";
                // Liên kết Xóa
                echo "<a href='deleteNhanVien.php?id=" . $row["Ma_NV"] . "'>Xóa</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
        }
        ?>
    </table>
    <br>
    <!-- Hiển thị phân trang -->
    <?php
    $sql = "SELECT COUNT(*) AS total_records FROM NHANVIEN";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_records = $row['total_records'];
    $total_pages = ceil($total_records / $records_per_page);

    echo "<div style='text-align: center;'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='?page=" . $i . "'>" . $i . "</a> ";
    }
    echo "</div>";
    ?>
</body>

</html>

<?php
// Đóng kết nối
$conn->close();
?>