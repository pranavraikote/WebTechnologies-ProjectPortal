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
    </head>
    <body>
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
                            <a href="addprojects.php" id="side3">Add Projects</a>
                            <a href="addStudents.php" id="side4">Add Students</a>
                            <a href="modifyStudentTeam.php" id="side5">Approve Team Changes</a>
                            <a href="#" id="side6">Modify Projects</a>
                            <a href="modifystudent.php" id="side7">Modify Student</a>
                        </div>                  
                    </div>
                </div>
                <div class="col-md-9" style="background-color:  rgba(44, 62, 80,0.7);">
                <div class="panel-heading text-center" style="background-color:  rgba(44, 62, 80,0.7);"><h3 class='student_view_header'> Projects in Database Catalog </h3> </div>
                <iframe src="Projects_stuff/index.php" width="101%" height="90%"></iframe>
            
            </div>    
        </div>
    </body>
</html>
