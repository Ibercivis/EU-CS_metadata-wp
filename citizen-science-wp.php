<?php
/**
 * Plugin Name: Citizen Science Metadata
 * Description: Metadata from Citizen Science resources. 
 * Version: 1.0
 * Author: Ibercivis
 * Text Domain: EU-CS_metadata-wp 
 * 
 * @package CitizenScienceMetadata Plugin
 */

defined( 'ABSPATH' ) or die( '¡Fail!' );

if ( is_admin() ) {
  require_once( 'admin/meta-box-projects.php' );
  require_once( 'admin/attachment_fields.php' );
} else {
  require_once( 'frontend/project-data.php' );
}

?>