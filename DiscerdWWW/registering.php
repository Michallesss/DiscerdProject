<?php
    session_start();

    if((isset($_SESSION['is_logged'])) && ($_SESSION['is_logged'])) {
        header('Location: index.php');
        exit();
    }


    $is_good=true; //info about walidation


    //Login checking:
    //if((isset($_POST['rg_login'])) && ($_SESSION['rg_login']!="")) {
    $login = $_POST['rg_login'];
    if((strlen($login)<3) || (strlen($login)>30)) {
        $is_good=false;
        $_SESSION['rg_login_error']="Login must have minimaly 3 and max 20 letters";
    }
    if(!ctype_alnum($login)) {
        $is_good=false;
        $_SESSION['rg_login_error']="Login can only consist liter and numbers";
    }
    if($login=="") {
        $is_good=false;
        $_SESSION['rg_login_error']="Fill login";
    }


    //Email checking:
    $email = $_POST['rg_email'];
    if(strlen($email)>30) {
        $is_good=false;
        $_SESSION['rg_email_error']="Email must have max 30 letters";
    }
    //$email2 = filter_var($email, FILTER_VALIDATE_EMAIL);
    //$email = htmlentities($email, ENT_QUOTES, "UTF-8");


    //Nick checking:
    $nick = $_POST['rg_nick'];
    //$nick = htmlentities($nick, ENT_QUOTES, "UTF-8");
    if($nick=="") {
        $nick=$login;
    }
    else if(!ctype_alnum($nick)) {
        $is_good=false;
        $_SESSION['rg_nick_error']="Nick can only consist liter and numbers";
    }
    if(strlen($nick)>30) {
        $is_good=false;
        $_SESSION['rg_nick_error']="Nick must have max 20 letters";
    }
    

    //Phone checking:
    $phone = $_POST['rg_phone'];
    if(($phone!="") && ($phone!=(int) $phone)) {
        $is_good=false;
        $_SESSION['rg_phone_error']="Phone can only consist numbers";
    }
    if(strlen($phone)>9) {
        $is_good=false;
        $_SESSION['rg_phone_error']="Phone must have max 9 numbers";
    }
    //$phone = htmlentities($phone, ENT_QUOTES, "UTF-8");


    //Password checking:
    $password = $_POST['rg_password'];
    $password2 = $_POST['rg_password2'];
    if((strlen($password)<8) || (strlen($password)>20)) {
        $is_good=false;
        $_SESSION['rg_password_error']="Password must have minimaly 8 and max 20 letters";
    }
    if($password=="") {
        $is_good=false;
        $_SESSION['rg_password_error']="Fill password";
    }
    if(($password!=$password2) || ($password2=="")) {
        $is_good=false;
        $_SESSION['rg_password2_error']="Passwords are not the same";
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        

    //Saveing..
    $_SESSION['rg_login'] = $login;
    $_SESSION['rg_nick'] = $nick;
    $_SESSION['rg_phone'] = $phone;
    $_SESSION['rg_email'] = $email;
    $_SESSION['rg_password'] = $password;

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = @new mysqli($host, $user, $pass, $database);

        if($connect->connect_errno!=0) {
            throw new Exception(mysqli_connect_errno());
        }
        else {
            $result = $connect->query("SELECT accountID FROM account WHERE `login`='$login'");

            if(!$result) {
                throw new Exception($connect->error);
            }

            $how_many = $result->num_rows;
            if($how_many>0) {
                $is_good=false;
                $_SESSION['rg_login_error']="That name already exists";
            }

            if($is_good) {
                if($connect->query("INSERT INTO account(`accountID`, `login`, `password`, `phone`, `email`, `nickname`) VALUES(NULL, '$login', '$hashed_password', '$phone', '$email', '$nick')")) {
                    header('Location: login.php');
                    unset($_SESSION['rg_login']);
                    unset($_SESSION['rg_nick']);
                    unset($_SESSION['rg_phone']);
                    unset($_SESSION['rg_email']);
                    unset($_SESSION['rg_password']);
                }
                else {
                    throw new Exception($connect->error);
                }
            }
            else {
                $connect->close();
                header('Location: signup.php');
                exit();
            }
        }
        $connect->close();
    }
    catch(Exception $e) {
        echo "<i>Error:</i>";
        echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="forum, social, discerd, chating, messages">
    <meta name="description" content="Discerd is global social forum for everyone!">
    <meta name="author" content="Mikael#0168">
    <title>Discerd | Registering...</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body></body>

</html>