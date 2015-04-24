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
            session_start();
            $user = $_SESSION['user'];
            $media=$_GET['id'];
            $connect = mysqli_connect('localhost','root','pass','imageshare');
            $connect->query("call media_deleteMedia('$media')") or die("Query error");
            header("location:profile.php?user=$user");
        ?>
    </body>
</html>
