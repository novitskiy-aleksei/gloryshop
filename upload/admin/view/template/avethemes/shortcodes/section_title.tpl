
 <input type="hidden" name="display" value="<?php echo $element;?>"/>  
     <table class="table table-bordered table-hover">
                     
                    <tr><td width="150"><?php echo $text_title_color;?></td><td>
                     <select name="sections[title_color]" class="form-control">
                   <option value="" <?php if ($sections['title_color']=='') { ?>selected="selected"<?php } ?>><?php echo $text_dark;?></option>
                    <option value="white_section" <?php if ($sections['title_color']=='white_section') { ?>selected="selected"<?php } ?>><?php echo $text_light;?></option>
                   </select>
                  </td>
                  </tr>
                  
                    
                    <tr><td width="150"><?php echo $text_show_icon;?></td><td>
                     <select name="sections[show_icon]" class="form-control">
                    <option value="0" <?php if ($sections['show_icon']=='0') { ?>selected="selected"<?php } ?>><?php echo $text_no;?></option>
                   <option value="1" <?php if ($sections['show_icon']=='1') { ?>selected="selected"<?php } ?>><?php echo $text_yes;?></option>
                   </select>
                  </td></tr>
                  
</table>