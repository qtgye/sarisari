<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Sari-Sari Stories</title>
    <link href="<?= app_path('css/public/main.css') ?>" rel="stylesheet">
    <link href="<?= app_path('vendor/custom-popover/css/popover.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arimo">

    <style>
        .marker::after {
            background-image: url("<?= app_path('assets/icon2.png') ?>");
        }
        .popup-arrow.left {
            background-image: url("<?= app_path('assets/arrow-left.png') ?>");
        }
        .popup-arrow.right {
            background-image: url("<?= app_path('assets/arrow-right.png') ?>");
        }
        .popup-close-icon {
            background-image: url("<?= app_path('assets/close.png') ?>");
        }
        .progress-block {
            background-image: url("<?= app_path('assets/main-bg.jpg') ?>");
            
        }
    </style>

</head>

<body>
<div id="main">    

	<div id="header">
    	<h1>Sari-Sari<br><span>Stories</span></h1>
    	<p>Follow us as we go on the Journey of a Bottle across the Philippines! Get to know our retailers by clicking the Coke bottles and find out how they’ve thrived by working together with Coca-Cola FEMSA.</p>
    </div> 

    <div class="map">
        <img src="<?= app_path('assets/background-map-trans-trimmed.png') ?>" alt="" class="map-image">
        <div class="map-markers">
            <?php foreach ($locations as $key => $location): ?>
                <div
                    class="marker <?php echo 'slideDown'.($key ? $key+1 : '')  ?>"
                    id="<?php echo $location->name ?>"
                    style="left: <?= $location->x ?>%; top: <?= $location->y ?>%;"
                >
                    <div class="popover">
                        <h2><?= $location->title ?></h2>
                        <div class="popover-photos">
                            <?php foreach (range(0,2) as $key => $photo): ?>
                                <div class="popover-photo-image">
                                    <div class="popover-photo-ratio">
                                        <?php
                                            // $src = !empty($location->images[$key]) ? app_path('/uploads/'.$location->images[$key]->file_name) : app_path('assets/thumbnail.png');
                                            $src = !empty($location->images[$key]) ? app_path('/assets/'.$location->name.'-'.$location->images[$key].'.jpg') : app_path('assets/thumbnail.png');
                                        ?>
                                        <img class="js-popover" data-popover-group="<?php echo $location->name ?>" src="<?= $src ?>" alt="">                                        
                                    </div>                                   
                                </div>            
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>            
        </div>
    </div>

    <img src="<?= app_path('/assets/femsa.png') ?>" alt="" class="femsa-logo">

</div>

<!-- progress block -->
<div class="progress-block">
    <div class="loader">
        <h3>LOADING...</h3>
        <div class="progress">
            <div class="progress-fill"></div>
        </div>
    </div>
</div>

<script src="<?= app_path('vendor/jquery/dist/jquery.min.js')?>"></script>
<script src="<?= app_path('vendor/jquery.html5loader/src/jquery.html5Loader.min.js') ?>"></script>
<script src="<?= app_path('vendor/custom-popover/js/popover.js') ?>"></script>
<script src="<?= app_path('js/public/app.js') ?>"></script>
<script>
    var json = <?= $preload_json ?>,
        progress = document.querySelector('.progress-fill');
    $.html5Loader({
          filesToLoad:    json, // this could be a JSON or simply a javascript object
          onBeforeLoad:       function () {},
          onComplete:         function () {
            setTimeout(function () {
                document.getElementById('main').className += ' visible animated';
                document.querySelector('.progress-block').className += ' hidden';
            },500);
            setTimeout(function () {
                document.querySelector('.progress-block').style.display = 'none';
            },800);
          },
          onElementLoaded:    function ( obj, elm) { },
          onUpdate:           function ( percentage ) {
            progress.style.width = percentage + '%';
          }
    });
</script>

</body>
</html>
