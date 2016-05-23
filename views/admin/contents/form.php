<form class="row" action="<?= app_path('/api/'.$method) ?>" method="post">

  <?php if (isset($flash)): ?>
    <script>
      document.addEventListener('DOMContentLoaded',function () {
        var $toastContent = $('<span><?= $flash ?></span>');
        Materialize.toast($toastContent, 5000);
      });
    </script>
  <?php endif ?>

  <?php if (isset($error)): ?>
    <div class="card red lighten-1">
      <div class="card-content white-text">
        <?= $error ?>
      </div>
    </div>
  <?php endif ?>
  

  <!-- hidden fields -->
  <input type="number" name="id" style="display: none;" value="<?= isset($location['id']) ? $location['id'] : '' ?>" hidden>

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
          <input id="name" type="text" class="validate" name="name" value="<?= isset($location['name']) ? $location['name'] : '' ?>" required>
          <label for="name">Location Name</label>
        </div>
      </div>

      <div class="row js-mapper">      
        <div class="col s12"><label for="">Coordinates</label></div>
        <div class="col s5">x: <em class="js-mapper-textX"><?= isset($location['x']) ? $location['x'] : 0 ?>&nbsp;</em></div>
        <div class="col s5">y: <em class="js-mapper-textY"><?= isset($location['y']) ? $location['y'] : 0 ?>&nbsp;</em></div>        
        <div class="col s2">
          <div class="btn-floating grey lighten-2 js-mapper-btn">
            <i class="material-icons">edit</i>
          </div>
        </div>
        <div class="col s12">
          <small class="grey-text">X and Y coordinates are percentage values relative to width/height of the map</small>
        </div>

        <div class="hide">
          <input name="x" id="coord_x" type="text" class="validate col s12" value="<?= isset($location['x']) ? $location['x'] : 0 ?>">
          <input name="y" id="coord_y" type="text" class="validate col s12" value="<?= isset($location['y']) ? $location['y'] : 0 ?>">
        </div>

        <?php include APP_PATH . '/views/admin/partials/mapper-modal.php' ?>

      </div>

      <br><br>

      <div class="row">
        <div class="col">
          <button type="submit" class="btn teal">
            <span><?= $method == 'create' ? 'Create' : 'Update' ?></span>
          </button>
        </div>
      </div>

    </div>    
  </div>

</form>


<!-- Photos -->
<?php if ( $method == 'update' ): ?>
  
  <div class="row">
    <hr>
  </div>
  
  <div class="row">
    <h5>Photos</h5> 
    <div class="col 12">
      <div class="row">
        <div class="col m3">
          
        </div>
        
      </div>
    </div>
    

    <br>
    

    <!-- UPLOADS LIST -->
    <div class="row js-uploads">      
    </div>
    <!-- END UPLOADS LIST -->

    <?php include APP_PATH . '/views/admin/partials/upload-item.php' ?>

    <!-- IMAGES LIST -->
    <div class="js-images">
    </div>
    <!-- END IMAGES LIST -->

    <?php include APP_PATH . '/views/admin/partials/image-card.php' ?>
    <?php include APP_PATH . '/views/admin/partials/image-delete-confirm.php' ?>
    <?php include APP_PATH . '/views/admin/partials/story-edit.php' ?>

    <div class="row">
      <div class="col">
        <label for="upload" class="btn left teal">Add Photos</label>
      </div>
    </div>   

    <input id="upload" type="file" name="images[]" data-location="<?= $location['id'] ?>" max="3" multiple hidden class="hide js-upload-input" accept="image/*">

  </div>
<?php endif ?>