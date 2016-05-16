<table>
	<thead>
	  <tr>
	      <th data-field="location">Location</th>
	      <th data-field="photos">Photos</th>
	      <th data-field="actions"></th>
	  </tr>
	</thead>

	<tbody>
	<?php foreach ($locations as $key => $location): ?>

		<tr>
			<td><?= $location->title ?></td>
			<td>Photos Here</td>
			<td>
				<div class="right">
					<a href="<?= app_path('/admin/edit?l='.$location->id) ?>" class="btn btn-floating teal lighten-3"><i class="material-icons">edit</i></a>
					<a href="#" class="btn btn-floating red lighten-3"><i class="material-icons">delete</i></a>
				</div>
			</td>
		</tr>
		
	<?php endforeach ?>
	</tbody>
</table>