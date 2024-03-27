<!-- addNhanVien.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân Viên</title>
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

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #006633;
            font-weight: bold;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #003300;
        }

        p {
            text-align: center;
            color: #006633;
            font-weight: bold;
        }
    </style><style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
        }

        h2 {
            color: #006633;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #006633;
            font-weight: bold;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #003300;
        }

        p {
            text-align: center;
            color: #006633;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Thêm Nhân Viên Mới</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="maNV">Mã NV:</label>
        <input type="text" name="maNV" id="maNV" required><br><br>
        <label for="tenNV">Tên NV:</label>
        <input type="text" name="tenNV" id="tenNV" required><br><br>
        <label for="phai">Phái:</label>
        <select name="phai" id="phai" required>
            <option value="NU">Nữ</option>
            <option value="NAM">Nam</option>
        </select><br><br>
        <label for="noiSinh">Nơi Sinh:</label>
        <input type="text" name="noiSinh" id="noiSinh"><br><br>
        <label for="maPhong">Mã Phòng:</label>
        <input type="text" name="maPhong" id="maPhong" required><br><br>
        <label for="luong">Lương:</label>
        <input type="text" name="luong" id="luong" required><br><br>
        <input type="submit" value="Thêm Nhân Viên">
    </form>

    <?php
    // Thiết lập thông tin kết nối đến cơ sở dữ liệu MySQL
    $servername = "localhost"; // Tên máy chủ MySQL
    $username = "root"; // Tên người dùng MySQL
    $password = ""; // Mật khẩu MySQL
    $database = "QL_NhanSu"; // Tên cơ sở dữ liệu MySQL

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $database);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }

     // Xử lý thêm nhân viên
    // Xử lý thêm nhân viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['maNV']) && isset($_POST['tenNV']) && isset($_POST['phai']) && isset($_POST['maPhong']) && isset($_POST['luong'])) {
        $maNV = $_POST['maNV'];
        $tenNV = $_POST['tenNV'];
        $phai = $_POST['phai'];
        $noiSinh = isset($_POST['noiSinh']) ? $_POST['noiSinh'] : '';
        $maPhong = $_POST['maPhong'];
        $luong = $_POST['luong'];

        $sql = "INSERT INTO NHANVIEN (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) 
                VALUES ('$maNV', '$tenNV', '$phai', '$noiSinh', '$maPhong', '$luong')";

if ($conn->query($sql) === TRUE) {
    echo "<p>Thêm nhân viên thành công</p>";
    // Chuyển hướng người dùng về trang index.php sau khi thêm thành công
    header("Location: index.php");
    exit();
} else {
    echo "<p>Lỗi: " . $sql . "<br>" . $conn->error . "</p>";
}
} else {
echo "<p>Vui lòng điền đầy đủ thông tin nhân viên</p>";
}   
}


    // Đóng kết nối
    $conn->close();
    ?>
</body>
</html>
