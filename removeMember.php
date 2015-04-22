<?php
include 'menu.php';
$username = filter_input(INPUT_GET,'user');
$group = filter_input(INPUT_GET,'group');

try {
    $conn = new PDO('mysql:host=localhost;dbname=imageshare', 'imageshare', 'sharemeplease!@#');
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
    }
    
    
    if($isAdmin)
    {
        $deleteQ = $conn->prepare('call groups_removeMember(:username, :groupId)');
        $deleteQ->execute( array(
                ':username' => $username,
                ':groupId' => $group));
        $deleteQ->closeCursor();
    }
    
    header('location: group.php?group=' . $group);

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>