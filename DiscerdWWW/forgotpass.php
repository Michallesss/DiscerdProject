<?php
    session_start();

    if((isset($_SESSION['is_logged'])) && ($_SESSION['is_logged']==true)) {
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
    <link rel="stylesheet" href="styles/forgot.css">
    <link rel="icon" href="imgs/icon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
</head>

<body>
    <img src="imgs/transparentlogo.png" width="500px" height="500px" style="float: left;">
    <h1>Option temporary unavailable</h1>
    <h2>Sorry :(</h2>
    <a href="discerd.php"><h3 style="clear: both;">Back</h3></a>
</body>

</html>