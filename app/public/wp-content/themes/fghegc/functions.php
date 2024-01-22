<?php

/**
 * Functions Theme
 * 
 * @package FGHEGC
 * 
 */

use FGHEGC\Modules\Core\CoreController;

date_default_timezone_set('America/Costa_Rica');

if (!defined('FGHEGC_DIR_PATH')) {
   define('FGHEGC_DIR_PATH', untrailingslashit(get_template_directory()));
}
if (!defined('FGHEGC_DIR_STYLE')) {
   define('FGHEGC_DIR_STYLE', untrailingslashit(get_stylesheet_uri()));
}
if (!defined('FGHEGC_DIR_URI')) {
   define('FGHEGC_DIR_URI', untrailingslashit(get_template_directory_uri()));
}
if (!defined('FGHEGC_POST_THUMBNAIL_URI')) {
   define('FGHEGC_POST_THUMBNAIL_URI', untrailingslashit(get_the_post_thumbnail_url()));
}

require_once FGHEGC_DIR_PATH . '/modules/core/autoloader.php';

if (!function_exists('fghegc_get_theme_instance')) {
   function fghegc_get_theme_instance()
   {
      CoreController::get_instance();
   }
   fghegc_get_theme_instance();
}
