<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

// Tạo hoặc lấy CSRF token từ phiên
if (isset($_SESSION['csrf_token'])) {
    $csrf_token = $_SESSION['csrf_token'];
} else {
    $csrf_token = bin2hex(random_bytes(32)); // Sinh CSRF token
    $_SESSION['csrf_token'] = $csrf_token;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>

    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Change Password</h2>
    <form method="post">
        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <label for="old_password">Old password</label>
        <input type="password" name="old_password" id="old_password"><br>

        <label for="new_password">New password:</label>
        <input type="password" name="new_password" id="new_password"><br>

        <label for="confirm_new_password">Confirm new password:</label>
        <input type="password" name="confirm_new_password" id="confirm_new_password"><br>

        <input type="submit" value="Change" name="change_password"></input>
    </form> 
</body>
</html>

<?php
// Xử lý thay đổi mật khẩu
if (isset($_POST["change_password"])){
    // Kiểm tra CSRF token
    if (empty($_POST['csrf_token']) || $csrf_token != $_POST['csrf_token']){
        echo '<span class="error">Lỗi CSRF token!.</span>';
		exit;
    }

    // lấy dữ liệu do người dùng nhập
    $old_password = addslashes($_POST["old_password"]);
    $new_password = addslashes($_POST["new_password"]);
    $confirm_new_password = addslashes($_POST["confirm_new_password"]);

    // kiểm tra thông tin nhập hợp lệ?
    if (empty($old_password) || empty($new_password) || empty($confirm_new_password)) {
        echo '<span class="error">Trường dữ liệu không được để trống</span>';
        exit;
    }
    if ($old_password == $new_password){
        echo '<span class="error">Mật khẩu và mật khẩu mới phải khác nhau.</span>';
		exit;
    }
    if (strlen($new_password) < 8){
        echo '<span class="error">Mật khẩu mới phải >= 8 ký tự.</span>';
        exit;
    }
    if (!isStrongPassword($new_password)) {
        echo '<span class="error">Mật khẩu chưa đủ mạnh.</span>';
        exit;
    }
    if ($new_password != $confirm_new_password){
        echo '<span class="error">Mật khẩu và mật khẩu nhập lại phải giống nhau.</span>';
		exit;
    }

    // Kết nối database, sử dụng PDO 
	try {
		$db_username = "root";
		$db_password = "";
		$conn = new PDO("mysql:host=localhost:3307;dbname=quanly_nv", $db_username, $db_password);
	
        // Kiểm tra mật khẩu hiện tại của người dùng
        $stmt = $conn->prepare("SELECT * FROM user WHERE USERNAME = :username");
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();
        $row = $stmt->fetch();

        $hashed_password = $row["PASS"];
        $salt = $row["SALT"];
        $old_password = sha1($old_password . $salt); 
        
        if ($old_password != $hashed_password){
            // 2 password băm khác nhau
            echo '<span class="error">Mật khẩu cũ không chính xác.</span>';
            exit;
        }

        // Thay đổi thành mật khẩu mới
        $new_password = sha1($new_password . $salt);
        $stmt = $conn->prepare("UPDATE user SET PASS = :password WHERE USERNAME = :username");
        $stmt->bindParam(':password', $new_password);
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();

         // Thông báo thành công
        echo '<script>alert("Successful change password!")</script>';
    } catch (PDOException $e) {
        echo '<span class="error">Có lỗi CSDL: ' . $e->getMessage() . '.</span>';
    } finally {
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
