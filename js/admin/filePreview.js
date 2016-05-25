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
	
	var _self = this;

	_self.DOM 			= {};
	_self.DOM.$element 	= $el;
	_self.DOM.$input 	= $el.find('input[type=file]');
	_self.DOM.$img 		= $el.find('img');

	_self.image 		= _self.DOM.$element.data('image');

	// PRIVATE FUNCTIONS

	function onChange () {
		var file 	= this.files[0];
			url 	= null;

		if ( file ) {			
			url = URL.createObjectURL(file);
			_self.image = url;
		} else {
			_self.image = null;
		}

		_self.DOM.$img.attr('src',_self.image);
		_self.DOM.$element.toggleClass('has-file',( _self.image ? true : false ));
	}


	// BINDS

	_self.DOM.$input.on('change',onChange);

	// INIT

	if ( _self.image ) {
		_self.DOM.$img.attr('src',_self.image);
		_self.DOM.$element.addClass('has-file');
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
		_filePreview.DOM.$input.change();
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