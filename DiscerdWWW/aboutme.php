<?php
    session_start();
    include('actions/functions.php');

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']!=true)) {
        header('Location" index.php');
        exit();
    }
    else {
        $accountID=$_SESSION['account_accountID'];
    }
    
    $id=$_SESSION['account_accountID'];

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
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | About me</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/discerd.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
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
        <div class="form" style="margin-top: 3%;">
            <form action="actions/upload.php" method="post" enctype="multipart/form-data">
                Profile Picture:
                <input type="file" name="pfp" id="pfp">
                Profile Banner:
                <input type="file" name="banner" id="banner">
                <input type="submit" value="Upload Images" name="submit">
            </form>
        </div>
        <div class="form" style="margin-top: 3%;">
            <form action="" method="post">
                Informations
                <input type="nick" name="pf_nick"  value="" placeholder="New Nickname" onfocus="this.placeholder=''" onblur="this.placeholder='New Nickname'">
                <input type="tel" name="pf_phone" value="" placeholder="New Phone number" onfocus="this.placeholder=''" onblur="this.placeholder='New Phone number'">
                <input type="email" name="pf_email" value="" placeholder="New E-mail" onfocus="this.placeholder=''" onblur="this.placeholder='New E-mail'">
                <input type="submit" value="Upload Images" name="submit">
                <a href="actions/changepass.php">Change password</a><br>
                <a href="deleteaccount.php">Delete account</a><br>
            </form>
        </div>
    </div>
</body>
</body>

</html>