<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<link rel="stylesheet" href="css/site.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<title>ImageShare</title>
</head>
<?php 
    include 'menu.php';
    print_r($_POST);
    if (!isset($_SESSION['user']))
    {
        header('location index2.php');
    }
    $niceFileName = basename($_FILES["fileToUpload"]["name"]);
    $target_dir = "Pictures/";
    $target_file = $target_dir . '/' . $_SESSION['user'] . '/' . $niceFileName;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {       
            try
            {
                $conn = new PDO('mysql:host=localhost;dbname=imageshare', 'imageshare', 'sharemeplease!@#');
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $locationVal = filter_input(INPUT_POST, 'location');
                $tempAry = explode('--', $locationVal);
                $long = $tempAry[0];
                $lat = $tempAry[1];
                
                $cameraVal = filter_input(INPUT_POST, 'camera');
                $tempAry = explode('--', $cameraVal);
                $cam_model = $tempAry[0];
                $cam_man = $tempAry[1];
                
                $private = filter_input(INPUT_POST, 'private');
                
                if(!isset($private))
                {
                    $private = false;
                }
                
                $insertPic = $conn->prepare('call media_addNew(:title,
								:height,
								:width,
								:filename,
								:description,
								:private,
								:cam_model,
								:cam_man,
								:longitude,
								:latitude,
								:owner_name,
								:flag,
								:extraparam1,
								:extraparam2)');
                $insertPic->execute(array(
                            ':title' => filter_input(INPUT_POST, 'title'),
                            ':height' => filter_input(INPUT_POST, 'height'),
                            ':width' => filter_input(INPUT_POST, 'width'),
                            ':filename' => $niceFileName,
                            ':description' => filter_input(INPUT_POST, 'description'),
                            ':private' => $private,
                            ':cam_model' => $cam_model,
                            ':cam_man' => $cam_man,
                            ':longitude' => $long,
                            ':latitude' => $lat,
                            ':owner_name' => $_SESSION['user'],
                            ':flag' => filter_input(INPUT_POST, 'flag'),
                            ':extraparam1' => filter_input(INPUT_POST, 'extraparam1'),
                            ':extraparam2' => null
                          ));
                        
                $insertPic->closeCursor();

            } catch(PDOException $e) {
                echo 'ERROR: ' . $e->getMessage();
            }
            //header('location profile.php?user=' . $_SESSION['user']);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    
?>
    