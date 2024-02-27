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

if (document.getElementById('beneficiario_graficos')) {
   /******************************************************
    * 
    * Gráfico de barras combinado con una línea
    * 
    ******************************************************/
   const barras = document.getElementById('myChart');
   const datGraGenFechas = JSON.parse(document.getElementById('GraGenLabels').value)
   const datGraGenAsistencia = JSON.parse(document.getElementById('GraGenAsistencia').value)
   const datGraGenAusencia = JSON.parse(document.getElementById('GraGenAusencia').value)
   const datGraGenCantidad = JSON.parse(document.getElementById('GraGenCantidad').value)

   new Chart(barras, {
      type: 'bar',
      data: {
         labels: datGraGenFechas,
         datasets: [
            {
               label: 'Asistencia',
               data: datGraGenAsistencia,
               backgroundColor: ['rgba(43, 170, 177, 0.2)'],
               borderColor: ['rgba(43, 170, 177, 1)'],
               borderWidth: 1
            },
            {
               label: 'Ausencias',
               data: datGraGenAusencia,
               backgroundColor: ['rgba(64, 154, 247, 0.2)'],
               borderColor: ['rgba(64, 154, 247, 1)'],
               borderWidth: 1
            },
            {
               label: 'Cantidad Alimentación',
               data: datGraGenCantidad,
               backgroundColor: ['rgba(174, 102, 221, 0.2)'],
               borderColor: ['rgba(174, 102, 221, 1)'],
               tension: 0.4,
               type: 'line',
            },
         ]
      },
      options: {
         scales: {
            x: {
               stacked: true
            },
            y: {
               beginAtZero: true,
               stacked: true,
            }
         }
      }
   });
   /******************************************************
    * 
    * Gráfico de donas
    * 
    ******************************************************/
   var label = 'Comedor Grano de Trigo'
   var data = [300, 50, 100]
   var donas = document.getElementById('donas');
   for (let index = 0; index < document.getElementById('totalComedores').value; index++) {
      var grafico_id = 'grafico_' + index
      var titulo_id = 'titulo_' + index
      var datos = 'datos_' + index
      donas = document.getElementById(grafico_id)
      label = document.getElementById(titulo_id).value
      datos = JSON.parse(document.getElementById(datos).value)
      generaGrafico(donas, label, datos)

   }

   function generaGrafico(donas, label, datos) {
      new Chart(donas, {
         type: 'doughnut',
         data: {
            labels: [
               'Asistencia',
               'Ausencias',
               'Cantidad'
            ],
            datasets: [{
               label: label,
               data: datos,
               backgroundColor: [
                  'rgba(17, 153, 142, 0.4)',
                  'rgba(64, 154, 247, 0.4)',
                  'rgba(174, 102, 221, 0.4)'
               ],
               hoverOffset: 4
            }]
         }
      })
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