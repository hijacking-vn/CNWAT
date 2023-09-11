<?php
if (isset($_POST["register"])){
    // lấy dữ liệu vào
    // xử lý dữ liệu
    $username = trim($_POST["username"]);
    $pass = trim($_POST["pass"]);
    $repass = trim($_POST["repass"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);

    // kiểm tra username hoặc email có bị trùng hay không?
    include ("../connect.php");
    $sql = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result)> 0){
        echo '<script>
        alert("Bị trùng tên hoặc email!");
        window.location="../login/loginForm.php";
        </script>';
        die();
    }else{
        $pass = sha1($pass);
        $sql = "INSERT INTO `user` (`id`, `username`, `password`, `phone`, `email`) VALUES (NULL, '$username', '$pass', '$phone', '$email')";
        if (mysqli_query($conn, $sql)){
            echo '<script>
            alert("Đăng ký thành công!");
            window.location="../login/loginForm.php";
            </script>';
        }
    }

    $conn->close();
}   
?>

