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
    <label class="btn btn-xs btn-success <?php if($skin_pin_download_status=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[skin_pin_download_status]" value="1" <?php if($skin_pin_download_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_pin_download_status=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[skin_pin_download_status]" value="0" <?php if($skin_pin_download_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
             
           <?php 
        if($content_installed){        
        	$download_style='';
        	$download_message='';
        }else{
        	$download_message='<div class="alert alert-warning">'.$text_skin_pin_download_message.'</div>';
        	$download_style='display:none';        
        }
         ?>
                <?php echo $download_message;?>
                <div style="<?php echo $download_style;?>">
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_title; ?></label>
<div class="col-sm-12"><?php foreach ($languages as $language){ ?>
                      <div class="lang-field">
                        <input type="text" name="theme_setting[skin_pin_download_title][<?php echo $language['language_id'];?>]" value="<?php echo isset($theme_setting['skin_pin_download_title'][$language['language_id']]) ? $theme_setting['skin_pin_download_title'][$language['language_id']]: 'Download';?>" class="form-control"/>
                        <img src="image/flags/<?php echo $language['image'];?>" title="<?php echo $language['name'];?>"/> </div>
                      <?php } ?>
                     </div>
              </div><!-- form-group--> 
                    <h4><?php echo $text_download; ?></h4>
                    <div class="autosuggest">
                        <div class="autosuggest_heading">
                          <input type="text" name="filter_download" value="" class="form-control"/>
                        </div>
                        <div class="autosuggest_content" id="downloads"> </div>
                        <!-- autosuggest_content--> 
                        <div id="skin_pin_download" class="scrollbox"><?php $class = 'odd'; ?>
                          <?php foreach ($downloads as $download){ ?>
                          <?php $class = ($class=='even' ? 'odd' : 'even'); ?>
                          <div id="skin_pin_download<?php echo $download['download_id']; ?>" class="<?php echo $class; ?>"><?php echo $download['name']; ?> <img src="assets/theme/img/delete.png" alt="" onclick="$(this).parent().remove();"/>
                      <input type="hidden" name="skin_pin_download[]" value="<?php echo $download['download_id']; ?>"/>
                          </div>
                          <?php } ?>
                        </div>
                        <!--skin_pin_download -->
                      </div><!--autosuggest --> 
                      
                      
                     </div><!--download_style -->
           
              </div><!-- container-fluid--> 
                