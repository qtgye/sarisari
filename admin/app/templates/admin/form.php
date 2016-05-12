<form class="row">

  <div class="col s6">

    <div class="row">
      <div class="input-field col s12">
        <input placeholder="Location Name" id="name" type="text" class="validate">
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
      <div class="btn">Edit Coordinates</div>
    </div>

    <div class="row">
      <!-- Coordinate map goes here -->
    </div>

  </div>


  <!-- Photos -->
  <div class="col s6">
    <div class="row">
      <div class="col s6"><label for="">Photos</label></div>   
      <div class="col 12">
        <span><img src="http://www.lorempixel.com/80/120" alt=""></span>
        <span><img src="http://www.lorempixel.com/80/120" alt=""></span>
        <span><img src="http://www.lorempixel.com/80/120" alt=""></span>
        <span><img src="http://www.lorempixel.com/80/120" alt=""></span>
        <span><img src="http://www.lorempixel.com/80/120" alt=""></span>
      </div>
      <div class="col s12">
        <div class="btn left">Add Photos</div>
      </div>   
    </div>
  </div>

  

  


  

</form>