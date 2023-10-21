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
    <title>Upload File</title>

    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Upload File</h2>
    <form method="post" enctype="multipart/form-data">
        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <label for="file">Chọn tệp:</label>
        <input type="file" name="file" id="file"><br>

        <input type="submit" value="Tải lên" name="upload_file"></input>
    </form>
</body>

</html>

<?php
// Xử lý upload file
if (isset($_POST["upload_file"])) {
    // Kiểm tra CSRF token
    if (empty($_POST['csrf_token']) || $csrf_token != $_POST['csrf_token']) {
        echo '<span class="error">Lỗi CSRF token!.</span>';
        exit;
    }

    // kiểm tra có tệp được chọn không
    if (!isset($_FILES["file"]) || empty($_FILES["file"]["name"])){
        echo '<span class="error">Vui lòng chọn tệp để tải lên.</span>';
        exit;
    }

    // lấy tên file
    $filename = addslashes($_FILES["file"]["name"]);
    if ($_FILES["file"]["size"] > 1000000) {
        echo '<span class="error">Tệp quá lớn. Vui lòng tải lên tệp nhỏ hơn.</span>';
        exit;
    }
    // Cho phép tải lên các loại tệp hình ảnh
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedTypes)){
        echo '<span class="error">Chỉ được tải lên tệp hình ảnh.</span>';
        exit;
    }
    
    // Upload file
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 777, true);
    }
    $targetFile = $uploadDir . basename($_FILES["file"]["name"]);

    if (file_exists($targetFile)) {
        echo '<span class="error">Tệp đã tồn tại.</span>';
        exit;
    }

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        echo '<script>alert("Tệp ' . htmlentities($filename) . ' đã được tải lên thành công.")</script>';
    } else {
        echo '<span class="error">Có lỗi xảy ra khi tải lên tệp.</span>';
    }
    exit;
}

?>