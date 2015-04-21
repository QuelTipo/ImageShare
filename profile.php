<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<link rel="stylesheet" href="css/site.css">

<link rel="stylesheet" href="css/profile.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<title>ImageShare</title>
</head>

<body>
    <?php include("menu.php"); 
          define("MAXWIDTH",470);
    ?>
    
    <div class="my-centre">
        <div class="container">
            <div class="col-lg-12">
                <h1 class="page-header">
                <?php
                    $displayname = getDisplayName($_GET['user']);
                    echo $displayname;
                ?> 
                </h1>
            </div>
            
            
            <div class="col-lg-4">
            	<div class="panle panel-group"><div class="panel-body no-padding">
                        <p>
                            <?php 
                                $statement = getStatement($_GET['user']);
                                echo $statement;
                            ?>
                        </p>
                    <?php
                        if (!isFriendQuery($_SESSION['user'])) {
                            echo '<a href="#" class="btn btn-default">Send Friend Request</a>';
                        }
                    ?>
                </div></div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Friends
                    </div>
                    <div class="panel-body">
                        <ul>
                            <?php getFriendList();?>
                        </ul>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Albums
                    </div>
                    <div class="panel-body">
                        <ul>
                            <?php getAlbumList();?>
                        </ul>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Groups
                    </div>
                    <div class="panel-body">
                        <ul>
                            <?php getGroupList();?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
            	<?php 
                    $result=getMediaOfUser();
                    while ($row=$result->fetch_object()) {
                        $media=getMediaInfo($row->ID);
                        getImageDetails($media);
                    }
                ?>
            </div>
            
        </div>
    </div>
    <?php
        function getMediaOfUser() {
            $user = $_GET['user'];
            $isFriend = isFriendQuery($_SESSION['user']);
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
            $result = $connect->query("CALL users_getMediaID('$user','$isFriend')") or die("Error");
            return $result;
        }
        function getMediaInfo($id) {
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
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
            echo '<div align="center">';
            echo '<a href="media.php?media='.$picture->ID.'"><img class="img-responsive" width="'.$width.'" height="'.$height.'" src ="Pictures/'.$_GET['user'].'/'.$picture->filename.'"/></a>';
            echo '</div>';
            
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
                echo '<div class="panel panel-default">';
                    echo '<div class="panel-heading">';
                        echo '<h3>'.$media->title.'</h3>';
                    echo '</div>';
                    echo '<div class="panel-body">';
                        echo '<div class="row text-center">';
                            getMediaImageTag($media);
                    echo '</div></div>';
                    echo '<div class="caption">';
                echo '<div>';
                echo $media->description;
                echo '</div>';
                echo '<div class="text-right">';
                echo '<a href="#">Cannon Powershot</a><br>';
                echo '<a href="#">Calgary, Alberta Canada</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  
            }
        }
        
        function resizeHeight($height,$width) {
            $factor = MAXWIDTH / $width;
            return (int) $height * $factor;
        }
        
        function isFriendQuery($viewer) {
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
            $pageowner = $_GET['user'];
            $result = $connect->query("CALL users_areFriends('$viewer','$pageowner')") or die("Error");
            $return = $result->fetch_object();
            return $return->result;
        }
        
        function getFriendList() {
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
            $user = $_GET['user'];
            $result = $connect->query("CALL users_getFriends('$user')") or die("Error");
            while ($row = $result->fetch_object()) {
                $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare') or die("Connect Error");
                $name_rs = $connect->query("CALL users_getDisplayName('$row->username2')") or die ("Query Error");
                $name_rs = $name_rs->fetch_object();
                echo '<li>';
                echo '<a href="profile.php?user='.$row->username2.'">'.$name_rs->displayname.'</a>';
                echo '</li>';
            }         
        }
        
        function getAlbumList() {
            $user = $_GET['user'];
            $isFriend = isFriendQuery($_SESSION['user']);
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
            $result = $connect->query("CALL users_getAlbums('$user','$isFriend')") or die("Error");
            while ($row = $result->fetch_object()) {
                $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare') or die("Connect Error");
                $ID_rs = $connect->query("CALL album_getByPk('$row->ID')") or die ("Query Error");
                $ID_rs = $ID_rs->fetch_object();
                echo '<li>';
                echo '<a href="album.php?album='.$row->ID.'">'.$ID_rs->title.'</a>';
                echo '</li>';
            }
        }
        
        function getGroupList() {
            $user = $_GET['user'];
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
            $result = $connect->query("CALL users_getGroups('$user')") or die("Error");
            while ($row = $result->fetch_object()) {
                $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare') or die("Connect Error");
                $ID_rs = $connect->query("CALL groups_getByPk('$row->groupID')") or die ("Query Error");
                $ID_rs = $ID_rs->fetch_object();
                echo '<li>';
                echo '<a href="group.php?group='.$row->groupID.'">'.$ID_rs->group_name.'</a>';
                echo '</li>';
            }
        }
        
        function getDisplayName($user) {
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
            $name_rs = $connect->query("CALL users_getDisplayName('$user')") or die ("Query Error");
            $name_rs2 = $name_rs->fetch_object();
            return $name_rs2->displayname;
        }
        
        function getStatement($user) {
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
            $name_rs = $connect->query("CALL users_getStatement('$user')") or die ("Query Error");
            $name_rs2 = $name_rs->fetch_object();
            return $name_rs2->statement;
        } 
        
    ?>
</body>
</html>
