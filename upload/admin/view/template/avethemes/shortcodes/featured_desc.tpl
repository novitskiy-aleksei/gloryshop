     <table class="table table-bordered table-hover">
          	<tr>
               <td width="150"><?php echo $text_desc_position; ?> </td>
               <td>   <select name="desc_position" class="form-control">   
                  <option value="left" <?php echo($desc_position=='left')?'selected="selected"':''; ?>><?php echo $text_left;?></option>
                  <option value="right" <?php echo($desc_position=='right')?'selected="selected"':''; ?>><?php echo $text_right;?></option>           
                </select> 
                  </td>
                  </tr>
              <tr>
               
               <td width="150"><?php echo $entry_template;?> </td>
               <td>
 <select name="display" id="display" class="form-control tr_change with-nav" onchange="Plus.activeObj('display',this.options[this.selectedIndex].value);">  
    <option value="featured_desc" <?php echo ($display=='featured_desc')?'selected="selected"':'';?>><?php echo $text_style;?> 1</option> 
    <option value="featured_desc2" <?php echo ($display=='featured_desc2')?'selected="selected"':'';?>><?php echo $text_style;?> 2</option> 
            </select>
                  </td></tr>
              <tr>
               <td width="150"></td>
               <td>
               <div style="max-width:600px;">
                <img src="../assets/editor/img/mockup/featured_desc.png" class="img-responsive display otp-featured_desc" style="display:none;"/>
                <img src="../assets/editor/img/mockup/featured_desc2.png" class="img-responsive display otp-featured_desc2" style="display:none;"/>
                </div>
                  </td></tr>
                  
               <tr style="display:none;" class="display otp-featured_desc">
               
               <td width="150"><?php echo $text_image;?> </td><td>
            <a onclick="image_upload('section_image','thumb-thumb');" id="thumb-thumb" class="img-thumbnail">
            <img src="<?php echo (!empty($sections['image']))?'../image/'.$sections['image']:$placeholder;?>" alt="" title="" data-placeholder="<?php echo (!empty($sections['image']))?'../image/'.$sections['image']:$placeholder;?>" id="section_image_thumb"/></a>
            <input type="hidden" name="sections[image]" value="<?php echo $sections['image'];?>" id="section_image"/>
                   
                      
                  </td></tr>
               <tr>
                  
               <td width="150"><?php echo $text_icon;?> </td><td>
                   
          <a class="icon-preview">
         <i class="<?php echo $sections['icon'];?>" id="section_icon_thumb"></i>
         <input type="hidden" name="sections[icon]" value="<?php echo $sections['icon'];?>" id="section_icon" /></a> 
                <i class="fa fa-trash-o clear-ico"></i>
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
             
                  
                  
                <?php $i =1;
                 foreach ($sections['features'] as $feature) { ?>
                 
                    <tr>
                    <td><?php echo $text_feature.''.$i;?>:</td>
                    <td>
                                    <?php foreach ($languages as $language) {
                                    
                                    
                                    ?>
                        
                <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                          <input type="text" name="sections[features][<?php echo $i;?>][<?php echo $language['language_id']; ?>]" value="<?php echo isset($feature[$language['language_id']]) ? $feature[$language['language_id']] : ''; ?>" class="form-control" />
                     
                     </div><?php } ?>
                          </td>
                          </tr>
            
                  	<?php
                    $i++;
                     } ?>		
                    
                      
                     <tr><td><?php echo $text_link;?> 1</td><td>
                     
                     <div class="row">
                  <div class="col-sm-4 col-xs-12">
                     <?php echo $text_button_title;?>
                   <?php foreach ($languages as $language) {?>
                <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <input type="text" name="sections[btn_title1][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections['btn_title1'][$language['language_id']]) ? $sections['btn_title1'][$language['language_id']] : ''; ?>" class="form-control" /></div>
              <?php } ?>
                  </div>
                     <div class="col-sm-4 col-xs-12">
                     <?php echo $text_button_link;?>
                  <input type="text" name="sections[btn_href1]" id="[section][btn_href1]" value="<?php echo $sections['btn_href1']; ?>" class="form-control" />
                  </div>
                  
                  <div class="col-sm-4 col-xs-12">
                <?php echo $text_target;?></label><select name="sections[btn_target1]" class="form-control">
                    <option value="_self" <?php if ($sections['btn_target1']=='_self') { ?>selected="selected"<?php } ?>><?php echo $text_no;?></option>
                   <option value="_blank" <?php if ($sections['btn_target1']=='_blank') { ?>selected="selected"<?php } ?>><?php echo $text_yes;?></option>
                   </select>
                   </div>
                   </div>
                  </td></tr>
                    <tr><td><?php echo $text_link;?> 2</td><td>
                     
                     <div class="row">
                      <div class="col-sm-4 col-xs-12">
                     <?php echo $text_button_title;?>
                   <?php foreach ($languages as $language) {?>
                <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <input type="text" name="sections[btn_title2][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections['btn_title2'][$language['language_id']]) ? $sections['btn_title2'][$language['language_id']] : ''; ?>" class="form-control" /></div>
              <?php } ?>
                  </div>
                  
                     <div class="col-sm-4 col-xs-12">
                     <?php echo $text_button_link;?>
                  <input type="text" name="sections[btn_href2]" id="[section][btn_href2]" value="<?php echo $sections['btn_href2']; ?>" class="form-control" />
                  </div>
                 
                  <div class="col-sm-4 col-xs-12">
                <?php echo $text_target;?></label><select name="sections[btn_target2]" class="form-control">
                    <option value="_self" <?php if ($sections['btn_target2']=='_self') { ?>selected="selected"<?php } ?>><?php echo $text_no;?></option>
                   <option value="_blank" <?php if ($sections['btn_target2']=='_blank') { ?>selected="selected"<?php } ?>><?php echo $text_yes;?></option>
                   </select>
                   </div>
                   </div>
                  </td></tr>
                  
                  </table>
                  
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
	$('#section-description<?php echo $language['language_id']; ?>').summernote({height: 200});
<?php } ?>
//--></script> 