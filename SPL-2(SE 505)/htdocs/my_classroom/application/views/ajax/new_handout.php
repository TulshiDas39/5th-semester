<script>
var page = "<?php echo $_SESSION['user_page']; ?>";
$('.fileUpload').fileUploader({
			
			afterEachUpload: function(data, status, formContainer){
				$jsonData = $.parseJSON($(data).find('#upload_data').text());
			}
});
$('.px-buttons').hide();
</script>
<div id="modal_header">
<h4>Create New Handout</h4>
</div>

<?php
$ho_title	= array(
				'id'=>'ho_title',
				'name'=>'ho_title',
			);

$ho_body	= array(
				'id'=>'ho_body',
				'name'=>'ho_body'
			);
	
$create		= array(
				'id'=>'create_handout',
				'name'=>'create_handout',
				'value'=>'Create Handout',
				'content'=>'Create Handout',
				'class'=>'medium green'
			);
?>
<div class="container">
<?php
echo form_label('Title', 'ho_title');
echo form_input($ho_title);	

echo form_label('Body', 'ho_body');
echo form_textarea($ho_body);
?>

<form action="/zenoir/index.php/upload/do_upload" method="post" enctype="multipart/form-data">
<input type="file" name="userfile" class="fileUpload" multiple>
		<div id="div_hide">		
		<button id="px-submit" type="submit" >Upload</button>
		<button id="px-clear" type="reset">Clear</button>
		</div>
</form>

<p>
<?php
echo form_button($create);
?>
</p>
</div>
<script>
$('#ho_body').redactor();
</script>