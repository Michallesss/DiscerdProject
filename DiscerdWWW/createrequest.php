<?php
    session_start();
    
    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']==false)) {
        header('Location: index.php');
        exit();
    }
    
    if(isset($_POST['submit'])) {
        $is_good=true;

        unset($_POST['submit']);
        if((!isset($_POST['nick'])) || ($_POST['nick']=="")) {
            $is_good=false;
            $rq_nick_error="Fill nick";
        }
        else {
            $nick = $_POST['nick'];
        }
        
        if((!isset($_POST['tag'])) || ($_POST['tag']=="")) {
            $is_good=false;
            $rq_tag_error="Fill tag";
        }
        else {
            $tag = $_POST['tag'];
            if($_SESSION['account_accountID']==$tag) {
                $is_good=false;
                $rq_tag_error="This is your tag";
            }
        }
    
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
    
        if($is_good) {
            try {
                $connect= @new mysqli($host, $user, $pass, $database);
    
                if($connect->connect_errno!=0) {
                    throw new Exception(mysqli_connect_errno());
                }
                else {
                    $result = $connect->query("SELECT * FROM account WHERE nickname='$nick' AND accountID='$tag'");
                    if(!$result) {
                        throw new Exception($connect->error);
                    }

                    $how_many=$result->num_rows;
                    if($how_many<=0) {
                        $rq_nick_error="That user doesn't exist";
                    }
                    else {
                        $senderID=$_SESSION['account_accountID'];
                        $reciverID=$tag;
    
                        $result = $connect->query("SELECT * FROM friendship WHERE (senderID='$senderID' AND reciverID='$reciverID') OR (senderID='$reciverID' AND reciverID='$senderID')");
                        if(!$result) {
                            throw new Exception($connect->error);
                        }
                        
                        $how_many=$result->num_rows;
                        if($how_many>0) {
                            $rq_nick_error="You've already sent an request";
                        }
                        else {
                            if($result=$connect->query("INSERT INTO friendship(`senderID`,`reciverID`,`status`) VALUES ('$senderID','$reciverID','0')")) {
                                $info = "Request was sent";
                            }
                            else {
                                throw new Exception($connect->error); 
                            }
                        }
                    }
                }
            }
            catch(Exception $e) {
                echo "<i>Error:</i>";
                echo "<div class='error'><b>Dev info:</b> ".$e."</div>";
                $connect->close();
            }
            $connect->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Send friend request</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
</head>

<body>
    <div class="form"><!--todo: wyświetlanie info o poprawnym wysłaniu zaproszenia-->
        <?php 
            if(isset($info)) {
                echo "<div class='info'>".$info."</div>";
                unset($nick);
                unset($tag);
                unset($info);
                exit();
            }
        ?>
        <form action="" method="post">
            <input type="text" name="nick" value="<?php if(isset($nick)) echo$nick; ?>" placeholder="Nick" onfocus="this.placeholder=''" onblur="this.placeholder='Nick'">
            <?php
                if(isset($rq_nick_error)) {
                    echo "<div class='error'>".$rq_nick_error."</div>";
                    unset($rq_nick_error);
                }?>
            <input type="number" name="tag" value="<?php if(isset($tag)) echo$tag; ?>" placeholder="Tag" onfocus="this.placeholder=''" onblur="this.placeholder='Tag'"><br>
            <?php 
                if(isset($rq_tag_error)) {
                    echo "<div class='error'>".$rq_tag_error."</div>";
                    unset($rq_tag_error);
                }?>
            <input type="submit" name="submit" value="Send request">
            <a href="index.php" style="float: left;">Back</a>
        </form>
    </div>
</body>

</html>