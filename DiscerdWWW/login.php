<?php
    session_start();

    if((isset($_SESSION['is_logged'])) && ($_SESSION['is_logged'])) {
        header('Location:index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discerd | Log in</title>

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/discerd.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">

    <script src="scripts/validation.js"></script>
</head>

<body>
    <div class="banner">
        <a href="discerd.php"><img src="imgs/banner.png"></a>
        <ol>
            <li><a href='login.php'><div>Login</div></a></li>
            <li><a href='signup.php'>Sign Up</a></li>
        </ol>
    </div>
    <div class="form">
        <form name="login" action="logging.php" method="POST" onsubmit="return log_in();">
            <input type="text" name="lg_login" value="<?php if(isset($_SESSION['lg_login'])) echo$_SESSION['lg_login']; ?>" placeholder="Login" onfocus="this.placeholder=''" onblur="this.placeholder='Login'">
            <div class="error" id="lg_login">
                <?php
                    if(isset($_SESSION['lg_login_error'])) {
                        echo $_SESSION['lg_login_error'];
                        unset($_SESSION['lg_login_error']);
                    }
                ?>
            </div>
            <!--====-->
            <input type="password" name="lg_password" placeholder="Password" onfocus="this.placeholder=''" onblur="this.placeholder='Password'"><br>
            <div class="error" id="lg_password">
                <?php 
                    if(isset($_SESSION['lg_password_error'])) {
                        echo $_SESSION['lg_password_error'];
                        unset($_SESSION['lg_password_error']);
                    }
                ?>
            </div>
            <!--====-->
            <a href="forgotpass.php">forgot password</a><br>
            <!--====-->
            <input type="submit" value="Log in"><br>
        </form>
        <a href="signup.php">Sign Up</a><br>
        <a href="index.php" style="float: left;">Back</a>
    </div>
</body>
</body>

</html>