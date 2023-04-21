<section id="hero-page" class="d-flex flex-column justify-content-center align-items-center text-white"
    style="background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(<?php echo fgh000_get_param(get_post_type())['imagen'] ?>) no-repeat center /cover; height: <?php echo fgh000_get_param(get_post_type())['height'] ?>;">
    <p
        class="animate__animated animate__fadeInDown mb-3 text-center  <?php echo isset(fgh000_get_param(get_post_type())['fontweight']) ? fgh000_get_param(get_post_type())['fontweight'] : 'fw-lighter' ?>  <?php echo isset(fgh000_get_param(get_post_type())['display']) ? fgh000_get_param(get_post_type())['display'] : 'display-4' ?>">
        <?php echo isset(fgh000_get_param(get_post_type())['titulo']) ? fgh000_get_param(get_post_type())['titulo'] : 'No hay información registrada' ?></p>
    <p
        class="animate__animated animate__fadeInUp mb-3 text-center <?php echo isset(fgh000_get_param(get_post_type())['fontweight']) ? fgh000_get_param(get_post_type())['fontweight'] : 'fw-lighter' ?>  <?php echo isset(fgh000_get_param(get_post_type())['displaysub']) ? fgh000_get_param(get_post_type())['displaysub'] : 'display-5' ?>">
        <?php echo isset(fgh000_get_param(get_post_type())['subtitulo']) ? fgh000_get_param(get_post_type())['subtitulo'] : '' ?></p>
    <p
        class="animate__animated animate__fadeInUp text-center  <?php echo isset(fgh000_get_param(get_post_type())['fontweight']) ? fgh000_get_param(get_post_type())['fontweight'] : 'fw-lighter' ?>  <?php echo isset(fgh000_get_param(get_post_type())['displaysub2']) ? fgh000_get_param(get_post_type())['displaysub2'] : 'display-6' ?>">
        <?php echo isset(fgh000_get_param(get_post_type())['subtitulo2']) ? fgh000_get_param(get_post_type())['subtitulo2'] : '' ?></p>
</section>
