(function (Mapper) {
	$(document).ready(Mapper.init);
})(

(function ($) {
	
var Mapper = {};

/**
 * PRIVATE VARS
 * ------------------------------------------------
 */

var

scrollBarWidth = 0,

$container,
$marker = $('<div class="js-mapper-marker mapper-marker"></div>'),
$oldMarker, $newMarker;




/**
 * PUBLIC PROPERTIES
 * ------------------------------------------------
 */

Mapper.data = {
	x : 0,
	y : 0
};






/**
 * PRIVATE FUNCTIONS
 * ------------------------------------------------
 */

function bindMapper () {

	Mapper.DOM = {
		$container 	 : $container,
		$x			 : $container.find('[name=x]'),
		$y 			 : $container.find('[name=y]'),
		$textX 		 : $container.find('.js-mapper-textX'),
		$textY 		 : $container.find('.js-mapper-textY'),
		$btn 		 : $container.find('.js-mapper-btn'),
		$modal 		 : $container.find('.js-mapper-modal')		
	};

	Mapper.DOM.$modalUpdate 	= Mapper.DOM.$modal.find('.js-mapper-modal-update');
	Mapper.DOM.$modalClose		= Mapper.DOM.$modal.find('.js-mapper-modal-close');
	Mapper.DOM.$modalMap		= Mapper.DOM.$modal.find('.js-mapper-image');
	Mapper.DOM.$modalMarkerX	= Mapper.DOM.$modal.find('.js-mapper-markerX');
	Mapper.DOM.$modalMarkerY	= Mapper.DOM.$modal.find('.js-mapper-markerY');
	Mapper.DOM.$modalCursorLoc 	= Mapper.DOM.$modal.find('.js-mapper-cursor-location');

	// Events
	Mapper.DOM.$btn.on('click',showModal);
	Mapper.DOM.$modalClose.on('click',hideModal);
	Mapper.DOM.$modalMap
		.on('click',plotNewCoordinates)
		.on('mouseenter',trackCursor)
		.on('mouseleave',function () {
			$(this).off('mousemove');
		});
	Mapper.DOM.$modalUpdate.on('click',function () {
		updateFormCoordinates();
		hideModal();
	});
	Mapper.DOM.$x.on('change',function () {
		Mapper.DOM.$textX.text(this.value);
	});
	Mapper.DOM.$y.on('change',function () {
		Mapper.DOM.$textY.text(this.value);
	});
}


function showModal () {	
	getFormCoordinates();
	plotCoordinates();

	$('body').css({
		'padding-right' : scrollBarWidth,
		'overflow' : 'hidden'
	});
	Mapper.DOM.$modal.fadeIn();
}


// Hide modal and reset data
function hideModal () {
	Mapper.DOM.$modal.fadeOut(300,function () {

		Mapper.data = {
			x : 0,
			y : 0
		}

		if ( $oldMarker ) {
			$oldMarker.remove();
			$oldMarker = null;
		}

		if ( $newMarker ) {
			$newMarker.remove();
			$newMarker = null;
		}

		Mapper.DOM.$modalCursorLoc.html('');

		$('body').css({
			'padding-right' : '',
			'overflow' : 'hidden'
		});

	});
}


function getFormCoordinates () {
	Mapper.data = {
		x : Mapper.DOM.$x.val(),
		y : Mapper.DOM.$y.val()
	}
};


function plotCoordinates () {
	if ( !Mapper.data.x || !Mapper.data.y ) return;
	$oldMarker = $marker.clone().addClass('mapper-marker-current');

	Mapper.DOM.$modalMarkerX.text(Mapper.data.x);
	Mapper.DOM.$modalMarkerY.text(Mapper.data.y);

	$oldMarker
	.css({ top: Mapper.data.y+'%', left: Mapper.data.x+'%' })
	.appendTo(Mapper.DOM.$modalMap);
};


function plotNewCoordinates (e) {

	if ( !$newMarker ) {
		$newMarker = $marker.clone();
		$newMarker.appendTo(Mapper.DOM.$modalMap);
	}

	// compute coordinates
	var clickPosition = getCursorCoordinates(e);

	Mapper.data = {
		x : clickPosition.x,
		y : clickPosition.y
	};

	Mapper.DOM.$modalMarkerX.text(Mapper.data.x);
	Mapper.DOM.$modalMarkerY.text(Mapper.data.y);

	$newMarker.css({
		left : Mapper.data.x+'%',
		top : Mapper.data.y+'%'
	});
	
};


function trackCursor(e) {
	Mapper.DOM.$modalMap
	.off('mousemove')
	.on('mousemove',function (e) {
		var cursorPosition = getCursorCoordinates(e);
		Mapper.DOM.$modalCursorLoc.html(cursorPosition.x+'<br />'+cursorPosition.y);
	});
}


function getCursorCoordinates (e) {
	// compute coordinates
	var position = Mapper.DOM.$modalMap.position(),
		mapDimensions = {
			width : Mapper.DOM.$modalMap.width(),
			height : Mapper.DOM.$modalMap.height()
		};

	return {
		x : 100 * ((e.pageX - position.left) / mapDimensions.width),
		y : 100 * ((e.pageY - position.top) / mapDimensions.height)
	}
}


function updateFormCoordinates () {
	Mapper.DOM.$x.val(Mapper.data.x).trigger('change');
	Mapper.DOM.$y.val(Mapper.data.y).trigger('change');
}


function getScrollBarWidth () {
    var outer = $('<div>')[0],
        inner = $('<div>')[0];

    $('body')[0].appendChild(outer);
    outer.appendChild(inner);

    outer.style.overflow = 'scroll';
    outer.style.height = '200px';
    inner.style.height = '300px';

    var outerWidth = outer.getBoundingClientRect().width,
        innerWidth = inner.getBoundingClientRect().width;

    scrollBarWidth = Math.abs(outerWidth-innerWidth);
    outer.parentNode.removeChild(outer);
}


/**
 * PUBLIC METHODS
 * ------------------------------------------------
 */

 




/**
 * INIT
 * ------------------------------------------------
 */

 Mapper.init = function () {

 	$container = $('.js-mapper');

 	if ( !$container.length ) return;

 	getScrollBarWidth();
 	bindMapper();
 }

return Mapper;

})(jQuery)

);