<?php if (isset($_GET['fpe'])): ?>
   <div class="my-3">
      <button class="btn btn-warning btn-sm"><a class="text-black"
            href="<?php echo get_post_type_archive_link(fgh000_get_param(get_post_type())['regresar']) . 'page/' . fgh000_get_param(get_post_type())['pag_ant'] . '/?fpe=' . sanitize_text_field($_GET['fpe']) ?>">Regresar</a></button>
   </div>
<?php else: ?>
   <div class="my-3">
      <button class="btn btn-warning btn-sm"><a class="text-black"
            href="<?php echo get_post_type_archive_link(fgh000_get_param(get_post_type())['regresar']) . 'page/' . fgh000_get_param(get_post_type())['pag_ant'] . '/?' . fgh000_get_param($post->post_type)['parametros'] ?>">Regresar</a></button>
   </div>
<?php endif; ?>
