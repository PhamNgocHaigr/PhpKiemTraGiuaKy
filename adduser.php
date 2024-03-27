<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tài Khoản</title>
</head>
<body>
    <h2>Thêm Tài Khoản Người Dùng</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" id="username" required><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" required><br><br>
        <label for="fullname">Họ và Tên:</label>
        <input type="text" name="fullname" id="fullname" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>
        <label for="role">Vai trò:</label>
        <select name="role" id="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>
        <input type="submit" value="Thêm Tài Khoản">
    </form>
    <?php
// Xử lý khi form thêm tài khoản được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    // Kiểm tra xem các trường cần thiết đã được điền đầy đủ
    if ($username && $password && $fullname && $email && $role) {
        // Hash mật khẩu trước khi lưu vào cơ sở dữ liệu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Thiết lập thông tin kết nối đến cơ sở dữ liệu MySQL
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $database = "QL_NhanSu";

        // Tạo kết nối
        $conn = new mysqli($servername, $db_username, $db_password, $database);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối không thành công: " . $conn->connect_error);
        }

        // Thực hiện truy vấn để thêm tài khoản mới vào cơ sở dữ liệu
        $sql = "INSERT INTO users (username, password, fullname, email, role) VALUES ('$username', '$hashed_password', '$fullname', '$email', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "Tài khoản đã được thêm thành công.";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }

        // Đóng kết nối
        $conn->close();
    } else {
        echo "Vui lòng điền đầy đủ thông tin vào các trường.";
    }
}
?>

</body>
</html>
