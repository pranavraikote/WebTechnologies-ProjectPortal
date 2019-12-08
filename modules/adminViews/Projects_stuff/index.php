<?php
	
include_once dirname(__FILE__).'/inc/config.php'; 
 
$q1 = app_db()->select('select * from projects');

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script type="text/javascript">

$(document).ready(function($)
{ 	 
	function create_html_table (tbl_data)
	{
		//--->create data table > start
		var tbl = '';
		tbl +='<table class="table table-hover tbl_code_with_mark">'

			//--->create table header > start
			tbl +='<thead>';
				tbl +='<tr>';
				tbl +='<th>Project ID</th>';
				tbl +='<th>Project Name</th>';
				tbl +='<th>Subject Code</th>';
				tbl +='<th>Options</th>';
				tbl +='</tr>';
			tbl +='</thead>';
			//--->create table header > end
			
			//--->create table body > start
			tbl +='<tbody>';

				//--->create table body rows > start
				$.each(tbl_data, function(index, val) 
				{
					//you can replace with your database row id
					var project_id = val['project_id'];

					//loop through ajax row data
					tbl +='<tr project_id="'+project_id+'">';
						tbl +='<td ><div class="row_data" edit_type="click" col_name="project_id">'+val['project_id']+'</div></td>';
						tbl +='<td ><div class="row_data" edit_type="click" col_name="project_name">'+val['project_name']+'</div></td>';
						tbl +='<td ><div class="row_data" edit_type="click" col_name="subject_code">'+val['subject_code']+'</div></td>';

						//--->edit options > start
						tbl +='<td>';						 
							tbl +='<span class="btn_edit" > <a href="#" class="btn btn-link " project_id="'+project_id+'" > Edit</a> </span>';
							//only show this button if edit button is clicked
							tbl +='<a href="#" class="btn_save btn btn-link"  project_id="'+project_id+'"> Save </a>';
							tbl +='<a href="#" class="btn_cancel btn btn-link" project_id="'+project_id+'"> Cancel </a>';
							tbl +='<a href="#" class="btn_delete btn btn-link1 text-danger" project_id="'+project_id+'"> Delete</a>';
						tbl +='</td>';
						//--->edit options > end						
					tbl +='</tr>';
				});
				//--->create table body rows > end
			tbl +='</tbody>';
			//--->create table body > end

		tbl +='</table>';
		//--->create data table > end


		//out put table data
		$(document).find('.tbl_user_data').html(tbl);

		$(document).find('.btn_save').hide();
		$(document).find('.btn_cancel').hide(); 	
		$(document).find('.btn_delete').hide(); 
			
	}


	var ajax_url = "<?php echo APPURL;?>/ajax.php" ;
	var ajax_data = <?php echo json_encode($q1);?>;

	//create table on page load
	//create_html_table(ajax_data);

	//--->create table via ajax call > start
	$.getJSON(ajax_url,{call_type:'get'},function(data) 
	{
		create_html_table(data);
	});
	//--->create table via ajax call > end
	



	//--->make div editable > start
	$(document).on('click', '.row_data', function(event) 
	{
		event.preventDefault(); 

		if($(this).attr('edit_type') == 'button')
		{
			return false; 
		}

		//make div editable
		$(this).closest('div').attr('contenteditable', 'true');
		//add bg css
		$(this).addClass('bg-warning').css('padding','5px');

		$(this).focus();

		$(this).attr('original_entry', $(this).html());

	})	
	//--->make div editable > end

	//--->save single field data > start
	$(document).on('focusout', '.row_data', function(event) 
	{
		event.preventDefault();

		if($(this).attr('edit_type') == 'button')
		{
			return false; 
		}

		//get the original entry
		var original_entry = $(this).attr('original_entry');

		var project_id = $(this).closest('tr').attr('project_id'); 
		
		var row_div = $(this)				
		.removeClass('bg-warning') //add bg css
		.css('padding','')

		var col_name = row_div.attr('col_name'); 
		var col_val = row_div.html(); 
		
		var arr = {};
		//get the col name and value
		arr[col_name] = col_val; 
		//get row id value
		arr['project_id'] = project_id;

		if(original_entry != col_val)
		{ 
			//remove the attr so that new entry can take place
			$(this).removeAttr('original_entry');

			//ajax api json data			 
			var data_obj = 
			{
				project_id: project_id,
				col_name: col_name,
				col_val:col_val,
				call_type: 'single_entry',				
			};
			
			//call ajax api to update the database record
			$.post(ajax_url, data_obj, function(data) 
			{
				var d1 = JSON.parse(data);
				if(d1.status == "error")
				{
					var msg = ''
					+ '<h3>There was an error while trying to update your entry</h3>'
					+'<pre class="bg-danger">'+JSON.stringify(arr, null, 2) +'</pre>'
					+'';

					$('.post_msg').html(msg);
				}
				else if(d1.status == "success")
				{
					var msg = ''
					+ '<h3>Successfully updated your entry</h3>'
					+'<pre class="bg-success">'+JSON.stringify(arr, null, 2) +'</pre>'
					+'';

					$('.post_msg').html(msg);
				}
			});
		}
		else
		{
			$('.post_msg').html('');
		}
		
	})	
	//--->save single field data > end

	//--->button > edit > start	
	$(document).on('click', '.btn_edit', function(event) 
	{
		event.preventDefault();
		var tbl_row = $(this).closest('tr');

		var project_id = tbl_row.attr('project_id');

		tbl_row.find('.btn_save').show();
		tbl_row.find('.btn_cancel').show();
		tbl_row.find('.btn_delete').show();

		//hide edit button
		tbl_row.find('.btn_edit').hide(); 

		//make the whole row editable
		tbl_row.find('.row_data')
		.attr('contenteditable', 'true')
		.attr('edit_type', 'button')
		.addClass('bg-warning')
		.css('padding','3px')

		//--->add the original entry > start
		tbl_row.find('.row_data').each(function(index, val) 
		{  
			//this will help in case user decided to click on cancel button
			$(this).attr('original_entry', $(this).html());
		}); 		
		//--->add the original entry > end

	});
	//--->button > edit > end


	//--->button > cancel > start	
	$(document).on('click', '.btn_cancel', function(event) 
	{
		event.preventDefault();

		var tbl_row = $(this).closest('tr');

		var project_id = tbl_row.attr('project_id');

		//hide save and cacel buttons
		tbl_row.find('.btn_save').hide();
		tbl_row.find('.btn_cancel').hide();
		tbl_row.find('.btn_delete').hide();

		//show edit button
		tbl_row.find('.btn_edit').show();

		//make the whole row editable
		tbl_row.find('.row_data')
		.attr('edit_type', 'click')
		.removeClass('bg-warning')
		.css('padding','') 

		tbl_row.find('.row_data').each(function(index, val) 
		{   
			$(this).html( $(this).attr('original_entry') ); 
		});  
	});
	//--->button > cancel > end

	
	//--->save whole row entery > start	
	$(document).on('click', '.btn_save', function(event) 
	{
		event.preventDefault();
		var tbl_row = $(this).closest('tr');

		var project_id = tbl_row.attr('project_id');

		
		//hide save and cacel buttons
		tbl_row.find('.btn_save').hide();
		tbl_row.find('.btn_cancel').hide();
		tbl_row.find('.btn_delete').hide();

		//show edit button
		tbl_row.find('.btn_edit').show();


		//make the whole row editable
		tbl_row.find('.row_data')
		.attr('edit_type', 'click')
		.removeClass('bg-warning')
		.css('padding','') 

		//--->get row data > start
		var arr = {}; 
		tbl_row.find('.row_data').each(function(index, val) 
		{   
			var col_name = $(this).attr('col_name');  
			var col_val  =  $(this).html();
			arr[col_name] = col_val;
		});
		//--->get row data > end

		//get row id value
		arr['project_id'] = project_id;

		//out put to show
		$('.post_msg').html( '<pre class="bg-success">'+JSON.stringify(arr, null, 2) +'</pre>');

		//add call type for ajax call
		arr['call_type'] = 'row_entry';

		//call ajax api to update the database record
		$.post(ajax_url, arr, function(data) 
		{
			var d1 = JSON.parse(data);
			if(d1.status == "error")
			{
				var msg = ''
				+ '<h3>There was an error while trying to update your entry</h3>'
				+'<pre class="bg-danger">'+JSON.stringify(arr, null, 2) +'</pre>'
				+'';

				$('.post_msg').html(msg);
			}
			else if(d1.status == "success")
			{
				var msg = ''
				+ '<h3>Successfully updated your entry</h3>'
				+'<pre class="bg-success">'+JSON.stringify(arr, null, 2) +'</pre>'
				+'';

				$('.post_msg').html(msg);
			}			
		});
	});
	//--->save whole row entery > end



	$(document).on('click', '.btn_new_row', function(event) 
	{
		event.preventDefault();
		//create a random id
		var project_id = Math.random().toString(36).substr(2);

		//get table rows
		var tbl_row = $(document).find('.tbl_code_with_mark').find('tr');	 
		var tbl = '';
		tbl +='<tr project_id="'+project_id+'">';
			tbl +='<td ><div class="new_row_data project_id bg-warning" contenteditable="true" edit_type="click" col_name="project_id"></div></td>';
			tbl +='<td ><div class="new_row_data project_name bg-warning" contenteditable="true" edit_type="click" col_name="project_name"></div></td>';
			tbl +='<td ><div class="new_row_data subject_code bg-warning" contenteditable="true" edit_type="click" col_name="subject_code"></div></td>';

			//--->edit options > start
			tbl +='<td>';			 
				tbl +='  <a href="#" class="btn btn-link btn_new" project_id="'+project_id+'" > Add Entry</a>   | ';
				tbl +='  <a href="#" class="btn btn-link btn_remove_new_entry" project_id="'+project_id+'"> Remove</a> ';
			tbl +='</td>';
			//--->edit options > end	

		tbl +='</tr>';
		tbl_row.last().after(tbl);

		$(document).find('.tbl_code_with_mark').find('tr').last().find('.project_id').focus();
	});

	
	$(document).on('click', '.btn_remove_new_entry', function(event) 
	{
		event.preventDefault();

		$(this).closest('tr').remove();
	});

	function alert_msg (msg)
	{
		return '<span class="alert_msg text-danger">'+msg+'</span>';
	}

	$(document).on('click', '.btn_new', function(event) 
	{
		event.preventDefault();
		
		var ele_this = $(this);
		var ele = ele_this.closest('tr');
		
		//remove all old alerts
		ele.find('.alert_msg').remove();

		//get row id
		var project_id = $(this).attr('project_id');

		//get field names
		var project_id = ele.find('.project_id');
		var project_name = ele.find('.project_name');
		var subject_code = ele.find('.subject_code');


		if(project_id.html() == "")
		{
			project_id.focus();
			project_id.after(alert_msg('Enter First Name'));
		}
		else if(project_name.html() == "")
		{
			project_name.focus();
			project_name.after(alert_msg('Enter Last Name'));
		}
		else if(subject_code.html() == "")
		{
			subject_code.focus();
			subject_code.after(alert_msg('Enter Email'));
		}
		else
		{
			var data_obj=
			{
				call_type:'new_row_entry',
				project_id:project_id,
				project_id:project_id.html(),
				project_name:project_name.html(),
				subject_code:subject_code.html(),
			};	
			
			ele_this.html('<p class="bg-warning">Please wait....adding your new row</p>');

			$.post(ajax_url, data_obj, function(data) 
			{
				var d1 = JSON.parse(data);

				var tbl = '';
				tbl +='<a href="#" class="btn btn-link btn_edit" project_id="'+project_id+'" > Edit</a>';
				tbl +='<a href="#" class="btn btn-link btn_save"  project_id="'+project_id+'" style="display:none;"> Save</a>';
				tbl +='<a href="#" class="btn btn-link btn_cancel" project_id="'+project_id+'" style="display:none;"> Cancel</a>';
				tbl +='<a href="#" class="btn btn-link text-warning btn_delete" project_id="'+project_id+'" style="display:none;" > Delete</a>';

				if(d1.status == "error")
				{
					var msg = ''
					+ '<h3>There was an error while trying to add your entry</h3>'
					+'<pre class="bg-danger">'+JSON.stringify(data_obj, null, 2) +'</pre>'
					+'';

					$('.post_msg').html(msg);
				}
				else if(d1.status == "success")
				{
					ele_this.closest('td').html(tbl);
					ele.find('.new_row_data').removeClass('bg-warning');
					ele.find('.new_row_data').toggleClass('new_row_data row_data');
				}
			});
		}
	});



	$(document).on('click', '.btn_delete', function(event) 
	{
		event.preventDefault();

		var ele_this = $(this);
		var project_id = ele_this.attr('project_id');
		var data_obj=
		{
			call_type:'delete_row_entry',
			project_id:project_id,
		};	
		 		 
		ele_this.html('<p class="bg-warning">Please wait....deleting your entry</p>')
		$.post(ajax_url, data_obj, function(data) 
		{ 
			var d1 = JSON.parse(data); 
			if(d1.status == "error")
			{
				var msg = ''
				+ '<h3>There was an error while trying to add your entry</h3>'
				+'<pre class="bg-danger">'+JSON.stringify(data_obj, null, 2) +'</pre>'
				+'';

				$('.post_msg').html(msg);
			}
			else if(d1.status == "success")
			{
				ele_this.closest('tr').css('background','red').slideUp('slow');				 
			}
		});
	});
 
	
});
</script>


<body style="background-color: rgba(0,0,0,0.8);background-image: none">
	<div style="padding:10px;"></div>
	
	<div class="container">


		<div class="panel panel-default">
		

		<div class="panel-body" style="width='120%';">
			
			<div class="tbl_user_data" style="width='120%';"></div>

		</div>

		</div>
	</div>
</body>
