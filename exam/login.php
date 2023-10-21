<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Login</title>

	<style>
		.error {
			color: red;
		}
	</style>
</head>

<body>
	<h2>LOGIN</h2>
	<form method="post">
		<label for="username">Username</label>
		<input type="text" name="username" id="username"><br>

		<label for="password">Password</label>
		<input type="password" name="password" id="password"><br>

		<input type="submit" value="Đăng nhập" name="login"></input><br>
	</form>
	<a href="./forgotPassword.php">Quên mật khẩu</a><br>
</body>

</html>

<?php
// khai báo sử dụng session
session_start();

// xử lý đăng nhập
if (isset($_POST["login"])) {
	// Lấy username, password
	$username = addslashes($_POST["username"]);
	$password = addslashes($_POST["password"]);

	// Kiểm tra dữ liệu
	if (empty($username) || empty($password)) {
		echo '<span class="error">Trường dữ liệu không được để trống</span>';
		exit;
	}
	if (strlen($password) < 8) {
		echo '<span class="error">Mật khẩu phải >= 8 ký tự.</span>';
		exit;
	}
	if (!isStrongPassword($password)) {
		echo '<span class="error">Mật khẩu chưa đủ mạnh.</span>';
		exit;
	}

	// Kết nối database, sử dụng PDO 
	try {
		$db_username = "root";
		$db_password = "";
		$conn = new PDO("mysql:host=localhost:3307;dbname=quanly_nv", $db_username, $db_password);
	
		// Thực hiện truy vấn SQL an toàn
		$stmt = $conn->prepare("SELECT * FROM user WHERE USERNAME = :username");
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		$row = $stmt->fetch();
		
		if ($stmt->rowCount() == 0){
			echo '<span class="error">Username hoặc Password không chính xác.</span>';
			exit;
		}
		
		// Tồn tại row trong database
		$hashed_password = $row["PASS"];
		$salt = $row["SALT"];
		$password = sha1($password . $salt); 
		
		if ($password != $hashed_password){
			// 2 password băm khác nhau
			echo '<span class="error">Username hoặc Password không chính xác.</span>';
			exit;
		}

		// Xác thực thành công, lưu trạng thái người dùng
		echo '<script>alert("Xin chào, '. htmlentities($username) .'!")</script>';
		$_SESSION['user_id'] = $row["ID"];
		$_SESSION['username'] = $username;

	}catch(PDOException $e){
		echo '<span class="error">Có lỗi CSDL: ' . $e->getMessage().'.</span>';
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
?>