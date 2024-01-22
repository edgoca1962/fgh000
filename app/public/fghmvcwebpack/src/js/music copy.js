// import Swal from "sweetalert2"
if (document.getElementById('discogs')) {
   const datoBuscar = document.getElementById('datoBuscar')
   const resultadosDiscogs = document.getElementById('resultadosDiscogs')
   const listadoDiscogs = document.getElementById('listadoDiscogs')
   const btnCerrarMusic = document.getElementById('btnCerrarMusic')
   btnCerrarMusic.addEventListener('click', f_cerrar_resultados)
   var typingTimer = 0;
   document.getElementById('btnBorrar').addEventListener('click', function () {
      location.reload()
   })
   datoBuscar.addEventListener('keyup', f_mostrar_resultados)

   function f_mostrar_resultados() {
      clearTimeout(typingTimer)
      typingTimer = setTimeout(f_obtener_resultados, 500)
   }

   function f_obtener_resultados() {
      if (datoBuscar.value != '') {
         const discogsApiUrl = `https://api.discogs.com/database/search?page=1&per_page=10`;
         const personalToken = 'RJRSNGepkZgYxgPFgPuLVGaOVCvYpEXDwxvokhyx';
         const searchQuery = datoBuscar.value;
         const queryParams = {
            q: searchQuery,
            token: personalToken,
            // type: 'release', //1605028
            // title: 'Latin Power',
            // artist: 'El Gran Combo',
         };
         const apiUrl = new URL(discogsApiUrl);
         Object.keys(queryParams).forEach(key => apiUrl.searchParams.append(key, queryParams[key]));

         async function getDatos() {
            try {
               const response = await fetch(apiUrl);
               const data = await response.json();
               var url
               if (data != null && data.results.length != 0) {
                  console.log('datos:', data.results)
                  if (data.results[0].type == 'master' || data.results[0].type == 'release') {
                     let album_id
                     if (data.results[0].master_id == 0) {
                        album_id = data.results[0].id
                        url = `https://api.discogs.com/releases/${album_id}`
                     } else {
                        album_id = data.results[0].master_id
                        url = `https://api.discogs.com/masters/${album_id}`;
                     }
                     resultadosDiscogs.removeAttribute('hidden')

                     const cover_image = data.results[0].cover_image
                     const thumb = data.results[0].thumb
                     const title = data.results[0].title.split('-')
                     const album = title[title.length - 1]
                     const artista = title[0]
                     const year = data.results[0].year

                     const releaseUrl = url;
                     const releaseDetailsUrl = new URL(releaseUrl);
                     releaseDetailsUrl.searchParams.append('token', personalToken);
                     const tracklist = await fetch(releaseDetailsUrl);
                     const datatracks = await tracklist.json()
                     if (datatracks != null) {
                        const listaCanciones = datatracks.tracklist
                        listadoDiscogs.innerHTML =
                           `
                           <button id='resultado' type='button' class='btn btn-light text-start'>
                              <div class="row">
                                 <div class="card mb-1 p-0">
                                    <div class="row">
                                       <div class="col-md-4">
                                          <img src="${thumb}" class="img-fluid rounded-start h-100" alt="Imágen de Album">
                                       </div>
                                       <div class="col-md-8 d-flex align-items-center">
                                       <p>
                                          <strong>${album}</strong> (${year})<br>
                                          <small class="text-body-secondary">${artista}</small>
                                       </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </button>
                           `
                        document.getElementById('resultado').addEventListener('click', insertarElemento)
                        function insertarElemento() {
                           const results = document.getElementById('results')
                           function elementFromHtml(html) {
                              const template = document.createElement('template')
                              template.innerHTML = html.trim()
                              return template.content.firstElementChild
                           }
                           var i = 1
                           const datosCancion = elementFromHtml(
                              `
                                 <div class="col">
                                    <div class="card h-100 shadow">
                                       <img src="${cover_image}" class="card-img-top" alt="Imágen del Album">
                                       <div class="card-body">
                                          <h5 class="card-title">${album} (${year})</h5>
                                          <p class="text-body-secondary">${artista}</p>
                                          <p class="card-text">
                                             ${listaCanciones.map(item => `${i++} - ${item.title} - ${item.duration}<br>`).join('')}
                                          </p>
                                          <p>ID: ${album_id}</p>
                                       </div>
                                    </div>
                                 </div>
                              `)
                           results.appendChild(datosCancion)
                           f_cerrar_resultados()
                        }
                     } else {
                        listadoDiscogs.innerHTML = `<h3>No se encontraron datos</h3>`
                     }
                  }
               } else {
                  listadoDiscogs.innerHTML = `<h3>No se encontraron datos</h3>`
               }
            } catch (error) {
               console.log(error);
            }
         }
         getDatos()
      } else {
         resultadosDiscogs.setAttribute('hidden', '')
      }
   }
   function f_cerrar_resultados() {
      datoBuscar.value = ""
      datoBuscar.focus()
      resultadosDiscogs.setAttribute('hidden', '')
   }
}

