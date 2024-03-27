<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa người dùng</title>
</head>
<body>
    <h2>Chỉnh sửa thông tin người dùng</h2>
    <?php
    session_start();

    // Thiết lập thông tin kết nối đến cơ sở dữ liệu MySQL
    $servername = "localhost";
    $username = "root"; // Thay your_username bằng tên người dùng của bạn
    $password = ""; // Thay your_password bằng mật khẩu của bạn
    $database = "QL_NhanSu";
    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $database);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }

    // Kiểm tra xem có ID người dùng được gửi từ trang danh sách người dùng không
    if (!isset($_GET['id'])) {
        // Nếu không, chuyển hướng về trang danh sách người dùng
        header("Location: user.php");
        exit;
    }

    // Lấy ID của người dùng cần chỉnh sửa
    $user_id = $_GET['id'];

    // Lấy thông tin người dùng từ cơ sở dữ liệu
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy người dùng";
        exit;
    }

    // Kiểm tra xem có dữ liệu được gửi từ form không
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ form
        $username = $_POST['username'];
        $password = $_POST['password'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // Cập nhật thông tin người dùng vào cơ sở dữ liệu
        $sql = "UPDATE users SET username='$username', password='$password', fullname='$fullname', email='$email', role='$role' WHERE id='$user_id'";

        if ($conn->query($sql) === TRUE) {
            // Nếu cập nhật thành công, chuyển hướng về trang danh sách người dùng
            header("Location: user.php");
            exit;
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>
    <form method="post">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" id="username" value="<?php echo $row['username']; ?>" required><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" value="<?php echo $row['password']; ?>" required><br><br>
        <label for="fullname">Họ và tên:</label>
        <input type="text" name="fullname" id="fullname" value="<?php echo $row['fullname']; ?>" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $row['email']; ?>" required><br><br>
        <label for="role">Vai trò:</label>
        <select name="role" id="role" required>
            <option value="user" <?php if ($row['role'] == 'user') echo 'selected'; ?>>User</option>
            <option value="admin" <?php if ($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
        </select><br><br>
        <input type="submit" value="Cập nhật">
    </form>
</body>
</html>
