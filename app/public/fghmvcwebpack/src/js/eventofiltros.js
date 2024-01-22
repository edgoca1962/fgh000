if (document.getElementById('recurrencia')) {
   document.getElementById('recurrencia').addEventListener('change', function () {
      actualizar()
   })
}
if (document.getElementById('mesEvento')) {
   document.getElementById('mesEvento').addEventListener('change', function () {
      actualizar()
   })

}
if (document.getElementById('annoEvento')) {
   document.getElementById('annoEvento').addEventListener('change', function () {
      actualizar()
   })
}

function actualizar() {
   window.location.href = document.getElementById('url').value + '?cpt=evento&recurrencia=' + document.getElementById('recurrencia').value + '&mes=' + document.getElementById('mesEvento').value + '&anno=' + document.getElementById('annoEvento').value
}
