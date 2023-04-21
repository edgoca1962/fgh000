<?php
$imagen = get_template_directory_uri() . '/assets/img/bgdefault.jpg'
?>

<div class="col text-dark">
    <div class="card h-100">
        <img src="<?= $imagen ?>" class="card-img-top" alt="post image">
        <div class="card-body">
            <h5 class="card-title"><?= the_title(sprintf('<h4><a href="%s" rel="bookmark">', esc_attr(esc_url(get_permalink()))), '</a></h4>') ?></h5>
            <p class="card-text"><?= the_excerpt() ?></p>
        </div>
        <div class="card-footer">
            <small class="text-muted">
                <?php if (has_tag()) {
                    echo get_the_tag_list('<p><span><i class="fas fa-tag"></i></span> Etiquetas: ', ', ', '</p>');
                } else {
                    echo '<span><i class="fas fa-tag"></i></span> Sin etiquetas.';
                } ?>
            </small>
        </div>
    </div>
</div>