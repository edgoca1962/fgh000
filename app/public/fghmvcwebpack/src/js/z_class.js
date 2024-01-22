class EventoClickSca {
   constructor() {
      this.events()
   }
   events() {
      document.addEventListener('click', this.f_click_sca.bind(this))
      document.addEventListener('touchstart', this.f_click_sca.bind(this))
   }
   f_click_sca(e) {
      switch (e.target.getAttribute('id')) {
         case 'vigente_agregar':
            this.f_vigente_agregar()
            break

         case "btn_cerrar_puesto":
         case "btn_cerrar_miembro":
         case "btn_cerrar_usuario":
            location.reload();
            break;

         default:
            break;
      }
      if (e.target.getAttribute('data-post_type')) {
         this.f_botones_sca(e)
      }
      if (e.target.getAttribute("data-vigente")) {
         this.f_vigente_editar();
      }
      switch (document.activeElement.getAttribute("id")) {
         case "agregar_puesto":
         case "modificar_puesto":
         case "eliminar_puesto":
         case "agregar_miembro":
         case "modificar_miembro":
         case "eliminar_miembro":
         case "agregar_usuario":
         case "modificar_usuario":
         case "eliminar_usuario":
            this.f_active_element()
      }
   }
   f_botones_sca(e) {
      const btn_editar = e.target
      const post_type = btn_editar.dataset.post_type
      const url = btn_editar.dataset.url
      const post_id = btn_editar.dataset.post_id
      let f_seguimiento

      switch (post_type) {
         case 'comite':
            async function getComiteData() {
               try {
                  const response = await fetch(url)
                  const data = await response.json()
                  if (response.status === 200) {
                     const titulo = data.title.rendered
                     document.getElementById('titulo_' + post_id).value = titulo
                  } else {
                     console.log(data)
                  }
               } catch (error) {
                  console.log(error)
               }
            }
            getComiteData()
            break

         case 'acuerdo':
            async function getAcuerdoData() {
               try {
                  const response = await fetch(url)
                  const data = await response.json()
                  if (response.status === 200) {
                     document.getElementById('titulo_' + post_id).innerHTML = 'Editar: ' + data.title.rendered
                     document.getElementById('f_compromiso_' + post_id).value = data.meta._f_compromiso
                     document.getElementById('vigente_' + post_id).value = data.meta._vigente
                     if (data.meta._vigente == 1) {
                        document.getElementById('vigente_' + post_id).setAttribute('checked', '')
                        document.getElementById('lbl_vigente_' + post_id).innerHTML = 'Vigente'
                     } else {
                        document.getElementById('vigente_' + post_id).removeAttribute('checked')
                        document.getElementById('lbl_vigente_' + post_id).innerHTML = 'Ejecutado'
                     }
                     document.getElementById('f_seguimiento_' + post_id).value = data.meta._f_seguimiento
                     document.getElementById('asignar_id_' + post_id).value = data.meta._asignar_id
                     const contenido = data.content.rendered.replace(/<\/?[^>]+(>|$)/g, "")
                     document.getElementById('contenido_' + post_id).value = contenido
                     return data.meta._f_seguimiento
                  } else {
                     console.log(data)
                  }
               } catch (error) {
                  console.log(error)
               }
            }
            getAcuerdoData().then((data) => {
               f_seguimiento = data
            })

            document.getElementById('vigente_' + post_id).addEventListener('change', function () {
               if (document.getElementById('vigente_' + post_id).value == 1) {
                  document.getElementById('vigente_' + post_id).value = 0
                  document.getElementById('vigente_' + post_id).removeAttribute('checked', '')
                  document.getElementById('lbl_vigente_' + post_id).innerHTML = 'Ejecutado'
                  document.getElementById('f_seguimiento_' + post_id).removeAttribute('disabled')
                  document.getElementById('f_seguimiento_' + post_id).value = f_seguimiento
                  document.getElementById('f_seguimiento_' + post_id).setAttribute('required', '')
               } else {
                  document.getElementById('vigente_' + post_id).value = 1
                  document.getElementById('vigente_' + post_id).setAttribute('checked', '')
                  document.getElementById('lbl_vigente_' + post_id).innerHTML = 'Vigente'
                  document.getElementById('f_seguimiento_' + post_id).setAttribute('disabled', '')
                  document.getElementById('f_seguimiento_' + post_id).value = ""
                  document.getElementById('f_seguimiento_' + post_id).removeAttribute('required')
               }
               // console.log('editando', document.getElementById('vigente_' + post_id).value)
            })
            break;

         default:
            console.log('Tipo de post no existe.')
            break;
      }
   }
   f_vigente_agregar() {
      const vigente = document.getElementById("vigente_agregar");
      const lbl_vigente = document.getElementById("lbl_vigente_agregar");
      const f_seguimiento = document.getElementById("f_seguimiento_agregar");
      if (vigente.value == 1) {
         vigente.value = 0;
         vigente.removeAttribute("checked");
         lbl_vigente.innerHTML = "Ejecutado";
         f_seguimiento.removeAttribute("disabled");
      } else {
         vigente.value = 1;
         vigente.setAttribute("checked", "");
         lbl_vigente.innerHTML = "Vigente";
         f_seguimiento.setAttribute("disabled", "");
      }
   }
   f_vigente_editar() {
      const vigente = e.target;
      const post_id = vigente.dataset.vigente;
      const lbl_vigente = document.getElementById("lbl_vigente_" + post_id);
      const f_seguimiento = document.getElementById("f_seguimiento_" + post_id);
      if (vigente.value == 1) {
         vigente.value = 0;
         vigente.setAttribute("checked", "");
         lbl_vigente.innerHTML = "Ejecutado";
         f_seguimiento.removeAttribute("disabled");
      } else {
         vigente.value = 1;
         vigente.removeAttribute("checked");
         lbl_vigente.innerHTML = "Vigente";
         f_seguimiento.setAttribute("disabled", "");
      }
   }
   f_active_element() {
      if (
         document.activeElement.getAttribute("id") === "eliminar_puesto" ||
         document.activeElement.getAttribute("id") === "eliminar_miembro" ||
         document.activeElement.getAttribute("id") === "eliminar_usuario"
      ) {
         document.getElementById("boton_puesto").value = "eliminar";
         document.getElementById("puesto_gestion").value = "eliminar";
         document.getElementById("boton_miembro").value = "eliminar";
         document.getElementById("miembro_gestion").value = "eliminar";
         document.getElementById("boton_usuario").value = "eliminar";
         document.getElementById("usuario_gestion").value = "eliminar";

         const elemento = document.getElementById("puesto_id");
         const elementolabel =
            elemento.options[elemento.selectedIndex].innerHTML;
         document.getElementById("miembro_titulo_confirmar").value =
            "Se eliminará el puesto de " + elementolabel;
         document.getElementById("miembro_post_id").value = elemento.value;
      } else {
         document.getElementById("boton_puesto").value =
            document.activeElement.getAttribute("id");
         document.getElementById("boton_miembro").value =
            document.activeElement.getAttribute("id");
         document.getElementById("boton_usuario").value =
            document.activeElement.getAttribute("id");
      }
   }
}
export default EventoClickSca