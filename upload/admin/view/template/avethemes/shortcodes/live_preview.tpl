
 <input type="hidden" name="display" value="<?php echo $element;?>"/>
  		<table class="table table-bordered table-hover">
          	<tr>
               <td width="150"><?php echo $entry_grid_limit; ?> </td>
               <td>   <select name="grid_limit" class="form-control">   
                  <option value="6" <?php echo($grid_limit=='6')?'selected="selected"':''; ?>>2</option>
                  <option value="4" <?php echo($grid_limit=='4')?'selected="selected"':''; ?>>3</option>
                  <option value="3" <?php echo($grid_limit=='3')?'selected="selected"':''; ?>>4</option>               
                </select> 
                  </td></tr>
             </table>
  <div class="clearfix">
          <table id="table-contact_info" class="table table-bordered table-hover">
                    <?php $section_row = 0;?>
                    <?php foreach ($sections as $section) {
                    if(!empty($section['title'])){ ?>
              <tbody id="section-tab<?php echo $section_row; ?>">
                <tr>
    <td colspan="2" class="heading-bar">  <?php echo $text_demo; ?> #<?php echo ($section_row+1); ?></td>
    </tr>
    
               <tr><td>
                   <div class="row">
                     <div class="col-sm-2"><?php echo $text_image;?>
                     
            <a onclick="image_upload('section_image<?php echo $section_row;?>','thumb-thumb<?php echo $section_row;?>');" id="thumb-thumb<?php echo $section_row;?>" class="img-thumbnail">
            <img src="<?php echo (!empty($section['image']))?'../image/'.$section['image']:$placeholder;?>" alt="" title="" data-placeholder="<?php echo (!empty($section['image']))?'../image/'.$section['image']:$placeholder;?>" id="section_image_thumb<?php echo $section_row;?>"/></a>
            <input type="hidden" name="sections[<?php echo $section_row; ?>][image]" value="<?php echo $section['image'];?>" id="section_image<?php echo $section_row;?>"/>
                  
                     </div>
                     <div class="col-sm-4"><?php echo $text_link;?>
                  <input type="text" name="sections[<?php echo $section_row; ?>][href]" value="<?php echo $section['href']; ?>" class="form-control" />
                  </div>
                     <div class="col-sm-4">Admin <?php echo $text_link;?> 
                  <input type="text" name="sections[<?php echo $section_row; ?>][admin]" value="<?php echo $section['admin']; ?>" class="form-control" />
                  </div>
                  
                  <div class="col-sm-2"><?php echo $text_target;?>
                <select name="sections[<?php echo $section_row; ?>][target]" class="form-control">
                    <option value="_self" <?php if ($section['target']=='_self') { ?>selected="selected"<?php } ?>><?php echo $text_no;?></option>
                   <option value="_blank" <?php if ($section['target']=='_blank') { ?>selected="selected"<?php } ?>><?php echo $text_yes;?></option>
                   </select>
                   </div>
                   </div>
                   
                  </td>
                  
                  
                  </tr>
                  
              <tr>
              <td>
              <div class="row">
              <div class="col-sm-6"><p><?php echo $text_title;?></p>
                <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
                  <input type="text" name="sections[<?php echo $section_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($section['title'][$language['language_id']]) ? $section['title'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
              </div>
              
              <div class="col-sm-6">
              <p><?php echo $text_description;?></p> 
               <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
                  <input type="text" name="sections[<?php echo $section_row; ?>][desc][<?php echo $language['language_id']; ?>]" value="<?php echo isset($section['desc'][$language['language_id']]) ? $section['desc'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
              </div>
              
              </div>
              
                  </td>
                   <td>
                  <a class="btn btn-danger" onclick="removeSection(<?php echo $section_row; ?>)"> <i class="fa fa-minus-circle"></i>   <?php echo $button_remove; ?> </a>
                    </td>
                  </tr>
                  
              <tr>
             </tbody>
                  
                    <?php }
                    $section_row++; ?>
                    <?php } ?> 
               
                  <tfoot>
            <tr>
            <td class="text-right" colspan="2"> <a class="btn btn-primary" onclick="addSection()"> <i class="fa fa-plus-circle"></i> <?php echo $button_add; ?></a></td>
            </tr>
            </tfoot>
                 </table>
                 </div>
                    

      <div id="add_section" data-section="<?php echo $section_row;?>"></div>
      
<script type="text/javascript"><!--
var section_row;
function addSection() {
	data_section = $('#add_section').attr('data-section');
	section_row = parseInt(data_section);
	html = '<tbody id="section-tab' + section_row + '">';
	
	html += '    <tr><td colspan="2" class="heading-bar">';
	html += '<?php echo $text_demo; ?> #' + parseInt(section_row+1);         
	html += '    </td></tr>';     
		
		
		html += '<tr><td>';
                     
	html += '<div class="row">';
	html += '<div class="col-sm-2"><?php echo $text_image;?>';
	
    html += '<a onclick="image_upload(\'section_image' + section_row + '\',\'thumb-thumb' + section_row + '\');" id="thumb-thumb' + section_row + '" class="img-thumbnail">';
    html += '<img src="<?php echo $placeholder;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>" id="section_image_thumb' + section_row + '"/>';
    html += '</a><input type="hidden" name="sections[' + section_row + '][image]" value="<?php echo $placeholder;?>" id="section_image' + section_row + '"/>';
	
	html += '</div>';
	html += '<div class="col-sm-4"><?php echo $text_link;?>';
	html += '<input type="text" name="sections[' + section_row + '][href]" value="" class="form-control" />';
	html += '</div>';
	html += '<div class="col-sm-4"><?php echo $text_link;?> Admin';
	html += '<input type="text" name="sections[' + section_row + '][admin]" value="" class="form-control" />';
	html += '</div>';
                  
                  
	html += '<div class="col-sm-2"><?php echo $text_target;?>';
	html += '<select name="sections[' + section_row + '][target]" class="form-control">';
	html += '<option value="_self"><?php echo $text_no;?></option>';
	html += '<option value="_blank"><?php echo $text_yes;?></option>';
	html += '</select>';
                   
	html += ' </div></div>';
	html += '</td></tr>';
	
	
	html += '    <tr><td>';
    html += '<div class="row">';
    html += '<div class="col-sm-6"><p><?php echo $text_title;?></p>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][title][<?php echo $language['language_id']; ?>]" class="form-control" value="Demo ' + parseInt(section_row+1) + '" /></div>';
				<?php } ?>
    html += '</div><div class="col-sm-6">';
    html += '<p><?php echo $text_description;?></p> ';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][desc][<?php echo $language['language_id']; ?>]" class="form-control" value="demo/demo" /></div>';
				<?php } ?>
    html += '</div>';
	
    html += '</div>';
    html += '</td><td>';
    html += '<a class="btn btn-danger" onclick="removeSection(' + section_row + ')"> <i class="fa fa-minus-circle"></i>   <?php echo $button_remove; ?> </a>';
	html += '    </td></tr>';	
	
	html += '    	</tbody>';
	
	$('#table-contact_info tfoot').before(html);
		
	section_row++;
	$('#add_section').attr('data-section',parseInt(section_row));
}

//--></script> 
   