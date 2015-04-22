<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
    <?php
        session_start();
        if(!isset($_SESSION['user'])){
            $_SESSION['user']=null;
        }
    ?>
       <nav class="navbar navbar-default navbar-fixed-top">
		<div class="my-centre collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        	<div class="navbar-header">
      			<a class="navbar-brand" href="index.php">ImageShare</a>
            </div>
      		<ul class="nav navbar-nav">
                        <?php
                            if($_SESSION['user']==null) {
                                echo '<li><a href="index.php">Home</a></li>';
                            } else {
                                echo '<li><a href="profile.php?user=' . $_SESSION['user'] . '">Home</a></li>';
                            }
                        ?>
                    <li><a href="browse.php?page=1">Browse</a></li>
                    <li><a href="upload.php">Upload</a></li>
      		</ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if($_SESSION['user']==null) {
                        echo '<li><a href="index2.php">Log In</a></li>';
                    } else {
                        echo '<li><a href="profile.php?user='.$_SESSION['user'].'">'.$_SESSION['user'].'</a></li>';
                    }
                ?>
            </ul>
        </div>
	</nav>
     
