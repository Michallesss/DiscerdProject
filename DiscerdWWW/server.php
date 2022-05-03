<!--Server with many channels and members-->
<?php 
    session_start();

    if((!isset($_SESSION['is_logged'])) || (!$_SESSION['is_logged'])) {
        header('Location: index.php');
        exit();
    }

    if((!isset($_GET['id'])) || ($_GET['id']=="")) {
        header('Location: index.php');
        exit();
    }
    else {
        $id = $_GET['id'];
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
    <title>Discer | Group - <?php if(isset($name)) echo $name?></title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/chat.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <div class="header">
        <?php 
        
        ?>
    </div>
    <div class="l-menu"><!--list of server's channels-->
        <?php 

        ?>
    </div>
    <div class="content">
        <?php 
            if($result=$connect->query(sprintf("SELECT `message`.`messageID`, `account`.`nickname`, `message`.`message_date`, `message`.`senderID`, `message`.`ChannelID`, `message`.`content` FROM `message` 
            JOIN account ON account.accountID=message.senderID
            //dodać dopowiednie dwa where jeden sprawdza id servera drugi id kanału albo zrobić jeden tylko trzeba gdzieś jeszcze w get dać id kanału czy coś
            ORDER BY `messageID` ASC;")))
        ?>
    </div>
</body>

</html>
<?php 
    $connect->close();
?>