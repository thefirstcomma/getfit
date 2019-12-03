<?php use Virtual_Fitting_Room\Core\DB;
$saves = (new DB\VFR_Main_DB)->get_records(['user_id' => get_current_user_id()]);
$dresses = (new DB\VFR_Dresses_DB)->get_dresses();
?>

<style>
	h1, h2, h3, h4, h5, h6 {
		margin-top: 0px !important;
	}
</style>

<?php foreach($saves as $save): ?>
<div class="card" style="width: 18rem; display: inline-block;">
	<!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
	<div class="card-body">
		<h5 class="card-title"><?= $save->title ?></h5>
		<p class="card-text"><?= date('F j, Y, g:i a', strtotime($save->date)) ?></p>
		<a href="#" class="btn btn-primary btn-view-save" data-toggle="modal" data-target=".modal" data-title="<?= $save->title ?>" data-height="<?= $save->height ?>" data-chest="<?= $save->chest ?>" data-waist="<?= $save->waist ?>" data-hips="<?= $save->hips ?>" data-inseam="<?= $save->seam ?>" data-size="<?= $save->dress_size ?>" data-dress="<?= $save->dress_id ?>">View</a>
		<button type="button" class="btn btn-danger delete" data-id="<?= $save->id ?>">Delete</button>
	</div>
</div>
<?php endforeach; ?>

<div class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body row">
				<div class="col-md-4">
					<ul class="body-measurements">
						<li class="height"></li>
						<li class="chest"></li>
						<li class="waist"></li>
						<li class="hips"></li>
						<li class="inseam"></li>
						<li class="size"></li>
					</ul>
				</div>
				<div class="col-md-8">
					<canvas id="canvas"></canvas>
				</div>
			</div>
			<div class="modal-footer">
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
