<?php

namespace FGHEGC\Modules\Core;

use FGHEGC\Modules\Core\Singleton;
use FGHEGC\Modules\DivPolCri\DivPolCriModel;
use FGHEGC\Modules\Music\MusicController;
use FGHEGC\Modules\Music\MusicModel;
use FGHEGC\Modules\Page\PageController;
use FGHEGC\Modules\Post\PostController;
use FGHEGC\Modules\Sae\Evento\EventoModel;
use FGHEGC\Modules\Sae\Evento\EventoController;
use FGHEGC\Modules\Sae\Inscripcion\InscripcionController;
use FGHEGC\Modules\Sae\Inscripcion\InscripcionModel;
use FGHEGC\Modules\Sca\Acta\ActaController;
use FGHEGC\Modules\sca\acta\ActaModel;
use FGHEGC\Modules\Sca\Acuerdo\AcuerdoController;
use FGHEGC\Modules\Sca\Acuerdo\AcuerdoModel;
use FGHEGC\Modules\Sca\Comite\ComiteController;
use FGHEGC\Modules\Sca\Comite\ComiteModel;
use FGHEGC\Modules\Sca\Miembro\MiembroController;
use FGHEGC\Modules\Sca\Miembro\MiembroModel;
use FGHEGC\Modules\Sca\Puesto\PuestoController;
use FGHEGC\Modules\Sca\Puesto\PuestoModel;
use FGHEGC\Modules\Scc\Asistencia\AsistenciaModel;
use FGHEGC\Modules\Scc\Beneficiario\BeneficiarioController;
use FGHEGC\Modules\Scc\Beneficiario\BeneficiarioModel;
use FGHEGC\Modules\Scc\Comedor\ComedorController;
use FGHEGC\Modules\Scc\Comedor\ComedorModel;
use FGHEGC\Modules\Scc\Menu\MenuController;
use FGHEGC\Modules\Scc\Menu\MenuModel;
use FGHEGC\modules\scp\oracion\OracionModel;
use FGHEGC\Modules\Scp\Peticion\PeticionController;
use FGHEGC\Modules\Scp\Peticion\PeticionModel;
use PHPMailer\PHPMailer\PHPMailer;

class CoreController
{
   use Singleton;
   public $atributos;


   private function __construct()
   {
      require_once FGHEGC_DIR_PATH . '/modules/core/helpers/twentytwentyone/class-twenty-twenty-one-svg-icons.php';
      require_once FGHEGC_DIR_PATH . '/modules/core/helpers/twentytwentyone/template-functions.php';
      require_once FGHEGC_DIR_PATH . '/modules/core/helpers/twentytwentyone/template-tags.php';
      require_once FGHEGC_DIR_PATH . "/modules/core/helpers/walker.php";
      require_once FGHEGC_DIR_PATH . "/modules/core/view/core-comments.php";
      require_once FGHEGC_DIR_PATH . "/modules/scp/peticion/view/peticion-comments-single-function.php";
      require_once WP_PLUGIN_DIR . '/getid3/getid3.php';

      CoreModel::get_instance();
      PeticionModel::get_instance();
      OracionModel::get_instance();
      ActaModel::get_instance();
      AcuerdoModel::get_instance();
      ComiteModel::get_instance();
      MiembroModel::get_instance();
      PuestoModel::get_instance();
      EventoModel::get_instance();
      InscripcionModel::get_instance();
      MusicModel::get_instance();
      DivPolCriModel::get_instance();
      BeneficiarioModel::get_instance();
      AsistenciaModel::get_instance();
      ComedorModel::get_instance();
      MenuModel::get_instance();

      $this->atributos = [];
      $this->setup_hooks();
      $this->set_adminRole();
   }
   private function setup_hooks()
   {
      add_action('after_setup_theme', [$this, 'fghegc_theme_functionality']);
      add_action('wp_enqueue_scripts', [$this, 'fghegc_register_scripts_styles']);
      add_action('phpmailer_init', [$this, 'fghegc_smtpconfig']);

      add_filter('manage_edit-motivo_columns', [$this, 'fghegc_id_column']);
      add_filter('manage_motivo_custom_column', [$this, 'fghegc_id_column_content'], 10, 3);
      add_filter('manage_edit-category_columns', [$this, 'custom_category_id_column']);
      add_filter('manage_category_custom_column', [$this, 'custom_category_id_column_content'], 10, 3);
   }
   public function fghegc_theme_functionality()
   {
      load_theme_textdomain('fghmvc', get_template_directory() . '/languages');
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
            'principal' => __('Menu Principal', 'fghmvc'),
            'administrador' => __('Menu Administrador', 'fghmvc'),
         )
      );
      global $content_width;
      if (!isset($content_width)) {
         $content_width = 1240;
      }
      add_role('useradmingeneral', 'Administrador(a) General', get_role('subscriber')->capabilities);
   }
   public function fghegc_register_scripts_styles()
   {

      wp_enqueue_style('styles', FGHEGC_DIR_STYLE, array(), null, 'all');

      // wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA31KJuZkm9rzF8_4zW4y9TneM5BI00lME&ibraries=places&callback=initMap', array(), null, ['in_footer' => true, 'strategy'  => 'async']);
      // wp_enqueue_script('mapas', FGHEGC_DIR_URI . '/assets/mapas.js', array(), null, true);

      wp_enqueue_script('scripts', FGHEGC_DIR_URI . '/assets/main.js', array('jquery'), null, true);
   }

   public function fghegc_smtpconfig(PHPMailer $phpmailer)
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
   public function get_IP_address()
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
   public function get_atributos($postType)
   {
      if (isset($_GET['cpt'])) {
         $postType = sanitize_text_field($_GET['cpt']);
      }
      $atributosCore = [];
      $atributosCore['fullpage'] = false;
      $atributosCore['fontweight'] = 'fw-lighter';
      $atributosCore['display'] = 'display-4';
      $atributosCore['subtitulo'] = $this->get_subtitulo();
      $atributosCore['displaysub'] = 'display-5';
      $atributosCore['subtitulo2'] = '';
      $atributosCore['displaysub2'] = 'display-6';
      $atributosCore['height'] = '60vh';
      $atributosCore['navbar'] = 'modules/core/view/navbar';
      $atributosCore['banner'] = $this->get_banner();
      $atributosCore['div0'] = 'background-blend pt-5';
      $atributosCore['div1'] = 'container';
      $atributosCore['div2'] = '';
      $atributosCore['div3'] = '';
      $atributosCore['div4'] = '';
      $atributosCore['div5'] = '';
      $atributosCore['agregarpost'] = $this->get_agregarpost($postType);
      $atributosCore['templatepart'] = $this->get_templatepart($postType);
      $atributosCore['single'] = is_single();
      $atributosCore['templatepartnone'] = '';
      $atributosCore['sidebar'] = '';
      $atributosCore['parametros'] = '';
      $atributosCore['btnregresar'] = $this->get_btnregresar();
      $atributosCore['userAdmin'] = $this->get_usuario()['userAdmin'];
      $atributosCore['usradmingeneralemail'] = $this->get_admingeneralemail()['email'];
      $atributosCore['usradmingeneralname'] = $this->get_admingeneralemail()['name'];
      $atributosCore['usuario_id'] = $this->get_usuario()['usuario_id'];
      $atributosCore['imagen'] = $this->get_imagen();
      $atributosCore['pag'] = $this->get_pags()['pag'];
      $atributosCore['pag_ant'] = $this->get_pags()['pag_ant'];
      $atributosCore['piepagina'] = 'modules/core/view/core-piepagina';
      $atributosCore['comentarios'] = true;
      $atributosCore['verNavegacionPosts'] = true;

      switch ($postType) {
         case 'page':
            $this->atributos = PageController::get_instance()->get_atributos($postType);
            break;

         case 'post':
            $this->atributos = PostController::get_instance()->get_atributos($postType);
            break;

         case 'comite':
            $this->atributos = ComiteController::get_instance()->get_atributos($postType);
            break;

         case 'acta':
            $this->atributos = ActaController::get_instance()->get_atributos($postType);
            break;

         case 'acuerdo':
            $this->atributos = AcuerdoController::get_instance()->get_atributos($postType);
            break;

         case 'miembro':
            $this->atributos = MiembroController::get_instance()->get_atributos($postType);
            break;

         case 'puesto':
            $this->atributos = PuestoController::get_instance()->get_atributos($postType);
            break;

         case 'evento':
            $this->atributos = EventoController::get_instance()->get_atributos($postType);
            break;

         case 'inscripcion':
            $this->atributos = InscripcionController::get_instance()->get_atributos($postType);
            break;

         case 'music':
            $this->atributos = MusicController::get_instance()->get_atributos($postType);
            break;

         case 'peticion':
            $this->atributos = PeticionController::get_instance()->get_atributos($postType);
            break;

         case 'beneficiario':
            $this->atributos = BeneficiarioController::get_instance()->get_atributos($postType);
            break;

         case 'comedor':
            $this->atributos = ComedorController::get_instance()->get_atributos($postType);
            break;

         case 'menu':
            $this->atributos = MenuController::get_instance()->get_atributos($postType);
            break;

         default:
            if (isset($_GET['cpt'])) {
               $titulo = 'No hay un información registrada';
            } else {
               $titulo = 'Página no existe';
            }
            $this->atributos['fullpage'] = true;
            $this->atributos['height'] = '100vh';
            $this->atributos['titulo'] = $titulo;
            $this->atributos['subtitulo'] = '';
            $this->atributos['div0'] = 'background-blend';

            break;
      }
      $replacements = $this->atributos;
      $this->atributos = array_replace_recursive($atributosCore, $replacements);

      return $this->atributos;
   }
   public function set_atributo($parametro, $valor)
   {
      $this->atributos[$parametro] = $valor;
   }
   public function get_atributo($parametro)
   {
      return $this->atributos[$parametro];
   }
   private function get_usuario()
   {
      $usuario = [];
      $usuario['userAdmin'] = false;
      $usuario['usuario_id'] = '';
      if (is_user_logged_in()) {
         $user = wp_get_current_user();
         $usuario['usuario_id'] = $user->ID;
         $usuarioRoles = $user->roles;
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles)) {
            $usuario['userAdmin'] = true;
         }
      }
      return $usuario;
   }
   private function get_admingeneralemail()
   {
      $usradmingeneral = [];
      $administradores = get_users(array('role__in' => 'useradmingeneral'));
      if (count($administradores)) {
         foreach ($administradores as $administrador) {
            $usradmingeneral['email'] = $administrador->user_email;
            $usradmingeneral['name'] = $administrador->display_name;
         }
      } else {
         $usradmingeneral['email'] = '';
         $usradmingeneral['name'] = '';
      }
      return $usradmingeneral;
   }
   private function get_imagen()
   {
      if (get_the_post_thumbnail_url()) {
         $imagen = get_the_post_thumbnail_url();
      } else {
         $imagen = FGHEGC_DIR_URI . '/assets/img/bg.jpg';
      }
      return $imagen;
   }
   private function get_pags()
   {
      $pags = [];

      if (isset(explode("/", $_SERVER['REQUEST_URI'])[3])) {
         if (explode("/", $_SERVER['REQUEST_URI'])[3] != '') {
            if (explode("/", $_SERVER['REQUEST_URI'])[3] == 'page') {
               $pags['pag'] = 0; //explode("/", $_SERVER['REQUEST_URI'])[4];
            } else {
               $pags['pag'] = explode("/", $_SERVER['REQUEST_URI'])[3];
            }
         } else {
            $pags['pag'] = 0;
         }
      } else {
         $pags['pag'] = 1;
      }
      if (isset($_GET['pag'])) {
         $pags['pag_ant'] = sanitize_text_field($_GET['pag']);
         if ($pags['pag_ant'] == 0) {
            $pags['pag_ant'] = 1;
         }
      } else {
         $pags['pag_ant'] = 1;
      }
      return $pags;
   }
   private function get_agregarpost($postType)
   {
      $agregarpost = '';
      if (is_user_logged_in()) {
         $usuarioRoles = wp_get_current_user()->roles;
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradminpost', $usuarioRoles)) {
            $agregarpost = 'modules/' . $postType . '/view/' . $postType . '-agregar';
         }
      }
      return $agregarpost;
   }
   private function get_templatepart($postType)
   {
      $sca = ['comite', 'acta', 'acuerdo', 'miembro', 'puesto'];
      $sae = ['evento', 'inscripcion'];
      $scp = ['peticion', 'oracion'];
      $scc = ['asistencia', 'bebeficiario', 'comedor'];
      if (in_array($postType, $sca)) {
         $modulo = 'modules/sca/';
      } elseif (in_array($postType, $sae)) {
         $modulo = 'modules/sae/';
      } elseif (in_array($postType, $scp)) {
         $modulo = 'modules/scp/';
      } elseif (in_array($postType, $scc)) {
         $modulo = 'modules/scc/';
      } else {
         $modulo = 'modules/';
      }
      if (is_single()) {
         $templatepart = $modulo . $postType . '/view/' . $postType . '-single';
      } else {
         $templatepart = $modulo . $postType . '/view/' . $postType;
      }
      return $templatepart;
   }
   private function get_subtitulo()
   {
      $subtitulo = '';
      if (get_the_archive_title() == 'Archives' || get_the_archive_title() == 'Archivos') {
         if (is_single()) {
            $subtitulo = get_the_title();
         }
      } else {
         $subtitulo = str_replace('Tag', 'Etiqueta', get_the_archive_title());
      }
      return $subtitulo;
   }
   private function get_btnregresar()
   {
      if (is_single()) {
         $btn_regresar = 'modules/core/view/btn_regresar';
      } else {
         $btn_regresar = '';
      }
      return $btn_regresar;
   }
   private function get_banner()
   {
      if (is_page('core-login')) {
         $banner = '';
      } else {
         $banner = 'modules/core/view/banner';
      }
      return $banner;
   }
   public function quitarDiacriticos($texto)
   {
      $texto = htmlentities($texto, ENT_COMPAT, 'UTF-8');
      $texto = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/', '$1', $texto);
      $texto = html_entity_decode($texto, ENT_COMPAT, 'UTF-8');
      // $texto = strtolower($texto);
      return $texto;
   }
   public function fghegc_id_column($columns)
   {
      $columns['term_id'] = 'Term ID';
      return $columns;
   }
   public function fghegc_id_column_content($content, $column_name, $term_id)
   {
      if ($column_name == 'term_id') {
         return $term_id;
      }
      return $content;
   }
   public function custom_category_id_column($columns)
   {
      $columns['category_id'] = 'Category ID';
      return $columns;
   }
   public function custom_category_id_column_content($deprecated, $column_name, $term_id)
   {
      if ($column_name == 'category_id') {
         return $term_id;
      }
      return $deprecated;
   }
   private function set_adminRole()
   {

      $user = get_user_by('ID', 1);
      $user->add_role('acuerdos');
   }
}
