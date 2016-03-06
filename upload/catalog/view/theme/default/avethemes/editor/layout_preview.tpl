<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>


  <a data-group="general_group" data-action="layout_assign" class="modal-form btn btn-block btn-info margin-bottom-15" data-title="<?php echo $text_header;?>"><i class="fa fa-chevron-left"></i>  <?php echo $text_back;?></a>
        
   
          <div class="container-fluid">     
 <h4><?php echo $text_composer_setting;?></h4>
  
          <div class="form-group">
            <label class="col-sm-12 control-label" for="input-name"><?php echo $text_layout_load; ?></label>
<div class="col-sm-12">
              <select type="text" name="skin_layout_refresh" class="form-control tr_change" onchange="MCP.activeObj('layout_option',this.options[this.selectedIndex].value);">
                <option value="1" <?php if ($skin_layout_refresh=='1') { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php if ($skin_layout_refresh=='0') { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
              </select>
              </select>
            </div>
          </div><!--form-group --> 
          <div class="form-group layout_option otp-0">
            <label class="col-sm-12 control-label" for="input-name"><?php echo $text_module_option; ?></label>
<div class="col-sm-12">
              <select type="text" name="skin_layout_builder_show_option" class="form-control">
                <option value="show_module_option" <?php if ($skin_layout_builder_show_option=='show_module_option') { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                <option value="hide_module_option" <?php if ($skin_layout_builder_show_option=='hide_module_option') { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
              </select>
              </select>
            </div>
          </div><!--form-group --> 
          
          <div class="form-group">
            <label class="col-sm-12 control-label" for="input-name"><?php echo $text_module_display; ?></label>
<div class="col-sm-12">
              <select type="text" name="skin_layout_builder_module_display" class="form-control">
                <option value="1" <?php if ($skin_layout_builder_module_display=='1') { ?>selected="selected"<?php } ?>><?php echo $text_accordion; ?></option>
                <option value="0" <?php if ($skin_layout_builder_module_display=='0') { ?>selected="selected"<?php } ?>><?php echo $text_default; ?> (Tables)</option>
              </select>
              </select>
            </div>
          </div><!--form-group --> 
          
            <h4><?php echo $text_preview_layout_setting;?></h4>
            <p>
            <?php echo $entry_layout; ?> - <?php echo $entry_preview_url; ?>
            </p>
      <div class="table-responsive">
         <table id="page" class="table table-bordered table-hover">
           <?php foreach($layouts as $layout){?>
              <tbody>
               <tr>
                  <td class="left"><input type="hidden" name="skin_layout_builder_preview_urls[<?php echo $layout['layout_id']; ?>][layout_id]" value="<?php echo $layout['layout_id']; ?>" size="5"/><b class="upper"><?php echo $layout['name']; ?></b>
                         
                    </td>      
                </tr>
                
                <tr>
                  <td class="left">
          <?php if(isset($skin_layout_builder_preview_urls[$layout['layout_id']])){?>
          <input type="text" name="skin_layout_builder_preview_urls[<?php echo $layout['layout_id']; ?>][preview_url]" value="<?php echo $skin_layout_builder_preview_urls[$layout['layout_id']]['preview_url']; ?>" class="form-control"/>
          <?php }else{ ?>
          <input type="text" name="skin_layout_builder_preview_urls[<?php echo $layout['layout_id']; ?>][preview_url]" value="index.php?route=common/home" class="form-control"/>
          <?php } ?>
                         
                    </td>      
                </tr>
              </tbody> 
          <?php } ?>
        </table>
        </div>
       </div><!--container-fluid -->  
</div>