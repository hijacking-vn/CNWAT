<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Register</h2>
    <form method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username"><br>

        <label for="email">Email</label>
        <input type="email" name="email" id="email"><br>

        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone"><br>

        <label for="password">Password</label>
        <input type="password" name="password" id="password"><br>

        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm_password"><br>

        <input type="submit" value="Đăng ký" name="register"></input><br>
    </form>
    <span>Đã có tài khoản? <a href="./login.php">Đăng nhập</a></span><br>
</body>

</html>
<?php

// Xử lý đăng ký
if (isset($_POST["register"])) {

    // lấy dữ liệu do người dùng nhập
    $username = addslashes($_POST["username"]);
    $email = addslashes($_POST["email"]);
    $phone = addslashes($_POST["phone"]);
    $password = addslashes($_POST["password"]);
    $confirm_password = addslashes($_POST["confirm_password"]);

    // kiểm tra thông tin nhập hợp lệ?
    if (empty($username) || empty($email) || empty($phone) || 
        empty($password) || empty($confirm_password)) {
        echo '<span class="error">Trường dữ liệu không được để trống</span>';
        exit;
    }
    if (!isPhone($phone)){
        echo '<span class="error">Số điện thoại không đúng định dạng.</span>';
		exit;
    }
    if (!isEmail($email)){
        echo '<span class="error">Email không đúng định dạng.</span>';
		exit;
    }
    if (strlen($password) < 8){
        echo '<span class="error">Mật khẩu phải >= 8 ký tự.</span>';
        exit;
    }
	if (!isStrongPassword($password)) {
		echo '<span class="error">Mật khẩu chưa đủ mạnh.</span>';
		exit;
	}
    if ($password != $confirm_password){
        echo '<span class="error">Mật khẩu và mật khẩu nhập lại phải giống nhau.</span>';
		exit;
    }
    
    // Kết nối database, sử dụng PDO 
	try {
		$db_username = "root";
		$db_password = "";
		$conn = new PDO("mysql:host=localhost:3307;dbname=quanly_nv", $db_username, $db_password);
	
        // Kiểm tra email, phone có bị trùng trong database?
        $stmt = $conn->prepare("SELECT * FROM user WHERE EMAIL=:email OR PHONE=:phone");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount()!=0){
            echo '<span class="error">Email hoặc Phone đã có người sử dụng.</span>';
            exit;
        }

        // Lưu thông tin vào database
        $salt = bin2hex(random_bytes(16)); // Sinh chuỗi salt ngẫu nhiên, độ dài 16 byte (128bit)
        $password = sha1($password . $salt);
        
        $stmt = $conn->prepare("INSERT INTO user (USERNAME, PASS, EMAIL, PHONE, SALT) VALUES (:username, :password, :email, :phone, :salt)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':salt', $salt, PDO::PARAM_STR);
        $stmt->execute();
        
        // Thông báo thành công
        echo '<script>alert("Successful account registration!")</script>';
        header('location: login.php');
    }catch(PDOException $e){
		echo '<span class="error">Kết nối tới CSDL thất bại: ' . $e->getMessage().'.</span>';
	}finally{
        // Đóng kết nối CSDL
        $conn = null;
    }

    exit;
}

function isStrongPassword($passwd)
{
    // Kiểm tra xem mật khẩu chứa ít nhất hai nhóm ký tự

    // Nhóm 1: Chữ hoa và chữ thường
    $pattern1 = "/(?=.*[a-z])(?=.*[A-Z])/";

    // Nhóm 2: Chữ số
    $pattern2 = "/(?=.*\d)/";

    // Nhóm 3: Ký tự đặc biệt (ví dụ: !, @, #, $, %, ^, &)
    $pattern3 = "/(?=.*[!@#\$%^&*])/";

    // Kiểm tra mật khẩu
    if (
        preg_match($pattern1, $passwd)
        + preg_match($pattern2, $passwd)
        + preg_match($pattern3, $passwd) >= 2
    ) {
        return true; // Mật khẩu mạnh
    }
    return false; // Mật khẩu yếu
}
function isPhone($phone)
{
    return preg_match("/^\d{10}$/", $phone) === 1;
}
function isEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
?>