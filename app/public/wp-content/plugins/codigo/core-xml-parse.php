<div class="d-flex justify-content-center">
   <form id="frm_xmlfile" enctype="multipart/form-data">
      <h3>XML Wordpress</h3>
      <div class="row">
         <div class="col">
            <label id="lbl_xmlfile" for="xmlfile" class="form-control text-center bg-primary text-white border-0 mb-3"><i class="fa-solid fa-magnifying-glass"></i> Buscar Arhcivo</label>
            <input type="file" accept=".xml" name="xmlfile" id="xmlfile" class="form-control" hidden>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <button id="btn_enviarfile" type="submit" value="Procesar" class="form-control btn btn-warning"><i class="fa-solid fa-cloud-arrow-up"></i> Procesar</button>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <div id="data" class="col"></div>
         </div>
      </div>
      <input type="hidden" name="action" value="xmlfile">
      <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('xmlfile') ?>">
      <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
      <input type="hidden" name="url" value="<?php echo get_template_directory_uri() . '/modules/core/' ?>">
      <input type="hidden" name="titulo" value="El archivo ha sido procesado">
   </form>
</div>

<script>
   if (document.getElementById('frm_xmlfile')) {
      const formulario = document.getElementById('frm_xmlfile')
      const dataform = new FormData(formulario)
      const xmlfile = document.getElementById('xmlfile')
      let url
      xmlfile.addEventListener('change', function() {
         if (xmlfile.value) {
            lbl_xmlfile.innerHTML = '<i class="fa-solid fa-file-csv"></i> ' + xmlfile.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1]
            const nombre_archivo = xmlfile.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1]
            url = dataform.get('url') + nombre_archivo;
         } else {
            lbl_xmlfile.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> Buscar Arhcivo'
            const nombre_archivo = ""
            url = "";
         }
      })

      formulario.addEventListener('submit', function(e) {
         e.preventDefault()
         xmldata()
      })

      async function xmldata() {
         const response = await fetch(url);
         const data = await response.text();
         try {
            if (data) {
               const parser = new DOMParser()
               const xml = parser.parseFromString(data, "application/xml")
               console.log(xml);
            } else {
               console.log('no hay datos');
            }
         } catch (error) {
            console.log('Error: ', error)
         }
      }

   }
</script>