<!--view assignment response-->
<?php 

$response  	= $page['reply'];
$reply_files= $page['files'];

$back	= array(
			'id'=>'back',
			'name'=>'back',
			'value'=>'Back to Replies',
			'content'=>'Back to Replies',
			'class'=>'medium blue'
		);
		
$view	= array(
			'id'=>'view',
			'name'=>'view',
			'value'=>'Back to Assignment',
			'content'=>'Back to Assignment',
			'class'=>'medium blue'
		);
?>
<div id="modal_header">
<h4>Assignment Response - <?php echo $response['res_title']; ?></h4>
</div>

<div class="container">
<div id="sender">
Sent by: <?php echo $response['sender']; ?>
</div>

<div id="datetime">
Date: <?php echo date('Y-m-d g:i:s A', strtotime($response['res_date'])); ?>
</div>

<div id="response_body">
	<pre>
	<?php echo $response['res_body']; ?>
	</pre>
</div>

<!--attached files-->
<?php if(!empty($reply_files)){ ?>
Attached Files:
<?php foreach($reply_files as $files){ ?>
	<li><a href="<?php echo $this->config->item('ajax_base'); ?>view_file?fid=<?php echo $files['file_id']; ?>" class="lightbox"><?php echo $files['filename']; ?></a></li>
<?php } ?>
<?php } ?>

<?php if($this->session->userdata('usertype') == 2){ ?>
<p>
<a href="<?php echo $this->config->item('ajax_base'); ?>list_assignmentreplies/<?php echo $response['as_id']; ?>" data-id="<?php echo $response['as_id']; ?>" class="lightbox">
<?php echo form_button($back); ?>
</a>
<?php }else if($this->session->userdata('usertype') == 3){ ?>
<p>
<a href="<?php echo $this->config->item('ajax_base'); ?>view_assignment/<?php echo $response['as_id']; ?>" data-id="<?php echo $response['as_id']; ?>" class="lightbox">
<?php echo form_button($view); ?>
</a>
</p>
<?php } ?>
</p>
</div><!--end of container-->