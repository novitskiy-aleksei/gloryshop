
 <input type="hidden" name="display" value="<?php echo $element;?>"/> 
           <div class="row">
                <div class="col-sm-2 col-xs-12 pull-right">
                 <ul class="nav nav-pills nav-stacked" id="section_nav">
                    <?php $section_row = 0; ?>
                    <?php 
                    foreach ($sections as $section) {
                      ?>
                    <li class="<?php echo ($section_row==0)?'active':'';?>">
                    <a href="#section-tab<?php echo $section_row; ?>" data-toggle="tab"><i class="icon-left fa fa-copy" onclick="cloneSection(<?php echo $section_row; ?>)" data-toggle="tooltip" title="<?php echo $text_copy_section;?>"></i>  <?php echo $text_block; ?> #<?php echo $section_row+1;?> <i class="icon-right fa fa-minus-circle" onclick="removeSection(<?php echo $section_row; ?>)"></i> </a>
                    </li>
                    <?php
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
                    <?php foreach ($sections as $section) { ?>
                    <div class="tab-pane <?php echo ($section_row==0)?'active':'';?>" id="section-tab<?php echo $section_row; ?>">
	<div class="heading-bar"> <?php echo $text_block; ?> #<?php echo ($section_row+1); ?></div>
                    <div>
                <table class="table table-bordered table-hover">
              
               <tr><td width="150"><?php echo $text_image;?> </td><td>
               
                     <div class="row">
                     <div class="col-sm-4 col-xs-12">
                     
                   
            <a onclick="image_upload('section_image<?php echo $section_row;?>','thumb-thumb<?php echo $section_row;?>');" id="thumb-thumb<?php echo $section_row;?>" class="img-thumbnail">
            <img src="<?php echo (!empty($section['image']))?'../image/'.$section['image']:$placeholder;?>" alt="" title="" data-placeholder="<?php echo (!empty($section['image']))?'../image/'.$section['image']:$placeholder;?>" id="section_image_thumb<?php echo $section_row;?>"/></a>
            <input type="hidden" name="sections[<?php echo $section_row; ?>][image]" value="<?php echo $section['image'];?>" id="section_image<?php echo $section_row;?>"/>
            
            
                     </div>
                  <div class="col-sm-4 col-xs-12"><?php echo $text_img_pos;?>
                <select name="sections[<?php echo $section_row; ?>][img_pos]" class="form-control">
                   <option value="" <?php if ($section['img_pos']=='') { ?>selected="selected"<?php } ?>><?php echo $text_pull_left;?></option>
                    <option value="pull-right" <?php if ($section['img_pos']=='pull-right') { ?>selected="selected"<?php } ?>><?php echo $text_pull_right;?></option>
                   </select>
                   </div>
                  <div class="col-sm-4 col-xs-12"><?php echo $text_anim_effect;?>
                <select name="sections[<?php echo $section_row; ?>][animation]" class="form-control">
                <option value="" <?php echo (''==$section['animation'])?'selected="selected"':'';?>><?php echo $text_none;?></option> 
   <?php foreach ($animations as $key=>$label) { ?>
    <option value="<?php echo $key;?>"  <?php echo ($key==$section['animation'])?'selected="selected"':'';?>><?php echo $label;?></option> 
   <?php } ?>
                   </select>
                   </div>
                   </div>
                   
                   
                  </td></tr>
              
              <tr><td><?php echo $text_title;?>:</td><td>
                <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
                  <input type="text" name="sections[<?php echo $section_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($section['title'][$language['language_id']]) ? $section['title'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
              <tr>
              <td><?php echo $text_description;?>:</td><td>
                <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <textarea  id="section-description-<?php echo $section_row; ?>-<?php echo $language['language_id']; ?>" name="sections[<?php echo $section_row; ?>][description][<?php echo $language['language_id']; ?>]" class="form-control summernote" rows="5"><?php echo isset($sections[$section_row]['description'][$language['language_id']]) ? $sections[$section_row]['description'][$language['language_id']] : ''; ?></textarea>
              </div><?php } ?>
                  </td></tr>
                  
             
    
                 </table>
                 </div>
                    
                    </div><!--//tab-pane -->
                  
                    <?php $section_row++; ?>
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
	
	html += '<div class="heading-bar"> <?php echo $text_block; ?> #' + parseInt(section_row+1) + '</div>';
	
	html += '<div class="table-responsive">';
    html += '<table class="table table-bordered table-hover">';
	
	html += '    <tr><td width="150"><?php echo $text_image;?></td><td><div class="row"> <div class="col-sm-4 col-xs-12">';
    html += '<a onclick="image_upload(\'section_image' + section_row + '\',\'thumb-thumb' + section_row + '\');" id="thumb-thumb' + section_row + '" class="img-thumbnail">';
    html += '<img src="<?php echo $placeholder;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>" id="section_image_thumb' + section_row + '"/>';
    html += '</a><input type="hidden" name="sections[' + section_row + '][image]" value="<?php echo $placeholder;?>" id="section_image' + section_row + '"/>';
	html += '</div><div class="col-sm-4 col-xs-12"><?php echo $text_img_pos;?>';
	html += '<select name="sections[<?php echo $section_row; ?>][img_pos]" class="form-control">';
	html += '<option value="" selected="selected"><?php echo $text_pull_left;?></option>';
	html += '<option value="pull-right"><?php echo $text_pull_right;?></option>';
	html += '</select>';
	html += '</div>';
	html += '<div class="col-sm-4 col-xs-12"><?php echo $text_anim_effect;?>';
	html += ' <select name="sections[<?php echo $section_row; ?>][animation]" class="form-control">';
	html += '<option value=""><?php echo $text_none;?></option>';
   <?php foreach ($animations as $key=>$label) { ?>
	html += '<option value="<?php echo $key;?>"><?php echo $label;?></option> ';
   <?php } ?>
	html += ' </select>';
	html += '</div>';
	html += '</div>';
	html += '</td></tr>';	
		
	html += '    <tr><td><?php echo $text_title;?>:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][title][<?php echo $language['language_id']; ?>]" class="form-control" value="Tabs ' + parseInt(section_row+1) + '" /></div>';
				<?php } ?>
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_description;?>:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += ' <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>';
	html += ' <textarea id="section-description-' + section_row + '-<?php echo $language['language_id']; ?>" name="sections[' + section_row + '][description][<?php echo $language['language_id']; ?>]" class="form-control summernote" rows="5">Lorem Ipsum is simply dummy text of the printing and typeseting industry Lorem in text Ipsum has been the industry standar dummyy text ever since the when an iunesi known printer of took a galley of type and scrambled it to make a typea specimen book There are many variations of the paes sages the Lorem Ipsum.</textarea></div>';
				<?php } ?>
	html += '    </td></tr>';	
	
	
	html += '    	</table>';
	html += '</div></div>';
	
	$('#section_nav > li,#section-tab>.tab-pane').removeClass('active');
	$('#section-tab.tab-content').append(html);
		$('#section_nav > li:last-child').before('<li class="active"><a href="#section-tab' + section_row + '" data-toggle="tab"><i class="icon-left fa fa-copy" onclick="cloneSection(' + section_row + ')" data-toggle="tooltip" title="<?php echo $text_copy_section;?>"></i>  <?php echo $text_block; ?> #' + parseInt(section_row+1) + ' <i class="icon-right fa fa-minus-circle" onclick="removeSection(' + section_row + ')"></i></li>');
		$('#section_nav a[href=\'#section-tab' + section_row + '\']').tab('show');
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});
		
		
	section_row++;
	$('#add_section').attr('data-section',parseInt(section_row));
}

//--></script> 
   