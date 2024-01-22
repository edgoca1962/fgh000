<?php

use FGHEGC\Modules\Music\MusicController;

$atributos = MusicController::get_instance()->get_atributos('music');
?>

<p><?php the_title() ?></p>