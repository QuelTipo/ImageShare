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
            $media=$_POST['mediaid'];
            $album=$_GET['album'];
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
            $connect->query("call users_deleteMediaFromAlbum('$media','$album')") or die("Query error");
            header("location:album.php?album=$album");
        ?>
    </body>
</html>
