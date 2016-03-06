
 <input type="hidden" name="display" value="<?php echo $element;?>"/>  
     <table class="table table-bordered table-hover">
             
              <tr><td width="150"><?php echo $text_description;?>:</td><td>
                <?php foreach ($languages as $language) {?>
<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <input type="text" name="sections[description][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections['description'][$language['language_id']]) ? $sections['description'][$language['language_id']] : ''; ?>" class="form-control" /></div><?php } ?>
                  </td></tr>
                  
     </table>
                  