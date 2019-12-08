<script type="text/javascript">
    function setSess(id){
        window.location.href="student.php?uid="+id;
    }
</script>
<style rel="stylesheet" type="text/css">
    th{
        
    }

</style>
<?php
    if(isset($_POST['sub_btn'])){
        $host = "localhost";
        $user="root";
        $password="";
        $db="project_portal";                
        $conn = mysqli_connect($host,$user,$password,$db);
        $usn_w = "'".$_SESSION['usn']."'";
        $project_id_chosen = "'".$_GET["uid"]."'";
        $sql_insert = "INSERT INTO works_on (usn,project_id) VALUES (".$usn_w.",".$project_id_chosen.");";
        if ($conn->query($sql_insert) === TRUE) {
            echo "<script>alert('Successfully Joined the Group');</script>";
            header('location: student.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
    }

?>
<h1 class="h1_custom">
	AVAILABLE PROJECTS
</h1>
<div class="scrollit_2">
	<form method="POST" >
		<table id="myTable_1">
			<tr>
				<th> Project ID <button onclick="sortTable_0('myTable_1')">↑</button><button onclick="sortRTable_0('myTable_1')">↓</button> </th>
				<th> Project Title <button onclick="sortTable_1('myTable_1')">↑</button><button onclick="sortRTable_1('myTable_1')">↓</button> </th>
				<th> Subject Code <button onclick="sortTable_2('myTable_1')">↑</button><button onclick="sortRTable_2('myTable_1')">↓</button></th>
                <th> Potential Teamates </th>
                <th>Actions</th>
            </tr>
			<?php
		    	$host = "localhost";
				$user="root";
				$password="";
				$db="project_portal";                
				$conn = mysqli_connect($host,$user,$password,$db);
				$sql = "SELECT p.project_id,p.project_name,p.subject_code from projects p,works_on we  where p.project_id = we.project_id and we.project_id in (SELECT w.project_id from works_on w group by w.project_id HAVING count(w.project_id)<3) UNION select p.project_id,p.project_name,p.subject_code FROM projects p where p.project_id not in (SELECT DISTINCT(r.project_id) from works_on r)";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["project_id"]."</td><td>".$row["project_name"]."</td><td>".$row["subject_code"]."</td><td>";
                        $sql_3 = "select s.usn,s.name from student s, works_on w WHERE w.usn = s.usn and w.project_id = ".$row['project_id'];
                        $result_teamates = $conn->query($sql_3);
                        $teamates = array();
                        while($row_team = $result_teamates->fetch_assoc()){
                            $t_n = " ".$row_team['usn']." | ".$row_team['name']."<br>";
                            echo $t_n;
                            array_push($teamates,$t_n);
                        }
                    echo "</td><td><input type='button' value='Choose Group' class='btn btn-warning' onClick='setSess(".$row['project_id'].")'></td></tr>";
				}
            ?>
            
        </table>
	
</div>
<input type="submit" name="sub_btn" class='btn btn-primary' onClick="setSess()" value="JOIN!!">
</form>
<br><br>

