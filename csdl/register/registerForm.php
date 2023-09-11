<title>Đăng ký</title>
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
<!--  -->
<form action="register.php" method="post" class="form-style">
    <fieldset>
        <legend>Đăng ký thành viên:</legend>
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" id="username" value="" required><br>

        <label for="pass">Mật khẩu:</label>
        <input type="password" name="pass" id="pass" value="" required><br>

        <label for="repass">Nhập lại mật khẩu:</label>
        <input type="password" name="repass" id="repass" value="" required><br>

        <label for="phone">Số điện thoại:</label>
        <input type="text" name="phone" id="phone" value="" required><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="" required><br>

        <button type="submit" name="register">Đăng ký</button>
    </fieldset>
    <br><br>
    <span>Đã có tài khoản? <a href="/login/loginForm.php">Đăng nhập</a></span>
</form>