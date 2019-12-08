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
            if(isset($_POST['subject_code'])) {
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
                $project_id = $_POST['project_id'];
                $project_name = $_POST['project_name'];
                $subject_code = $_POST['subject_code'];
                $sql = "insert into projects VALUES ('$project_id','$project_name','$subject_code')";

                if ($conn->query($sql) === TRUE) {

                    echo '<script type="text/javascript">
                    function clear_entry()
                    {
                        document.getElementById("pid").innerHTML="";
                        document.getElementById("pname").innerHTML="";
                        document.getElementById("sid").innerHTML="";
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
                            <a href="#" id="side3">Add Projects</a>
                            <a href="addStudents.php" id="side4">Add Students</a>
                            <a href="modifyStudentTeam.php" id="side5">Approve Team Changes</a>
                            <a href="modifyProjects.php" id="side6">Modify Projects</a>
                            <a href="modifystudent.php" id="side7">Modify Student</a>
                        </div>                  
                    </div>
                </div>
                <div class="col-md-9" style=" height:600px;text-align: center;">
                    <div class="loginbox">
                        <h3 class="h3_pclass">Project Entry</h3>
                        <form method="POST" id="project_form" action="addProjects.php">
                           <input type="text" placeholder="Enter Project ID" name="project_id" id="pid"/><br><br>
                           <input type="text" placeholder="Enter Project Name" name="project_name" id="pname"/><br><br>
                           <input type="text" placeholder="Enter Subject Code" name="subject_code" id="sid"/><br><br><br><br>
                            <input type="submit" class="input_btn"/>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </body>
</html>
