import Swal from 'sweetalert2'
const hoy = new Date()
if (document.getElementById('evento')) {
   const formulario = document.getElementById('evento')
   const f_inicio = document.getElementById('f_inicio')
   const h_inicio = document.getElementById('h_inicio')
   const f_final = document.getElementById('f_final')
   const h_final = document.getElementById('h_final')
   const dia_completo = document.getElementById('dia_completo')
   const periodicidadevento = document.getElementById('periodicidadevento')
   const diario = document.getElementById('diario')
   const semanal = document.getElementById('semanal')
   const mensual = document.getElementById('mensual')
   const anual = document.getElementById('anual')
   const evento_imagen = document.getElementById('evento_imagen')
   const imagennueva = document.getElementById('imagennueva')

   const dia_evento = parseInt(f_inicio.value.slice(8, 10))

   document.getElementById('numerodiaeventomes').value = dia_evento
   f_inicio.addEventListener('change', function () {
      document.getElementById('numerodiaeventomes').value = f_inicio.value.slice(8, 10)
   })

   document.getElementById('numerodiaeventoanno').value = dia_evento
   f_inicio.addEventListener('change', function () {
      document.getElementById('numerodiaeventoanno').value = f_inicio.value.slice(8, 10)
   })
   const mes_evento = parseInt(f_inicio.value.slice(5, 7))
   if (document.getElementById('mesop1')) {
      document.getElementById('mesop1').value = mes_evento
      f_inicio.addEventListener('change', function () {
         document.getElementById('mesop1').value = parseInt(f_inicio.value.slice(5, 7))
      })
   }
   if (document.getElementById('mesop2')) {
      document.getElementById('mesop2').value = mes_evento
      f_inicio.addEventListener('change', function () {
         document.getElementById('mesop2').value = parseInt(f_inicio.value.slice(5, 7))
      })
   }
   f_final.value = f_inicio.value //hoy.toISOString().slice(0, 10)
   h_inicio.addEventListener('change', function () {
      var ff1 = parseInt(h_inicio.value.slice(0, 2)) + 1
      h_final.value = ff1.toString() + ':00:00'
   })

   evento_imagen.addEventListener('change', function () {
      const imagen = this.files[0]
      if (imagen) {
         const reader = new FileReader()
         imagennueva.display = 'block'
         reader.addEventListener('load', function () {
            imagennueva.setAttribute('src', this.result)
         })
         reader.readAsDataURL(imagen)
      } else {
         console.log('por definir')
      }
   })

   document.getElementById('dia_completo').addEventListener('click', f_diacompleto)
   document.getElementById('dia_completo').addEventListener('touchstart', f_diacompleto)
   function f_diacompleto() {
      if (document.getElementById('dia_completo').dataset.opcion == 'off') {
         h_inicio.setAttribute('disabled', '')
         h_inicio.classList.add('bg-secondary')
         h_inicio.value = '08:00'
         h_final.setAttribute('disabled', '')
         h_final.classList.add('bg-secondary')
         h_final.value = '18:00'
         dia_completo.dataset.opcion = 'on'
         dia_completo.value = 'on'
      } else {
         h_inicio.removeAttribute('disabled')
         h_inicio.classList.remove('bg-secondary')
         if (hoy.getHours() < 10) {
            h_inicio.value = '0' + hoy.getHours().toString() + ':00'
         } else {
            h_inicio.value = hoy.getHours().toString() + ':00'
         }
         h_final.removeAttribute('disabled')
         h_final.classList.remove('bg-secondary')
         var hfinal = hoy.getHours() + 1
         if (hfinal < 10) {
            h_final.value = '0' + hfinal.toString() + ':00'
         } else {
            h_final.value = hfinal.toString() + ':00'
         }
         dia_completo.dataset.opcion = 'off'
         dia_completo.value = 'off'
      }
   }
   document.getElementById('periodicidadevento').addEventListener('change', function () {
      const insertar = document.getElementById('formatos_repeticion')
      const hr = document.createElement("hr")
      hr.setAttribute('id', 'hr')
      const newhr = document.getElementById('hr')
      if (periodicidadevento.value == '1') {
         document.getElementById('f_final').value = hoy.toISOString().slice(0, 10)
         document.getElementById('f_final').setAttribute('required', '')
         document.getElementById('unico').innerHTML = ""
      }
      if (periodicidadevento.value == '2') {
         diario.removeAttribute('hidden')
         document.getElementById('f_final').value = hoy.toISOString().slice(0, 10)
         document.getElementById('f_final').setAttribute('required', '')
      } else {
         diario.setAttribute('hidden', '')
      }
      if (periodicidadevento.value == '3') {
         semanal.removeAttribute('hidden')
         document.getElementById('f_final').value = ""
         document.getElementById('f_final').removeAttribute('required')
      } else {
         semanal.setAttribute('hidden', '')
      }
      if (periodicidadevento.value == '4') {
         mensual.removeAttribute('hidden')
         document.getElementById('f_final').value = ""
         document.getElementById('f_final').removeAttribute('required')
      } else {
         mensual.setAttribute('hidden', '')
      }
      if (periodicidadevento.value == '5') {
         anual.removeAttribute('hidden')
         document.getElementById('f_final').value = ""
         document.getElementById('f_final').removeAttribute('required')
      } else {
         anual.setAttribute('hidden', '')
      }
      if (parseInt(periodicidadevento.value) > 1) {
         if (!document.getElementById('hr')) {
            insertar.after(hr)
         }
      } else {
         newhr.remove()
      }
   })

   document.getElementById('inscripcion').addEventListener('click', f_inscripcion)
   document.getElementById('inscripcion').addEventListener('touchstart', f_inscripcion)
   function f_inscripcion() {
      if (document.getElementById('inscripcion').dataset.inscripcion == 'off') {
         document.getElementById('inscripcion').dataset.inscripcion = 'on'
         document.getElementById('inscripcion').value = 'on'
      } else {
         document.getElementById('inscripcion').dataset.inscripcion = 'off'
         document.getElementById('inscripcion').value = 'off'
      }
   }

   document.getElementById('donativo').addEventListener('click', f_donativo)
   document.getElementById('donativo').addEventListener('touchstart', f_donativo)
   function f_donativo() {
      if (document.getElementById('donativo').dataset.donativo == 'off') {
         document.getElementById('donativo').dataset.donativo = 'on'
         document.getElementById('donativo').value = 'on'
         document.getElementById('montodonativo').removeAttribute('disabled')
      } else {
         document.getElementById('donativo').dataset.donativo = 'off'
         document.getElementById('donativo').value = 'off'
         document.getElementById('montodonativo').setAttribute('disabled', '')
         document.getElementById('montodonativo').value = ''
      }
   }

   document.getElementById('aforo').addEventListener('click', f_aforo)
   document.getElementById('aforo').addEventListener('touchstart', f_aforo)
   function f_aforo() {
      if (document.getElementById('aforo').dataset.aforo == 'off') {
         document.getElementById('aforo').dataset.aforo = 'on'
         document.getElementById('aforo').value = 'on'
         document.getElementById('q_aforo').removeAttribute('disabled')
      } else {
         document.getElementById('aforo').dataset.aforo = 'off'
         document.getElementById('aforo').value = 'off'
         document.getElementById('q_aforo').setAttribute('disabled', '')
         document.getElementById('q_aforo').value = ''
      }
   }

   document.addEventListener('click', function (e) {
      if (e.target.getAttribute('type') == "checkbox" && e.target.getAttribute('value') != null) {
         if (e.target.getAttribute('checked') == null) {
            e.target.setAttribute('checked', '')
         } else {
            e.target.removeAttribute('checked')
         }
      }
   })

   document.getElementById('opcion_mensual').addEventListener('click', f_opcion_mensual)
   document.getElementById('opcion_mensual').addEventListener('touchstart', f_opcion_mensual)
   const opcion_mensual = document.getElementById('opcion_mensual')
   function f_opcion_mensual() {
      if (opcion_mensual.dataset.opcion == 'on') {
         document.querySelectorAll('.op1mensual').forEach((item) => {
            item.setAttribute('disabled', '')
            item.classList.add('bg-secondary')
         })
         document.querySelectorAll('.op2mensual').forEach((item) => {
            item.removeAttribute('disabled')
            item.classList.remove('bg-secondary')
         })
         opcion_mensual.dataset.opcion = 'off'
      } else {
         document.querySelectorAll('.op1mensual').forEach((item) => {
            item.removeAttribute('disabled')
            item.classList.remove('bg-secondary')
         })
         document.querySelectorAll('.op2mensual').forEach((item) => {
            item.setAttribute('disabled', '')
            item.classList.add('bg-secondary')
         })
         opcion_mensual.dataset.opcion = 'on'
      }
      document.getElementById('numerodiaeventomes').setAttribute('disabled', '')
   }

   document.getElementById('opcion_anual').addEventListener('click', f_opcion_anual)
   document.getElementById('opcion_anual').addEventListener('touchstart', f_opcion_anual)
   const opcion_anual = document.getElementById('opcion_anual')
   function f_opcion_anual() {
      if (opcion_anual.dataset.opcion == 'on') {
         document.querySelectorAll('.op1anual').forEach((item) => {
            item.setAttribute('disabled', '')
            item.classList.add('bg-secondary')
         })
         document.querySelectorAll('.op2anual').forEach((item) => {
            item.removeAttribute('disabled')
            item.classList.remove('bg-secondary')
         })
         opcion_anual.dataset.opcion = 'off'
      } else {
         document.querySelectorAll('.op1anual').forEach((item) => {
            item.removeAttribute('disabled')
            item.classList.remove('bg-secondary')
         })
         document.querySelectorAll('.op2anual').forEach((item) => {
            item.setAttribute('disabled', '')
            item.classList.add('bg-secondary')
         })
         opcion_anual.dataset.opcion = 'on'
      }
      document.getElementById('numerodiaeventoanno').setAttribute('disabled', '')
      document.getElementById('mesop1').setAttribute('disabled', '')
      document.getElementById('mesop2').setAttribute('disabled', '')
   }


   formulario.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!formulario.checkValidity()) {
         e.preventDefault();
         e.stopPropagation();
      } else {
         switch (periodicidadevento.value) {
            case '1':
               document.getElementById('diario').remove()
               document.getElementById('semanal').remove()
               document.getElementById('mensual').remove()
               document.getElementById('anual').remove()
               break;
            case '2':
               document.getElementById('unico').remove()
               document.getElementById('semanal').remove()
               document.getElementById('mensual').remove()
               document.getElementById('anual').remove()
               break;
            case '3':
               document.getElementById('unico').remove()
               document.getElementById('diario').remove()
               document.getElementById('mensual').remove()
               document.getElementById('anual').remove()
               break;
            case '4':
               if (opcion_mensual.dataset.opcion == 'on') {
                  document.getElementById('opcionmensualdos').remove()
               } else {
                  document.getElementById('opcionmensualuno').remove()
               }
               document.getElementById('unico').remove()
               document.getElementById('diario').remove()
               document.getElementById('semanal').remove()
               document.getElementById('anual').remove()
               break;
            case '5':
               if (opcion_anual.dataset.opcion == 'on') {
                  document.getElementById('opcionanualdos').remove()
               } else {
                  document.getElementById('opcionanualuno').remove()
               }
               document.getElementById('unico').remove()
               document.getElementById('diario').remove()
               document.getElementById('semanal').remove()
               document.getElementById('mensual').remove()
               break;
            default:
               console.log('default')
               break;
         }
         const dataform = new FormData(formulario);
         const diasemana = []
         document.querySelectorAll('.diasemana').forEach(function (item) {
            if (item.getAttribute('checked') != null) {
               diasemana.push(item.value)
            }
         })
         dataform.append('diasemanaevento', diasemana.toString())

         async function registrar_evento() {
            const request = new Request(
               dataform.get('endpoint'), {
               method: 'POST',
               body: dataform,
            })
            try {
               const response = await fetch(request)
               const data = await response.json()
               if (data.success) {
                  // console.log(data.data)
                  Swal.fire({
                     icon: 'success',
                     title: 'Evento Registrado',
                     showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                     },
                     hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                     },
                     text: 'El evento se ha capturado correctamente.',
                     showConfirmButton: false,
                     timer: 2000
                  }).then((result) => {
                     setTimeout(() => {
                        location.reload()
                     }, 2000);
                  });
               } else {
                  console.log(data)
                  var msgtxt = 'Ha habido un error en el enlace de comunicación.'
                  Swal.fire({
                     icon: 'error',
                     title: 'Error al Enviar',
                     showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                     },
                     hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                     },
                     text: msgtxt,
                     showConfirmButton: false,
                     timer: 2000
                  });
                  formulario.classList.add('was-validated');
               }
            } catch (error) {
               console.log('Error: ', error)
            }
         }
         registrar_evento()
      }
      formulario.classList.add('was-validated');
   });
}

//Boton comprobante de pago
document.addEventListener('click', function (e) {
   if (e.target.getAttribute('data-post_id')) {
      const btn_cp = e.target
      const post_id = btn_cp.dataset.post_id
      btn_cambio_nombre(post_id)
   }
})

function btn_cambio_nombre(post_id) {
   document.getElementById('btn_comprobante_pago_' + post_id).addEventListener('change', function () {
      const comprobante_pago = document.getElementById('btn_comprobante_pago_' + post_id).value
      const comprobante_pago2 = comprobante_pago.split('\\')
      document.getElementById('lbl_comprobante_pago_' + post_id).innerHTML = comprobante_pago2[2]
      document.getElementById('lbl_comprobante_pago_' + post_id).classList.remove('bg-warning')
      document.getElementById('lbl_comprobante_pago_' + post_id).classList.add('bg-secondary')
   })
}

// Agregar Participantes y habilitar boton para inscribirse.
let contador = 0
document.addEventListener('click', function (e) {
   if (e.target.getAttribute('data-btn_post_id')) {
      const btn_insert = e.target
      const post_id = btn_insert.dataset.btn_post_id
      const boleta = btn_insert.dataset.boleta
      const btn_comprobante_pago = document.getElementById('btn_comprobante_pago_' + post_id)
      const nombre = document.getElementById('nombre_' + post_id)
      const apellido = document.getElementById('apellido_' + post_id)
      const list_part = document.getElementById('post_content_' + post_id)
      const content_inscripcion = document.getElementById('content_inscripcion_' + post_id)
      const btn_inscribirse = document.getElementById('btn_inscribirse_' + post_id)
      const q_inscripciones = document.getElementById('q_inscripciones_' + post_id)
      if (nombre.value === '' || apellido.value === '' || (boleta === 'on' && btn_comprobante_pago.value === '')) {
         // console.log(nombre.value, apellido.value, boleta, btn_comprobante_pago.value)
         if ((boleta === 'on' && btn_comprobante_pago.value === '')) {
            Swal.fire({
               icon: 'info',
               title: 'Comprobante de Pago',
               showClass: {
                  popup: 'animate__animated animate__fadeInDown'
               },
               hideClass: {
                  popup: 'animate__animated animate__fadeOutUp'
               },
               text: 'Debe adjuntarse el comprobante de pago.',
               showConfirmButton: false,
               timer: 4000
            });
            btn_inscribirse.setAttribute('disabled', '')
         } else {
            if (list_part.value === '') {
               Swal.fire({
                  icon: 'info',
                  title: 'Sin participantes',
                  showClass: {
                     popup: 'animate__animated animate__fadeInDown'
                  },
                  hideClass: {
                     popup: 'animate__animated animate__fadeOutUp'
                  },
                  text: 'Debe incluir al menos un participante.',
                  showConfirmButton: false,
                  timer: 4000
               });
               btn_inscribirse.setAttribute('disabled', '')
            } else {
               Swal.fire({
                  icon: 'info',
                  title: 'Nombre y Apellido',
                  showClass: {
                     popup: 'animate__animated animate__fadeInDown'
                  },
                  hideClass: {
                     popup: 'animate__animated animate__fadeOutUp'
                  },
                  text: 'Debe incluir el nombre y apellido del participante.',
                  showConfirmButton: false,
                  timer: 4000
               });
               btn_inscribirse.removeAttribute('disabled')
            }
         }
      } else {
         list_part.value += nombre.value + ' ' + apellido.value + '\n'
         content_inscripcion.value += nombre.value + ' ' + apellido.value + '\n'
         contador++
         q_inscripciones.value = contador
         nombre.value = ''
         apellido.value = ''
         btn_inscribirse.removeAttribute('disabled')
         // console.log(contador)
      }
   }
})


// Inscripciones Comprobante de Pago
document.addEventListener('click', function (e) {
   if (e.target.getAttribute('data-cp_post_id')) {
      const post_id = e.target.dataset.cp_post_id
      const img_cp = document.getElementById('cp_' + post_id)
      const modal = document.getElementById('cp_modal_id_' + post_id)
      const src = e.target.getAttribute('src')
      document.getElementById('cp_img_' + post_id).src = src
      const modalscr = new bootstrap.Modal(modal)
      modalscr.show()
   }
})

document.addEventListener('click', function (e) {
   if (e.target.getAttribute('data-btn_cancelar')) {
      location.reload()
   }
})
/************************************************************************************
 * 
 * 
 * Rutinas para editar eventos.
 * 
 * 
 ************************************************************************************/
if (document.getElementById('single_event')) {
   document.getElementById('btn_edit_single').addEventListener('click', function () {
      const formulario = document.getElementById('editar_evento')
      const dataform = new FormData(formulario)
      async function datosEvento() {
         const request = new Request(
            dataform.get('endpoint'), {
            method: 'POST',
            body: dataform,
         })
         try {
            const response = await fetch(request)
            const data = await response.json()
            if (data.success) {
               // console.log(data.data)
               document.getElementById('title').value = data.data.titulo
               document.getElementById('content').value = data.data.contenido
               document.getElementById('imagennueva').setAttribute('src', data.data.imagen)
               document.getElementById('periodicidadevento').value = data.data.tipevento
               document.getElementById('inscripcion').dataset.inscripcion = data.data.inscripcion
               if (document.getElementById('inscripcion').dataset.inscripcion == 'on') {
                  document.getElementById('inscripcion').setAttribute('checked', '')
               }
               document.getElementById('donativo').dataset.donativo = data.data.donativo
               if (document.getElementById('donativo').dataset.donativo == 'on') {
                  document.getElementById('donativo').setAttribute('checked', '')
               }
               document.getElementById('montodonativo').value = data.data.montodonativo
               document.getElementById('aforo').dataset.aforo = data.data.aforo
               if (document.getElementById('aforo').dataset.aforo == 'on') {
                  document.getElementById('aforo').setAttribute('checked', '')
               }
               document.getElementById('q_aforo').value = data.data.q_aforo
               document.getElementById('f_inicio').value = data.data.f_inicio
               document.getElementById('h_inicio').value = data.data.h_inicio
               document.getElementById('h_final').value = data.data.h_final
               document.getElementById('f_final').value = data.data.f_final
               switch (data.data.tipevento) {
                  case '2':
                     document.getElementById('diario').removeAttribute('hidden')
                     document.getElementById('npereventosdiario').value = data.data.npereventos
                     break;

                  case '3':
                     document.getElementById('semanal').removeAttribute('hidden')
                     document.getElementById('npereventossemana').value = data.data.npereventos
                     const diasSemana = document.querySelectorAll('.opsemana')
                     Array.from(diasSemana).forEach((dia) => {
                        Array.from(data.data.diasemanaevento).forEach((diasemana) => {
                           if (dia.value == diasemana) {
                              dia.setAttribute('checked', '')
                           }
                        })
                     })
                     break;

                  case '4':
                     document.getElementById('mensual').removeAttribute('hidden')
                     if (data.data.opciones_esquema == 'on') {
                        document.getElementById('npereventosmes1').value = data.data.npereventos
                        document.getElementById('numerodiaeventomes').value = data.data.numerodiaevento
                     } else {
                        document.getElementById('opcion_mensual').removeAttribute('checked')
                        document.getElementById('npereventosmes1').classList.add('bg-secondary')
                        document.getElementById('npereventosmes1').setAttribute('disabled', '')
                        document.getElementById('numerodiaeventomes').classList.add('bg-secondary')
                        document.getElementById('numerodiaeventomes').setAttribute('disabled', '')
                        document.getElementById('npereventosmes2').classList.remove('bg-secondary')
                        document.getElementById('npereventosmes2').removeAttribute('disabled')
                        document.getElementById('numerodiaordinalevento').classList.remove('bg-secondary')
                        document.getElementById('numerodiaordinalevento').removeAttribute('disabled')

                        const diasSemana = document.querySelectorAll('.op2mensual')
                        Array.from(diasSemana).forEach((dia) => {
                           dia.removeAttribute('disabled')
                           Array.from(data.data.diasemanaevento).forEach((diasemana) => {
                              if (dia.value == diasemana) {
                                 dia.setAttribute('checked', '')
                              }
                           })
                        })
                     }
                     break;

                  case '5':
                     document.getElementById('anual').removeAttribute('hidden')
                     if (data.data.opciones_esquema == 'on') {
                        document.getElementById('npereventosanno1').value = data.data.npereventos
                        document.getElementById('numerodiaeventoanno').value = data.data.numerodiaevento
                        const mesanno = document.getElementById('mesop1')
                        Array.from(mesanno).forEach((mes) => {
                           if (mes.value == data.data.mesevento) {
                              mes.setAttribute('selected', '')
                           }
                        })

                     } else {
                        document.getElementById('opcion_anual').removeAttribute('checked')
                        document.getElementById('npereventosanno1').classList.add('bg-secondary')
                        document.getElementById('npereventosanno1').setAttribute('disabled', '')
                        document.getElementById('numerodiaeventoanno').classList.add('bg-secondary')
                        document.getElementById('numerodiaeventoanno').setAttribute('disabled', '')
                        document.getElementById('mesop1').classList.add('bg-secondary')
                        document.getElementById('mesop1').setAttribute('disabled', '')
                        document.getElementById('npereventosanno2').classList.remove('bg-secondary')
                        document.getElementById('npereventosanno2').removeAttribute('disabled')
                        document.getElementById('numerodiaordinaleventoanno').classList.remove('bg-secondary')
                        document.getElementById('numerodiaordinaleventoanno').removeAttribute('disabled')
                        const ordinalanno = document.getElementById('numerodiaordinaleventoanno')
                        Array.from(ordinalanno).forEach((ordinal) => {
                           if (ordinal.value == data.data.numerodiaordinalevento) {
                              ordinal.setAttribute('selected', '')
                           }
                        })
                        const diasSemana = document.querySelectorAll('.op2anual')
                        Array.from(diasSemana).forEach((dia) => {
                           dia.removeAttribute('disabled')
                           Array.from(data.data.diasemanaevento).forEach((diasemana) => {
                              if (dia.value == diasemana) {
                                 dia.setAttribute('checked', '')
                              }
                           })
                        })
                        document.getElementById('mesop2anno').removeAttribute('disabled')
                        document.getElementById('mesop2anno').classList.remove('bg-secondary')
                        const mesanno = document.getElementById('mesop2anno')
                        Array.from(mesanno).forEach((mes) => {
                           if (mes.value == data.data.mesevento) {
                              mes.setAttribute('selected', '')
                           }
                        })
                     }
                     break;

                  default:
                     break;
               }
            } else {
               console.log(data.data)
            }
         } catch (error) {
            console.log('Error: ', error)
         }
      }
      datosEvento()
      document.getElementById('single_event').setAttribute('hidden', '')
      document.getElementById('edit_event').removeAttribute('hidden')

   })
   document.getElementById('btncancelaredicionevento').addEventListener('click', function () {
      location.reload()
   })
}
