<?php

/**
 * Aplicación Web functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Aplicación_Web
 */
//Wordfence: ee5e3f5fd23828ee1c9c3d27cee8bde830532affc76b395bcc414f3924ef4090de733f9be812717e6a89d8457b8d44f4521c13d15b11f604374f84832cdf739e
date_default_timezone_set('America/Costa_Rica');

if (!defined('_S_VERSION')) {
   // Replace the version number of the theme on each release.
   define('_S_VERSION', '2.0.0');
}
if (!defined('PREFIJO')) {
   // Replace the version number of the theme on each release.
   define('PREFIJO', 'fgh000');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function fgh000_setup()
{
   /*
    * Make theme available for translation.
    */
   load_theme_textdomain('fgh000', get_template_directory() . '/languages');

   // Add default posts and comments RSS feed links to head.
   add_theme_support('automatic-feed-links');

   /*
    * Let WordPress manage the document title.
    */
   add_theme_support('title-tag');

   /*
    * Enable support for Post Thumbnails on posts and pages.
    *
    * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
    */
   add_theme_support('post-thumbnails');

   // This theme uses wp_nav_menu() in one location.
   register_nav_menus(
      array(
         'principal' => esc_html__('Principal', 'fgh000'),
      )
   );
   /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
   add_theme_support(
      'html5',
      array(
         'search-form',
         'comment-form',
         'comment-list',
         'gallery',
         'caption',
         'style',
         'script',
      )
   );

   // Add theme support for selective refresh for widgets.
   add_theme_support('customize-selective-refresh-widgets');

   /**
    * Add support for core custom logo.
    *
    * @link https://codex.wordpress.org/Theme_Logo
    */
   add_theme_support(
      'custom-logo',
      array(
         'height' => 300,
         'width' => 300,
         'flex-width' => true,
         'flex-height' => true,
      )
   );
}
add_action('after_setup_theme', 'fgh000_setup');

/**
 * Enqueue scripts and styles.
 */
function fgh000_scripts()
{
   wp_enqueue_style('styles', get_stylesheet_uri(), array(), microtime(), 'all');
   wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/main.js', array('jquery'), microtime(), true);
}
add_action('wp_enqueue_scripts', 'fgh000_scripts');

require_once ABSPATH . '/wp-admin/includes/taxonomy.php';
require get_template_directory() . "/modules/core/inc/functions.php";