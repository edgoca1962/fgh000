import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
let myChart = {}
if (document.getElementById('comites')) {
   for (let index = 0; index < parseInt(document.getElementById('comites').value); index++) {
      var valores = 'valgra_' + index
      var grafico = 'grafico_' + index
      if (document.getElementById(valores)) {
         const dataphp = JSON.parse(document.getElementById(valores).value)
         const ctx = document.getElementById(grafico).getContext('2d')
         creaGrafico(ctx, dataphp)
      }
   }

   document.addEventListener('click', function (e) {
      if (e.target.getAttribute('id')) {
         const grafico = e.target.getAttribute('id')
         const valores = 'valgra_' + grafico.substr(8, 2)
         const comite = document.getElementById('comite_' + grafico).value
         const pagina = document.getElementById('pagina').value
         const datos = JSON.parse(document.getElementById(valores).value)
         const estadoAcuerdos = myChart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true)
         if (estadoAcuerdos.length) {
            const categoria = estadoAcuerdos[0]
            const estado = myChart.data.datasets[categoria.datasetIndex].data[categoria.index].estado
            if (comite != 'todos') {
               location.href = pagina + '/?id=' + comite
            }
         }

      }
   })

   function creaGrafico(ctx, dataphp) {
      myChart = new Chart(ctx, {
         type: 'doughnut',
         data: {
            labels: ['En proceso', 'Vencen este mes', 'Vencidos'],
            datasets: [{
               label: 'Estado de los acuerdos',
               data:
                  [
                     { estado: '1', url: '', total: { total: dataphp.proceso } },
                     { estado: '2', url: '', total: { total: dataphp.porvencer } },
                     { estado: '3', url: '', total: { total: dataphp.vencidos } },
                  ],
               backgroundColor: [
                  'rgba(17, 153, 142, 0.3)',
                  'rgba(255, 224, 0, 0.3)',
                  'rgba(237, 33, 58, 0.3)',
               ],
               borderColor: [
                  'rgba(17, 153, 142, 1)',
                  'rgba(255, 224, 0, 1)',
                  'rgba(237, 33, 58, 1)',
               ],
               borderWidth: 1
            }]
         },
         options: {
            parsing: {
               key: 'total.total'
            }
         }
      });
      // return myChart
   }
}

//#2BAAB1 #AE66DD #409AF7
/*
rgba(43, 170, 177, 1) verde monterrey
rgba(174, 102, 221, 1) morado monterrey
rgba(64, 154, 247, 1) azul monterrey
rgba(17, 153, 142, 1) verde
rgba(255, 224, 0, 1) amarillo
rgba(237, 33, 58, 1) rojo

*/