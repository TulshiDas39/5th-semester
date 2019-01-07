<?php
class ajax_loader extends ci_Controller{
	
	function __construct(){
		parent::__construct();
		$this->is_logged_in();
	}

	function index(){
		
		$this->load->view('ajax/edit_account');
	}
	
	function is_logged_in(){
		$logged_in = $this->session->userdata('logged_in');
		if(!isset($logged_in) || $logged_in != true){
			redirect('../loader/view/login_form');
		}
	}
	
	function access($user_type, $strict){//returns true of the current user can access the page, 
		//if this returns false user will be redirected to login page
		//because links are already hidden if users does not have the privilege
		//its most likely that the user is malicious if the user type validation springs into action
		//thats why the user is redirected to login page
		$current_type = $this->session->userdata('usertype');
		$ret = false;
		/*
		user types:
		1-admin
		2-teacher
		3-student
		1-strict - the specified usertype is the only one who can access it
		0-non-strict - users who are higher than the specified user type can also access it
		*/
		if($strict == 0){
			if($current_type <= $user_type){
				$ret = true;
			}
		}else if($strict == 1){
			if($current_type == $user_type){
				$ret = true;
			}
		}
		return $ret;
	}
	
	function view($page){
		if(empty($_SERVER['HTTP_REFERER'])){
			show_404();
		}
		$user_id = $this->session->userdata('user_id');
		
		
		$data['user'] = $this->users->user_info($user_id);
		$data['page'] = $this->selector($page);
		
		
		$this->load->view('ajax/'.$page, $data);
		$this->load->view('templates/ajax_header', $data);
		
	}
	
	function selector($page){
		switch($page){
		
						
			
			case 'new_class'://admin only
				if($this->access(1, 1) == false){
					redirect('../loader/view/login_form');
				}
				
				$subjects = $this->subjects_model->select_subjects();
				
				
				$users = $this->users->select_users();
		
				
				$courses = $this->courses_model->select_courses();
				
				$datalist = $_GET['dl'];//1 if browser supports datalist; 2 if not
				
				return array('subjects'=>$subjects, 'users'=>$users, 'courses'=>$courses, 'datalist'=>$datalist);
			break;
			
			case 'view_subjects'://admin only
				if($this->access(1, 1) == false){
					redirect('../loader/view/login_form');
				}
				
				$data = $this->classrooms_model->select_classsubject();
				return $data;
			break;
			
			case 'view_courses'://admin only
				if($this->access(1, 1) == false){
					redirect('../loader/view/login_form');
				}
				
				$data = $this->classrooms_model->select_classcourse();
				return $data;
			break;
			
			case 'view_user'://all
				
				$user_id = $this->uri->segment(4);
				$this->load->model('users');
				$user_info = $this->users->user_information($user_id);
				return $user_info;
			break;
			
			case 'edit_subject'://admin only
				if($this->access(1, 1) == false){
					redirect('../loader/view/login_form');
				}
				
				$subject = $this->subjects_model->get_subject();
				return $subject;
			break;
			
			case 'edit_course'://admin only
				if($this->access(1, 1) == false){
					redirect('../loader/view/login_form');
				}
				
				$course = $this->courses_model->get_course();
				return $course;
			break;
			
			case 'new_message'://teacher + student
				if($this->access(3, 0) == false){
					redirect('../loader/view/login_form');
				}
				
				$class_users = $this->classusers_model->class_users();
				return $class_users;
			break;
			
			case 'view_message'://teacher + student
				if($this->access(3, 0) == false || $this->messages_model->check_owner() == 0){
					redirect('../loader/view/login_form');
				}
				
				$this->post->unset_post('PO');
			
				
				$message = $this->messages_model->view();
				
				$_SESSION['page']= $_SERVER['REQUEST_URI'];
				
				return $message;
			break;
			
			
			case 'reply'://teacher + student
				if($this->access(3, 0) == false){
					redirect('../loader/view/login_form');
				}
				
				$reply_details = $this->messages_model->reply_details();
				return $reply_details;
			break;
			
			case 'msg_history'://teacher + student
				if($this->access(3, 0) == false){
					redirect('../loader/view/login_form');
				}
				
				$history = $this->messages_model->history();
				return $history;
			break;
			
			case 'view_handout'://teacher + student
				if($this->access(3, 0) == false){
					redirect('../loader/view/login_form');
				}
				
				$this->post->unset_post('HO');
				
				
				$this->logs_model->lag(6, 'HO');
			
				
				$handout = $this->handouts_model->view();
				
				$_SESSION['page']= $_SERVER['REQUEST_URI'];
				return $handout;
			break;
			
			case 'view_assignment'://teacher + student
				if($this->access(3, 0) == false){
					redirect('../loader/view/login_form');
				}
				
				$this->post->unset_post('AS');
				
				
				$this->logs_model->lag(4, 'AS');
			
				$assignment_id = $this->uri->segment(4);
				$assignment['details'] = $this->assignments_model->view($assignment_id);
				$assignment['response'] = $this->assignments_model->response_id($assignment_id);
				
				$_SESSION['page']= $_SERVER['REQUEST_URI'];
				return $assignment;
			break;
			
			case 'view_assignmentreply'://teacher + student
				if($this->access(3, 0) == false || $this->assignments_model->check_owner() == 0){
					redirect('../loader/view/login_form');
				}
				
				if($this->session->userdata('usertype') == 2){
					$this->post->unset_assignmentreply();
				}
				
				$this->post->unset_post('AR');
				$this->logs_model->lag(14, 'AR');
			
				$reply_id = $this->uri->segment(4);
				$assignment = $this->assignments_model->view_reply($reply_id);
				
				$_SESSION['page']= $_SERVER['REQUEST_URI'];
				return $assignment;
			break;
			
			case 'assignment_reply'://student
				if($this->access(3, 1) == false){
					redirect('../loader/view/login_form');
				}
				
				$reply = $this->assignments_model->check();
				if($reply == 0){
					redirect('../ajax_loader/view/view_assignment/'.$this->uri->segment(4));
				}
				
				$assignment_id = $this->uri->segment(4);
				$assignment = $this->assignments_model->reply_details($assignment_id);
				return $assignment;
			break;
			
			case 'list_assignmentreplies'://teacher
				if($this->access(2, 1) == false){
					redirect('../loader/view/login_form');
				}
				
				$assignment_id 	= $this->uri->segment(4);
				$assignment_reply = $this->assignments_model->list_replies($assignment_id);
				return $assignment_reply;
			break;
			
			case 'new_group'://teacher + student
				if($this->access(3, 0) == false){
					redirect('../loader/view/login_form');
				}
				
				$class_users = $this->classusers_model->class_users();
				return $class_users;
			break;
			
			case 'groups'://teacher + student
				if($this->access(3, 0) == false){
					redirect('../loader/view/login_form');
				}
				
				$groups = $this->groups_model->list_all();
				return $groups;
			break;
			
			case 'edit_group'://group creator
				
				$group_owner = $this->groups_model->group_owner();
				
				if($this->session->userdata('user_id') != $group_owner){
					redirect('../ajax_loader/view/groups');
				}
				
				$group['members'] = $this->groups_model->view();
				$group['pendings'] = $this->groups_model->pendings();
				return $group;
			break;
			
			
			case 'new_classsession': 
				$session_type = $_SESSION['session_type'];
				$session['title'] = '';
				if($session_type == 2){//masked - teacher only
					if($this->access(2, 1) == false){
						redirect('../loader/view/login_form');
					}
					$session['title'] = 'Masked';
					
				}else if($session_type == 1){//class - teacher only
					if($this->access(2, 1) == false){
						redirect('../loader/view/login_form');
					}
					$session['title'] = 'Class';
				}else if($session_type == 3){//team session - load groups - teacher + student
					if($this->access(3, 0) == false){
						redirect('../loader/view/login_form');
					}
					$session['title'] = 'Team';
					
					$session['groups'] =  $this->groups_model->list_all();
					
				}
				
				return $session;
			break;
			
			case 'join_session':
				
				
				$session = $this->sessions_model->view($this->uri->segment(4));
				return $session;
			break;		
			
			case 'user_logs'://teacher 
			
				if($this->session->userdata('usertype') == 3){//student cannot view logs
					redirect('../ajax_loader/view/view_user');
				}
				$user['user_info']	= array();
				$user['logs']	= array();
				
				
				$user['user_info'] = $this->users->user_information($this->uri->segment(4));
			
				
				$user['logs']	= $this->classusers_model->user_logs();
				
				return $user;
			break;
			
			case 'session': //teacher + student
				if($this->access(3, 0) == false){
					redirect('../loader/view/login_form');
				}
				
				$content = $this->sessions_model->content();
				return $content;
			break;
			
			case 'view_file': //teacher + student
				if($this->access(3, 0) == false){
					redirect('../loader/view/login_form');
				}
				
				$filedata = $this->files->data($_GET['fid']);
				return $filedata;
			break;
			
			case 'dl_file': //teacher + student
				if($this->access(3, 0) == false){
					redirect('../loader/view/login_form');
				}
				
				$filedata = $this->files->data($_GET['fid']);
				return $filedata;
			break;
			
			case 'view_nohandout':
				
				
				$handout['students'] = $this->post->no_handout();
				$handout['details'] = $this->handouts_model->handout_details();
				return $handout;
			break;
			
			case 'view_nohw'://no assignment
				
				
				$assignment['students'] = $this->post->no_assignment();
				$assignment['details'] = $this->assignments_model->assignment_details();
				return $assignment;
			break;
			
			case 'score':
				
				$score = $this->quizzes_model->score();
				return $score;
			break;
			
			case 'view_quizreply':
				
				$reply = $this->quizzes_model->student_reply();
				$_SESSION['page']= $_SERVER['REQUEST_URI'];
				return $reply;
			break;
		}
	}
}
?>