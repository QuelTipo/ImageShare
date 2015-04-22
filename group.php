

<!DOCTYPE html>
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
    <?php 
        include 'menu.php';
        $id = filter_input(INPUT_GET, 'group');
        $isAdmin = false;
        $isMember = false;

        $allMembers;
        $allAlbums;
        $groupInfo;
        $allMedia;
        
        try
        {
            $conn = new PDO('mysql:host=localhost;dbname=imageshare', 'imageshare', 'sharemeplease!@#');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if(isset($_SESSION['user']))
            {
                $adminQ = $conn->prepare('call groups_isAdmin( :user , :groupid , @isAdmin_res)');
                $adminQ->bindParam(':user', $_SESSION['user']);
                $adminQ->bindParam(':groupid', $id);
                $adminQ->execute();
                $adminQ->closeCursor();
                
                $temp = $conn->prepare('select @isAdmin_res as res');
                $temp->execute();
                $isAdmin = $temp->fetchColumn();
                
                $temp->closeCursor();

                $isMemberQ = $conn->prepare('call groups_isMember( :user , :groupid , @isMember_res)');
                $isMemberQ->bindParam(':user', $_SESSION['user']);
                $isMemberQ->bindParam(':groupid', $id);
                $isMemberQ->execute();
                $isMemberQ->closeCursor();
                
                $temp = $conn->prepare('select @isMember_res as res');
                $temp->execute();
                $isMember = $temp->fetchColumn();
                
                $temp->closeCursor();
            }

            $memberQ = $conn->query('call groups_getMembers(' . $id . ')');
            $allMembers = $memberQ->fetchAll();
            $memberQ->closeCursor();

            $albumQ = $conn->query('call groups_getAlbums(' . $id . ',' . (($isMember) ? 'true' : 'false') . ')');
            $allAlbums = $albumQ->fetchAll();
            $albumQ->closeCursor();

            $groupInfoQ = $conn->query('call groups_getByPk(' . $id . ')');
            $groupInfo = $groupInfoQ->fetchAll()[0];
            $groupInfoQ->closeCursor();
            
            $mediaQ = $conn->query('call groups_getMedia(' . $id . ',' . (($isMember) ? 'true' : 'false') . ')');
            $allMedia = $mediaQ->fetchAll();
            $mediaQ->closeCursor();
            
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }

        function get_groupMemberList()
        {
            global $allMembers; global $isAdmin; global $id;
            foreach ($allMembers as $curMember)
            {
                echo '<li>';
                    echo '<a href="profile.php?user=' . $curMember['username'] . '">' . $curMember['displayname'] . '</a>';
                    if($isAdmin)
                    {
                        echo '<a href="removeMember.php?group=' . $id . '&user=' . $curMember['username'] . '" class="pull-right">remove</a>';
                    }
                echo '</li>';
            }
            if($isAdmin)
            {
                echo '<form action="addMember.php" method="post">';
                    echo '<input type="submit" name="submit" value="Add Member">';
                    echo '<input type="text" placeholder="username" name="user">';
                    echo '<input type="text" hidden name="group" value="' . $id . '">';
                echo '</form>';
            }
        }
       
        function get_albumList()
        {
            global $allAlbums;
            foreach ($allAlbums as $curAlbum)
            {
                echo '<li>';
                    echo '<a href="album.php?album=' . $curAlbum['ID'] . '">' . $curAlbum['title'] . '</a>';
                echo '</li>';
            }
        }

        function get_imageList()
        {
            global $allMedia;
            foreach ($allMedia as $curMedia)
            {
                echo '<div class="panel panel-default">';
                    echo '<div class="panel-heading">';
                        echo '<h3>' . $curMedia['title'] . '</h3>';
                    echo '</div>';
                    echo '<div class="panel-body">';
                        echo '<div class="row text-center">';
                                if ($curMedia['flag'] == 1) {
                                    echo '<video controls ';
                                } elseif ($curMedia['flag'] == 0) {
                                    echo '<img ';
                                }
                                echo 'class="img-responsive" src="Pictures/' . $curMedia['owner_name'] . '/' . $curMedia['filename'] . '" alt="">';
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="caption">';
                        echo '<div>';
                            echo $curMedia['description'];
                        echo '</div>';
                        echo '<div class="text-right">';
                            echo '<a href="#">Cannon Powershot</a><br>';
                            echo '<a href="#">Calgary, Alberta Canada</a>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }
        }

        ?>
    <div class="my-centre">
        <div class="container">
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo $groupInfo['group_name'] ?></h1>
            </div>
            
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Members
                    </div>
                    <div class="panel-body">
                        <ul>
                            <?php get_groupMemberList(); ?>
                        </ul>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Albums
                    </div>
                    <div class="panel-body">
                        <ul>
                            <?php get_albumList(); ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
            	<?php get_imageList(); ?>
            </div>
            
        </div>
    </div>
</body>
</html>
