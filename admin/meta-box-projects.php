<?php
/**
 * Logic related to the operation of the project data meta box.
 * It is responsible for adding the meta box in the WordPress UI and saving the values requested by the user.
 *
 */


/**
 * Add our meta box.
 */
function add_meta_box_project() {
	add_meta_box(
		'idMetaBoxProject',
		'Citizen Science project metadata',
		'print_projects_meta_box'
	);
}
add_action( 'add_meta_boxes_post', 'add_meta_box_project' );
//add_action( 'add_meta_boxes', 'add_meta_box_project' );


/**
 * Callback used to draw the meta box.
 *
 * @param   WP_POST   $post   the entry that is being edited.
 */
function print_projects_meta_box( $post ) {
	$post_id = $post->ID;
	$projectName = get_post_meta( $post_id, '_project-name', true );
	$projectUrl = get_post_meta( $post_id, '_project-url', true );
	$startDate = get_post_meta( $post_id, '_start-date', true );
	$endDate = get_post_meta( $post_id, '_end-date', true );
	$emailContact = get_post_meta( $post_id, '_contact-email', true );
	
	include 'partials/meta-box-projects.php';
	
	//uploadFile();
	
}

/**
 * Field to upload a file associated to the project
 *
*/
function uploadFile() {
	echo '<br/><br/>';	
	wp_nonce_field( plugin_basename(__FILE__), 'wp_custom_attachment_nonce' );
	echo '<span class="labelMbCC">File: </span>';
	
	$filearray = get_post_meta( get_the_ID(), 'wp_custom_attachment', true );
	$url = $filearray['url'];
	$name = $filearray['name'];
	
    $filename = basename($url); 
	
	
	if ( $url != '' ) { 
	    echo '<span>';
		echo '<a href="'.$url.'"> ' . $filename. ' </a>';
		echo '</span>';
	}else{
		//echo '<span>Ningún archivo seleccionado</span>';
	}
	
	$html .= '<input id="wp_custom_attachment" name="wp_custom_attachment" size="25" type="file" style="margin-left:2em;" />';
	
	echo $html;	
	
}


/**
 * Save meta box value.
 *
 * @param   int   $post   the identifier of the entry to be saved.
 */
function save_meta_box_project( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( !isset( $_REQUEST['project-name'] ) || !isset( $_REQUEST['project-url'] ) 
			|| !isset( $_REQUEST['start-date'] ) || !isset( $_REQUEST['end-date'] ) 
			|| !isset( $_REQUEST['contact-email'] )) {
		return;
	}
	
	$projectName = trim( sanitize_text_field( $_REQUEST['project-name'] ) );
	update_post_meta( $post_id, '_project-name', $projectName );
	
	$url = trim( sanitize_text_field( $_REQUEST['project-url'] ) );
	update_post_meta( $post_id, '_project-url', $url );
	
	$startDate = trim( sanitize_text_field( $_REQUEST['start-date'] ) );
	update_post_meta( $post_id, '_start-date', $startDate );

	$endDate = trim( sanitize_text_field( $_REQUEST['end-date'] ) );
	update_post_meta( $post_id, '_end-date', $endDate );
	
	$emailContact = trim( sanitize_text_field( $_REQUEST['contact-email'] ) );
	update_post_meta( $post_id, '_contact-email', $emailContact );
	
}
add_action( 'save_post', 'save_meta_box_project' );


/**
 * Save custom attachment metabox info.
 */
function save_custom_meta_data( $id ) {
	if ( ! empty( $_FILES['wp_custom_attachment']['name'] ) ) {
		$supported_types = array( 'application/pdf' );
		$arr_file_type = wp_check_filetype( basename( $_FILES['wp_custom_attachment']['name'] ) );
		$uploaded_type = $arr_file_type['type'];

		if ( in_array( $uploaded_type, $supported_types ) ) {
			$upload = wp_upload_bits($_FILES['wp_custom_attachment']['name'], null, file_get_contents($_FILES['wp_custom_attachment']['tmp_name']));
			if ( isset( $upload['error'] ) && $upload['error'] != 0 ) {
				wp_die( 'There was an error uploading your file. The error is: ' . $upload['error'] );
			} else {
				add_post_meta( $id, 'wp_custom_attachment', $upload );
				update_post_meta( $id, 'wp_custom_attachment', $upload );
			}
		}
		else {
			wp_die( "The file type that you've uploaded is not a PDF." );
		}
	}
}
add_action( 'save_post', 'save_custom_meta_data' );



/**
 * Add functionality for file upload.
 */
 
function update_edit_form() {
	echo ' enctype="multipart/form-data"';
}
add_action( 'post_edit_form_tag', 'update_edit_form' );


?>