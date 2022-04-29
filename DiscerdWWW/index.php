<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="forum, social, discerd, chating, messages">
    <meta name="description" content="Discerd is global social forum for everyone!">
    <meta name="author" content="Mikael#0168">
    <title>Discerd | Home</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <div class="header">
        <a href="index.php"><img src="imgs/transparentlogo.png"></a>
        <ol>
        <?php
            if((isset($_SESSION['is_logged'])) && ($_SESSION['is_logged']==true)) {
                echo "<li><a href='discerd.php'><div>Open Discerd</div></a></li>";
            }
            else {
                echo "<li><a href='login.php'><div>Login</div></a></li>";
            }
        ?>
        </ol>
    </div>

    <div class="content">
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Odit sapiente fugit, similique hic adipisci voluptatem iure ratione nesciunt quod. Nihil, voluptas porro fugiat non voluptatem eos asperiores? Maxime, provident accusantium?
    </div>

    <div class="footer">
        Discerd<br>
        By Michał Wieczorek, Szymon Kulej, Mateusz Simkiewicz.
    </div>
</body>

</html>

<?php
    if((isset($_SESSION['is_logged'])) && ($_SESSION['is_logged']==true)) {
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        try {
            $connect = @new mysqli($host, $user, $pass, $database);
            if($connect->connect_errno!=0) {
                throw new Exception(mysqli_connect_errno());
            }

            if(isset($_SESSION['account_accountID'])) {
                $id = $_SESSION['account_accountID'];
                if($result = $connect->query(sprintf("SELECT * FROM account WHERE accountID='$id'"))) {
                    $how_many = $result->num_rows;
                    if($how_many>0) {
                        $account = $result->fetch_assoc();

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
                    }
                    else {
                        exit();
                    }
                }
                else {
                    throw new Exception($connect->error);
                }
            }
            $connect->close();
        }
        catch(Exception $e) {
            echo "<i>Error:</i>";
            echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
            $connect->close();
        }
    }
?>