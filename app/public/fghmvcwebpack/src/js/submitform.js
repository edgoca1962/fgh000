import Swal from "sweetalert2"
const forms = document.querySelectorAll('.needs-validation')
Array.from(forms).forEach(form => {
   form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
         event.preventDefault()
         event.stopPropagation()
      } else {
         event.preventDefault()
         const dataform = new FormData(form)
         if (dataform.get('gestion') === 'eliminar') {
            Swal.fire({
               icon: 'warning',
               title: dataform.get('titulo_confirmar'),
               showClass: {
                  popup: 'animate__animated animate__fadeInDown'
               },
               hideClass: {
                  popup: 'animate__animated animate__fadeOutUp'
               },
               text: dataform.get('msg_confirmar'),
               showCancelButton: true,
               cancelButtonText: 'Cancelar',
               confirmButtonColor: '#d33',
               cancelButtonColor: '#3085d6',
               confirmButtonText: 'Confirmar'
            }).then((result) => {
               if (result.isConfirmed) {
                  send_data(dataform, event)
               }
            })
         } else {
            if (dataform.get('action') == 'registrarevento') {

            } else {
               send_data(dataform, event)
            }
         }
      }
      form.classList.add('was-validated')
   }, false)
})

async function send_data(dataform, event) {
   event.preventDefault()
   if (dataform.get('action') === 'csvfile') {
      Swal.fire({
         title: 'Procesando Archivo CSV',
         didOpen: () => {
            Swal.showLoading()
         }
      })
   }
   if (dataform.get('vigente') == null) {
      dataform.set('vigente', 0)
   }
   const request = new Request(
      dataform.get('endpoint'), {
      method: 'POST',
      body: dataform,
   })
   try {
      const response = await fetch(request)
      const data = await response.json()
      if (data.success) {
         if (dataform.get('action') === 'ingresar') {
            window.location = dataform.get('redireccion')
         } else {
            if (data.data.inscripciones) {
               inscripciones_csvfile(data.data.inscripciones)
            }
            Swal.fire({
               icon: 'success',
               title: data.data.titulo,
               showConfirmButton: false,
               showClass: {
                  popup: 'animate__animated animate__fadeInDown'
               },
               hideClass: {
                  popup: 'animate__animated animate__fadeOutUp'
               },
               text: data.data.msg,
               timer: 2000
            });
            console.log(data.data.datos)
            setTimeout(() => {
               location.reload()
            }, 2000);
            // console.log(data.data)
         }
      } else {
         console.log('ERROR', data)
         Swal.fire({
            icon: 'error',
            title: data.data.titulo,
            showClass: {
               popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
               popup: 'animate__animated animate__fadeOutUp'
            },
            text: data.data.msg,
            showConfirmButton: false,
            timer: 4000
         });
      }
   } catch (error) {
      console.log('Error: ', error)
   }
}
function inscripciones_csvfile(csvfile) {
   const inscripciones = csvfile
   const filename = `inscripciones_${Date.now()}.csv`
   let linea = 'Fecha,Referencia,Monto\n';
   inscripciones.forEach((row) => {
      linea += row.f_pago + ',' + row.n_referencia + ',' + row.monto + '\n'
   });
   const file = new File([linea], filename, { type: 'text/csv' })
   const a = document.createElement('a')
   a.href = URL.createObjectURL(file)
   a.download
   a.click()
}