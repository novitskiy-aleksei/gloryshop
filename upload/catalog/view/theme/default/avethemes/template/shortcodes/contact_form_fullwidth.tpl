<!-- Contact Us -->
	<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?> " style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
		<div class="content large_spacer no_padding">	
        <div class="heading_title <?php echo $heading_align;?> upper">
			    <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
			</div>
			<div class="content_row clearfix">
				<div class="col-md-12">
					<h2 class="title1 upper"><i class="fa fa-envelope"></i><?php echo html_entity_decode($sections['title'][$language_id], ENT_QUOTES, 'UTF-8');?></h2>
					<span class="spacer40"></span>
					<form id="contact_form<?php echo $module;?>" enctype="multipart/form-data" class="elem_contact_form">
						<div class="form_row clearfix">
							<label>
								<span class="elem_field_name"><?php echo $entry_name; ?></span>
							</label>
							<input class="form_fill_fields elem_input_text" type="text" name="name" id="input-name" placeholder="Full Name">
						</div>
						<div class="form_row clearfix">
							<label>
								<span class="elem_field_name"><?php echo $entry_email; ?></span>
							</label>
							<input class="form_fill_fields elem_input_text" type="text" name="email" id="input-email" placeholder="mail@sitename.com">
						</div>
					
						<div class="form_row clearfix">
							<label>
								<span class="elem_field_name"><?php echo $entry_enquiry; ?></span>
							</label>
							<textarea class="form_fill_fields elem_textarea" name="enquiry" id="input-enquiry"></textarea>
						</div>
                        
						<div class="form_row clearfix">
							<label>
								<span class="elem_field_name">Enter captcha</span>
							</label>
                            <div class="">
                                 <div class="input-group"> 
                                <div class="input-group-addon captcha">
                                        <img src="index.php?route=avethemes/contact/captcha" id="contact_captcha<?php echo $module;?>" alt="" onclick="reload_captcha('contact_captcha<?php echo $module;?>');" /> </div>
                              <input type="text" name="captcha" value="" id="input-captcha" class="form-control full_button" />
                                 
                            </div><!-- /input-group--> 
                              </div><!--//row --> 
              
                        
						</div>
                        <div class="form_row clearfix">
                                <a class="send_button full_button text-center" id="contact-submit<?php echo $module;?>"><?php echo $button_submit; ?></a>
						</div>

                        <div class="form_row clearfix">
							<div class="popup_message"></div>
						</div>
                      


					</form>
                    
<script type="text/javascript">

jQuery('body').on('click', '#contact-submit<?php echo $module;?>', function () {
	$.ajax({
				url: 'index.php?route=avethemes/contact/popup_contact',
				type: 'post',
				dataType: 'json',
				data: $('#contact_form<?php echo $module;?> input[type=\'text\'], #contact_form<?php echo $module;?> input[type=\'hidden\'], #contact_form<?php echo $module;?> input[type=\'radio\']:checked, #contact_form input[type=\'checkbox\']:checked, #contact_form<?php echo $module;?> select, #contact_form<?php echo $module;?> textarea'),
				beforeSend: function() {
					$('.popup_message').html('');
				},
				complete: function() {					
				},
				success: function(json) {
						console.log(json);
					if (json['success']) {	
						reload_captcha('contact_captcha<?php echo $module;?>');
						$('#contact_form<?php echo $module;?> input').val('');
						$('#contact_form<?php echo $module;?> textarea').val('');	
						$('#contact_form<?php echo $module;?> .popup_message').html('<div class="alert alert-success" style="display:none;">' + json['success'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="$(this).parent().fadeOut(500);"><span aria-hidden="true">&times;</span></button></div>');
						$('#contact_form<?php echo $module;?> .popup_message>div').fadeIn(500);
						$('#modal-box').fadeOut(1000);		
						$('.modal-backdrop').remove(); 
						$('body').removeClass('modal-open'); 	
					}
					if (json['error']) {
						$('#contact_form<?php echo $module;?> .popup_message').html('<div class="alert alert-warning" style="display:none;">' + json['error'] + '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="$(this).parent().fadeOut(500);"><span aria-hidden="true">&times;</span></button></div>');
						$('#contact_form<?php echo $module;?> .popup_message>div').fadeIn(500);
					} 	
				}
			});
});

function reload_captcha(id) {
	var obj =document.getElementById(id);
	var src ='index.php?route=avethemes/contact/captcha';
	var date =new Date();
	obj.src = src + '&time=' + date.getTime();
	return false;
}

</script>
				</div><!-- Grid -->
		
			</div>
		</div>
	</div>
	<!-- End Contact Us -->