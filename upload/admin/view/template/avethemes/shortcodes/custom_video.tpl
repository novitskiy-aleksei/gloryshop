
 <input type="hidden" name="display" value="<?php echo $element;?>"/> 
     <table class="table table-bordered table-hover">
              
              <tr><td width="150"><?php echo $entry_title;?>:</td><td>
                <?php foreach ($languages as $language) {?>
<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <input type="text" name="sections[title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections['title'][$language['language_id']]) ? $sections['title'][$language['language_id']] : ''; ?>" class="form-control" /></div><?php } ?>
                  </td></tr>
               <tr>
               
               <td width="150"><?php echo $text_image;?> </td><td>
            <a onclick="image_upload('section_image','thumb-thumb');" id="thumb-thumb" class="img-thumbnail">
            <img src="<?php echo (!empty($sections['image']))?'../image/'.$sections['image']:$placeholder;?>" alt="" title="" data-placeholder="<?php echo (!empty($sections['image']))?'../image/'.$sections['image']:$placeholder;?>" id="section_image_thumb"/></a>
            <input type="hidden" name="sections[image]" value="<?php echo $sections['image'];?>" id="section_image"/>
                   
                      
                  </td></tr>
               <tr>
               
             
        <tr><td width="150"><?php echo $text_video_type;?></td><td>
         <select name="sections[type]" class="form-control tr_change with-nav" onchange="Plus.activeObj('video_type',this.options[this.selectedIndex].value);">
           <option value="youtube" <?php if ($sections['type']=='youtube') { ?>selected="selected"<?php } ?>>Youtube</option>
            <option value="vimeo" <?php if ($sections['type']=='vimeo') { ?>selected="selected"<?php } ?>>Vimeo</option>
       </select>
      </td>
      </tr>
          
              <tr class="video_type otp-vimeo">
              <td width="150"><?php echo $text_video_url;?>:</td><td>
                  <input type="text" name="sections[vimeo_href]" value="<?php echo $sections['vimeo_href']; ?>" class="form-control" />
              
              </td></tr>
                  
                  
              <tr class="video_type otp-youtube">
              <td width="150"><?php echo $text_video_url;?>:</td><td>
                  <input type="text" name="sections[youtube_href]" value="<?php echo $sections['youtube_href']; ?>" class="form-control" />
              
              </td></tr>
             
                  
                  </table>
                  