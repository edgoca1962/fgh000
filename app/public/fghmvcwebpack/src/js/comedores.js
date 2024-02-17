if (document.getElementById('comedorescsv')) {
   document.getElementById('csvfile').addEventListener('change', function () {
      const csvfile = document.getElementById('csvfile').value
      const csvfile2 = csvfile.split('\\')
      console.log(csvfile2[2])
      document.getElementById('lbl_csvfile').innerHTML = csvfile2[2]
   })
}
if (document.getElementById('beneficiario_single')) {
   document.getElementById('reflexion').addEventListener('click', () => {
      if (document.getElementById('reflexion').value == 'No') {
         document.getElementById('reflexion').value = 'Si'
      } else {
         document.getElementById('reflexion').value = 'No'
      }
   })
   document.getElementById('alimentacion').addEventListener('click', () => {
      if (document.getElementById('alimentacion').value == 'No') {
         document.getElementById('alimentacion').value = 'Si'
      } else {
         document.getElementById('alimentacion').value = 'No'
      }
   })
}
if (document.getElementById('beneficiario_single_editar')) {
   const formulario = document.getElementById('beneficiario_single')
   const datos = new FormData(formulario)
   const elementosConEditar = document.querySelectorAll('[editar]');
   elementosConEditar.forEach(function (elemento) {
      elemento.setAttribute('disabled', '');
   });
   if (datos.get('f_nacimiento') !== undefined || datos.get('f_nacimiento') !== null) {
      var fecha_actual = new Date()
      var f_nacimiento_val = new Date(datos.get('f_nacimiento'))
      var edad_calc = Math.floor((fecha_actual - f_nacimiento_val) / (365.25 * 24 * 60 * 60 * 1000))
      document.getElementById('editar_edad').value = edad_calc
      datos.set('edad', edad_calc)
   }
   document.getElementById('btn_cancelar').addEventListener('click', () => {
      location.reload()
   })
   document.getElementById('btn_editar_beneficiario').addEventListener('click', () => {
      document.getElementById('seccion_beneficiario_single').setAttribute('hidden', '')
      const post_id = document.getElementById('btn_editar_beneficiario').dataset.scc_post_id
      const action = document.getElementById('btn_editar_beneficiario').dataset.action
      const nonce = document.getElementById('btn_editar_beneficiario').dataset.nonce
      const endpoint = document.getElementById('endpoint').value
      datos.append('post_id', post_id)
      datos.append('endpoint', endpoint)
      datos.append('action', action)
      datos.append('nonce', nonce)
      /*
      for (var pair of datos.entries()) {
         var nombre = pair[0];
         var valor = pair[1];
         console.log("Nombre:", nombre, "Valor:", valor);
      }
      */
      document.getElementById('nombre').value = datos.get('nombre')
      document.getElementById('p_apellido').value = datos.get('p_apellido')
      document.getElementById('s_apellido').value = datos.get('s_apellido')
      if (datos.get('sexo') == '2') {
         document.getElementById('femenino').setAttribute('checked', '')
      } else {
         document.getElementById('masculino').setAttribute('checked', '')
      }
      document.getElementById('f_nacimiento').value = datos.get('f_nacimiento')
      document.getElementById('f_ingreso').value = datos.get('f_ingreso')
      document.getElementById('f_salida').value = datos.get('f_salida')
      document.getElementById('edad').value = datos.get('edad')
      document.getElementById('peso').value = datos.get('peso')
      document.getElementById('estatura').value = datos.get('estatura')
      function datos_provincias() {
         const provincia = document.getElementById('provincia')
         const datos_provincias = new FormData()
         datos_provincias.append('nonce', datos.get('nonce_provincia'))
         datos_provincias.append('action', datos.get('action_provincia'))
         async function get_provincias() {
            const request = new Request(
               endpoint, {
               method: 'POST',
               body: datos_provincias,
            })
            try {
               const response = await fetch(request)
               const data = await response.json()
               if (data.success) {
                  provincia.innerHTML = ''
                  const provincias = data.data
                  provincias.forEach(provincias => {
                     if (datos.get('provincia_id') == provincias.ID) {
                        provincia.innerHTML += `<option selected value="${provincias.ID}">${provincias.provincia}</option>`;
                     } else {
                        provincia.innerHTML += `<option value="${provincias.ID}">${provincias.provincia}</option>`;
                     }
                  });
               } else {
                  console.log(data)
               }
            } catch (error) {
               console.log('Error: ', error)
            }
         }
         get_provincias()
      }
      datos_provincias()
      function datos_cantones() {
         const canton = document.getElementById('canton')
         const datos_cantones = new FormData()
         datos_cantones.append('nonce', datos.get('nonce_canton'))
         datos_cantones.append('action', datos.get('action_canton'))
         datos_cantones.append('provincia_id', datos.get('provincia_id'))
         async function get_cantones() {
            const request = new Request(
               endpoint, {
               method: 'POST',
               body: datos_cantones,
            })
            try {
               const response = await fetch(request)
               const data = await response.json()
               if (data.success) {
                  canton.innerHTML = ''
                  const cantones = data.data
                  cantones.forEach(cantones => {
                     if (datos.get('canton_id') == cantones.ID) {
                        canton.innerHTML += `<option selected value="${cantones.ID}">${cantones.canton}</option>`;
                     } else {
                        canton.innerHTML += `<option value="${cantones.ID}">${cantones.canton}</option>`;
                     }
                  });
               } else {
                  console.log(data)
               }
            } catch (error) {
               console.log('Error: ', error)
            }
         }
         get_cantones()
      }
      datos_cantones()
      function datos_distritos() {
         const distrito = document.getElementById('distrito')
         const datos_distritos = new FormData()
         datos_distritos.append('nonce', datos.get('nonce_distrito'))
         datos_distritos.append('action', datos.get('action_distrito'))
         datos_distritos.append('canton_id', datos.get('canton_id'))
         async function get_distritos() {
            const request = new Request(
               endpoint, {
               method: 'POST',
               body: datos_distritos,
            })
            try {
               const response = await fetch(request)
               const data = await response.json()
               if (data.success) {
                  distrito.innerHTML = ''
                  const distritos = data.data
                  distritos.forEach(distritos => {
                     if (datos.get('distrito_id') == distritos.ID) {
                        distrito.innerHTML += `<option selected value="${distritos.ID}">${distritos.distrito}</option>`;
                     } else {
                        distrito.innerHTML += `<option value="${distritos.ID}">${distritos.distrito}</option>`;
                     }
                  });
               } else {
                  console.log(data)
               }
            } catch (error) {
               console.log('Error: ', error)
            }
         }
         get_distritos()
      }
      datos_distritos()
      document.getElementById('direccion').value = datos.get('direccion')
      document.getElementById('email').value = datos.get('email')
      document.getElementById('t_principal').value = datos.get('t_principal')
      document.getElementById('t_otros').value = datos.get('t_otros')
      document.getElementById('n_madre').value = datos.get('n_madre')
      document.getElementById('n_padre').value = datos.get('n_padre')
      function datos_comedores() {
         const comedor = document.getElementById('comedor')
         const datos_comedores = new FormData()
         datos_comedores.append('nonce', datos.get('nonce_comedor'))
         datos_comedores.append('action', datos.get('action_comedor'))
         async function get_comedores() {
            const request = new Request(
               endpoint, {
               method: 'POST',
               body: datos_comedores,
            })
            try {
               const response = await fetch(request)
               const data = await response.json()
               if (data.success) {
                  comedor.innerHTML = ''
                  const comedores = data.data
                  console.log(datos.get('post_parent'))
                  comedores.forEach(item => {
                     if (datos.get('post_parent') == item.ID) {
                        comedor.innerHTML += `<option selected value="${item.ID}">${item.comedor}</option>`;
                     } else {
                        if (datos.get('post_parent') == 0) {
                           comedor.innerHTML += `<option value="0">Sin Asignar</option>`;
                        } else {
                           comedor.innerHTML += `<option value="${item.ID}">${item.comedor}</option>`;
                        }
                     }
                  });
               } else {
                  console.log(data)
               }
            } catch (error) {
               console.log('Error: ', error)
            }
         }
         get_comedores()
      }
      datos_comedores()
      document.getElementById('content').value = datos.get('content')

      document.getElementById('seccion_beneficiario_single_editar').removeAttribute('hidden')
   })
   document.getElementById('btn_actualizar_asistencia').addEventListener('click', () => {
      document.getElementById('asistencia').setAttribute('hidden', '')
      document.getElementById('btn_asistencia').removeAttribute('hidden')

   })
}
if (document.getElementById('beneficiario_ninos')) {
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

   if (document.getElementById('beneficiario_imagen')) {
      document.getElementById('beneficiario_imagen').addEventListener('change', function () {
         const imagen = this.files[0]
         if (imagen) {
            const reader = new FileReader()
            document.getElementById('imagennueva').display = 'block'
            reader.addEventListener('load', function () {
               document.getElementById('imagennueva').setAttribute('src', this.result)
            })
            reader.readAsDataURL(imagen)
         } else {
            console.log('por definir')
         }
      })
   }
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
      for (var pair of datos.entries()) {
         var nombre = pair[0];
         var valor = pair[1];
         console.log("Nombre:", nombre, "Valor:", valor);
      }
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
      for (var pair of datos.entries()) {
         var nombre = pair[0];
         var valor = pair[1];
         console.log("Nombre:", nombre, "Valor:", valor);
      }
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
if (document.getElementById('beneficiario_adultos')) {
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

   if (document.getElementById('beneficiario_imagen')) {
      document.getElementById('beneficiario_imagen').addEventListener('change', function () {
         const imagen = this.files[0]
         if (imagen) {
            const reader = new FileReader()
            document.getElementById('imagennueva').display = 'block'
            reader.addEventListener('load', function () {
               document.getElementById('imagennueva').setAttribute('src', this.result)
            })
            reader.readAsDataURL(imagen)
         } else {
            console.log('por definir')
         }
      })
   }
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
      for (var pair of datos.entries()) {
         var nombre = pair[0];
         var valor = pair[1];
         console.log("Nombre:", nombre, "Valor:", valor);
      }
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
      for (var pair of datos.entries()) {
         var nombre = pair[0];
         var valor = pair[1];
         console.log("Nombre:", nombre, "Valor:", valor);
      }
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
if (document.getElementById('comedor')) {
   const endpoint = document.getElementById('endpoint').value
   const provincia = document.getElementById('provincia')
   const canton = document.getElementById('canton')
   const distrito = document.getElementById('distrito')
   const nonce_canton = document.getElementById('nonce_canton').value
   const action_canton = document.getElementById('action_canton').value
   const nonce_distrito = document.getElementById('nonce_distrito').value
   const action_distrito = document.getElementById('action_distrito').value

   if (document.getElementById('comedor_imagen')) {
      document.getElementById('comedor_imagen').addEventListener('change', function () {
         const imagen = this.files[0]
         if (imagen) {
            const reader = new FileReader()
            document.getElementById('imagennueva').display = 'block'
            reader.addEventListener('load', function () {
               document.getElementById('imagennueva').setAttribute('src', this.result)
            })
            reader.readAsDataURL(imagen)
         } else {
            console.log('por definir')
         }
      })
   }

   provincia.addEventListener('change', () => {
      const provincia_id = provincia.value
      const datos = new FormData()
      datos.append('endpoint', endpoint)
      datos.append('action', action_canton)
      datos.append('nonce', nonce_canton)
      datos.append('provincia_id', provincia_id)
      for (var pair of datos.entries()) {
         var nombre = pair[0];
         var valor = pair[1];
         console.log("Nombre:", nombre, "Valor:", valor);
      }
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
      for (var pair of datos.entries()) {
         var nombre = pair[0];
         var valor = pair[1];
         console.log("Nombre:", nombre, "Valor:", valor);
      }
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

document.addEventListener('click', funcion_beneficiario)
function funcion_beneficiario(e) {
   if (e.target.getAttribute('data-b_id')) {
      e.preventDefault();
      e.stopPropagation();
      const post_id = e.target.dataset.b_id
      const formulario = document.getElementById(post_id)
      const datos = new FormData(formulario)

      async function save_f_u_actualizacion() {
         const request = new Request(
            datos.get('endpoint'), {
            method: 'POST',
            body: datos,
         })
         try {
            const response = await fetch(request)
            const data = await response.json()
            if (data.success) {
               console.log(data.data)
            } else {
               console.log(data)
            }
         } catch (error) {
            console.log('Error: ', error)
         }
      }
      save_f_u_actualizacion()

      document.getElementById(post_id).setAttribute('hidden', '')
   }

}
