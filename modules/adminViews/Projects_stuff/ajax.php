<?php

include_once dirname(__FILE__).'/inc/config.php';


//--->get all projects > start
if(isset($_GET['call_type']) && $_GET['call_type'] =="get")
{
	$q1 = app_db()->select('select * from projects');
	echo json_encode($q1);
}
//--->get all projects > end




//--->update single entry > start
if(isset($_POST['call_type']) && $_POST['call_type'] =="single_entry")
{	

	$project_id 	= app_db()->CleanDBData($_POST['project_id']);
	$col_name  	= app_db()->CleanDBData($_POST['col_name']); 
	$col_val  	= app_db()->CleanDBData($_POST['col_val']);
	
	$tbl_col_name = array("project_id", "project_name", "subject_code", "project_id");

	if (!in_array($col_name, $tbl_col_name))
	{
		echo json_encode(array(
			'status' => 'error', 
			'msg' => 'invalid col_name', 
		));
		die();
	}

	$q1 = app_db()->select("select * from projects where project_id='$project_id'");
	if($q1 < 1) 
	{
		//no record found in the database
		echo json_encode(array(
			'status' => 'error', 
			'msg' => 'no entries were found', 
		));
		die();
	}
	else if($q1 > 0) 
	{
		//found record in the database
		 
		$strTableName = "projects";

		$array_fields = array(
			$col_name => $col_val,
		);
		$array_where = array(    
		  'project_id' => $project_id,
		);
		//Call it like this:  
		app_db()->Update($strTableName, $array_fields, $array_where);


		echo json_encode(array(
			'status' => 'success', 
			'msg' => 'updated entry', 
		));
		die();
	}
}
//--->update single entry > end




//--->update a whole row  > start
if(isset($_POST['call_type']) && $_POST['call_type'] =="row_entry")
{	

	$project_id 	= app_db()->CleanDBData($_POST['project_id']);
	$project_id  	= app_db()->CleanDBData($_POST['project_id']); 
	$project_name  	= app_db()->CleanDBData($_POST['project_name']); 
	$subject_code  	= app_db()->CleanDBData($_POST['subject_code']); 	
	
	$q1 = app_db()->select("select * from projects where project_id='$project_id'");
	if($q1 < 1) 
	{
		//no record found in the database
		echo json_encode(array(
			'status' => 'error', 
			'msg' => 'no entries were found', 
		));
		die();
	}
	else if($q1 > 0) 
	{
		//found record in the database
		 
		$strTableName = "projects";

		$array_fields = array(
			'project_id' => $project_id,
			'project_name' => $project_name,
			'subject_code' => $subject_code,
		);
		$array_where = array(    
		  'project_id' => $project_id,
		);
		//Call it like this:  
		app_db()->Update($strTableName, $array_fields, $array_where);


		echo json_encode(array(
			'status' => 'success', 
			'msg' => 'updated row entry', 
		));
		die();
	}
}
//--->update a whole row > end




//--->new row entry  > start
if(isset($_POST['call_type']) && $_POST['call_type'] =="new_row_entry")
{	

	$project_id 	= app_db()->CleanDBData($_POST['project_id']);
	$project_id  	= app_db()->CleanDBData($_POST['project_id']); 
	$project_name  	= app_db()->CleanDBData($_POST['project_name']); 
	$subject_code  	= app_db()->CleanDBData($_POST['subject_code']); 	
	
	$q1 = app_db()->select("select * from projects where project_id='$project_id'");
	if($q1 < 1) 
	{
		//add new row
		$strTableName = "projects";

		$insert_arrays = array
		(
			'project_id' => $project_id,
			'project_id' => $project_id,
			'project_name' => $project_name,
			'subject_code' => $subject_code,
		);

		//Call it like this:
		app_db()->Insert($strTableName, $insert_arrays);

		echo json_encode(array(
			'status' => 'success', 
			'msg' => 'added new entry', 
		));
		die();
	}	 
}
//--->new row entry  > end



//--->new row entry  > start
if(isset($_POST['call_type']) && $_POST['call_type'] =="delete_row_entry")
{	

	$project_id 	= app_db()->CleanDBData($_POST['project_id']);	 
	
	$q1 = app_db()->select("select * from projects where project_id='$project_id'");
	if($q1 > 0) 
	{
		//found a row to be deleted
		$strTableName = "projects";

		$array_where = array('project_id' => $project_id);

		//Call it like this:
		app_db()->Delete($strTableName,$array_where);

		echo json_encode(array(
			'status' => 'success', 
			'msg' => 'deleted entry', 
		));
		die();
	}	 
}
//--->new row entry  > end