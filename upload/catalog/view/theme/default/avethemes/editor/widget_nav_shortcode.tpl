<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>


 <div class="container-fluid">
        
  <a data-group="general_group" data-action="general_navigation" class="modal-form btn btn-info" data-title="<?php echo $text_header_nav;?>"><i class="fa fa-chevron-left"></i>  <?php echo $text_back;?></a>
  <button type="button" onclick="MCP.apply(1);" class="btn btn-success pull-right">
                    <i class="fa fa-save"></i>  <?php echo $button_save;?>          </button>
                      
              
              <br> 
              
 		    
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_status; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($skin_nav_shortcode=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_nav_shortcode" value="1" <?php if($skin_nav_shortcode=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_nav_shortcode=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_nav_shortcode" value="0" <?php if($skin_nav_shortcode=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
              
           </div>