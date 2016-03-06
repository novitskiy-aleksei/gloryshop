       	<table class="table table-bordered table-hover" style="display:none">
               <tr>
               
               <td width="150"><?php echo $entry_template;?> </td>
               <td>
 <select name="display" id="display" class="form-control tr_change with-nav" onchange="Plus.activeObj('display',this.options[this.selectedIndex].value);">  
    <option value="fan_box" <?php echo ($display=='fan_box')?'selected="selected"':'';?>><?php echo $text_fanbox;?></option>
            </select>
   <!-- <option value="chat_box" <?php echo ($display=='chat_box')?'selected="selected"':'';?>><?php echo $text_chatbox;?></option> --> 
                  </td>
                  </tr>  <tr>
               <td width="150"></td>
               <td>
               <div style="max-width:600px;">
                <img src="../assets/editor/img/mockup/facebook_page.png" class="img-responsive display otp-fan_box"/>
                <img src="../assets/editor/img/mockup/chat_box.png" class="img-responsive display otp-chat_box"/>
                </div>
                  </td>
                  </tr>
                  
               
   </table>
          <div class="form-group required">
            <label for="input-page-url" class="col-sm-2 control-label"><?php echo $entry_page_url; ?></label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-addon">www.facebook.com/</span>
                <input type="text" id="input-page-url" name="sections[page_url]" value="<?php echo $sections['page_url']; ?>" placeholder="<?php echo $entry_page_url; ?>" class="form-control">
              </div>
            </div>
          </div>
          
          <div class="row display otp-fan_box">
              <div class="col-xs-6">
              	<div class="form-group required">
                <label class="col-sm-4 control-label" for="input-width"><?php echo $entry_width; ?></label>
                <div class="col-sm-8">
                  <input type="text" id="input-width" name="sections[width]" value="<?php echo $sections['width']; ?>" placeholder="<?php echo $entry_width; ?>" class="form-control" />
                </div>
                </div>
             </div><!--//col --> 
              <div class="col-xs-6">
              	<div class="form-group required">
              <label class="col-sm-4 control-label" for="input-height"><?php echo $entry_height; ?></label>
                <div class="col-sm-8">
                  <input type="text" id="input-height" name="sections[height]" value="<?php echo $sections['height']; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                </div>
              </div>
              </div><!--//col --> 
          </div>
         
          <div class="row display otp-chat_box">
              <div class="col-xs-6">
              	<div class="form-group required">
                <label class="col-sm-4 control-label" for="input-width"><?php echo $entry_width; ?></label>
                <div class="col-sm-8">
                  <input type="text" id="input-width" name="sections[cwidth]" value="<?php echo $sections['cwidth']; ?>" placeholder="<?php echo $entry_width; ?>" class="form-control" />
                </div>
                </div>
             </div><!--//col --> 
              <div class="col-xs-6">
              	<div class="form-group required">
              <label class="col-sm-4 control-label" for="input-height"><?php echo $entry_height; ?></label>
                <div class="col-sm-8">
                  <input type="text" id="input-height" name="sections[cheight]" value="<?php echo $sections['cheight']; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                </div>
              </div>
              </div><!--//col --> 
          </div>
             
         <div class="form-group display otp-chat_box">
            <label class="col-sm-2 control-label" for="input-locale"><?php echo $entry_position; ?></label>
            <div class="col-sm-10">
                           
 <select name="sections[position]"class="form-control">
    <option value="base_parent"  <?php echo ('base_parent'==$sections['position'])?'selected="selected"':'';?>><?php echo $text_base_parent;?></option> 
    <option value="bottom_right"  <?php echo ('bottom_right'==$sections['position'])?'selected="selected"':'';?>><?php echo $text_bottom_right;?></option> 
    <option value="bottom_left"  <?php echo ('bottom_left'==$sections['position'])?'selected="selected"':'';?>><?php echo $text_bottom_left;?></option> 
            </select>
            
            </div>
          </div>        
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-locale"><?php echo $entry_locale; ?></label>
            <div class="col-sm-10">
                           
 <select name="sections[locale]"class="form-control">
              <?php foreach ($flangs as $value=>$label) { ?>
    <option value="<?php echo $value;?>"  <?php echo ($value==$sections['locale'])?'selected="selected"':'';?>><?php echo $label;?> - <?php echo $value;?></option> 
              <?php } ?>
            </select>
            
            </div>
          </div>
           <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_show_cover; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <input type="radio" name="sections[show_cover]" value="false" <?php echo ($sections['show_cover'] == 'false' ? 'checked="checked" ' : ''); ?>/>
                <?php echo $text_yes; ?>
              </label>
              <label class="radio-inline">
                <input type="radio" name="sections[show_cover]" value="true" <?php echo ($sections['show_cover'] == 'true' ? 'checked="checked" ' : ''); ?>/>
                <?php echo $text_no; ?>    
              </label>
            </div>
          </div>
          <div class="form-group display otp-fan_box">
            <label class="col-sm-2 control-label"><?php echo $entry_show_faces; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <input type="radio" name="sections[show_faces]" value="true" <?php echo ($sections['show_faces'] == 'true' ? 'checked="checked" ' : ''); ?>/>
                <?php echo $text_yes; ?>
              </label>
              <label class="radio-inline">
                <input type="radio" name="sections[show_faces]" value="false" <?php echo ($sections['show_faces'] == 'false' ? 'checked="checked" ' : ''); ?>/>
                <?php echo $text_no; ?>    
              </label>
            </div>
          </div>
          <div class="form-group display otp-fan_box">
            <label class="col-sm-2 control-label"><?php echo $entry_show_posts; ?></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <input type="radio" name="sections[show_posts]" value="true" <?php echo ($sections['show_posts'] == 'true' ? 'checked="checked" ' : ''); ?>/>
                <?php echo $text_yes; ?>
              </label>
              <label class="radio-inline">
                <input type="radio" name="sections[show_posts]" value="false" <?php echo ($sections['show_posts'] == 'false' ? 'checked="checked" ' : ''); ?>/>
                <?php echo $text_no; ?>    
              </label>
            </div>
          </div>
          