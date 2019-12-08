<?php
session_start();
if(!isset($_SESSION['Alogin']))
    {
        echo "<script type='text/javascript'>alert('Please Login!');
             window.location.href='../login.php'
          </script>";
    }
    else{
        if(isset($_POST['postusn'])){
            $host = "localhost";
            $user="root";
            $password="";
            $db="project_portal";
            $conn = mysqli_connect($host,$user,$password,$db);
            $del_sql = "DELETE FROM WORKS_ON WHERE USN='".$_POST['postusn']."'";
            $conn->query($del_sql);                                       
            unset($_POST['postname']);
            header('location: modifyStudentTeam.php');                                    
        }
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
        <script src="../../js/jquery-3.4.1.min.js"></script>
        <script src="../../js/approval_req.js"></script>
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
                            <a href="#" id="side5">Approve Team Changes</a>
                            <a href="modifyProjects.php" id="side6">Modify Projects</a>
                            <a href="modifystudent.php" id="side7">Modify Student</a>
                        </div>                  
                    </div>
                </div>
                <div class="col-md-9" style="background-color: rgba(0,0,0,0.5)">
                <div class="contain_in">
                         <input type="text" id="myInput_1" onkeyup="myFunction(this.id,'myTable_1')" placeholder="Search for Project names.." >
                    </div>
                    <div class="scrollit">
                        <table id="myTable_1">
                            <tr style="text-align:center;font-size: 18px;width:100%;">
                                <th> SL.NO</th>
                                <th> USN <button onclick="sortTable_0('myTable_1')">↑</button><button onclick="sortRTable_0('myTable_1')">↓</button> </th>
                                <th> Student Name <button onclick="sortTable_1('myTable_1')">↑</button><button onclick="sortRTable_1('myTable_1')">↓</button> </th>
                                <th> Project ID <button onclick="sortTable_2('myTable_1')">↑</button><button onclick="sortRTable_2('myTable_1')">↓</button></th>
                                <th> Project Name <button onclick="sortTable_2('myTable_1')">↑</button><button onclick="sortRTable_2('myTable_1')">↓</button></th>
                                <th> Action </th>
                            </tr>

                            <?php
                                        $host = "localhost";
                                        $user="root";
                                        $password="";
                                        $db="project_portal";                
                                        $conn = mysqli_connect($host,$user,$password,$db);
                                        $sql = "select s.usn,s.name,p.project_id,p.project_name FROM projects p,student s,works_on w WHERE w.usn = s.usn and w.project_id = p.project_id and w.request = 'YES'";
                                        $result = $conn->query($sql);
                                        $sl_no_p = 1;
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr><td>".$sl_no_p."</td><td>".$row['usn']."</td><td>".$row['name']."</td><td>".$row['project_id']."</td><td>".$row['project_name']."</td><td><input type='button' id='".$row['usn']."' value='Approve' class='btn btn-primary' onClick='approve_change(id)'></td></tr>";
                                            $sl_no_p++;
                                        }
                            ?>
                        </table>
                    </div>
                </div>
            </div>    
        </div>
    </body>
</html>
