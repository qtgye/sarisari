$(document).ready(function () {
	
	/**
	 * ITEM DELETE
	 */
	var DeleteModal = {
		$element : $('#deleteModal')
	};

	var currentId = null,
		$currenElement = null;

	DeleteModal.$title = DeleteModal.$element.find('.delete-item-title');
	DeleteModal.$confirm = DeleteModal.$element.find('.modal-confirm');

	$('.js-item').each(function () {

		var $el 	= $(this),
			$delBtn = $el.find('.delete-modal-trigger'),
			title 	= $el.data('title'),
			id 		= $el.data('id');

		$delBtn.on('click',function (e) {

			if ( $el.data('disabled') ) return true;

			$currenElement = $el;

			e.preventDefault();
			currentId = id;
			DeleteModal.$title.text(title);
			DeleteModal.$element.openModal({
			    complete : onModalHide
			});
		});		

	});

	DeleteModal.$confirm.on('click',function () {

		if ( !currentId ) return;

		// Show delete in progress feedback
		$currenElement.data('disabled',true);

		$.ajax({
			url : 'api/delete',
			dataType : 'json',
			method : 'post',
			data : { id : currentId },
			success : function (resp) {
				// Remove item from list
			}
		});

	});

	function onModalHide () {
		currentId = null;
		$currenElement.data('disabled',false);
	}

});