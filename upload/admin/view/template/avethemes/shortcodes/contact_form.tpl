      
     <table class="table table-bordered table-hover">
              <tr>
               
               <td width="150"><?php echo $entry_template;?> </td>
               <td>
 <select name="display" id="display" class="form-control">  
    <option value="contact_form" <?php echo ($display=='contact_form')?'selected="selected"':'';?>><?php echo $text_half_width;?></option> 
    <option value="contact_form_fullwidth" <?php echo ($display=='contact_form_fullwidth')?'selected="selected"':'';?>><?php echo $text_full_width;?></option> 
            </select>
                  </td></tr>
                    
              <tr><td width="150"><?php echo $text_title;?>:</td><td>
                <?php foreach ($languages as $language) {?>
<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <input type="text" name="sections[title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections['title'][$language['language_id']]) ? $sections['title'][$language['language_id']] : ''; ?>" class="form-control" /></div><?php } ?>
                  </td></tr>
                  
                  
              <tr><td width="150"><?php echo $text_description;?>:</td><td>
                <?php foreach ($languages as $language) {?>
<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <input type="text" name="sections[description][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections['description'][$language['language_id']]) ? $sections['description'][$language['language_id']] : ''; ?>" class="form-control" /></div><?php } ?>
                  </td></tr>
        
                  </table>