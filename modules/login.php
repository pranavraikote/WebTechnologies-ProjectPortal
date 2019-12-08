<?php
    try{
     session_start();
     session_destroy();
    }
     catch(Exception $e){
        echo "$e";
    }
?>
<html>
<head>
    <link rel="icon" href="../img/BMSIT_1.ico">
    <title>Admin | Project Portal</title>

    <link rel="stylesheet" type="text/css" href="../css/logincss.css">
    
    <style>
        .a1{
            position: absolute;
            right: 80px;
            }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-md-12">
            <div class ="container_cust"><p><a class="a1" href="login_dashboard.php"><img style="width:67px;height:67px;" src="../img/back.png"></a></p></div>
        </div>
    </div>
    <div class="loginbox">
      <img src="../img/avatar.png" class="avatar">
        <h1>Admin Login</h1>
        <form method="POST" action ="verify_login.php" id="form">
            <p>Username</p>
            <input type="text" name="username" placeholder="Enter Username">
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter Password">
            <input type="submit" name="" value="Login">
        </form>
     </div>

</body>
</head>
</html>