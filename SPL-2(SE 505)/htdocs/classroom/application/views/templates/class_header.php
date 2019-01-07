<!--class template-->
<link rel="stylesheet" href="/zenoir/libs/kickstart/css/kickstart.css"/><!--ui and overall layout style-->
<link rel="stylesheet" href="/zenoir/css/main.css"/><!--main style-->
<link rel="stylesheet" href="/zenoir/libs/datatables/media/css/demo_table.css"/><!--table styles-->
<link rel="stylesheet" href="/zenoir/libs/jquery_ui/css/ui-lightness/jquery-ui-1.8.18.custom.css"/><!--ui style-->
<link rel="stylesheet" href="/zenoir/css/fileUploader.css"/><!--fileuploader style-->
<link rel="stylesheet" href="/zenoir/libs/noty/css/jquery.noty.css"/><!--notifications-->
<link rel="stylesheet" href="/zenoir/libs/noty/css/noty_theme_default.css"/><!--notifications-->
<link rel="stylesheet" href="/zenoir/libs/jScrollPane/style/jquery.jscrollpane.css"  media="all"/><!--scrollbars-->
<link rel="stylesheet" href="/zenoir/libs/redactor/redactor.css"/><!--wysiywg-->

<script src="/zenoir/js/jquery171.js"></script><!--core-->
<script src="/zenoir/libs/kickstart/js/kickstart.js"></script><!--ui and overall layout script-->
<script src="/zenoir/libs/kickstart/js/jquery.snippet.min.js"></script>
<script src="/zenoir/libs/kickstart/js/prettify.js"></script>
<script src="/zenoir/libs/datatables/media/js/jquery.dataTables.js"></script><!--table functionality-->
<script src="/zenoir/libs/jquery_ui/js/jquery-ui-1.8.18.custom.min.js"></script><!--ui script-->
<script src="/zenoir/js/jquery.fileUploader.js"></script><!--file uploader script-->
<script src="/zenoir/libs/jquery_ui/js/datetimepicker.js"></script><!--date and time picker script-->
<script src="/zenoir/libs/noty/js/jquery.noty.js"></script><!--notifications-->
<script src="/zenoir/libs/jScrollPane/script/jquery.mousewheel.js"></script><!-- the mousewheel plugin -->
<script src="/zenoir/libs/jScrollPane/script/jquery.jscrollpane.min.js"></script><!--scrollbars-->
<script src="/zenoir/libs/redactor/redactor.min.js"></script><!--wysiywg-->

<link rel="zenoir icon" href="/zenoir/img/zenoir.ico">
<script>

$(function(){
	var noty_success = {
			"text":"Operation was successfully completed!",
			"layout":"top",
			"type":"success",
			"textAlign":"center",
			"easing":"swing",
			"animateOpen":{"height":"toggle"},
			"animateClose":{"height":"toggle"},
			"speed":500,
			"timeout":5000,
			"closable":true,
			"closeOnSelfClick":true
	}
	
	var noty_err = {
			"text":"An error occured, please try again",
			"layout":"top",
			"type":"error",
			"textAlign":"center",
			"easing":"swing",
			"animateOpen":{"height":"toggle"},
			"animateClose":{"height":"toggle"},
			"speed":500,
			"timeout":5000,
			"closable":true,
			"closeOnSelfClick":true
	}
	
	
	
	$('.time_picker').datetimepicker({
		ampm: true,
		dateFormat: 'yy-mm-dd'
	});
	
	$('.tbl_classes').dataTable({aaSorting: []});
	
	$('a[data-classid]').live('mouseenter', function(){//creates a session for the class
		var class_id = $.trim($(this).data('classid'));

		$.post('/zenoir/index.php/data_setter/set_class', {'class_id' : class_id});
	});
	
	$('a[data-classid]').live('click', function(){
		var class_id= $.trim($(this).data('classid'));
		var act_id	= 3;
		var prefix 	= 'EC';
		$.post('/zenoir/index.php/logs/log_act', {'act_id' : act_id, 'prefix' : prefix});
	});
	
	$('a[data-sid]').live('hover', function(){
                
		var current_id = $(this).data('sid');
		$.post('/zenoir/index.php/data_setter/set_sid', {'sid' : current_id});
    });
	
	$('#btn_update_account').live('click',function(){
		var updates	= 1;
		var password = $.trim($('#password').val()); 
		var fname = $.trim($('#fname').val());
		var mname = $.trim($('#mname').val());
		var lname = $.trim($('#lname').val());
		var auto_biography = $.trim($('#autobiography').val());
		var email =	$.trim($('#email').val());
		
		var account_data = [fname, mname, lname];
		for(var x in account_data){
			if(account_data[x] == ''){
				updates = 0;
			}
		}
		
		if(updates==1){
			$.post('/zenoir/index.php/usert/update_user', {'pword' : password, 'fname' : fname, 'mname' : mname, 'lname' : lname, 'autobiography' : auto_biography, 'email' : email},
				function(){
					
					noty_success.text = 'Account was successfully updated!';
					noty(noty_success);
					
					if($('.upload-data').length){//has files to upload
						$('#px-submit').click();
					}else{
						setTimeout(function(){
							location.reload();
						}, 1000);
					}
				}
			);
		}else{
			noty_err.text = 'Firstname, Middlename and Lastname are required!';
			noty(noty_err);
		}
	});
	
	$('#create_assignment').live('click', function(){
		
		var as_title	= $.trim($('#as_title').val());
		var as_body		= $.trim($('#as_body').val());
		var as_deadline	= $.trim($('#deadline').val());
		var submits 	= 1;
		
		var assignment = [as_title, as_body, as_deadline];
		for(var x in assignment){
			if(assignment[x] == ''){
				submits = 0;
			}
		}
		
		if(submits == 1){
			$("#fancybox-content").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
			$.post('/zenoir/index.php/assignments/create_assignment', {'as_title' : as_title, 'as_body' : as_body, 'as_deadline' : as_deadline},
				function(){
					$('#ajax_loader').remove();
					noty_success.text = 'Assignment was successfully created!';
					noty(noty_success);
					
					if($('.upload-data').length){//has files to upload
						$('#px-submit').click();
					}else{
						setTimeout(function(){
							location.reload();
						}, 1000);
					}
					
					
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});

	$('#create_handout').live('click', function(){
		var create		= 1;
		var ho_title	= $.trim($('#ho_title').val());
		var ho_body		= $.trim($('#ho_body').val());
		var handout		= [ho_title, ho_body];
		
		for(var x in handout){
			if(handout[x] == ''){
				create = 0;
			}
		}
		
		if(create == 1){
			$("#fancybox-content").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
			$.post('/zenoir/index.php/handouts/create', {'ho_title' : ho_title, 'ho_body' : ho_body},
				function(){
					$('#ajax_loader').remove();
					noty_success.text = 'Handout was successfully created!';
					noty(noty_success);
					
					if($('.upload-data').length){//has files to upload
						$('#px-submit').click();
					}else{
						setTimeout(function(){
							location.reload();
						}, 1000);
					}
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	$('#create_message').live('click', function(){
		var send		= 1;
		var receivers	= $.trim($('#receivers').val());
		var msg_title 	= $.trim($('#msg_title').val()); 
		var msg_body 	= $.trim($('#msg_body').val()); 
		
		var message		= [msg_title, msg_body];
		var receiver_len= $('#receivers :selected').length;
		
		for(var x in message){
			if(message[x] == ''){
				send = 0;
			}
		}
		
		if(send == 1 && receiver_len >= 1){
			$("#fancybox-content").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
			$.post('/zenoir/index.php/messages/create', {'receivers' : receivers, 'msg_title' : msg_title, 'msg_body' : msg_body},
				function(data){
					
					$('#ajax_loader').remove();
					noty_success.text = 'Message Sent!';
					noty(noty_success);
				
					if($('.upload-data').length){//has files to upload
						$('#px-submit').click();
					}else{
						setTimeout(function(){
							location.reload();
						}, 1000);
					}
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	
	$('#reply_message').live('click', function(){
		var create		= 1;
		var msg_title 	= $.trim($('#msg_title').val()); 
		var msg_body 	= $.trim($('#msg_body').val()); 
		
		var reply = [msg_title, msg_body];
		for(var x in reply){
			if(reply[x] == ''){
				create = 0;
			}
		}
		
		if(create == 1){
			$("#fancybox-content").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
			$.post('/zenoir/index.php/messages/reply', {'msg_title' : msg_title, 'msg_body' : msg_body},
				function(data){
					$('#ajax_loader').remove();
					noty_success.text = 'Message sent!';
					noty(noty_success);
				
					if($('.upload-data').length){//has files to upload
						$('#px-submit').click();
					}else{
						setTimeout(function(){
							location.reload();
						}, 1000);
					}
				
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	
	$('#submit_assignmentreply').live('click', function(){
		var create		= 1;
		var assignment_id = $.trim($('input[name=assignment_id]').val());
		var reply_title	= $.trim($('#as_title').val());
		var reply_body	= $.trim($('#as_body').val());
		
		var reply		= [reply_title, reply_body];
		
		for(var x in reply){
			if(reply[x] == ''){
				create = 0;
			}
		}
		
		if(create == 1){
			$("#fancybox-content").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
			$.post('/zenoir/index.php/assignments/reply/' + assignment_id, {'reply_title' : reply_title, 'reply_body' : reply_body},
				function(){
					$('#ajax_loader').remove();
					noty_success.text = 'Reply was successfully submitted!';
					noty(noty_success);
					
					if($('.upload-data').length){//has files to upload
						$('#px-submit').click();
					}else{
						setTimeout(function(){
							location.reload();
						}, 1000);
					}
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	$('#file_uploader').hide();
	$('input[name=quiz_type]').live('click', function(){
		var id = $(this).attr('id');
		if(id == 'with_choices'){
			
			$('#create_quizno, #file_uploader').hide();
			$('#next').show();
			
		}else if(id == 'no_choices'){
			$('#next').hide();
			$('#file_uploader').show();
			$('#action_button').after("<button id='create_quizno' name='create_quizno' class='medium green'>Create Quiz</button>");
		}
	});
	
	$('#next').live('click', function(){
		var create		= 1;
		var quiz_title	= $.trim($('#quiz_title').val());
		var quiz_body	= $.trim($('#quiz_body').val());
		var start_time	= $.trim($('#start_time').val());
		var end_time	= $.trim($('#end_time').val());
		
		var quiz		= [quiz_title, quiz_body, start_time, end_time];
		
		for(var x in quiz){
			if(quiz[x] == ''){
				create = 0;
			}
		}
		
		if(create == 1){
			//put the general quiz info on the session
			$.post('/zenoir/index.php/quizzes/cache', {'quiz_title' : quiz_title, 'quiz_body' : quiz_body, 'start_time' : start_time, 'end_time' : end_time},
				function(){
					
					window.location = "<?php echo $this->config->item('page_base'); ?>quiz_items";
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	
	$('a[data-takequiz]').click(function(e){
		e.preventDefault();
		var address = $(this).attr('href');
		noty(	
		{
			modal : true,
			text: 'You can only access this quiz once. Are you sure you want to take the quiz?',
			buttons: [
			  {type: 'button green', text: 'Ok', 
					click: function(){
						location.replace(address);
					}
			  },
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);
	});
	
	$('#create_quizno').live('click', function(){//creating quiz with no items
		var create		= 1;
		var quiz_title	= $.trim($('#quiz_title').val());
		var quiz_body	= $.trim($('#quiz_body').val());
		var start_time	= $.trim($('#start_time').val());
		var end_time	= $.trim($('#end_time').val());
		
		var quiz		= [quiz_title, quiz_body, start_time, end_time];
		
		for(var x in quiz){
			if(quiz[x] == ''){
				create = 0;
			}
		}
		
		if(create == 1){
			//put the general quiz info on the session
			$("body").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
			$.post('/zenoir/index.php/quizzes/create_no', {'quiz_title' : quiz_title, 'quiz_body' : quiz_body, 'start_time' : start_time, 'end_time' : end_time},
				function(){
					$('#ajax_loader').remove();
					noty_success.text = 'Quiz was successfully created!';
					noty(noty_success);
					
					if($('.upload-data').length){//has files to upload
						$('#px-submit').click();
					}else{
						setTimeout(function(){
							location.replace('<?php echo $this->config->item('page_base'); ?>quizzes');
						}, 1000);
					}
					
				}
			);
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	$('#create_quiz').live('click', function(){
		var create_quiz	= 1;
		var questions	= $('.qt').serializeArray();
		var a			= $('.ca').serializeArray();
		var b			= $('.cb').serializeArray();
		var c			= $('.cc').serializeArray();
		var d			= $('.cd').serializeArray();
		var answers		= $('.an').serializeArray();
	
		$('input[type=text]').each(function(){
			if($(this).attr('value') == ''){
				create_quiz = 0;
			}
		});
		
		if(create_quiz == 1){
			$("body").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
			$.post('/zenoir/index.php/quizzes/create', {'questions' : questions, 'a' : a, 'b' : b, 'c' : c, 'd' : d, 'answers' : answers},
				function(data){
					$('#ajax_loader').remove();
					noty_success.text = 'Quiz was successfully created!';
					noty(noty_success);
					setTimeout(function(){
						window.location = "<?php echo $this->config->item('page_base'); ?>quizzes"
					}, 1000);
					
			});
		
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	$('#submit_quiz').live('click', function(){//for quiz with items
		
		var quiz_items 	= $('select').length;
		var answered_all= 1;
		$('select').each(function(){
			if($(this).val() == '--'){
				answered_all = 0;
			}
		});
		
		if(answered_all == 1){
			var answers 	= $('.answers').serializeArray();
			
		noty(	
		{
			modal : true,
			text: 'Are you sure of your answers?',
			buttons: [
			  {type: 'button green', text: 'Ok', 
					click: function(){
						$("body").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
						$.post('/zenoir/index.php/quizzes/submit', {'answers' : answers}, 
						function(){
							$.noty.close(); 
							$('#ajax_loader').remove();
							noty_success.text = 'Answers was successfully submitted!';
							noty(noty_success);
							 
							setTimeout(function(){
								window.location = "<?php echo $this->config->item('page_base'); ?>quizzes";
							}, 1000);
						}
						);
					}
			  },
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);
			
		}else{
			noty_err.text = 'Please answer all of the quiz items!';
			noty(noty_err);
		}
		
	});
	
	$('#reply_quiz').click(function(){//for quiz without items
		var title 	= $.trim($('#res_title').val());
		var body	= $.trim($('#res_body').val());
		
		noty(	
		{
			modal : true,
			text: 'Are you sure of your answers?',
			buttons: [
			  {type: 'button green', text: 'Ok', 
					click: function(){
						$("body").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
						$.post('/zenoir/index.php/quizzes/reply', {'title' : title, 'body' : body}, 
							function(){
								$.noty.close(); 
								$('#ajax_loader').remove();
								noty_success.text = 'Answer was successfully submitted!';
								noty(noty_success);
								
								if($('.upload-data').length){//has files to upload
									$('#px-submit').click();
								}else{
									setTimeout(function(){
										location.reload();
									}, 1000);
								}
							}
						);
					}
			  },
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);
		
		
		
	});
	
	$('#create_group').live('click', function(){
		var member_length 	= $('#class_users :selected').length;
		var group_name 		= $.trim($('#group_name').val());
		
		if(group_name != ''){
			if(member_length > 0){
					
					var group_members 	= $('#class_users').serializeArray();
					$("#fancybox-content").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
					$.post('/zenoir/index.php/groups/create', {'group_name' : group_name, 'members' : group_members},
							function(){
								$('#ajax_loader').remove();
								noty_success.text = 'Group successfully created!';
								noty(noty_success);
								$('#fancybox-close').click();
							}
					);
			}else{
				noty_err.text = 'Please select atleast one co-member!';
				noty(noty_err);
			}
		}else{
			noty_err.text = 'Please enter a group name!';
			noty(noty_err);
		}
	});
	
	$('img[data-delmember]').live('click', function(){
		var member_id 	= $.trim($(this).data('delmember'));
		var member		= $.trim($(this).data('delmembername'));
		var dis			= $(this);
		
		noty(	
		{
			modal : true,
			text: 'Are you sure you want to remove ' + member + ' from the group?',
			buttons: [
			  {type: 'button green', text: 'Ok', 
					click: function(){
						$("#fancybox-content").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
						$.post('/zenoir/index.php/groups/delmember', {'member_id' : member_id}, 
						function(){
							$('#ajax_loader').remove();
							noty_success.text = 'Group member successfully removed!';
							noty(noty_success);
							$.noty.close(); 
							dis.parents('tr').remove();
							if($('#tbl_current tbody tr').length == 0){
								$('#tbl_current').remove();
								
							}
								
						
						}
						);
					}
			  },
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);
	});
	
	$('#update_group').live('click', function(){
		var group_id 		= $.trim($('input[name=group_id]').val());
		var group_name 		= $.trim($('#group_name').val());
		var group_description = $.trim($('#group_description').val());
		
		if(group_name != ''){
			
					
					var group_members 	= $('#class_users').serializeArray();
					$("#fancybox-content").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
					$.post('/zenoir/index.php/groups/update', {'group_id' : group_id, 'group_name' : group_name, 'group_description' : group_description, 'members' : group_members},
							function(){
								$('#ajax_loader').remove();
								noty_success.text = "Group successfully updated!";
								noty(noty_success);
								$('#fancybox-close').click();
							}
					);
			
		}else{
			noty_err.text = 'Please enter a group name!';
			noty(noty_err);
		}
	});
	
	$('#ses_validity').live('click', function(){
		if($(this).attr('checked')){
			$('#time_setter').hide();
		}else{
			$('#time_setter').show();
		}
	});
	
	 $('a[data-sestype]').live('hover', function(){
		var session_type        = $(this).data('sestype');
		$.post('/zenoir/index.php/data_setter/set_sessiontype', {'session_type' : session_type});
    });
        
	$('a[data-sestype]').live('click', function(){
		var session_type        = $(this).data('sestype');
		$.post('/zenoir/index.php/data_setter/set_sessiontype', {'session_type' : session_type});
	});
	
	$('#create_mcsession').live('click', function(){
		
		var create		= 1;
		var title		= $.trim($('#ses_title').val());
		var ses_desc	= $.trim($('#ses_body').val());
		var sessions_type= $.trim($('#current_session_type').val());
		console.log(sessions_type);
		if(sessions_type != 'Team'){
			console.log('booms');
		}
		var infinite	= 0;
		
		if($('#ses_validity').attr('checked')){
			infinite = 1;
		}
		
		var time_from	= $.trim($('#time_from').val());
		var time_to		= $.trim($('#time_to').val());
		
		
		if($('#session_groups').length){//team session
			var members	= $('#session_groups').serializeArray();
			
		}else{//class and masked session
			var members	= 0;
		}
		
		var session = [title, ses_desc];
		if(infinite == 0){
			session = [title, ses_desc, time_from, time_to];
		}
		
		for(var x in session){
			if(session[x] == ''){
				create = 0;
			}
		}
		
		if($('#session_groups').length > 0 && $('#session_groups :selected').length == 0){
			create = 0;
		}
		
		if(create == 1){
			if(sessions_type == 'Team' && members == 0){
				noty_err.text = 'Make sure that you are a member of atleast one group before trying to create a Team Session';
				noty(noty_err);
			}else{
			
			$("#fancybox-content").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
			$.post('/zenoir/index.php/sessions/create', {'ses_title' : title, 'ses_body' : ses_desc, 'infinite' : infinite, 
															'time_from' : time_from, 'time_to' : time_to, 'members' : members},
															function(data){
																$('#ajax_loader').remove();
																$('#fancybox-close').click();
																noty_success.text = 'Session successfully created!';
																noty(noty_success);
																setTimeout(function(){
																	location.reload();
																},1000);
															
															});
			}												
		}else{
			noty_err.text = 'All fields are required!';
			noty(noty_err);
		}
	});
	
	
	$('img[data-inviteid]').live('click', function(){//teacher invites student
		var invite_id	= $(this).data('inviteid');
		var invite_name = $(this).data('invitename');
		noty(	
		{
			modal : true,
			text: 'Are you sure you want to invite ' + invite_name + ' into this class?',
			buttons: [
			  {type: 'button green', text: 'Ok', 
					click: function(){
						$("body").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
						$.post('/zenoir/index.php/classrooms/invites', {'student_id' : invite_id}, function(){
							$('#ajax_loader').remove();
							$.noty.close();
							noty_success.text = 'Student was successfully invited to the classroom!';
							noty.force = true;
							noty(noty_success);
							setTimeout(function(){
								location.reload();
							},1000);
						});
					}
			  },
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);

	});
	
	$('img[data-studentid]').live('click', function(){//student accepts teacher invite
		var student_id	= $(this).data('studentid');
		var class_id	= $(this).data('classid');
		
		noty(	
		{
			modal : true,
			text: 'Are you sure you want to join this class?',
			buttons: [
			  {type: 'button green', text: 'Yes', 
					click: function(){
						$.post('/zenoir/index.php/classrooms/accept', {'student_id' : student_id, 'class_id' : class_id}, function(){
							$.noty.close();
							noty_success.text = 'You can now login to this classroom!';
							noty.force = true;
							noty(noty_success);
							setTimeout(function(){
								location.reload();
							},1000);
						});
					}
			  },
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);
	});
	
	$('img[data-decline]').live('click', function(){//student declines invitation to classroom
		var student_id 	= $(this).data('decline');
		var class_id	= $(this).data('classid');
		
		noty(	
		{
			modal : true,
			text: 'Are you sure you want to decline the invitation to join this class?',
			buttons: [
			  {type: 'button green', text: 'Yes', 
					click: function(){
						$.post('/zenoir/index.php/classrooms/decline', {'student_id' : student_id, 'class_id' : class_id}, function(){
							$.noty.close();
							noty_success.text = 'You have declined the request to join this classroom!';
							noty.force = true;
							noty(noty_success);
							setTimeout(function(){
								location.reload();
							},1000);
						});
					}
			  },
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);
	
	});
	
	$('img[data-grpaccept]').live('click', function(){//user accepts group invite
		var user_id 	= $(this).data('grpaccept');
		var group_id	= $(this).data('groupid');
		
		noty(	
			{
				modal : true,
				text: 'Are you sure you want to join this group?',
				buttons: [
				  {type: 'button green', text: 'Yes', 
						click: function(){
							$.post('/zenoir/index.php/groups/accept', {'user_id' : user_id, 'group_id' : group_id}, function(){
								$.noty.close();
								noty_success.text = 'You are now a part of this group';
								noty.force = true;
								noty(noty_success);
								setTimeout(function(){
									location.reload();
								},1000);
							});
						}
				  },
				  {type: 'button pink', text: 'Cancel', click: function(){
						$.noty.close(); 
				  }}
				],
				closable: false,
				timeout: false
			}
		);
	});
	
	$('img[data-grpdecline]').live('click', function(){//user declines group invite
		var user_id 	= $(this).data('grpdecline');
		var group_id	= $(this).data('groupid');
		
		noty(	
			{
				modal : true,
				text: 'Are you sure you want to decline the invitation to join this group?',
				buttons: [
				  {type: 'button green', text: 'Yes', 
						click: function(){
							$.post('/zenoir/index.php/groups/decline', {'user_id' : user_id, 'group_id' : group_id}, function(){
								$.noty.close();
								noty_success.text = 'You have declined the request to join this group';
								noty.force = true;
								noty(noty_success);
								setTimeout(function(){
									location.reload();
								},1000);
							});
						}
				  },
				  {type: 'button pink', text: 'Cancel', click: function(){
						$.noty.close(); 
				  }}
				],
				closable: false,
				timeout: false
			}
		);
	});
	
	$('.endis_module').live('click', function(){
		
		var classmodule_id = $(this).data('classmoduleid');
		if($(this).attr('checked')){
			$.post('/zenoir/index.php/classrooms/enable', {'cm_id' : classmodule_id});
		}else{
			$.post('/zenoir/index.php/classrooms/disable', {'cm_id' : classmodule_id});
		}
	});
	
	$('#btn_export').live('click', function(){
		var export_class = $('#export_to').val();
		var export_numbers = $('.exports:checked').length;
		
		noty(	
		{
			modal : true,
			text: 'This process cannot be undone are you sure you want to continue?',
			buttons: [
			  {type: 'button green', text: 'Yes', 
					click: function(){
					if(export_class != null){
						if(export_numbers != 0){
							$('#export_group input[type=checkbox]').each(function(index){
								if($(this).attr('checked')){
									$("#fancybox-content").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
									$.post('/zenoir/index.php/classrooms/export', {'export_class' : export_class, 'export_type' : index}, 
									function(){
										$('#ajax_loader').remove();
										$.noty.close();
										noty_success.text = 'Classroom data was successfully exported!';
										noty.force = true;
										noty(noty_success);
										
									});
								}
							});
						}else{
							$.noty.close();
							noty_err.text = 'Please select atleast one export type!';
							noty.force = true;
							noty(noty_err);
						}
					}else{
						$.noty.close();
						noty_err.text = 'Please select a class to export to!';
						noty.force = true;
						noty(noty_err);
					}
			  }},
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);

	});
	
	$('img[data-removename]').live('click', function(){
		var student_id 	= $.trim($(this).data('removeid'));
		var student		= $.trim($(this).data('removename'));
	
		noty(	
		{
			modal : true,
			text: 'Are you sure you want to remove '+ student +' from this class?',
			buttons: [
			  {type: 'button green', text: 'Yes', 
					click: function(){
							$("body").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
							$.post('/zenoir/index.php/classrooms/remove', {'student_id' : student_id},
							function(){
								$('#ajax_loader').remove();
								$.noty.close();
								noty_success.text = 'Student successfully removed from the classroom!';
								noty.force = true;
								noty(noty_success);
								setTimeout(function(){
								location.reload();
								},1000);
								
							});
					
			  }},
			  {type: 'button pink', text: 'Cancel', click: function(){
					$.noty.close(); 
			  }}
			],
			closable: false,
			timeout: false
		}
		);
	
		
	});
	
	$('img[data-lock]').live('click', function(e){
		e.preventDefault();
		var class_id = $(this).data('lock');
		$("#fancybox-content").append("<img id='ajax_loader' src='/zenoir/img/ajax-loader.gif' class='centered'/>");
		$.post('/zenoir/index.php/classrooms/lock', {'class_id' : class_id}, 
				function(){
					$('#ajax_loader').remove();
					noty_success.text = 'Class was successfully locked!';
					noty(noty_success);
					
					setTimeout(function(){
						location.reload()
					},1000);
				
				}
		);
		
	});
	
	$('#time_to').live('blur', function(){
		var time_from 	= Date.parse($('#time_from').val());
		var time_to		= Date.parse($('#time_to').val());
		
		if(time_to <= time_from){
			noty_err.text = "End time should be greater than start time!";
			noty(noty_err);
			
		}
	});
	
	
	$('#end_time').live('blur', function(){
		var start_time	= Date.parse($('#start_time').val());
		var end_time	= Date.parse($('#end_time').val());
		
		if(end_time <= start_time){
			noty_err.text = "End time should be greater than start time!";
			noty(noty_err);
			
		}
	});
	
	
	$('img[src="/zenoir/img/view.png"]').live('click', function(){
		var id = $(this).parents('a').data('id');
		$('#'+id).remove();
	});
	
	$('#deadline').live('change', function(){
		var deadline = Date.parse($(this).val());
		var current_date = Date.parse($('#current_date').val());
		if(deadline < current_date){
			noty_err.text = 'Deadline should be greater than current date!';
			noty(noty_err);
		}
	});

	$('.events').live('click', function(){
		var nevent_id 	= $.trim($(this).attr('id'));
		var check 		= $(this).is(':checked');
		var status		= 0;
		if(check){
			status = 1;
		}else{
			status = 0;
		}
		
		$.post('/zenoir/index.php/notifs/change_status', {'nevent_id' : nevent_id, 'status' : status});
	});
	
	$('#alias').live('keyup', function(){
		var alias = $.trim($(this).val());
		var current_url = $('#enter_session').parents('a').attr('href');
		var exploded_url = current_url.split('/');
		exploded_url.pop();
		var new_url = exploded_url.join('/') + '/' + alias;
		$('#enter_session').parents('a').attr('href', new_url);
	});
});
</script>
<?php
//classroom information
$class_info = $_SESSION['classroom_info'];
$class_code = $class_info['class_code'];
$class_desc = $class_info['class_desc'];
$teacher	= ucwords($class_info['fname'] . ' ' .$class_info['lname']);
$notes		= $class_info['notes'];
?>
<title><?php echo $title; ?></title>
<input type="hidden" id="current_date" value="<?php echo date('Y-m-d'); ?>"/>
<!--user id-->
<span class="spacer">
<a href="<?php echo $this->config->item('ajax_base'); ?>edit_account" class="lightbox"><?php echo $_SESSION['user_name']; ?></a>
</span>
<?php if(!empty($_SESSION['current_class'])){ ?>
<span class="spacer">
<a href="<?php echo $this->config->item('ajax_base'); ?>groups" class="lightbox">Groups</a>
<?php } ?>
</span>
<span class="spacer">
<a href="/zenoir/index.php/class_loader/destroy_userdata">[Logout]</a>
</span>
<div id="container">
	<div id="app_name"><img src="/zenoir/img/zenoir.png"/><h2><a id="app_title" href="<?php echo $this->config->item('page_base'); ?>class_home">Zenoir</a></h2></div>

<div id="class_title">
<h6>
<?php 
echo $class_code.'<br/>'; 
echo $class_desc . ' - '. $teacher.'<br/>'; 
echo $notes;
?>
</h6>
</div>