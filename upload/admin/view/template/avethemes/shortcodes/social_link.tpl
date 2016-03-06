
 <input type="hidden" name="display" value="<?php echo $element;?>"/>
  <div class="clearfix">
          <table id="table-contact_info" class="table table-bordered table-hover">
                    <?php $section_row = 0;?>
                    <?php foreach ($sections as $section) {
                    if(!empty($section['title'])){ ?>
              <tbody id="section-tab<?php echo $section_row; ?>">
                <tr>
    <td colspan="2" class="heading-bar">  <?php echo $text_link; ?> #<?php echo ($section_row+1); ?></td>
    </tr>
    
               <tr><td>
                   <div class="row">
                     <div class="col-sm-2"><?php echo $text_icon;?>
                     
          
                     <div class="input-group">
          <a class="icon-preview">
         <i class="<?php echo $section['icon'];?>" id="section_icon_thumb<?php echo $section_row; ?>"></i>
         <input type="hidden" name="sections[<?php echo $section_row; ?>][icon]" value="<?php echo $section['icon'];?>" id="section_icon<?php echo $section_row; ?>" /></a> 
                <i class="fa fa-trash-o clear-ico"></i>
                </div>
                     
                     </div>
                     <div class="col-sm-3"><?php echo $text_title;?>
                  <input type="text" name="sections[<?php echo $section_row; ?>][title]" value="<?php echo $section['title']; ?>" class="form-control" />
                  </div>
                     <div class="col-sm-4"><?php echo $text_link;?>
                  <input type="text" name="sections[<?php echo $section_row; ?>][href]" value="<?php echo $section['href']; ?>" class="form-control" />
                  </div>
                  
                  <div class="col-sm-3"><?php echo $text_target;?>
                <select name="sections[<?php echo $section_row; ?>][target]" class="form-control">
                    <option value="_self" <?php if ($section['target']=='_self') { ?>selected="selected"<?php } ?>><?php echo $text_no;?></option>
                   <option value="_blank" <?php if ($section['target']=='_blank') { ?>selected="selected"<?php } ?>><?php echo $text_yes;?></option>
                   </select>
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
	html += '<?php echo $text_link; ?> #' + parseInt(section_row+1);         
	html += '    </td></tr>';     
		
		
		html += '<tr><td>';
                     
	html += '<div class="row">';
	html += '<div class="col-sm-2"><?php echo $text_icon;?>';
	html += '<div class="input-group"><a class="icon-preview">';
	html += '<i class="fa fa-rocket" id="section_icon_thumb' + section_row + '"></i>';
	html += '<input type="hidden" name="sections[' + section_row + '][icon]" value="fa fa-rocket" id="section_icon' + section_row + '" /></a> ';
	html += '<i class="fa fa-trash-o clear-ico"></i>';
	html += '</div>';
	
	html += '</div>';
	html += '<div class="col-sm-3"><?php echo $text_title;?>';
	html += '<input type="text" name="sections[' + section_row + '][title]" value="" class="form-control" />';
	html += '</div>';
	html += '<div class="col-sm-4"><?php echo $text_link;?>';
	html += '<input type="text" name="sections[' + section_row + '][href]" value="" class="form-control" />';
	html += '</div>';
                  
	html += '<div class="col-sm-3"><?php echo $text_target;?>';
	html += '<select name="sections[' + section_row + '][target]" class="form-control">';
	html += '<option value="_blank"><?php echo $text_yes;?></option>';
	html += '<option value="_self"><?php echo $text_no;?></option>';
	html += '</select>';
                   
	html += ' </div></div>';
	html += '</td>';
    html += '<td><a class="btn btn-danger" onclick="removeSection(' + section_row + ')"> <i class="fa fa-minus-circle"></i>   <?php echo $button_remove; ?> </a></td>';	
	html += '</tr>';
	
	
	
	html += '    	</tbody>';
	
	$('#table-contact_info tfoot').before(html);
		
	section_row++;
	$('#add_section').attr('data-section',parseInt(section_row));
}

//--></script> 
   