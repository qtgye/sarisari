<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width:device-width,initial-scale:1.0">
    <title>Sari-Sari Stories</title>
    <link href="<?php echo app_path('css/public/main.css') ?>" rel="stylesheet">
</head>

<body>
<div id="main">
	<div id="header">
    	<h1>Sari-Sari<br><span>Stories</span></h1>
    	<p>Follow us as we go on the Journey of a Bottle across the Philippines! Get to know our retailers by clicking the Coke bottles and find out how they’ve thrived by working together with Coca-Cola FEMSA.</p>
    </div>
    <div class="map">
        <img src="/assets/background-map-trans-trimmed.png" alt="" class="map-image">
        <div class="map-markers">
            <?php foreach ($locations as $key => $location): ?>
                <div
                    class="marker"
                    id="<?php echo $location->name ?>"
                    style="left: <?= $location->pX ?>; top: <?= $location->pY ?>;"
                >
                    <div class="popover">
                        <h2><?= $location->title ?></h2>
                        <div class="popover-photos">
                            <?php foreach (range(0,2) as $photo): ?>
                                <div class="popover-photo-image">
                                    <div class="popover-photo-ratio">
                                         <img src="http://www.lorempixel.com/120/120/city" alt="">
                                    </div>                                   
                                </div>                                
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>            
        </div>
    </div>
</div>


</body>
</html>
