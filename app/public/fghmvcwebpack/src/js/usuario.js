if (document.getElementById('mantener_usuario')) {
   const formulario = document.getElementById("mantener_usuario");
   const first_name = document.getElementById("first_name");
   const last_name = document.getElementById("last_name");
   const user_email = document.getElementById("user_email");
   const user_pass = document.getElementById("user_pass");
   const user_login = document.getElementById("user_login");
   const btn_agregar = document.getElementById("agregar_usuario");
   const btn_modificar = document.getElementById("modificar_usuario");
   const btn_eliminar = document.getElementById("eliminar_usuario");

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
               } else {
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
               }
            } else {
               console.log(data);
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
               console.log(data.data);
               if (data.data == "agregar") {
                  user_pass.removeAttribute("readonly", "");
                  btn_agregar.classList.remove("disabled");
                  btn_modificar.classList.add("disabled");
                  btn_eliminar.classList.add("disabled");
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
                     user_login.value = "";
                     user_pass.setAttribute("readonly", "");
                     btn_agregar.classList.add("disabled");
                     btn_modificar.classList.remove("disabled");
                     btn_eliminar.classList.remove("disabled");
                  }
               }
            } else {
               console.log(data);
            }
         } catch (error) {
            console.log(error);
         }
      }
      validar_login();
   });
}
