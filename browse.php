<?php

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<link rel="stylesheet" href="css/site.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<title>ImageShare</title>
</head>

<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="my-centre collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        	<div class="navbar-header">
      			<a class="navbar-brand" href="#">ImageShare</a>
            </div>
      		<ul class="nav navbar-nav">
        		<li><a href="#">Home</a></li>
        		<li class="active"><a href="#">Browse</a></li>
      		</ul>
            <ul class="nav navbar-nav navbar-right">
            	<li><a href="#">Log In</a></li>
            </ul>
        </div>
	</nav>
    <div class="my-centre">
        <div class="container">
            <div class="col-lg-12">
                <h1 class="page-header">Most Recent</h1>
            </div>

            <?php
                try {
                    $conn = new PDO('mysql:host=localhost;dbname=imageshare', 'root', 'pass');
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $page = $_GET["page"];
                    if ($page <= 0)
                        $page = 1;
                    $command = $conn->query("call media_getRecent( " . $page . " )");

                    $all = $command->fetchAll();

                    $i = 0;
                    foreach($all as $aThumb) { ?>
                        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                            <a class="thumbnail" href="<?php echo '"/image.php?id=' . $aThumb['ID'];?>">
                                <img class="img-responsive my-thumb" src="Pictures/<?php echo $aThumb['owner_name'] . '/' . $aThumb['filename']?>" alt="">
                            </a>
                            <?php echo $aThumb['ID'] ?>
                        </div>
            <?php       $i++;
                    }
                } catch(PDOException $e) {
                    echo 'ERROR: ' . $e->getMessage();
                }
            ?>
            <nav>
                <div class="row span12">
                    <ul class="pager">
                        <li class="previous"><a href="#"><span aria-hidden="true">&larr;</span> Newer</a></li>
                        <li class="next"><a href="#">Older <span aria-hidden="true">&rarr;</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</body>
</html>
