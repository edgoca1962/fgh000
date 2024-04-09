<?php

namespace EGC001\Modules\Scc\Beneficiario;

use EGC001\Modules\Core\Singleton;

/**
 * 
 * Controller de Beneficiario
 * 
 * @package:EGC001
 */

class BeneficiarioController
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      $this->atributos = $this->get_atributos();
      // add_action('wp_ajax_beneficiario_graficos', [$this, 'scc_beneficiario_get_datos_graficos']);
   }
   public function get_atributos($postType = 'beneficiario')
   {
      // $this->atributos['banner'] = 'modules/core/view/banner';
      // $this->atributos['navbar'] = 'modules/core/view/navbar';
      // variables del banner
      $this->atributos['imagen'] = EGC001_DIR_URI . '/assets/img/manosorando.jpeg';
      // $this->atributos['height'] = '60dvh';
      // $this->atributos['fontweight'] = 'fw-lighter';
      // $this->atributos['display'] = 'display-3';
      $this->atributos['titulo'] = $this->get_datosAtributos($postType)['titulo'];
      $this->atributos['displaysub'] = 'fs-4';
      $this->atributos['subtitulo'] = $this->get_datosAtributos($postType)['subtitulo'];
      $this->atributos['displaysub2'] = 'fs-5';
      $this->atributos['subtitulo2'] = $this->get_datosAtributos($postType)['subtitulo2'];
      //fin variables banner
      // $this->atributos['body'] = 'bg-dark bg-gradient text-white';
      // $this->atributos['section'] = '';
      // $this->atributos['div1'] = 'container-fluid';
      // $this->atributos['div2'] = 'row';
      $this->atributos['agregarpost'] = $this->get_datosAtributos($postType)['agregarpost'];
      $this->atributos['div3'] = '';
      $this->atributos['sidebarlefttemplate'] = '';
      $this->atributos['div4'] = 'col-md-8';
      // $this->atributos['div5'] = '';
      $this->atributos['div6'] = 'container my-5';
      $this->atributos['div7'] = $this->get_datosAtributos($postType)['div7'];
      $this->atributos['templatepart'] = $this->get_datosAtributos($postType)['templatepart'];
      // $this->atributos['comentarios'] = true;
      // $this->atributos['navegacion'] = true;
      // $this->atributos['btnregresar'] = is_single() ? 'modules/core/view/btn_regresar' : '';
      $this->atributos['templatepartnone'] = 'modules/scc/' . $postType . '/view/' . $postType . '-none';
      $this->atributos['div8'] = 'col-md-4';
      $this->atributos['sidebarrighttemplate'] = 'modules/scc/beneficiario/view/beneficiario-sidebar';
      $this->atributos['footerclass'] = 'pt-5';
      $this->atributos['footertemplate'] = 'modules/scc/beneficiario/view/beneficiario-footer';
      $this->atributos['regresar'] = $postType;
      /**Abributos Beneficiario */
      $comedor_id = (isset($_GET['comedor_id'])) ? sanitize_text_field($_GET['comedor_id']) : '';
      $condicion = (isset($_GET['condicion'])) ? sanitize_text_field($_GET['condicion']) : '';
      $sexo = (isset($_GET['sexo'])) ? sanitize_text_field($_GET['sexo']) : '';
      $this->atributos['parametros'] = $this->get_parametros($comedor_id, $condicion, $sexo);
      $this->atributos['ocultar'] = $this->get_ocultar();
      $this->atributos['ocultarVista'] = $this->get_datosAtributos($postType)['ocultarVista'];
      $this->atributos['ocultarElemento'] = $this->get_datosAtributos($postType)['ocultarElemento'];
      $this->atributos['ocultarMantenimiento'] = $this->get_datosAtributos($postType)['ocultarMantenimiento'];
      $this->atributos['ocultarBoton'] = $this->get_datosAtributos($postType)['ocultarBoton'];
      $this->atributos['datosGraficos'] = $this->get_datos_graficos();
      $this->atributos['encargados'] = get_users(['orderby' => 'display_name', 'role__in' => ['encargadocomedores']]);
      $this->atributos['listadoBeneficiarios'] = $this->get_beneficiario_listado();
      $this->atributos['mesSel'] = $this->get_MesAnno()['mesSel'];
      $this->atributos['annoSel'] = $this->get_MesAnno()['annoSel'];
      $this->atributos['provincias'] = $this->scc_get_provincias();
      $this->atributos['asistencias'] = get_posts(['post_type' => 'asistencia', 'posts_per_page' => -1, 'post_parent' => get_the_id()]);
      $this->atributos['comedores'] = get_posts(['post_type' => 'comedor', 'posts_per_page' => -1, 'orderby' => 'post_title', 'order' => 'ASC']);
      $this->atributos['listado'] = $this->get_datos_sidebar()['listado'];
      $this->atributos['avatar'] = $this->get_avatar(get_the_ID());
      $this->atributos['provincia'] = $this->get_provincia(get_post_meta(get_the_ID(), '_provincia_id', true));
      $this->atributos['canton'] = $this->get_canton(get_post_meta(get_the_ID(), '_canton_id', true));
      $this->atributos['distrito'] = $this->get_distrito(get_post_meta(get_the_ID(), '_distrito_id', true));

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
   private function get_datosAtributos($postType)
   {
      $datosAtributos = [];
      $datosAtributos['agregarpost'] = '';
      $datosAtributos['verbeneficiarios'] = false;
      $datosAtributos['userAdmin'] = false;
      $usuarioRoles = wp_get_current_user()->roles;
      if (is_user_logged_in()) {
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradminbeneficiarios', $usuarioRoles) || in_array('beneficiarios', $usuarioRoles)) {
            $datosAtributos['verbeneficiarios'] = true;
            if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradminbeneficiarios', $usuarioRoles)) {
               $datosAtributos['userAdmin'] = true;
               $datosAtributos['agregarpost'] = 'modules/scc/' . $postType . '/view/' . $postType . '-agregar';
            }
         }
      }

      if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradmincomedores', $usuarioRoles)) {
         $datosAtributos['ocultarElemento'] = '';
         $datosAtributos['ocultarVista'] = '';
         $datosAtributos['ocultarMantenimiento'] = '';
         $datosAtributos['ocultarBoton'] = '';
      } elseif (in_array('encargadocomedores', $usuarioRoles)) {
         $datosAtributos['ocultarVista'] = '';
         $datosAtributos['ocultarElemento'] = 'hidden';
         $datosAtributos['ocultarMantenimiento'] = '';
         $datosAtributos['ocultarBoton'] = '';
      } elseif (in_array('comedores', $usuarioRoles)) {
         $datosAtributos['ocultarVista'] = '';
         $datosAtributos['ocultarElemento'] = 'hidden';
         $datosAtributos['ocultarMantenimiento'] = 'hidden';
         $datosAtributos['ocultarBoton'] = 'hidden';
      } else {
         $datosAtributos['ocultarVista'] = 'hidden';
         $datosAtributos['ocultarElemento'] = 'hidden';
         $datosAtributos['ocultarMantenimiento'] = 'hidden';
         $datosAtributos['ocultarBoton'] = 'hidden';
      }

      if (is_single()) {
         $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . $postType . '-single';
         $datosAtributos['subtitulo'] = 'Y SABEMOS QUE DIOS HACE<br>QUE TODAS LAS COSAS<br>COOPEREN PARA EL BIEN DE<br>QUIENES LO AMAN Y SON<br>LLAMADOS SEGÚN EL<br>PROPÓSITO QUE ÉL TIENE<br>PARA ELLOS<br><strong>ROMANSOS 8:28</strong>';
         $datosAtributos['subtitulo2'] = get_the_title();
         $datosAtributos['div7'] = '';
      } else {
         if (is_page()) {
            $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . get_post(get_the_ID())->post_name;
            if (is_page('beneficiario-acerca')) {
               $this->atributos['div2'] = '';
               $this->atributos['div4'] = '';
               $this->atributos['div6'] = '';
               $this->atributos['div7'] = '';
               $this->atributos['sidebarrighttemplate'] = '';
            }
            if (is_front_page() || is_page('beneficiario-principal')) {
               $this->atributos['banner'] = '';
               $this->atributos['height'] = '100dvh';
               $this->atributos['div1'] = '';
               $this->atributos['div2'] = '';
               $this->atributos['div4'] = '';
               $this->atributos['div6'] = '';
               $this->atributos['div7'] = '';
               $this->atributos['sidebarrighttemplate'] = '';
               $this->atributos['footerclass'] = '';
               $this->atributos['footertemplate'] = '';
            }
         } else {
            $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . $postType;
         }
         $datosAtributos['subtitulo'] = 'Y SABEMOS QUE DIOS HACE<br>QUE TODAS LAS COSAS<br>COOPEREN PARA EL BIEN DE<br>QUIENES LO AMAN Y SON<br>LLAMADOS SEGÚN EL<br>PROPÓSITO QUE ÉL TIENE<br>PARA ELLOS<br><strong>ROMANSOS 8:28</strong>';
         $datosAtributos['subtitulo2'] = '';
         $datosAtributos['div7'] = '';
      }

      if (isset($_GET['comedor_id'])) {
         $comedor = sanitize_text_field($_GET['comedor_id']);
         $datosAtributos['titulo'] = get_post($comedor)->post_title;
      } else {
         $datosAtributos['titulo'] = 'Forjadores de Esperanza';
      }

      return $datosAtributos;
   }
   private function get_parametros($comedor_id, $condicion, $sexo)
   {
      $parametros = '';
      if ($comedor_id != '') {
         $parametros = 'comedor_id=' . $comedor_id;
      }
      if ($comedor_id != '' && $condicion != '' && $sexo != '') {
         $parametros = 'comedor_id=' . $comedor_id . '&condicion=' . $condicion . '&sexo=' . $sexo;
      }
      return $parametros;
   }
   private function scc_get_provincias()
   {
      global $wpdb;

      $sql =
         "SELECT DISTINCT t1.meta_value AS ID, t2.meta_value AS provincia
      FROM $wpdb->posts
      INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
      INNER JOIN $wpdb->postmeta t2
         ON (ID = t2.post_id)
      WHERE post_type = 'divpolcri'
         AND (t1.meta_key = '_provincia_id' AND t1.meta_value !='')
         AND (t2.meta_key = '_provincia' AND t2.meta_value !='')
      ORDER BY t2.meta_value
      ";

      $provincias = $wpdb->get_results($sql, ARRAY_A);

      return $provincias;
   }
   private function get_provincia($provincia_id)
   {
      global $wpdb;

      $sql =
         "SELECT t2.meta_value AS provincia
      FROM $wpdb->posts
      INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
      INNER JOIN $wpdb->postmeta t2
         ON (ID = t2.post_id)
      WHERE post_type = 'divpolcri'
         AND (t1.meta_key = '_provincia_id' AND t1.meta_value = $provincia_id)
         AND (t2.meta_key = '_provincia' AND t2.meta_value !='')
      ORDER BY t2.meta_value
      ";

      $provincias = $wpdb->get_var($sql);

      return $provincias;
   }
   public function get_canton($canton_id)
   {
      global $wpdb;

      $sql =
         "SELECT t2.meta_value AS canton
      FROM $wpdb->posts
      INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
      INNER JOIN $wpdb->postmeta t2
         ON (ID = t2.post_id)
      WHERE post_type = 'divpolcri'
         AND (t1.meta_key = '_canton_id' AND t1.meta_value = $canton_id)
         AND (t2.meta_key = '_canton' AND t2.meta_value !='')
      ORDER BY t2.meta_value
      ";

      $cantones = $wpdb->get_var($sql);

      return $cantones;
   }
   public function get_distrito($distrito_id)
   {
      global $wpdb;

      $sql =
         "SELECT t2.meta_value AS distrito
      FROM $wpdb->posts
      INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
      INNER JOIN $wpdb->postmeta t2
         ON (ID = t2.post_id)
      WHERE post_type = 'divpolcri'
         AND (t1.meta_key = '_distrito_id' AND t1.meta_value = $distrito_id)
         AND (t2.meta_key = '_distrito' AND t2.meta_value !='')
      ORDER BY t2.meta_value
      ";

      $distritos = $wpdb->get_var($sql);

      return $distritos;
   }
   private function get_avatar($post_id)
   {
      if (get_post_meta($post_id, '_sexo', true) == '2') {
         switch (get_post_meta($post_id, '_condicion', true)) {
            case '1':
               $avatar = EGC001_DIR_URI . '/assets/img/scc/avatar_femenino.png';
               break;
            case '2':
               $avatar = EGC001_DIR_URI . '/assets/img/scc/avatarAdultaMayor.png';
               break;
            case '3':
               $avatar = EGC001_DIR_URI . '/assets/img/scc/avatarEmbarazada.png';
               break;
            case '4':
               $avatar = EGC001_DIR_URI . '/assets/img/scc/avatarLactancia.png';
               break;
            default:
               $avatar = EGC001_DIR_URI . '/assets/img/scc/avatar03.png';
               break;
         }
      } else {
         switch (get_post_meta($post_id, '_condicion', true)) {
            case '1':
               $avatar = EGC001_DIR_URI . '/assets/img/scc/avatar_masculino.png';
               break;
            case '2':
               $avatar = EGC001_DIR_URI . '/assets/img/scc/avatarAdultoMayor.png';
               break;
            default:
               $avatar = EGC001_DIR_URI . '/assets/img/scc/avatar03.png';
               break;
         }
      }
      return $avatar;
   }
   private function get_datos_sidebar()
   {
      $datosSidebar = [];
      global $wpdb;

      $sql =
         "SELECT meta_value as condicion_id,count(*) AS total,
            CASE 
               WHEN meta_value = '1' THEN 'Niños(as)'
               WHEN meta_value = '2' THEN 'Adultos(as) Mayores'
               WHEN meta_value = '3' THEN 'Embarazadas'
               ELSE 'En Lactancia'
            END AS condicion
      FROM $wpdb->posts
      INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
      WHERE post_type = 'beneficiario'
         AND (t1.meta_key = '_condicion' AND t1.meta_value !='')
      GROUP BY t1.meta_value,
            CASE 
               WHEN meta_value = '1' THEN 'Niños(as)'
               WHEN meta_value = '2' THEN 'Adultos(as) Mayores'
               WHEN meta_value = '3' THEN 'Embarazadas'
               ELSE 'En Lactancia'
            END
      ORDER BY t1.meta_value
      ";


      /********************************************
       * 
       * Listado de comedores por condición y sexo 
       * 
       * ******************************************/
      $datosSidebar['condiciones'] = $wpdb->get_results($sql, ARRAY_A);
      $comedores = get_posts(['post_type' => 'comedor', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'post_title', 'order' => 'ASC']);
      $sql =
         "SELECT post_parent AS comedor_id, 
            t1.meta_value AS condicion_id,
            t2.meta_value AS sexo,
            count(*) AS total
         FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta t1
            ON (ID = t1.post_id)
            INNER JOIN $wpdb->postmeta t2
            ON (ID = t2.post_id)
         WHERE post_type = 'beneficiario'
            AND post_status = 'publish'
            AND (t1.meta_key='_condicion')
            AND (t2.meta_key = '_sexo')
         GROUP BY post_parent,t1.meta_value,t2.meta_value
         ORDER BY post_parent,t1.meta_value,t2.meta_value";
      $datos = $wpdb->get_results($sql, ARRAY_A);
      $listado = [];
      foreach ($comedores as $comedor) {
         $listado[] =
            [
               'nivel' => 1,
               'enlace' => get_post_type_archive_link('beneficiario') . '?comedor_id=' . $comedor->ID,
               'descripcion' => $comedor->post_title
            ];
         foreach ($datos as $dato) {
            $descripcion = '';
            switch ($dato['condicion_id']) {
               case '1':
                  if ($dato['sexo'] == '1') {
                     $descripcion = 'Total de Niños ' . '( ' . $dato['total'] . ' )';
                  } else {
                     $descripcion = 'Total de Niñas ' . '( ' . $dato['total'] . ' )';
                  }
                  break;

               case '2':
                  if ($dato['sexo'] == '1') {
                     $descripcion = 'Total de Adultos Mayores ' . '( ' . $dato['total'] . ' )';
                  } else {
                     $descripcion = 'Total de Adultas Mayores ' . '( ' . $dato['total'] . ' )';
                  }
                  break;

               case '3':
                  $descripcion = 'Total de Embarazadas ' . '( ' . $dato['total'] . ' )';
                  break;

               case '4':
                  $descripcion = 'Total en Lactancia ' . '( ' . $dato['total'] . ' )';
                  break;
            }

            if ($dato['comedor_id'] == $comedor->ID) {
               $listado[] =
                  [
                     'nivel' => 2,
                     'enlace' => get_post_type_archive_link('beneficiario') . '?comedor_id=' . $comedor->ID . '&condicion=' . $dato['condicion_id'] . '&sexo=' . $dato['sexo'],
                     'descripcion' => $descripcion
                  ];
            }
         }
      }

      $datosSidebar['listado'] = $listado;


      return $datosSidebar;
   }
   private function get_ocultar()
   {
      $ocultar = '';
      if (get_post_meta(get_the_ID(), '_f_u_actualizacion', true) == date('Y-d-m')) {
         $ocultar = 'hidden';
      }
      return $ocultar;
   }
   private function get_datos_graficos()
   {
      $mesesIngles = ['1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'];
      $datosGraficos['mesesEspanol'] = ["1" => "Enero", "2" => "Febrero", "3" => "Marzo", "4" => "Abril", "5" => "Mayo", "6" => "Junio", "7" => "Julio", "8" => "Agosto", "9" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"];

      $comedores = get_posts(['post_type' => 'comedor', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'post_title', 'order' => 'ASC']);

      if (isset($_GET['mes'])) {
         $mes = sanitize_text_field($_GET['mes']);
      } else {
         $mes = date('n');
      }
      if (isset($_GET['anno'])) {
         $anno = sanitize_text_field($_GET['anno']);
      } else {
         $anno = date('Y');
      }

      $fechaInicial = date('Y-m-d H:i:s', strtotime('First day of' . $mesesIngles[$mes] . ' ' . $anno));
      $fechaFinal = date('Y-m-d H:i:s', strtotime('Last day of' . $mesesIngles[$mes] . ' ' . $anno));

      global $wpdb;

      /***************************************************
       * 
       * Datos para Gráfico de Barras combinado con una línea
       * 
       **************************************************/

      $sql =
         "SELECT DISTINCT post_date AS label
      FROM $wpdb->posts
      WHERE 
         post_type = 'asistencia' 
         AND post_status = 'publish'
         AND post_date BETWEEN '$fechaInicial' AND '$fechaFinal'
      ORDER BY post_date";
      $results = $wpdb->get_results($sql, ARRAY_A);
      foreach ($results as $item) {
         $labels[] = date('d-m-y', strtotime($item['label']));
      }
      if ($results) {
         $datosGraficos['labels'] = $labels;
      } else {
         $datosGraficos['labels'] = [];
      }

      $sql =
         "SELECT post_date AS fecha,
      count(t1.meta_value) AS asistencia
      FROM $wpdb->posts
         INNER JOIN $wpdb->postmeta t1
         ON ( ID = t1.post_id )
      WHERE 
         post_type = 'asistencia' 
         AND post_status = 'publish'
         AND post_date BETWEEN '$fechaInicial' AND '$fechaFinal'
         AND (t1.meta_key = '_reflexion' AND t1.meta_value='Si')
      GROUP BY post_date
      ORDER BY post_date";
      $asistencias = $wpdb->get_results($sql, ARRAY_A);
      foreach ($asistencias as $item) {
         $asistencia[] = $item['asistencia'];
      }
      if ($asistencias) {
         $datosGraficos['asistencia'] = $asistencia;
      } else {
         $datosGraficos['asistencia'] = [];
      }

      $sql =
         "SELECT post_date AS fecha,
      count(t1.meta_value) AS ausencia
      FROM $wpdb->posts
         INNER JOIN $wpdb->postmeta t1
         ON ( ID = t1.post_id )
      WHERE 
         post_type = 'asistencia' 
         AND post_status = 'publish'
         AND post_date BETWEEN '$fechaInicial' AND '$fechaFinal'
         AND (t1.meta_key = '_reflexion' AND t1.meta_value='No')
      GROUP BY post_date
      ORDER BY post_date";
      $ausencias = $wpdb->get_results($sql, ARRAY_A);
      foreach ($ausencias as $item) {
         $ausencia[] = $item['ausencia'];
      }
      if ($ausencias) {
         $datosGraficos['ausencia'] = $ausencia;
      } else {
         $datosGraficos['ausencia'] = [];
      }

      $sql =
         "SELECT post_date AS fecha,
      sum(t1.meta_value) AS cantidad
      FROM $wpdb->posts
         INNER JOIN $wpdb->postmeta t1
         ON ( ID = t1.post_id )
      WHERE 
         post_type = 'asistencia' 
         AND post_status = 'publish'
         AND post_date BETWEEN '$fechaInicial' AND '$fechaFinal'
         AND (t1.meta_key = '_q_alimentacion')
      GROUP BY post_date
      ORDER BY post_date";
      $cantidades = $wpdb->get_results($sql, ARRAY_A);
      foreach ($cantidades as $item) {
         $cantidad[] = $item['cantidad'];
      }
      if ($cantidades) {
         $datosGraficos['cantidad'] = $cantidad;
      } else {
         $datosGraficos['cantidad'] = [];
      }

      /***************************************************
       * 
       * Datos para Gráficos tipo Dona
       * 
       **************************************************/
      $sql =
         "SELECT post_parent AS beneficiario,
      count(t1.meta_value) AS asistencia
      FROM $wpdb->posts
         INNER JOIN $wpdb->postmeta t1
         ON ( ID = t1.post_id )
      WHERE 
         post_type = 'asistencia' 
         AND post_status = 'publish'
         AND post_date BETWEEN '$fechaInicial' AND '$fechaFinal'
         AND (t1.meta_key = '_reflexion' AND t1.meta_value = 'Si')
      GROUP BY post_parent
      ORDER BY post_parent";

      $asistencia = $wpdb->get_results($sql, ARRAY_A);
      if (!$asistencia) {
         $asistencia = [];
      }

      $sql =
         "SELECT post_parent AS beneficiario,
      count(t1.meta_value) AS ausencia
      FROM $wpdb->posts
         INNER JOIN $wpdb->postmeta t1
         ON ( ID = t1.post_id )
      WHERE 
         post_type = 'asistencia' 
         AND post_status = 'publish'
         AND post_date BETWEEN '$fechaInicial' AND '$fechaFinal'
         AND (t1.meta_key = '_reflexion' AND t1.meta_value = 'No')
      GROUP BY post_parent
      ORDER BY post_parent";

      $ausencia = $wpdb->get_results($sql, ARRAY_A);
      if (!$ausencia) {
         $ausencia = [];
      }

      $sql =
         "SELECT post_parent AS beneficiario,
      sum(t1.meta_value) AS cantidad
      FROM $wpdb->posts
         INNER JOIN $wpdb->postmeta t1
         ON ( ID = t1.post_id )
      WHERE 
         post_type = 'asistencia' 
         AND post_status = 'publish'
         AND post_date BETWEEN '$fechaInicial' AND '$fechaFinal'
         AND (t1.meta_key = '_q_alimentacion' AND t1.meta_value != '')
      GROUP BY post_parent
      ORDER BY post_parent";

      $cantidad = $wpdb->get_results($sql, ARRAY_A);
      if (!$cantidad) {
         $cantidad = [];
      }

      $datos = array_merge($asistencia, $ausencia, $cantidad);

      $datosGraficosDonas = [];

      $asistencia = 0;
      $ausencia = 0;
      $cantidad = 0;
      foreach ($datos as $item) {
         if (isset($item['asistencia'])) {
            $asistencia = $asistencia + intval($item['asistencia']);
         }
         if (isset($item['ausencia'])) {
            $ausencia = $ausencia + intval($item['ausencia']);
         }
         if (isset($item['cantidad'])) {
            $cantidad = $cantidad + intval($item['cantidad']);
         }
      }

      $datosGraficosDonas[] = [
         'ID' => 'todos',
         'titulo' => 'Todos los Comedores',
         'datos' => [$asistencia, $ausencia, $cantidad]
      ];

      foreach ($comedores as $comedor) {
         $asistencia = 0;
         $ausencia = 0;
         $cantidad = 0;
         foreach ($datos as $item) {
            if (wp_get_post_parent_id($item['beneficiario']) == $comedor->ID) {
               if (isset($item['asistencia'])) {
                  $asistencia = $asistencia + intval($item['asistencia']);
               }
               if (isset($item['ausencia'])) {
                  $ausencia = $ausencia + intval($item['ausencia']);
               }
               if (isset($item['cantidad'])) {
                  $cantidad = $cantidad + intval($item['cantidad']);
               }
            }
         }

         $datosGraficosDonas[] = [
            'ID' => $comedor->ID,
            'titulo' => $comedor->post_title,
            'datos' => [$asistencia, $ausencia, $cantidad]
         ];
      }
      $datosGraficos['donas'] = $datosGraficosDonas;

      return $datosGraficos;
   }
   private function get_beneficiario_listado()
   {

      $beneficiarios = get_posts(['post_type' => 'beneficiario', 'posts_per_page' => -1, 'post_status' => 'publish']);
      foreach ($beneficiarios as $beneficiario) {
         $hoy = date('Y-m-d');
         $hoy = new \DateTime($hoy);
         $f_nacimiento = date('Y-m-d', strtotime(get_post_meta($beneficiario->ID, '_f_nacimiento', true)));
         $f_nacimiento = new \DateTime($f_nacimiento);
         $diff = $hoy->diff($f_nacimiento);
         $edad = $diff->y;
         update_post_meta($beneficiario->ID, '_edad', $edad);
      }

      global $wpdb;

      // Query posts from WordPress.
      $sql =
         "SELECT 
         post_parent AS comedor,
         post_title AS nombre,
         CASE WHEN t1.meta_value = '1' THEN 'Niño(a)'
            WHEN t1.meta_value = '2' THEN 'Adulto(a) Mayor'
            WHEN t1.meta_value = '3' THEN 'Embarazada'
            WHEN t1.meta_value = '4' THEN 'Lactancia'
            ELSE 'No definida' END AS condicion,
         t2.meta_value AS edad,
         t3.meta_value AS estatura 
         FROM $wpdb->posts 
         INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
         INNER JOIN $wpdb->postmeta t2
         ON (ID = t2.post_id)
         INNER JOIN $wpdb->postmeta t3
         ON (ID = t3.post_id)
         WHERE post_type = 'beneficiario' AND post_status = 'publish'
           AND (t1.meta_key = '_condicion')
           AND (t2.meta_key = '_edad')
           AND (t3.meta_key = '_estatura')
         ORDER BY post_parent, post_title,t1.meta_value,t2.meta_value,t3.meta_value
         ";

      $beneficiarios = $wpdb->get_results($sql);

      return $beneficiarios;
   }
   private function get_MesAnno()
   {
      $datosAtributos = [];
      if (isset($_GET['mes'])) {
         $datosAtributos['mesSel'] = sanitize_text_field($_GET['mes']);
      } else {
         $datosAtributos['mesSel'] = date('n');
      }
      if (isset($_GET['anno'])) {
         $datosAtributos['annoSel'] = sanitize_text_field($_GET['anno']);
      } else {
         $datosAtributos['annoSel'] = date('Y');
      }
      return $datosAtributos;
   }
}
