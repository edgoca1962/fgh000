// import Swal from "sweetalert2"
if (document.getElementById('discogs')) {
   const datoBuscar = document.getElementById('datoBuscar')
   const resultadosDiscogs = document.getElementById('resultadosDiscogs')
   const listadoDiscogs = document.getElementById('listadoDiscogs')
   const btnCerrarMusic = document.getElementById('btnCerrarMusic')
   const discogsApiUrl = `https://api.discogs.com/database/search?page=1&per_page=10`;
   const personalToken = 'RJRSNGepkZgYxgPFgPuLVGaOVCvYpEXDwxvokhyx';

   btnCerrarMusic.addEventListener('click', f_cerrar_resultados)
   var typingTimer = 0;

   datoBuscar.addEventListener('keyup', f_mostrar_resultados)

   function f_mostrar_resultados() {
      clearTimeout(typingTimer)
      typingTimer = setTimeout(f_obtener_resultados, 500)
   }

   function f_obtener_resultados() {
      if (datoBuscar.value != '') {
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
                  listadoDiscogs.innerHTML = ""
                  resultadosDiscogs.removeAttribute('hidden')
                  let album_id
                  for (let index = 0; index < data.results.length; index++) {
                     const element = data.results[index];
                     if (data.results[index].type == 'master' || data.results[index].type == 'release') {
                        let dataset_type
                        if (data.results[index].master_id == 0) {
                           album_id = data.results[index].id
                           url = `https://api.discogs.com/releases/${album_id}`
                           dataset_type = 'release'
                        } else {
                           album_id = data.results[index].master_id
                           url = `https://api.discogs.com/masters/${album_id}`;
                           dataset_type = 'master'
                        }

                        const thumb = data.results[index].thumb
                        const title = data.results[index].title.split('-')
                        const album = title[title.length - 1]
                        const artista = title[0]
                        const year = data.results[index].year

                        function insertarElementoVentana() {
                           function elementFromHtml(html) {
                              const template = document.createElement('template')
                              template.innerHTML = html.trim()
                              return template.content.firstElementChild
                           }
                           var i = 1
                           const datosBusqueda = elementFromHtml(
                              `
                           <button data-album_id='${album_id}' data-type=${dataset_type} type='button' class='btn btn-light text-start'>
                              <div class="row d-flex">
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
                              `)
                           listadoDiscogs.appendChild(datosBusqueda)
                        }
                        insertarElementoVentana()
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
   document.addEventListener('click', async function (event) {

      if (event.target.closest('button') != null) {
         const boton = event.target.closest('button')
         const album_id = boton.dataset.album_id
         const album_type = boton.dataset.type
         let url
         if (album_type == 'release') {
            url = `https://api.discogs.com/releases/${album_id}`
         } else {
            url = `https://api.discogs.com/masters/${album_id}`;
         }

         const releaseUrl = url;
         const releaseDetailsUrl = new URL(releaseUrl);
         releaseDetailsUrl.searchParams.append('token', personalToken);
         try {
            const albumId = await fetch(releaseDetailsUrl);
            const albumIdData = await albumId.json()

            console.log(albumIdData)
            const artists = albumIdData.artists[0].name
            const images = albumIdData.images[0].uri
            const title = albumIdData.title //album
            const year = albumIdData.year
            const listaCanciones = albumIdData.tracklist

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
                                       <img src="${images}" class="card-img-top" alt="Imágen del Album">
                                       <div class="card-body">
                                          <h5 class="card-title">${title} (${year})</h5>
                                          <p class="text-body-secondary">${artists}</p>
                                          <p class="card-text">
                                             ${listaCanciones.map(item => `${i++} - ${item.title} - ${item.duration}<br>`).join('')}
                                          </p>
                                       </div>
                                       <div class="card-footer">
                                          ID: ${album_id} (${album_type})
                                       </div>
                                    </div>
                                 </div>
                              `)
               results.appendChild(datosCancion)
               f_cerrar_resultados()
            }
            insertarElemento()
         } catch (error) {
            console.log(error);
         }
      }
   })

   function f_cerrar_resultados() {
      datoBuscar.value = ""
      datoBuscar.focus()
      resultadosDiscogs.setAttribute('hidden', '')
   }
}

