if (document.getElementById('comedorescsv')) {
   document.getElementById('csvfile').addEventListener('change', function () {
      const csvfile = document.getElementById('csvfile').value
      const csvfile2 = csvfile.split('\\')
      console.log(csvfile2[2])
      document.getElementById('lbl_csvfile').innerHTML = csvfile2[2]
   })

}