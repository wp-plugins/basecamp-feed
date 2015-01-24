<?php
namespace BaseCamp_Feed;

class BaseCamp_Feed_settings extends BaseCamp_Feed_Main {

	function __construct() {
		if ( is_admin() ){
		  //Add Admin Menu Pages
		  add_action('admin_menu', array( $this,'main_menu'));
		  // add_action('admin_menu', array( $this,'basecampfeed_submenu_pages'));
		  
		  add_action('wp_enqueue_scripts', array( $this,'basecampfeed_head'));
		  add_action('admin_init', array( $this,'settings_page_register_settings' ));
		}
	}
	//**************************************************
	// Admin Menu
	//**************************************************
	function main_menu() {
  	 	add_menu_page('BaseCamp Feed', 'BaseCamp Feed', 'manage_options', 'basecamp-feed-settings-page', array( $this,'settings_page'), '');
		add_submenu_page('basecamp-feed-settings-page', __('Settings', 'basecamp-feed'),  __('Settings', 'basecamp-feed'), 'manage_options', 'basecamp-feed-settings-page' );
	}
	///**************************************************
	// Register Settings Page Settings
	//***************************************************
	function settings_page_register_settings() { 
		//Register Login Settting Options
		$login_settings = array(
					'bcf_user_id',
					'bcf_password_id',
					'bcf_account_id'
					);
		$this->register_settings('basecamp-feed-login-settings', $login_settings);
		//Register Format Settting Options
		$format_settings = array(
					'bcf-date-and-time-format',
					'bcf-timezone',
					'bcf-color-options-settings-custom-css',
					'bcf-color-options-main-wrapper-css-input',
					'bcf-powered-text-options-settings'
					);
		$this->register_settings('basecamp-feed-format-settings', $format_settings);
	}
	///**************************************************
	// Generate Shortcode
	//***************************************************
	function  generate_shortcode($onclick, $label, $input_class) {
	
      $output = '<input type="button" class="feed-them-social-admin-submit-btn" value="'.__('Generate Shortcode', 'basecamp-feed').'" onclick="'.$onclick.'" tabindex="4" style="margin-right:1em;" />';
      $output .= '<div class="feed-them-social-admin-input-wrap final-shortcode-textarea">';
      
     	 $output .= '<h4>'.__('Copy the ShortCode below and paste it on a page or post that you want to display your feed.', 'basecamp-feed').'</h4>';
      
        $output .= '<div class="feed-them-social-admin-input-label">'.$label.'></div>';
        
        $output .= '<input class="copyme '.$input_class.' feed-them-social-admin-input" value="" />';
        
      $output .= '<div class="clear"></div>';
      $output .= '</div><!--/feed-them-social-admin-input-wrap-->';
	  
	  return $output;
	}
	///**************************************************
	// Settings Page Display
	//***************************************************
	function settings_page() { ?>
<link href='http://fonts.googleapis.com/css?family=Rambla:400,700' rel='stylesheet' type='text/css'>
<div class="feed-them-social-admin-wrap">
  <h1>
    <?php _e('BaseCamp Feed', 'basecamp-feed'); ?>
  </h1>
  <div class="use-of-plugin">
    <?php _e('Select what type of feed you would like to generate a shortcode for using the select option below. Then you\'ll copy that shortcode to a page or post.', 'basecamp-feed'); ?>
  </div>
  <div class="feed-them-icon-wrap">
    <?php
		//show the js for the discount option under social icons on the settings page
		if(!is_plugin_active('feed-them-premium/feed-them-premium.php')) { ?>
    <div id="discount-for-review">
      <?php _e('15% off Premium Version', 'basecamp-feed'); ?>
    </div>
    <div class="discount-review-text"><a href="#" target="_blank">
      <?php _e('Share here', 'basecamp-feed'); ?>
      </a>
      <?php _e('and receive 15% OFF your total order.', 'basecamp-feed'); ?>
    </div>
    <?php } ?>
  </div>
  <?php
	$basecamp = new Basecamp('BaseCampFeed');
	$bcf_un = get_option('bcf_user_id');  
	$bcf_pw = get_option('bcf_password_id');
	$bcf_account_id = get_option('bcf_account_id');
	$basecamp->setServerAuthentication($bcf_un,$bcf_pw);
	$basecamp->setAccount('https://basecamp.com/'.$bcf_account_id.'/api/v1');
	
	$success = $basecamp->getProjects() ? 'successful' : 'unsuccessful';
  ?>
  <form method="post" class="feed-them-social-admin-form" action="options.php">
    <?php settings_fields('basecamp-feed-login-settings'); ?>
    <h2>
      <?php _e('Connect to Basecamp', 'basecamp-feed'); ?>
    </h2>
    <div class="feed-them-social-admin-input-wrap">
      <div class="feed-them-social-admin-input-label <?php echo $success;?>">
        <?php _e('Basecamp User ID', 'basecamp-feed'); ?>
      </div>
      <input type="text" name="bcf_user_id" id="bcf-user-id" class="feed-them-social-admin-input" value="<?php echo get_option('bcf_user_id'); ?>">
      <div class="clear"></div>
    </div>
    <div class="feed-them-social-admin-input-wrap">
      <div class="feed-them-social-admin-input-label <?php echo $success;?>">
        <?php _e('Basecamp Password', 'basecamp-feed'); ?>
      </div>
      <input type="password" name="bcf_password_id" id="bcf-password-id" class="feed-them-social-admin-input" value="<?php echo get_option('bcf_password_id'); ?>">
      <div class="clear"></div>
    </div>
    <div class="instructional-text facebook-message-generator" style="display: block !important;">
      <?php _e('Copy your', 'basecamp-feed'); ?>
      <?php _e('<a href="http://www.slickremix.com/2015/01/22/basecamp-account-id" target="_blank">Account ID</a> and paste it below.', 'basecamp-feed'); ?>
    </div>
    <div class="feed-them-social-admin-input-wrap">
      <div class="feed-them-social-admin-input-label <?php echo $success;?>">
        <?php _e('Basecamp Accout Id', 'basecamp-feed'); ?>
      </div>
      <input type="text" name="bcf_account_id" id="bcf-account-id" class="feed-them-social-admin-input" value="<?php echo get_option('bcf_account_id'); ?>">
      <div class="clear"></div>
    </div>
    <span style="color:#FFF;">
    <?php _e('To create a Feed From a different Account name simply enter a new Basecamp Account ID above and save, then you will see the options populated below with that account list of To-Dos.', 'basecamp-feed'); ?>
    </span> <br/>
    <input type="submit" class="feed-them-social-admin-submit-btn" value="<?php _e('Save Account Info', 'basecamp-feed') ?>" />
  </form>
  <?php if($basecamp->getProjects()){ ?>
  <div class="fts-facebook_page-shortcode-form">
    <form class="feed-them-social-admin-form shortcode-generator-form fb-page-shortcode-form" id="fts-fb-page-form" style="display: block;">
      <h2>
        <?php _e('Basecamp To-Do Shortcode Generator', 'basecamp-feed'); ?>
      </h2>
      <div class="feed-them-social-admin-input-wrap">
        <div class="feed-them-social-admin-input-label">
          <?php _e('Feed Type', 'basecamp-feed'); ?>
        </div>
        <select name="facebook-messages-selector" id="facebook-messages-selector" class="feed-them-social-admin-input">
          <option value="page">
          <?php _e('Single To-Do Feed', 'basecamp-feed'); ?>
          </option>
          <option value="group">
          <?php _e('Multi To-Do Feed', 'basecamp-feed'); ?>
          </option>
        </select>
        <div class="clear"></div>
      </div>
      <!--/feed-them-social-admin-input-wrap-->
      
      <div class="feed-them-social-admin-input-wrap project-id-select-wrap">
        <div class="feed-them-social-admin-input-label">
          <?php _e('Project ID', 'basecamp-feed'); ?>
        </div>
        <select name="bcf-project-id" id="bcf-project-id" class="feed-them-social-admin-input">
          <option value="">Please Choose</option>
          <?php
             //Foreach Proejct Make option
             foreach($basecamp->getProjects() as $project) {
               echo'<option value="'.$project->id.'">'.$project->name.'</option>';
			   
			   $basecamp->getTodoLists(false,$project->id);
             }
           ?>
        </select>
        <div class="clear"></div>
      </div>
      <!--/feed-them-social-admin-input-wrap-->
      
      <div class="feed-them-social-admin-input-wrap to-dos-list-id-option">
        <div class="feed-them-social-admin-input-label">
          <?php _e('To Do List ID', 'basecamp-feed'); ?>
        </div>
        <select name="bcf-todo-list-id" id="bcf-todo-list-id" class="feed-them-social-admin-input">
          <option value="">Please Choose</option>
          <?php
             //Foreach Proejct Make option
			 foreach($basecamp->getProjects() as $project) {
			   echo'<optgroup label="'.$project->name.'" id="'.$project->id.'">';
				 foreach($basecamp->getTodoLists(false,$project->id) as $todo_list) {
					  echo'<option value="'.$todo_list->id.'">'.$todo_list->name.'</option>';
				 }
			  echo'</optgroup>';
             }
			 
             
           ?>
        </select>
        <div class="clear"></div>
      </div>
      <!--/feed-them-social-admin-input-wrap-->
      
      <div class="feed-them-social-admin-input-wrap">
        <div class="feed-them-social-admin-input-label">
          <?php _e('Show Completed To-Dos', 'basecamp-feed'); ?>
        </div>
        <select name="bcf-completed" id="bcf-completed" class="feed-them-social-admin-input">
          <option value="yes">
          <?php _e('Yes', 'basecamp-feed'); ?>
          </option>
          <option value="no">
          <?php _e('No', 'basecamp-feed'); ?>
          </option>
        </select>
        <div class="clear"></div>
      </div>
      <!--/feed-them-social-admin-input-wrap-->
      
      <input type="button" class="feed-them-social-admin-submit-btn" value="<?php _e('Generate Shortcode', 'basecamp-feed'); ?>" onclick="updateTextArea_fb_page();" tabindex="4" style="margin-right:1em;">
      <div class="feed-them-social-admin-input-wrap final-shortcode-textarea" style="display: none;">
        <h4>
          <?php _e('Copy the ShortCode below and paste it on a page or post that you want to display your feed.', 'basecamp-feed'); ?>
        </h4>
        <div class="feed-them-social-admin-input-label">
          <?php _e('Basecamp Feed Shortcode', 'basecamp-feed'); ?>
        </div>
        <input class="copyme facebook-page-final-shortcode feed-them-social-admin-input" value="">
        <div class="clear"></div>
      </div>
      <!--/feed-them-social-admin-input-wrap-->
    </form>
  </div>
  <?php } ?>
  <div class="clear"></div>
  
  <!-- custom option for padding -->
  <form method="post" class="fts-color-settings-admin-form" action="options.php">
    <div class="feed-them-custom-css">
      <?php settings_fields('basecamp-feed-format-settings'); ?>
      <?php 
			isset($ftsDateTimeFormat) ? $ftsDateTimeFormat : "";
			isset($ftsTimezone) ? $ftsTimezone : "";
			
			$ftsDateTimeFormat = get_option('bcf-date-and-time-format');
			$ftsTimezone = get_option('bcf-timezone');
			date_default_timezone_set(get_option('bcf-timezone'));
	   ?>
      <div style="float:left; max-width:400px; margin-right:30px;">
        <h2>
          <?php _e('Date Format', 'basecamp-feed'); ?>
        </h2>
        <fieldset>
          <select id="fts-date-and-time-format" name="bcf-date-and-time-format">
            <option value="l, F jS, Y \a\t g:ia" <?php if ($ftsDateTimeFormat == 'l, F jS, Y \a\t g:ia' ) echo 'selected="selected"'; ?>><?php echo date('l, F jS, Y \a\t g:ia'); ?></option>
            <option value="F j, Y \a\t g:ia" <?php if ($ftsDateTimeFormat == 'F j, Y \a\t g:ia' ) echo 'selected="selected"'; ?>><?php echo date('F j, Y \a\t g:ia'); ?></option>
            <option value="F j, Y g:ia" <?php if ($ftsDateTimeFormat == 'F j, Y g:ia' ) echo 'selected="selected"'; ?>><?php echo date('F j, Y g:ia'); ?></option>
            <option value="F, Y \a\t g:ia" <?php if ($ftsDateTimeFormat == 'F, Y \a\t g:ia' ) echo 'selected="selected"'; ?>><?php echo date('F, Y \a\t g:ia'); ?></option>
            <option value="M j, Y @ g:ia" <?php if ($ftsDateTimeFormat == 'M j, Y @ g:ia' ) echo 'selected="selected"'; ?>><?php echo date('M j, Y @ g:ia'); ?></option>
            <option value="M j, Y @ G:i" <?php if ($ftsDateTimeFormat == 'M j, Y @ G:i' ) echo 'selected="selected"'; ?>><?php echo date('M j, Y @ G:i'); ?></option>
            <option value="m/d/Y \a\t g:ia" <?php if ($ftsDateTimeFormat == 'm/d/Y \a\t g:ia' ) echo 'selected="selected"'; ?>><?php echo date('m/d/Y \a\t g:ia'); ?></option>
            <option value="m/d/Y @ G:i" <?php if ($ftsDateTimeFormat == 'm/d/Y @ G:i' ) echo 'selected="selected"'; ?>><?php echo date('m/d/Y @ G:i'); ?></option>
            <option value="d/m/Y \a\t g:ia" <?php if ($ftsDateTimeFormat == 'd/m/Y \a\t g:ia' ) echo 'selected="selected"'; ?>><?php echo date('d/m/Y \a\t g:ia'); ?></option>
            <option value="d/m/Y @ G:i" <?php if ($ftsDateTimeFormat == 'd/m/Y @ G:i' ) echo 'selected="selected"'; ?>><?php echo date('d/m/Y @ G:i'); ?></option>
            <option value="Y/m/d \a\t g:ia" <?php if ($ftsDateTimeFormat == 'Y/m/d \a\t g:ia' ) echo 'selected="selected"'; ?>><?php echo date('Y/m/d \a\t g:ia'); ?></option>
            <option value="Y/m/d @ G:i" <?php if ($ftsDateTimeFormat == 'Y/m/d @ G:i' ) echo 'selected="selected"'; ?>><?php echo date('Y/m/d @ G:i'); ?></option>
          </select>
        </fieldset>
      </div>
      <div style="float:left; max-width:330px">
        <h2>
          <?php _e('TimeZone', 'basecamp-feed'); ?>
        </h2>
        <fieldset>
          <select id="fts-timezone" name="bcf-timezone">
            <option value="Pacific/Midway" <?php if($ftsTimezone == "Pacific/Midway") echo 'selected="selected"' ?> >
            <?php _e('UTC-11:00'); ?>
            </option>
            <option value="Etc/UTC+10" <?php if($ftsTimezone == "Etc/UTC+10") echo 'selected="selected"' ?> >
            <?php _e('UTC-10:00'); ?>
            </option>
            <option value="Pacific/Marquesas" <?php if($ftsTimezone == "Pacific/Marquesas") echo 'selected="selected"' ?> >
            <?php _e('UTC-09:30'); ?>
            </option>
            <option value="Pacific/Gambier" <?php if($ftsTimezone == "Pacific/Gambier") echo 'selected="selected"' ?> >
            <?php _e('UTC-09:00'); ?>
            </option>
            <option value="Etc/UTC+8" <?php if($ftsTimezone == "Etc/UTC+8") echo 'selected="selected"' ?> >
            <?php _e('UTC-08:00'); ?>
            </option>
            <option value="America/Denver" <?php if($ftsTimezone == "America/Denver") echo 'selected="selected"' ?> >
            <?php _e('UTC-07:00'); ?>
            </option>
            <option value="America/Chicago" <?php if($ftsTimezone == "America/Chicago") echo 'selected="selected"' ?> >
            <?php _e('UTC-06:00'); ?>
            </option>
            <option value="America/Havana" <?php if($ftsTimezone == "America/Havana") echo 'selected="selected"' ?> >
            <?php _e('UTC-05:00'); ?>
            </option>
            <option value="America/Caracas" <?php if($ftsTimezone == "America/Caracas") echo 'selected="selected"' ?> >
            <?php _e('UTC-04:30'); ?>
            </option>
            <option value="America/Glace_Bay" <?php if($ftsTimezone == "America/Glace_Bay") echo 'selected="selected"' ?> >
            <?php _e('UTC-04:00'); ?>
            </option>
            <option value="America/St_Johns" <?php if($ftsTimezone == "America/St_Johns") echo 'selected="selected"' ?> >
            <?php _e('UTC-03:30'); ?>
            </option>
            <option value="America/Sao_Paulo" <?php if($ftsTimezone == "America/Sao_Paulo") echo 'selected="selected"' ?> >
            <?php _e('UTC-03:00'); ?>
            </option>
            <option value="America/Noronha" <?php if($ftsTimezone == "America/Noronha") echo 'selected="selected"' ?> >
            <?php _e('UTC-02:00'); ?>
            </option>
            <option value="Atlantic/Cape_Verde" <?php if($ftsTimezone == "Atlantic/Cape_Verde") echo 'selected="selected"' ?> >
            <?php _e('UTC-01:00'); ?>
            </option>
            <option value="Europe/Belfast" <?php if($ftsTimezone == "Europe/Belfast") echo 'selected="selected"' ?> >
            <?php _e('UTC'); ?>
            <option value="Europe/Amsterdam" <?php if($ftsTimezone == "Europe/Amsterdam") echo 'selected="selected"' ?> >
            <?php _e('UTC+01:00'); ?>
            </option>
            <option value="Asia/Beirut" <?php if($ftsTimezone == "Asia/Beirut") echo 'selected="selected"' ?> >
            <?php _e('UTC+02:00'); ?>
            </option>
            <option value="Europe/Moscow" <?php if($ftsTimezone == "Europe/Moscow") echo 'selected="selected"' ?> >
            <?php _e('UTC+03:00'); ?>
            </option>
            <option value="Asia/Tehran" <?php if($ftsTimezone == "Asia/Tehran") echo 'selected="selected"' ?> >
            <?php _e('UTC+03:30'); ?>
            </option>
            <option value="Asia/Yerevan" <?php if($ftsTimezone == "Asia/Yerevan") echo 'selected="selected"' ?> >
            <?php _e('UTC+04:00'); ?>
            </option>
            <option value="Asia/Kabul" <?php if($ftsTimezone == "Asia/Kabul") echo 'selected="selected"' ?> >
            <?php _e('UTC+04:30'); ?>
            </option>
            <option value="Asia/Tashkent" <?php if($ftsTimezone == "Asia/Tashkent") echo 'selected="selected"' ?> >
            <?php _e('UTC+05:00'); ?>
            </option>
            <option value="Asia/Kolkata" <?php if($ftsTimezone == "Asia/Kolkata") echo 'selected="selected"' ?> >
            <?php _e('UTC+05:30'); ?>
            </option>
            <option value="Asia/Katmandu" <?php if($ftsTimezone == "Asia/Katmandu") echo 'selected="selected"' ?> >
            <?php _e('UTC+05:45'); ?>
            </option>
            <option value="Asia/Dhaka" <?php if($ftsTimezone == "Asia/Dhaka") echo 'selected="selected"' ?> >
            <?php _e('UTC+06:00'); ?>
            </option>
            <option value="Asia/Novosibirsk" <?php if($ftsTimezone == "Asia/Novosibirsk") echo 'selected="selected"' ?> >
            <?php _e('UTC+06:00'); ?>
            </option>
            <option value="Asia/Rangoon" <?php if($ftsTimezone == "Asia/Rangoon") echo 'selected="selected"' ?> >
            <?php _e('UTC+06:30'); ?>
            </option>
            <option value="Asia/Bangkok" <?php if($ftsTimezone == "Asia/Bangkok") echo 'selected="selected"' ?> >
            <?php _e('UTC+07:00'); ?>
            </option>
            <option value="Australia/Perth" <?php if($ftsTimezone == "Australia/Perth") echo 'selected="selected"' ?> >
            <?php _e('UTC+08:00'); ?>
            </option>
            <option value="Australia/Eucla" <?php if($ftsTimezone == "Australia/Eucla") echo 'selected="selected"' ?> >
            <?php _e('UTC+08:45'); ?>
            </option>
            <option value="Asia/Tokyo" <?php if($ftsTimezone == "Asia/Tokyo") echo 'selected="selected"' ?> >
            <?php _e('UTC+09:00'); ?>
            </option>
            <option value="Australia/Adelaide" <?php if($ftsTimezone == "Australia/Adelaide") echo 'selected="selected"' ?> >
            <?php _e('UTC+09:30'); ?>
            </option>
            <option value="Australia/Hobart" <?php if($ftsTimezone == "Australia/Hobart") echo 'selected="selected"' ?> >
            <?php _e('UTC+10:00'); ?>
            </option>
            <option value="Australia/Lord_Howe" <?php if($ftsTimezone == "Australia/Lord_Howe") echo 'selected="selected"' ?> >
            <?php _e('UTC+10:30'); ?>
            </option>
            <option value="Etc/UTC-11" <?php if($ftsTimezone == "Etc/UTC-11") echo 'selected="selected"' ?> >
            <?php _e('UTC+11:00'); ?>
            </option>
            <option value="Pacific/Norfolk" <?php if($ftsTimezone == "Pacific/Norfolk") echo 'selected="selected"' ?> >
            <?php _e('UTC+11:30'); ?>
            </option>
            <option value="Asia/Anadyr" <?php if($ftsTimezone == "Asia/Anadyr") echo 'selected="selected"' ?> >
            <?php _e('UTC+12:00'); ?>
            </option>
            <option value="Pacific/Chatham" <?php if($ftsTimezone == "Pacific/Chatham") echo 'selected="selected"' ?> >
            <?php _e('UTC+12:45'); ?>
            </option>
            <option value="Pacific/Tongatapu" <?php if($ftsTimezone == "Pacific/Tongatapu") echo 'selected="selected"' ?> >
            <?php _e('UTC+13:00'); ?>
            </option>
            <option value="Pacific/Kiritimati" <?php if($ftsTimezone == "Pacific/Kiritimati") echo 'selected="selected"' ?> >
            <?php _e('UTC+14:00'); ?>
            </option>
          </select>
        </fieldset>
      </div>
      <div class="clear"></div>
      <br/>
      <h2>
        <?php _e('Custom CSS Option', 'basecamp-feed'); ?>
      </h2>
      <p>
        <input name="bcf-color-options-settings-custom-css" class="fts-color-settings-admin-input" type="checkbox"  id="fts-color-options-settings-custom-css" value="1" <?php echo checked( '1', get_option( 'bcf-color-options-settings-custom-css' ) ); ?>/>
        <?php  
							if (get_option( 'bcf-color-options-settings-custom-css' ) == '1') { ?>
        <strong>
        <?php _e('Checked:', 'basecamp-feed'); ?>
        </strong>
        <?php _e('Custom CSS option is being used now.', 'basecamp-feed'); ?>
        <?php
							}
							else	{ ?>
        <strong>
        <?php _e('Not Checked:', 'basecamp-feed'); ?>
        </strong>
        <?php _e('You are using the default CSS.', 'basecamp-feed'); ?>
        <?php
							}
							   ?>
      </p>
      <label class="toggle-custom-textarea-show"><span>
        <?php _e('Show', 'basecamp-feed'); ?>
        </span><span class="toggle-custom-textarea-hide">
        <?php _e('Hide', 'basecamp-feed'); ?>
        </span>
        <?php _e('custom CSS', 'basecamp-feed'); ?>
      </label>
      <div class="clear"></div>
      <div class="fts-custom-css-text">
        <?php _e('Thanks for using our plugin :) Add your custom CSS additions or overrides below.', 'basecamp-feed'); ?>
      </div>
      <textarea name="bcf-color-options-main-wrapper-css-input" class="fts-color-settings-admin-input" id="fts-color-options-main-wrapper-css-input"><?php echo get_option('bcf-color-options-main-wrapper-css-input'); ?></textarea>
    </div>
    <!--/feed-them-custom-css-->
    
    <div class="feed-them-custom-logo-css">
      <h2>
        <?php _e('Powered by Text', 'basecamp-feed'); ?>
      </h2>
      <p>
        <input name="bcf-powered-text-options-settings" class="fts-powered-by-settings-admin-input" type="checkbox" id="fts-powered-text-options-settings" value="1" <?php echo checked( '1', get_option( 'bcf-powered-text-options-settings' ) ); ?>/>
        <?php  
				if (get_option( 'bcf-powered-text-options-settings' ) == '1') { ?>
        <strong>
        <?php _e('Checked:', 'basecamp-feed'); ?>
        </strong>
        <?php _e('You are not showing the Powered by Logo.', 'basecamp-feed'); ?>
        <?php
				}
				else	{ ?>
        <strong>
        <?php _e('Not Checked:', 'basecamp-feed'); ?>
        </strong>
        <?php _e('The Powered by text will appear in the site. Awesome! Thanks so much for sharing.', 'basecamp-feed'); ?>
        <?php
				}
			 ?>
      </p>
      <br/>
      <input type="submit" class="feed-them-social-admin-submit-btn" value="<?php _e('Save All Changes', 'basecamp-feed') ?>" />
      <div class="clear"></div>
    </div>
    <!--/feed-them-custom-logo-css-->
    
  </form>
  <a class="feed-them-social-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a> </div>
<!--/feed-them-social-admin-wrap--> 
<script>
    jQuery(function() {    
    // Master feed selector
    jQuery('#shortcode-form-selector').change(function(){
        jQuery('.shortcode-generator-form').hide();
        jQuery('.' + jQuery(this).val()).fadeIn('fast');
    });
    
	  jQuery('#bcf-todo-list-id').change(function(){	 
			jQuery("#bcf-todo-list-id").find("option:selected").each(function(){
			var opt_id = jQuery(this).parent().attr("id");
			jQuery('#bcf-project-id').val(opt_id);
	  });
    });
 });
	
	 jQuery('#facebook-messages-selector').bind('change', function (e) { 
		if(jQuery('select#facebook-messages-selector').val() == 'page') {
		 jQuery('.to-dos-list-id-option').show();
		 jQuery('.project-id-select-wrap').hide();
		}
	});
	
	 jQuery('#facebook-messages-selector').bind('change', function (e) { 
		if(jQuery('select#facebook-messages-selector').val() == 'group') {
		 jQuery('.to-dos-list-id-option').hide();
		 jQuery('.project-id-select-wrap').show();
		}
	});
	
    //START Page JS/
    function updateTextArea_fb_page() {
    var account_id = ' account_id=' + jQuery("input#bcf-account-id").val(); 
    var project_id = ' project_id=' + jQuery("select#bcf-project-id").val();
    var completed = ' show_completed=' + jQuery("select#bcf-completed").val();
    var todo_list_id = ' todo_list_id=' + jQuery("select#bcf-todo-list-id").val();
    
	
    if (account_id == " account_id=") {
         jQuery(".fb_page_id").addClass('fts-empty-error');  
         jQuery("input#account_id").focus();
         return false;
    }
    if (account_id != " account_id=") {
         jQuery(".fb_page_id").removeClass('fts-empty-error');  
    }
    
                
                if (jQuery("select#facebook-messages-selector").val() == "page") {
                    var final_fb_page_shortcode = '[BCF single todo list' + account_id + project_id + todo_list_id + completed + ']';
			   }
			   else {
				   var final_fb_page_shortcode = '[BCF multi todo list' + account_id + project_id + completed +']';
			   }
              
    jQuery('.facebook-page-final-shortcode').val(final_fb_page_shortcode);
    
    jQuery('.fb-page-shortcode-form .final-shortcode-textarea').slideDown();
    
    }
    //END Page//
    
    
    //select all 
    jQuery(".copyme").focus(function() {
    var jQuerythis = jQuery(this);
    jQuerythis.select();
    
    // Work around Chrome's little problem
    jQuerythis.mouseup(function() {
        // Prevent further mouseup intervention
        jQuerythis.unbind("mouseup");
        return false;
    });
    });
    
    jQuery( document ).ready(function() {
    jQuery( ".toggle-custom-textarea-show" ).click(function() {  
         jQuery('textarea#fts-color-options-main-wrapper-css-input').slideToggle();
          jQuery('.toggle-custom-textarea-show span').toggle();
          jQuery('.fts-custom-css-text').toggle();
          
    }); 
    <?php
    //show the js for the discount option under social icons on the settings page
    if(is_plugin_active('feed-them-premium/feed-them-premium.php')) {
                // do not show the js below
        }
    else { ?>
        jQuery( "#discount-for-review" ).click(function() {  
             jQuery('.discount-review-text').slideToggle();
        });
    <?php } ?>
    }); //end document ready
    </script>
<?php
   
    }
	
}//END CLASS
new BaseCamp_Feed_settings();
?>
