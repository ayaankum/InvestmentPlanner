<?php
    session_start();
    session_destroy();
    header('Location: login.php');
    echo '<script>alert("Logged out")</script>';
?>

