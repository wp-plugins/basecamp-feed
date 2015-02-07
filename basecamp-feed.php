<?php
/*
Plugin Name: BaseCamp Feed
Plugin URI: http://slickremix.com/
Description: Allows you to display single or multiple To-do Lists from Basecamp
Version: 1.0.1
Author: SlickRemix
Author URI: http://slickremix.com/
Requires at least: wordpress 3.4.0
Tested up to: WordPress 4.0.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

 * @package    			BaseCamp Feed
 * @category   			Core
 * @author     		    SlickRemix
 * @copyright  			Copyright (c) 2012-2015 SlickRemix

If you need support or want to tell us thanks please contact us at support@slickremix.com or use our support forum on slickremix.com.
*/
define( 'BASECAMP_FEED_PLUGIN_PATH', plugins_url());

if ( ! function_exists( 'is_plugin_active' ) )
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    // Makes sure the plugin is defined before trying to use it

// Make sure php version is greater than 5.3
if ( function_exists( 'phpversion' ) )			
					$phpversion = phpversion();
					$phpcheck = '5.2.9';

if ($phpversion > $phpcheck) {
						
	function basecamp_feed_language_init(){
	  // Localization
	  load_plugin_textdomain('basecamp-feed', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
	// Add actions
	add_action('init', 'basecamp_feed_language_init');
	
	$basecamp_feed_plugin_rel_url = plugin_dir_path( __FILE__ );
	
	//Include BaseCamp classes/shortcodes
	include($basecamp_feed_plugin_rel_url.'updates/update-functions.php' );
	include($basecamp_feed_plugin_rel_url.'basecamp/attachment.php');
	include($basecamp_feed_plugin_rel_url.'basecamp/object.php');
	include($basecamp_feed_plugin_rel_url.'basecamp/project.php');
	include($basecamp_feed_plugin_rel_url.'basecamp/person.php');
	include($basecamp_feed_plugin_rel_url.'includes/basecamp.class.php');
	include($basecamp_feed_plugin_rel_url.'includes/basecamp-feed-main.php');
	include($basecamp_feed_plugin_rel_url.'admin/basecamp-feed-settings-page.php');
	include($basecamp_feed_plugin_rel_url.'admin/basecamp-feed-options-page.php');
	include($basecamp_feed_plugin_rel_url.'admin/basecamp-feed-system-info.php');
	include($basecamp_feed_plugin_rel_url.'feeds/to-do-list/to-do-list.php');
	
	
	function bcf_system_version() {
		$plugin_data = get_plugin_data( __FILE__ );
		$plugin_version = $plugin_data['Version'];
		return $plugin_version;
	}
	
} // end if php version check
else  {
		//if the php version is not at least 5.3 do action
		deactivate_plugins( 'basecamp-feed/basecamp-feed.php' ); 
		
	    	if ($phpversion < $phpcheck) {
			
		add_action( 'admin_notices', 'bcf_required_php_check1' );	
		function bcf_required_php_check1() {
				echo '<div class="error"><p>' . __( '<strong>Warning:</strong> Your php version is '.phpversion().'. You need to be running at least 5.3 or greater to use this plugin. Please upgrade the php by contacting your host provider. Some host providers will allow you to change this yourself in the hosting control panel too.<br/><br/>If you are hosting with BlueHost or Godaddy and the php version above is saying you are running 5.2.17 but you are really running something higher please <a href="https://wordpress.org/support/topic/php-version-difference-after-changing-it-at-bluehost-php-config?replies=4" target="_blank">click here for the fix</a>. If you cannot get it to work using the method described in the link please contact your host provider and explain the problem so they can fix it.', 'basecamp-feed' ) . '</p></div>';
		}
	   }
} // end fts_required_php_check
?>