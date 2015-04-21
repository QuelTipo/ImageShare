<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php
    define("MAXWIDTH",470);
    session_start();
    if(!isset($_SESSION['user'])){
        $_SESSION['user']=null;
    }
    ?>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        Login Successful
        <?php
            $media = getMediaOfUser();
            while ($row = $media->fetch_object()) {
                $info = getMediaInfo($row->ID);
                getImageDetails($info);
            }
            getFriendList();
        ?>
    </body>
    <?php
        function getMediaOfUser() {
            $user = $_GET['user'];
            $isFriend = isFriendQuery($_SESSION['user']);
            $connect = mysqli_connect('localhost','root','pass','imageshare');
            $result = $connect->query("CALL users_getMediaID('$user','$isFriend')") or die("Error");
            return $result;
        }
        function getMediaInfo($id) {
            $connect = mysqli_connect('localhost','root','pass','imageshare');
            $result = $connect->query("CALL media_getByPk('$id')") or die("Error");
            return $result->fetch_object();
        }
        function getMediaImageTag($picture) {
            $width = $picture->width;
            $height = $picture->height;
            if ($width > MAXWIDTH) {
                $height = resizeHeight($height,$width);
                $width = MAXWIDTH;
            }
            echo '<a href="media.php?media='.$picture->ID.'"><img width="'.$width.'" height="'.$height.'" src ="Pictures/'.$_GET['user'].'/'.$picture->filename.'"/></a>';
        }
        function isMovie($media) {
            if ($media->flag) {
                return true;
            } else {
                return false;
            }
        }
        function getImageDetails($media) {
            if (!isMovie($media)) {
                echo $media->title;
                echo '<br />';
                getMediaImageTag($media);
                echo '<br />';
                echo $media->description;
                echo '<br />';
            }
        }
        
        function resizeHeight($height,$width) {
            $factor = MAXWIDTH / $width;
            return (int) $height * $factor;
        }
        
        function isFriendQuery($viewer) {
            $connect = mysqli_connect('localhost','root','pass','imageshare');
            $pageowner = $_GET['user'];
            $result = $connect->query("CALL users_areFriends('$viewer','$pageowner')") or die("Error");
            $return = $result->fetch_object();
            return $return->result;
        }
        
        function getFriendList() {
            $connect = mysqli_connect('localhost','root','pass','imageshare');
            $user = $_GET['user'];
            $result = $connect->query("CALL users_getFriends('$user')") or die("Error");
            while ($row = $result->fetch_object()) {
                $connect = mysqli_connect('localhost','root','pass','imageshare') or die("Connect Error");
                $name_rs = $connect->query("CALL users_getDisplayName('$row->username2')") or die ("Query Error");
                $name_rs = $name_rs->fetch_object();
                echo '<a href="user.php?user='.$row->username2.'">'.$name_rs->displayname.'</a>';
                echo '<br />';
            }         
        }
        
    ?>
</html>
