
if (1 == 2) {
   const discogsApiUrl = `https://api.discogs.com/database/search`;
   const personalToken = 'jSHbCxgXWdKoHqJchKdWMZgWMqpvIzHVTyyFlNiO';
   const searchQuery = 'El padre antonio Buscando América';
   const queryParams = {
      q: searchQuery,
      // type: 'release', //1605028
      // title: 'Latin Power',
      // artist: 'El Gran Combo',
   };
   const apiUrl = new URL(discogsApiUrl);
   Object.keys(queryParams).forEach(key => apiUrl.searchParams.append(key, queryParams[key]));
   apiUrl.searchParams.append('token', personalToken);

   fetch(apiUrl)
      .then((response) => {
         if (!response.ok) {
            throw new Error('Network response was not ok');
         }
         return response.json();
      })
      .then((data) => {
         console.log('Search results:', data.results[0]);

         console.log(searchQuery)
         console.log(data.results[0].title)
         console.log(data.results[0].year)
         console.log(data.results[0].thumb)
         console.log(data.results[0].genre[0])
      })
}
/**
 * 
 * Discogs API
 * Consulta detallada obteniendo
 * el release id
 *  
 */
if (1 == 2) {

   // Consumer Key	gfhOnnAjNHOKCQvaMgAL
   // Consumer Secret	GDGBlbSqjhjtfkDdpDsPdLPwSMUfEbDr
   // https://api.discogs.com//masters/1296562

   const discogsApiUrl = `https://api.discogs.com/database/search`;
   const personalToken = 'jSHbCxgXWdKoHqJchKdWMZgWMqpvIzHVTyyFlNiO';
   const searchQuery = 'mi version';
   const queryParams = {
      q: searchQuery,
      type: 'release',
      title: 'retrospectiva vol. 2',
      artist: 'El Trabuco Venezolano',
   };
   const apiUrl = new URL(discogsApiUrl);
   Object.keys(queryParams).forEach(key => apiUrl.searchParams.append(key, queryParams[key]));
   apiUrl.searchParams.append('token', personalToken);

   fetch(apiUrl)
      .then((response) => {
         if (!response.ok) {
            throw new Error('Network response was not ok');
         }
         return response.json();
      })
      .then((data) => {
         console.log('Search results:', data.results[0]);
         const result = data.results[0]
         console.log(searchQuery)
         console.log(result.title)
         console.log(result.year)
         console.log(result.thumb)
         console.log(result.genre[0])
         const release_id = result.id

         const releaseUrl = `https://api.discogs.com/releases/${release_id}`;
         const releaseDetailsUrl = new URL(releaseUrl);
         releaseDetailsUrl.searchParams.append('token', personalToken);

         // Make the request to get detailed information about the album
         return fetch(releaseDetailsUrl);
      })
      .then(response => {
         if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
         }
         return response.json();
      })
      .then(releaseDetails => {
         // Access the tracklist from the detailed information
         console.log('Detalle Album', releaseDetails)
         const tracklist = releaseDetails.tracklist;
         console.log('Pistas', tracklist);
         // Process the tracklist as needed
      })
      .catch((error) => {
         console.error('There was a problem with the fetch operation:', error);
      });
}
/**
 * 
 * Discogs API
 * Consulta detallada obteniendo
 * el master id
 *  
 */
if (1 == 2) {

   // Consumer Key	gfhOnnAjNHOKCQvaMgAL
   // Consumer Secret	GDGBlbSqjhjtfkDdpDsPdLPwSMUfEbDr
   // https://api.discogs.com//masters/1296562

   const discogsApiUrl = `https://api.discogs.com/database/search`;
   const personalToken = 'jSHbCxgXWdKoHqJchKdWMZgWMqpvIzHVTyyFlNiO';
   const searchQuery = 'El Gran Combo';
   const queryParams = {
      q: searchQuery,
      type: 'master',
      title: 'Latin Power',
      artist: 'El Gran Combo',
   };
   const apiUrl = new URL(discogsApiUrl);
   Object.keys(queryParams).forEach(key => apiUrl.searchParams.append(key, queryParams[key]));
   apiUrl.searchParams.append('token', personalToken);

   fetch(apiUrl)
      .then((response) => {
         if (!response.ok) {
            throw new Error('Network response was not ok');
         }
         return response.json();
      })
      .then((data) => {
         console.log('Search results:', data.results[0]);
         const result = data.results[0]
         console.log(searchQuery)
         console.log(result.title)
         console.log(result.year)
         console.log(result.thumb)
         console.log(result.genre[0])
         const master_id = result.master_id

         const releaseUrl = `https://api.discogs.com/masters/${master_id}`;
         const releaseDetailsUrl = new URL(releaseUrl);
         releaseDetailsUrl.searchParams.append('token', personalToken);

         // Make the request to get detailed information about the album
         return fetch(releaseDetailsUrl);
      })
      .then(response => {
         if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
         }
         return response.json();
      })
      .then(releaseDetails => {
         // Access the tracklist from the detailed information
         console.log('Detalle Album', releaseDetails)
         const tracklist = releaseDetails.tracklist;
         console.log('Pistas', tracklist);
         // Process the tracklist as needed
      })
      .catch((error) => {
         console.error('There was a problem with the fetch operation:', error);
      });
}
/**
 * 
 * Shazan API
 * 
 */
if (1 == 2) {
   const track = 'Amor y Control'
   const url = `https://shazam-api6.p.rapidapi.com/shazam/search_track/?query=${encodeURIComponent(track)}`
   const options = {
      method: 'GET',
      headers: {
         'X-RapidAPI-Key': 'fac6024f48mshf58058b7d5d2180p17d271jsn7f789d8847fe',
         'X-RapidAPI-Host': 'shazam-api6.p.rapidapi.com'
      }
   };

   try {
      const response = await fetch(url, options);
      const result = await response.json();
      const track_id = result.result.tracks.hits[0].key;
      console.log(result);
      console.log(track_id);
   } catch (error) {
      console.error(error);
   }

}
/**
 * Busca una canción por su nombre, obtiene el track ID y el artista ID
 * y luego busca por el track ID para más información.
 */
if (1 == 2) {

   const track = 'Juana Mayo';

   const commonHeaders = {
      'X-RapidAPI-Key': 'fac6024f48mshf58058b7d5d2180p17d271jsn7f789d8847fe',
      'X-RapidAPI-Host': 'shazam-api6.p.rapidapi.com',
   };
   const firstQueryUrl = `https://shazam-api6.p.rapidapi.com/shazam/search_track/?query=${encodeURIComponent(track)}`;
   const firstQueryOptions = {
      method: 'GET',
      headers: commonHeaders,
   };

   try {
      const firstQueryResponse = await fetch(firstQueryUrl, firstQueryOptions);
      const firstQueryResult = await firstQueryResponse.json();
      const track_id = firstQueryResult.result.tracks.hits[0].key;
      const artist_id = firstQueryResult.result.tracks.hits[0].artists[0].adamid;
      const scanResults = firstQueryResult.result.tracks.hits;

      scanResults.forEach((artistId) => {
         if (artist_id == artistId.artists[0].adamid) {
            console.log(artistId.artists[0].adamid)
         }
      })

      console.log('Search track:', firstQueryResult);

      const secondQueryUrl = `https://shazam-api6.p.rapidapi.com/shazam/about_track?track_id=${track_id}`;
      const secondQueryOptions = {
         method: 'GET',
         headers: commonHeaders,
      };
      const secondQueryResponse = await fetch(secondQueryUrl, secondQueryOptions);
      const secondQueryResult = await secondQueryResponse.json();
      console.log('About track:', secondQueryResult);

   } catch (error) {
      console.error(error);
   }
}

if (1 == 2) {
   if (document.getElementById('frmmusic')) {
      const formulario = document.getElementById('frmmusic')
      const btn_procesar = document.getElementById('btn_enviarfile')
      formulario.addEventListener('submit', function (event) {
         event.preventDefault()
         event.stopPropagation()
         const formularioData = new FormData(formulario)
         const file = formularioData.get('music')
         const data = new FormData()
         data.append('upload_file', file);
         const url = 'https://shazam-api6.p.rapidapi.com/shazam/recognize/';
         // const data = new FormData();
         // data.append('upload_file', "01. Juana Mayo (A Woman's Name).mp3");
         const options = {
            method: 'POST',
            headers: {
               'X-RapidAPI-Key': 'fac6024f48mshf58058b7d5d2180p17d271jsn7f789d8847fe',
               'X-RapidAPI-Host': 'shazam-api-free.p.rapidapi.com'
               // 'X-RapidAPI-Host': 'shazam-api6.p.rapidapi.com'
               // 'X-RapidAPI-Host': 'shazam.p.rapidapi.com'

            },
            body: data
         };
         consultaArchivo(url, options)
      })
   }
   async function consultaArchivo(url, options) {

      try {
         Swal.fire({
            title: 'Identificando canción',
            didOpen: () => {
               Swal.showLoading()
            }
         })
         const response = await fetch(url, options);
         const result = await response.json();
         if (result.status) {
            console.log('Track:', result.result.track);
            const track = result.result.track
            const title = track.title != '' ? track.title : 'No econtrado'
            const album = track.sections[0].metadata.length > 0 ? track.sections[0].metadata[0].text : 'No econtrado'
            const artista = track.subtitle != '' ? track.subtitle : 'No econtrado'
            const anno = track.sections[0].metadata.length > 1 ? track.sections[0].metadata[2].text : 'No econtrado'
            const genero = track.genres.primary != '' ? track.genres.primary : 'No econtrado'
            function elementFromHtml(html) {
               const template = document.createElement('template')
               template.innerHTML = html.trim()
               return template.content.firstElementChild
            }
            const datosCancion = elementFromHtml(`
               <div class="col">
                  <div class="card h-100">
                     <img id="img_track" src="${result.result.track.images.coverart}" class="card-img-top" alt="Imágen de Disco">
                     <div class="card-body">
                        <h5 class="card-title">Título: <span id="trackTitle">${title}</span></h5>
                        <p class="card-text">Album: <span id="album">${album}</span></p>
                        <p class="card-text">Artista: <span id="artista">${artista}</span></p>
                        <p class="card-text">Año: <span id="anno"></span>${anno}</p>
                        <p class="card-text">Género: <span id="genero">${genero}</span></p>
                     </div>
                  </div>
               </div>
            `)
            document.getElementById('results').appendChild(datosCancion)
            Swal.fire({
               icon: 'success',
               title: 'Canción Identificada',
               showClass: {
                  popup: 'animate__animated animate__fadeInDown'
               },
               hideClass: {
                  popup: 'animate__animated animate__fadeOutUp'
               },
               text: 'La canción fue identificada.',
               showConfirmButton: false,
               timer: 2000
            });
         } else {
            Swal.fire({
               icon: 'error',
               title: 'Canción no identificada',
               showClass: {
                  popup: 'animate__animated animate__fadeInDown'
               },
               hideClass: {
                  popup: 'animate__animated animate__fadeOutUp'
               },
               text: 'No fue posible identificar la canción.',
               showConfirmButton: false,
               timer: 4000
            });
            setTimeout(() => {
               location.reload()
            }, 4000);
         }
      } catch (error) {
         console.error(error);
      }
   }
}
