<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa nhân viên</title>
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
        input[type="radio"] {
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
    <h2>Chỉnh sửa thông tin nhân viên</h2>


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
        // Lấy thông tin nhân viên từ cơ sở dữ liệu để hiển thị trong biểu mẫu chỉnh sửa
        $sql = "SELECT * FROM NHANVIEN WHERE Ma_NV='$userId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Hiển thị biểu mẫu chỉnh sửa thông tin nhân viên
            // Ở đây bạn có thể sử dụng các trường thông tin của $row để điền vào các trường nhập của biểu mẫu
    ?>
    <!-- Form chỉnh sửa thông tin nhân viên -->
    <form action="updateNhanVien.php?id=<?php echo $userId; ?>" method="post">
        <!-- Các trường nhập thông tin nhân viên -->
        <label for="Ten_NV">Tên nhân viên:</label><br>
        <input type="text" id="Ten_NV" name="Ten_NV" value="<?php echo $row['Ten_NV']; ?>"><br>
        <label for="Phai">Phái:</label><br>
        <input class="radio" type="radio" id="Nam" name="Phai" value="Nam" <?php if ($row['Phai'] === 'Nam') echo 'checked'; ?>>
        <label for="Nam">Nam</label>
        <input class="radio" type="radio" id="Nu" name="Phai" value="Nu" <?php if ($row['Phai'] === 'Nu') echo 'checked'; ?>>
        <label for="Nu">Nữ</label><br>
        <label for="Noi_Sinh">Nơi sinh:</label><br>
        <input type="text" id="Noi_Sinh" name="Noi_Sinh" value="<?php echo $row['Noi_Sinh']; ?>"><br>
        <label for="Ma_Phong">Mã phòng:</label><br>
        <input type="text" id="Ma_Phong" name="Ma_Phong" value="<?php echo $row['Ma_Phong']; ?>"><br>
        <label for="Luong">Lương:</label><br>
        <input type="text" id="Luong" name="Luong" value="<?php echo $row['Luong']; ?>"><br>
        <input type="submit" value="Cập nhật">
    </form>
    <?php
        } else {
            echo "Không tìm thấy nhân viên.";
        }
    }

    $conn->close();
    ?>
</body>
</html>
