(function (Factory) {
	$(document).ready(Factory);
})(function () {

$('.js-story-card').each(function () {
	
	var $el = $(this),
		$confirmModalBtn = $el.find('.js-confirm-modal'),
		storyId = $el.data('storyId');

	$confirmModalBtn.on('confirm',function () {
		$.ajax({
			url : '/api/story/delete',
			type : 'POST',
			dataType : 'json',
			data : {
				id : storyId
			},
			success : function (data,status,xhr) {
				if ( data.success ) {
					console.log('success',data);					
				} else {
					console.warn('Unable to delete item',xhr);
				}
				// post-request tasks
			},
			error : function (xhr) {
				console.warn('Unable to delete item',xhr);
			}
		})
	});

});


});