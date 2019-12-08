
	<!DOCTYPE html>
	<html>
	<head>
	<link rel="icon" href="../img/BMSIT_1.ico">
		<title> Student </title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
				
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../css/studentstyle.css">
		<link rel="stylesheet" type="text/css" href="../css/logincss.css">
		<link rel="stylesheet" type="text/css" href="../css/admin_dash.css">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap-table.css">
		<link rel="stylesheet" type="text/css" href="../css/viewforadmin.css">
		<link rel="stylesheet" type="text/css" href="../css/button_magic.css">
		<script type="text/javascript" src="../js/viewStudents.js"></script>	
	
	</head>
	
	<?php
		session_start();
		if(!isset($_SESSION['student'])){
			echo "<script>alert('PLEASE LOGIN!');</script>";
			header("location: slogin.php");
		}
		else{
			$na = $_SESSION['student'][0];
		}
		$host = "localhost";
		$user="root";
		$password="";
		$db="project_portal";
		$conn = mysqli_connect($host,$user,$password,$db);
		if(isset($_POST['change_btn_req'])){
			$update_sql = "UPDATE works_on SET request='YES' WHERE usn = '".$_SESSION['usn']."'";
			$conn->query($update_sql);
		}
		$result = $conn->query("select w.project_id from works_on w,student s where s.usn=w.usn and s.name='".$na."' LIMIT 1;");
		if(@mysqli_num_rows($result)==1){
			$in_project = TRUE;
			while($row = $result->fetch_assoc())
				$proj_id = $row["project_id"];
		}
		else{
			$in_project = FALSE;
		}
	?>

	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-8">
					<div class="h1_custom">
						<h1>
							Welcome to your Student Portal 
							<br>
							<?php echo $na; ?>
						</h1>
						<br>
						<img src="../img/img.png"/>		
					</div>
				</div>
				<div class="col-md-2">
					<a href="slogin.php"><img style="margin-top:30px;width:67px;height:67px;" src="../img/back.png"></a>
				</div>
			</div>
			<br><br>
			<div class="row">
				<div class="col-md-12">
					<div class = "h_container">
						<?php
							if($in_project){
								echo "<hh class='h2_custom'><center>Your Project Details</center></hh>";
								$sql_p = "select s.usn,s.name,s.email,p.project_name,p.subject_code,w.request from student s,projects p,works_on w WHERE s.usn = w.usn and w.project_id = p.project_id and p.project_id =".$proj_id;
								$result = $conn->query($sql_p);
								$team_name = array();
								$team_usn = array();
								$team_email = array();
								while($row = $result->fetch_assoc()){
									array_push($team_usn,$row['usn']);
									array_push($team_name,$row['name']);
									array_push($team_email,$row['email']);
									$sub_code = $row['subject_code'];
									$req_status = $row['request'];
									$project_name = $row['project_name'];
								}

								$number_of_teammates = count($team_usn);
								echo "<div class='row'><div class='col-md-6'><div class='h3_custom'>Project ID :</div></div><div class='col-md-6'> <div class='h2_custom'> ".$proj_id."</div></div></div><br>";
								echo "<div class='row'><div class='col-md-6'><div class='h3_custom'>Project Name :</div></div><div class='col-md-6'> <div class='h2_custom'> ".$project_name."</div></div></div><br>";
								echo "<div class='row'><div class='col-md-6'><div class='h3_custom'>Subject Code  :</div></div><div class='col-md-6'> <div class='h2_custom'> ".$sub_code."</div></div></div>";
								if($req_status == "YES"){
									echo "<h3 class='h3_pclass'>Request is Being Processed</h3>";
								}
								else{
									echo "<form method='POST' action = ''><input type='submit' name='change_btn_req' class='btn_req_change' value='Request for Change' style='vertical-align:middle'></input></form>";
								}
								echo "<br><div class='h4_custom'>Details of your Team</div>";
								echo "<table class=''>";
									echo "<tr><th style='font-size: 30px;'>USN</th><th style='font-size: 30px;'>Name</th><th style='font-size: 30px;'>E-Mail</th></tr>";
									for($i=0;$i<$number_of_teammates;$i++){
										echo "<tr><td>".$team_usn[$i]."</td><td>".$team_name[$i];
										if($na==$team_name[$i]){
											echo "<img src='../img/you.png' style='margin-top:3px;margin-left:33px;width:37px;height:37px;'/>";
										}
										echo "</td><td>".$team_email[$i]."</td></tr>";
									}
								echo "</table>";
							}
							else{
								echo "<h1 class='h1_custom'>NOT YET IN A TEAM...PLEASE CHOOSE A PROJECT</h1>";
							}
						?>
					</div>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php
						if(!$in_project){
							include "student_available_projects.php";
						}
					?>
				</div>
			</div>
		</div>
	</body>
</html>
