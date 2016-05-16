<!-- modal -->
<div class="container js-mapper-modal mapper-modal">
  
  <div class="mapper-modal-map js-mapper-modal-map">
    <div class="mapper-image js-mapper-image">
      <img src="<?= app_path('assets/background-map-trans-trimmed.png') ?>" alt="">
    </div>
  </div>

  <div class="mapper-modal-info js-mapper-modal-info">
    <div class="row">

      <div class="col s12">
          
          <h5 class="white-text">Marker Location</h5>
          <div class="white-text">
            <div>x : <span class="js-mapper-markerX">456</span></div>
            <div>y : <span class="js-mapper-markerY">353</span></div>
          </div>

      </div>

      <div class="col s12">
          <p class="js-mapper-cursor-location red-text darken-3"></p>
      </div>

      <div class="col s12">
        <p>
          <div class="btn red darken-5 js-mapper-modal-update">
            <i class="material-icons">check</i>
            UPDATE
          </div>                    
        </p>
        
        <p>
          <div class="btn grey darken-5 js-mapper-modal-close">
            <i class="material-icons">cancel</i>
            CANCEL
          </div>                    
        </p>

      </div>

    </div>
  </div>
     
</div>