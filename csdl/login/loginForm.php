<title>Đăng nhập</title>

<style>
    .form-style label {
        display: inline-block;
        width: 150px;
    }
    .form-style input {
        padding-top: 5px;
        margin-bottom: 10px;
    }
</style>

<form action="login.php" method="post" class="form-style">
    <fieldset>
        <legend>Đăng nhập:</legend>
        
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" id="username" value="" required><br>

        <label for="pass">Mật khẩu:</label>
        <input type="password" name="pass" id="pass" value="" required><br>

        <button type="submit" name="login">Đăng nhập</button>
    </fieldset>
    <br>
    <span>Bạn quên mật khẩu? <a href="forgot.php">Lấy lại mật khẩu</a></span><br>
    <span>Bạn chưa có tài khoản? <a href="../register/registerForm.php">Đăng ký</a></span>
</form>