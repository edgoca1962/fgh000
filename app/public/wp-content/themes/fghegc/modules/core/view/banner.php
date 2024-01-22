<?php

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos(get_post_type());

?>
<section id="hero-page" class="d-flex flex-column justify-content-center align-items-center text-white" style="background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(<?php echo $atributos['imagen'] ?>) no-repeat center /cover; height: <?php echo $atributos['height'] ?>;">
    <p class="animate__animated animate__fadeInDown mb-3 text-center  <?php echo $atributos['fontweight'] ?>  <?php echo $atributos['display'] ?>">
        <?php echo $atributos['titulo'] ?></p>
    <p class="animate__animated animate__fadeInUp mb-3 text-center <?php echo $atributos['fontweight'] ?>  <?php echo $atributos['displaysub'] ?>">
        <?php echo $atributos['subtitulo'] ?></p>
    <p class="animate__animated animate__fadeInUp text-center  <?php echo $atributos['fontweight'] ?>  <?php echo $atributos['displaysub2'] ?>">
        <?php echo  $atributos['subtitulo2'] ?></p>
</section>