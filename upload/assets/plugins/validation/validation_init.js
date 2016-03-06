$(document).ready(function(){
//----------> Validation
		if ( $.isFunction($.fn.validate) ) {
			$("#contact-us-form").validate({
				submitHandler: function(contact_form) {
					$('.form_loader').css({ "display": "block"});
					$('#form-messages').css({ "opacity": "0"});
					$(contact_form).ajaxSubmit({
						target: '#form-messages',
						success: function() {
							$('.form_loader').css({ "display": "none"});
							$('#form-messages').css({ "opacity": "1"});
							$('#form-messages').addClass("send_success");
							$('#contact-us-form').find('.form_fill_fields').val('');
						},
						
					});
				}
			});
			
			$("#careers-form").validate({
				submitHandler: function(contact_form) {
					$('.form_loader').css({ "display": "block"});
					$('#form-messages').css({ "opacity": "0"});
					$(contact_form).ajaxSubmit({
						target: '#form-messages',
						success: function() {
							$('.form_loader').css({ "display": "none"});
							$('#form-messages').css({ "opacity": "1"});
							$('#form-messages').addClass("send_success");
							$('#careers-form').find('.form_fill_fields').val('');
						},
						
					});
				}
			});
			
			$("#newsletter_form").validate({
				submitHandler: function(subscribe_mail) {
					$('.newsletter_button').find(".refresh_loader").css({"opacity" : "1"}).siblings("i").css({"opacity" : "0"});
					$('#subscribe_output').slideUp(300);
					$(subscribe_mail).ajaxSubmit({
						target: '#subscribe_output',
						success: function() {
							$('.newsletter_button').find(".subscribe_true").css({"opacity" : "1"}).siblings("i").css({"opacity" : "0"});
							$('#subscribe_output').slideDown(300);
							setTimeout(function() {
								$('#subscribe_output').slideUp(300);
								$('.newsletter_button').find(".subscribe_btn").css({"opacity" : "1"}).siblings("i").css({"opacity" : "0"});
							}, 4000 );
							$('#newsletter_form').find('.subscribe-mail').val('');
						}
					});
				},
			});
		};
		
		$('.sign_up_login_flip').on("click", function(){
			var $this = $(this);
			var $form = $this.closest("form");
			var $form_other = $form.siblings("form");
			$form.removeClass("owl-goDown-in").addClass("owl-goDown-out");
			$form_other.removeClass("flip_top").css({"display" : "block"});
			setTimeout(function() {
				if($form.hasClass("login_flip")){
					$form.removeClass("flip_top").css({"display" : "none"});
				}
				$form_other.removeClass("owl-goDown-out").addClass("owl-goDown-in");
				$form_other.addClass("flip_top");
				
			}, 300 );
			
			return false;
		});
});