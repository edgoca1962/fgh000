<?php

/**
 * Functions Theme
 * 
 * @package EGC001
 * 
 */

use EGC001\Modules\Core\CoreController;

// date_default_timezone_set('America/Costa_Rica');

if (!defined('EGC001_DIR_PATH')) {
   define('EGC001_DIR_PATH', untrailingslashit(get_template_directory()));
}
if (!defined('EGC001_DIR_STYLE')) {
   define('EGC001_DIR_STYLE', untrailingslashit(get_stylesheet_uri()));
}
if (!defined('EGC001_DIR_URI')) {
   define('EGC001_DIR_URI', untrailingslashit(get_template_directory_uri()));
}
if (!defined('EGC001_POST_THUMBNAIL_URI')) {
   define('EGC001_POST_THUMBNAIL_URI', untrailingslashit(get_the_post_thumbnail_url()));
}
if (!defined('EGC001_CPT')) {
   define('EGC001_CPT', ['comite', 'acta', 'acuerdo', 'miembro', 'puesto', 'peticion', 'oracion', 'evento', 'inscripcion', 'beneficiario', 'comedor']);
}

require_once EGC001_DIR_PATH . '/modules/core/autoloader.php';

if (!function_exists('EGC001_get_theme_instance')) {
   function EGC001_get_theme_instance()
   {
      CoreController::get_instance();
   }
   EGC001_get_theme_instance();
}
