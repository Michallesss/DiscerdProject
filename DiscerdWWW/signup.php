<?php
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']==false)) {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Sign up</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/signup.css">
    <link rel="icon" href="">
</head>

<body>
    <form action="registering" method="POST">
        <!--na razie nie robie tego ale trzeba nowy plik php obsługujący rejestracje-->
    </form>
    <a href="login.php">Log In</a>
</body>

</html>