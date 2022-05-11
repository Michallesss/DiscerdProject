<?php 
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']!=true)) {
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception($connect->mysqli_connect_errno());
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
    <title>Discer | Friends Requests</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <?php 
        try {
            $accountID = $_SESSION['account_accountID'];
            if($result=$connect->query(sprintf("SELECT `account`.`accountID`, `account`.`nickname`, `account`.`activity`, `account`.`status`, `account`.`pfp`, `account`.`banner` FROM friendship 
            JOIN account ON accountID=senderID
            WHERE `friendship`.`reciverID`='$accountID' AND `friendship`.`status`=0;"))) {
                while($row=$result->fetch_assoc()) {
                    echo $row['nickname']."#".$row['accountID']; 
                    $id = $row['accountID'];
                    echo "
                    <form action='actions/requestaction.php' method='post'>
                        <input type='submit' name='action' value='accept'>
                        <input type='hidden' name='user' value='$id'>
                        <input type='submit' name='action' value='dimiss'>
                    </form>";
                }
            }
            else {
                throw new Exception($connect->error);
            }
        }
        catch(Exception $e) {
            echo "<i>Error:</i>";
            echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
            $connect->close();
        }
    ?>
    <a href="index.php" style="float: left;">Back</a>
</body>

</html>
<?php 
    $connect->close();
?>