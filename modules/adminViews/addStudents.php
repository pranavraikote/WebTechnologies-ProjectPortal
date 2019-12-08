<?php
session_start();
if(!isset($_SESSION['Alogin']))
    {
        echo "<script type='text/javascript'>alert('Please Login!');
             window.location.href='../login.php'
          </script>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Admin </title>
        <link rel="icon" href="../../img/BMSIT_1.ico">
        <link rel="stylesheet" type="text/css" href="../../css/admin_dash.css">
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../../css/bootstrap-table.css">
        <link rel="stylesheet" type="text/css" href="../../css/viewforadmin.css">
        <link rel="stylesheet" type="text/css" href="../../css/button_input.css">
        
    </head>
    <body>
            
    <?php
        try{
            if(isset($_POST['student_email'])) {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "project_portal";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $student_usn = $_POST['student_usn'];
                $student_name = $_POST['student_name'];
                $student_email = $_POST['student_email'];
                $student_pass = $_POST['student_pass'];
                $sql = "insert into student VALUES ('$student_usn','$student_name','$student_email','$student_pass')";

                if ($conn->query($sql) === TRUE) {

                    echo '<script type="text/javascript">
                    function clear_entry()
                    {
                        document.getElementById("pid").innerHTML="";
                        document.getElementById("pname").innerHTML="";
                        document.getElementById("sid").innerHTML="";
                        document.getElementById("spid").innerHTML="";
                    }
                    alert("New record created successfully");
                    clear_entry();
                    </script>';
                

                } else {
                    echo '<script type="text/javascript">
                        alert("Error: " . $sql . "<br>" . $conn->error);
                    </script>';
                }

                $conn->close();
            }
        }
        catch(Exception $e){
            
        }
    ?>
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">
                            <div class ="container_cust"><p>Welcome Admin <a class="a1" href="../login.php"><img style="width:67px;height:67px;" src="../../img/back.png"></a></p></div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="container_2">     
                        <div id="mySidenav" class="sidenav">
                            <a href="viewProjects.php" id="side1">View Projects</a>
                            <a href="viewStudents.php" id="side2">View Students</a>
                            <a href="addProjects.php" id="side3">Add Projects</a>
                            <a href="#" id="side4">Add Students</a>
                            <a href="modifyStudentTeam.php" id="side5">Approve Team Changes</a>
                            <a href="modifyProjects.php" id="side6">Modify Projects</a>
                            <a href="modifystudent.php" id="side7">Modify Student</a>
                        </div>                  
                    </div>
                </div>
                <div class="col-md-9" style=" height:600px;text-align: center;">
                    <div class="loginbox">
                        <h3 class="h3_pclass">Student Entry</h3>
                        <form method="POST" id="project_form" action="addStudents.php">
                           <input type="text" placeholder="Enter USN" name="student_usn" id="pid"/><br><br>
                           <input type="text" placeholder="Enter Name" name="student_name" id="pname"/><br><br>
                           <input type="text" placeholder="Enter Email ID" name="student_email" id="sid"/><br><br>
                           <input type="password" placeholder="Enter New Password" name="student_pass" id="spid"/><br><br>
                            <input type="submit" class="input_btn"/>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </body>
</html>
