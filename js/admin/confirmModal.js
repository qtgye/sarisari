(function (Factory) {
	$(document).ready(Factory);
})(function () {


/**
 * --------------------------------------------------------------------------------
 * MODULE DECLARATION
 * --------------------------------------------------------------------------------
 */

var ConfirmModal = window.ConfirmModal = {

		// the modal DOM element
		$element : $('<div class="modal">' +
						'<div class="modal-content">' +
							'<p class="modal-confirm-message">Are you sure you want to delete this item?</p>' +
						'</div>' +
						'<div class="modal-footer">' +		
							'<button class="modal-confirm modal-close modal-close waves-effect waves-green btn grey lighten-1">Delete</button>' +
							'&nbsp;&nbsp;' +
							'<button class="modal-decline modal-close waves-effect waves-green btn teal">Cancel</button>' +							
						'</div>' +
					'</div>'),

		// Modal toggle buttons list
		toggles : [],

		// key:index mapping for ConfirmModal.toggles
		togglesMap : [],

		// The toggle object which recently toggles the modal
		activeToggle : null

	};

ConfirmModal.$confirmMessage = ConfirmModal.$element.find('.modal-confirm-message');
ConfirmModal.$confirmBtn 	 = ConfirmModal.$element.find('.modal-confirm');
ConfirmModal.$declineBtn 	 = ConfirmModal.$element.find('.modal-decline');





/**
 * --------------------------------------------------------------------------------
 * PRIVATE VARIABLES
 * --------------------------------------------------------------------------------
 */





/**
 * --------------------------------------------------------------------------------
 * PRIVATE FUNCTIONS
 * --------------------------------------------------------------------------------
 */


function generate_id() {
	return Math.floor(Math.random(Date.now()) * 1000000000000);
}


function bindModal() {

	ConfirmModal.$element.appendTo($('body'));

	// On Confirm
	ConfirmModal.$confirmBtn.on('click',function () {
		if (ConfirmModal.activeToggle) {
			ConfirmModal.activeToggle.$element.trigger('confirm');
		}
		ConfirmModal.$element.trigger('confirm');
		ConfirmModal.activeToggle = null;
	});

	// On Decline
	ConfirmModal.$declineBtn.on('click',function () {
		if (ConfirmModal.activeToggle) {
			ConfirmModal.activeToggle.$element.trigger('decline');
		}
		ConfirmModal.$element.trigger('decline');
		ConfirmModal.activeToggle = null;
	});

}

function bindModalToggle() {
	$('.js-confirm-modal').each(function () {
		
		var _toggle,
			$toggle = $(this),
			id = generate_id(),
			message = $toggle.data('confirmMessage'),
			confirmText = $toggle.data('confirmText'),
			declineText = $toggle.data('declineText');

		_toggle = {
			$element : $toggle,
			id : id,
			message : message,
			confirmText : confirmText,
			declineText : declineText
		};

		$toggle.data('id',id);

		$toggle
		.on('click',function () {
			ConfirmModal.activeToggle = _toggle;
			ConfirmModal.updateContents(_toggle);
			ConfirmModal.open();
		});
	});
}





/**
 * --------------------------------------------------------------------------------
 * PUBLIC METHODS
 * --------------------------------------------------------------------------------
 */

ConfirmModal.open = function () {
	ConfirmModal.$element.openModal();
}

ConfirmModal.close = function () {
	ConfirmModal.$element.closeModal();
}

ConfirmModal.updateContents = function (data) {
	var defaults = {
		message : 'Are you sure you want to delete this item?',
		confirmText : 'Delete',
		declineText : 'Cancel'
	};

	var contents = $.extend({},defaults,data);

	ConfirmModal.$confirmMessage.html(contents.message);
	ConfirmModal.$confirmBtn.text(contents.confirmText);
	ConfirmModal.$declineBtn.text(contents.declineText);
}



/**
 * --------------------------------------------------------------------------------
 * INIT
 * --------------------------------------------------------------------------------
 */

bindModal();
bindModalToggle();

});