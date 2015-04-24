<?php
include 'menu.php';
$username = filter_input(INPUT_POST,'user');
$group = filter_input(INPUT_POST,'group');

try {
    $conn = new PDO('mysql:host=localhost;dbname=imageshare', 'imageshare', 'pass');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $isAdmin = false;
    
    if(isset($_SESSION['user']))
    {
        $adminQ = $conn->prepare('call groups_isAdmin( :user , :groupid , @isAdmin_res)');
        $adminQ->bindParam(':user', $_SESSION['user']);
        $adminQ->bindParam(':groupid', $group);
        $adminQ->execute();
        $adminQ->closeCursor();

        $temp = $conn->prepare('select @isAdmin_res as res');
        $temp->execute();
        $isAdmin = $temp->fetchColumn();
        $temp->closeCursor();
    }
    
    if($isAdmin)
    {
        $private = false;
        if(isset($_POST['private']))
        {
            $private = true;
        }
        $addQ = $conn->prepare('call groups_createAlbum(:title, :private, :groupID)');
        $addQ->execute( array(
                ':title' => filter_input(INPUT_POST, 'title'),
                ':private' => $private ? 'true' : 'false',
                ':groupID' => filter_input(INPUT_POST, 'group')));
        $addQ->closeCursor();
        
    }
    header('location: group.php?group=' . $group);

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>