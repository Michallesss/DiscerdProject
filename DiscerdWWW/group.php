<!--Group chat with many users-->
<?php 
    session_start();
    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']!=true)) {
        header('Location: index.php');
        exit();
    }

    if(!isset($_GET['id'])) {
        header('Location: index.php');
        exit();
    }
    else {
        $id=$_GET['id'];
        $accountID=$_SESSION['account_accountID'];
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = @new mysqli($host, $user, $pass, $database);
        if($connect->connect_errno!=0) {
            throw new Exception($connect->mysqli_connect_errno());
        }

        if($result=$connect->query(sprintf("SELECT `group`.`group_name`, `group`.`group_icon` FROM `group` WHERE groupID='$id'"))) {
            $how_many=$result->num_rows;
            if($how_many>0) {
                $row=$result->fetch_assoc();
                //$id
                $name = $row['group_name'];
                $icon = $row['group_icon'];
            }
            else {
                header('Location: index.php');
                exit();
            }
        }
        else {
            throw new Exception($connect->error);
        }

        if(isset($_POST['submit'])) {
            if((isset($_POST['content'])) && ($_POST['content']!="")) {
                $content=$_POST['content'];
                $time=time();
                $time=date ('Y-m-d H:i', $time);
                if(!$connect->query("INSERT INTO `message`(`senderID`, `groupID`, `message_date`, `content`) VALUES ('$accountID', '$id', '$time', '$content')")) {
                    throw new Exception($connect->error);
                }
            }
        }
        unset($_POST['submit']);
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
    <title>Discer | Group - <?php if(isset($name)) echo $name?></title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/chat.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <div class="header">
        <?php 
            echo "<a href=''>".$name."</a>"
        ?>
        <a href="index.php">Back</a>
    </div>
    <?php
        try {
            if($result=$connect->query(sprintf("SELECT `message`.`messageID`, `account`.`nickname`, `message`.`message_date`, `message`.`senderID`, `message`.`recipientID`, `message`.`content` FROM `message` 
            JOIN account ON account.accountID=message.senderID
            WHERE message.groupID='$id'
            ORDER BY `messageID` ASC;"))) {
                while($row=$result->fetch_assoc()) {
                    echo "<div class='message'>";
                    echo $row['nickname']." ".$row['message_date'];
                    if($accountID==$row['senderID']) {
                        echo " <a target='_blank' href='deletemessage.php?id=".$row['messageID']."'>Delete</a>";
                    }
                    echo "<br>".$row['content'];
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