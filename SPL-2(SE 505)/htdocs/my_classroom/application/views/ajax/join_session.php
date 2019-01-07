<!--session entrance-->
<?php
$session_types = array('Class', 'Masked', 'Team');
$accessible = array('NO','YES');
$session = $page;

$alias 	= array(
			'id'=>'alias',
			'name'=>'alias',
			'placeholder'=>'Dodeng Daga'
		);

$enter	= array(
			'id'=>'enter_session',
			'name'=>'enter_session',
			'value'=>'Enter Session',
			'content'=>'Enter Session',
			'class'=>'medium green'
		);
?>

<div id="modal_header">
<h4><?php echo $session['title']; ?></h4>
</div>
<div id="description">
Description:
<?php echo $session['description']; ?>
</div>
<div id="sessiontype">
Session type:
<?php echo $session_types[$session['type']-1]; ?>
</div>
<?php if($session['infinite'] != 1){ ?>
<div id="date">
Date:
<?php echo $session['date']; ?>
</div>
<div id="time_from">
Time from:
<?php echo date('g:i:s A', strtotime($session['from'])); ?>
</div>
<div id="time_to">
Time to:
<?php echo date('g:i:s A', strtotime($session['to'])); ?>
</div>
<?php } ?>
<div id="infinite">
Always Accessible: 
<?php echo $accessible[$session['infinite']]; ?>
</div>

<div class="container">
<?php 
if($_SESSION['session_type'] == 2){
echo form_label('Alias', 'alias'); 
echo form_input($alias);
}
?>
<p>
<a href="<?php echo $this->config->item('page_base'); ?>session/<?php echo $this->uri->segment(4); ?>/<?php echo $this->session->userdata('user_name'); ?>" data-id="<?php echo $session['id']; ?>">
<?php echo form_button($enter); ?>
</a>
</p>
</div>