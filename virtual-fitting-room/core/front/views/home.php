<?php use Virtual_Fitting_Room\Core\DB;
$dresses = (new DB\VFR_Dresses_DB)->get_dresses();
	// (new DB\VFR_Main_DB)->create_table();
	
?>

<style type="text/css">
	.card-img-custom {
		height: 200px !important;
		width: 200px !important;
		margin: 0 auto;
	}

	.new-row {
		margin: 40px 0;
	}
</style>

<form role="form" id="vfrForm" action="<?= get_admin_url(); ?>admin-post.php" method="post">
	<input type="hidden" name="action" value="vfr_insert_form" />
	<?php wp_nonce_field( 'virtual_fitting_room', 'token' ); ?>

	<div class="row">
		<div class="col-md-4">
			<label for="height">Height</label>
		</div>
		<div class="col-md-2" style="border-style: solid;">
			<output name="heightOutput" id="heightOutput">66</output>
			<div class="inches-sub-text">inches</div>
		</div>
		<div class="col-md-6">
			<input type="range" class="custom-range" name="height" id="heightInput" value="66" min="50" max="80" oninput="heightOutput.value = heightInput.value">
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<label for="height">Chest</label>
		</div>
		<div class="col-md-2" style="border-style: solid;">
			<output name="chestOutput" id="chestOutput">37</output>
			<div class="inches-sub-text">inches</div>
		</div>
		<div class="col-md-6">
			<input type="range" class="custom-range" name="chest" id="chestInput" value="37" min="21" max="56" oninput="chestOutput.value = chestInput.value">
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<label for="height">Waist</label>
		</div>
		<div class="col-md-2" style="border-style: solid;">
			<output name="waistOutput" id="waistOutput">30</output>
			<div class="inches-sub-text">inches</div>
		</div>
		<div class="col-md-6">
			<input type="range" class="custom-range" name="waist" id="waistInput" value="30" min="15" max="50" oninput="waistOutput.value = waistInput.value">
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<label for="height">Hips</label>
		</div>
		<div class="col-md-2" style="border-style: solid;">
			<output name="hipsOutputId" id="hipsOutput">40</output>
			<div class="inches-sub-text">inches</div>
		</div>
		<div class="col-md-6">
			<input type="range" class="custom-range" name="hips" id="hipsInput" value="40" min="28" max="58" oninput="hipsOutput.value = hipsInput.value">
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<label for="height">Inseam</label>
		</div>
		<div class="col-md-2" style="border-style: solid;">
			<output name="inseamOutput" id="inseamOutput">30</output>
			<div class="inches-sub-text">inches</div>
		</div>
		<div class="col-md-6">
			<input type="range" class="custom-range" name="inseam" id="inseamInput" value="30" min="20" max="40" oninput="inseamOutput.value = inseamInput.value">
		</div>
	</div>
	<div class="row new-row">
		<div class="col-md-4">
			<label for="height">Name this fit:</label>
		</div>
		<div class="form-group" style="border-style: solid;">
			<input type="text" class="input-field" name="title" placeholder="Type here...">
		</div>
	</div>

	<h2>Select a dress below:</h2>

	<div class="row new-row">
		<?php foreach($dresses as $dress): ?>
		<div class="col">
			<div class="card-deck">
				<div class="card" style="width: 250px; height: auto;">
					<img class="card-img-top card-img-custom" src="<?= wp_upload_dir()['baseurl'] . $dress->dress_location ?>" alt="<?= $dress->name ?>">
					<div class="card-body">
						<h5 class="card-title"><b>Dress:</b> <?= $dress->name ?></h5>
						<p class="card-text"><b>Description:</b> <?= $dress->description ?></p>
					</div>
					<div class="card-footer">
						<div class="form-check">
							<input type="radio" class="form-check-input" name="dress" value="<?= $dress->id ?>">
							<label class="form-check-label">Select</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>

	<div class="row new-rows">
		<input type="submit" class="btn btn-primary">
	</div>
</form>