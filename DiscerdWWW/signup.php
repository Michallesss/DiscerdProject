<?php
    session_start();

    if((isset($_SESSION['is_logged'])) && ($_SESSION['is_logged'])) {
        header('Location: index.php');
        exit();
    }

    if(isset($_POST['login'])) {
        $is_good=true; //info about walidation

        //$nick = $_POST['rg_nick'];
        $nick = htmlentities($_SESSION['rg_nick'], ENT_QUOTES, "UTF-8");
        //$phone = $_POST['rg_phone'];
        $phone = htmlentities($_SESSION['rg_phone'], ENT_QUOTES, "UTF-8");


        //Login checking:
        $login = $_POST['rg_login'];
        if((strlen($login)<3) || (strlen($login)>30)) {
            $is_good=false;
            $_SESSION['rg_login_error']="Login must have minimaly 3 and max 30 letters";
        }
        if(!ctype_alnum($login)) {
            $is_good=false;
            $_SESSION['rg_login_error']="Nick can only consist of liter and numbers";
        }


        //Email checking:
        $email = $_POST['rg_email'];
        $email2 = filter_var($email, FILTER_VALIDATE_EMAIL);
        if((!filter_var($email2, FILTER_VALIDATE_EMAIL)) || ($email!=$email2)) {
            $is_good=false;
            $_SESSION['rg_email_error']="Incorect email";
        }
        unset($email2);


        //Nick checking:
        //...


        //Phone checking:
        //...


        //Password checking:
        $password = $_POST['rg_password'];
        //$password = htmlentities($password, ENT_QUOTES, "UTF-8");
        $password2 = $_POST['rg_password2'];
        //$password2 = htmlentities($password2, ENT_QUOTES, "UTF-8");
        if((strlen($password)<8) (strlen($password)>30)) {
            $is_good=false;
            $_SESSION['rg_password_error']="Password must have minimaly 3 and max 30 letters";
        }
        if($password!=$password2) {
            $is_good=false;
            $_SESSION['rg_password_error']="Passwords are not the same";
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        //here...
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Sign up</title>

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
</head>

<body>
    <div class="form">
        <form method="POST">
            <input type="login" name="rg_login" placeholder="Login*" onfocus="this.placeholder=''" onblur="this.placeholder='Login*'">
            <?php 
                if(isset($_SESSION['rg_login_error'])) {
                    echo "<div class='error'>".$_SESSION['rg_login_error']."</div>";
                    unset($_SESSION['rg_login_error']);
                }?>
            <input type="nick" name="rg_nick" placeholder="Nickname" onfocus="this.placeholder=''" onblur="this.placeholder='Nickname'">
            <input type="tel" name="rg_phone" placeholder="Phone number" onfocus="this.placeholder=''" onblur="this.placeholder='Phone number'">
            <input type="email" name="rg_email" placeholder="E-mail*" onfocus="this.placeholder=''" onblur="this.placeholder='E-mail*'">
            <input type="password" name="rg_password" placeholder="Password*" onfocus="this.placeholder=''" onblur="this.placeholder='Password*'">
            <input type="password" name="rg_password2" placeholder="Repeat Password*" onfocus="this.placeholder=''" onblur="this.placeholder='Repeat Password*'">
            <input type="submit" value="Sign Up">
        </form>
        <a href="login.php">Log In</a><br>
        <a href="index.php" style="float: left;">Back</a>
    </div>
</body>

</html>