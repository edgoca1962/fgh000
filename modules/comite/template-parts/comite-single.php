<div class="col">
    <div class="card h-100 border border-0 bg-transparent">
        <div class="card-body">
            <h2 class="card-title"><?php the_title() ?></h2>
            <?php the_content() ?>
        </div>
        <div class="card-footer">
            <small class="text">
                <?php if (has_tag()) {
                    echo get_the_tag_list('<p><span><i class="fas fa-tag"></i></span> Etiquetas: ', ', ', '</p>');
                } else {
                    echo '<span><i class="fas fa-tag"></i></span> Sin etiquetas.';
                } ?>
            </small>
        </div>
    </div>
</div>