
<html>
<head>
<link rel="icon" href="../img/BMSIT_1.ico">
<title>Student | Project Portal</title>
    <?php 
        session_start();
        @session_destroy();
    ?>
    <link rel="stylesheet" type="text/css" href="../css/logincss.css">
    <style>
        .a1{
            position: absolute;
            right: 80px;
            }
    </style>

<body>
<div class="row">
        <div class="col-md-12">
            <div class ="container_cust"><p><a class="a1" href="login_dashboard.php"><img style="width:67px;height:67px;" src="../img/back.png"></a></p></div>
        </div>
    </div>
    <div class="loginbox">
      <img src="../img/avatar.png" class="avatar">
        <h1>Student Login</h1>
        <form method="POST" action ="sverify_login.php" id="form">
            <p>USN</p>
            <input type="text" name="susername" placeholder="Enter USN">
            <p>Password</p>
            <input type="password" name="spassword" placeholder="Enter Password">
            <input type="submit" name="" value="Login" id="login">
        </form>
     </div>

</body>
</head>
