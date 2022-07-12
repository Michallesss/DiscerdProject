<!--Group chat with many users-->
<?php 
    session_start();
    include('actions/functions.php');

    if((!isset($_SESSION['is_logged'])) || (!$_SESSION['is_logged'])) {
        header('Location: index.php');
        exit();
    }

    if((!isset($_GET['group'])) || ($_GET['group']=="")) {
        header('Location: index.php');
        exit();
    }
    else {
        $id=$_GET['group'];
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

    <script src="scripts/livechat.js"></script>
    <script src="scripts/validation.js"></script>
</head>

<body onload="livechat();">
    <div class="banner">
    <a href="discerd.php"><img src="imgs/banner.png"></a>
        <ol>
            <li><a href='createinvite.php'>Add member</a></li>
            <?php
                echo "<li><a href=''>".$name."</a></li>";
            ?>
        </ol>
    </div>
    <div class="servers">
        <?php //list of servers
            servers($accountID, $connect);
        ?>
    </div>
    <div class="channels">
        <div style="padding: 15% 0 15% 0; text-align: center; border-bottom: 1px solid #404040;" title="switch to text channel"><a href="">Text Channel</a></div>
        <div style="padding: 15% 0 15% 0; text-align: center; border-bottom: 1px solid #404040;" title="switch to voice channel"><a href="">Voice Channel</a></div>
        <!--some code to voice chats:))-->
    </div>
    <div class="friends">
        <?php //list of users
            friends($accountID, $connect);
        ?>
    </div>
    <input type="hidden" id="type" value="group">
    <input type="hidden" id="channel" value="<?php echo$id;?>">
    <div class="content">Loading..</div>
    <div class="inputBar">
        <form name="message" action="actions/send.php" method="post" onsubmit="return messages();">
            <input type="text" name="content" placeholder="Type here..." onfocus="this.placeholder=''" onblur="this.placeholder='Type here...'">
            <input type="hidden" value="<?php echo$id; ?>" name="group">
            <input type="submit" value="send" name="submit">
        </form>
    </div>
</body>

</html>
<?php 
    $connect->close();
?>