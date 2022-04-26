<?php 
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']==false)) {
        header('Location: index.php');
        exit();
    }

    if(!isset($_GET['id'])) {
        header('Location: index.php');
        exit();
    }
    else {
        $id = $_GET['id'];
        $accountID = $_SESSION['account_accountID'];
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception($connect->mysqli_connect_errno());
        }

        if($result=$connect->query(sprintf("SELECT account.`nickname`, account.`status`, account.`activity`, account.`pfp`, account.`banner` FROM account WHERE accountID='$id'"))) {
            $row=$result->fetch_assoc();

            //$id
            $nick=$row['nickname'];
            $status=$row['status'];
            $activity=$row['activity'];
            $pfp=$row['pfp'];
            $banner=$row['banner'];
        }
        else {
            throw new Exception($connect->error);
        }
        $is_good=true;

        if((isset($_POST['submit']) && ($_POST['submit']=="send"))) {
            if((!isset($_POST['content'])) || ($_POST['content']=="")) {
                $is_good=false;
            }
            else {
                $content=$_POST['content'];
                echo "dupa";
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
    <title>Discer | Chat - <?php if(isset($nick)) echo $nick?></title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/chat.css">
    <link rel="icon" href="imgs/icon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
</head>

<body>
    <?php
        try {
            if($result=$connect->query(sprintf("SELECT `message`.`messageID`, `account`.`nickname`, `message`.`message_date`, `message`.`senderID`, `message`.`recipientID`, `message`.`content` FROM `message` 
            JOIN account ON account.accountID=message.senderID
            WHERE (`message`.senderID=1 AND `message`.recipientID=2) OR (`message`.senderID=2 AND `message`.recipientID=1)
            ORDER BY `message_date` ASC;"))) {
                while($row=$result->fetch_assoc()) {
                    echo "<div class='message'>";
                    echo $row['nickname']." ".$row['message_date']."<br>";
                    echo $row['content'];
                    echo "</div>";
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
    <form action="" method="post">
        <input type="text" name="content" placeholder="Type here..." onfocus="this.placeholder=''" onblur="this.placeholder='Type here...'">
        <input type="submit" value="send" name="submit">
    </form>
</body>

</html>
<?php 
    $connect->close();
?>