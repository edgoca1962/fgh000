<h3>Pruebas Funcionales</h3>
<?php

$datos = get_userdata(1);
print_r($datos->roles);
$datos->remove_role('subscriber');

$datos = get_userdata(39);
echo 'priscila';
print_r($datos->roles);

$datos = get_userdata(38);
echo 'encargado01';
print_r($datos->roles);
