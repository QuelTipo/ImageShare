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
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare') or die("Can't connect");
            $myusername = $_POST['myusername'];
            $mypassword = $_POST['mypassword'];
            $result = mysqli_query($connect,"CALL users_login('$myusername','$mypassword')") or die("Query failed");
            $count = mysqli_num_rows($result);
            if($count==1) {
                session_start();
                $_SESSION['user']=$myusername;
                $_SESSION['pass']=$mypassword;
                header("location:profile.php?user=$myusername");
             } else {
                 echo "Wrong username or password";
             }
        ?>
    </body>
</html>
