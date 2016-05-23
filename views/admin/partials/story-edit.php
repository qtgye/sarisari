<!-- Modal Structure -->
<div id="storyEdit" class="modal js-story-edit">
	<div class="modal-content">
		<form action="#!" method="post" class="row">
			<div class="input-field col s6">
	          <input name="name" placeholder="Name" id="name" type="text" class="validate">
	          <label for="name">Name</label>
	        </div>
	        <div class="input-field col s6">
	          <input name="profession" placeholder="Profession" id="profession" type="text" class="validate">
	          <label for="profession">Profession</label>
	        </div>
	        <div class="input-field col s12">
	          <input name="address" placeholder="Address" id="address" type="text" class="validate">
	          <label for="address">Address</label>
	        </div>	        
	        <div class="input-field col s12">
	          <textarea name="story" id="story" placeholder="Story" class="materialize-textarea"></textarea>
	          <label for="story">Story</label>
	        </div>
		</form>
	</div>
	<div class="modal-footer">		
		<div class=" modal-action modal-close waves-effect waves-green btn-flat">Cancel</div>
		<div class="modal-confirm modal-close waves-effect waves-green btn teal">Update</div>
	</div>
</div>