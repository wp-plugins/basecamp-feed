<?php
namespace BaseCamp_Feed;

class BaseCamp_Feed_Options extends BaseCamp_Feed_Main {

	function __construct() {
		if ( is_admin() ){
		  //Add Admin Menu Pages
		  add_action('admin_menu', array( $this,'add_options_submenu_page'));
		  //Register Options Page Settings
		  add_action('admin_init', array( $this,'style_options_page' ));
		}
	}
	//**************************************************
	// Admin Menu
	//**************************************************
	function  add_options_submenu_page() {   
		//System Info
		add_submenu_page('basecamp-feed-settings-page', __('Options', 'basecamp-feed'), __('Options', 'basecamp-feed'), 'manage_options','basecamp-feed-options-submenu-page', array( $this,'options_page'));
	}
	///**************************************************
	// Register Settings Page Settings
	//***************************************************
	function style_options_page() { 
		$basecamp_style_options = array(
		 // To-Do List Options
		'bcf_todos_title_color',
		'bcf_todos_title_size',
		
		'bcf_todos_description_text_color',
		'bcf_todos_description_text_size',
		'bcf_todos_description_style',
		
		'bcf_todos_border_color',
		'bcf_todos_border_size',
		
		'bcf_todos_text_color',
		'bcf_todos_text_size',
		
		'bcf_todos_completed_header_text_color',
		'bcf_todos_completed_header_text_size',
		
		'bcf_todos_completed_text_color',
		'bcf_todos_completed_text_size',
		
		'bcf_todos_completed_content_color',
		'bcf_todos_completed_content_size',
		
		'bcf_todos_completed_checkmark_color',
		'bcf_todos_completed_checkmark_size',
		
		'bcf_todos_completed_date_color',
		'bcf_todos_completed_date_size',
		'bcf_todos_completed_date_style',
		
		 // Calendar Options
        'bcf_calendar_main_title_text_color',
        'bcf_calendar_main_title_text_size',
        'bcf_calendar_color',
        'bcf_calendar_title_color',
        'bcf_calendar_title_size',
        'bcf_calendar_description_text_color',
        'bcf_calendar_description_text_size',
         );
		$this->register_settings('fts-basecamp-feed-style-options', $basecamp_style_options);
	}
	

	///**************************************************
	// Settings Page Display
	//***************************************************
	function options_page() { 
	wp_enqueue_script( 'feed_them_style_options_color_js', plugins_url( 'admin/js/jscolor/jscolor.js',  dirname(__FILE__) ) );
	?>
	    
    
    				
    <div class="feed-them-social-admin-wrap"> 
    
    
     <h1><?php _e('BaseCamp Feed Options', 'basecamp-feed'); ?></h1>
      <div class="use-of-plugin"><p><?php _e('Change the text color, text size and more of your Basecamp To-Do List(s) or Calendar(s) using the options below.', 'basecamp-feed'); ?></p></div>
      <!-- custom option for padding -->
      <form method="post" class="fts-facebook-feed-options-form" action="options.php">
      <?php // get our registered settings from the fts functions 
               settings_fields('fts-basecamp-feed-style-options'); ?>        
           
    
		
<div class="tabs">    
    <div class="tab-1 active">To-Do List Styles</div>
    <div class="tab-2">Calendar Styles</div>
</div>
           <div class='clear'></div>
      <div class="content-1">
      <h2><?php _e('To-Do List(s)', 'basecamp-feed'); ?></h2>   
<?php 
		///**************************************************
		// Need Premium ToDo Options
		//***************************************************
        if (!is_plugin_active('basecamp-feed-premium/basecamp-feed-premium.php')){
	        //To Do Lists
			//Declaring this variable with no value and then modifying it when appropriate
			$output = '';
                $bfc_todo_options = array(
	                __('Title', 'basecamp-feed') => array(
	                	__('Title Color', 'basecamp-feed'),
						__('Title Size', 'basecamp-feed'),
                    ),
                    __('Description', 'basecamp-feed') => array(
	                	__('Text Color', 'basecamp-feed'),
	                    __('Text Size', 'basecamp-feed'),
	                    __('Text Style', 'basecamp-feed'),
                    ),
                    __('Header Border', 'basecamp-feed') => array(
	                	__('Border Color', 'basecamp-feed'),
						__('Border Size', 'basecamp-feed'),
                    ),
                    __('Content', 'basecamp-feed') => array(
	                	    __('Text Color', 'basecamp-feed'),
	                    __('Text Size', 'basecamp-feed'),
                    ),                    
                );//End Main Array
                 
			$output .= $this->need_bcf_premium_fields($bfc_todo_options);
			
			//Completed To Do Lists
			$output .= '<h2>'.__('Completed List(s)', 'basecamp-feed').'</h2>';
			$bfc_completed_todo_options = array(
	                __('Header', 'basecamp-feed') => array(
	                	__('Title Color', 'basecamp-feed'),
						__('Title Size', 'basecamp-feed'),
                    ),
                    __('Content', 'basecamp-feed') => array(
	                	__('Text Color', 'basecamp-feed'),
	                    __('Text Size', 'basecamp-feed'),
                    ),
                    __('Checkmark', 'basecamp-feed') => array(
	                	__('Checkmark Color', 'basecamp-feed'),
						__('Checkmark Size', 'basecamp-feed'),
                    ),                    
                 );//End Main Array
                 
			$output .= $this->need_bcf_premium_fields($bfc_completed_todo_options);
			
			//Both Completed AND To Do Lists
			$output .= '<h2>'.__('To-Do & Completed List(s)', 'basecamp-feed').'</h2>';
			$bfc_both_completed_todo_options = array(
	                __('Date', 'basecamp-feed') => array(
	                	__('Date Color', 'basecamp-feed'),
						__('Date Size', 'basecamp-feed'),
						__('Date Date Font Style', 'basecamp-feed'),
                    ),
     
                 );//End Main Array
                 
			$output .= $this->need_bcf_premium_fields($bfc_both_completed_todo_options);
			
			echo $output;
			
         }else { 		 
			 include(WP_CONTENT_DIR.'/plugins/basecamp-feed-premium/admin/basecamp-feed-todo-options.php');
		 }//END IF PREMIUM ?>   
         </div> 
          <div class="clear"></div>
          
  
            
		  <div class="content-2">
<?php 
		///**************************************************
		// Need Premium Calendar Options
		//***************************************************
        if (!is_plugin_active('basecamp-feed-premium/basecamp-feed-premium.php')){
	        //To Do Lists
			$output = '<h2>'.__('Calendar List(s)', 'basecamp-feed').'</h2>';
                $bfc_calendar_options = array(
	                __('Calendar', 'basecamp-feed') => array(
	                	__('Title Color', 'basecamp-feed'),
						__('Title Size', 'basecamp-feed'),
                    ),
                    __('Calendar Color', 'basecamp-feed') => array(
	                	__('Color of Calendar', 'basecamp-feed'),
                    ),
                    __('Event Title', 'basecamp-feed') => array(
	                	__('Title color', 'basecamp-feed'),
						__('Title size', 'basecamp-feed'),
                    ),
                    __('Description', 'basecamp-feed') => array(
	                	__('Text Color', 'basecamp-feed'),
	                    __('Text Size', 'basecamp-feed'),
                    ),                    
                );//End Main Array
                 
			$output .= $this->need_bcf_premium_fields($bfc_calendar_options);     
			
			echo $output;
			
         }else { 
	         include(WP_CONTENT_DIR.'/plugins/basecamp-feed-premium/admin/basecamp-feed-calendar-options.php');
	     }//END IF PREMIUM ?>                              
           </div>
        <div class="clear"></div>
       
       <input type="submit" class="feed-them-social-admin-submit-btn" value="<?php _e('Save All Changes') ?>" />
       </form>
                
        <a class="feed-them-social-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a>
      
    </div><!--/feed-them-social-admin-wrap-->
    <script>
		jQuery( ".tab-1" ).click(function() {
		  jQuery( ".content-1" ).fadeIn();
		  jQuery( ".content-2" ).hide();
		  
		   jQuery( ".tab-1" ).addClass('active')
		   jQuery( ".tab-2" ).removeClass('active')
		});	
		jQuery( ".tab-2" ).click(function() {
		  jQuery( ".content-2" ).fadeIn();
		  jQuery( ".content-1" ).hide();
		  
		   jQuery( ".tab-2" ).addClass('active')
		   jQuery( ".tab-1" ).removeClass('active')
		});	
	</script>

<?php
    }
	
}//END CLASS
new BaseCamp_Feed_Options();
?>
