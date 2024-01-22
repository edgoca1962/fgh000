<h3>Pruebas Funcionales</h3>
<?php

use FGHEGC\Modules\Scp\Peticion\PeticionController;

$peticion = PeticionController::get_instance();

echo '<pre>';
print_r($peticion);
echo '</pre>';
