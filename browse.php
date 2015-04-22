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
    <?php include 'menu.php' ?>
    <div class="my-centre">
        <div class="container">
            <div class="col-lg-12">
                <h1 class="page-header">Most Recent</h1>
            </div>

            <?php
                try {
                    $conn = new PDO('mysql:host=localhost;dbname=imageshare', 'imageshare', 'sharemeplease!@#');
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $page = filter_input(INPUT_GET,'page');
                    
                    $maxCmd = $conn->query("call media_getMaxPage()");
                    $maxPage = $maxCmd->fetchAll()[0][0];
                    if($maxPage < $page)
                    {
                        $page = $maxPage;
                    }
                    
                    if ($page <= 0)
                    {
                        $page = 1;
                    }
                    
                    $maxCmd = null;
                    
                    $command = $conn->query("call media_getRecent( " . $page . " )");
                    $all = $command->fetchAll();

                    $i = 0;
                    foreach($all as $aThumb) { ?>
                        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                            <a class="thumbnail" href="<?php echo 'image.php?id=' . $aThumb['ID'];?>">
                                <?php 
                                if ($aThumb['flag'] == 1) {
                                    echo '<video ';
                                } elseif ($aThumb['flag'] == 0) {
                                    echo '<img ';
                                }
                                echo 'class="img-responsive my-thumb" src="Pictures/' . $aThumb['owner_name'] . '/' . $aThumb['filename'] . '" alt="">';
                                ?>
                                
                            </a>
                        </div>
                    <?php $i++;
                    }
                } catch(PDOException $e) {
                    echo 'ERROR: ' . $e->getMessage();
                }
                ?>
            <nav>
                <div class="row span12">
                    <ul class="pager">
                        <li class="previous">
                            <?php 
                                if ($page > 1)
                                {
                                    echo '<a href="browse.php?page=' . ($page - 1) . '">';
                                } else
                                {
                                    echo '<a href="#">';
                                }
                            ?>
                                <span aria-hidden="true">&larr;</span> Newer</a></li>
                        <li class="next">
                            <?php 
                                if ($page >= $maxPage)
                                {
                                    echo '<a href="#">';
                                } else
                                {
                                    echo '<a href="browse.php?page=' . ($page + 1) . '">';
                                }
                            ?>
                            Older <span aria-hidden="true">&rarr;</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</body>
</html>
