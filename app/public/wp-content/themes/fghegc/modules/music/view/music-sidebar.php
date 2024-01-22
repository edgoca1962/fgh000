<div class="row p-0 mb-5">
   <div class="position-relative">
      <form id="discogs">
         <input id="datoBuscar" class="form-control" type="text" placeholder="Canción y/o Artista y/o Album " aria-label="Search">
      </form>
      <div id="resultadosDiscogs" class="container position-absolute search-overlay rounded-3 w-100 overflow-y-auto" style="height:350px;" hidden>
         <div class="d-flex justify-content-between">
            <h5>Resultados</h5><span id="btnCerrarMusic"><i class="far fa-times-circle"></i></span>
         </div>
         <div id="listadoDiscogs"></div>
      </div>
   </div>
</div>

<div class="row">
   <h4 class="text-center">Identificar canción por medio de archivo</h4>
   <form class="g-3" id="frmmusic" enctype="multipart/form-data">
      <div class="col">
         <label id="lbl_music" for="music" class="form-control text-center bg-primary text-white border-0 mb-3"><i class="fa-solid fa-magnifying-glass"></i> Buscar Arhcivo</label>
         <input type="file" accept=".mp3" name="music" id="music" class="form-control" hidden>
      </div>
      <div class="col">
         <button id="btn_enviarfile" type="submit" value="Procesar" class="form-control btn btn-warning"><i class="fa-solid fa-cloud-arrow-up"></i> Procesar</button>
      </div>
      <input type="hidden" name="action" value="music">
      <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('music') ?>">
      <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
      <input type="hidden" name="titulo_error" value="Archivo no seleccionado">
      <input type="hidden" name="msg_error" value="Por favor seleccionar un archivo de música.">
      <input type="hidden" name="titulo_procesado" value="El archivo ha sido procesado">
      <input type="hidden" name="msg_procesado" value="El archivo ha sido procesado">
   </form>
</div>