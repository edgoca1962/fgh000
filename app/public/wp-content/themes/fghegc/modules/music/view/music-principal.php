<?php

use FGHEGC\Modules\Core\CoreController;

use FGHEGC\Modules\Music\MusicModel;

$atributos = CoreController::get_instance()->get_atributos('music');

?>
<div class="row">
   <div class="col-md-9 mb-5">
      <div class="row mb-3">
         <div class="col col-md-2">
            <h3>Resultados</h3>
         </div>
         <div class="col col-md-10">
            <button id="btnBorrar" class="btn btn-warning">Borrar</button>
         </div>
      </div>
      <div id="results" class="row row-cols-1 row-cols-md-3 g-4 ">
      </div>
   </div>
   <div class="col-md-3">
      <?php get_template_part($atributos['sidebar']);
      ?>
   </div>
</div>
<?php

/*
$musicmodelo = MusicModel::get_instance();

// $file= '/Volumes/Hitachi_03/Music/Aleks Syntek/1993 -Mas Fuerte De Lo Que Pensaba/01. El Camino.mp3'
// $file='/Volumes/Hitachi_03/MusicLlaves/Lexar/1979 -Trabuco Venezolano/23201.mp3'
$datos = $musicmodelo->get_fileinfo_mp3tag($file);
echo '<pre>';
print_r($datos);
echo '<pre>';
*/

/*
$file= '/Volumes/Hitachi_03/MusicLlaves/Lexar/Charly García - 1987 - Parte de la religión/01 - Necesito tu amor.mp3'
$datos = $musicmodelo->get_mp3tag($file);
echo '<pre>';
print_r($datos);
echo '<pre>';
*/