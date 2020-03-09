<?php
/*
Plugin Name: Resume Uploader
Plugin URI: https://github.com/drizzlethemes/resume-cv-uploader-osclass-plugin.git
Description: Resume Uploader helps to upload Resume while register.
Version: 1.0.1
Author: DrizzleThemes
Author URI: https://www.drizzlethemes.com/
Short name: resume_uploader
*/

include "ModelResume.php";

/* Install Plugin */
function resumeUploader_install() {
	ModelResume::newInstance()->import('resume_uploader/struct.sql');
	if (!file_exists(osc_content_path()."/plugins/resume_uploader/resumes/")) {
		mkdir(osc_content_path()."/plugins/resume_uploader/resumes/", 0777, true);
		fopen(osc_content_path()."/plugins/resume_uploader/resumes/index.php", 'a');
	}
	osc_set_preference('cv_type', 'doc,docx', 'resume_uploader', 'STRING'); 
}

/* Uninstall Plugin */
function resumeUploader_uninstall() {
	ModelResume::newInstance()->uninstall();
}

function insertResume($userId){
		if(!$_FILES["resume"]["error"] == 4){
		$upload_directory = osc_content_path().'plugins/resume_uploader/resumes/';
		$safe_filename = preg_replace(
						 array("/\s+/", "/[^-\.\w]+/"),
						 array("_", ""),
						 trim($_FILES['resume']['name'])); 
						 
		$ext = pathinfo($safe_filename, PATHINFO_EXTENSION);
		$code = $userId."_". uniqid();
		move_uploaded_file (
					 $_FILES['resume']['tmp_name'],
					 $upload_directory.$code.".".$ext);
					 
		$last_added = ModelResume::newInstance()->checkResume($userId);
		if($last_added !="" ) {
		//	ModelResume::newInstance()->updateResume($ipath, $userId);
		} else {
			ModelResume::newInstance()->insertResume($safe_filename, $userId, $code, $ext );
		}
	}
}
function resumeViewUrl($resume){
	return osc_route_url('resume-view', array('code' => $resume['code']));
}

function resumeDownloadUrl($resume) {
	return osc_base_url().'oc-content/plugins/resume_uploader/resumes/'.$resume['code'].'.'.$resume['ext'];
}

function resumeDeleteUrl($resume){
	return osc_route_url('resume-delete', array('code' => $resume['code']));
}

function userResume($user){
	$resume = ModelResume::newInstance()->getResume($user);
	 if($resume){ ?>
         <div class="resume">
            <div class="icon" style="float: left; margin-right: 8px;">
                <img style="width:50px" src="<?php echo osc_base_url().'oc-content/plugins/resume_uploader/ms_word.png'; ?>" />
            </div>
            <div class="doc-detail">
                <b><?php echo $resume['name']; ?></b>
                <?php if($resume['views'] != '0'){ ?> <small>(<?php echo $resume['views']; ?> <?php _e('views', 'resume_uploader'); ?>)</small><?php } ?><br>
                <small>(<?php _e('Last updated on', 'resume_uploader'); ?> <?php echo $resume['date']; ?>)</small><br>
                
                <a target="_blank" href="<?php echo resumeViewUrl($resume); ?>"><?php _e('View', 'resume_uploader'); ?></a> 
                | <a href="<?php echo resumeDownloadUrl($resume); ?>"><?php _e('Download', 'resume_uploader'); ?></a></small>
            </div>
        </div>
	<?php }
}

function resumeUploader_form(){ ?>
	<div class="control-group">
   		<label class="control-label" for="password"><?php _e('Upload your CV', 'resume_uploader'); ?></label>
      	<div class="controls">
            <div id="text">
            <input id="pResume"  name="resume" type="file" />
            <span id="lblError"></span>
            </div>
           	
        </div>
    </div>
<?php }

function resume_js_footer(){ ?>
 	<script type="text/javascript" src="<?php echo osc_base_url().'oc-content/plugins/resume_uploader/js/additional-methods.min.js';?>"></script>
    <script type="text/javascript">
		$(document).ready(function() {
	       $("form[name='register']").attr("enctype", "multipart/form-data");
		});
		
			$.validator.addMethod('filesize', function (value, element, param) {
			    return this.optional(element) || (element.files[0].size <= param)
			});

			
			$("form[name='register'], form[name='resumePost']").validate({
			  rules: {
			    'resume': {
			      <?php if (!OC_ADMIN) { 
				  	if(cv_req() == 1 ){?>
				 		required: true,
			      <?php } 
				   }?>
			      extension: "<?php echo cv_type(); ?>",
			      filesize: 3145728
			    }
			  },
			   messages:{
			        'resume':{
			          <?php if (!OC_ADMIN) { 
				  			if(cv_req() == 1 ){?>
			           			required : "<?php echo osc_esc_js(__('Please upload your CV','resume_uploader')); ?>",
			           <?php } 
				   }?>
			           extension:"<?php echo osc_esc_js(__('Only '.cv_type().' formats are allowed!','resume_uploader')); ?>",
			           filesize: "<?php echo osc_esc_js(__('Size should less than 3MB','resume_uploader')); ?>"
			        }
			    }
			});
			
	</script>

	<style type="text/css">
	label.error {
			color:#ff0000;
			display: block;
		}
	</style>

<?php }

function resumeUploader_settings_actions() {
  $dao_preference = new Preference();
  $option = Params::getParam('cvoption');

  if (Params::getParam('file') != 'resume_uploader/admin/settings.php') {
    return '';
  }

  if ($option == 'cvsettings') {
   
  	osc_set_preference('cv_type', Params::getParam("cv_type") ? Params::getParam("cv_type") : '', 'resume_uploader', 'STRING');
    osc_set_preference('cv_req', Params::getParam("cv_req") ? Params::getParam("cv_req") : '0', 'resume_uploader', 'STRING');
	osc_add_flash_ok_message(__('Plugin has been updated', 'resume_uploader'), 'admin');
    osc_redirect_to(osc_admin_render_plugin_url('resume_uploader/admin/settings.php'));
  }
}

function cv_type() {
  return(osc_get_preference('cv_type', 'resume_uploader'));
}
function cv_req() {
  return(osc_get_preference('cv_req', 'resume_uploader'));
}

function resumeUploader_user_menu_route() {
	$class='';
	if(Params::getParam('route')=='resume-user') {
		$class = 'active';
	}
	echo '<li class="opt_resumeUploader '.$class.'" ><a href="' . osc_route_url('resume-user') . '" >' . __('My Resume', 'resume_uploader') . '</a></li>';
}

function resumeUploader_user_menu() {
	echo '<li class="opt_resumeUploader" ><a href="' . osc_render_file_url(osc_plugin_folder(__FILE__) . 'user-resume.php') . '" >' . __('My Resume', 'resume_uploader') . '</a></li>';
}

function resumeUploader_admin_menu() {
	echo '<li class="submenu-divide">'.__('Resume Uploader', 'resume_uploader').'</li>';
	echo '<li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/settings.php') . '" >' . __('Settings', 'resume_uploader') . '</a></li>';
	echo '<li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin/help.php') . '" >' . __('Help', 'resume_uploader') . '</a></li>';
}

	if(osc_version()<320) {
        osc_add_hook('user_menu', 'resumeUploader_user_menu');
    } else {
        osc_add_hook('user_menu', 'resumeUploader_user_menu_route');
        // Add route
        osc_add_route('resume-user', 'user/resume', 'user/resume', osc_plugin_folder(__FILE__) . 'user-resume.php', true, 'custom', 'custom', __('Your resume', 'resume_uploader'));
    }

osc_add_hook('admin_menu', 'resumeUploader_admin_menu');
osc_add_hook('user_register_form', 'resumeUploader_form');
osc_add_hook('user_profile_form', 'resumeUploader_form');
osc_add_hook('footer', 'resume_js_footer');
osc_add_hook('init_admin', 'resumeUploader_settings_actions'); 

osc_add_hook('user_register_completed', 'insertResume');
osc_add_hook('user_edit_completed', 'insertResume');

osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'resumeUploader_uninstall') ;
osc_register_plugin(osc_plugin_path(__FILE__), 'resumeUploader_install') ;
osc_add_route('resume-view','resume/view/?(.*)/?','resume/view/{code}',osc_plugin_folder(__FILE__).'view-resume.php', '','resume',__('Your resume', 'resume_uploader'));
osc_add_route('resume-delete','resume/delete/?(.*)/?','resume/delete/{code}',osc_plugin_folder(__FILE__).'user-resume.php', true,  'resume', '');
?>