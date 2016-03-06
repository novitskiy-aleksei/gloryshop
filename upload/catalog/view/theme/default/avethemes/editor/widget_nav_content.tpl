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
        
        
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_status; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($nav_content_status=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[nav_content_status]" value="1" <?php if($nav_content_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($nav_content_status=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[nav_content_status]" value="0" <?php if($nav_content_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
  
              
               
 			<div class="form-group">     
            <div class="col-sm-12"> 
                    <?php 
        if($content_installed){        
        	$custom_menu_message='<a class="btn btn-info btn-sm" href="'.$custom_menu_link.'" target="_blank">'.$text_click_custom_menu.'</a>';
        }else{
        	$custom_menu_message='<div class="alert alert-warning">'.$text_skin_pin_download_message.'</div>';
        }
         ?>
         <?php echo $custom_menu_message;?>
                    
                    
                     </div>
              </div><!-- form-group--> 
                    
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_dimension; ?></label>
<div class="col-sm-12"><input type="text" name="theme_setting[preview_content_image_width]" value="<?php echo $preview_content_image_width; ?>" class="form-control half-width"/>
                      
                      <input type="text" name="theme_setting[preview_content_image_height]" value="<?php echo $preview_content_image_height; ?>" class="form-control half-width"/>
                     </div>
              </div><!-- form-group--> 
                
              <br>             
                             
              <table class="table nav_table">
<thead>
<tr>
<th><?php echo $text_name;?></th>
<th><?php echo $text_display;?></th>
<th><?php echo $text_column;?></th>
<th><?php echo $text_top;?></th>
</tr>
</thead>
<?php foreach($content_categories as $category){ ?>
<tbody class="nav_row">
<tr>
<td><?php echo $category['name'];?>
<input type="hidden" name="nav_content[<?php echo $category['content_id'];?>][sort_order]" class="nav_sort" value="<?php echo $category['sort_order'];?>">
</td>
<td>
 <select name="nav_content[<?php echo $category['content_id'];?>][display]" class="form-control" style="min-width:60px;">
<option value="mega" <?php echo ($category['display']=='mega')?'selected="selected"':'';?>><?php echo $text_mega;?></option>
<option value="multilevel" <?php echo ($category['display']=='multilevel')?'selected="selected"':'';?>><?php echo $text_3level;?></option>
                        </select>
                        </td>
<td>
 <select name="nav_content[<?php echo $category['content_id'];?>][column]" class="form-control" style="width:55px;">
<option value="1" <?php echo ($category['column']=='1')?'selected="selected"':'';?>>1</option>
<option value="2" <?php echo ($category['column']=='2')?'selected="selected"':'';?>>2</option>
<option value="3" <?php echo ($category['column']=='3')?'selected="selected"':'';?>>3</option>
<option value="4" <?php echo ($category['column']=='4')?'selected="selected"':'';?>>4</option>
                        </select>
</td>
<td><input type="checkbox" name="nav_content[<?php echo $category['content_id'];?>][top]" value="1" <?php echo ($category['top']==1)?'checked="checked"':'';?>></td>
</tr>
</tbody>
<?php } ?>

</table>
           </div>