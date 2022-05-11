<?php
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']!=true)) {
        header('Location" index.php');
        exit();
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
    <div class="header">
        <ol>
            <a href="index.php"><img src="imgs/transparentlogo.png"></a>
        </ol> 
    </div>
    <div class="form">
        <form action="actions/upload.php" method="post" enctype="multipart/form-data">
            Profile Picture:
            <input type="file" name="pfp" id="pfp">
            Profile Banner:
            <input type="file" name="banner" id="banner">
            <input type="submit" value="Upload Images" name="submit">
        </form>
    </div>
    <div class="form">
        <form action="" method="post">
            Informations
            <input type="nick" name="pf_nick"  value="" placeholder="New Nickname" onfocus="this.placeholder=''" onblur="this.placeholder='New Nickname'">
            <input type="tel" name="pf_phone" value="" placeholder="New Phone number" onfocus="this.placeholder=''" onblur="this.placeholder='New Phone number'">
            <input type="email" name="pf_email" value="" placeholder="New E-mail" onfocus="this.placeholder=''" onblur="this.placeholder='New E-mail'">
            <a href="actions/changepass.php">Change password</a><br>
            <a href="actions/deleteaccount.php">Delete account</a><br>
            <a href="discerd.php" style="float: left;">Back</a>
        </form>
    </div>
</body>
</body>

</html>