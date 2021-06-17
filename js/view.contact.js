/*
Name: 			View - Contact
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version:	5.7.2
*/

(function($) {

	'use strict';

	/*
	Contact Form: Basic
	*/
	$('#contactForm').on('submit', function(e){

		e.preventDefault();					

			var $form = $(this);

			var	$messageSuccess = $('#contactSuccess');			

			// Ajax Submit
			$.ajax({
				type: 'POST',
				url: $form.attr('action'),
				data: {
					name: $('#name').val(),
					email: $('#email').val(),
					subject: 'Contato Site Innovare',
					message: $('#message').val(),
					telefone: $('#telefone').val(),
				}
			}).always(function(data, textStatus, jqXHR) {

				if (data.response == 'success') {

					$messageSuccess.removeClass('hidden');				

					// Reset Form
					$form.find('.form-control')
						.val('')
						.blur()
						.parent()
						.removeClass('has-success')
						.removeClass('has-error')
						.find('label.error')
						.remove();

					if (($messageSuccess.offset().top - 80) < $(window).scrollTop()) {
						$('html, body').animate({
							scrollTop: $messageSuccess.offset().top - 80
						}, 300);
					}					
					
					return;

				} 
				
				$messageSuccess.addClass('hidden');

				$form.find('.has-success')
					.removeClass('has-success');

			});
		
	});

	/*
	Contact Form: Advanced
	*/
	$('#contactFormAdvanced').validate({
		onkeyup: false,
		onclick: false,
		onfocusout: false,
		rules: {
			'captcha': {
				captcha: true
			},
			'checkboxes[]': {
				required: true
			},
			'radios': {
				required: true
			}
		},
		errorPlacement: function(error, element) {
			if (element.attr('type') == 'radio' || element.attr('type') == 'checkbox') {
				error.appendTo(element.parent().parent());
			} else {
				error.insertAfter(element);
			}
		}
	});

}).apply(this, [jQuery]);