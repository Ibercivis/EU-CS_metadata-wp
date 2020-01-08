<?php


/**
 * Adding custom fields to the $form_fields array
 * 
 * @param array $form_fields
 * @param object $post
 * @return array
 */
function my_custom_fields_image_attachment($form_fields, $post) {
    $form_fields['description'] = array(
        'label' => __("Description"),
        'input' => "text", // this is default if "input" is omitted
        'value' => get_post_meta($post->ID, "description", true)
    );
	$form_fields["doc_name"]["label"] = __("Document name");
	$form_fields["doc_name"]["input"] = "textarea";
	$form_fields["doc_name"]["value"] = get_post_meta($post->ID, "doc_name", true);
	
	$form_fields["author"]["label"] = __("Author");
	$form_fields["author"]["input"] = "textarea";
	$form_fields["author"]["value"] = get_post_meta($post->ID, "author", true);
	
    return $form_fields;
}

add_filter("attachment_fields_to_edit", "my_custom_fields_image_attachment", null, 2);


/**
 * Save the added fields for the attachment
*/
function update_attachment_fields( $attachment_id ){
	if ( isset( $_REQUEST['attachments'][$attachment_id]['description'] ) ) {
		$description = $_REQUEST['attachments'][$attachment_id]['description'];    
		update_post_meta( $attachment_id, 'description', $description );
	}
	if ( isset( $_REQUEST['attachments'][$attachment_id]['doc_name'] ) ) {
		$doc_name = $_REQUEST['attachments'][$attachment_id]['doc_name'];    
		update_post_meta( $attachment_id, 'doc_name', $doc_name );
	}
	if ( isset( $_REQUEST['attachments'][$attachment_id]['author'] ) ) {
		$author = $_REQUEST['attachments'][$attachment_id]['author'];    
		update_post_meta( $attachment_id, 'author', $author );
	}
}
add_action( 'edit_attachment', 'update_attachment_fields' );


?>