<!--quizzes-->
<h4>[Quizzes]</h4>
<!--new quiz-->
<?php if($this->session->userdata('usertype') != 3){ ?>
<p>
<a href="<?php echo $this->config->item('page_base'); ?>new_quiz">Create New</a>
</p>
<?php } ?>

<?php 
$quizzes = $table;
?>
<div class="tbl_view">
<?php if(!empty($quizzes)){ ?>
<table class="tbl_classes">
<thead>
	<tr>
		<th>Title</th>
		<th>Date</th>
		<th>Start Time</th>
		<th>End Time</th>
		<?php if($this->session->userdata('usertype') == 3){ ?>
		<th>Take/View</th>
		<?php }else{ ?>
		<th>View</th>
		<?php } ?>
	</tr>
</thead>
<tbody>
<?php foreach($quizzes as $row){ ?>
	<tr>
		<td>
		
		<?php echo $row['title']; ?>
		<?php
		$combined_status = $row['student_status'] + $row['teacher_status'];
		?>
		<?php if($combined_status >= 1){ ?>
		<span class="red_star">*</span>
		<?php } ?>
		</td>
		<td><?php echo $row['date']; ?></td>
		<td><?php echo date('g:i:s A', strtotime($row['start_time'])); ?></td>
		<td><?php echo date('g:i:s A', strtotime($row['end_time'])); ?></td>
		<?php if($this->session->userdata('usertype') == 3){ ?><!--student-->
			<?php
			if($row['stat'] == 1){ 
			?>
				<td><a href="<?php echo $this->config->item('page_base'); ?>take_quiz/<?php echo $row['quiz_id']; ?>" data-takequiz="1" data-id="<?php echo $row['quiz_id']; ?>"><img src="/zenoir/img/take.png" class="icons"/></a></td>
			<?php }else if($row['stat'] == 0 && $row['type'] == 1){ ?><!--view score-->
			
				<td><a href="<?php echo $this->config->item('ajax_base'); ?>score/<?php echo $row['quiz_id']; ?>" data-id="<?php echo $row['quiz_id']; ?>"  class="lightbox"><img src="/zenoir/img/view.png" class="icons"/></a></td>
			
			<?php }else if($row['stat'] == 0 && $row['type'] == 2){ ?><!--view response-->
			
				<td><a href="<?php echo $this->config->item('ajax_base'); ?>view_quizreply/<?php echo $row['quiz_id']; ?>" data-id="<?php echo $row['quiz_id']; ?>" class="lightbox"><img src="/zenoir/img/view.png" class="icons"/></a></td>
			<?php }else if($row['stat'] == 2){ ?>
				<td><img src="/zenoir/img/lock.png" class="icons"/></td>
			<?php } ?>
			
		<?php }else{ ?><!--teacher-->
		<td><a href="<?php echo $this->config->item('page_base'); ?>view_quiz/<?php echo $row['quiz_id']; ?>" data-quiz_id="<?php echo $row['quiz_id']; ?>" data-id="<?php echo $row['quiz_id']; ?>"><img src="/zenoir/img/view.png" class="icons"/></a></td>
		<?php } ?>
	</tr>
<?php } ?>
</tbody>
</table>
<?php } ?>
</div>