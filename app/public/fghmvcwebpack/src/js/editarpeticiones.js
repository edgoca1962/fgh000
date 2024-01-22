/**
 * ****************************************************************************
 * Rutinas Formulario Seguimiento
 * ****************************************************************************
 */
//Rutina para editar posts
if (document.getElementById('editar_peticiones')) {
   const btn_editar = document.getElementById('btn_editar')
   const btn_cancelar = document.getElementById('btn_cancelar')
   const campos_editables = document.getElementById('campos_editables')
   const btn_seguimiento = document.getElementById('btn_seguimiento')
   const btn_seg = document.getElementById('btn_seg')
   const botones = document.getElementById('botones')
   const navegacion = document.getElementById('navegacion')

   const vigente = document.getElementById('vigente')
   const txt_vigente = document.getElementById('txt_vigente')
   const marca_seguimiento = document.getElementById('marca_seguimiento')
   const txt_marca_seguimiento = document.getElementById('txt_marca_seguimiento')
   const nperiodos = document.getElementById('nperiodos')
   const periodicidad = document.getElementById('periodicidad')
   const f_seguimiento = document.getElementById('f_seguimiento')

   btn_editar.addEventListener('click', f_editar)
   btn_editar.addEventListener('touchstart', f_editar)

   function f_editar() {
      campos_editables.classList.remove('invisible')
      botones.classList.remove('invisible')
      botones.style.height = 'auto'
      campos_editables.style.height = 'auto'
      btn_seguimiento.classList.add('invisible')
      btn_seguimiento.style.height = '0'
      const btns_eli_com = document.querySelectorAll('.btn_eli_com').forEach((elemento) => {
         elemento.classList.remove('invisible')
      })
      navegacion.classList.add('invisible')
      navegacion.style.height = '0'
      // comentarios.classList.add('invisible')
   }

   btn_cancelar.addEventListener('click', f_cancelar)
   btn_cancelar.addEventListener('touchstart', f_cancelar)

   function f_cancelar() {
      campos_editables.classList.add('invisible')
      campos_editables.style.height = '0'
      botones.classList.add('invisible')
      botones.style.height = '0'
      btn_seguimiento.classList.remove('invisible')
      btn_seguimiento.style.height = 'auto'
      const btns_eli_com = document.querySelectorAll('.btn_eli_com').forEach((elemento) => {
         elemento.classList.add('invisible')
      })
      navegacion.classList.remove('invisible')
      navegacion.style.height = 'auto'
      // comentarios.classList.remove('invisible')
   }

   var vigentestatus = true
   var marcasegstatus = false

   vigente.addEventListener('touchstart', f_vigente)
   vigente.addEventListener('click', f_vigente)

   function f_vigente() {
      if (vigente.value == '1') {
         vigente.value = '0'
         txt_vigente.textContent = 'Deshabilitado'
         nperiodos.disabled = true
         periodicidad.disabled = true
         vigentestatus = false
         if (marcasegstatus) {
            marca_seguimiento.click()
         } else {
            f_marca_seguimiento()
         }
      } else {
         vigente.value = '1'
         txt_vigente.textContent = 'Vigente'
         nperiodos.disabled = false
         periodicidad.disabled = false
         marca_seguimiento.removeAttribute('disabled')
         vigentestatus = true
      }
      f_seguimiento.value = new Date().toISOString().slice(0, 10)
   }

   marca_seguimiento.addEventListener('touchstart', f_marca_seguimiento)
   marca_seguimiento.addEventListener('click', f_marca_seguimiento)

   function f_marca_seguimiento() {
      if (vigentestatus) {
         if (marca_seguimiento.value == '1') {

            marca_seguimiento.value = '0'
            marca_seguimiento.removeAttribute('checked')
            txt_marca_seguimiento.textContent = 'Sin seguimiento'
            f_seguimiento.value = new Date().toISOString().slice(0, 10)
            marcasegstatus = false

         } else {

            marca_seguimiento.value = '1'
            marca_seguimiento.setAttribute('checked', '')
            txt_marca_seguimiento.textContent = 'Seguimiento dado'
            var resultado = fecha_proximo_seguimiento(nperiodos.value, periodicidad.value)
            f_seguimiento.value = resultado
            marcasegstatus = true

         }
      } else {
         if (marcasegstatus) {
            marca_seguimiento.setAttribute('disabled', '')
            marca_seguimiento.value = '0'
            marca_seguimiento.removeAttribute('checked')
            txt_marca_seguimiento.textContent = 'Sin seguimiento'
            f_seguimiento.value = new Date().toISOString().slice(0, 10)
         } else {
            marca_seguimiento.setAttribute('disabled', '')
         }
      }
   }

   var nperiodosval = '1'
   nperiodos.addEventListener('change', (e) => {
      nperiodosval = e.target.value
      f_periodicidad(nperiodosval, periodicidad.value)
   })

   periodicidad.addEventListener('change', (e) => {
      opcionperiodo = e.target.value
      f_periodicidad(nperiodos.value, opcionperiodo)
   })

   function f_periodicidad(nper, opcionper) {
      var resultado = fecha_proximo_seguimiento(nper, opcionper)
      f_seguimiento.value = resultado
   }

   function fecha_proximo_seguimiento(cantidad, tipoperiodo) {
      const hoy = new Date()
      switch (tipoperiodo) {
         case '1':
            var periodo = 1000 * 60 * 60 * 24 * parseInt(cantidad, 10)
            break;
         case '2':
            var periodo = 1000 * 60 * 60 * 24 * 7 * parseInt(cantidad, 10)
            break;
         case '3':
            var periodo = 1000 * 60 * 60 * 24 * 7 * 4.33 * parseInt(cantidad, 10)
            break;
         default:
            periodo = 0
            break;
      }
      const nuevafecha = Date.parse(hoy) + periodo
      const fechaseguimiento = new Date(nuevafecha).toISOString().slice(0, 10)
      return fechaseguimiento
   }


   const tagContainer = document.getElementById('tagContainer')
   const btn_agregar = document.getElementById('btn_agregar')
   var etiquetas = []
   const etiquetas_reg = document.querySelectorAll('.txt_etiqueta').forEach((txtEtiqueta) => {
      etiquetas.push(txtEtiqueta.textContent);
   })

   btn_agregar.addEventListener('click', crearPalabraClave)
   btn_agregar.addEventListener('touchstart', crearPalabraClave)
   document.addEventListener('click', eliminaElementos)
   document.addEventListener('touchstart', eliminaElementos)

   function reset() {
      document.querySelectorAll('.tag').forEach(function (etiqueta) {
         etiqueta.parentElement.removeChild(etiqueta)
      })
   }
   function agregarEtiquetas() {
      reset()
      etiquetas.slice().reverse().forEach(function (palabraClave) {
         const input_txt = crear_palabras_claves(palabraClave)
         tagContainer.prepend(input_txt)
      })
   }
   function crearPalabraClave() {
      var txtPalabraClave = ''
      document.querySelectorAll('.txtPalabraClave').forEach((elemento) => {
         if (elemento.value) {
            txtPalabraClave = elemento.value
         }
      })

      if (txtPalabraClave != '') {
         //Rutina para Minúsculas y sin acentos diacríticos--------------------------
         var etiquetasMinusculas = [];
         var etiquetasTmp = [...etiquetas]
         for (var i = 0; i < etiquetasTmp.length; i++) {
            etiquetasTmp[i] = etiquetasTmp[i].toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "");
            etiquetasMinusculas.push(etiquetasTmp[i])
         }

         //Palabra Clave minúscula y sin asentos diacríticos--------------------------
         const palClaMin = txtPalabraClave.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "");

         //Rutina para Mayúscula la primera letra-------------------------------------
         const palCla1 = txtPalabraClave;
         const arr = palCla1.split(" ");
         for (var i = 0; i < arr.length; i++) {
            arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1).toLowerCase();
         }
         const palabraClave = arr.join(" ");

         //Valida y agrega palabra clave---------------------------------------------
         if (!etiquetasMinusculas.includes(palClaMin)) {
            etiquetas.push(palabraClave)
            agregarEtiquetas()
         } else {
            Swal.fire({
               title: 'Error',
               confirmButtonColor: '#3085d6',
               color: '#fff',
               background: 'radial-gradient(50% 50% at top center, rgba(0, 0, 0, .66), #262626),var(--featured-img)',
               text: 'Frase o palabra clave "' + txtPalabraClave + '" ya existe.',
               icon: 'error'
            })
         }
         document.querySelectorAll('.txtPalabraClave').forEach((elemento) => {
            elemento.value = ''
         })
         txtPalabraClave = ''
      }
   }

   function crear_palabras_claves(palabraClave) {
      const div = document.createElement('div')
      div.setAttribute('class', 'tag col')
      const div2 = document.createElement('div')
      div2.setAttribute('class', 'p-1 rounded-1 border border-light bg-secondary d-flex justify-content-between align-items-center')
      const eti = document.createElement('i')
      eti.setAttribute('class', 'fas fa-tag')
      const span = document.createElement('span')
      span.setAttribute('class', 'txt_etiqueta')
      span.innerHTML = palabraClave;
      const btn_cerrar = document.createElement('i')
      btn_cerrar.setAttribute('class', 'fas fa-window-close')
      btn_cerrar.setAttribute('data-item', palabraClave)

      div.appendChild(div2)
      div2.appendChild(eti)
      div2.appendChild(span)
      div2.appendChild(btn_cerrar)
      return div
   }

   function eliminaElementos(e) {

      if (!e.target.getAttribute('id')) {
         if (e.target.tagName === 'I' && e.target.getAttribute('data-item')) {
            const dataEtiqueta = e.target.getAttribute('data-item')
            const index = etiquetas.indexOf(dataEtiqueta)
            etiquetas = [...etiquetas.slice(0, index), ...etiquetas.slice(index + 1)]
            agregarEtiquetas()
         }
         if ((e.target.tagName === "BUTTON") || e.target.getAttribute('data-trash') == 'borrar_comentario') {
            if (e.target.getAttribute('data-trash')) {
               var basurero = e.target.parentElement
               var idcom = basurero.getAttribute('data-idcom')
            } else {
               var idcom = e.target.getAttribute('data-idcom')
            }
            const idli = 'li_id_' + idcom
            const li_com = document.getElementById(idli)
            const endpoint = li_com.getAttribute('data-endpoint')
            const action = li_com.getAttribute('data-action')
            const nonce = li_com.getAttribute('data-nonce')
            const com_datos = new FormData()
            com_datos.append('id_comentario', idcom)
            com_datos.append('action', action)
            com_datos.append('nonce', nonce)
            fetch(endpoint, {
               method: 'POST',
               body: com_datos,
            })
               .then((res) => res.json())
               .then((data) => {
                  if (data.success) {
                     li_com.remove()
                     Swal.fire({
                        icon: 'success',
                        title: 'Comentario Eliminado',
                        showClass: {
                           popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                           popup: 'animate__animated animate__fadeOutUp'
                        },
                        text: 'El comentario fue eliminado correctamente.',
                        showConfirmButton: false,
                        timer: 1000
                     })
                  } else {
                     console.log(data)
                     var msgtxt = 'Ha habido un error en el enlace de comunicación.'
                     Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        showClass: {
                           popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                           popup: 'animate__animated animate__fadeOutUp'
                        },
                        text: msgtxt,
                     });
                  }
               })
               .catch((err) => console.log(err));
         }
      }
   }

   var eliminarpeticion = false
   const btn_eliminar = document.getElementById('btn_eliminar')
   btn_eliminar.addEventListener('click', f_eliminar_peticion)
   btn_eliminar.addEventListener('touchstart', f_eliminar_peticion)
   function f_eliminar_peticion() {
      eliminarpeticion = true
      document.getElementById('action').value = 'eliminar'
   }

   /**
    * ****************************************************************************
    * Registro de información en la base de datos
    * ****************************************************************************
    */

   const formulario = document.getElementById('editar_peticiones');
   btn_seg.addEventListener('click', f_registradatos)
   formulario.addEventListener('submit', f_registradatos)
   function f_registradatos(e) {
      e.preventDefault();
      if (!formulario.checkValidity()) {
         e.preventDefault();
         e.stopPropagation();
      } else {
         f_seguimiento.removeAttribute('disabled')
         const datosformulario = new FormData(document.getElementById('editar_peticiones'));
         datosformulario.append('etiquetas', etiquetas)
         fetch(datosformulario.get('endpoint'), {
            method: 'POST',
            body: datosformulario,
         })
            .then((res) => res.json())
            .then((data) => {
               if (data.success) {
                  if (eliminarpeticion) {
                     var titulo = 'Petición Eliminada'
                     var texto = ' La petición fue eliminada correctamente.'
                  } else {
                     var titulo = 'Petición Actualizada'
                     var texto = ' La petición fue actualizada correctamente.'
                  }
                  Swal.fire({
                     icon: 'success',
                     title: titulo,
                     showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                     },
                     hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                     },
                     text: texto,
                     showConfirmButton: false,
                     timer: 1000
                  }).then((result) => {
                     if (eliminarpeticion) {
                        window.location = datosformulario.get('redireccion')
                     } else {
                        location.reload()
                     }
                  });
                  f_seguimiento.setAttribute('disabled', '')
               } else {
                  console.log(data)
                  var msgtxt = 'Ha habido un error en el enlace de comunicación.'
                  Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     showConfirmButton: false,
                     timer: 2000,
                     showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                     },
                     hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                     },
                     text: msgtxt,
                  });
               }
               formulario.classList.remove('was-validated');
               formulario.reset();
            })
            .catch((err) => console.log(err));
      }
      formulario.classList.add('was-validated');

   };
}
