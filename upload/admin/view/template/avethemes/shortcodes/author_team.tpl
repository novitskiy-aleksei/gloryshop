
 		<table class="table table-bordered table-hover">
               <tr>
               
               <td width="150"><?php echo $entry_template;?> </td>
               <td>
 <select name="display" id="display" class="form-control tr_change with-nav" onchange="Plus.activeObj('display',this.options[this.selectedIndex].value);">  
    <option value="author_list" <?php echo ($display=='author_list')?'selected="selected"':'';?>><?php echo $text_list;?></option> 
    <option value="author_dropdown" <?php echo ($display=='author_dropdown')?'selected="selected"':'';?>><?php echo $text_dropdown;?></option>  
    <option value="author_carousel" <?php echo ($display=='author_carousel')?'selected="selected"':'';?>><?php echo $text_carousel;?></option> 
    <option value="author_featured" <?php echo ($display=='author_featured')?'selected="selected"':'';?>><?php echo $text_featured_author;?></option> 
    <option value="author_profile" <?php echo ($display=='author_profile')?'selected="selected"':'';?>><?php echo $text_profile;?></option> 
    <option value="author_profile2" <?php echo ($display=='author_profile2')?'selected="selected"':'';?>><?php echo $text_profile;?> 2</option> 
            </select>
                  </td></tr>
              <tr>
               
               <td width="150"></td>
               <td>
               <div style="max-width:600px;">
                <img src="../assets/editor/img/mockup/author_list.png" class="display otp-author_list"/>
                <img src="../assets/editor/img/mockup/author_dropdown.png" class="display otp-author_dropdown"/>
                <img src="../assets/editor/img/mockup/author_featured.png" class="display otp-author_featured"/>
                <img src="../assets/editor/img/mockup/author_carousel.png" class="display otp-author_carousel"/>
                <img src="../assets/editor/img/mockup/author_profile.png" class="display otp-author_profile"/>
                <img src="../assets/editor/img/mockup/author_profile2.png" class="display otp-author_profile2"/>
                </div>
                  </td>
                  </tr>
                    <tr class="display otp-author_featured">
                  <td><?php echo $entry_choose_author;?></td><td>
              <select name="sections[author_id]" class="form-control">
                                <?php                              
                                 foreach ($authors as $author) { ?>
<option value="<?php echo $author['author_id']; ?>" <?php if ($author['author_id']==$sections['author_id']) { ?>selected="selected"<?php } ?>><?php echo $author['author']; ?></option>
                                <?php } ?>		
                </select>
                    </td>
                </tr>	                   
               <tr class="display otp-author_carousel otp-author_profile otp-author_profile2">
                  <td><?php echo $text_description;?></td><td>
                                    <?php foreach ($languages as $language) { ?>
                <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                <textarea name="sections[description][<?php echo $language['language_id']; ?>]" rows="4" class="form-control" id="section-description<?php echo $language['language_id']; ?>"/><?php echo isset($sections['description'][$language['language_id']]) ? $sections['description'][$language['language_id']] : ''; ?></textarea></div>
                                <?php } ?>		
                    </td>
                </tr>	
    
             </table>