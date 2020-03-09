<?php 
if(Params::getParam('code')){
	$resume = ModelResume::newInstance()->viewResumeByCode(Params::getParam('code'));
	if($resume){
		if(osc_logged_user_id() != $resume['fk_i_user_id']){
			ModelResume::newInstance()->updateViews(Params::getParam('code'), $resume['views']);
		}
	 ?>
    <h2><?php echo $resume['name']?> <small><?php _e('views', 'resume_uploader'); ?>(<?php echo $resume['views']?>)</small> <a class="dwd-btn btn btn-primary ui-button ui-button-middle ui-button-main" href="<?php echo resumeDownloadUrl($resume); ?>"><?php _e('Download', 'resume_uploader'); ?></a></h2>
    
	<iframe class="doc" src="https://docs.google.com/gview?url=<?php echo osc_base_url().'oc-content/plugins/resume_uploader/resumes/' .$resume['code'].'.'.$resume['ext'];?>&embedded=true"></iframe>
    <?php } else { _e('File Not Available', 'resume_uploader'); } 
}?>

<style>
iframe.doc {
  border: 1px solid #b5b5b5;
  height: auto;
  min-height: 800px;
  width: 100%;
}
.dwd-btn { float:right;}
</style>