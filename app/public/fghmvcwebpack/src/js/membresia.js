/******************************************************************************
*
* Funciónes para el mantenimiento de Membresía.
*
*****************************************************************************/
if (document.getElementById("nombrePuesto")) {
   document
      .getElementById("nombrePuesto")
      .addEventListener("change", function () {
         const nombre = nombrePuesto.value;
         const evaluar = parseInt(nombre.trim().substring(0, 1));
         const btn_agregar = document.getElementById("agregar_puesto");
         const btn_modificar = document.getElementById("modificar_puesto");
         const btn_eliminar = document.getElementById("eliminar_puesto");
         const post_id = document.getElementById("puesto_post_id");
         if (isNaN(evaluar)) {
            if (nombre != "") {
               const url =
                  document.getElementById("url_puesto").value +
                  nombrePuesto.value;
               async function getPuestoData() {
                  try {
                     const response = await fetch(url);
                     const data = await response.json();
                     if (data[0] != null) {
                        btn_agregar.classList.add("disabled");
                        btn_modificar.classList.remove("disabled");
                        btn_eliminar.classList.remove("disabled");
                        post_id.value = data[0].id;
                     } else {
                        btn_agregar.classList.remove("disabled");
                        btn_modificar.classList.add("disabled");
                        btn_eliminar.classList.add("disabled");
                     }
                  } catch (error) {
                     console.log(error);
                  }
               }
               getPuestoData();
            } else {
               btn_agregar.classList.add("disabled");
               btn_modificar.classList.add("disabled");
               btn_eliminar.classList.add("disabled");
            }
         } else {
            btn_agregar.classList.add("disabled");
            btn_modificar.classList.remove("disabled");
            btn_eliminar.classList.remove("disabled");
            post_id.value = nombre.substring(0, nombre.indexOf("-"));
         }
      });
}
if (document.getElementById("usr_id")) {
   document.getElementById("usr_id").addEventListener("change", function () {
      const usr_id = document.getElementById("usr_id").value;
      const comite_id = document.getElementById("comite_id").value;
      const puesto_id = document.getElementById("puesto_id").value;
      const agregar_miembro = document.getElementById("agregar_miembro");
      const modificar_miembro = document.getElementById("modificar_miembro");
      const eliminar_miembro = document.getElementById("eliminar_miembro");
      if (usr_id != 0 && comite_id != 0 && puesto_id != 0) {
         evaluar_membresia(usr_id, comite_id, puesto_id);
      } else {
         agregar_miembro.classList.add("disabled");
         modificar_miembro.classList.add("disabled");
         eliminar_miembro.classList.add("disabled");
      }
   });
}
if (document.getElementById("comite_id")) {
   document.getElementById("comite_id").addEventListener("change", function () {
      const usr_id = document.getElementById("usr_id").value;
      const comite_id = document.getElementById("comite_id").value;
      const puesto_id = document.getElementById("puesto_id").value;
      const agregar_miembro = document.getElementById("agregar_miembro");
      const modificar_miembro = document.getElementById("modificar_miembro");
      const eliminar_miembro = document.getElementById("eliminar_miembro");
      if (usr_id != 0 && comite_id != 0 && puesto_id != 0) {
         evaluar_membresia(usr_id, comite_id), puesto_id;
      } else {
         agregar_miembro.classList.add("disabled");
         modificar_miembro.classList.add("disabled");
         eliminar_miembro.classList.add("disabled");
      }
   });
}
if (document.getElementById("puesto_id")) {
   document.getElementById("puesto_id").addEventListener("change", function () {
      const usr_id = document.getElementById("usr_id").value;
      const comite_id = document.getElementById("comite_id").value;
      const puesto_id = document.getElementById("puesto_id").value;
      const agregar_miembro = document.getElementById("agregar_miembro");
      const modificar_miembro = document.getElementById("modificar_miembro");
      const eliminar_miembro = document.getElementById("eliminar_miembro");
      if (usr_id != 0 && comite_id != 0 && puesto_id != 0) {
         evaluar_membresia(usr_id, comite_id, puesto_id);
      } else {
         agregar_miembro.classList.add("disabled");
         modificar_miembro.classList.add("disabled");
         eliminar_miembro.classList.add("disabled");
      }
   });
}
function evaluar_membresia(usr_id, comite_id, puesto_id) {
   const url_miembro_comite_puesto =
      document.getElementById("url_miembro").value +
      "?usr_id=" +
      usr_id +
      "&comite_id=" +
      comite_id +
      "&puesto_id=" +
      puesto_id;
   const url_miembro_comite =
      document.getElementById("url_miembro").value +
      "?usr_id=" +
      usr_id +
      "&comite_id=" +
      comite_id;
   const url_comite_puesto =
      document.getElementById("url_miembro").value +
      "?comite_id=" +
      comite_id +
      "&puesto_id=" +
      puesto_id;

   const f_inicio = document.getElementById("f_inicio");
   const f_final = document.getElementById("f_final");
   const miembro_post_id = document.getElementById('miembro_post_id');
   const agregar_miembro = document.getElementById("agregar_miembro");
   const modificar_miembro = document.getElementById("modificar_miembro");
   const eliminar_miembro = document.getElementById("eliminar_miembro");

   async function getMiembroComitePuestoData() {
      try {
         const response = await fetch(url_miembro_comite_puesto);
         const data = await response.json();
         if (data[0] != null) {
            return data[0];
         } else {
            return false;
         }
      } catch (error) {
         console.log(error);
      }
   }

   async function getMiembroComiteData() {
      try {
         const response = await fetch(url_miembro_comite);
         const data = await response.json();
         if (data[0] != null) {
            return data[0];
         } else {
            return false;
         }
      } catch (error) {
         console.log(error);
      }
   }

   async function getComitePuestoData() {
      try {
         const response = await fetch(url_comite_puesto);
         const data = await response.json();
         if (data[0] != null) {
            return data[0];
         } else {
            return false;
         }
      } catch (error) {
         console.log(error);
      }
   }

   getMiembroComitePuestoData().then(function (data) {
      respuesta(data);
   });
   getMiembroComiteData().then(function (data) {
      respuesta(data);
   });
   getComitePuestoData().then(function (data) {
      respuesta(data);
   });

   let respnum = 1;
   let respuestas = [];

   function respuesta(data) {
      respuestas["resp" + respnum] = data;
      respnum++;
      if (respnum > 3) {
         // console.log(respuestas);
         resultados(respuestas);
      }
   }

   function resultados(respuestas) {
      if (respuestas["resp1"] && respuestas["resp2"] && respuestas["resp3"]) {
         agregar_miembro.classList.add("disabled");
         modificar_miembro.classList.remove("disabled");
         eliminar_miembro.classList.remove("disabled");
         f_inicio.value = respuestas["resp1"].meta._f_inicio;
         f_final.value = respuestas["resp1"].meta._f_final;
         miembro_post_id.value = respuestas["resp1"].id
         // console.log("Op1 Modificar Borrar", respuestas["resp1"].id);
      }
      if (!respuestas["resp1"] && respuestas["resp2"] && respuestas["resp3"]) {
         agregar_miembro.classList.add("disabled");
         modificar_miembro.classList.add("disabled");
         eliminar_miembro.classList.add("disabled");
         const finicio = new Date();
         f_inicio.value = finicio.toISOString().substring(0, 10);
         f_final.value = "";
         miembro_post_id.value = respuestas["resp2"].id
         // console.log("Op2 desabilitar botones", respuestas["resp2"].id);
      }
      if (!respuestas["resp1"] && respuestas["resp2"] && !respuestas["resp3"]) {
         agregar_miembro.classList.add("disabled");
         modificar_miembro.classList.remove("disabled");
         eliminar_miembro.classList.remove("disabled");
         const finicio = new Date();
         f_inicio.value = finicio.toISOString().substring(0, 10);
         f_final.value = respuestas["resp2"].meta._f_final;
         miembro_post_id.value = respuestas["resp2"].id
         // console.log("Op3 Modificar Borrar", respuestas["resp2"].id);
      }
      if (!respuestas["resp1"] && !respuestas["resp2"] && respuestas["resp3"]) {
         agregar_miembro.classList.add("disabled");
         modificar_miembro.classList.add("disabled");
         eliminar_miembro.classList.add("disabled");
         const finicio = new Date();
         f_inicio.value = finicio.toISOString().substring(0, 10);
         f_final.value = "";
         // console.log("Op4 desabilitar botones");
      }
      if (
         !respuestas["resp1"] &&
         !respuestas["resp2"] &&
         !respuestas["resp3"]
      ) {
         agregar_miembro.classList.remove("disabled");
         modificar_miembro.classList.add("disabled");
         eliminar_miembro.classList.add("disabled");
         const finicio = new Date();
         f_inicio.value = finicio.toISOString().substring(0, 10);
         f_final.value = "";
         // console.log("Agregar");
      }
   }
}
