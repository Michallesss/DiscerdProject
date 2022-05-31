<?php
    session_start();

    if((!isset($_SESSION['is_logged'])) || (!$_SESSION['is_logged'])) {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discerd | invite</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <?php
        echo "<div class='form'>";
        if(!isset($_SESSION['account_accountID'])) {
            echo "<div class='error'>Something is wrong with your account. Try to logout and log in again</div>";
            echo "<a href='discerd.php' style='float: left;'>Back</a>";
            exit();
        }
        else {
            $accountID=$_SESSION['account_accountID'];

            if((!isset($_GET['serverID'])) || (!isset($_GET['groupID']))) {
                echo "<div class='error'>That server doesn't exists</div>";
                echo "<a href='discerd.php' style='float: left;'>Back</a>";
                exit();
            }
            else {
                $serverID=$_GET['serverID'];
                //$groupID=$_GET['groupID'];
                $message=$_GET['message'];

                require_once "connect.php";
                mysqli_report(MYSQLI_REPORT_STRICT);

                try {
                    $connect = @new mysqli($host, $user, $pass, $database);
                    if($connect->connect_errno!=0) {
                        throw new Exception(mysqli_connect_errno());
                    }
                    else {
                        $result = $connect->query("SELECT * FROM server_group_account WHERE serverID='$serverID' AND accountID='$accountID'");
                        if(!$result) {
                            throw new Exception($connect->error);
                        }
                        $how_many = $result->num_rows;
                        if($how_many>0) {
                            echo "<div class='error'>You're already on this server</div>";
                            echo "<a href='discerd.php' style='float: left;'>Back</a>";
                            $connect->close();
                            exit();
                        }
                        else {
                            if($connect->query("INSERT INTO `server_group_account`(`serverID`,`accountID`,`muted`) VALUES ('$serverID','$accountID','0')")) {
                            echo "<h1>You're in</h1>";
                            echo "Message: ".$message;
                            $connect->close();
                            exit();
                            }
                            else {
                                throw new Exception($connect->error);
                            }
                        }
                    }
                }
                catch(Exception $e) {
                    echo "<i>Error:</i>";
                    echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
                    $connect->close();
                }
            }
        }
        echo "</div>";
    ?>
</body>

</html>