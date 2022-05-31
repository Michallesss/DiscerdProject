<!--Creating invites to a group/server-->
<?php
    //dodać kożystanie przy tworzeniu zaproszeń z tabeli invite (tu i w invite.php)
    session_start();
    include('actions/functions.php');

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']!=true)) {
        header('Location: index.php');
        exit();
    }

    $accountID=$_SESSION['account_accountID'];
    
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception(mysqli_connect_errno());
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
    <link rel="stylesheet" href="styles/discerd.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <div class="banner">
        <a href="discerd.php"><img src="imgs/banner.png"></a>
    </div>
    <div class="servers">
        <?php //list of servers
            servers($accountID, $connect);
        ?>
    </div>
    <div class="friends">
        <?php //list of users
            friends($accountID, $connect);
        ?>
    </div>
    <div class="content">
        <div class="form">
            <form method="get" action="invite.php">
                <label for="serverID">Server/Group:</label>
                <select name="serverID" id="serverID">
                    <option value="NULL">Server..</option>
                    <?php
                        try {
                            if(!$result = $connect->query("SELECT `server`.`serverID`, `server`.`server_name` FROM `server`
                            JOIN `server_group_account` ON `server`.`serverID`=`server_group_account`.`serverID`
                            JOIN `account` ON `server_group_account`.`accountID`=`account`.`accountID`
                            WHERE `account`.`accountID`='$accountID'")) {
                                throw new Exception($connect->error);
                            }
                            while($row=$result->fetch_assoc()) {
                                $serverID=$row['serverID'];
                                $server_name=$row['server_name'];
                                echo "<option value='$serverID'>$server_name</option>";
                            }
                    ?>
                </select>
                <select name="groupID" id="groupID">
                    <option value="NULL">Group</option>
                    <?php
                            if(!$result = $connect->query("SELECT `group`.`groupID`, `group`.`group_name` FROM `group`
                            JOIN `server_group_account` ON `group`.`groupID`=`server_group_account`.`groupID`
                            JOIN `account` ON `server_group_account`.`accountID`=`account`.`accountID`
                            WHERE `account`.`accountID`='$accountID'")) { 
                                throw new Exception($connect->error);
                            }
                            while($row=$result->fetch_assoc()) {
                                $serverID=$row['groupID'];
                                $server_name=$row['group_name'];
                                echo "<option value='$serverID'>$server_name</option>";
                            }
                        }
                        catch(Exception $e) {
                            echo "<i>Error:</i>";
                            echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
                        }
                    ?>
                </select>
                <input type="text" name="message" placeholder="Message" onfocus="this.placeholder=''" onblur="this.placeholder='Message'">
                Click create and copy the link
                <input type="submit" value="create invite">
            </form>
        </div>
    </div>
</body>

</html>