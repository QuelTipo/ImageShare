<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<link rel="stylesheet" href="css/site.css">
<link rel="stylesheet" href="css/image.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<title>ImageShare</title>
</head>

<body>
    <?php include 'menu.php'
    ?>
    <div class="my-centre">
        <div class="container">
            
            <div class="col-lg-12">
                <?php
                try
                {
                    $conn = new PDO('mysql:host=localhost;dbname=imageshare', 'imageshare', 'sharemeplease!@#');
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $id = filter_input(INPUT_GET,'id');
                    
                    if(isset($_POST['tText']))
                    {
                        $ttext = filter_input(INPUT_POST, 'tText');
                        $user = $_SESSION['user'];
                        $stmt = $conn->prepare('call media_addComment( :id, :user, :ttext)');
                        $stmt->execute(array(
                            ':id' => $id,
                            ':user' => $user,
                            ':ttext' => $ttext
                          ));
                        
                        header('location /ImageShare/image.php?id=' . $id);
                    }
                    
                    $imageCommand = $conn->query('call media_getInfoByPk( ' . $id . ')');
                    
                    $imageInfo = $imageCommand->fetchAll()[0];
                   
                    $imageCommand = null;
                    
                    $commentCommand = $conn->query('call media_getCommentsByPk( ' . $id . ')');
                    
                    $allComments = $commentCommand->fetchAll();
                    
                    $commentCommand = null;
                    
                } catch(PDOException $e) {
                    echo 'ERROR: ' . $e->getMessage();
                }
                ?>
                <h1 class="page-header"><?php echo $imageInfo['title'] ?></h1>
            </div>    
            <div class="col-lg-12">
            	<div class="panel panel-default">
                    <div class="panel-body">
                    	<div class="row text-center">
                            <div align="center">    
                            <?php 
                                if ($imageInfo['flag'] == 1) {
                                    echo '<video controls ';
                                } elseif ($imageInfo['flag'] == 0) {
                                    echo '<img ';
                                }
                                echo 'class="img-responsive" src="Pictures/' . $imageInfo['owner_name'] . '/' . $imageInfo['filename'] . '" alt="">';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="caption">
                        <p>
                            <?php echo $imageInfo['description'] ?>
                        </p>
                        <div class="info">
                            <p>
                                Taken by: <a href="profile.php?user=<?php echo $imageInfo['username'] ?>"><?php echo $imageInfo['displayname'] ?></a><br>                                
                                Added on <?php echo date('F jS\, Y', strtotime(str_replace('-','/', $imageInfo['upload_date'])))?></br>
                                Resolution: <?php echo $imageInfo['height'] . 'x' . $imageInfo['width'] ?>
                                <a href="#" class="pull-right"><?php echo $imageInfo['manufacturer'] . ' ' . $imageInfo['model'] ?></a><br>
                                <a href="#" class="pull-right"><?php echo $imageInfo['location'] ?></a>
                                <?php if($imageInfo['album_id'] != null) { ?>
                                    Part of album: <a href="album.php?album=<?php echo $imageInfo['album_id']?>"><?php echo $imageInfo['album_title'] ?></a>
                                <?php } else { ?>
                                    <br>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="panel panel-default">
                	<div class="panel-heading">
                        <h4>Comments</h4>
                    </div>
                	<div class="panel-body">
                       	<ul class="list-unstyled">
                            <?php foreach($allComments as $comment) { ?>
                            <li>
                                <div class="col-lg-10">
                                    <b>
                                        <?php 
                                        if (empty($comment['username'])) { 
                                            echo 'anonymous:';
                                        } else {
                                            echo '<a href="profile.php?user=' . $comment['username'] . '"> ' . $comment['username'] . ' </a>:';
                                        }
                                        ?>
                                    </b><?php echo $comment['tText'] ?>
                                </div>
                                <div class="col-lg-2">
                                    <span class="pull-right"><small><?php echo date('F jS\, Y', strtotime(str_replace('-','/', $comment['comment_date'])))?></small></span>
                                </div>
                            </li>
                            <br>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                
                <div class="panel panel-default">
                	<div class="panel-heading">
                        <h4>Add new comment</h4>
                    </div>
                	<div class="panel-body">
                       	<form action="#" method="post">
                        	<textarea name="tText" class="form-control no-resize-ta" rows="5"></textarea>
                            <button class="btn btn-default pull-right">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>