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
            $friend=$_GET['id'];
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
            $connect->query("call users_addNewFriend('$user','$friend')") or die("Query error");
            header("location:profile.php?user=$friend");
        ?>
    </body>
</html>
