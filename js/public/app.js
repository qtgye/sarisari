;(function () {

	var App = window.App ? window.App : {};

	// FACADES
	var _w = window,
		_d = document;

	

	// INITIAL PROPS

	App.isInitialized = false;



	// PRIVATE VARIABLES

	var infoTemplate = (function () {
		
		var template = '<div class="popup-meta">\
				            <h3>Juan Dela Cruz</h3>\
				            <h4>Address</h4>\
				            <p>Profession</p>\
				        </div>\
				        <div class="popup-copy">\
				            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo neque, vel facilis accusamus laboriosam inventore perspiciatis magni, possimus porro consequuntur at adipisci enim, corrupti dignissimos et amet soluta atque. Dignissimos?\
				        </div>';

		return {
			render : function (_data) {
				var newTemplate = template;
				// replace data
				return newTemplate;
			}
		};

	})();



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
		var _item = Popover.getItem(_img);

		_item.events.onShow = function (_modal) {
			onItemShow(_img,_modal);
		}

		_item.events.onActive = function (_item,_modal) {
			onItemShow(_item,_modal);
		}
	}


	function onItemShow (_item,_modal) {
		_modal.DOM.info.innerHTML = infoTemplate.render({});
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