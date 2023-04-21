<div class="row">
   <div
      class="<?php echo isset(fgh000_get_param(get_post_type())['div2']) ? fgh000_get_param(get_post_type())['div2'] : '' ?>">
      <?php if (isset($_GET['cpt'])) {
         $postType = sanitize_text_field($_GET['cpt']);
         if (fgh000_get_param($postType)['userAdmin'] && isset($_GET['acta_id'])) {
            echo get_template_part(fgh000_get_param($postType)['agregarpost']);
         }
      }
      ?>
      <h3>No hay información registrada.</h3>
   </div>
   <div
      class="<?php echo isset(fgh000_get_param(get_post_type())['div4']) ? fgh000_get_param(get_post_type())['div4'] : '' ?>">
      <?php
      if (isset(fgh000_get_param(get_post_type())['barra'])) {
         get_template_part(fgh000_get_param(get_post_type())['barra']);
      }
      ?>
   </div>
</div>
