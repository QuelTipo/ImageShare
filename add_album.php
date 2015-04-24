<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            
            $user = $_GET['user'];
            $title=$_POST['title'];
            $private = true;
            if (!isSet($_POST['private'])) {
                $private = false;
            }
            $connect = mysqli_connect('localhost','root','pass','imageshare');
            $connect->query("call users_createAlbum('$user','$title','private')") or die("Query error");
            header("location:profile.php?user=$user");
        ?>
    </body>
</html>
