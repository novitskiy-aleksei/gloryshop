 		<table class="table table-bordered table-hover">
        <style>
		.display{display:none;}
		</style>
                  
               <tr>
               
               <td width="150"><?php echo $entry_template;?> </td>
               <td>
 <select name="display" id="display" class="form-control tr_change with-nav" onchange="Plus.activeObj('display',this.options[this.selectedIndex].value);">  
    <option value="skill" <?php echo ($display=='skill')?'selected="selected"':'';?>><?php echo $text_style;?> 1</option> 
    <option value="skill2" <?php echo ($display=='skill2')?'selected="selected"':'';?>><?php echo $text_style;?> 2</option> 
    <option value="skill3" <?php echo ($display=='skill3')?'selected="selected"':'';?>><?php echo $text_style;?> 3</option> 
    <option value="skill4" <?php echo ($display=='skill4')?'selected="selected"':'';?>><?php echo $text_style;?> 4</option> 
    <option value="skill5" <?php echo ($display=='skill5')?'selected="selected"':'';?>><?php echo $text_style;?> 5</option> 
            </select>
                  </td></tr>
              <tr>
               <td width="150"></td>
               <td>
               <div style="max-width:600px;">
                <img src="../assets/editor/img/mockup/skill.png" class="img-responsive display otp-skill"/>
                <img src="../assets/editor/img/mockup/skill2.png" class="img-responsive display otp-skill2"/>
                <img src="../assets/editor/img/mockup/skill3.png" class="img-responsive display otp-skill3"/>
                <img src="../assets/editor/img/mockup/skill4.png" class="img-responsive display otp-skill4"/>
                <img src="../assets/editor/img/mockup/skill5.png" class="img-responsive display otp-skill5"/>
                </div>
                  </td>
              </tr>
              
          	<tr class="display otp-skill otp-skill2">
               <td width="150"><?php echo $entry_grid_limit; ?> </td>
               <td>   <select name="grid_limit" class="form-control">   
                  <option value="6" <?php echo($grid_limit=='6')?'selected="selected"':''; ?>>2</option>
                  <option value="4" <?php echo($grid_limit=='4')?'selected="selected"':''; ?>>3</option>
                  <option value="3" <?php echo($grid_limit=='3')?'selected="selected"':''; ?>>4</option>               
                </select> 
                  </td></tr>
                  
          	<tr class="display otp-skill3 otp-skill4">
               <td width="150"><?php echo $text_desc_position; ?> </td>
               <td>   <select name="desc_position" class="form-control">   
                  <option value="left" <?php echo($desc_position=='left')?'selected="selected"':''; ?>><?php echo $text_left;?></option>
                  <option value="right" <?php echo($desc_position=='right')?'selected="selected"':''; ?>><?php echo $text_right;?></option>           
                </select> 
                  </td></tr>
                  
              <tr class="display otp-skill3 otp-skill4 otp-skill">
               <td width="150"><?php echo $text_skill_desc;?></td>
               <td><?php foreach ($languages as $language) { ?>
<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
<textarea name="description[<?php echo $language['language_id']; ?>]" class="form-control summernote" id="skill-description<?php echo $language['language_id']; ?>"/><?php echo isset($description[$language['language_id']]) ? $description[$language['language_id']] : ''; ?></textarea></div>
				<?php } ?>		
                </div>
                  </td>
              </tr>
              
              <tr class="display otp-skill3">
               <td width="150"><?php echo $text_skill_title;?></td>
               <td><?php foreach ($languages as $language) { ?>
<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
<input type="text" name="skill_title[<?php echo $language['language_id']; ?>]" class="form-control" id="skill_title<?php echo $language['language_id']; ?>" value="<?php echo isset($skill_title[$language['language_id']]) ? $skill_title[$language['language_id']] : ''; ?>"/></div>
				<?php } ?>		
                </div>
                  </td>
              </tr>
              
               
              
             </table>
             
           <div class="clearfix">
                <table id="table_skill" class="table table-bordered table-hover">  
                
                 <?php $section_row = 0;?>
                    <?php foreach ($sections as $section) {
                    if(!empty($section['title'])){ ?>
               <tbody id="section-tab<?php echo $section_row; ?>">
                    <tr>
    <td colspan="2" class="heading-bar">  <?php echo $text_skill; ?> #<?php echo ($section_row+1); ?></td>
    </tr>
    
     <tr><td>
                   <div class="row">
                     <div class="col-sm-3"><?php echo $text_percent;?>
                     
                  <input type="text" name="sections[<?php echo $section_row; ?>][percent]" value="<?php echo $section['percent']; ?>" class="form-control" />
                     
                     </div>
                  
                  <div class="col-sm-6"><?php echo $text_title;?>
            <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($section['title'][$language['language_id']]) ? $section['title'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                   </div>
                     <div class="col-sm-3"><?php echo $text_progess_color;?>
                  <input type="text" name="sections[<?php echo $section_row; ?>][color]" value="<?php echo $section['color']; ?>" class="form-control colorpicker" />
                  </div>
                    
                   </div>
                   
                  </td>
                  
                   <td>
                  <a class="btn btn-danger" onclick="removeSection(<?php echo $section_row; ?>)"> <i class="fa fa-minus-circle"></i>   <?php echo $button_remove; ?> </a>
                    </td>
                  </tr>
    
    
    
                  
              <tr>
              <td><?php echo $text_progess_color;?>:</td>
              <td>
               
                  </td></tr>
                  
             
                  
                 
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
	html += '<?php echo $text_skill; ?> #' + parseInt(section_row+1);         
	html += '    </td></tr>';     
		
		
	html += '<tr><td>';
                     
	html += '<div class="row">';
	html += '<div class="col-sm-3"><?php echo $text_percent;?>';
	html += '<input type="text" name="sections[' + section_row + '][percent]" value="99" class="form-control" />';
	
	html += '</div>';
	html += '<div class="col-sm-6"><?php echo $text_title;?>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][title][<?php echo $language['language_id']; ?>]" class="form-control" value="Tabs ' + parseInt(section_row+1) + '" /></div>';
				<?php } ?>
	html += '</div>';
	html += '<div class="col-sm-3"><?php echo $text_progess_color;?>';
	html += '<input type="text" name="sections[' + section_row + '][color]" value="" class="form-control colorpicker" />';
	html += '</div>';
                  
                   
	html += '</div>';
	html += '</td>';
    html += '<td><a class="btn btn-danger" onclick="removeSection(' + section_row + ')"> <i class="fa fa-minus-circle"></i>   <?php echo $button_remove; ?> </a></td>';	
	html += '</tr>';
		
	html += '    	</tbody>';
	
	$('#table_skill tfoot').before(html);
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});
		
		
	section_row++;
			Plus.handleColorpicker();
	$('#add_section').attr('data-section',parseInt(section_row));
}

   // html += '<td><a class="btn btn-danger" onclick="removeSection(' + section_row + ')"> <i class="fa fa-minus-circle"></i>   <?php echo $button_remove; ?> </a></td>';	
//--></script> 
   
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
	$('#skill-description<?php echo $language['language_id']; ?>').summernote({height: 400});
<?php } ?>
//--></script> 