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
                    <br> 
                    
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_status; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($skin_pin_product_status=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[skin_pin_product_status]" value="1" <?php if($skin_pin_product_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_pin_product_status=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[skin_pin_product_status]" value="0" <?php if($skin_pin_product_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_title; ?></label>
<div class="col-sm-12">
                    	<?php foreach ($languages as $language){ ?>
                      <div class="lang-field">
                        <input type="text" name="theme_setting[skin_pin_product_title][<?php echo $language['language_id'];?>]" value="<?php echo isset($theme_setting['skin_pin_product_title'][$language['language_id']]) ? $theme_setting['skin_pin_product_title'][$language['language_id']]: 'Featured';?>" class="form-control"/>
                        <img src="image/flags/<?php echo $language['image'];?>" title="<?php echo $language['name'];?>"/>
                        </div>
                      <?php } ?>
                     </div>
              </div><!-- form-group--> 
              
                      
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_dimension; ?></label>
<div class="col-sm-12">
<div class="row">
<div class="col-sm-6 col-xs-12">
<input type="text" name="theme_setting[pin_binding][image_width]" size="1" value="<?php echo $pin_binding['image_width']; ?>" class="form-control"/>
          </div>  
<div class="col-sm-6 col-xs-12">          
                      <input type="text" name="theme_setting[pin_binding][image_height]" size="1" value="<?php echo $pin_binding['image_height']; ?>" class="form-control"/>
                      </div>
                      </div><!-- row --> 
                     </div>
              </div><!-- form-group--> 
<div class="form-group hide">
                    <label class="col-sm-12 control-label"><?php echo $entry_item_shown;?></label>
<div class="col-sm-12"><select name="theme_setting[pin_binding][carousel_limit]" class="form-control">
                        <option value="3" <?php echo ($pin_binding['carousel_limit']=='3')?'selected="selected"':'';?>>3</option>
                        <option value="4" <?php echo ($pin_binding['carousel_limit']=='4')?'selected="selected"':'';?>>4</option>
                        <option value="5" <?php echo ($pin_binding['carousel_limit']=='5')?'selected="selected"':'';?>>5</option>
                        </select>
                     </div>
              </div><!-- form-group--> 
              
<h4><?php echo $entry_product; ?></h4>
    <div class="autosuggest">
        <div class="autosuggest_heading">
          <input type="text" name="filter_product" value="" class="form-control"/>
        </div>
        <div class="autosuggest_content" id="products"> </div>
        <!-- autosuggest_content--> 
        <div id="skin_pin_product" class="scrollbox"><?php $class = 'odd'; ?>
          <?php foreach ($products as $product){ ?>
          <?php $class = ($class=='even' ? 'odd' : 'even'); ?>
          <div id="skin_pin_product<?php echo $product['product_id']; ?>" class="<?php echo $class; ?>"><?php echo $product['name']; ?> <img src="assets/theme/img/delete.png" alt="" onclick="$(this).parent().remove();"/>
      <input type="hidden" name="skin_pin_product[]" value="<?php echo $product['product_id']; ?>" class="form-control"/>
          </div>
          <?php } ?>
        </div>
        <!--skin_pin_product -->
      </div>
      
      <!-- autosuggest-->
            
            
           </div>