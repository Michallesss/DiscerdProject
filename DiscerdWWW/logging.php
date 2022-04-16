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
    $login2 = htmlentities($login, ENT_QUOTES, "UTF-8");
    if($login!=$login2) {
        $is_good=false;
        $_SESSION['lg_login_error']="Incorrect login";
    }
    else {
        $login=$login2;
    }

    
    //Password checking:
    $password=$_POST['lg_password'];
    if($password=="") {
        $is_good=false;
        $_SESSION['lg_password_error']="Fill password";
    }
    $hashed_password=password_hash($password, PASSWORD_DEFAULT);
    
    
    //Saveing
    $_SESSION['lg_login']=$login;
    $_SESSION['lg_password']=$password;

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        
        if($connect->connect_errno!=0) {
            throw new Exception(mysqli_connect_errno());
        }
        else {
            if($is_good) {
                //... line:26 zaloguj.php

                /*if ($rezultat = @$polaczenie->query(
                    sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
                    mysqli_real_escape_string($polaczenie,$login))))
                    {
                        $ilu_userow = $rezultat->num_rows;
                        if($ilu_userow>0)
                        {
                            $wiersz = $rezultat->fetch_assoc();
                            
                            if (password_verify($haslo, $wiersz['pass']))
                            {
                                $_SESSION['zalogowany'] = true;
                                $_SESSION['id'] = $wiersz['id'];
                                $_SESSION['user'] = $wiersz['user'];
                                $_SESSION['drewno'] = $wiersz['drewno'];
                                $_SESSION['kamien'] = $wiersz['kamien'];
                                $_SESSION['zboze'] = $wiersz['zboze'];
                                $_SESSION['email'] = $wiersz['email'];
                                $_SESSION['dnipremium'] = $wiersz['dnipremium'];
                                
                                unset($_SESSION['blad']);
                                $rezultat->free_result();
                                header('Location: gra.php');
                            }
                            else 
                            {
                                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                                header('Location: index.php');
                            }
                            
                        } else {
                            
                            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                            header('Location: index.php');
                        }
                    }*/

                //!!!
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
    <title>Discer | Logging...</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body></body>

</html>