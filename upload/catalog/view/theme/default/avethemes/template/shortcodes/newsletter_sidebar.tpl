<div class="content_row">
      <h3 class="heading_title"><?php echo $heading_title; ?></h3>
   <div class="content-inner margin-bottom-20" id="subscribe_box_<?php echo $module;?>">
   
<?php echo (isset($sections['description'][$language_id]))?'<p>'.html_entity_decode($sections['description'][$language_id], ENT_QUOTES, 'UTF-8').'</p>':'';?>
                  <div class="text-center">
                <div class="form" role="form">
                 
                      <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" name="subscribe_name" class="form-control" placeholder="<?php echo $entry_name; ?>">
                      </div>
                  <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" name="subscribe_email" class="form-control" placeholder="<?php echo $entry_email; ?>">
                  </div>
                </div>
     			<div id="subscribe_message_<?php echo $module;?>"></div>
                <div class="btn-group">
     <a class="btn btn-primary e_subscribe" onclick="check_subscribe('<?php echo $module;?>','subscribe');"><i class="fa fa-envelope-o margin-right-10"></i><?php echo $entry_button; ?></a>
     <?php if($ave_newsletter_unsubscribe) { ?>
          <a class="btn btn-default e_subscribe" onclick="check_subscribe('<?php echo $module;?>','unsubscribe');" title="<?php echo $entry_unbutton; ?>">&nbsp;<i class="fa fa-chain-broken"></i>&nbsp;</a>
      <?php } ?>   
      </div>
              </div>
    </div> 
 </div>