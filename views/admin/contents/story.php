<div class="row">
  <a href="<?= app_path("admin/location/edit/?l={$location_id}") ?>" class="grey-text text-lighten-1 left">< Go Back to Location</a>
  <?php if ( $method == 'update' ): ?>
    <a href="<?= app_path("admin/story/add/?l={$location_id}") ?>" class="btn btn-small right">
      <i class="material-icons">add</i> Add Another Story
    </a>
  <?php endif ?>
</div>

<br>

<form class="row" action="<?= app_path('/api/story/'.$method) ?>" method="post" enctype="multipart/form-data" novalidate>

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
  <input type="number" name="id" style="display: none;" value="<?= isset($story['id']) ? $story['id'] : '' ?>" hidden>
  <input type="number" name="location_id" style="display: none;" value="<?= isset($location_id) ? $location_id : '' ?>" hidden>

  <?php if ( isset($heading) ): ?>
    <div class="row">
      <div class="col s12">
        <h5 class=""><?= $heading ?></h5>
      </div>      
    </div>
  <?php endif ?> 

  <div class="row">

    <div class="col s12">
      <div class="row">
        <div class="clearfix"></div>
        <!-- NAME -->
        <div class="input-field col s12 m6">
          <input id="name" type="text" class="validate" name="name" value="<?= isset($story['name']) ? $story['name'] : '' ?>" >
          <label for="name">Name</label>
        </div>
        <!-- PROFESSION -->
        <div class="input-field col s12 m6">
          <input id="profession" type="text" class="validate" name="profession" value="<?= isset($story['profession']) ? $story['profession'] : '' ?>" >
          <label for="profession">Profession</label>
        </div>
        <!-- ADDRESS -->
        <div class="input-field col s12">
          <input id="address" type="text" class="validate" name="address" value="<?= isset($story['address']) ? $story['address'] : '' ?>" >
          <label for="address">Address</label>
        </div>
        <!-- STORY -->
        <div class="input-field col s12">
          <textarea id="story" name="story" class="materialize-textarea validate" ><?= isset($story['story']) ? $story['story'] : '' ?></textarea>
          <label for="story">Story</label>
        </div>
        <!-- THUMBNAIL -->
        <div class="col s12 m6 l4 js-file-preview file-preview" data-image="<?= !empty($story['thumbnail']) ? app_path('/uploads/'.$story['thumbnail']) : '' ?>">
            <div class="grey-text">Thumbnail</div>
            <div class="card">
              <div class="card-content">
                <div class="image-container">
                  <div class="aspect-ratio">
                    <img src="<?php echo isset($story['thumbnail']) ? app_path('/uploads/'.$story['thumbnail']) : '' ?>" class="file-preview-image">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <label for="thumbnail" class="btn grey lighten-3 grey-text wave-grey">
              <span class="show-if-hasfile">Select Image</span>
              <span class="hide-if-nofile">Replace Image</span>
              <input id="thumbnail" type="file" class="hide" name="file" value="">
            </label>
          
        </div>
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


<!-- Photos-->
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
    <?php include APP_PATH . '/views/admin/partials/image-card.php' ?>

    <!-- IMAGES LIST -->
    <div class="js-images row"></div>
    <!-- END IMAGES LIST -->
    
    <?php include APP_PATH . '/views/admin/partials/image-delete-confirm.php' ?>

    <div class="row">
      <div class="col">
        <label for="upload" class="btn left teal">Add Photos</label>
        <input id="upload" type="file" name="images[]" data-story="<?= $story['id'] ?>" max="3" multiple hidden class="hide js-upload-input" accept="image/*">
      </div>
    </div>   

  </div>

<?php endif ?>