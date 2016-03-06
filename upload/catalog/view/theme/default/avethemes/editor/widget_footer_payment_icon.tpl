<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>


  <a data-group="general_group" data-action="general_footer" class="modal-form btn btn-block btn-info margin-bottom-15" data-title="<?php echo $text_footer;?>"><i class="fa fa-chevron-left"></i>  <?php echo $text_back;?></a>
    <ul class="nav nav-tabs nav-justified margin-bottom-5">
            <li class="active"><a href="#tab-payicon" data-toggle="tab"><?php echo $text_payment_logo;?></a></li>
            <li> <a href="#tab-powered" data-toggle="tab"><?php echo $text_powered;?></a></li>
    </ul>
    
 <div class="container-fluid">
 
  
 
            <div class="tab-content clearfix">
                    <div class="tab-pane" id="tab-powered">
   <div class="form-group">                
      <div class="row">
            <label class="col-sm-4 control-label"><?php echo $entry_power_position; ?></label>
                <div class="col-sm-8">
                    <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-xs btn-success <?php if($powered_position=='pull-left'){ echo 'active tr_click';}?>">
                            <input type="radio" name="theme_setting[powered_position]" value="pull-left" <?php if($powered_position=='pull-left'){ echo 'checked';}?>/><?php echo $text_pull_left;?></label>
                        <label class="btn btn-xs btn-info <?php if($powered_position=='pull-right text-right'){ echo 'active tr_click';}?>">
                            <input type="radio" name="theme_setting[powered_position]" value="pull-right text-right" <?php if($powered_position=='pull-right text-right'){ echo 'checked';}?>/><?php echo $text_pull_right;?></label>
                    </div>
             </div>
      </div><!-- row-->    
      </div><!-- form-group-->   
             
            
                 <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_powered_info;?></label>
                 </div>
                 <div class="form-group">
                    <div class="col-sm-12"><?php foreach ($languages as $language){ ?>
                      <div class="lang-field">
                        <textarea name="skin_powered_desc[<?php echo $language['language_id'];?>]" id="skin_powered_desc<?php echo $language['language_id'];?>" rows="15" class="form-control" style="min-height:240px;resize: none;"><?php echo isset($skin_powered_desc[$language['language_id']]) ? $skin_powered_desc[$language['language_id']]: 'Powered By OpenCart © 2015<br>Theme made by <a href="http://www.avethemes.com" target="_blank">AveThemes</a>';?></textarea>
                        <img src="image/flags/<?php echo $language['image'];?>" title="<?php echo $language['name'];?>"/> </div>
                      <?php } ?>
                     </div>
              </div><!-- form-group--> 
              
                  </div><!-- tab-content--> 
                  
                  
                  
                  
                  
                  
                  
                  
                  
              <div class="tab-pane active" id="tab-payicon">
               <div class="form-group">                
      <div class="row">
            <label class="col-sm-4 control-label"><?php echo $entry_status; ?></label>
                <div class="col-sm-8">
                    <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-xs btn-success <?php if($skin_payment_icons_status=='1'){ echo 'active tr_click';}?>">
                            <input type="radio" name="skin_payment_icons_status" value="1" <?php if($skin_payment_icons_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
                        <label class="btn btn-xs btn-info <?php if($skin_payment_icons_status=='0'){ echo 'active tr_click';}?>">
                            <input type="radio" name="skin_payment_icons_status" value="0" <?php if($skin_payment_icons_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
                    </div>
             </div>
      </div><!-- row-->    
      </div><!-- form-group-->       
                
               <div class="table-responsive">
                <table id="add_payment_icons" class="table table-bordered table-hover">
                  <thead>
                    <td><?php echo $entry_image;?></td>
                    <td><?php echo $entry_title;?></td>
                    <td><?php echo $text_action;?></td>
                  </thead>
                  <?php $payment_row = 0;?>
                  <?php 
                  if(!empty($skin_payment_icons_data)){
                  foreach ($skin_payment_icons_data as $payment){ ?>
                  <?php if(!empty($payment['image'])){ ?>
                  <tbody class="payment_icons-row" id="payment_icons-row<?php echo $payment_row;?>">
                  <tr>
                  <td>
                  
                    <a id="payment_image<?php echo $payment_row;?>_thumb" data-toggle="imagex" class="img-thumbnail file-browse">
                    <img src="<?php echo (!empty($payment['image']))?$payment['image']:'';;?>" data-placeholder="<?php echo (!empty($payment['image']))?$payment['image']:'';;?>" alt=""/></a>
                  <i class="fa fa-trash-o clear-img"></i><input type="hidden" name="skin_payment_icons_data[<?php echo $payment_row;?>][image]" value="<?php echo $payment['image'];?>" id="payment_image<?php echo $payment_row;?>"/>
                  
                        </td>
                         <td>
                   <?php foreach ($languages as $language){ ?>
                        <div class="lang-field">
                          <input type="text" name="skin_payment_icons_data[<?php echo $payment_row;?>][title][<?php echo $language['language_id'];?>]" value="<?php echo isset($payment['title'][$language['language_id']]) ? $payment['title'][$language['language_id']] : '';?>" class="form-control"/>
                          <img src="image/flags/<?php echo $language['image'];?>" title="<?php echo $language['name'];?>"/> </div>
                        <?php } ?></td>
                      <td class="right"><a onclick="$('#payment_icons-row<?php echo $payment_row;?>').remove();" class="btn btn-primary btn-sm pull-right"><?php echo $button_remove;?></a></td>
                  
                  <?php } ?>
                  <?php $payment_row++;?>
                  <?php } ?>
                  <?php } ?>
                  </td>
                  </tr>
                  <tfoot data-row="<?php echo $payment_row;?>">
                    <tr>
                      <td colspan="3" class="right"><a onclick="MCP.addPayment();" class="btn btn-primary btn-sm pull-right"><?php echo $button_add_payment_icons;?></a></td>
                      </tr>
                  </tfoot>
                </table>
                
              </div>
            </div><!-- tab_content-->
 </div>