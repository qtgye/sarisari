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
$fileUploadTemplate = $('.js-upload-item'),

$imageDeleteConfirm = $('#imageDeleteConfirm'),

images = {};
 	



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
			story 		: ''
		},
		opts = $.extend({},defaults,opts);

	/*
	Update properties
	 */
	for ( key in defaults ) {
		_self[key] = opts[key];
	}

	/*
	DOM elements
	 */

    _self.guid = guid();

	_self.$element 	    = $imageCardTemplate.clone();
	_self.$img 			= _self.$element.find('.js-image-img')[0].src = _self.src;
	_self.$info 		= _self.$element.find('.js-image-info').text(_self.info);
	_self.$name 		= _self.$info.find('.js-image-name').text(_self.name);
	_self.$address 		= _self.$info.find('.js-image-address').text(_self.address);
	_self.$profession 	= _self.$info.find('.js-image-profession').text(_self.profession);
	_self.$copy 		= _self.$info.find('.js-image-copy').text(_self.story);
	_self.$edit 		= _self.$element.find('.js-image-edit');
	_self.$delete 		= _self.$element.find('.js-image-delete');

    if ( opts.id ) {
        _self.id = opts.id;
    }


    /*
    PRIVATE FUNCTIONS
     */

    function confirmDelete () {
        var $confirmBtn = $imageDeleteConfirm.find('.modal-confirm');
        $imageDeleteConfirm.find('img')[0].src = _self.src;
        $imageDeleteConfirm.openModal({
            ready : function () {
                $confirmBtn.data('guid',_self.guid);
            },
            complete : function () {
                $confirmBtn.data('guid',null);
            }
        });
    }

    function remove() {
        _self.$element.remove();
    }



    /*
    PUBLIC METHODS
     */

    _self.delete = function () {
        _self.$element.addClass('is-loading');

        $.ajax({
            url : '/api/image_delete',
            type : 'POST',
            data : {
                id : _self.id
            },
            dataType : 'json',
            success : function (data) {
                if ( data.success ) {

                    remove();
                    delete images[_self.guid];
                } 

                _self.$element.removeClass('is-loading');                
            },
            error : function (resp) {
                _self.$element.removeClass('is-loading');
            }
       });
    };



    /*
    BINDS
     */

    // _self.$edit.on('click',showEdit);
    _self.$delete.on('click',confirmDelete);


    /*
    ADD TO STORE
     */
    images[_self.guid] = _self;


};


/**
 * FileObject Class
 */

var FileObject = function (file) {
        
    var _file = this,
        request = null;

    _file.dataURL = URL.createObjectURL(file);

    _file.location_id   = $input.data('location');
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

    function onUploadSuccess (data) {
        // uploaded++;
        // requestsCount++;
        _file.isUploadSuccess = true;
        _file.isUploadDone = true;
        // if ( isFunction(uploadDone) ) uploadDone();
        // _file.$element.removeClass('is-uploading').addClass('is-success');
        // console.log('data',data);

        data.data.src = data.data.file_name;
        _image = new Image(data.data);
        _image.$element.appendTo($imagesContainer).removeClass('hide');
    }

    function onUploadError (data) {
        // request = null;
        // requestsCount++;
        _file.isUploadDone = true;

        // if ( isFunction(uploadDone) ) uploadDone();
        _file.$element.addClass('is-error');

        // var errorText   = ( data.data && data.data.message ) ?
        //                   data.data.message :
        //                   'This file was not uploaded due to an error.';

        // $error.text(errorText);            
        console.warn('The file '+_file.name+' was not uploaded due to an error:', data);       
    }

    function onRequestError (xhr) {
        // request = null;
        // requestsCount++;
        _file.isUploadDone = true;

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
    function upload ( ) {
        var formData = new FormData();
        formData.append('file',_file.originalFile);
        formData.append('location_id',_file.location_id);
        request = $.ajax({
            url : '/api/upload',
            type : 'POST',
            method : 'POST',
            data : formData,
            dataType : 'json',
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            success : function (data,status,xhr) {
                request = null;
                if ( !data.success ) {
                    onUploadError(data); return;
                }
                onUploadSuccess(data);
                _file.$element.remove();
            },
            error : function (xhr) {
                onRequestError(xhr);
                _file.$element.remove();
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


function guid() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
  }
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    s4() + '-' + s4() + s4() + s4();
}


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


function bindInput() {
    $input.on('change',onFilesSelect);
    function onFilesSelect() {
        var files = $input[0].files;

        if ( files.length > (3-Object.keys(images).length) ) {
            alert('You can only upload up to 3 images.');
            return;
        }

        [].forEach.call(files,function (file) {
            var _file = new FileObject(file);
        });
    }
}


function bindImageDeleteModal() {
    var $confirmBtn = $imageDeleteConfirm.find('.modal-confirm');
    $confirmBtn.on('click',function () {
       var imageGUID = $confirmBtn.data('guid');

       if ( !imageGUID ) return;

       var _image = images[imageGUID];

       if ( _image && _image.delete ) {
            _image.delete();
       }
       
    });
    
}


function onGetImagesError(resp) {
    console.warn('Error ',resp);
}


function getImages () {
    // console.log('$input',$input);
    var location_id = $input.data('location');
    if ( !location_id ) return;
    $.ajax({
        url : '/api/images',
        type : 'POST',
        data : {
            'location_id' : Number(location_id)
        },
        dataType : 'json',
        success : function (data,xhr) {
            if ( data.success ) {
                // disable photo upload
                if ( data.items.length == 3 ) {
                    $input[0].disabled = true;
                }
                data.items.forEach(function (_item) {
                    var _image = new Image(_item);
                    _image.$element.appendTo($imagesContainer).removeClass('hide');
                });                
            } else {
                onGetImagesError(xhr);
            }
        },
        error : function (xhr) {
            onGetImagesError(xhr);
        }
    });
}


/**
 * INIT
 */

bindInput();
bindImageDeleteModal();
getImages();



});