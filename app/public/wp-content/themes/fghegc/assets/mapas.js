const coordenadas = { lat: 10.15416, lng: -85.04341 }
const mapa = document.getElementById('mapa')
const localizacion = document.getElementById('localizacion')
let map
let marker
let autocomplete
function initMap() {
   if (document.getElementById('mapa')) {

      map = new google.maps.Map(mapa, {
         center: coordenadas,
         zoom: 13
      })
      marker = new google.maps.Marker({
         position: coordenadas,
         map: map,
      })
      geocoder = new google.maps.Geocoder()
   }
}
if (document.getElementById('localizacion')) {

   document.getElementById('localizacion').addEventListener('change', codeAddress)

   function codeAddress() {
      const address = document.getElementById('localizacion').value;
      geocoder.geocode({
         'address': address
      }, function (results, status) {
         if (status == 'OK') {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
               map: map,
               position: results[0].geometry.location
            });
         } else {
            console.log('Geocode was not successful for the following reason: ' + status);
         }
      });
   }
}
/*
const coordenadas = { lat: 10.15416, lng: -85.04341 }
let mapa
let autocomplete
const localizacion = document.getElementById('localizacion')
async function initMap() {
   const { Map } = await google.maps.importLibrary("maps")
   const { Marker } = await google.maps.importLibrary("marker")

   mapa = new Map(document.getElementById('mapa'), {
      center: coordenadas,
      zoom: 12,
      mapID: "DEMO_MAP_ID",
   })
   const marker = new Marker({
      map: mapa,
      position: coordenadas,
      title: 'Abangares'
   })
   const autocomplete = new google.maps.places.Autocomplete(document.getElementById('localizacion'), {
      fields: ['place_id', 'geometry', 'name']
   })
   autocomplete.addListener('place_changed', buscarLugar)
}

function buscarLugar() {
   var place = autocomplete.getPlace()
   if (!place.geometry) {
      document.getElementById('localizacion').placeholder = "Ingrese una dirección"
   } else {
      document.getElementById('detalles').innerHTML = place.name
   }
}
*/