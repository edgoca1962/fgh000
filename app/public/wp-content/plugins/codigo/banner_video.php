<?php

/**
 * Banner dinámico
 * 
 * @package:FGHMVC
 */

use FGHMVC\modules\core\controller\Atributos;

$atributos = Atributos::get_instance()->get_atributos(get_post_type());

?>
<section class="d-flex justify-content-center align-items-center position-relative">
    <video autoplay muted loop src="<?php echo get_template_directory_uri() ?>'/assets/img/video_bg2.mp4'" style="width:100vw;"></video>
    <div class="position-absolute">
        <p class="animate__animated animate__fadeInDown mb-3 fw-bolder text-center  <?php echo isset($atributos['fontweight']) ? $atributos['fontweight'] : 'fw-lighter' ?>  <?php echo isset($atributos['display']) ? $atributos['display'] : 'display-4' ?>">
            <?php echo isset($atributos['titulo']) ? $atributos['titulo'] : 'No hay información registrada' ?></p>
        <p class="animate__animated animate__fadeInUp mb-3 text-center <?php echo isset($atributos['fontweight']) ? $atributos['fontweight'] : 'fw-lighter' ?>  <?php echo isset($atributos['displaysub']) ? $atributos['displaysub'] : 'display-5' ?>">
            <?php echo isset($atributos['subtitulo']) ? $atributos['subtitulo'] : '' ?></p>
        <p class="animate__animated animate__fadeInUp text-center  <?php echo isset($atributos['fontweight']) ? $atributos['fontweight'] : 'fw-lighter' ?>  <?php echo isset($atributos['displaysub2']) ? $atributos['displaysub2'] : 'display-6' ?>">
            <?php echo isset($atributos['subtitulo2']) ? $atributos['subtitulo2'] : '' ?></p>
    </div>
</section>