<?php
include 'menu.php';
$groupName = filter_input(INPUT_POST,'group_name');

print_r($_POST);

try {
    $conn = new PDO('mysql:host=localhost;dbname=imageshare', 'imageshare', 'sharemeplease!@#');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if(isset($_SESSION['user']))
    {
        echo 'here';
        $addQ = $conn->query('call groups_newGroup( \'' . $_SESSION['user'] .  '\',\'' . $groupName . '\')');
        $newGroupId = $addQ->fetchAll()[0][0];
        $addQ->closeCursor();
        
        $addMemQ = $conn->prepare('call groups_addMember(:username, :groupId)');
        $addMemQ->execute( array(
                ':username' => $_SESSION['user'],
                ':groupId' => $newGroupId));
        $addMemQ->closeCursor();
    }
    header('location: profile.php?user=' . $_SESSION['user']);

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>