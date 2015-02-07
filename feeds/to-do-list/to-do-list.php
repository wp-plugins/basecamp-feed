<?php
namespace BaseCamp_Feed;

class  BaseCamp_Feed_to_do_list extends BaseCamp_Feed_Main {
	
	function __construct() {
		add_shortcode( 'BCF multi todo list', array($this,'todo_multi_list_func'));
		add_shortcode( 'BCF single todo list', array($this,'todo_single_list_func'));
	
		add_action('wp_enqueue_scripts', array( $this,'frontend_head'));
		add_action('wp_head', array( $this,'todo_list_dynamic_css' ));
	}
	
	///**************************************************
	// Frontend Styles & Scripts
	//***************************************************
	function frontend_head() {
		wp_enqueue_style( 'basecampfeed_css', plugins_url( 'to-do-list/css/styles.css',  dirname(__FILE__ ) ) );
		wp_register_style( 'basecampfeed-font-awesome-min', plugins_url( 'css/font-awesome.min.css', dirname(__FILE__) ) );  
		wp_enqueue_style('basecampfeed-font-awesome-min');
		
		//Settings option. Custom Powered by Feed Them Social Option
		$powered_text_options_settings =  get_option( 'bcf-powered-text-options-settings' );
		if ($powered_text_options_settings != '1') { 
		  wp_register_style( 'basecamp-feed-powered-by-css', plugins_url( 'basecamp-feed/css/powered-by.css',  basename( dirname( __FILE__ ) )) );
		  wp_enqueue_style('basecamp-feed-powered-by-css'); 
		  wp_enqueue_script( 'basecamp-feed-powered-by-js', plugins_url( 'basecamp-feed/js/powered-by.js',  basename( dirname( __FILE__ ) )), array( 'jquery' ));
		}
	}
	///**************************************************
	// Frontend Dynamic Styles from Options Page
	//***************************************************
	function  todo_list_dynamic_css() { 
		if(is_plugin_active('basecamp-feed-premium/basecamp-feed-premium.php')) {
			// To-Do List Styles
			$bcf_todos_title_color = get_option('bcf_todos_title_color');
			$bcf_todos_title_size = get_option('bcf_todos_title_size');
			
			$bcf_todos_description_text_color = get_option('bcf_todos_description_text_color');
			$bcf_todos_description_text_size = get_option('bcf_todos_description_text_size');
			$bcf_todos_description_style = get_option('bcf_todos_description_style');
			
		
			$bcf_todos_border_color = get_option('bcf_todos_border_color');
			$bcf_todos_border_size = get_option('bcf_todos_border_size');
			
			$bcf_todos_text_color = get_option('bcf_todos_text_color');			
			$bcf_todos_text_size = get_option('bcf_todos_text_size');
			
			$bcf_todos_completed_header_text_color = get_option('bcf_todos_completed_header_text_color');
			$bcf_todos_completed_header_text_size = get_option('bcf_todos_completed_header_text_size');
			
			$bcf_todos_completed_text_color = get_option('bcf_todos_completed_text_color');
			$bcf_todos_completed_text_size = get_option('bcf_todos_completed_text_size');
			
			$bcf_todos_completed_checkmark_color = get_option('bcf_todos_completed_checkmark_color');
			$bcf_todos_completed_checkmark_size = get_option('bcf_todos_completed_checkmark_size');
			
			$bcf_todos_completed_date_color = get_option('bcf_todos_completed_date_color');
			$bcf_todos_completed_date_size = get_option('bcf_todos_completed_date_size');
			$bcf_todos_completed_date_style = get_option('bcf_todos_completed_date_style');
			
			
			// Calendar Styles
			$bcf_calendar_title_color = get_option('bcf_calendar_title_color');
			$bcf_calendar_title_size = get_option('bcf_calendar_title_size');
			$bcf_calendar_description_text_color = get_option('bcf_calendar_description_text_color');
			$bcf_calendar_description_text_size = get_option('bcf_calendar_description_text_size');
			$bcf_calendar_main_title_text_color = get_option('bcf_calendar_main_title_text_color');
			$bcf_calendar_main_title_text_size = get_option('bcf_calendar_main_title_text_size');
			$bcf_calendar_color = get_option('bcf_calendar_color');
			
echo '<style>'; 
echo !empty($bcf_todos_title_color) ? '.bsf-todo-list-title{color:'.$bcf_todos_title_color.'!important;}' : '';
echo !empty($bcf_todos_title_size) ? '.font-size{color:'.$bcf_todos_title_size.'!important;}' : '';
echo !empty($bcf_todos_description_text_color) ? '.bsf-todo-list-description{color:'.$bcf_todos_description_text_color.'!important;}' : '';
echo !empty($bcf_todos_description_text_size) ? '.bsf-todo-list-description{font-size:'.$bcf_todos_description_text_size.'!important;}' : '';
echo !empty($bcf_todos_description_style) ? '.bsf-todo-list-description{'.$bcf_todos_description_style.'!important;}' : '';
echo !empty($bcf_todos_border_color) ? '.bsf-todo-list-title{border-bottom-color:'.$bcf_todos_border_color.'!important;}' : '';
echo !empty($bcf_todos_border_size) ? '.bsf-todo-list-title{border-bottom-width:'.$bcf_todos_border_size.'!important;}' : '';
echo !empty($bcf_todos_text_color) ? '.bsf-todo-item{color:'.$bcf_todos_text_color.'!important;}' : '';
echo !empty($bcf_todos_text_size) ? '.bsf-todo-item{font-size:'.$bcf_todos_text_size.'!important;}' : '';
echo !empty($bcf_todos_completed_header_text_color) ? '.bsf-todo-list-title-completed{color:'.$bcf_todos_completed_header_text_color.'!important;}' : '';
echo !empty($bcf_todos_completed_header_text_size) ? '.bsf-todo-list-title-completed{font-size:'.$bcf_todos_completed_header_text_size.'!important;}' : '';
echo !empty($bcf_todos_completed_text_color) ? '.bcf-item-complete-list{color:'.$bcf_todos_completed_text_color.'!important;}' : '';
echo !empty($bcf_todos_completed_text_size) ? '.bcf-item-complete-list{font-size:'.$bcf_todos_completed_text_size.'!important;}' : '';
echo !empty($bcf_todos_completed_checkmark_color) ? '.bcf-item-complete-list div:before{color:'.$bcf_todos_completed_checkmark_color.'!important;}' : '';
echo !empty($bcf_todos_completed_checkmark_size) ? '.bcf-item-complete-list div:before{font-size:'.$bcf_todos_completed_checkmark_size.'!important;}' : '';
echo !empty($bcf_todos_completed_date_color) ? '.bsf-todo-item span{color:'.$bcf_todos_completed_date_color.'!important;}' : '';
echo !empty($bcf_todos_completed_date_size) ? '.bsf-todo-item span{font-size:'.$bcf_todos_completed_date_size.'!important;}' : '';
echo !empty($bcf_todos_completed_date_style) ? '.bsf-todo-item span{'.$bcf_todos_completed_date_style.'!important;}' : '';


echo !empty($bcf_calendar_title_color) ? '.bsf-event-title{color:'.$bcf_calendar_title_color.'!important;}' : '';
echo !empty($bcf_calendar_title_size) ? '.bsf-event-title{font-size:'.$bcf_calendar_title_size.'!important;}' : '';
echo !empty($bcf_calendar_description_text_color) ? '.bsf-event-description{color:'.$bcf_calendar_description_text_color.'!important;}' : '';
echo !empty($bcf_calendar_description_text_size) ? '.bsf-event-description{font-size:'.$bcf_calendar_description_text_size.'!important;}' : '';
echo !empty($bcf_calendar_main_title_text_color) ? '.bsf-calendar-title{color:'.$bcf_calendar_main_title_text_color.'!important;}' : '';
echo !empty($bcf_calendar_main_title_text_size) ? '.bsf-calendar-title{font-size:'.$bcf_calendar_main_title_text_size.'!important;}' : '';
echo !empty($bcf_calendar_color) ? '.bsf-calendar-event-wrap .event_date, .bsf-calendar-event-wrap .dash{background:'.$bcf_calendar_color.'!important;}' : '';
echo '</style>';
 }
	} // CLOSE Function basecamp_head_css
	
	///**************************************************
	// ToDo Multi List Array
	//***************************************************
	function todo_multi_list_func($atts = NULL){
			extract( shortcode_atts( array(
				'account_id' => '',
				'project_id' => '',
				'show_completed' => '',
			), $atts ) );
		
		ob_start();	
		$basecamp = new Basecamp('BaseCampFeed');
		$bcf_un = get_option('bcf_user_id');
		$bcf_pw = get_option('bcf_password_id');
		$bcf_account_id = get_option('bcf_account_id');
		$basecamp->setServerAuthentication($bcf_un,$bcf_pw);
		$basecamp->setAccount('https://basecamp.com/'.$bcf_account_id.'/api/v1');
		
		//To do Lists
		$bfc_todo_lists = $basecamp->getTodoLists(false,$project_id);
		$bsf_output = '<div class="bsf-todo-list-wrapper">';
			foreach($bfc_todo_lists as $list){
				//Get Items
				$bfc_todo_items_list = $basecamp->getTodoList($project_id, $list->id);
				//Build Items List 
				$bsf_output .= $this->todo_items($bfc_todo_items_list, $show_completed);
			}//foreach list
		$bsf_output .= '</div>';
		
		//Display the ToDo list
		echo $bsf_output;
		return ob_get_clean();
	}
	
	///**************************************************
	// ToDo Single List Array
	//***************************************************
	function todo_single_list_func($atts = NULL){
			extract( shortcode_atts( array(
				'account_id' => '',
				'project_id' => '',
				'todo_list_id' => '',
				'show_completed' => '',
			), $atts ) );
		ob_start();		
		$basecamp = new Basecamp('BaseCampFeed');
		$bcf_un = get_option('bcf_user_id');
		$bcf_pw = get_option('bcf_password_id');
		$bcf_account_id = get_option('bcf_account_id');
		$basecamp->setServerAuthentication($bcf_un,$bcf_pw);
		$basecamp->setAccount('https://basecamp.com/'.$bcf_account_id.'/api/v1');
		
		$bsf_output = '<div class="bsf-todo-list-wrapper">';
			//Get Items
			$bfc_todo_items_list = $basecamp->getTodoList($project_id, $todo_list_id);
			//Build Items List 
			$bsf_output .= $this->todo_items($bfc_todo_items_list, $show_completed);
		$bsf_output .= '</div>';
		
		//Display the ToDo list
		echo $bsf_output;
		return ob_get_clean();
	}
	
	//**************************************************
	// Build Todo List Items
	//**************************************************
	function todo_items($bfc_todo_items, $show_completed){

			//List Title
			$bsf_output = '<div class="bsf-todo-list-title">'.$bfc_todo_items->name.'';
			
			//List Descrption
			$bsf_output .= '<div class="bsf-todo-list-description">'.$bfc_todo_items->description.'</div></div>';
		
		if(isset($bfc_todo_items->todos)){
			
			$bsf_output .= '<div class="bcf-item-list-wrap">';	
			$bsf_output .= '<div class="bcf-item-list">';
				//Not Completed Items
				foreach($bfc_todo_items->todos->remaining as $not_complete_list_item){
					
					//Which time?
					$pre_list_item_time = !empty($not_complete_list_item->updated_at) ? $not_complete_list_item->updated_at : $not_complete_list_item->created_at;
					//Format the Time
					$formatted_time = $this->clean_date_time($pre_list_item_time);
					//updated? or just created?
					$list_item_time = !empty($not_complete_list_item->updated_at) ? 'Updated: '. $formatted_time : 'Created: '. $formatted_time;
					
					//Item Content
					$bsf_output .= '<div class="bsf-not-completed bsf-todo-item">'.$not_complete_list_item->content.' <span>'.$list_item_time.'</span></div>';
				}//END NOT completed Items
				$bsf_output .= '</div>';
				
				//Completed Items
				if($show_completed == 'yes' && !empty($bfc_todo_items->todos->completed)){
				$bsf_output .= '<div class="bsf-todo-list-title-completed">Completed</div>';
				$bsf_output .= '<div class="bcf-item-list bcf-item-complete-list">';
					foreach($bfc_todo_items->todos->completed as $completed_list_item){
						//Format the Time
						$completed_formatted_time = $this->clean_date_time($completed_list_item->completed_at);
						//Item Content
						$bsf_output .= '<div class="bsf-completed bsf-todo-item">'.$completed_list_item->content.' <span>Completed by '.$completed_list_item->completer->name.' on '.$completed_formatted_time.'</span></div>';
					}//END for each
				 $bsf_output .= '</div>';
				} // END completed 
				
			$bsf_output .= '</div>';	
		}//End if To Do's isset
		
		//echo'<pre>';
//			print_r($bfc_todo_items);
//		echo'</pre>';
		
		return $bsf_output;
	}
}// FTS_Facebook_Feed END CLASS
new BaseCamp_Feed_to_do_list();
?>