$(document).ready(function(){
	console.log('ready');
	$("form.sends-email").each(function(){

		// add neccessary html elements for display
		$(this).append('<div class="messages"><p class="success alert alert-success">Thank you. Your message has been sent.</p><p class="failed alert alert-danger">Message was not sent.</p</div>');
		$(this).children('[type="submit"]').after('<img src="public/images/loading.gif" class="loading" alt="">');

		// reference the form as parent
		var parent = $(this);

		//set POST target for aJax request
		var target = $("#sendform").attr('data-view')+"/"+parent.attr("action");

		// slides messages up
		function sldUp(){
			parent.find('.messages p').slideUp(300);
		}

		//slide messages up on input focus	
		parent.find(":input").focus(function(){
			$(this).removeAttr('style');
			sldUp();
		});

		// reset css
		function resetCss(){
			parent.find(":input,textarea").not(".g-recaptcha-response").removeAttr('style');
			sldUp();
		}

		$(this).find('[type="submit"]').click(function(e){


			// reference the submit button as click
			var click = $(this);
			e.preventDefault();


			resetCss();

			$.ajax({
				type: "POST",
				data:parent.serialize(),
				url: target,
				beforeSend:function(){

				// display loading gif and disable button
				parent.find(".loading").toggle(200);
				click.css("pointer-events","none").prop("disabled",true);
			},
			success: function(data){
				// disable the button for 2 seconds no matter the result
				setTimeout(function(){

					if(data == "sent"){
						// slide down success message, hide it after 3 seconds, and clear the field forms
						//parent.find(".success").slideDown(300);
						parent.find(":input").val('');
						parent.find("input[type='checkbox']").attr('checked', false);
						// setTimeout(sldUp,5000);
						swal({
							type: "success",
							title: "Success",
							html: "We will get back to you as soon as possible",
						});
					}
					else{
						var msg = "";
						switch(data){
						// customize the messages here
						case 'not-sent':
						msg = "Mailer error. Please try again.";
						break;
						case 'no-recaptcha':
						msg ="Please click on the reCaptcha.";
						break;
						case 'wrong-recaptcha':
						msg = "You have failed the reCaptcha test. Please try again." ;
						break;
						case 'no-terms-conditions':
						msg = "Please agree to the terms and conditions first.";
						break;
						case 'no-consent':
						msg = "Please agree that you are submitting information so that we can respond to your iniquirty";
						break;
						default:
							// by default parses the messages, but it's possible to customize the message if there are ANY errors,
							// just replace the msg variable below and remove it from the loop. Like the commented sample below
							var errors = JSON.parse(data);
							$.each(errors,function(e){

								//parent.find('[name="'+errors[e]['name']+'"]').css("box-shadow","inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255,0,0,.6");	
								msg = msg+errors[e]['msg']+"<br>";
							});

							//msg="There are some errors on this form";
							break;
						}
						// display the error message
						// parent.find(".failed").html(msg).slideDown(300);
						swal({
							type: "error",
							title: "Error",
							html: msg
						});
						
					}

					// hide the loading gif and enable the button, reset the captcha
					parent.find(".loading").toggle(200);
					click.css("pointer-events","auto").prop("disabled",false);
					$('.g-recaptcha').each(function(index,element) {
						grecaptcha.reset(index);
					});


				},2000)
			},
			error: function(data){
				parent.find(".failed").slideDown(300);

			},
		});
		});
	});
});