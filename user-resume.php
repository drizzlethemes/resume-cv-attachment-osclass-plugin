<script type="text/javascript" src="<?php echo osc_base_url();?>/oc-includes/osclass/assets/js/jquery.validate.min.js"></script>
<?php 

if(Params::getParam('uploader')){
	if(!$_FILES["resume"]["error"] == 4){
		insertResume(osc_logged_user_id());
		osc_add_flash_ok_message(__('Resume added successfully', 'resume_uploader'));
		header('Location:'.osc_route_url('resume-user'));
	}
}

$resume = ModelResume::newInstance()->getResume(osc_logged_user_id());
if(Params::getParam('code')) {
	//if(osc_logged_user_id() == $resume['fk_i_user_id']) {
		 ModelResume::newInstance()->deleteResume();
		 osc_add_flash_ok_message(__('Resume deleted successfully', 'resume_uploader'));
		 header('Location:'.osc_route_url('resume-user'));
	//}
} ?>
<?php if($resume){ ?>
    <h2><?php _e('My Resume', 'resume_uploader'); ?></h2>
    <div class="icon">
        <img style="width:50px" src="<?php echo osc_base_url().'oc-content/plugins/resume_uploader/ms_word.png'; ?>" />
    </div>
    <div class="doc-detail">
        <b><?php echo $resume['name']; ?></b>
        <?php if($resume['views'] != '0'){ ?> <small>(<?php echo $resume['views']; ?> <?php _e('views', 'resume_uploader'); ?>)</small><?php } ?><br>
        <small>(<?php _e('Last updated on', 'resume_uploader'); ?> <?php echo $resume['date']; ?>)</small><br>
        <small><a href="<?php echo resumeDeleteUrl($resume); ?>"><?php _e('Delete', 'resume_uploader'); ?></a> 
        | <a target="_blank" href="<?php echo resumeViewUrl($resume); ?>"><?php _e('View', 'resume_uploader'); ?></a> 
        | <a href="<?php echo resumeDownloadUrl($resume); ?>"><?php _e('Download', 'resume_uploader'); ?></a></small>
    </div>
<?php } else { ?>
	<h2><?php _e('You are not uploaded any resume yet!', 'resume_uploader'); ?></h2>
    <h3><?php _e('Upload Now', 'resume_uploader'); ?></h3>
    <form name="resumePost" method="post" enctype="multipart/form-data">
    	<input type="hidden" name="uploader" value="1" />
        <span id="lblError"></span>
    	<input type="file" name="resume" /><br /><br />
        <button class="ui-button ui-button-middle ui-button-main" type="submit"><?php _e('Submit', 'resume_uploader'); ?></button>
    </form>
<?php } ?>

<style>
.icon {
  float: left;
  margin-right: 8px;
}
</style>