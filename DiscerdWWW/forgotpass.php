<?php
    session_start();

    if((!isset($_SESSION['is_logged'])) && (!$_SESSION['is_logged'])) {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Forgot Password</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/discerd.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body>
    <div class="banner">
        <a href="discerd.php"><img src="imgs/banner.png"></a>
    </div>
    <img src="imgs/transparentlogo.png" width="500px" height="500px" style="float: left;">
    <h1>Option temporary unavailable</h1>
    <h2>Sorry :(</h2>
    <a href="discerd.php"><h3 style="clear: both;">Back</h3></a>
</body>

</html>