<!--courses management-->
<h4>[Courses]</h4>
<p>
<a href="<?php echo $this->config->item('ajax_base'); ?>new_course" class="lightbox">Create New</a>
</p>
<?php 
$courses = $table;
?>
<table class="tbl_classes">
	<thead>
		<tr>
			<th>Course Code</th>
			<th>Description</th>
			<th>Edit</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($courses as $k=>$v){ ?>
		<tr>
			<td><?php echo $v[0]; ?></td>
			<td><?php echo $v[1]; ?></td>
			<td><a href="<?php echo $this->config->item('ajax_base'); ?>edit_course/<?php echo $v[2]; ?>" data-id="<?php echo $v[2]; ?>" class="lightbox"><img class="icons" src="/zenoir/img/update.png"/></a></td>
			<td><a href="<?php echo $this->config->item('ajax_base'); ?>view_courses/<?php echo $v[2]; ?>" data-id="<?php echo $v[2]; ?>" class="lightbox"><img class="icons" src="/zenoir/img/view.png"/></a></td><!--view classes associated-->
		</tr>
		<?php } ?>
	</tbody>
</table>