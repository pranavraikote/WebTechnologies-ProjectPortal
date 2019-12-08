<?php
$host = "localhost";
$user="root";
$password="";
$db="project_portal";

$conn = mysqli_connect($host,$user,$password,$db);
//mysql_select_db($db);

if(isset($_POST['susername'])) {
	$uname = $_POST['susername'];
	$password=$_POST['spassword'];
	unset($_SESSION['student']);
	$sql="select usn,name from student where usn='".$uname."' AND password='".$password."' LIMIT 1";

	$result = $conn->query($sql);

	if(mysqli_num_rows($result)==1){
		//echo "<h1>Logged in Successfully<h1>";
		session_start();
		$nn = $result->fetch_assoc();
		$_SESSION['student'] = array($nn['name'],$nn['usn']);
		$_SESSION['usn'] = $nn['usn'];
		#echo " NAMe  ".$nn['name']." ";
		header('location: student.php');
	}
	else{
		echo "<script type='text/javascript'> alert('Invalid Credentials');window.location = 'slogin.php';</script>";
		
		
	}
}

?>
