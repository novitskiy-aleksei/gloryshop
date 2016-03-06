
 <input type="hidden" name="display" value="<?php echo $element;?>"/>
  <div class="clearfix">
          <table id="table-contact_info" class="table table-bordered table-hover">
                    <?php $section_row = 0;?>
                    <?php foreach ($sections as $section) {
                    if(!empty($section['title'])){ ?>
              <tbody id="section-tab<?php echo $section_row; ?>">
                <tr>
    <td colspan="2" class="heading-bar">  <?php echo $text_contact_line; ?> #<?php echo ($section_row+1); ?></td>
    </tr>
              <tr>
              <td>
              <div class="row">
              <div class="col-sm-4"><p><?php echo $text_title;?></p>
                <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
                  <input type="text" name="sections[<?php echo $section_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($section['title'][$language['language_id']]) ? $section['title'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
              </div>
              <div class="col-sm-8">
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
	html += '<?php echo $text_contact_line; ?> #' + parseInt(section_row+1);
	
         
	html += '    </td></tr>';     
		
	html += '    <tr><td>';
    html += '<div class="row">';
    html += '<div class="col-sm-4"><p><?php echo $text_title;?></p>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][title][<?php echo $language['language_id']; ?>]" class="form-control" value="Email: ' + parseInt(section_row+1) + '" /></div>';
				<?php } ?>
    html += '</div><div class="col-sm-8">';
    html += '<p><?php echo $text_description;?></p> ';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][desc][<?php echo $language['language_id']; ?>]" class="form-control" value="info@mail.com ' + parseInt(section_row+1) + '" /></div>';
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
   