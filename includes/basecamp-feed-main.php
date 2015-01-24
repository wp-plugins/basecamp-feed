<?php
namespace BaseCamp_Feed;

class BaseCamp_Feed_Main {
	
	function __construct() {
		//If is in Admin Enqeue Styles & Scripts
		if (is_admin()){
		  // Admin Styles & Scripts
		  add_action('admin_enqueue_scripts', array( $this,'admin_css'));
		  // Settings Page Styles & Scripts
		  if (isset($_GET['page']) && $_GET['page'] == 'basecamp-feed-settings-page') {
			  add_action('admin_enqueue_scripts',  array( $this,'settings_page_styles_scripts'));
		  }
		  // System Info Page Styles & Scripts
		  if (isset($_GET['page']) && $_GET['page'] == 'basecamp-feed-info-submenu-page') {
			add_action('admin_enqueue_scripts', array( $this,'system_info_css'));
		  }
		}
	}
	//**************************************************
	// Admin Styles & Scripts
	//**************************************************
	function admin_css() {
		wp_register_style('basecamp-feed-admin', plugins_url( 'admin/css/admin.css', dirname(__FILE__) ) );  
		wp_enqueue_style('basecamp-feed-admin');
	}
	function settings_page_styles_scripts() {
		wp_register_style('basecamp-feed-settings-css', plugins_url( 'admin/css/settings-page.css',  dirname(__FILE__) ) );
		wp_enqueue_style('basecamp-feed-settings-css'); 
		wp_enqueue_script('basecamp-feed-settings-js', plugins_url( 'admin/js/admin.js',  dirname(__FILE__) ) );
	}
	function system_info_css() {
		wp_register_style('basecamp-feed-settings-admin-css', plugins_url( 'admin/css/admin-settings.css',  dirname(__FILE__) ) );
		wp_enqueue_style('basecamp-feed-settings-admin-css'); 
	}
	//**************************************************
	// Admin Styles & Scripts
	//**************************************************
	function get_check_plugin_version($plugin_file = 'feed-them-premium.php', $version_needed = '1.0.0', $return_version = false) {
		if (!empty($_GET['activate'])){
		  if (is_admin() && $_GET['activate'] == 'true') {
			  require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			  $plugins = get_plugins();
			
			  foreach($plugins as $plugin_file => $plugin_info) {
				  
				  //Check if plugin is active if not don't bug em
				  if (is_plugin_active($plugin_file)) {
						$plugin_file_name = explode('/', $plugin_file);
						
							if ($plugin_file_name[1] == $_plugin_file && $plugin_info['Version'] < $version_needed){
								$download_location = "__( 'If you have not received an update notification for this plugin you may re-download the plugin/extension from your <a href='http://slickremix.com/my-account' target='_blank'>SlickRemix 'My Account' page.</a>, 'fts-bar' ) . ";
							   
								$error_msg = '<div class="error"><p>' . __( 'Warning: <strong>'.$plugin_info['Name'].'</strong> needs to be <strong>UPDATED</strong> to <strong>version '.$version_needed.'</strong> to function properly. '.$download_location, 'fts-bar' ) . '</p></div>';
							  
							   add_action( 'admin_notices', function() use ($error_msg) {
									echo $error_msg;
							   });
							   
							   deactivate_plugins($plugin_file);
							   
							   return $error_msg;
							}
				  }
			  }
		  }
		}
	}
	//**************************************************
	// Register Settings
	//**************************************************
	function register_settings($settings_name ,$settings)	{
		foreach($settings as $key => $setting)	{
			register_setting( $settings_name, $setting);
		}
	}
	//**************************************************
	// Clean Date & Time
	//**************************************************
	function clean_date_time($bcf_time){
		  //Set Time Format
		  $CustomDateCheck = get_option('bcf-date-and-time-format');
		  $CustomDateFormatBCF = !empty($CustomDateCheck) ? get_option('bcf-date-and-time-format') : 'F jS, Y \a\t g:ia';
		  
		  //Set TimeZone
		  date_default_timezone_set(get_option('bcf-timezone'));
		  
		  return date($CustomDateFormatBCF ,strtotime($bcf_time));
	}
}//END Class
new BaseCamp_Feed_Main();
?>