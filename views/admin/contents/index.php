<div class="row">
	<table class="col s4">
		<thead>
		  <tr>
		      <th data-field="location">Location</th>
		      <th data-field="actions"></th>
		  </tr>
		</thead>

		<tbody>
		<?php foreach ($locations as $key => $location): ?>

			<tr class="js-item" data-id="<?= $location->id ?>" data-title="<?= $location->title ?>">
				<td><?= $location->title ?></td>
				<td>
					<div class="right">
						<a href="<?= app_path('/admin/location/edit?l='.$location->id) ?>" class="btn btn-floating teal lighten-3"><i class="material-icons">edit</i></a>
						<!-- <a href="#" class="btn btn-floating red lighten-3 delete-modal-trigger"><i class="material-icons">delete</i></a> -->
					</div>
				</td>
			</tr>
			
		<?php endforeach ?>
		</tbody>
	</table>

	<!-- delete modal -->

	<div id="deleteModal" class="modal">
		<div class="modal-content">
		  <p>Are you sure you want to delete <span class="delete-item-title"></span></p>
		</div>
		<div class="modal-footer">
			<a href="#!" class=" modal-action modal-close waves-effect waves-green btn red">No</a>
			<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat modal-confirm">Yes</a>
		</div>
	</div>
</div>