if (document.getElementById('csvfilefrm')) {
   document.getElementById('csvfile').addEventListener('change', function () {
      const csvfile = document.getElementById('csvfile').value
      const csvfile2 = csvfile.split('\\')
      document.getElementById('lbl_csvfile').innerHTML = csvfile2[2]
   })
}
