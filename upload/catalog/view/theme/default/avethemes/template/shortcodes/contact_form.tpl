  <div class="content_row" id="popup_contact">
  		<h3 class="title1 upper"><?php if(!empty($icon)){?><i class="<?php echo $icon;?>"></i><?php } ?><?php echo html_entity_decode($sections['title'][$language_id], ENT_QUOTES, 'UTF-8');?></h3>
      <form id="contact_form<?php echo $module;?>" enctype="multipart/form-data" class="form-horizontal">
       <?php if(isset($sections['description'][$language_id])){?>
                <p class="text">
			<?php echo html_entity_decode($sections['description'][$language_id], ENT_QUOTES, 'UTF-8');?>
           	 </p>
             <?php } ?>
          <div class="clearfix">
        
              <div class="form-group">
                  <div class="col-md-6">
                    <label class="control-label"><?php echo $entry_name; ?></label>
                      <input type="text" name="name" value="" id="input-name" class="form-control" />
                  </div>
                  <div class="col-md-6">
                    <label class="control-label"><?php echo $entry_email; ?></label>
                      <input type="text" name="email" value="" id="input-email" class="form-control" />
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12">
                <label class=" control-label"><?php echo $entry_enquiry; ?></label>
                  <textarea name="enquiry" rows="9" id="input-enquiry" class="form-control"></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12 popup_message"></div>
                  <div class="col-md-7 col-xs-7">
                            <div class="input-group"> 
                              <input type="text" name="captcha" value="" id="input-captcha" class="form-control" />
                                 
                            <div class="input-group-addon captcha">
                                    <img src="index.php?route=avethemes/contact/captcha" id="contact_captcha<?php echo $module;?>" alt="" onclick="reload_captcha('contact_captcha<?php echo $module;?>');" />
                                  </div>
                            </div>
                   </div>
                  <div class="col-md-5 col-xs-5 text-right">
                    <a class="btn btn-primary" id="contact-submit<?php echo $module;?>"><?php echo $button_submit; ?></a>
                  </div>
              </div>
          </div><!-- clearfix--> 
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
     </div>