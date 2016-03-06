<input type="hidden" name="display" value="<?php echo $element;?>"/>
       	
          
             
         <div class="form-group">
            <label class="col-sm-2 control-label" for="input-locale"><?php echo $entry_type; ?></label>
            <div class="col-sm-10">
                           
 <select name="sections[fb_type]"class="form-control">
    <option value="admins"  <?php echo ('admins'==$sections['fb_type'])?'selected="selected"':'';?>>Admin</option> 
    <option value="app_id"  <?php echo ('app_id'==$sections['fb_type'])?'selected="selected"':'';?>>AppID</option> 
            </select>
            
            </div>
          </div>  
          <div class="form-group">
            <label class="col-sm-2 control-label">Facebook ID</label>
            <div class="col-sm-10">
               <input type="text" name="sections[fb_id]"class="form-control" value="<?php echo $sections['fb_id'];?>">
            </div>
          </div>
           <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_num_comment; ?></label>
            <div class="col-sm-10">
               <input type="text" name="sections[fb_num_posts]"class="form-control" value="<?php echo $sections['fb_num_posts'];?>">
            </div>
          </div>
          
         <div class="form-group">
            <label class="col-sm-2 control-label" for="input-locale"><?php echo $entry_order_by; ?></label>
            <div class="col-sm-10">
                           
 <select name="sections[fb_order_by]"class="form-control">
    <option value="social"  <?php echo ('social'==$sections['fb_order_by'])?'selected="selected"':'';?>>Social</option> 
    <option value="reverse_time"  <?php echo ('reverse_time'==$sections['fb_order_by'])?'selected="selected"':'';?>>Reverse time</option> 
    <option value="time"  <?php echo ('time'==$sections['fb_order_by'])?'selected="selected"':'';?>>Time</option> 
            </select>
            
            </div>
          </div>  
          
         <div class="form-group">
            <label class="col-sm-2 control-label" for="input-locale"><?php echo $entry_color_scheme; ?></label>
            <div class="col-sm-10">
                           
 <select name="sections[fb_color_scheme]"class="form-control">
    <option value="light"  <?php echo ('light'==$sections['fb_color_scheme'])?'selected="selected"':'';?>><?php echo $text_light;?></option> 
    <option value="dark"  <?php echo ('dark'==$sections['fb_color_scheme'])?'selected="selected"':'';?>><?php echo $text_dark;?></option> 
            </select>
            
            </div>
          </div>  
           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-locale"><?php echo $entry_locale; ?></label>
            <div class="col-sm-10">
                           
 <select name="sections[fb_lang]"class="form-control">
              <?php foreach ($flangs as $value=>$label) { ?>
    <option value="<?php echo $value;?>"  <?php echo ($value==$sections['fb_lang'])?'selected="selected"':'';?>><?php echo $label;?> - <?php echo $value;?></option> 
              <?php } ?>
            </select>
            
            </div>
          </div>