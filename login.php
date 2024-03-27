<?php
session_start();

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


// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header("location: index.php"); // Chuyển hướng người dùng đã đăng nhập đến trang chính
    exit;
}

// Xử lý dữ liệu đăng nhập khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Chuẩn bị câu truy vấn SQL
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Người dùng tồn tại, kiểm tra mật khẩu
        // $user = $result->fetch_assoc();
        // if ($password === $user['password']) {
        //     // Mật khẩu đúng, đăng nhập thành công
        //     $_SESSION["loggedin"] = true;
        //     header("location: index.php");
        // } else {
        //     // Mật khẩu không đúng
        //     $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
        // }
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            // Mật khẩu đúng, đăng nhập thành công
            $_SESSION["loggedin"] = true;
            // Kiểm tra vai trò của người dùng
            if ($user['role'] === 'user') {
                header("location: indexuser.php"); // Chuyển hướng người dùng về trang indexuser.php nếu vai trò là "user"
                exit;
            } else {
                header("location: index.php"); // Chuyển hướng người dùng về trang index.php nếu vai trò không phải "user"
                exit;
            }
        } else {
            // Mật khẩu không đúng
            $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
        }
    } else {
        // Tên đăng nhập không tồn tại
        $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #666;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin-bottom: 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            color: #ff0000;
        }
    </style>
</head>

<body>
    <h2>Đăng nhập</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" id="username" required><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" required><br><br>
        <input type="submit" value="Đăng nhập">
    </form>
    <?php
    if (isset($error)) {
        echo "<p>$error</p>";
    }
    ?>
</body>

</html>