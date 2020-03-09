<h2><?php _e('Resume Uploader Settings', 'resume_uploader'); ?></h2>
<?php $pluginInfo = osc_plugin_get_info('resume_uploader/index.php');  ?>
<form action="<?php echo osc_admin_render_plugin_url('resume_uploader/admin/settings.php'); ?>" method="post">
<input type="hidden" name="cvoption" value="cvsettings" />
<fieldset>
    <div class="form-horizontal">
        <div class="form-row">
        	<div class="form-label">Supported File Types by comma:</div>
            <div class="form-controls">
            <input class="xlarge" type="text" value="<?php echo cv_type(); ?>" name="cv_type">
            </div>
        </div>
        <div class="form-row">
        	<div class="form-label">Required?</div>
            <div class="form-controls">
            	<div class="form-label-checkbox">
            		<label>
                    	<input type="checkbox" <?php echo (cv_req() ? 'checked="true"' : ''); ?> value="1" name="cv_req"> <?php _e('Yes', 'resume_uploader'); ?>
                     </label>
                </div>
            </div>
        </div>
     </div>
</fieldset>
<div class="form-actions">
	<input type="submit" class="btn btn-submit" value="<?php osc_esc_html(_e('Save changes', 'resume_uploader')); ?>" id="save_changes">
</div>
</form>