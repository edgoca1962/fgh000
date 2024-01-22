//Búsqueda en vivo.
if (document.getElementById('impbuscar')) {
   const buscar = document.getElementById('impbuscar');
   const resultados = document.getElementById('resultados');
   const btn_cerrar = document.getElementById('btn_cerrar');
   const resultados_busqueda = document.getElementById('resultados_busqueda')
   var typingTimer = 0;

   buscar.addEventListener('keyup', f_mostrar_resultados)
   btn_cerrar.addEventListener('touchstart', f_cerrar_resultados)
   btn_cerrar.addEventListener('click', f_cerrar_resultados)

   function f_mostrar_resultados() {
      clearTimeout(typingTimer)
      typingTimer = setTimeout(f_obtener_resultados, 500)
   }
   function f_obtener_resultados() {
      resultados.classList.remove('invisible')
      resultados.style.height = 'auto'
      if (buscar.value != '') {
         const url = resultados_busqueda.dataset.url + buscar.value
         const msg = resultados_busqueda.dataset.msg
         // console.log(url)
         fetch(url)
            .then((res) => res.json())
            .then((data) => {
               // console.log(data);
               if (data.length) {
                  resultados_busqueda.innerHTML = `
                     <ul>
                        ${data.map(item => `<li><a class="text-black" href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                     </ul>`
               } else {
                  resultados_busqueda.innerHTML = msg
               }
            })
            .catch((err) => console.log(err));
      } else {
         resultados.classList.add('invisible')
      }
   }
   function f_cerrar_resultados() {
      // console.log("cerrar")
      buscar.value = ""
      buscar.focus()
      resultados.classList.add('invisible')
   }
}
