import Swal from 'sweetalert2';
//Lógica para likes o similares.
if (document.getElementById('oracion')) {
   const oracion = document.getElementById('oracion')
   var accion = ''

   oracion.addEventListener('click', f_oracion)
   oracion.addEventListener('touchstart', f_oracion)

   function f_oracion() {
      console.log(oracion.dataset.oracion)
      if (oracion.dataset.oracion == 'no') {
         oracion.dataset.oracion = 'si'
         accion = 'agregar'
      } else {
         oracion.dataset.oracion = 'no'
         accion = 'borrar'
      }
      const data = new FormData()
      data.append('action', 'conteo_oracion')
      data.append('accion', accion)
      data.append('post_id', oracion.dataset.post_id)
      data.append('oracion_id', oracion.dataset.oracion_id)
      console.log(oracion.dataset.post_id)

      fetch(oracion.dataset.url, {
         method: 'POST',
         body: data,
      })
         .then((res) => res.json())
         .then((data) => {
            if (data.success) {
               location.reload()
            } else {
               Swal.fire({
                  icon: 'error',
                  title: 'Error en datos',
                  showClass: {
                     popup: 'animate__animated animate__fadeInDown'
                  },
                  hideClass: {
                     popup: 'animate__animated animate__fadeOutUp'
                  },
                  text: 'Error en los datos enviados.',
                  timer: 2000,
               });
            }
         })
         .catch((err) => console.log(err));
   }
}
