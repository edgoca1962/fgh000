<div class="container d-flex justify-content-center">
   <div class="row">
      <h4 class="text-center">CSV File Import</h4>
      <form class="needs-validation g-3" id="csvfilefrm" enctype="multipart/form-data">
         <div class="col">
            <label id="lbl_csvfile" for="csvfile" class="form-control text-center bg-primary text-white border-0 mb-3"><i class="fa-solid fa-magnifying-glass"></i> Buscar Arhcivo</label>
            <input type="file" accept=".csv" name="csvfile" id="csvfile" class="form-control" hidden>
         </div>
         <div class="col">
            <button id="btn_enviarfile" type="submit" value="Procesar" class="form-control btn btn-warning"><i class="fa-solid fa-cloud-arrow-up"></i> Procesar</button>
         </div>
         <input type="hidden" name="action" value="csvfile">
         <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('csvfile') ?>">
         <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
      </form>
   </div>
</div>