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
            
            $id = $_GET['album'];
            $connect = $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
            $result = $connect->query("CALL album_getByPk('$id')") or die("Error");
            $album = $result->fetch_object();
        ?>
    <div class="my-centre">
        <div class="container">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <small class="pull-right small-header">                    	
                        <?php getOwner($album) ?>
                    </small>
                    <?php echo $album->title ?>
                </h1>
            </div>
            <?php getSideBar($album); ?>
            <div class="col-lg-10">
            <?php getAlbumMediaThumbnails($album);?>
            <nav>
              	<ul class="pager">
                	<li class="previous"><a href="#"><span aria-hidden="true">&larr;</span> Previous</a></li>
                	<li class="next"><a href="#">Next <span aria-hidden="true">&rarr;</span></a></li>
              	</ul>
            </nav>
            </div>
            
            

            
        </div>
    </div>
    <?php
        function getOwner($album) {
            if ($album->group_id == null) {
                $connect=mysqli_connect('localhost','root','Hibobhi02','imageshare');
                $result=$connect->query("call users_getDisplayName('$album->owner_name')") or die("Query error");
                $result=$result->fetch_object();
                echo 'Owner Name: <a href="user.php?user='.$album->owner_name.'">'.$result->displayname.'</a>';
            } else {
               $connect=mysqli_connect('localhost','root','Hibobhi02','imageshare');
                $result=$connect->query("call groups_getByPk('$album->group_id')") or die("Query error");
                $result=$result->fetch_object();
                echo 'Owner Group: <a href="group.php?group="'.$album->group_id.'">'.$result->group_name.'</a>';
            }
        }
        
        
        
        function getAlbumMediaThumbnails($album) {
            $canview = 0;
            $connect=mysqli_connect('localhost','root','Hibobhi02','imageshare') or die("Connect error");
            $result=$connect->query("call album_getImagesByPk('$album->ID')") or die("Query error");
            while($image=$result->fetch_object()) {
                $connect1=mysqli_connect('localhost','root','Hibobhi02','imageshare');
                $user = $_SESSION['user'];
                $result1=$connect1->query("call users_canViewMedia('$image->ID','$user')");
                $result1=$result1->fetch_object();
                $canview=$result1->result;
                if (($album->group_id != null) && (canview==0))  {
                    $connect2=mysqli_connect('localhost','root','Hibobhi02','imageshare');
                    $result3=$connect3->query("call groups_isMember('$user','$album->group_id')");
                    $result3=$result3->fetch_object();
                    $canview=$result3->result;
                }
                if ($canview == 1) {
                    getImageThumb($image);
                }
            }
            
        }
        
        function getImageThumb($image) {
            echo '<div class="col-lg-3 col-md-4 col-xs-6 thumb">';
                echo '<a class="thumbnail" href="image.php?id='.$image->ID.'">';
                    echo '<img class="img-responsive my-thumb" src="Pictures/'.$image->owner_name.'/'.$image->filename.'" alt="">';
                echo '</a>';
            echo '</div>';
        }
        
        function getSideBar($album) {
            $viewer = $_SESSION['user'];
            $needSideBar = 0;
            $connect=mysqli_connect('localhost','root','Hibobhi02','imageshare');
            if ($album->group_id == null) {
                $result=$connect->query("call users_isUsersAlbum('$album->ID','$viewer')") or die("Query error.");
                $result=$result->fetch_object();
                $needSideBar = $result->result;
            } else {
                $result=$connect->query("call groups_isMember('$viewer','$album->group_id')");
                $result=$result->fetch_object();
                $needSideBar = $result->result;
            }
            if ($needSideBar) {
                doSideBar($album);
            }
        }
        
        function doSideBar($album) {
            echo '<div class="col-lg-2">';
                echo '<div class="panle panel-group"><div class="panel-body no-padding">';
                    echo '<p>';
                    echo 'HIIIIIII';
                    echo '</p>';
                echo '</div></div>';
            echo '<div class="panel panel-default">
                    <div class="panel-heading">
                        Add Photos
                    </div>
                    <div class="panel-body">';
                        getAddForm($album);
                    echo '</div></div>
            <div class="panel panel-default">
                    <div class="panel-heading">
                        Delete Photos
                    </div>
                    <div class="panel-body">';
                        getDeleteForm($album);
                    echo '</div>
                </div>
                </div>';
        }
        
        function getAddForm($album) {
            echo '<form action="add_to_album.php?album='.$album->ID.'" method="post">';
            echo '<select name="mediaid">';
            $viewer = $_SESSION['user'];
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
            $result = $connect->query("call album_getPhotosNotAdded('$viewer','$album->ID')") or die("Query error");
            while ($row=$result->fetch_object()) {
                echo '<option value="'.$row->ID.'"> '.$row->title.'</option>';
            }
            echo '<input type="submit" class="button" value="Submit"/>';
            echo '</select>';
            echo '</form>';
            
        }
        function getDeleteForm($album) {
            echo '<form action="delete_from_album.php?album='.$album->ID.'" method="post">';
            echo '<select name="mediaid">';
            $viewer = $_SESSION['user'];
            $connect = mysqli_connect('localhost','root','Hibobhi02','imageshare');
            $result = $connect->query("call album_getUsersPhotosAdded('$viewer','$album->ID')") or die("Query error");
            while ($row=$result->fetch_object()) {
                echo '<option value="'.$row->ID.'"> '.$row->title.'</option>';
            }
            echo '<input type="submit" class="button" value="Submit"/>';
            echo '</select>';
            echo '</form>';
            
        }
    ?>
</body>
</html>
