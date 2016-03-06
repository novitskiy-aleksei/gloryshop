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
    <label class="btn btn-xs btn-success <?php if($skin_pin_brand_status=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[skin_pin_brand_status]" value="1" <?php if($skin_pin_brand_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_pin_brand_status=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[skin_pin_brand_status]" value="0" <?php if($skin_pin_brand_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
            <div id="skin_pin_brand_extra">
             
              <div class="mpadding"><div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_title; ?></label>
<div class="col-sm-12"><?php foreach ($languages as $language){ ?>
                      <div class="lang-field">
                        <input type="text" name="theme_setting[skin_pin_brand_title][<?php echo $language['language_id'];?>]" value="<?php echo isset($theme_setting['skin_pin_brand_title'][$language['language_id']]) ? $theme_setting['skin_pin_brand_title'][$language['language_id']]: 'Brands';?>"  class="form-control"/>
                        <img src="image/flags/<?php echo $language['image'];?>" title="<?php echo $language['name'];?>"/> </div>
                      <?php } ?>
                     </div>
              </div><!-- form-group--> 
<div class="form-group hide">
                    <label class="col-sm-12 control-label"><?php echo $entry_item_per_row;?></label>
<div class="col-sm-12"><select name="theme_setting[skin_pin_brand_limit]" class="form-control">
                        <option value="3" <?php echo ($skin_pin_brand_limit=='3')?'selected="selected"':'';?>>3</option>
                        <option value="4" <?php echo ($skin_pin_brand_limit=='4')?'selected="selected"':'';?>>4</option>
                        <option value="5" <?php echo ($skin_pin_brand_limit=='5')?'selected="selected"':'';?>>5</option>
                        <option value="6" <?php echo ($skin_pin_brand_limit=='6')?'selected="selected"':'';?>>6</option></select>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_dimension; ?></label>
<div class="col-sm-12"><input type="text" name="theme_setting[skin_pin_logo_width]" value="<?php echo $skin_pin_logo_width; ?>" class="form-control half-width"/>
                      
                      <input type="text" name="theme_setting[skin_pin_logo_height]" value="<?php echo $skin_pin_logo_height; ?>" class="form-control half-width"/>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <h4><?php echo $text_skin_pin_brand; ?></h4>   
              </div><!-- form-group--> 
<div class="form-group">
                    <div class="col-sm-12"><?php
              if(empty($skin_pin_brand)){
              	$skin_pin_brand=array();
              }
        	  ?>
                      <div class="well well-sm" style="min-height:150px;overflow: auto;">
                      	<?php $class = 'even'; ?>
                        <?php foreach ($manufacturers as $manufacturer){ ?>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                        <div class="checkbox <?php echo $class; ?>">
                        <label>
                          <input type="checkbox" name="skin_pin_brand[]" value="<?php echo $manufacturer['id']; ?>" <?php if (in_array($manufacturer['id'], $skin_pin_brand)){ ?>checked="checked"<?php } ?>/> <?php echo $manufacturer['name']; ?></label>
                        </div>
                        <?php } ?>
                      </div>
                      <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all;?></a> / 
                      <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all;?></a>
                      
                     </div>
              </div><!-- form-group--> 
                
              </div>
            </div>
            <!--skin_pin_brand_extra -->
            
           </div>