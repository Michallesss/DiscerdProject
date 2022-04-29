<?php
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']!=true)) {
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    $accountID=$_SESSION['account_accountID'];

    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception(mysqli_connect_errno());
        }
        else {
            if(!isset($_SESSION['account_accountID'])) {
                echo "<div class='error'>Something is wrong with your account. Try to logout and log in again</div>";
                $connect->close();
                exit();
            }
            $result = $connect->query("SELECT server.serverID, server.server_name FROM server
            JOIN server_group_account ON server.serverID=server_group_account.serverID
            JOIN account ON server_group_account.accountID=account.accountID
            WHERE account.accountID='$accountID'");

            if(!$result) {
                throw new Exception($connect->error);
            }
        }
    }
    catch(Exception $e) {
        echo "<i>Error:</i>";
        echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
        $connect->close();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discerd | Create invite</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
</head>

<body>
    <div class="form">
        <form method="get" action="invite.php">
            <label for="serverID">Server:</label>
            <select name="serverID" id="serverID">
                <?php 
                    while($row=$result->fetch_assoc()) {
                        $serverID=$row['serverID'];
                        $server_name=$row['server_name'];
                        echo "<option value='$serverID'>$server_name</option>";
                    }
                ?>
            </select>
            <input type="text" name="message" placeholder="Message" onfocus="this.placeholder=''" onblur="this.placeholder='Message'">
            Click create and copy the link
            <input type="submit" value="create invite">
            <a href="index.php" style="float: left;">Back</a>
        </form>
    </div>
</body>

</html>