<div class="row">
	<div class="col mb-5">
		<h4>CSV File Import</h4>
		<form id="csvfilefrm" enctype="multipart/form-data">
			<div class="row">
				<div class="col-4" class="d-flex">
					<label for="csvfile"></label>
					<input type="file" accept=".csv" name="csvfile" id="csvfile" class="form-control mb-3">
					<input type="number" name="consecutivo" id="consecutivo" min="1" placeholder="Indicar el ID inicial" class="form-control mb-3" value="1">
					<input id="btn_enviarfile" type="submit" value="Procesar" class="form-control btn btn-warning">
				</div>
			</div>
			<input type="hidden" name="action" value="csvfile">
			<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('csvfile') ?>">
			<input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
			<input type="hidden" name="msgtxt" value="CSV File ha sido procesado correctamente.">
		</form>
	</div>
</div>

<!-- <div class="row">
	<div class="col">
		<?php
		$comites = get_posts(['post_type' => 'comite', 'numberposts' => -1]);
		foreach ($comites as $comite) {
			echo $comite->ID . '  ' . $comite->post_title . '<br>';
		}
		echo '<br><br>';
		$actas = get_posts(['post_type' => 'acta', 'numberposts' => -1, 'orderby' => 'ID', 'order' => 'ASC']);
		foreach ($actas as $acta) {
			echo $acta->ID . '  ' . $acta->post_title . '<br>';
		}
		$acuerdos = get_posts(['post_type' => 'acuerdo', 'numberposts' => -1, 'orderby' => 'ID', 'order' => 'ASC']);
		echo '<br><br>';
		foreach ($acuerdos as $acuerdo) {
			echo $acuerdo->ID . '  ' . $acuerdo->post_title . '<br>';
		}
		?>
	</div>
</div> -->