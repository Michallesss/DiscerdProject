<?php
    session_start();

    require_once "connect.php";
    $connect = @new mysqli($host, $user, $password, $database);


    $connect->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Connecting...</title>
    
    <link rel="icon" href="imgs/icon.ico">
</head>

<body></body>

</html>