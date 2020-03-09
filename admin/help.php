<h1><?php _e('Resume Uploader', 'resume_uploader'); ?></h1>

<h3><?php _e('What the plugin does?', 'resume_uploader'); ?></h3>
<p><?php _e('The Resume Uploader plugins help to user to upload their CV on while register on your site. they can update the resume in my account page.', 'resume_uploader'); ?></p>
<h3><?php _e('How to show the resume?', 'resume_uploader'); ?></h3>
<p><?php _e('Use this code to show the CV', 'resume_uploader'); ?> <br /><br />
<?php _e('Show CV on public profile page', 'resume_uploader'); ?> : <code>&lt;?php if (function_exists('userResume')){ echo userResume(osc_user_id());} ?&gt;</code><br /><br />
<?php _e('Show CV on item post detail page', 'resume_uploader'); ?> : <code>&lt;?php if (function_exists('userResume')){ echo userResume(osc_item_user_id());} ?&gt;</code><br /><br />
</p>
<h3><?php _e('About', 'resume_uploader'); ?></h3>
<p>
<?php _e('Plugin Name', 'resume_uploader'); ?>: Resume uploader<br />
<?php _e('Version', 'resume_uploader'); ?>    : 1.0.1<br />
<?php _e('Author', 'resume_uploader'); ?>     : DrizzleThemes<br />
</p>
