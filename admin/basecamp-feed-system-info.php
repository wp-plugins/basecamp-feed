<?php
namespace BaseCamp_Feed;

class BaseCamp_Feed_System_Info extends BaseCamp_Feed_Main {

	function __construct() {
		//Add Admin Menu Pages
		add_action('admin_menu', array( $this,'submenu_pages'));
	}
	//**************************************************
	// Admin Add System Info Page to submenu
	//**************************************************
	function  submenu_pages() {   
		//System Info
		add_submenu_page('basecamp-feed-settings-page', __('System Info', 'basecamp-feed'), __('System Info', 'basecamp-feed'), 'manage_options','basecamp-feed-info-submenu-page', array( $this,'system_info_page'));
	}
	//**************************************************
	// Admin System Info Page
	//**************************************************
	function system_info_page(){
	?>
	<div class="fts-help-admin-wrap"> <a class="buy-extensions-btn" href="http://www.slickremix.com/downloads/category/feed-them-social/" target="_blank"><?php _e( 'Get Extensions Here!', 'basecamp-feed'); ?></a>
	  <h2><?php _e( 'System Info', 'basecamp-feed'); ?></h2>
	  <div class="fts-admin-help-wrap">
		<div class="use-of-plugin"><?php _e( "Can't figure out how to do something and need help? Use our", 'basecamp-feed'); ?> <a href="http://www.slickremix.com/support-forum/" target="_blank"><?php _e('Support Forum', 'basecamp-feed')?></a> <?php _e('and someone will respond to your request asap. Usually we will respond the same day, the latest the following day. You may also find some of the existing posts to be helpfull too, so take a look around first. If you do submit a question please','basecamp-feed')?> <a href="#" class="fts-debug-report"><?php _e('generate a report', 'basecamp-feed')?></a> <?php _e('and copy the info, ask your question in our','basecamp-feed')?> <a href="http://www.slickremix.com/support-forum/" target="_blank"><?php _e('Support Forum','basecamp-feed')?></a> <?php _e('then paste the info you just copied. That will help speed things along for sure.','basecamp-feed')?></div>
		</h3>
		<h3><?php _e( 'Plugin &amp; System Info', 'basecamp-feed'); ?></h3>
		<p><?php _e( 'Please','basecamp-feed'); ?> <a href="#" class="fts-debug-report"><?php _e( 'click here to generate a report', 'basecamp-feed'); ?></a> <?php _e( 'You will need to paste this information along with your question in our', 'basecamp-feed'); ?> <a href="http://www.slickremix.com/support-forum/" target="_blank"><?php _e( 'Support Forum', 'basecamp-feed'); ?></a>. <?php _e( 'Ask your question then paste the copied text below it.', 'basecamp-feed'); ?></p>
		<textarea id="fts-debug-report" readonly="readonly"></textarea>
		<table class="wc_status_table widefat" cellspacing="0">
		  <thead>
			<tr>
			  <th colspan="2"><?php _e( 'Versions','basecamp-feed'); ?></th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <td><?php _e('BaseCamp Feed Plugin version','basecamp-feed')?></td>
			  <td><?php echo bcf_system_version(); ?></td>
			</tr>
			<tr>
			  <td><?php _e('WordPress version','basecamp-feed')?></td>
			  <td><?php if ( is_multisite() ) echo 'WPMU'; else echo 'WP'; ?>
				<?php echo bloginfo('version'); ?></td>
			</tr>
			<tr>
			  <td><?php _e('Installed plugins', 'basecamp-feed')?></td>
			  <td><?php
							$active_plugins = (array) get_option( 'active_plugins', array() );
	
							if ( is_multisite() )
								$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
	
							$active_plugins = array_map( 'strtolower', $active_plugins );
	
							$wc_plugins = array();
	
							foreach ( $active_plugins as $plugin ) {
									$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
	
									if ( ! empty( $plugin_data['Name'] ) ) {
										$wc_plugins[] = $plugin_data['Name'] . ' ' . __('by', 'basecamp-feed') . ' ' . $plugin_data['Author'] . ' ' . __('version', 'basecamp-feed') . ' ' . $plugin_data['Version'];
									}
							}
							if ( sizeof( $wc_plugins ) == 0 ) echo '-'; else echo '<ul><li>' . implode( ', </li><li>', $wc_plugins ) . '</li></ul>';
	
						?></td>
			</tr>
		  </tbody>
		  <thead>
			<tr>
			  <th colspan="2"><?php _e( 'Server Environment', 'basecamp-feed'); ?></th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <td><?php _e('PHP Version', 'basecamp-feed')?></td>
			  <td><?php
							if ( function_exists( 'phpversion' ) )
							
							$phpversion = phpversion();
							$phpcheck = '5.2.9';
							
							if($phpversion > $phpcheck) {
								 echo phpversion();
							}
							else {
								echo phpversion();
								echo '<br/><mark class="no">'; 
								_e('WARNING: ', 'basecamp-feed');
								echo '</mark>';
								 _e('Your version of php must be 5.3 or greater to use this plugin. Please upgrade the php by contacting your host provider. Some host providers will allow you to change this yourself in the hosting control panel too.', 'basecamp-feed');
							}
						?></td>
			</tr>
			<tr>
			  <td><?php _e('Server Software', 'basecamp-feed');?></td>
			  <td><?php
							echo $_SERVER['SERVER_SOFTWARE'];
						?></td>
			</tr>
			<tr>
			  <td><?php _e('WP Max Upload Size', 'basecamp-feed'); ?></td>
			  <td><?php
							echo size_format( wp_max_upload_size() );
						?></td>
			</tr>
			<tr>
			  <td><?php _e('WP Debug Mode', 'basecamp-feed')?></td>
			  <td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">' . __('Yes', 'feed-them-social') . '</mark>'; else echo '<mark class="no">' . __('No', 'feed-them-social') . '</mark>'; ?></td>
			</tr>
			<tr>
			  <td><?php _e('fsockopen', 'basecamp-feed')?></td>
			  <td><?php
	 if(function_exists('fsockopen')) {
		  _e('fsockopen is ON', 'basecamp-feed');
	 }
	 else {
		 _e('fsockopen is not enabled and must be set to ON for our plugin to work properly with all feeds.','feed-them-social');
	 }
	 ?></td>
			</tr>
			
			<tr>
			<td><?php _e('cURL', 'basecamp-feed');?></td>
			<td><?php
			// Script to test if the CURL extension is installed on this server
	
	// Define function to test
	function _fts_is_curl_installed() {
		if  (in_array  ('curl', get_loaded_extensions())) {
			return true;
		}
		else {
			return false;
		}
	}
	
	// Ouput text to user based on test
	if (_fts_is_curl_installed()) {
		 _e('cURL is ', 'basecamp-feed');
		 echo '<span style="color:blue">';
		 _e('installed', 'basecamp-feed');
		 echo '</span> ';
		 _e('on this server', 'basecamp-feed');
		 
		 
	} else {
		 _e('cURL is NOT ', 'basecamp-feed');
		 echo '<span style="color:red">';
		 _e('installed', 'basecamp-feed');
		 echo '</span> ';
		 _e('on this server', 'basecamp-feed');
	}
	?></td>
			</tr>
		  </tbody>
		</table>
	  </div>
	  <!--/fts-admin-help-faqs-wrap--> 
	  
	  <a class="fts-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a> </div>
	<!--/fts-help-admin-wrap--> 
	<script type="text/javascript">
			jQuery('a.fts-debug-report').click(function(){
	
				if ( ! jQuery('#fts-debug-report').val() ) {
	
					// Generate report - user can paste into forum
					var report = '`';
	
					jQuery('thead, tbody', '.wc_status_table').each(function(){
	
						$this = jQuery( this );
	
						if ( $this.is('thead') ) {
	
							report = report + "\n=============================================================================================\n";
							report = report + " " + jQuery.trim( $this.text() ) + "\n";
							report = report + "=============================================================================================\n";
	
						} else {
	
							jQuery('tr', $this).each(function(){
	
								$this = jQuery( this );
	
								report = report + $this.find('td:eq(0)').text() + ": \t";
								report = report + $this.find('td:eq(1)').text() + "\n";
	
							});
						}
					});
					report = report + '`';
					jQuery('#fts-debug-report').val( report );
				}
				jQuery('#fts-debug-report').slideToggle('500', function() {
					jQuery(this).select();
				});
				return false;
			});
	
		</script>
	<?php
	}

}//END CLASS
new BaseCamp_Feed_System_Info();
?>