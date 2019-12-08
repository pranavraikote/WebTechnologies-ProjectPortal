<?php
            $host = "localhost";
            $user="root";
            $password="";
            $db="project_portal";
            $USN = $_POST['usn'];
            $conn = mysqli_connect($host,$user,$password,$db);
            $sql = 'SELECT S.NAME FROM STUDENT S,WORKS_ON W WHERE S.USN = W.USN AND W.USN = '.$USN.'';;
            $result = mysqli_query($sql);
            if (mysqli_num_rows($result)==0) {
                
            }

?>