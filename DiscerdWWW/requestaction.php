<!--Accepting or dimmmising requests from `requests.php`-->
<?php 
    session_start();

    if((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']!=true)) {
        header('Location: requests.php');
        exit();
    }

    if((!isset($_GET['id'])) || ($_GET['id']=="")) {
        header('Location: requests.php');
        exit();
    }
    else {
        $id=$_GET['id'];
    }

    //here..
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discer | Action on Request...</title>
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="imgs/icon.ico">
</head>

<body></body>

</html>