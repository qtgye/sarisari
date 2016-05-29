(function (Factory) {
	$(document).ready(Factory);
})(function () {
	
/**
 * ---------------------------------------------------------------------------
 * PRIVATE VARIABLES
 * ---------------------------------------------------------------------------
 */




/**
 * ---------------------------------------------------------------------------
 * CLASSES
 * ---------------------------------------------------------------------------
 */

var FilePreview = function ($el) {
	
	var _self = this,
		newImage;

	_self.DOM 			= {};
	_self.DOM.$element 	= $el;
	_self.DOM.$input 	= $el.find('input[type=file]');
	_self.DOM.$img 		= $el.find('.file-preview-image');

	_self.originalImage 		= _self.DOM.$element.data('image');

	// PRIVATE FUNCTIONS

	function onChange () {
		var file 	= this.files[0];
			url 	= null;

		if ( file ) {			
			url = URL.createObjectURL(file);
			newImage = url;
		} else {
			newImage = null;
		}

		_self.DOM.$img.attr('src', (newImage ? newImage : _self.originalImage));
		_self.DOM.$element.toggleClass('has-file',( _self.originalImage || newImage ? true : false));
	}


	// BINDS

	_self.DOM.$input.on('change',onChange);

	// INIT

	if ( _self.originalImage ) {
		_self.DOM.$element.addClass('has-file');
		_self.DOM.$img = _self.DOM.$img;
		_self.DOM.$img
		.attr('src', _self.originalImage);
	}	

}





/**
 * ---------------------------------------------------------------------------
 * PRIVATE FUNCTIONS
 * ---------------------------------------------------------------------------
 */

function bindFilePreview() {
	$('.js-file-preview').each(function () {
		var _filePreview = new FilePreview($(this));
		// _filePreview.DOM.$input.change();
	});
}




/**
 * ---------------------------------------------------------------------------
 * PUBLIC METHODS
 * ---------------------------------------------------------------------------
 */




/**
 * ---------------------------------------------------------------------------
 * INIT
 * ---------------------------------------------------------------------------
 */

bindFilePreview();


});