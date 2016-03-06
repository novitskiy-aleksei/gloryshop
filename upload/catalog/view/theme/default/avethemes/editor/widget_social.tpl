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
  <a data-group="general_group" data-action="general_header" class="modal-form btn btn-block btn-info margin-bottom-15" data-title="<?php echo $text_header;?>"><i class="fa fa-chevron-left"></i>  <?php echo $text_back;?></a>
  
 			<div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $entry_status; ?></label>
<div class="col-sm-9">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($social_status=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[social_status]" value="1" <?php if($social_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($social_status=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[social_status]" value="0" <?php if($social_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
           
                
               <div class="table-responsive">
                <table id="add_social" class="table table-bordered table-hover">
                  <?php $social_row = 0;?>
                  <?php 
                  if(!empty($skin_social_data)){
                  foreach ($skin_social_data as $social){ ?>
                  <?php if(!empty($social['image'])||!empty($social['icon'])){ ?>
                  <tbody class="social-row" id="social-row<?php echo $social_row;?>">
                  <tr><td colspan="3"><div class="heading-bar text-center">Social #<?php echo $social_row;?></div></td></tr>
                      <tr>
                      
              <td colspan="3">
<div class="form-group">

              <div class="form-group">
                    <label class="control-label"><?php echo $entry_title;?></label>
                        <?php foreach ($languages as $language){ ?>
                        <div class="lang-field">
                          <input type="text" name="skin_social_data[<?php echo $social_row;?>][title][<?php echo $language['language_id'];?>]" value="<?php echo isset($social['title'][$language['language_id']]) ? $social['title'][$language['language_id']] : '';?>" class="form-control"/>
                          <img src="image/flags/<?php echo $language['image'];?>" title="<?php echo $language['name'];?>"  /> </div>
                        <?php } ?>
                        </div>
                        
              <div class="form-group">
                    <label class="control-label"><?php echo $entry_link;?></label>
                    
                          <input type="text" name="skin_social_data[<?php echo $social_row;?>][link]" value="<?php echo $social['link'];?>" class="form-control"/>
                       </div>
                       
              <div class="form-group">
                          <label><?php echo $entry_target;?>
                          <input type="checkbox" name="skin_social_data[<?php echo $social_row;?>][target]" value="1" <?php echo (!empty($social['target']))?'checked="checked"':'';?>/></label>
                          </div>
                         
                        <input class="sort_order" type="hidden" name="skin_social_data[<?php echo $social_row;?>][sort_order]" value="<?php echo $social['sort_order'];?>"/>
                          </td>
                          </tr>
                          
                  <tr>
                
              <td>
                  <div class="form-group"><label class="control-label"><?php echo $entry_icon;?></label></div>
                  <a class="icon-preview">
                          <i id="social_icon<?php echo $social_row;?>_thumb" class="<?php echo $social['icon'];?>">&nbsp;</i>
                          <input type="hidden" name="skin_social_data[<?php echo $social_row;?>][icon]" value="<?php echo $social['icon'];?>" id="social_icon<?php echo $social_row;?>"/>
                  </a><i class="fa fa-trash-o clear-ico"></i>
                          
                  </td>
                      <td><a onclick="$('#social-row<?php echo $social_row;?>').remove();" class="btn btn-xs btn-primary"><?php echo $button_remove;?></a></td>
                      </tr>
                  
                  </tbody>
                  <?php } ?>
                  <?php $social_row++;?>
                  <?php } ?>
                  <?php } ?>
                  <tfoot data-row="<?php echo $social_row;?>">
                    <tr><td colspan="4"><a onclick="MCP.addSocialRow();" class="btn btn-xs btn-primary pull-right"><?php echo $button_add_social;?></a></td></tr>
                  </tfoot>
                  </table>
                </div><!-- table-responsive--> 
              </div>