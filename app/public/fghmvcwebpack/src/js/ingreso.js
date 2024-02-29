if (document.getElementById('menuAvatar')) {
   const avatar = document.getElementById('menuAvatar')
   const avatarMenu = document.getElementById('menuAvatarMenu')
   const mqs = window.matchMedia("(max-width: 991px)")

   if (window.matchMedia("screen and (max-width: 991px)").matches) {
      avatar.setAttribute('hidden', '')
      avatarMenu.removeAttribute('hidden')
   } else {
      avatar.removeAttribute('hidden')
      avatarMenu.setAttribute('hidden', '')
   }
}

if (document.getElementById('ingreso')) {
   document.addEventListener('click', f_mostrar_clave)
   document.addEventListener('touchstart', f_mostrar_clave)
   function f_mostrar_clave(e) {
      if (e.target.getAttribute('id') == 'ver_clave' || e.target.getAttribute('id') == 'ver_clave_i') {
         if (document.getElementById('clave').getAttribute('type') == 'password') {
            document.getElementById('clave').setAttribute('type', 'text')
            document.getElementById('ver_clave').innerHTML = '<i id="ver_clave_i" class="fa-solid fa-eye" ></i>'
         } else {
            document.getElementById('clave').setAttribute('type', 'password')
            document.getElementById('ver_clave').innerHTML = '<i id="ver_clave_i" class="fa-solid fa-eye-slash" ></i>'
         }
      }
   }
}