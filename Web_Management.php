<?php
/*
Plugin Name: Webdesign Management
Plugin URI: http://www.scottbaker.eu/
Description: Give web design clients a visualization of their website's progress.
Version: 0.9
Author: Scott Baker
Author URI: http://www.scottbaker.eu/
License: GPL2
*/
// =========================
// = Buy me a Beer please! =
// =========================

//------------------------------
//Jquery and CSS Definitions
//------------------------------
function webm_project_head() {
 	$siteurl = get_option('siteurl');
    $pluginfolder = get_bloginfo('url') . '/' . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__));

	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-slider');
	//wp_enqueue_script('jquery-ui-datepicker,jquery-ui-slider', $pluginfolder . '/js/jquery-ui.js', array('jquery','jquery-ui-core'));
	wp_enqueue_style('jquery.ui.theme', $pluginfolder . '/css/jquery-ui-custom.css');
	
	wp_register_style('admin.css',$pluginfolder . '/admin.css'); 
	wp_enqueue_style('admin.css');
	
}
add_action('admin_head', 'webm_project_head');


//------------------------------
//Declare Custom Post Type
//------------------------------
function webm_project() {
	$labels = array(
		'name'               => _x( 'Web Projects', 'post type general name' ),
		'singular_name'      => _x( 'Project', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'Project' ),
		'add_new_item'       => __( 'Add New Web Project' ),
		'edit_item'          => __( 'Edit Web Project' ),
		'new_item'           => __( 'New Web Project' ),
		'all_items'          => __( 'All Web Projects' ),
		'view_item'          => __( 'View Web Project' ),
		'search_items'       => __( 'Search Web Projects' ),
		'not_found'          => __( 'No Web Projects found' ),
		'not_found_in_trash' => __( 'No Web Projects found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Web Projects'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our products and product specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title' , 'comments'),
		'has_archive'   => true,
	);
	register_post_type( 'client', $args );	
}
add_action( 'init', 'webm_project' );
add_action('admin_init', 'webm_meta_boxes');


//------------------------------
//Define Metaboxes
//------------------------------

function webm_meta_boxes($webmproject){
	add_meta_box( 'webm_meta_box', 'Web Projects Details', 'webm_projectdetails', 'client', 'normal', 'high' );
	add_meta_box( 'webm_todo_box', 'To Do List', 'webm_todo_box', 'client', 'normal', 'high' );
	add_meta_box( 'webm_progress', 'Website Progress', 'webm_progress', 'client', 'normal', 'high' );
}

//------------------------------
//Progress Bar Metabox
//------------------------------

function webm_progress($webmproject) { 
	
	global $post;
  	$custom = get_post_custom($post->ID);
	$current_tasks = $custom["current_tasks"][0];
  	$current_holds = $custom["current_holds"][0];
  	$progress = $custom["progress"][0];

	?>
	
	 <p><label class="big_title percent_complete">Percentage Complete: <span id="percentage_value"></span></label> 
		
		<div id="progress-slider-wrapper">
			<div id="progress-slider"></div>
		</div>
		
		<input type="text" name="progress" id="slider-input" value="<?php echo $progress; ?>" />
		<script>
			jQuery(document).ready(function() {
				initValue = jQuery('#slider-input').val();
				jQuery('#percentage_value').html(initValue + '%');
				jQuery( "#progress-slider" ).slider({
					range: "min",
				    value: initValue,
				    step: 1,
				    min: 0,
				    max: 100,
				    slide: function( event, ui ) {
				        jQuery( "#slider-input" ).val(ui.value);
						jQuery('#percentage_value').html(ui.value + '%');
				    }
				});
			});
		</script>
	</p>
<?php
}

//------------------------------
//Display ToDo Box
//------------------------------

function webm_todo_box($webmproject){ 
//Define new variable
$webm_entry1 = esc_html(get_post_meta($webmproject->ID,'webm_id_entry1', true));
$webm_entry2 = esc_html(get_post_meta($webmproject->ID,'webm_id_entry2', true));
$webm_entry3 = esc_html(get_post_meta($webmproject->ID,'webm_id_entry3', true));
$webm_current = esc_html(get_post_meta($webmproject->ID,'webm_id_current', true));
?>
<table>
	<tr>
		<td style="width: 100%">To Do Item #1:</td>
		<td><input type="text" size="80" name="webm_id_entry1" value="<?php echo $webm_entry1; ?>" /></td>
	</tr>
	<tr>
		<td style="width: 100%">To Do Item #2:</td>
		<td><input type = "text" size = "80" name = "webm_id_entry2" value="<?php echo $webm_entry2; ?>" /></td>
	</tr>
	<!--Copy TR Section for new field-->
	<tr>
		<td style="width: 100%">To Do Item #3:</td>
		<td><input type = "text" size = "80" name = "webm_id_entry3" value="<?php echo $webm_entry3; ?>" /></td>
	</tr>
	<tr>
		<td style="width: 100%">Currently working on:</td>
		<td><input type = "text" size = "80" name = "webm_id_current" value="<?php echo $webm_current; ?>" /></td>
	</tr>
</table>
<?php
}

//------------------------------
//Display Project Details
//------------------------------

function webm_projectdetails($webmproject){ 
//Define new variable
$webm_name = esc_html(get_post_meta($webmproject->ID,'webm_id', true));
$webm_email = esc_html(get_post_meta($webmproject->ID,'webm_client_email', true));
$webm_phoneno = esc_html(get_post_meta($webmproject->ID,'webm_client_phoneno', true));
?>
<table>
	<tr>
		<td style="width: 100%">Client Name:</td>
		<td><input type="text" size="80" name="webm_id" value="<?php echo $webm_name; ?>" /></td>
	</tr>
	<tr>
		<td style="width: 100%">Client Email:</td>
		<td><input type = "text" size = "80" name = "webm_client_email" value="<?php echo $webm_email; ?>" /></td>
	</tr>
	<tr>
		<td style = "width: 100%"></td>
		<td></td>
	</tr>
	<!--Copy TR Section for new field-->
	<tr>
		<td style="width: 100%">Phone Number:</td>
		<td><input type = "text" size = "80" name = "webm_client_phoneno" value="<?php echo $webm_phoneno; ?>" /></td>
	</tr>
</table>
<?php
}
//------------------------------
//Save Todo List
//------------------------------

add_action( 'save_post', 'webm_todo_fields', 10, 2 );

function webm_todo_fields( $webm_client_id, $webm_project ) {

	if ( $webm_project->post_type == 'client' ) {
	// Store data in post meta table if present in post data
		if ( isset( $_POST['webm_id_entry1'] ) &&
		$_POST['webm_id_entry1'] != '' ) {
		update_post_meta( $webm_client_id, 'webm_id_entry1',
		$_POST['webm_id_entry1'] );
		}
	}

if ( $webm_project->post_type == 'client' ) {
	// Store data in post meta table if present in post data
		if ( isset( $_POST['webm_id_entry2'] ) &&
		$_POST['webm_id_entry2'] != '' ) {
		update_post_meta( $webm_client_id, 'webm_id_entry2',
		$_POST['webm_id_entry2'] );
		}
	}

if ( $webm_project->post_type == 'client' ) {
	// Store data in post meta table if present in post data
		if ( isset( $_POST['webm_id_entry3'] ) &&
		$_POST['webm_id_entry3'] != '' ) {
		update_post_meta( $webm_client_id, 'webm_id_entry3',
		$_POST['webm_id_entry3'] );
		}
	}

if ( $webm_project->post_type == 'client' ) {
	// Store data in post meta table if present in post data
		if ( isset( $_POST['webm_id_current'] ) &&
		$_POST['webm_id_current'] != '' ) {
		update_post_meta( $webm_client_id, 'webm_id_current',
		$_POST['webm_id_current'] );
		}
	}
}

//------------------------------
//Save Project Details
//------------------------------

add_action( 'save_post', 'webm_fields', 10, 2 );

function webm_fields( $webm_client_id, $webm_project ) {
	global $post;
 
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    	return $post->ID;
	}

	update_post_meta($post->ID, "progress", $_POST["progress"]);

	if ( $webm_project->post_type == 'client' ) {
	// Store data in post meta table if present in post data
		if ( isset( $_POST['webm_id'] ) &&
		$_POST['webm_id'] != '' ) {
		update_post_meta( $webm_client_id, 'webm_id',
		$_POST['webm_id'] );
		}
	}

if ( $webm_project->post_type == 'client' ) {
	// Store data in post meta table if present in post data
		if ( isset( $_POST['webm_client_email'] ) &&
		$_POST['webm_client_email'] != '' ) {
		update_post_meta( $webm_client_id, 'webm_client_email',
		$_POST['webm_client_email'] );
		}
	}

if ( $webm_project->post_type == 'client' ) {
	// Store data in post meta table if present in post data
		if ( isset( $_POST['webm_client_phoneno'] ) &&
		$_POST['webm_client_phoneno'] != '' ) {
		update_post_meta( $webm_client_id, 'webm_client_phoneno',
		$_POST['webm_client_phoneno'] );
		}


	}
}

//------------------------------
//Add Page Template
//------------------------------

add_filter( 'template_include',
'include_template_function', 1 );


function include_template_function( $template_path ) {
if ( get_post_type() == 'client' ) {
if ( is_single() ) {
// checks if the file exists in the theme first,
// otherwise serve the file from the plugin
if ( $theme_file = locate_template( array
( 'single-webmprojects.php' ) ) ) {
$template_path = $theme_file;
} else {
$template_path = plugin_dir_path( __FILE__ ) .
'/single-webmprojects.php';
}
}
}
return $template_path;
}


?>