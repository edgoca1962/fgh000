<?php

namespace EGC001\Modules\Core;

use EGC001\Modules\Core\Singleton;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * 
 * clase principal o core.
 * @package: EGC001
 * 
 */


class ThemeSetup
{
   use Singleton;
   private function __construct()
   {
      add_action('after_setup_theme', [$this, 'EGC001_theme_functionality']);
      add_action('wp_enqueue_scripts', [$this, 'EGC001_register_scripts_styles']);
      add_action('phpmailer_init', [$this, 'EGC001_smtpconfig']);
   }
   public function EGC001_theme_functionality()
   {
      load_theme_textdomain('EGC001', get_template_directory() . '/languages');
      add_theme_support('title-tag');
      add_theme_support('automatic-feed-links');
      add_theme_support('post-thumbnails');
      add_theme_support('post-formats', array('aside', 'gallery', 'quote', 'image', 'video'));
      add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
      add_theme_support('customize-selective-refresh-widgets');
      add_theme_support('wp-block-styles');
      add_theme_support('align-wide');
      add_theme_support('custom-logo', array('height' => 300, 'width' => 300, 'flex-width' => true, 'flex-height' => true,));
      register_nav_menus(
         array(
            'principal' => __('Menu Principal', 'EGC001'),
            'administrador' => __('Menu Administrador', 'EGC001'),
         )
      );
      global $content_width;
      if (!isset($content_width)) {
         $content_width = 1240;
      }
      add_role('useradmingeneral', 'Administrador(a) General', get_role('subscriber')->capabilities);
   }
   public function EGC001_register_scripts_styles()
   {

      wp_enqueue_style('styles', EGC001_DIR_STYLE, array(), microtime(), 'all');

      // wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA31KJuZkm9rzF8_4zW4y9TneM5BI00lME&ibraries=places&callback=initMap', array(), null, ['in_footer' => true, 'strategy'  => 'async']);
      // wp_enqueue_script('mapas', EGC001_DIR_URI . '/assets/mapas.js', array(), null, true);

      wp_enqueue_script('scripts', EGC001_DIR_URI . '/assets/main.js', array('jquery'), null, true);
   }
   public function EGC001_smtpconfig(PHPMailer $phpmailer)
   {
      $phpmailer->isSMTP();
      $phpmailer->Host       = 'smtp.hostinger.com';
      $phpmailer->SMTPAuth   = true;
      $phpmailer->Port       = 587;
      $phpmailer->Username   = 'soporte@fgh-org.org';
      $phpmailer->Password   = 'Fagohi<1986Edgoca>1962';
      $phpmailer->SMTPSecure = 'tls';
      $phpmailer->From       = 'soporte@fgh-org.org';
      $phpmailer->FromName   = 'Soporte';
   }
   private function EGC001_get_IP_address()
   {
      foreach (array(
         'HTTP_CLIENT_IP',
         'HTTP_X_FORWARDED_FOR',
         'HTTP_X_FORWARDED',
         'HTTP_X_CLUSTER_CLIENT_IP',
         'HTTP_FORWARDED_FOR',
         'HTTP_FORWARDED',
         'REMOTE_ADDR'
      ) as $key) {
         if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $IPaddress) {
               $IPaddress = trim($IPaddress); // Just to be safe

               if (
                  filter_var(
                     $IPaddress,
                     FILTER_VALIDATE_IP,
                     FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
                  )
                  !== false
               ) {

                  return $IPaddress;
               }
            }
         }
      }
      /* INCLUIR LÓGICA EN OTRA FUNCIÓN
      $ip = get_IP_address();
      $query = @unserialize(file_get_contents("http://ip-api.com/php/$ip"));
      if ($query && $query['status'] == 'success') {
         echo 'Hello visitor from ' . $query['country'] . ', ' . $query['city'] . '!';
      } else {
         echo 'Unable to get location';
      }
      */
   }
}
