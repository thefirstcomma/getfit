<?php use Virtual_Fitting_Room\Core\DB;
$dresses = (new DB\VFR_Dresses_DB)->get_dresses();

	//(new DB\VFR_Dresses_DB)->create_table();

?>

<style>
	h1, h2, h3, h4, h5, h6 {
		margin-top: 0px !important;
	}
</style>

<div class="row" style="margin-bottom: 25px;">
	<div class="col-md-12">
		<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#exampleModal">+ Add Dress</button>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card-group">
			<?php foreach($dresses as $dress): ?>
			<div class="card">
				<img class="card-img-top" src="<?= wp_upload_dir()['baseurl'] . $dress->dress_location ?>" alt="<?= $dress->name ?>">
				<div class="card-body">
					<h5 class="card-title"><?= $dress->name ?></h5>
					<p class="card-text"><?= $dress->description ?></p>
				</div>
				<div class="card-footer">
					<!-- <small class="text-muted">Last updated 3 mins ago</small> -->
					<button type="button" class="btn btn-danger delete" data-id="<?= $dress->id ?>">Delete</button>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New Dress</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="dressForm" role="form" action="<?= get_admin_url(); ?>admin-post.php" enctype="multipart/form-data" method="post">
				<input type="hidden" name="action" value="vfr_add_dress" />
				<?php wp_nonce_field( 'virtual_fitting_room', 'token' ); ?>

				<div class="modal-body">
					<div class="form-group">
						<label for="exampleFormControlInput1">Name</label>
						<input type="text" class="form-control" name="dress_name" placeholder="Dress name...">
					</div>
					<div class="form-group">
						<label for="exampleFormControlSelect1">Dress file (.png, .jpg)</label>
						<input type="file" class="form-control" name="dress_file" />
					</div>
					<div class="form-group">
						<label for="dress_description">Description</label>
						<textarea class="form-control" name="dress_description" rows="3"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add dress</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
( function( $ ) {
	$(function() {

		

	});
})( jQuery );
</script>