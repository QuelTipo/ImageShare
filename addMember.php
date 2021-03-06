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
    $existsQ = $conn->query('call users_usernameTaken("' . $username . '")');
    $temp = $existsQ->fetchAll();
    $userExists = $temp[0][0];
    $existsQ->closeCursor();
    
    print_r($userExists);
    echo '<br>';
    
    if($userExists == 0)
    {
        echo '<script>alert("the specified user does not exist");window.location.replace("group.php?group=' . $group . '");</script>';
        $isAdmin = false;
    }
    
    if($isAdmin)
    {
        $addQ = $conn->prepare('call groups_addMember(:username, :groupId)');
        $addQ->execute( array(
                ':username' => $username,
                ':groupId' => $group));
        $addQ->closeCursor();
        
    }
    if($userExists == 1)
    {
        header('location: group.php?group=' . $group);
    }

} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>