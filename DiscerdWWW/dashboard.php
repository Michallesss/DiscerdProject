<?php 
    session_start();

    if((!isset($_SESSION['is_logged'])) || (!$_SESSION['is_logged']) || ($_SESSION['account_permission_level']==0)) {
        header('Location: index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Discerd | Admin Dashboard</title>
        
        <link rel="stylesheet" href="styles/style.css">
        <link rel="stylesheet" href="styles/discerd.css">
        <link rel="icon" href="imgs/icon.ico">
    </head>

    <body>
        <div class="banner">
            <a href="discerd.php"><img src="imgs/banner.png"></a>
        </div>
        
        <h1>Beta admin panel</h1>
        <h3>Option temporary unavailable</h3>
        <a href="discerd.php">Back</a>
    </body>
</html>