
 <input type="hidden" name="display" value="<?php echo $element;?>"/> 
<table class="table table-bordered table-hover">
     <tr>
           <td width="150" valign="top"><?php echo $entry_slider;?> </td><td>
                 
           <?php if(count($revosliders)>0){?>
          <select name="sections[primary_id]" class="form-control">
              <?php foreach ($revosliders as $slider) { ?>
<option value="<?php echo $slider['primary_id']; ?>" <?php if ($slider['primary_id']==$sections['primary_id']) { ?>selected="selected"<?php } ?>><?php echo $slider['title']; ?></option>
                <?php } ?>
            </select>
            <?php }else{ ?><a onclick="location = '<?php echo $insert_slider; ?>';" class="btn btn-primary btn-sm"><?php echo $text_add_slider; ?></a> <?php }?>
            
            
              </td></tr>
           <tr>
</table>
                  