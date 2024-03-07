<?php
    include('auth/connection.php');
    $conn= connect();

    $user= $_POST['username'];

    $sql= "SELECT * FROM user_login WHERE username='$user'";
    $flag= $conn->query($sql);

    $retData['success']= false;
    if(mysqli_num_rows($flag)>0){
        $retData['success']= true;
    }
    echo json_encode($retData);
?>