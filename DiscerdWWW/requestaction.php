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
?>