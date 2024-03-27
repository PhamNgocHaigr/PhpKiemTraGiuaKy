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

/// Xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maPhong = $_POST['Ma_Phong'];
    $tenPhong = $_POST['Ten_Phong'];

    // Kiểm tra xem mã phòng đã tồn tại trong cơ sở dữ liệu chưa
    $sql_check = "SELECT * FROM PHONGBAN WHERE Ma_Phong = '$maPhong'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "";
    } else {
        // Thực hiện truy vấn SQL để thêm phòng ban vào cơ sở dữ liệu
        $sql = "INSERT INTO PHONGBAN (Ma_Phong, Ten_Phong) VALUES ('$maPhong', '$tenPhong')";

        if ($conn->query($sql) === TRUE) {
            echo "Thêm phòng ban thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Đóng kết nối
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Phòng Ban</title>
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

        input[type="text"] {
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
    </style>
</head>
<body>
    <h2>Thêm Phòng Ban Mới</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="Ma_Phong">Mã Phòng:</label>
        <input type="text" name="Ma_Phong" id="Ma_Phong" required><br><br>
        <label for="Ten_Phong">Tên Phòng:</label>
        <input type="text" name="Ten_Phong" id="Ten_Phong" required><br><br>
        <input type="submit" value="Thêm Phòng Ban">
    </form>

</body>
</html>
