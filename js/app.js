;(function () {

	var App = window.App ? window.App : {};

	// FACADES
	var _w = window,
		_d = document;

	

	// INITIAL PROPS

	App.isInitialized = false;



	// PRIVATE METHODS

	function bindPopoverImages() {
		var images = _d.getElementsByClassName('js-popover');

		[].forEach.call(images,function (_img) {
			function checkPopoverInit () {
				if ( _img.getAttribute('data-popover-item-id') ) {
					updatePopoverImage(_img);
				}
				setTimeout(checkPopoverInit,500);
			}
			checkPopoverInit();
		});
	}


	function updatePopoverImage (_img) {
		var _item = Popover.getItem(_img),
			events = {};

		events.onShow = function () {
			console.log('i am shown!!!',_img);
		}

		_item.events = events;
	}







	// METHODS

	App.init = function () {

		bindPopoverImages();

		App.isInitialized = true;
	}

	
	// INIT
    if ( !App.isInitialized ) {
        _d.addEventListener("DOMContentLoaded", App.init);  
    }

})();