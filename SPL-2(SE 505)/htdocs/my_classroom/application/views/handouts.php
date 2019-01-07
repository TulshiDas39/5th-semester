<!--handouts-->
<h4>[Handouts]</h4>
<?php if($this->session->userdata('usertype') != 3){ ?>
<p>
<a href="<?php echo $this->config->item('ajax_base'); ?>new_handout" class="lightbox">Create New</a>
</p>
<?php } ?>

<?php 
$handouts = $table;
?>
<!--existing assignments both done, read, and not done-->
<div class="tbl_view">
<?php if(!empty($handouts)){ ?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Title</th>
			<th>Date Created</th>	
			<th>View</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($handouts as $row){ ?>
		<tr>
			<td>
			<?php echo $row['ho_title']; ?>
			<?php if($row['status'] == 1){ ?>
			<span class="red_star" id="<?php echo $row['handout_id']; ?>">*</span>
			<?php } ?>
			</td>
			<td><?php echo $row['date_posted']; ?></td>
			<td><a href="<?php echo $this->config->item('ajax_base'); ?>view_handout/<?php echo $row['handout_id']; ?>" data-id="<?php echo $row['handout_id']; ?>" class="lightbox"><img src="/zenoir/img/view.png" class="icons"/></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
</div>