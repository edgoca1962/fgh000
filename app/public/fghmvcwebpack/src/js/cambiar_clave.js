if (document.getElementById('cambiar_clave')) {
   document.addEventListener('click', f_mostrar)
   document.addEventListener('touchstart', f_mostrar)
   function f_mostrar(e) {
      switch (e.target.getAttribute('id')) {
         case 'ver_clave_actual':
         case 'ver_clave_actual_i':
            if (document.getElementById('clave_actual').getAttribute('type') == 'password') {
               document.getElementById('clave_actual').setAttribute('type', 'text')
               document.getElementById('ver_clave_actual').innerHTML = '<i id="ver_clave_actual_i" class="fa-solid fa-eye" ></i>'
            } else {
               document.getElementById('clave_actual').setAttribute('type', 'password')
               document.getElementById('ver_clave_actual').innerHTML = '<i id="ver_clave_actual_i" class="fa-solid fa-eye-slash" ></i>'
            }
            break;
         case 'ver_nueva_clave':
         case 'ojo1':
            if (document.getElementById('clave_nueva').getAttribute('type') == 'password') {
               document.getElementById('clave_nueva').setAttribute('type', 'text')
               document.getElementById('ver_nueva_clave').innerHTML = '<i id="ojo1" class="fa-solid fa-eye" ></i>'
            } else {
               document.getElementById('clave_nueva').setAttribute('type', 'password')
               document.getElementById('ver_nueva_clave').innerHTML = '<i id="ojo1" class="fa-solid fa-eye-slash" ></i>'
            }
            break

         case 'ver_nueva_clave2':
         case 'ojo2':
            if (document.getElementById('clave_nueva2').getAttribute('type') == 'password') {
               document.getElementById('clave_nueva2').setAttribute('type', 'text')
               document.getElementById('ver_nueva_clave2').innerHTML = '<i id="ojo2" class="fa-solid fa-eye" ></i>'
            } else {
               document.getElementById('clave_nueva2').setAttribute('type', 'password')
               document.getElementById('ver_nueva_clave2').innerHTML = '<i id="ojo2" class="fa-solid fa-eye-slash" ></i>'
            }
            break
         default:
            break;
      }
   }
}