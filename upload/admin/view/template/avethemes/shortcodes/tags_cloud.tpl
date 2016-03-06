
 <input type="hidden" name="display" value="<?php echo $element;?>"/>  
<table class="table table-bordered table-hover">
        <tr><td width="150"><?php echo $text_filter_from;?></td><td>
         <select name="sections[type]" class="form-control">
            <option value="product" <?php if ($sections['type']=='product') { ?>selected="selected"<?php } ?>><?php echo $text_product;?></option>
           <option value="blog" <?php if ($sections['type']=='blog') { ?>selected="selected"<?php } ?>><?php echo $text_blog;?></option>
           </select>
      </td>
      </tr>
        <tr><td width="150"><?php echo $text_limit;?></td><td>
         <input type="text" name="sections[limit]" class="form-control" value="<?php echo $sections['limit'];?>"/>
      </td>
      </tr>
          
</table>