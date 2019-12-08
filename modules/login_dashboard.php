<?php
	session_start();
	session_destroy();
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login | Project Portal</title>
		<link rel="icon" href="../img/BMSIT_1.ico">
		<link rel="stylesheet" type="text/css" href="../css/a11.css">
	</head>

	<body>
		<div class="container">
			<div class="card">
				<div class="face face1">
					<div class="content">
						<img src="../img/Admin.png" id="img1">
						<h3 id="t">ADMINISTRATOR</h3>	
					</div>	
				</div>
				<div class="face face2">
					<div class="content">
						<p>The Admin Page gives access to exclusive editing features for the system. Click below and login to add new projects, change project status and much more!   
						</p>	
						<a href='login.php'>Login Here</a>
					</div>	
				</div>
				</div>
			<div class="card" >
				<div class="face face1">
					<div class="content">
					<img src="../img/Student.png" id="img2">
						<h3>STUDENT</h3>	
					</div>	
				</div>
				<div class="face face2">
					<div class="content">
						<p>The Student Page gives an interface to select a project and view team mates. Click below and login to choose your project! </p>	

						<a href='slogin.php'>Login Here</a> 
                                   
                                                   
					</div>
				</div>
		 </div>


		</div>

	</body>
</html>

