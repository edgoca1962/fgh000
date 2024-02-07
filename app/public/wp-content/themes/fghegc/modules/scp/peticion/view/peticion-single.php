<?php

/**
 * Template part for displaying page content-single-peticion.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FGHEGC
 */

use FGHEGC\Modules\Core\CoreController;

$core = CoreController::get_instance();
$atributos = $core->get_atributos(get_post_type());

$oracion_id = $post->ID;
$usuario = wp_get_current_user();
$editores = [1, 14];

$tdy = new DateTime('now', new DateTimeZone('America/Costa_Rica'));
$today = $tdy->format('Y-m-d');

$f_n = new DateTime(get_post_meta($post->ID, '_f_nacimiento', true), new DateTimeZone('America/Costa_Rica'));
$f_nacimiento = $f_n->format('Y-m-d');

$f_s = new DateTime(get_post_meta($post->ID, '_f_seguimiento', true), new DateTimeZone('America/Costa_Rica'));
$f_seguimiento = $f_s->format('Y-m-d');

$cats = wp_get_post_categories(get_the_ID(), array('fields' => 'ids'));
$tags = wp_get_post_tags(get_the_ID(), array('fields' => 'names'));

/************************************
 * Fecha Seguimiento y asignación
 ***********************************/

$time_string = '<time datetime="%1$s">%2$s</time>';
if (get_the_time('U') !== get_the_modified_time('U')) {
    $time_string = '<time datetime="%1$s">%2$s</time>';
} else {
    $time_string = 'Sin seguimiento';
}


$time_string = sprintf(
    $time_string,
    esc_attr(get_the_modified_date(DATE_W3C)),
    esc_html(get_the_modified_date())
);

$posted_on = sprintf(
    esc_html_x('Fecha Seguimiento: %s', 'post date', 'semillacr'),
    '<span>' . $time_string . '</span>'
);

$nombreasignada = get_user_by('ID', get_post_meta($post->ID, '_asignar_a', true));
if ($nombreasignada != null) {
    $nombre_asginada = $nombreasignada->display_name;
} else {
    $nombre_asginada = '';
}

$asignada_a = '<a href="' . site_url('/asignado-' . get_post_meta($post->ID, '_asignar_a', true))  . '">' . $nombre_asginada . '</a>';
$asignada = (get_post_meta($post->ID, '_asignar_a', true) == '') ? ' Sin asignar.' : $asignada_a;
$byline = sprintf(
    /* translators: %s: post author. */
    esc_html_x('Asignada a: %s', '', 'semillacr'),
    '<span>' . $asignada . '</span>'
);
/*********************************/

$conteoOraciones = new WP_Query(
    [
        'post_type' => 'oracion',
        'date_query' => [
            [
                'before' => $tdy->format('Y-m-d H:i:s'),
                'inclusive' => true,
            ],
        ],
        'meta_query' =>
        [
            [
                'key' => '_peticion',
                'value' => $oracion_id,
            ],
        ],
    ]
);
wp_reset_postdata();

$conteoUsuario = new WP_Query(
    [
        'post_type' => 'oracion',
        'author' => $usuario->ID,
        'meta_query' => [
            [
                'key' => '_peticion',
                'value' => $oracion_id,
            ],
        ],

        'date_query' => [
            [
                'before' => $tdy->format('Y-m-d H:i:s'),
                'inclusive' => true,
            ],
        ],
    ]
);
wp_reset_postdata();

if ($conteoUsuario->found_posts) {
    $oraciones = "si";
} else {
    $oraciones = 'no';
}


// echo wp_unique_post_slug('peticion', get_the_ID(), 'publish', 'peticion', get_the_ID())
?>
<?php if ($atributos['verPeticiones']) : ?>
    <section class="row">
        <form id="editar_peticiones" class="needs-validation" novalidate>
            <?php
            the_title('<h1 class="entry-title">', sprintf('<span class=text-danger> %s</span></h1>', (get_post_meta($post->ID, '_vigente', true) == '0') ? '(ELIMINAR)' : ''));
            ?>
            <header id="navegacion" style="height: auto;">
                <div class="row" class="d-flex entry-header mb-3">
                    <div class="col-10">
                        <p><button id="btn_editar" type="button" class="btn btn-danger" <?php echo (in_array(get_current_user_id(), $editores)) ? '' : 'disabled' ?>><i class="fas fa-pencil-alt"></i> Editar</button></p>
                        <p>
                            <?php
                            echo '<span class="text-muted">' . $posted_on . '</span>';
                            echo '<span class="text-muted"> ' . $byline . '</span>';
                            ?>
                        </p>

                        <a href="tel:<?php echo get_post_meta($post->ID, '_telefono', true) ?>"><span class="pe-2"><i class="fas fa-phone-alt"></i></span><?php echo get_post_meta($post->ID, '_telefono', true) ?></a><br>
                        <a href="mailto:<?php echo get_post_meta($post->ID, '_email', true) ?>"><span class="pe-2"><i class="fas fa-envelope"></i></span><?php echo get_post_meta($post->ID, '_email', true) ?></a>
                        <h5 class="py-3">Detalle de la petición</h5>
                        <p>
                            <?php the_content() ?>
                        </p>
                    </div>
                    <div class="col-2">
                        <button id="oracion" type="button" class="btn btn-outline-danger" data-oracion="<?php echo $oraciones ?>" data-url="<?php echo admin_url('admin-ajax.php') ?>" data-post_id="<?php echo get_the_ID() ?>" data-oracion_id="<?php echo isset($conteoUsuario->post->ID) ? $conteoUsuario->post->ID : 0 ?>">
                            <span><i class="fas fa-praying-hands"></i></span><span><?php echo ' ' . $conteoOraciones->found_posts ?></span>
                        </button>
                    </div>
                </div>
                <div class="row my-3">
                    <small class="text-muted">
                        <?php if (has_tag()) {
                            echo get_the_tag_list('<p><span><i class="fas fa-tag"></i></span> Etiquetas: ', ', ', '</p>');
                        } else {
                            echo '<span><i class="fas fa-tag"></i></span> Sin etiquetas.';
                        } ?>
                    </small>
                    <?php
                    /*
                $term_args = array(
                        'post_type'              => 'peticion',
                        'taxonomy'               => 'category',
                        'hide_empty'             => true,
                        'fields'                 => 'all'
                    );
                $term_query = new WP_Term_Query( $term_args );
                */

                    $taxonomy = 'category';

                    // Get the term IDs assigned to post.
                    $post_terms = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'ids'));
                    unset($post_terms[4]);

                    // Separator between links.
                    $separator = ', ';

                    if (!empty($post_terms) && !is_wp_error($post_terms)) {

                        $term_ids = implode(',', $post_terms);

                        $terms = wp_list_categories(array(
                            'title_li' => '',
                            'style'    => 'none',
                            'echo'     => false,
                            'taxonomy' => $taxonomy,
                            'include'  => $term_ids,
                            'exclude' => array(3)
                        ));

                        $terms = rtrim(trim(str_replace('<br />',  $separator, $terms)), $separator);
                    }
                    ?>

                    <small>
                        <?php if (has_category()) {
                            echo '<p class="text-muted">';
                            echo 'Motivos de oración: ' .  $terms;
                            echo '</p>';
                        } else {
                            echo 'Sin motivos de oración';
                        }
                        ?>
                    </small>
                </div>
            </header><!-- #encabezado -->
            <hr>
            <section id="campos_editables" class="invisible" style="height:0;">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <input type="text" name="nombre" placeholder="Nombre" class="form-control" value="<?php echo get_post_meta($post->ID, '_nombre', true) ?>" required>
                        <div class="invalid-feedback">
                            Por favor indicar un nombre.
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <input type="text" name="apellido" placeholder="Apellido" class="form-control" value="<?php echo get_post_meta($post->ID, '_apellido', true) ?>" required>
                        <div class="invalid-feedback">
                            Por favor indicar un apellido.
                        </div>
                    </div>
                </div> <!-- nombre y apellido -->
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <input type="email" name="email" placeholder="e-mail" class="form-control" value="<?php echo get_post_meta($post->ID, '_email', true) ?>" required>
                        <div class="invalid-feedback">
                            Por favor indicar un correo válido.
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <input type="text" name="telefono" placeholder="Teléfono móvil" class="form-control" value="<?php echo get_post_meta($post->ID, '_telefono', true) ?>" required>
                        <div class="invalid-feedback">
                            Por favor indicar un teléfono móvil.
                        </div>
                    </div>
                </div> <!-- email y teléfono -->
                <div class="row">
                    <h4 class="text-center">Motivos de oración</h4>
                    <div class="table-responsive">
                        <table class="table text-reset align-middle table-sm">
                            <tbody>
                                <tr>
                                    <td class="fs-4">Salvación:</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="cat1" type="checkbox" value="5" <?php echo (in_array('5', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Personal</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="cat2" type="checkbox" value="6" <?php echo (in_array('6', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Familiares</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="cat3" type="checkbox" value="7" <?php echo (in_array('7', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Otros</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-4">Salud:</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="cat4" type="checkbox" value="8" <?php echo (in_array('8', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Personal</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="cat5" type="checkbox" value="9" <?php echo (in_array('9', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Familiares</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="cat6" type="checkbox" value="10" <?php echo (in_array('10', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Otros</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-4">Matrimonio:</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="cat7" type="checkbox" value="11" <?php echo (in_array('11', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Personal</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="cat8" type="checkbox" value="12" <?php echo (in_array('12', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Familiares</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="cat9" type="checkbox" value="13" <?php echo (in_array('13', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Otros</label>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="fs-4">Provisión:</td>
                                    <td>
                                        <div class="form-check  form-check-inline">
                                            <input class="form-check-input" name="cat10" type="checkbox" value="14" <?php echo (in_array('14', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Trabajo</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check  form-check-inline">
                                            <input class="form-check-input" name="cat11" type="checkbox" value="15" <?php echo (in_array('15', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Manejo Finanzas</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check  form-check-inline">
                                            <input class="form-check-input" name="cat12" type="checkbox" value="16" <?php echo (in_array('16', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Otro</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-4">Otros:</td>
                                    <td>
                                        <div class="form-check  form-check-inline">
                                            <input class="form-check-input" name="cat13" type="checkbox" value="17" <?php echo (in_array('17', $cats)) ? 'checked' : '' ?>>
                                            <label class="form-check-label">Favor detallar</label>
                                        </div>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- Motivos de oración -->
                <div class="row mb-3">
                    <textarea name="peticion" cols="30" rows="5" class="form-control" placeholder="Espacio para detallar tu petición"><?php echo wp_strip_all_tags(get_the_content()) ?></textarea>
                </div> <!-- Detalle de la petición -->
            </section>
            <div class="row d-flex align-items-center mb-3">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <span>Vigencia <?php echo get_post_meta($post->ID, '_vigente', true) ?></span>
                        <!-- <label id="txt_vigencia" for="">Vigencia</label> -->
                        <div class="form-check form-switch">
                            <input id="vigente" class="form-check-input" type="checkbox" name="vigente" value="<?php echo get_post_meta($post->ID, '_vigente', true) ?>" <?php echo (get_post_meta($post->ID, '_vigente', true) == '1') ? 'checked' : '' ?>>
                            <label id="txt_vigente" class="form-check-label" for="vigente"><?php echo (get_post_meta($post->ID, '_vigente', true) == '0') ? 'Deshabilitado' : 'Vigente'; ?></label>
                        </div>
                        <div class="form-check form-switch">
                            <input id="marca_seguimiento" class="form-check-input" type="checkbox" name="marca_seguimiento" value="<?php echo get_post_meta($post->ID, '_marca_seguimiento', true) ?>" <?php echo (get_post_meta($post->ID, '_marca_seguimiento', true) == '1') ? 'checked' : '' ?>>
                            <label id="txt_marca_seguimiento" class="form-check-label" for="marca_seguimiento"><?php echo (get_post_meta($post->ID, '_marca_seguimiento', true) == '0') ? 'Sin seguimiento' : 'Seguimiento dado'; ?></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-3">
                                <span>Cantidad</span>
                                <input type="number" min="1" max="12" name="nperiodos" id="nperiodos" class="form-control" value="<?php echo get_post_meta($post->ID, '_nperiodos', true) ?>">
                            </div>
                            <div class="col-9">
                                <span>Periodicidad</span>
                                <select id="periodicidad" name='periodicidad' class="form-select" aria-label="Seleccionar frecuencia">
                                    <option <?php echo (get_post_meta($post->ID, '_periodicidad', true) == '1') ? 'value="1" selected' : 'value="1"' ?>>Dia(s)</option>
                                    <option <?php echo (get_post_meta($post->ID, '_periodicidad', true) == '2') ? 'value="2" selected' : 'value="2"' ?>>Semana(s)</option>
                                    <option <?php echo (get_post_meta($post->ID, '_periodicidad', true) == '3') ? 'value="3" selected' : 'value="3"' ?>>Mes(es)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="f_seguimiento">Próximo seguimiento</label>
                        <input id="f_seguimiento" type="date" name="f_seguimiento" value="<?php echo $f_seguimiento ?>" class="form-control" disabled>
                    </div>
                    <div class="col">
                        <label for="f_nacimient">Cumpleaños</label>
                        <input id="f_nacimiento" type="date" name="f_nacimiento" value="<?php echo ($f_nacimiento == $today) ? '' : $f_nacimiento ?>" class="form-control">
                    </div>
                </div>
            </div> <!-- Vigencia, Periodicidad, Fechas  -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <label for="asignar_a">Asignar petición a:</label>
                    <select name="asignar_a" id="asignar_a" class="form-select" aria-label="Selecionar miembro">
                        <option <?php echo (get_post_meta($post->ID, '_asignar_a', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar</option>
                        <?php
                        $usuarios = get_users('orderby=nicename&role=peticiones');
                        foreach ($usuarios as $usuario) {
                        ?>
                            <option <?php echo (get_post_meta($post->ID, '_asignar_a', true) == $usuario->ID) ? 'value="' . $usuario->ID . '" Selected' : 'value="' . $usuario->ID . '"' ?>><?php echo $usuario->display_name ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div> <!-- Asignación -->
            <div class="row mb-3">
                <h5 class="mt-3">Palabras Claves</h5>
                <div id="tagContainer" class="row row-cols-2 g-2 row-cols-md-4 g-lg-3">
                    <?php for ($i = 0; $i < count($tags); $i++) {  ?>
                        <div class="tag col">
                            <div class="p-1 rounded-1 border border-light bg-secondary d-flex justify-content-between align-items-center">
                                <i class="fas fa-tag"></i>
                                <span class="txt_etiqueta"><?php echo $tags[$i] ?></span>
                                <i class="fas fa-window-close" data-item="<?php echo $tags[$i] ?>"></i>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col">
                        <div class="input-group">
                            <input class="txtPalabraClave form-control rounded-start border-0 shadow-none" type="text" placeholder="Incluir palabra" aria-describedby="btn_agregar">
                            <button class="btn btn-outline-warning" type="button" id="btn_agregar"><i class="fas fa-tag"></i></button>
                        </div>
                    </div>
                </div>
            </div> <!-- Palabras clave -->

            <div id="btn_seguimiento" class="text-center text-md-start" style="height: auto;">
                <hr>
                <button id="btn_seg" type="button" class="btn btn-warning"><i class="fas fa-save"></i> Guardar cambios</button>
            </div>
            <hr>
            <div id="botones" class=" invisible" style="height: 0;">
                <div class="form-group d-flex justify-content-between py-3">
                    <button id="btn_guardar" type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
                    <button id="btn_cancelar" type="button" class="btn btn-warning"><i class="fas fa-window-close"></i> Cancelar</button>
                    <button id="btn_eliminar" type="buttom" class="btn btn-danger"><i class="fas fa-trash-alt"></i></i> Eliminar</button>
                </div> <!-- Botones Guardar y Cancelar -->
                <hr>
            </div>
            <input id="action" type="hidden" name="action" value="editar">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('editar') ?>">
            <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
            <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
            <input type="hidden" name="redireccion" value="<?php echo site_url('/') ?>">
            <input type="hidden" name="msgtxt" value="Datos actualizados correctamente.">
        </form>
        <div id="comentarios" class="mt-3">
            <?php
            if (comments_open() || get_comments_number())
                comments_template('/modules/scp/peticion/view/peticion-comments-single.php');
            ?>
        </div>

    </section><!-- #post-<?php the_ID(); ?> -->
<?php endif; ?>