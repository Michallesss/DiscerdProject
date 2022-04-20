<!--uploading pictures-->
<?php
    //===PROFILE PICTURE===:
    require_once "aboutme.php";
    $target_dir="uploads/";
    $target_file= $target_dir.basename($_FILES['pfp']['name']);
    $is_good=true;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(isset($_POST['submit'])) {
        $check = getimagesize($_FILES['pfp']['tmp_name']);
        if($check!==false) {
            echo "File is an image - ".$check['mime'].".";
            $is_good=true;
        }
        else {
            echo "File is not an image.";
            $is_good=false;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $is_good=false;
    } 
    
    // Check file size
    if ($_FILES["pfp"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $is_good=false;
    } 
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $is_good=false;
    }

    
    // Check if $uploadOk is set to 0 by an error
    if ($is_good == false) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } 
    else {
        if (move_uploaded_file($_FILES["pfp"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["pfp"]["name"])). " has been uploaded.";
        } 
        else {
            echo "Sorry, there was an error uploading your file.";
        }
    }



    //===PROFILE BANNER===:
    $target_dir="uploads/";
    $target_file= $target_dir.basename($_FILES['banner']['name']);
    $is_good=true;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    //here...
?>