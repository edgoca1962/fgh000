<?php

namespace EGC001\Modules\Core;

use EGC001\Modules\DivPolCri\DivPolCriModel;
use EGC001\Modules\Page\PageController;
use EGC001\Modules\Post\PostController;
use EGC001\Modules\Sca\Acuerdo\AcuerdoController;
use EGC001\Modules\Sca\Acuerdo\AcuerdoModel;
use EGC001\Modules\Scc\Asistencia\AsistenciaController;
use EGC001\Modules\Scc\Asistencia\AsistenciaModel;
use EGC001\Modules\Scc\Beneficiario\BeneficiarioController;
use EGC001\Modules\Scc\Beneficiario\BeneficiarioModel;
use EGC001\Modules\Scc\Comedor\ComedorController;
use EGC001\Modules\Scc\Comedor\ComedorModel;
use EGC001\Modules\Scc\Menu\MenuController;
use EGC001\Modules\Scc\Menu\MenuModel;
use PHPMailer\PHPMailer\PHPMailer;

class CoreController
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      require_once EGC001_DIR_PATH . '/modules/core/helpers/twentytwentyone/class-twenty-twenty-one-svg-icons.php';
      require_once EGC001_DIR_PATH . '/modules/core/helpers/twentytwentyone/template-functions.php';
      require_once EGC001_DIR_PATH . '/modules/core/helpers/twentytwentyone/template-tags.php';
      require_once EGC001_DIR_PATH . "/modules/core/helpers/walker.php";
      // require_once EGC001_DIR_PATH . "/modules/core/view/core-comments.php";

      ThemeSetup::get_instance();
      CoreModel::get_instance();
      DivPolCriModel::get_instance();
      BeneficiarioModel::get_instance();
      AsistenciaModel::get_instance();
      ComedorModel::get_instance();
      MenuModel::get_instance();
      AcuerdoModel::get_instance();
   }
   public function set_atributo($parametro, $valor)
   {
      $this->atributos[$parametro] = $valor;
   }
   public function get_atributo($parametro)
   {
      return $this->atributos[$parametro];
   }
   public function get_atributos()
   {
      $postType = get_post_type();
      if (isset($_GET['cpt'])) {
         $postType = sanitize_text_field($_GET['cpt']);
      } else {
         if (get_post_type() == 'page') {
            $PrefijoPage = substr(get_post(get_the_ID())->post_name, 0, strpos(get_post(get_the_ID())->post_name, '-'));
            if (isset(EGC001_CPT_MODULO[$PrefijoPage])) {
               $postType = $PrefijoPage;
            }
         }
      }

      $atributosCore['banner'] = 'modules/core/view/banner';
      $atributosCore['navbar'] = 'modules/core/view/navbar';
      // variables del banner
      $atributosCore['imagen'] = (get_the_post_thumbnail()) ? get_the_post_thumbnail() : EGC001_DIR_URI . '/assets/img/bg.jpg';
      $atributosCore['height'] = '60dvh';
      $atributosCore['fontweight'] = 'fw-lighter';
      $atributosCore['display'] = 'display-3';
      $atributosCore['titulo'] = get_the_title();
      $atributosCore['displaysub'] = 'display-4';
      $atributosCore['subtitulo'] = '';
      $atributosCore['displaysub2'] = 'display-5';
      $atributosCore['subtitulo2'] = '';
      //fin variables banner
      $atributosCore['body'] = 'bg-dark bg-gradient text-white';
      $atributosCore['section'] = '';
      $atributosCore['div1'] = 'container-fluid';
      $atributosCore['div2'] = 'row';
      $atributosCore['agregarpost'] = 'modules/core/view/agregarpost';
      $atributosCore['div3'] = 'col-md-3';
      $atributosCore['sidebarlefttemplate'] = 'modules/core/view/core-sidebar-left';
      $atributosCore['div4'] = 'col-md-6';
      $atributosCore['div5'] = '';
      $atributosCore['div6'] = '';
      $atributosCore['div7'] = '';
      $atributosCore['templatepart'] = (is_page()) ? 'modules/core/view/' . get_post(get_the_ID())->post_name : '';
      $atributosCore['comentarios'] = true;
      $atributosCore['navegacion'] = true;
      $atributosCore['btnregresar'] = is_single() ? 'modules/core/view/btn_regresar' : '';
      $atributosCore['templatepartnone'] = '';
      $atributosCore['div8'] = 'col-md-3';
      $atributosCore['sidebarrighttemplate'] = 'modules/core/view/core-sidebar-right';
      $atributosCore['footerclass'] = 'container pt-5';
      $atributosCore['footertemplate'] = 'modules/core/view/core-footer';
      //Atributos otros
      $atributosCore['userAdmin'] = $this->get_datos_atributos()['userAdmin'];
      $atributosCore['pag'] = $this->get_pags()['pag'];
      $atributosCore['pag_ant'] = $this->get_pags()['pag_ant'];

      $atributosModulo = $this->get_atributos_modulo($postType);

      return $this->atributos = array_replace_recursive($atributosCore, $atributosModulo);
   }
   private function get_datos_atributos()
   {
      $datosAtributos = [];

      $datosAtributos['userAdmin'] = false;
      $datosAtributos['usuario_id'] = '';
      if (is_user_logged_in()) {
         $user = wp_get_current_user();
         $datosAtributos['usuario_id'] = $user->ID;
         $usuarioRoles = $user->roles;
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles)) {
            $datosAtributos['userAdmin'] = true;
         }
      }

      return $datosAtributos;
   }
   private function get_atributos_modulo($postType)
   {
      switch ($postType) {
         case 'page':
            $atributosModulo = PageController::get_instance()->get_atributos();
            break;

         case 'post':
            $atributosModulo = PostController::get_instance()->get_atributos();
            break;

         case 'beneficiario':
            $atributosModulo = BeneficiarioController::get_instance()->get_atributos();
            break;

         case 'asistencia':
            $atributosModulo = AsistenciaController::get_instance()->get_atributos();
            break;

         case 'comedor':
            $atributosModulo = ComedorController::get_instance()->get_atributos();
            break;

         case 'menu':
            $atributosModulo = MenuController::get_instance()->get_atributos();
            break;

         case 'acuerdo':
            $atributosModulo = AcuerdoController::get_instance()->get_atributos();
            break;

         default:
            /**Modificar */
            if (isset($_GET['cpt']) || in_array($postType, [])) {
               $titulo = 'No hay un información registrada';
            } else {
               $titulo = 'Página no existe';
            }
            $atributosModulo['navbar'] = 'modules/core/view/navbar';
            $atributosModulo['height'] = '100vh';
            $atributosModulo['titulo'] = $titulo;
            $atributosModulo['sidebarlefttemplate'] = '';
            $atributosModulo['sidebarrightclass'] = '';
            $atributosModulo['sidebarrighttemplate'] = '';
            $atributosModulo['agregarpost'] = '';
            $atributosModulo['footerclass'] = '';
            $atributosModulo['footertemplate'] = '';
            break;
      }
      return $atributosModulo;
   }
   private function get_pags()
   {
      $pags = [];
      // wp_die(print_r(explode("/", $_SERVER['REQUEST_URI'])));
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
   private function fghegc_smtpconfig(PHPMailer $phpmailer)
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
   public function quitarDiacriticos($texto)
   {
      $texto = htmlentities($texto, ENT_COMPAT, 'UTF-8');
      $texto = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/', '$1', $texto);
      $texto = html_entity_decode($texto, ENT_COMPAT, 'UTF-8');
      // $texto = strtolower($texto);
      return $texto;
   }
}
