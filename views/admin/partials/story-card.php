<div class="card story-card js-story-card" data-story-id="<?= $story->id ?>">

	<div class="card-content row">
		<div class="col s3">
			<div class="image-container">
				<div class="aspect-ratio">
				<?php if ( !empty($story->thumbnail) ): ?>					
					<img src="<?= app_path("/uploads/{$story->thumbnail}") ?>" alt="">						
				<?php endif ?>
				</div>
			</div>
		</div>

		<div class="col s1">			
			<?php if ( isset($story->images) && !empty($story->images) ):
				foreach ( $story->images as $key => $image ) :?>
					<div class="row">
						<div class="image-container">
							<div class="aspect-ratio">
								<img src="<?= app_path("/uploads/{$image->file_name}") ?>" alt="">	
							</div>
						</div>
					</div>
			<?php endforeach; endif ?>
			&nbsp;
		</div>

		<div class="col s8">
			<p><small>NAME : </small><?= $story->name ?></p>
		    <p><small>ADDRESS : </small><span><em><?= $story->address ?></em></span></p>
		    <p><small>PROFESSION : </small><span><em><?= $story->profession ?></em></span></p>
		    <p><small>STORY : </small><span><?= $story->story ?></span></p>
		</div>
	</div>

	<!-- story actions -->
	<div class="story-actions">
		<a href='<?= app_path("/admin/story/edit/?s={$story->id}") ?>' class="btn">
			<i class="material-icons">edit</i>
		</a>
		<a href="javascript:;" class="btn grey lighten-2 js-confirm-modal" data-confirm-message="Are you sure you want to delete this story? <br> <strong><?= $story->name ?></strong>" data-confirm-text="Delete">
			<i class="material-icons">delete</i>
		</a>
	</div>

</div>