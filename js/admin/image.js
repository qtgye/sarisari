/**
 * Handles the Image upload, edit and delete
 */


 (function (Factory) {
 	$(document).ready(Factory);
 })(function () {


/**
 * ----------------------------------- 
 * PRIVATE VARIABLES
 * -----------------------------------
 */

var

$input = $('.js-upload-input'),
$imagesContainer = $('.js-images'),
$imageCardTemplate = $('.js-image-item'),
$uploadsContainer = $('.js-uploads'),
$fileUploadTemplate = $('.js-upload-item');
 	



/**
 * ----------------------------------- 
 * CLASSES
 * -----------------------------------
 */


/**
 * Image Class
 */

var Image = function (opts) {
	
	var _self = this,
		defaults = {
			src 		: '',
			name 		: '',
			address		: '',
			profession 	: '',
			copy 		: ''
		},
		opts = $.extend({},defaults,opts);

	/*
	Update properties
	 */
	for ( key in defauts ) {
		_self[key] = opts[key];
	}

	/*
	DOM elements
	 */

	_self.$element 	= $imageCardTemplate.clone();

	_self.$img 			= _self.$element.find('.js-image-img');

	_self.$info 		= _self.$element.find('.js-image-info');
	_self.$name 		= _self.$info.find('.js-image-name');
	_self.$address 		= _self.$info.find('.js-image-address');
	_self.$profession 	= _self.$info.find('.js-image-profession');
	_self.$copy 		= _self.$info.find('.js-image-copy');

	_self.$edit 		= _self.$element.find('.js-image-edit');
	_self.$delete 		= _self.$element.find('.js-image-delete');

	_self.$element.appendTo($imagesContainer).removeClass('hide');


};


/**
 * FileObject Class
 */

var FileObject = function (file) {
        
    var _file = this,
        request = null;

    _file.dataURL = URL.createObjectURL(file);

    _file.name          = file.name;
    _file.size          = file.size;
    _file.mimeType      = file.mimeType;
    _file.type          = getFileType(file);
    _file.originalFile  = file;
    _file.$element      = $fileUploadTemplate.clone();
    _file.isUploadSuccess = false;
    _file.isUploadDone  = false;

    var $image      = _file.$element.find('img'),
        $delete     = _file.$element.find('.js-upload-delete');

    // private functions  

    function onUploadSuccess (data,uploadDone) {
        // uploaded++;
        // requestsCount++;
        // _file.isUploadSuccess = true;
        // _file.isUploadDone = true;
        // if ( isFunction(uploadDone) ) uploadDone();
        // _file.$element.removeClass('is-uploading').addClass('is-success');
        // console.log('data',data);
        console.log('Done uploading file: ',_file.$element);
    }

    function onUploadError (data,uploadDone) {
        // request = null;
        // requestsCount++;
        // _file.isUploadDone = true;

        // if ( isFunction(uploadDone) ) uploadDone();
        _file.$element.addClass('is-error');

        // var errorText   = ( data.data && data.data.message ) ?
        //                   data.data.message :
        //                   'This file was not uploaded due to an error.';

        // $error.text(errorText);            
        console.warn('The file '+_file.name+' was not uploaded due to an error:', data);       
    }

    function onRequestError (xhr,uploadDone) {
        // request = null;
        // requestsCount++;
        // _file.isUploadDone = true;

        // if ( isFunction(uploadDone) ) uploadDone();
        _file.$element.addClass('is-error');

        // $error.text('This file was not uploaded due to an error.');       

        // if ( xhr.statusText == 'abort' ) {
        //     $error.text('This file was aborted.');    
        //     console.warn('The file ' + _file.name + ' was aborted.'); return;
        // }            

        console.warn('The file '+_file.name+' was not uploaded due to an error:', xhr);
    }

    /**
     * Uploads the file object
     * @param  {Function} uploadDone callback function for the request
     * @return void
     */
    function upload ( uploadDone ) {

        var formData = new FormData();
        formData.append('file',_file.originalFile);
        request = $.ajax({
            url : '/api/upload',
            type : 'POST',
            method : 'POST',
            data : formData,
            dataType : 'json',
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            // xhr: function () {
            //     var xhr = new window.XMLHttpRequest();
            //     // Upload progress
            //     xhr.upload.addEventListener("progress", function (evt) {
            //         if (evt.lengthComputable) {
            //             var percentComplete = evt.loaded / evt.total;
            //             $progress.css('width',(percentComplete * 100) + '%');
            //         }
            //     }, false);
            //     return xhr;
            // },
            success : function (data,status,xhr) {
                request = null;
                if ( !data.success ) {
                    onUploadError(data,uploadDone); return;
                }
                onUploadSuccess(data, uploadDone);
            },
            error : function (xhr) {
                onRequestError(xhr,uploadDone);
            }
        });
    }

    function remove () {
        var index = fileObjectsMap[_file.name];
        if ( request && request.abort ) {
            request.abort();
        }
        _file.$element.remove();
    }

    // methods

    // _file.remove = remove;
    _file.upload = upload;

    // DOM update

    var filetype = _file.type;
    if ( filetype == 'image' ) {
        $image.attr('src',_file.dataURL);
    }
    _file.$element.removeClass('hide').appendTo($uploadsContainer);

    // Binds

    $delete.on('click', remove);

    // Init

    _file.upload();

}






/**
 * ----------------------------------- 
 * PRIVATE FUNCTIONS
 * -----------------------------------
 */

/**
 * gets a short string of the file type
 * @param  {object} fileObject File instance
 * @return {string} photo | video | document | other
 */
function getFileType (file) {       
    if ( ! (file instanceof File) ) return '';

    if ( file.name.match(/[.](jpg|jpeg|png|gif|bmp|ico)$/i) ) {
        return 'image';
    }
    else if ( file.name.match(/[.](mp4|mpeg|avi|mov|3gp|wmv|mkv)$/i) ) {
        return 'video';
    }
    else if ( file.name.match(/[.](wav|mp3|wma)$/i) ) {
        return 'audio';
    }
    else if ( file.name.match(/[.](doc|docx|txt)$/i) ) {
        return 'document';
    }
    else if ( file.name.match(/[.](pdf)$/i) ) {
        return 'pdf';
    }
    return 'other';
}


// test
$input.on('change',onFilesSelect);

function onFilesSelect() {
	var files = $input[0].files;

	console.log('files',files);	

	[].forEach.call(files,function (file) {
		var _file = new FileObject(file);
	});
}



});