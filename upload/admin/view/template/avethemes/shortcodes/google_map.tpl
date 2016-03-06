
     <table class="table table-bordered table-hover">
              
                
        <tr><td width="150"><?php echo $entry_display;?></td><td>
         <select name="display" class="form-control tr_change with-nav" onchange="Plus.activeObj('display',this.options[this.selectedIndex].value);">
           <option value="map_boxed" <?php if ($display=='map_boxed') { ?>selected="selected"<?php } ?>><?php echo $text_boxed;?></option>
           <option value="map_fullwidth" <?php if ($display=='map_fullwidth') { ?>selected="selected"<?php } ?>><?php echo $text_fullwidth;?></option>
           <option value="map_popup" <?php if ($display=='map_popup') { ?>selected="selected"<?php } ?>><?php echo $text_popup_map;?></option>
       </select>
      </td>
      </tr>
       <td width="150"></td>
               <td>
               <div style="max-width:600px;">
                <img src="../assets/editor/img/mockup/map_boxed.png" class="display otp-map_boxed"/>
                <img src="../assets/editor/img/mockup/map_fullwidth.png" class="display otp-map_fullwidth"/>
                <img src="../assets/editor/img/mockup/map_popup.png" class="display otp-map_popup"/>
                </div>
                  </td>
                  </tr>
         
        <tr><td width="150"><?php echo $text_min_height;?></td><td>
        <input type="text" name="sections[height]" value="<?php echo $sections['height']; ?>" class="form-control" />
      </td>
      </tr>
              <tr><td width="150"><?php echo $text_latitude;?>:</td><td>
            <a class="btn btn-primary btn-xs pull-right" href="http://itouchmap.com/latlong.html" target="_blank">Find your store coordinates</a>    <br/> 
                  <input type="text" name="sections[latitude]" value="<?php echo $sections['latitude']; ?>" class="form-control" />
              
                  </td></tr>
                  
                  
             
              <tr><td><?php echo $text_longitude;?>:</td><td>
                  <input type="text" name="sections[longitude]" value="<?php echo $sections['longitude']; ?>" class="form-control" />
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
             
                  
                  </table>
                  