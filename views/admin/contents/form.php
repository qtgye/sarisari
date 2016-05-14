<form class="row" action="">

  <?php if ( isset($heading) ): ?>
    <div class="row">
      <div class="col s12">
        <h5 class=""><?= $heading ?></h5>
      </div>      
    </div>
  <?php endif ?> 

  <div class="row">
    <div class="col s6">
      <div class="row">
        <div class="input-field col s12">
          <input id="name" type="text" class="validate">
          <label for="name">Location Name</label>
        </div>
      </div>

      <div class="row">      
        <div class="col s12"><label for="">Coordinates</label></div>
        <div class="col s6"><input disabled value="" id="coord_x" type="text" class="validate col s12"></div>
        <div class="col s6"><input disabled value="" id="coord_y" type="text" class="validate col s12"></div>
        <div class="col s12">
          <small class="grey-text">X and Y coordinates are percentage values relative to width/height of the map</small>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <div class="btn red">Edit Coordinates</div>
        </div>
      </div>
    </div>
  </div>


  <!-- Photos -->
  <?php if ( $page == 'edit' ): ?>
    <div class="row">
      <div class="col s12">
        <h5>Photos</h5>
      </div>   
      <div class="col 12">
        <div class="row">
          <div class="col m3">
            
          </div>
          
        </div>
      </div>
      <div class="col s12">
        <div class="btn left">Add Photos</div>
      </div>   
    </div>
  <?php endif ?>
  

</form>