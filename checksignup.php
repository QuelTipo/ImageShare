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
            $connect = mysqli_connect('localhost','root','pass','imageshare') or die("Can't connect");
            
            if ((empty($_POST['myusername'])) || (empty($_POST['mypassword'])) || (empty($_POST['mydisplayname'])) || (empty($_POST['mystatement']))) {
                header("location:newuser.php");
            } else {
            
                $myusername = $_POST['myusername'];
                $mypassword = $_POST['mypassword'];
                $mydisplayname = $_POST['mydisplayname'];
                $mystatement = $_POST['mystatement'];
            
                $isTaken = mysqli_query($connect,"CALL users_usernameTaken('$myusername')") or die("Error.");
                $result = $isTaken->fetch_object();
                if ($result->result) {
                    session_start();
                    $_SESSION['signupfail'] = 1;
                    header("location:newuser.php");
                } else {
                    $connect = mysqli_connect('localhost','root','pass','imageshare') or die("Can't connect");
                    $result = mysqli_query($connect,"CALL users_enterUser('$myusername','$mydisplayname','$mypassword','$mystatement')");
                    $connect = mysqli_connect('localhost','root','pass','imageshare') or die("Can't connect");
                    $result = mysqli_query($connect,"CALL users_addNewFriend('$myusername','$myusername')");
                    mkdir('Pictures/'.$myusername.'/',0777,true);
                    session_start();
                    $_SESSION['user'] = $myusername;
                    header("location:profile.php?user=$myusername");
                }
            }
            
        ?>
    </body>
</html>
