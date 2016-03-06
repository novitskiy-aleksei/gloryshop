     <table class="table table-bordered table-hover">
               <tr>
               
               <td width="150"><?php echo $entry_template;?> </td>
               <td>
 <select name="display" id="action_display" class="form-control tr_change with-nav" onchange="Plus.activeObj('action_display',this.options[this.selectedIndex].value);">  
    <option value="action_full_bg" <?php echo ($display=='action_full_bg')?'selected="selected"':'';?>><?php echo $text_full_bg;?></option>
    <option value="action_full_colored" <?php echo ($display=='action_full_colored')?'selected="selected"':'';?>><?php echo $text_full_colored;?></option>
    <option value="action_full_white" <?php echo ($display=='action_full_white')?'selected="selected"':'';?>><?php echo $text_full_white;?></option>
    <option value="action_boxed_colored" <?php echo ($display=='action_boxed_colored')?'selected="selected"':'';?>><?php echo $text_boxed_colored;?></option>
    <option value="action_boxed_white" <?php echo ($display=='action_boxed_white')?'selected="selected"':'';?>><?php echo $text_boxed_white;?></option>
    <option value="action_full_banner_colored" <?php echo ($display=='action_full_banner_colored')?'selected="selected"':'';?>><?php echo $text_full_banner_colored;?></option>
    <option value="action_classic_white" <?php echo ($display=='action_classic_white')?'selected="selected"':'';?>><?php echo $text_classic_white;?></option>
    <option value="action_full_gray" <?php echo ($display=='action_full_gray')?'selected="selected"':'';?>><?php echo $text_full_gray;?></option>
            </select>
                  </td></tr>
              <tr>
               
               <td width="150"></td>
               <td>
               <div style="max-width:600px;">
                <img src="../assets/editor/img/mockup/action_full_bg.png" class="img-responsive action_display otp-action_full_bg"/>
                <img src="../assets/editor/img/mockup/action_full_colored.png" class="img-responsive action_display otp-action_full_colored"/>
                <img src="../assets/editor/img/mockup/action_full_white.png" class="img-responsive action_display otp-action_full_white"/>
                <img src="../assets/editor/img/mockup/action_boxed_colored.png" class="img-responsive action_display otp-action_boxed_colored"/>
                <img src="../assets/editor/img/mockup/action_boxed_white.png" class="img-responsive action_display otp-action_boxed_white"/>
                <img src="../assets/editor/img/mockup/action_full_banner_colored.png" class="img-responsive action_display otp-action_full_banner_colored"/>
                <img src="../assets/editor/img/mockup/action_classic_white.png" class="img-responsive action_display otp-action_classic_white"/>
                <img src="../assets/editor/img/mockup/action_full_gray.png" class="img-responsive action_display otp-action_full_gray"/>
                </div>
                  </td></tr>
             
          
              
             
              <tr><td><?php echo $text_title;?>:</td><td>
                <?php foreach ($languages as $language) {?>
<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <input type="text" name="sections[title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections['title'][$language['language_id']]) ? $sections['title'][$language['language_id']] : ''; ?>" class="form-control" /></div><?php } ?>
                  </td></tr>
                  
  <tr><td><?php echo $text_description;?></td><td>
					<?php foreach ($languages as $language) { ?>
<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
<textarea name="sections[description][<?php echo $language['language_id']; ?>]" rows="6" class="form-control summernote" id="section-description<?php echo $language['language_id']; ?>"/><?php echo isset($sections['description'][$language['language_id']]) ? $sections['description'][$language['language_id']] : ''; ?></textarea></div>
				<?php } ?>		
    </td></tr>	
                    
                      
                     <tr><td><?php echo $text_link;?></td><td>
                     
                     <div class="row">
                     <div class="col-sm-2 col-xs-12">
                     <?php echo $text_icon;?><br> 
                     <div class="input-group">
          <a class="icon-preview">
         <i class="<?php echo $sections['icon'];?>" id="section_icon_thumb"></i>
         <input type="hidden" name="sections[icon]" value="<?php echo $sections['icon'];?>" id="section_icon" /></a> 
                <i class="fa fa-trash-o clear-ico"></i>
                </div>
                  </div>
                  
                  <div class="col-sm-3 col-xs-12">
                     <?php echo $text_button_title;?>
                   <?php foreach ($languages as $language) {?>
                <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <input type="text" name="sections[btn_title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections['btn_title'][$language['language_id']]) ? $sections['btn_title'][$language['language_id']] : ''; ?>" class="form-control" /></div>
              <?php } ?>
                  </div>
                     <div class="col-sm-4 col-xs-12">
                     <?php echo $text_button_link;?>
                  <input type="text" name="sections[btn_href]" id="[section][btn_href]" value="<?php echo $sections['btn_href']; ?>" class="form-control" />
                  </div>
                  
                  <div class="col-sm-3 col-xs-12">
                <?php echo $text_target;?></label><select name="sections[btn_target]" class="form-control">
                    <option value="_self" <?php if ($sections['btn_target']=='_self') { ?>selected="selected"<?php } ?>><?php echo $text_no;?></option>
                   <option value="_blank" <?php if ($sections['btn_target']=='_blank') { ?>selected="selected"<?php } ?>><?php echo $text_yes;?></option>
                   </select>
                   </div>
                   </div>
                  </td></tr>
              
                  
                  </table>
                  