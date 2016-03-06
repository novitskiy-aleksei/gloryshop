<div class="<?php echo $class;?>">
<h5><i class="<?php echo $subscribe_icon;?>"></i><?php echo $subscribe_title; ?></h5>
<div class="pre-footer-subscribe-box" id="subscribe_box_footer">
<div class="input-group margin-bottom-10">
                  <input type="text" value="" name="subscribe_email" class="form-control subscribe_email" placeholder="Email">
                  <span class="input-group-btn">
    			 <?php if($ave->getConfig('ave_newsletter_unsubscribe')==1) { ?>
                    <button class="btn e_subscribe btn-primary" type="button" onclick="THEME.check_subscribe('footer','unsubscribe');">
                    <i class="fa fa-chain-broken with-tooltip" title="<?php echo $ave->text('text_unsubscribe');?>"></i></button>
                    <?php } ?>
                    <button class="btn e_subscribe btn-primary" type="button" onclick="THEME.check_subscribe('footer','subscribe');">
                    <i class="fa fa-envelope-o"></i>
                    <span> <?php echo $ave->text('text_subscribe');?></span></button>
                    
                  </span>
 </div>
 <div id="subscribe_message_footer"></div>
 </div>
</div>   