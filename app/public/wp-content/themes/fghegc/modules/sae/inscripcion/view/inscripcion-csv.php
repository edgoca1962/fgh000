<?php if (get_post_meta(get_the_ID(), '_donativo', true) == 'on') : ?>
   <form class="needs-validation g-3" id="csvfilefrm">
      <button type="submit" class="btn btn-warning mb-5 shadow"><i class="fa-solid fa-cloud-arrow-down"></i> Extraer Inscripciones CSV</button>
      <input type="hidden" name="action" value="inscripciones_csvfile">
      <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('csvfile') ?>">
      <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
      <input type="hidden" name="post_parent" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
   </form>
<?php endif; ?>