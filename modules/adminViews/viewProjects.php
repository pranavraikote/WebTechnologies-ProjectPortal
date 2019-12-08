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
                            <a href="#" id="side1">View Projects</a>
                            <a href="viewStudents.php" id="side2">View Students</a>
                            <a href="addprojects.php" id="side3">Add Projects</a>
                            <a href="addStudents.php" id="side4">Add Students</a>
                            <a href="modifyStudentTeam.php" id="side5">Approve Team Changes</a>
                            <a href="modifyProjects.php" id="side6">Modify Projects</a>
                            <a href="modifystudent.php" id="side7">Modify Student</a>
                        </div>                  
                    </div>
                </div>
                <div class="col-md-9" style="background-color: rgba(44, 62, 80,0.79); height:600px;">
                    <div class="contain_in">
                         <input type="text" id="myInput_1" onkeyup="myFunction(this.id,'myTable_1')" placeholder="Search for Project names.." >
                         <input type="submit" id="pdf" class="btn btn-primary" style="margin:20px;" value="PDF" onclick="window.open('report.php')"/>
                    </div>
                    <div class="scrollit">
                        <table id="myTable_1">
                            <tr>
                                <th>SL.NO</th>
                                <th>Project ID <button onclick="sortTable_0('myTable_1')">↑</button><button onclick="sortRTable_0('myTable_1')">↓</button> </th>
                                <th> Project Title <button onclick="sortTable_1('myTable_1')">↑</button><button onclick="sortRTable_1('myTable_1')">↓</button> </th>
                                <th> Subject Code <button onclick="sortTable_2('myTable_1')">↑</button><button onclick="sortRTable_2('myTable_1')">↓</button></th>
                            </tr>

                            <?php
                                        $host = "localhost";
                                        $user="root";
                                        $password="";
                                        $db="project_portal";                
                                        $conn = mysqli_connect($host,$user,$password,$db);
                                        $sql = "SELECT * FROM projects";
                                        $result = $conn->query($sql);
                                        $sl_no_p = 1;
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr><td>".$sl_no_p."</td><td>".$row["project_id"]."</td><td>".$row["project_name"]."</td><td>".$row["subject_code"]."</td></tr>";
                                            $sl_no_p++;
                                        }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
    </body>
    <script src="../../js/viewStudents.js"></script>
</html>
