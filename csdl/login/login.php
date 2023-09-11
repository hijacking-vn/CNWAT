<?php
    // khai báo sử dụng session
    session_start();

    // xử lý đăng nhập
    if (isset($_POST["login"])){
        // Lấy username, password
        $username = addslashes($_POST["username"]);
        $pass = addslashes($_POST["pass"]);
        $pass = sha1($pass);
        
        // kết nối database
        include ("../connect.php");
        
        // kiểm tra có tồn tại username không
        $sql = "SELECT id FROM user WHERE username = '$username' AND password = '$pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result)){
            echo 'Username hoặc mật khẩu không đúng. <a href="javascript: history.go(-1)">Trở lại</a>';
            exit;
        }
        // Đóng kết nối
        $conn->close();

        // Lưu tên đăng nhập
        $_SESSION['username'] = $username;
        echo "<br>Xin chào, <b>".$username."</b>. Đăng nhập thành công";

    }
?>


