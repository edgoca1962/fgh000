
if (document.getElementById('evento_usuario')) {
   const formulario = document.getElementById("evento_usuario");
   const first_name = document.getElementById("first_name");
   const last_name = document.getElementById("last_name");
   const user_email = document.getElementById("user_email");
   const user_pass = document.getElementById("user_pass");
   const user_login = document.getElementById("user_login");
   const btn_agregar = document.getElementById("agregar_usuario_evento");
   const btn_modificar = document.getElementById("modificar_usuario_evento");
   const btn_eliminar = document.getElementById("eliminar_usuario_evento");
   const usuario_id = document.getElementById('usuario_id');
   var email = false

   user_email.addEventListener("change", function () {
      const datosformulario = new FormData(formulario);
      datosformulario.append("boton", "validar_usr");

      async function validar_usr() {
         const request = new Request(datosformulario.get("endpoint"), {
            method: "POST",
            body: datosformulario,
         });
         try {
            const response = await fetch(request);
            const data = await response.json();
            if (data.success) {
               if (data.data == "agregar") {
                  first_name.value = "";
                  last_name.value = "";
                  user_login.value = "";
                  user_pass.setAttribute("type", "text");
                  user_pass.removeAttribute("readonly", "");
                  user_pass.classList.remove("bg-secondary");
                  user_pass.classList.remove("disabled");
                  user_pass.value = "";
                  btn_agregar.classList.remove("disabled");
                  btn_modificar.classList.add("disabled");
                  btn_eliminar.classList.add("disabled");
                  first_name.focus();
                  email = false
               } else {
                  usuario_id.value = data.data.ID;
                  first_name.value = data.data.first_name;
                  last_name.value = data.data.last_name;
                  user_login.value = data.data.user_login;
                  user_pass.setAttribute("type", "password");
                  user_pass.setAttribute("readonly", "");
                  user_pass.classList.add("bg-secondary");
                  user_pass.classList.add("disabled");
                  user_pass.value = data.data.user_pass;
                  btn_agregar.classList.add("disabled");
                  btn_modificar.classList.remove("disabled");
                  btn_eliminar.classList.remove("disabled");
                  email = true
               }
            } else {
               // console.log(data);
            }
         } catch (error) {
            console.log(error);
         }
      }
      validar_usr();
   });

   user_login.addEventListener("change", function () {
      const datosformulario = new FormData(formulario);
      datosformulario.append("boton", "validar_login");

      async function validar_login() {
         const request = new Request(datosformulario.get("endpoint"), {
            method: "POST",
            body: datosformulario,
         });
         try {
            const response = await fetch(request);
            const data = await response.json();
            if (data.success) {
               if (data.data == "agregar") {
                  if (email) {
                     user_pass.setAttribute("readonly", "");
                     btn_agregar.classList.add("disabled");
                     btn_modificar.classList.remove("disabled");
                     btn_eliminar.classList.remove("disabled");
                  } else {
                     user_pass.removeAttribute("readonly", "");
                     btn_agregar.classList.remove("disabled");
                     btn_modificar.classList.add("disabled");
                     btn_eliminar.classList.add("disabled");
                  }
               } else {
                  if (user_email.value != data.data.user_email) {
                     Swal.fire({
                        icon: "error",
                        title: "Usuario de Ingreso Existe",
                        showClass: {
                           popup: "animate__animated animate__fadeInDown",
                        },
                        hideClass: {
                           popup: "animate__animated animate__fadeOutUp",
                        },
                        text:
                           "El usuario de ingreso " +
                           data.data.user_login +
                           " ya existe registrado.",
                        showConfirmButton: false,
                        timer: 3000,
                     });
                     if (email) {
                        user_pass.setAttribute("readonly", "");
                        btn_agregar.classList.add("disabled");
                        btn_modificar.classList.remove("disabled");
                        btn_eliminar.classList.remove("disabled");
                        user_login.value = "";
                     } else {
                        user_pass.setAttribute("readonly", "");
                        btn_agregar.classList.remove("disabled");
                        btn_modificar.classList.add("disabled");
                        btn_eliminar.classList.add("disabled");
                        user_login.value = "";
                     }
                  }
               }
            } else {
               // console.log(data);
            }
         } catch (error) {
            console.log(error);
         }
      }
      validar_login();
   });

   document.addEventListener('click', f_click)
   function f_click(e) {
      switch (e.target.getAttribute('id')) {
         case 'agregar_usuario_evento':
            document.getElementById('boton_usuario').value = 'agregar_usuario'
            break
         case 'modificar_usuario_evento':
            document.getElementById('boton_usuario').value = 'modificar_usuario'
            break
         case 'eliminar_usuario_evento':
            document.getElementById('boton_usuario').value = 'eliminar_usuario'
            break
      }
   }
}
