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
  <button type="button" onclick="MCP.apply(0);" class="btn btn-success pull-right">
                    <i class="fa fa-save"></i>  <?php echo $button_save;?>          </button>
            
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_status; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($skin_pin_information_status=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[skin_pin_information_status]" value="1" <?php if($skin_pin_information_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_pin_information_status=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[skin_pin_information_status]" value="0" <?php if($skin_pin_information_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
              
            <div id="skin_pin_information_extra">
             
              <div class="mpadding"><div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_title; ?></label>
<div class="col-sm-12"><?php foreach ($languages as $language){ ?>
                      <div class="lang-field">
                        <input type="text" name="theme_setting[skin_pin_information_title][<?php echo $language['language_id'];?>]" value="<?php echo isset($theme_setting['skin_pin_information_title'][$language['language_id']]) ? $theme_setting['skin_pin_information_title'][$language['language_id']]: 'Information';?>" class="form-control"/>
                        <img src="image/flags/<?php echo $language['image'];?>" title="<?php echo $language['name'];?>"/> </div>
                      <?php } ?>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <h4><?php echo $text_skin_pin_information; ?></h4>
</div><!-- form-group--> 
                    
<div class="form-group">
                    <div class="col-sm-12"><?php
              if(empty($skin_pin_information)){
              	$skin_pin_information=array();
              }
        	  ?>
                      <div class="well well-sm" style="min-height:150px;overflow: auto;">
                      <?php
                       $class = 'even'; ?>
                        <?php foreach ($informations as $information){ ?>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                        <div class="checkbox<?php echo $class; ?>">
                        <label>
                          <input type="checkbox" name="skin_pin_information[]" value="<?php echo $information['id']; ?>" <?php if (in_array($information['id'], $skin_pin_information)){ ?>checked="checked"<?php } ?>/> <?php echo $information['title']; ?></label>
                        </div>
                        <?php } ?>
                      </div>
                      
                      <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all;?></a> / 
                      <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all;?></a>
                      
                     </div>
              </div><!-- form-group--> 
                
              </div>
            </div>
            <!--skin_pin_information_extra -->
            
           </div>