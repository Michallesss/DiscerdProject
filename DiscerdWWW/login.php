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
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <div class="form">
        <form action="logging.php" method="POST">
            <input type="text" name="lg_login" value="<?php if(isset($_SESSION['lg_login'])) echo$_SESSION['lg_login']; ?>" placeholder="Login" onfocus="this.placeholder=''" onblur="this.placeholder='Login'">
            <?php
                if(isset($_SESSION['lg_login_error'])) {
                    echo "<div class='error'>".$_SESSION['lg_login_error']."</div>";
                    unset($_SESSION['lg_login_error']);
                }?>
            <!--====-->
            <input type="password" name="lg_password" placeholder="Password" onfocus="this.placeholder=''" onblur="this.placeholder='Password'"><br>
            <?php 
                if(isset($_SESSION['lg_password_error'])) {
                    echo "<div class='error'>".$_SESSION['lg_password_error']."</div>";
                    unset($_SESSION['lg_password_error']);
                }
            ?>
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