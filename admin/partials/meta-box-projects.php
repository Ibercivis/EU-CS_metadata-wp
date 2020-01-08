<?php
/**
 * Meta boxes with project data.
 * The template assumes that the following variables are defined:
 *  * $projectName  {string} 
 *  * $projectUrl  {string}
 *  * $startDate {date}
 *  * $endDate {date} 
 *
 */


	wp_register_style('myStyleSheet', '/wp-content/plugins/citizen-science-metadata-wp/admin/css/styles.css');
	wp_enqueue_style( 'myStyleSheet');


?>



<label class="labelMbCC" for="project-name">Project name:</label>
<input class="inputMbCC" name="project-name" type="text" value="<?php echo esc_attr( $projectName );?>" />
<br/><br/>
<label class="labelMbCC" for="project-url">Project URL:</label>
<input class="inputMbCC" name="project-url" type="text" value="<?php echo esc_attr( $projectUrl ); ?>" />
<br/><br/>
<label class="labelMbCC" for="start-date">Start date:</label>
<input class="inputMbCC" type="date" id="start-date" name="start-date" value="<?php echo esc_attr( $startDate ); ?>" />
<br/><br/>
<label class="labelMbCC" for="end-date">End date:</label>
<input class="inputMbCC" type="date" id="end-date" name="end-date" value="<?php echo esc_attr( $endDate ); ?>" />
<br/><br/>
<label class="labelMbCC" for="contact-email">Email contact:</label>
<input class="inputMbCC" type="text" id="contact-email" name="contact-email" value="<?php echo esc_attr( $emailContact ); ?>" />

