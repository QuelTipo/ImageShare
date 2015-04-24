<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
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
        <?php include("menu.php"); 
            if (!isset($_SESSION['user']))
            {
                header('location:index2.php');
            }
            
            try
            {
                $conn = new PDO('mysql:host=localhost;dbname=imageshare', 'imageshare', 'pass');
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $locationQuery = $conn->query('call location_getAll()');

                $allLocations = $locationQuery->fetchAll();
                
                $locationQuery->closeCursor();
                
                $cameraQuery = $conn->query('call camera_getAll()');
                
                $allCameras = $cameraQuery->fetchAll();
                
                $cameraQuery->closeCursor();

            } catch(PDOException $e) {
                echo 'ERROR: ' . $e->getMessage();
            }
        ?>
        <div class="my-centre">
            <div class="container">
                <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Upload a new file
                            </div>
                            <div class="panel-body">
                                <form action="upload2.php" method="post" enctype="multipart/form-data">
                                    File title:<input type="text" name="title"><br>
                                    <input type="file" name="fileToUpload" id="fileToUpload"><br>
                                    File size:<input type="text" name="width" placeholder="width">x<input type="text" name="height" placeholder="height"><br>
                                    Description:<input type="text" name="description"><br>
                                    Private: <input type="checkbox" name="private"><br>
                                    Camera:<select name="camera">
                                        <?php
                                        foreach($allCameras as $camera)
                                        {
                                            echo '<option value="' . $camera['model'] . '--' . $camera['manufacturer'] . '">' . $camera['manufacturer'] . ' ' . $camera['model'] . '</option>';
                                        }
                                        ?>
                                    </select><br>
                                    Location: <select name="location">
                                        <?php
                                        
                                        foreach($allLocations as $aLocation)
                                        {
                                            echo '<option value="' . $aLocation['longitude'] . '--' . $aLocation['latitude'] . '">' . $aLocation['description'] . '</option>';
                                        }
                                        ?>
                                    </select><br>
                                    Type:<select name="flag">
                                        <option value="0">Image</option>
                                        <option value="1">Video</option>
                                    </select><br>
                                    Extension:<input type="text" name="extraparam1"><br>
                                    <input type="submit" value="Upload Media" name="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
