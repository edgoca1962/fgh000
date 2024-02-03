<?php

namespace FGHEGC\Modules\Scp\Peticion;

use FGHEGC\Modules\Core\Singleton;

class PeticionController
{
   use Singleton;
   public $atributos;
   private function __construct()
   {
      $this->atributos = [];
   }

   public function get_atributos($postType)
   {
      $this->atributos = [];
      $this->atributos['titulo'] = 'Peticiones';
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-7';
      $this->atributos['div5'] = 'col-md-5';
      $this->atributos['regresar'] = $postType;
      $this->atributos['subtitulo'] = $this->get_datosAtributos($postType)['subtitulo'];
      $this->atributos['div4'] = $this->get_datosAtributos($postType)['div4'];
      $this->atributos['agregarpost'] = $this->get_datosAtributos($postType)['agregarpost'];
      $this->atributos['sidebar'] = $this->get_datosAtributos($postType)['sidebar'];
      $this->atributos['templatepart'] = $this->get_datosAtributos($postType)['templatepart'];
      $this->atributos['templatepartnone'] = $this->get_datosAtributos($postType)['templatepartnone'];
      $this->atributos['peticionClass'] = $this->get_datosAtributos($postType)['peticionClass'];
      $this->atributos['ocultarSidebar'] = $this->get_datosAtributos($postType)['ocultarSidebar'];
      $this->atributos['ocultarPeticiones'] = $this->get_datosAtributos($postType)['verPeticiones'];
      $this->atributos['adminPeticiones'] = $this->get_datosAtributos($postType)['adminPeticiones'];
      $this->atributos['verPeticiones'] = $this->get_datosAtributos($postType)['verPeticiones'];
      $this->atributos['motivos'] = $this->get_datosAtributos($postType)['motivos'];
      $this->atributos['asignacion'] = $this->get_datosSidebar()['asignacion'];
      $this->atributos['seguimiento'] = $this->get_datosSidebar()['seguimiento'];
      $this->atributos['cumpleanos'] = $this->get_datosSidebar()['cumpleanos'];
      $this->atributos['peticionesAsignadas'] = $this->get_datosSidebar()['peticionesAsignadas'];

      return $this->atributos;
   }

   private function get_datosAtributos($postType)
   {

      $datosAtributos['templatepartnone'] = 'modules/scp/' . $postType . '/view/' . $postType . '-none';

      $datosAtributos['agregarpost'] = '';
      $datosAtributos['sidebar'] = '';
      $datosAtributos['peticionClass'] = 'd-flex justify-content-center';
      $datosAtributos['ocultarSidebar'] = 'hidden';
      $datosAtributos['ocultarPeticiones'] = 'hidden';
      $datosAtributos['adminPeticiones'] = false;
      $datosAtributos['verPeticiones'] = false;
      $datosAtributos['asignados'] = [];
      if (is_user_logged_in()) {
         $usuarioRoles = wp_get_current_user()->roles;
         $datosAtributos['peticionClass'] = '';
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradminpeticion', $usuarioRoles)) {
            $datosAtributos['agregarpost'] = 'modules/scp/' . $postType . '/view/' . $postType . '-agregar';
            $datosAtributos['sidebar'] = 'modules/scp/' . $postType . '/view/' . $postType . '-sidebar';
            $datosAtributos['ocultarPeticiones'] = '';
            $datosAtributos['ocultarSidebar'] = '';
            $datosAtributos['adminPeticiones'] = true;
            $datosAtributos['verPeticiones'] = true;
         } else {
            if (in_array('peticiones', $usuarioRoles)) {
               $datosAtributos['sidebar'] = 'modules/scp/' . $postType . '/view/' . $postType . '-sidebar';
               $datosAtributos['ocultarSidebar'] = '';
               $datosAtributos['ocultarPeticiones'] = '';
               $datosAtributos['verPeticiones'] = true;
            }
         }
         $asignados =
            [
               'post_type' => 'peticion',
               'orderby' => '_f_seguimiento',
               'order' => 'DESC',
               'posts_per_page' => -1,
               'meta_query' =>
               [
                  'relation' => 'AND',
                  [
                     'key' => '_vigente',
                     'value' => 1,
                  ],
                  [
                     'key' => '_f_seguimiento',
                     'type' => 'DATE',
                     'value' => date('Y-m-d'),
                     'compare' => '<=',
                  ],
                  [
                     'key' => '_asignar_a',
                     'value' => wp_get_current_user()->ID,
                  ],
               ]
            ];
         $datosAtributos['asignados'] = get_posts($asignados);
      }

      $datosAtributos['templatepart'] = 'modules/scp/' . $postType . '/view/' . $postType;
      $datosAtributos['subtitulo'] = '';
      $datosAtributos['div4'] = 'row row-cols-1 g-4';
      if (is_single()) {
         $datosAtributos['templatepart'] = 'modules/scp/' . $postType . '/view/' . $postType . '-single';
         $datosAtributos['subtitulo'] = get_the_title();
         $datosAtributos['div4'] = '';
      }

      $datosAtributos['motivos'] = [
         'Salvación' =>
         [
            [
               'name' => 'cat1',
               'value' => 'salvacion-personal',
               'label' => 'Personal',
               'hidden' => '',
            ],
            [
               'name' => 'cat2',
               'value' => 'salvacion-familiares',
               'label' => 'Familiares',
               'hidden' => '',
            ],
            [
               'name' => 'cat3',
               'value' => 'salvacion-otros',
               'label' => 'Otros',
               'hidden' => '',
            ],
         ],
         'Salud' =>
         [
            [
               'name' => 'cat4',
               'value' => 'salud-personal',
               'label' => 'Personal',
               'hidden' => '',
            ],
            [
               'name' => 'cat5',
               'value' => 'salud-familiares',
               'label' => 'Familiares',
               'hidden' => '',
            ],
            [
               'name' => 'cat6',
               'value' => 'salud-otros',
               'label' => 'Otros',
               'hidden' => '',

            ],
         ],
         'Matrimonio' => [
            [
               'titulo' => 'Matrimonio',
               'name' => 'cat7',
               'value' => 'matrimonio-personal',
               'label' => 'Personal',
               'hidden' => '',
            ],
            [
               'titulo' => 'Matrimonio',
               'name' => 'cat8',
               'value' => 'matrimonio-familiares',
               'label' => 'Familiares',
               'hidden' => '',
            ],
            [
               'titulo' => 'Matrimonio',
               'name' => 'cat9',
               'value' => 'matrimonio-otros',
               'label' => 'Otros',
               'hidden' => '',
            ],
         ],
         'Provisión' => [
            [
               'titulo' => 'Provisión',
               'name' => 'cat10',
               'value' => 'provision-trabajo',
               'label' => 'Trabajo',
               'hidden' => '',
            ],
            [
               'titulo' => 'Provisión',
               'name' => 'cat11',
               'value' => 'manejo-finanzas',
               'label' => 'Manejo Financiero',
               'hidden' => '',
            ],
            [
               'titulo' => 'Provisión',
               'name' => 'cat12',
               'value' => 'provision-otro',
               'label' => 'Otro',
               'hidden' => '',
            ],
         ],
         'Otros' =>
         [
            [
               'name' => 'cat13',
               'value' => 'otros',
               'label' => 'Favor detallar',
               'hidden' => '',
            ],
            [
               'name' => '',
               'value' => 'sin-categoria',
               'label' => '',
               'hidden' => 'hidden',
            ],
            [
               'name' => '',
               'value' => 'sin-categoria',
               'label' => '',
               'hidden' => 'hidden',
            ],
         ],
      ];

      return $datosAtributos;
   }
   private function get_datosSidebar()
   {
      global $wpdb;
      $datosSidebar = [];

      $peticiones = get_posts(
         [
            'post_type' => 'peticion',
            'posts_per_page' => -1,
            'meta_query' => [
               [
                  'key' => '_vigente',
                  'value' => '1'
               ]
            ]
         ]
      );
      foreach ($peticiones as $peticion) {
         $f_nacimiento = get_post_meta($peticion->ID, '_f_nacimiento', true);
         if (date('m', strtotime($f_nacimiento)) == date('m') && date('Y', strtotime($f_nacimiento)) > 1910) {
            $bg = (date('d', strtotime($f_nacimiento)) == date('d')) ? 'bg-warning text-black' : 'bg-transparent text-white';
            $cumpleaneros[] = ['dia' => date('d', strtotime($f_nacimiento)), 'nombre' => get_post_meta($peticion->ID, '_nombre', true) . ' ' . get_post_meta($peticion->ID, '_apellido', true), 'telefono' => get_post_meta($peticion->ID, '_telefono', true), 'f_nacimiento' => get_post_meta($peticion->ID, '_f_nacimiento', true), 'bg' => $bg, 'f_cumple' => $f_nacimiento];
         }
      }
      asort($cumpleaneros);
      $datosSidebar['cumpleanos'] = $cumpleaneros;

      $datosSidebar['seguimiento'] =

         get_posts([
            'post_type' => 'peticion',
            'orderby' => get_the_date(),
            'order' => 'DESC',
            'posts_per_page' => -1,
            'meta_query' =>
            [
               [
                  'key' => '_vigente',
                  'value' => '1',
               ],
               [
                  'key' => '_f_seguimiento',
                  'type' => 'DATE',
                  'value' => date('Y-m-d'),
                  'compare' => '<=',
               ],
            ]
         ]);


      $datosSidebar['asignacion'] = $wpdb->get_results(
         "SELECT meta_value AS usr_id, 
            count(meta_key) AS total 
         FROM $wpdb->posts 
         INNER JOIN $wpdb->postmeta 
            ON (ID = post_id) 
         WHERE post_type = 'peticion' 
            AND (meta_key = '_asignar_a' AND meta_value != 0) 
         GROUP BY meta_value 
         ORDER BY meta_value",
         ARRAY_A
      );
      $datosSidebar['peticionesAsignadas'] = [];
      if (get_current_user_id()) {
         $datosSidebar['peticionesAsignadas'] =
            get_posts(
               [
                  'post_type' => 'peticion',
                  'orderby' => '_f_seguimiento',
                  'order' => 'DESC',
                  'posts_per_page' => -1,
                  'meta_query' =>
                  [
                     'relation' => 'AND',
                     [
                        'key' => '_vigente',
                        'value' => 1,
                     ],
                     [
                        'key' => '_f_seguimiento',
                        'type' => 'DATE',
                        'value' => date('Y-m-d'),
                        'compare' => '<=',
                     ],
                     [
                        'key' => '_asignar_a',
                        'value' => get_current_user_id(),
                     ],
                  ]
               ]

            );
      }

      return $datosSidebar;
   }
   public function get_oraciones($peticionID)
   {
      $conteoOraciones =
         count(
            get_posts(
               [
                  'post_type' => 'oracion',
                  'post_date' => date('Y-m-d'),
                  'meta_query' => [
                     [
                        'key' => '_peticion',
                        'value' => $peticionID,
                     ],
                  ]
               ]
            )
         );

      return $conteoOraciones;
   }
}
