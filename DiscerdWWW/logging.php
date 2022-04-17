<?php
    session_start();

    if((isset($_SESSION['is_logged'])) && ($_SESSION['is_logged'])) {
        header('Location: index.php');
        exit();
    }

    $is_good=true;
    
    //Login checking:
    $login=$_POST['lg_login'];
    if($login=="") {
        $is_good=false;
        $_SESSION['lg_login_error']="Fill login";
    }
    /*$login2 = htmlentities($login, ENT_QUOTES, "UTF-8");
    if($login!=$login2) {
        $is_good=false;
        $_SESSION['lg_login_error']="Incorrect login";
    }
    else {
        $login=$login2;
    }*/

    
    //Password checking:
    $password=$_POST['lg_password'];
    if($password=="") {
        $is_good=false;
        $_SESSION['lg_password_error']="Fill password";
    }
    //$hashed_password=password_hash($password, PASSWORD_DEFAULT);
    
    
    //Saveing
    $_SESSION['lg_login']=$login;
    $_SESSION['lg_password']=$password;

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        
        if($connect->connect_errno!=0) {
            throw new Exception(mysqli_connect_errno());
            header('Location: index.php');
        }
        else {
            if($is_good) {
                if($result = $connect->query(sprintf("SELECT * FROM account WHERE login='$login'"))) {
                        $how_many = $result->num_rows;
                        if($how_many>0)
                        {
                            $account = $result->fetch_assoc();
                            
                            if (password_verify($password, $account['password']))
                            {
                                $_SESSION['is_logged'] = true;

                                //Getting account info
                                $_SESSION['account_accountID'] = $account['accountID'];
                                $_SESSION['account_login'] = $account['login'];
                                $_SESSION['account_password'] = $account['password'];
                                $_SESSION['account_phone'] = $account['phone'];
                                $_SESSION['account_email'] = $account['email'];
                                $_SESSION['account_nick'] = $account['nickname'];
                                $_SESSION['account_aboutme'] = $account['aboutme'];
                                $_SESSION['account_status'] = $account['status'];
                                $_SESSION['account_activity'] = $account['activity'];
                                $_SESSION['account_pfp'] = $account['pfp'];
                                $_SESSION['account_banner'] = $account['banner'];
                                
                                unset($_SESSION['lg_login']);
                                $result->free_result();
                                $connect->close();
                                header('Location: discerd.php');
                                exit();
                            }
                            else 
                            {
                                throw new Exception($connect->error);
                            }
                            
                        }
                        else {
                            
                            $_SESSION['lg_login_error'] = "<div class='error'>Incorrect login or password</div>";
                            $connect->close();
                            header('Location: login.php');
                            exit();
                        }
                }
                else {
                    $_SESSION['lg_login_error'] = "<div class='error'>Incorrect login or password</div>";
                    $connect->close();
                    header('Location: login.php');
                    exit();
                }
            }
            else {
                $connect->close();
                header('Location: login.php');
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
    <title>Discerd | Logging...</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body></body>

</html>