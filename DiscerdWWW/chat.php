<!--private chat between two users-->
<?php 
    session_start();
    
    if((!isset($_SESSION['is_logged'])) || (!$_SESSION['is_logged'])) {
        header('Location: index.php');
        exit();
    }

    if(!isset(($_GET['chat'])) || ($_GET['chat']=="")) {
        header('Location: index.php');
        exit();
    }
    else {
        $id = $_GET['chat'];
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
            $how_many=$result->num_rows;
            if($how_many>0) {
                $row=$result->fetch_assoc();
                //$id
                $nick=$row['nickname'];
                $status=$row['status'];
                $activity=$row['activity'];
                $pfp=$row['pfp'];
                $banner=$row['banner'];
            }
            else {
                header('Location: index.php');
                exit();
            }
        }
        else {
            throw new Exception($connect->error);
        }

        /*if(isset($_POST['submit'])) {
            if((!isset($_POST['content'])) || ($_POST['content']!="")) {
                $content=$_POST['content'];
                $time=time();
                $time=date ('Y-m-d H:i', $time);
                if(!$connect->query("INSERT INTO `message`(`senderID`, `recipientID`, `message_date`, `content`) VALUES ('$accountID', '$id', '$time', '$content')")) {
                    throw new Exception($connect->error);
                }
                $_POST['content']="";
                unset($_POST['content']);
            }
            $_POST['submit'];
            unset($_POST['submit']);
        }*/
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
    <title>Discer | Chat -
        <?php if(isset($nick)) echo $nick?>
    </title>

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/chat.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <div class="header">
        <?php 
            echo "<a href='profile.php?id=$id'>".$nick."</a>";
        ?>
        <a href="discerd.php">Back</a>
    </div>
    <div class="content">
        <?php
        try {
            if($result=$connect->query(sprintf("SELECT `message`.`messageID`, `account`.`nickname`, `message`.`message_date`, `message`.`senderID`, `message`.`recipientID`, `message`.`content` FROM `message` 
            JOIN account ON account.accountID=message.senderID
            WHERE (`message`.senderID='$accountID' AND `message`.recipientID='$id') OR (`message`.senderID='$id' AND `message`.recipientID='$accountID')
            ORDER BY `messageID` ASC"))) {
                while($row=$result->fetch_assoc()) {
                    echo "<div class='message'>";
                    echo $row['nickname']." ".$row['message_date']; 
                    if($accountID==$row['senderID']) {
                        echo "<a href='actions/deletemessage.php?id=".$row['messageID']."&chat=".$id."'>Delete</a>";
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
        <form action="actions/send.php" method="post">
            <input type="text" name="content" placeholder="Type here..." onfocus="this.placeholder=''"
                onblur="this.placeholder='Type here...'">
            <input type="hidden" value="<?php echo$id; ?>" name="chat">
            <input type="submit" value="send" name="submit">
        </form>
    </div>
</body>

</html>
<?php
    $connect->close();
?>