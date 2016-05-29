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
				            <h3>{name}</h3>\
				            <h4>{address}</h4>\
				            <p>{profession}</p>\
				        </div>\
				        <div class="popup-copy">\
				            {story}\
				        </div>';
		var defaults = {
				name 		: 'Juan Dela Cruz',
				address 	: 'Address',
				profession 	: 'Profession',
				story		: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus atque alias, rerum culpa rem debitis deleniti ab voluptatum natus enim inventore et consequatur aliquam, laudantium, adipisci! Hic at vel ipsa.'
			};

		return {
			render : function (_data) {
				var newTemplate = template;
				// replace data
				var data = $.extend({},defaults,_data);
				for ( key in defaults ) {
					newTemplate = newTemplate.replace('{'+key+'}',data[key]);
				}
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
			onItemShow(_img,_modal);
		}
	}


	function onItemShow (_img,_modal) {
		var $img = $(_img),
			data = $img.data();
		_modal.DOM.info.innerHTML = infoTemplate.render(data);
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