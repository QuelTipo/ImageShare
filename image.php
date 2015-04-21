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
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="my-centre collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        	<div class="navbar-header">
      			<a class="navbar-brand" href="#">ImageShare</a>
            </div>
      		<ul class="nav navbar-nav">
        		<li><a href="#">Home</a></li>
        		<li><a href="/browse.php?page=1">Browse</a></li>
      		</ul>
            <ul class="nav navbar-nav navbar-right">
            	<li><a href="#">Log In</a></li>
            </ul>
        </div>
	</nav>
    <div class="my-centre">
        <div class="container">
            <div class="col-lg-12">
                <h1 class="page-header">Image 1</h1>
            </div>    
            <div class="col-lg-12">
            	<div class="panel panel-default">
                    <div class="panel-body">
                    	<div class="row text-center">
                    		<img class="img-responsive" src="resources/292 - Df1htHM.jpg" alt="">
                        </div>
                    </div>
                    <div class="caption">
                        <p>
                            Cras at justo ipsum. Maecenas ultrices volutpat eros, vel consequat tellus. Ut iaculis pretium ultrices. Duis eleifend porta mi quis tempor. Praesent eu felis vel quam fringilla lobortis. Etiam ut finibus neque, semper dignissim lectus. Aliquam quis mollis velit, in porttitor odio. Mauris varius fringilla arcu, vel euismod turpis tincidunt vel. Vivamus eu elit sit amet eros dignissim venenatis a vitae odio.
                        </p>
                        <div class="info">
                            <p>
                                Taken by: <a href="#">Joe Shmoe</a><br>
                                Added on June, 13 2015</br>
                                Resolution: 1080x720
                                <a href="#" class="pull-right">Cannon Powershot</a><br>
                                <a href="#" class="pull-right">Calgary, Alberta Canada</a>
                                Part of album: <a href="#">Calgary At It's Finest</a>
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
                        	<li>
                                <div class="col-lg-10">
                                    <b><a href="#">Freddy K</a>:</b> I love this!
                                </div>
                                <div class="col-lg-2">
                                    <span class="pull-right"><small>June, 14 2015</small></span>
                                </div>
                            </li>
                            <br>
                            <li>
                                <div class="col-lg-10">
                                    <b><a href="#">Bobby Al</a>:</b> Vivamus tristique tempus quam, id finibus quam rutrum vitae. Ut eu risus lorem. Aenean commodo risus lacus. Curabitur arcu dolor, tincidunt non est et, rutrum vehicula neque. Nullam in sodales augue. Fusce finibus viverra iaculis. Praesent mollis auctor augue, a cursus elit tempor at. Nullam mi nunc, ultrices vitae ante ut, euismod aliquam libero.
                                </div>
                                <div class="col-lg-2">
                                    <span class="pull-right"><small>June, 15 2015</small></span>
                                </div>
                            </li>
                            <br>
                            <li>
                                <div class="col-lg-10">
                                    <b><a href="#">Willy Bill</a>:</b> The contrast is amazing
                                </div>
                                <div class="col-lg-2">
                                    <span class="pull-right"><small>June, 16 2015</small></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="panel panel-default">
                	<div class="panel-heading">
                        <h4>Add new comment</h4>
                    </div>
                	<div class="panel-body">
                       	<form action="#">
                        	<textarea class="form-control no-resize-ta" rows="5"></textarea>
                            <button class="btn btn-default pull-right">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>
