     
 <input type="hidden" name="display" value="<?php echo $element;?>"/>  
     <table class="table table-bordered table-hover">
              
               <tr>
               
               <td width="150" valign="top"><?php echo $entry_poll;?> </td><td>
                     
               <?php if(count($polls)>0){?>
              <select name="sections[poll_id]" class="form-control">
                  <?php foreach ($polls as $poll) { ?>
<option value="<?php echo $poll['poll_id']; ?>" <?php if ($poll['poll_id']==$sections['poll_id']) { ?>selected="selected"<?php } ?>><?php echo $poll['question']; ?></option>
 					<?php } ?>
                </select>
                <?php }else{ ?><a onclick="location = '<?php echo $poll_insert; ?>';" class="btn btn-primary btn-sm"><?php echo $text_add_poll; ?></a> <?php }?>
                
                
                  </td></tr>
               <tr>
</table>
                  