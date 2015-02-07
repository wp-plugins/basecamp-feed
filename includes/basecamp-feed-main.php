<?php
namespace BaseCamp_Feed;

class BaseCamp_Feed_Main {
	
	function __construct() {
		//If is in Admin Enqeue Styles & Scripts
		if (is_admin()){
		  // Admin Styles & Scripts
		  add_action('admin_enqueue_scripts', array( $this,'admin_css'));
		  // Settings Page Styles & Scripts
		  if (isset($_GET['page']) && $_GET['page'] == 'basecamp-feed-settings-page' or isset($_GET['page']) && $_GET['page'] == 'basecamp-feed-options-submenu-page') {
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
	}
	function system_info_css() {
		wp_register_style('basecamp-feed-settings-admin-css', plugins_url( 'admin/css/admin-settings.css',  dirname(__FILE__) ) );
		wp_enqueue_style('basecamp-feed-settings-admin-css'); 
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
	// Display Need Premium Fields
	//**************************************************
	function need_bcf_premium_fields($fields) {
		foreach($fields as $main_key => $label)	{
			$output = isset($output) ? $output : "";
			$output .= '<h3>'.$main_key.'</h3>';
			  foreach($label as $key => $sub_label)	{
				  $output .= '<div class="feed-them-social-admin-input-wrap">';
					  $output .= '<div class="feed-them-social-admin-input-label">'.$sub_label.'</div>';
					  $output .= '<div class="feed-them-social-admin-input-default">Must have <a target="_blank" href="http://www.slickremix.com/downloads/feed-them-social-premium-extension/">premium version</a> to edit.</div>';
					$output .= '<div class="clear"></div>';
				  $output .= '</div><!--/feed-them-social-admin-input-wrap-->';
			  }	  
			  
		}//END Foreach
		
		return $output;
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
	//**************************************************
	// Create an array of dated from two dates
	//**************************************************
	function createDateRangeArray($strDateFrom,$strDateTo){
	    $aryRange=array();
	
	    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));
	
	    if ($iDateTo>=$iDateFrom)
	    {
	        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
	        while ($iDateFrom<$iDateTo)
	        {
	            $iDateFrom+=86400; // add 24 hours
	            array_push($aryRange,date('Y-m-d',$iDateFrom));
	        }
	    }
	    return $aryRange;
	}
}//END Class
new BaseCamp_Feed_Main();
?>