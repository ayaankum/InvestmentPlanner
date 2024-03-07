<?php
include 'auth/connection.php';
$conn = connect();
$m = '';
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $uName = $_POST['uname'];
    $email = $_POST['email'] ? $_POST['email'] : '';
    $pass = $_POST['pass'];
    $rPass = $_POST['r_pass'];
    if ($pass === $rPass) {
        $sq = "INSERT INTO user_login (name, username, email, password) VALUES('$name', '$uName', '$email', '$pass')";
        if ($conn->query($sq) === true) {
            header('Location: login.php');
        } else {
            $m = 'Connection not established!';
        }
    } else {
        $m = "Passwords don't match!";
    }
}

?>

<html>

<head>
    <title> Sign Up </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <link type="text/css" rel="stylesheet" href="css/register.css">
</head>

<body>
    <form method="POST" action="register.php">
        <div class="container reg">

            <span><?php if ($m != '') echo $m; ?></span>
            <h1>Sign Up</h1>
            <hr>
            <div>
                <label><b> Your Name </b><span>*</span></label>
                <input name="name" id="name" type="text" placeholder="Enter Your Name" required>
            </div>
            <div>
                <label><b> Your Username </b><span>*</span></label>
                <input name="uname" id="uname" type="text" placeholder="Enter Your Username" onchange="checkUser(this.value);" required>
                <small id="checktext"></small>
                <small id="checkuser"></small>
            </div>
            <div>
                <br>
                <label><b> Your Email </b><span>*</span></label>
                <input name="email" id="email" type="text" placeholder="Enter Your Email">
            </div>
            <div>
                <label><b> Enter Password </b><span>*</span></label>
                <input name="pass" id="pass" type="password" placeholder="Enter Your Password" required>
            </div>
            <div>
                <label><b> Confirm Password </b><span>*</span></label>
                <input name="r_pass" id="rpass" type="password" placeholder="Confirm your password" required>
            </div>
            <div style="text-align: center">
                <p>Disclaimer: By creating an account, you are agreeing to our terms of service.</p>
            </div>
            <div style="text-align: center; padding: 15px;">
                <input type="submit" class="btn btn-success" value="Submit" name="submit">
            </div>

            <div style="text-align: center">
                <p>Already have an account? <a href="login.php">Sign in</a></p>
            </div>
        </div>
    </form>
</body>
<script type="text/javascript" src="js/script.js"></script>

</html>


<script>
    $(document).ready(function() {
        $('.reg').css('color', '#ffce00');
        //document.getElementsByClassName('reg')[0].style.color='#ffce00';
    });
    /*window.onload= function(){
          document.getElementsByClassName('reg')[0].style.color='#ffce00';
    };
    *?
     */
</script>