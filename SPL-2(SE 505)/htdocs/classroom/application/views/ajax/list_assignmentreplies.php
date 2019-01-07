<!--list of responses to a specific assignment-->
<?php 
$replies = $page;

$back	= array(
			'id'=>'back',
			'name'=>'back',
			'value'=>'Back to Assignment',
			'content'=>'Back to Assignment',
			'class'=>'medium orange'
		);
?>
<div id="modal_header">
<h4>Assignment Replies - <?php echo $replies['as_title']; ?></h4>
</div>
<div class="container">
<?php if(!empty($replies['replies'])){ ?>
<div id="reply_list">
<p>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Title</th>
			<th>Date</th>
			<th>Sender</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($replies['replies'] as $row){ ?>
		<tr>
			<td>
			
			<?php echo $row['res_title']; ?>
			<?php if($row['status']){ ?>
			<span class="red_star" id="<?php echo $row['res_id']; ?>">*</span>
			<?php } ?>
			</td>
			<td><?php echo date('Y-m-d g:i:s A', strtotime($row['res_date'])); ?></td>
			<td><?php echo $row['sender']; ?></td>
			<td><a href="<?php echo $this->config->item('ajax_base'); ?>view_assignmentreply/<?php echo $row['res_id']; ?>" data-id="<?php echo $row['res_id']; ?>" data-sid="<?php echo $row['status_id']; ?>" class="lightbox"><img src="/zenoir/img/view.png" class="icons"/></a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
</p>
</div>
<?php } ?>
<p>
<a href="<?php echo $this->config->item('ajax_base'); ?>view_assignment/<?php echo $replies['as_id']; ?>" data-id="<?php echo $replies['as_id']; ?>" class="lightbox">
<?php
echo form_button($back);
?>
</a>
</p>
</div>
<script>
$('#reply_list').jScrollPane({autoReinitialise: true});
</script>