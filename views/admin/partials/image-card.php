<!-- IMAGE CARD TEMPLATE -->
<div class="hide card js-image-item image-card">
  <div class="card-content row">
    <div class="col s3">

      <div class="image-container js-image-image">

        <div class="aspect-ratio">
          <img src="http://www.lorempixel.com/300/300" alt="" class="js-image-img">
        </div>     
        <label for="replace_image" class="btn grey lighten-3 grey-text text-grey-darken-2 js-image-replace image-card-edit" data-id="">
            <input id="replace_image" accept="image/*" type="file" name="file" name="file" hidden class="js-image-replace-input hide">
            Replace Image
        </label>

      </div>

    </div>

    <div class="col s8 image-info js-image-info">

      <p><small>NAME : </small><strong class="js-image-name">Juan Dela Cruz</strong></p>
      <p><small>ADDRESS : </small><span class="js-image-address"><em>Address</em></span></p>
      <p><small>PROFESSION : </small><span class="js-image-profession"><em>Profession</em></span></p>
      <p><small>STORY : </small><span class="js-image-story">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium, non! Id tenetur iste, odio dolor debitis provident impedit architecto autem eligendi nemo. Deleniti voluptates, sunt repudiandae atque fugit tenetur natus!</span></p>
    
      <div class="btn grey lighten-3 grey-text text-grey-darken-2 js-story-edit image-card-edit">
          Edit Story
      </div>
      
    </div>

    <div class="col s1">
      <!-- <div class="btn-floating js-image-edit">
        <i class="material-icons">edit</i>
      </div>
      <br> -->
      <div class="btn-floating grey lighten-2 js-image-delete">
        <i class="material-icons">delete</i>
      </div>
    </div>
  </div>

  <div class="image-card-loader">
    <i class="fa fa-spinner fa-pulse fa-3x"></i>
  </div>

</div>
<!-- END IMAGE CARD TEMPLATE -->