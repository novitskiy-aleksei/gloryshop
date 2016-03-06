 <input type="hidden" name="display" value="<?php echo $element;?>"/>  
<table class="table table-bordered table-hover">
               <tr>
               <td width="150"><?php echo $entry_heading_size;?> </td>
               <td>
 <select name="heading_size" class="form-control">  
    <option><?php echo $text_inherit;?></option> 
    <option value="small" <?php echo ($heading_size=='small')?'selected="selected"':'';?>><?php echo $text_small;?></option> 
            </select>
                  </td>
                  </tr>
              </table>
           <div class="row">
                <div class="col-sm-2 col-xs-12 pull-right">
                 <ul class="nav nav-pills nav-stacked" id="section_nav">
                    <?php $section_row = 0; ?>
                    <?php 
                    foreach ($sections as $section) {
                    if(!empty($section['title'])){
                      ?>
                    <li class="<?php echo ($section_row==0)?'active':'';?>">
                    <a href="#section-tab<?php echo $section_row; ?>" data-toggle="tab"><i class="icon-left fa fa-copy" onclick="cloneSection(<?php echo $section_row; ?>)" data-toggle="tooltip" title="<?php echo $text_copy_section;?>"></i>  <?php echo $text_tab; ?> #<?php echo $section_row+1;?> <i class="icon-right fa fa-minus-circle" onclick="removeSection(<?php echo $section_row; ?>)"></i> </a>
                    </li>
                    <?php
                    }
                     $section_row++; ?>
                    <?php } ?>
                    <li>
                      <a data-toggle="tab" onclick="addSection()" style="background-color: #8fbb6c; color:#fff;text-align:right;"><?php echo $button_add; ?> <i class="fa fa-plus-circle"></i> </a>
                    </li>
                  </ul>
                  
          		</div><!--//col --> 
                
                <div class="col-sm-10 col-xs-12">
                 <div class="tab-content" id="section-tab">
                    <?php $section_row = 0;?>
                    <?php foreach ($sections as $section) {
                    if(!empty($section['title'])){ ?>
                    <div class="tab-pane <?php echo ($section_row==0)?'active':'';?>" id="section-tab<?php echo $section_row; ?>">
	<div class="heading-bar"> <?php echo $text_tab; ?> #<?php echo ($section_row+1); ?></div>
                    <div>
                <table class="table table-bordered table-hover">
              
               <tr><td width="150"><?php echo $text_icon;?> </td><td>
          <a class="icon-preview">
         <i class="<?php echo $section['icon'];?>" id="section_icon_thumb<?php echo $section_row;?>"></i>
         <input type="hidden" name="sections[<?php echo $section_row; ?>][icon]" value="<?php echo $section['icon'];?>" id="section_icon<?php echo $section_row;?>" /></a> 
          <i class="fa fa-trash-o clear-ico"></i>
                      
                  </td></tr>
             
             
              <tr><td><?php echo $text_title;?>:</td><td>
                <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['title'][$language['language_id']]) ? $sections[$section_row]['title'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
                  
              <tr>
              <td><?php echo $text_description;?>:</td><td>
                <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
                  <textarea  id="section-description-<?php echo $section_row; ?>-<?php echo $language['language_id']; ?>" name="sections[<?php echo $section_row; ?>][description][<?php echo $language['language_id']; ?>]" class="form-control summernote"><?php echo isset($sections[$section_row]['description'][$language['language_id']]) ? $sections[$section_row]['description'][$language['language_id']] : ''; ?></textarea>
              </div><?php } ?>
                  </td></tr>
                  
             
    
                 </table>
                 </div>
                    
                    </div><!--//tab-pane -->
                    <script type="text/javascript"><!--
					<?php foreach ($languages as $language) { ?>
						$('#section-description-<?php echo $section_row;?>-<?php echo $language['language_id']; ?>').summernote({height: 300});
					<?php } ?>
					//--></script> 
                    <?php }
                    $section_row++; ?>
                    <?php } ?> 
                    </div><!--//tab-content --> 
          		</div><!--//col --> 
          </div><!--//row --> 
               
      
      <div id="add_section" data-section="<?php echo $section_row;?>"></div>
      
<script type="text/javascript"><!--
var section_row;
function addSection() {
	data_section = $('#add_section').attr('data-section');
	section_row = parseInt(data_section);
	html = '<div class="tab-pane active" id="section-tab' + section_row + '">';
	
	html += '<div class="heading-bar"> <?php echo $text_tab; ?> #' + parseInt(section_row+1) + '</div>';
	
	html += '<div class="table-responsive">';
    html += '<table class="table table-bordered table-hover">';
	html += '    <tr><td width="150"><?php echo $text_icon;?></td><td>';
	
    html += '<a class="icon-preview">';
    html += '<i class="fa fa-rocket" id="section_icon_thumb' + section_row + '"></i>';
    html += '<input type="hidden" name="sections[' + section_row + '][icon]" value="fa fa-rocket" id="section_icon' + section_row + '" /></a> ';
    html += '<i class="fa fa-trash-o clear-ico"></i>';
		
	html += '</td></tr>';	
	     
	html += '    <tr><td><?php echo $text_title;?>:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][title][<?php echo $language['language_id']; ?>]" class="form-control" value="Tabs ' + parseInt(section_row+1) + '" /></div>';
				<?php } ?>
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_description;?>:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += ' <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
	html += ' <textarea id="section-description-' + section_row + '-<?php echo $language['language_id']; ?>" name="sections[' + section_row + '][description][<?php echo $language['language_id']; ?>]" class="form-control summernote">Description</textarea></div>';
				<?php } ?>
	html += '    </td></tr>';	
	
	
	html += '    	</table>';
	html += '</div></div>';
	
	$('#section_nav > li,#section-tab>.tab-pane').removeClass('active');
	$('#section-tab.tab-content').append(html);
		$('#section_nav > li:last-child').before('<li class="active"><a href="#section-tab' + section_row + '" data-toggle="tab"><i class="icon-left fa fa-copy" onclick="cloneSection(' + section_row + ')" data-toggle="tooltip" title="<?php echo $text_copy_section;?>"></i>  <?php echo $text_tab; ?> #' + parseInt(section_row+1) + ' <i class="icon-right fa fa-minus-circle" onclick="removeSection(' + section_row + ')"></i></li>');
		$('#section_nav a[href=\'#section-tab' + section_row + '\']').tab('show');
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});
		
		<?php foreach ($languages as $language) { ?>
			$('#section-description-' + section_row + '-<?php echo $language['language_id']; ?>').summernote({height: 300});
		<?php } ?>
	section_row++;
	$('#add_section').attr('data-section',parseInt(section_row));
}

//--></script> 
   