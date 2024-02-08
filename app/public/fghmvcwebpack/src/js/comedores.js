
if (document.getElementById('comedorescsv')) {
   document.getElementById('csvfile').addEventListener('change', function () {
      const csvfile = document.getElementById('csvfile').value
      const csvfile2 = csvfile.split('\\')
      console.log(csvfile2[2])
      document.getElementById('lbl_csvfile').innerHTML = csvfile2[2]
   })
}
if (document.getElementById('beneficiario')) {
   const endpoint = document.getElementById('endpoint').value
   const f_nacimiento = document.getElementById('f_nacimiento')
   const edad = document.getElementById('edad')
   const provincia = document.getElementById('provincia')
   const canton = document.getElementById('canton')
   const distrito = document.getElementById('distrito')
   const nonce_canton = document.getElementById('nonce_canton').value
   const action_canton = document.getElementById('action_canton').value
   const nonce_distrito = document.getElementById('nonce_distrito').value
   const action_distrito = document.getElementById('action_distrito').value
   f_nacimiento.addEventListener('change', () => {
      var fecha_actual = new Date()
      var f_nacimiento_val = new Date(f_nacimiento.value)
      var edad_calc = Math.floor((fecha_actual - f_nacimiento_val) / (365.25 * 24 * 60 * 60 * 1000))
      edad.value = edad_calc
   })
   provincia.addEventListener('change', () => {
      const provincia_id = provincia.value
      const datos = new FormData()
      datos.append('endpoint', endpoint)
      datos.append('action', action_canton)
      datos.append('nonce', nonce_canton)
      datos.append('provincia_id', provincia_id)
      async function buscar_canton() {
         const request = new Request(
            datos.get('endpoint'), {
            method: 'POST',
            body: datos,
         })
         try {
            const response = await fetch(request)
            const data = await response.json()
            if (data.success) {
               canton.innerHTML = '<option selected>Seleccionar Cantón</option>'
               const cantones = data.data
               cantones.forEach(cantones => {
                  canton.innerHTML += `<option value="${cantones.ID}">${cantones.canton}</option>`;
               });

            } else {
               console.log(data)
            }
         } catch (error) {
            console.log('Error: ', error)
         }
      }
      buscar_canton()
   })
   canton.addEventListener('change', () => {
      const canton_id = canton.value
      const datos = new FormData()
      datos.append('endpoint', endpoint)
      datos.append('action', action_distrito)
      datos.append('nonce', nonce_distrito)
      datos.append('canton_id', canton_id)
      async function buscar_distrito() {
         const request = new Request(
            datos.get('endpoint'), {
            method: 'POST',
            body: datos,
         })
         try {
            const response = await fetch(request)
            const data = await response.json()
            if (data.success) {
               distrito.innerHTML = '<option selected>Seleccionar Distrito</option>'
               const distritos = data.data
               distritos.forEach(distritos => {
                  distrito.innerHTML += `<option value="${distritos.ID}">${distritos.distrito}</option>`;
               });

            } else {
               console.log(data)
            }
         } catch (error) {
            console.log('Error: ', error)
         }
      }
      buscar_distrito()
   })

}
