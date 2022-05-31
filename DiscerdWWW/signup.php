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
    <title>Discerd | Sign up</title>

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/discerd.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">
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
        <form action="registering.php" method="POST">
            <input type="login" name="rg_login" value="<?php if(isset($_SESSION['rg_login'])) echo$_SESSION['rg_login']; ?>" placeholder="Login*" onfocus="this.placeholder=''" onblur="this.placeholder='Login*'">
            <?php 
                if(isset($_SESSION['rg_login_error'])) {
                    echo "<div class='error'>".$_SESSION['rg_login_error']."</div>";
                    unset($_SESSION['rg_login_error']);
                }?>
            <!--====-->
            <input type="nick" name="rg_nick"  value="<?php if(isset($_SESSION['rg_nick'])) echo$_SESSION['rg_nick']; ?>" placeholder="Nickname" onfocus="this.placeholder=''" onblur="this.placeholder='Nickname'">
            <?php 
                if(isset($_SESSION['rg_nick_error'])) {
                    echo "<div class='error'>".$_SESSION['rg_nick_error']."</div>";
                    unset($_SESSION['rg_nick_error']);
                }?>
            <!--====-->
            <input type="tel" name="rg_phone" value="<?php if(isset($_SESSION['rg_phone'])) echo$_SESSION['rg_phone']; ?>" placeholder="Phone number" onfocus="this.placeholder=''" onblur="this.placeholder='Phone number'">
            <?php 
                if(isset($_SESSION['rg_phone_error'])) {
                    echo "<div class='error'>".$_SESSION['rg_phone_error']."</div>";
                    unset($_SESSION['rg_phone_error']);
                }?>
            <!--====-->
            <input type="email" name="rg_email" value="<?php if(isset($_SESSION['rg_email'])) echo$_SESSION['rg_email']; ?>" placeholder="E-mail" onfocus="this.placeholder=''" onblur="this.placeholder='E-mail'">
            <?php 
                if(isset($_SESSION['rg_email_error'])) {
                    echo "<div class='error'>".$_SESSION['rg_email_error']."</div>";
                    unset($_SESSION['rg_email_error']);
                }?>
            <!--====-->
            <input type="password" name="rg_password" placeholder="Password*" onfocus="this.placeholder=''" onblur="this.placeholder='Password*'">
            <?php 
                if(isset($_SESSION['rg_password_error'])) {
                    echo "<div class='error'>".$_SESSION['rg_password_error']."</div>";
                    unset($_SESSION['rg_password_error']);
                }?>
            <!--====-->
            <input type="password" name="rg_password2" placeholder="Repeat Password*" onfocus="this.placeholder=''" onblur="this.placeholder='Repeat Password*'"><br>
            <?php 
                if(isset($_SESSION['rg_password2_error'])) {
                    echo "<div class='error'>".$_SESSION['rg_password2_error']."</div>";
                    unset($_SESSION['rg_password2_error']);
                }?>
            <!--====-->
            <input type="submit" value="Sign Up">
        </form>
        <a href="login.php">Log In</a><br>
        <a href="index.php" style="float: left;">Back</a>
    </div>
</body>

</html>