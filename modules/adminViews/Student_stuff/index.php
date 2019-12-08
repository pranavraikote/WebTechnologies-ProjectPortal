<?php
	
include_once dirname(__FILE__).'/inc/config.php'; 
 
$q1 = app_db()->select('select * from student');

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="icon" href="../../img/BMSIT_1.ico">
<link rel="stylesheet" type="text/css" href="../../../css/admin_dash.css">
<link rel="stylesheet" type="text/css" href="../../../css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../../../css/bootstrap-table.css">

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
					tbl +='<th>USN</th>';
					tbl +='<th>Name</th>';
					tbl +='<th>Email</th>';
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
						var usn = val['usn'];

						//loop through ajax row data
						tbl +='<tr usn="'+usn+'">';
							tbl +='<td ><div class="row_data" edit_type="click" col_name="usn">'+val['usn']+'</div></td>';
							tbl +='<td ><div class="row_data" edit_type="click" col_name="name">'+val['name']+'</div></td>';
							tbl +='<td ><div class="row_data" edit_type="click" col_name="email">'+val['email']+'</div></td>';

							//--->edit options > start
							tbl +='<td>';						 
								tbl +='<span class="btn_edit" > <a href="#" class="btn btn-link " usn="'+usn+'" > Edit</a> </span>';
								//only show this button if edit button is clicked
								tbl +='<a href="#" class="btn_save btn btn-link"  usn="'+usn+'"> Save </a>';
								tbl +='<a href="#" class="btn_cancel btn btn-link" usn="'+usn+'"> Cancel </a>';
								tbl +='<a href="#" class="btn_delete btn btn-link1 text-danger" usn="'+usn+'"> Delete</a>';
							tbl +='</td>';
							//--->edit options > end						
						tbl +='</tr>';
					});
					//--->create table body rows > end
				tbl +='</tbody>';
				//--->create table body > end

			tbl +='</table>';
			//--->create data table > end

			//add new table row


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

			var usn = $(this).closest('tr').attr('usn'); 
			
			var row_div = $(this)				
			.removeClass('bg-warning') //add bg css
			.css('padding','')

			var col_name = row_div.attr('col_name'); 
			var col_val = row_div.html(); 
			
			var arr = {};
			//get the col name and value
			arr[col_name] = col_val; 
			//get row id value
			arr['usn'] = usn;

			if(original_entry != col_val)
			{ 
				//remove the attr so that new entry can take place
				$(this).removeAttr('original_entry');

				//ajax api json data			 
				var data_obj = 
				{
					usn: usn,
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

			var usn = tbl_row.attr('usn');

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

			var usn = tbl_row.attr('usn');

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

			var usn = tbl_row.attr('usn');

			
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
			arr['usn'] = usn;

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
			var usn = Math.random().toString(36).substr(2);

			//get table rows
			var tbl_row = $(document).find('.tbl_code_with_mark').find('tr');	 
			var tbl = '';
			tbl +='<tr usn="'+usn+'">';
				tbl +='<td ><div class="new_row_data usn bg-warning" contenteditable="true" edit_type="click" col_name="usn"></div></td>';
				tbl +='<td ><div class="new_row_data name bg-warning" contenteditable="true" edit_type="click" col_name="name"></div></td>';
				tbl +='<td ><div class="new_row_data email bg-warning" contenteditable="true" edit_type="click" col_name="email"></div></td>';

				//--->edit options > start
				tbl +='<td>';			 
					tbl +='  <a href="#" class="btn btn-link btn_new" usn="'+usn+'" > Add Entry</a>   | ';
					tbl +='  <a href="#" class="btn btn-link btn_remove_new_entry" usn="'+usn+'"> Remove</a> ';
				tbl +='</td>';
				//--->edit options > end	

			tbl +='</tr>';
			tbl_row.last().after(tbl);

			$(document).find('.tbl_code_with_mark').find('tr').last().find('.usn').focus();
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
			var usn = $(this).attr('usn');

			//get field names
			var usn = ele.find('.usn');
			var name = ele.find('.name');
			var email = ele.find('.email');


			if(usn.html() == "")
			{
				usn.focus();
				usn.after(alert_msg('Enter Project ID'));
			}
			else if(name.html() == "")
			{
				name.focus();
				name.after(alert_msg('Enter Project Name'));
			}
			else if(email.html() == "")
			{
				email.focus();
				email.after(alert_msg('Enter Subject Code'));
			}
			else
			{
				var data_obj=
				{
					call_type:'new_row_entry',
					usn:usn,
					usn:usn.html(),
					name:name.html(),
					email:email.html(),
				};	
				
				ele_this.html('<p class="bg-warning">Please wait....adding your new row</p>');

				$.post(ajax_url, data_obj, function(data) 
				{
					var d1 = JSON.parse(data);

					var tbl = '';
					tbl +='<a href="#" class="btn btn-link btn_edit" usn="'+usn+'" > Edit</a>';
					tbl +='<a href="#" class="btn btn-link btn_save"  usn="'+usn+'" style="display:none;"> Save</a>';
					tbl +='<a href="#" class="btn btn-link btn_cancel" usn="'+usn+'" style="display:none;"> Cancel</a>';
					tbl +='<a href="#" class="btn btn-link text-warning btn_delete" usn="'+usn+'" style="display:none;" > Delete</a>';

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
			var usn = ele_this.attr('usn');
			var data_obj=
			{
				call_type:'delete_row_entry',
				usn:usn,
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
