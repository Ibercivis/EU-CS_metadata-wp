<?php


function generateProject_JSONLD() {
	$id=get_the_ID();
	$project_name = get_post_meta( $id, '_project-name', true );
	$url = get_post_meta( $id, '_project-url', true );
	$startDate = get_post_meta( $id, '_start-date', true );
	$endDate = get_post_meta( $id, '_end-date', true );
	$emailContact = get_post_meta( $id, '_contact-email', true );

		
	////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	///////////////////////////////  Image/archive data   //////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$post_content = get_post($id)->post_content;

	$search_pattern = '/src="([^"]+)"|href="([^"]+)" class/';

	// Run preg_match_all to grab all the images and save the results in $embedded_images
	preg_match_all( $search_pattern, $post_content, $embedded_images );

	// Check to see if we have at least 1 image
	$embedded_images_count = count($embedded_images[0]);
	
	$mediaResources = array();
	
	//print_r($embedded_images);
	//echo '<br/>'.count($embedded_images[0]);
	
	
	//Get attachment_id from image urls 
	for ($i = 0; $i < count($embedded_images[0]) ; $i++) {
		$img_string = $embedded_images[0][$i];
		$img_string = preg_replace('/\-*(\d+)x(\d+)\.(.*)$/', '.$3', $img_string);

		$pos_init = strpos($img_string, '"');
		$pos_end =  strpos($img_string, '"', $pos_init + strlen('"'));

		$media_url = substr($img_string,$pos_init+1, $pos_end-$pos_init-1);
		$attach_id = attachment_url_to_postid($media_url); //$Attachment_ID
		
		//echo '<br/>'.$media_url.'<br/>';
		
		//Get fields from attachment media
		$description = get_post_meta($attach_id, 'description', true);
		$doc_name = get_post_meta($attach_id, 'doc_name', true);
		$author = get_post_meta($attach_id, 'author', true);
		$datePublished = get_the_date('Y-m-d', $attach_id);
		$attachment_title = get_the_title($attach_id);


		$newMedia = new stdClass;			
		$newMedia->id = $attach_id;
		$newMedia->url = $media_url;
		$newMedia->description = $description;
		$newMedia->doc_name = $doc_name;
		$newMedia->author = $author;
		$newMedia->datePublished = $datePublished;
		$newMedia->attachment_title = $attachment_title;
		array_push($mediaResources, $newMedia);
	}
	//print_r($mediaResources);
	////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
	
?>
	<script type="application/ld+json">
	{
	  "@context": "http://schema.org",
	  "@type": "ProjectCC",
	  "name": "<?php echo $project_name; ?>",
	  "url": "<?php echo $url; ?>",
	  "start-date": "<?php echo $startDate; ?>",
	  "end-date": "<?php echo $endDate; ?>",
	  "contact-email": "<?php echo $emailContact; ?>"
	}

		<?php
			for($img = 0; $img < count($mediaResources); $img++){
				print_r(",");
				print_r('{
					"@context": "http://schema.org",
					"@type": "DocumentsCC",
					"url": "'.$mediaResources[$img]->url.'",
					"name": "'.$mediaResources[$img]->doc_name.'",
					"author": "'.$mediaResources[$img]->author.'",
					"description": "'.$mediaResources[$img]->description.'",
					"datePublished": "'.$mediaResources[$img]->datePublished.'",				
					"title": "'.$mediaResources[$img]->attachment_title.'"
				}');
			}
		?>
	</script>
<?php
}
add_filter( 'wp_footer', 'generateProject_JSONLD');

?>