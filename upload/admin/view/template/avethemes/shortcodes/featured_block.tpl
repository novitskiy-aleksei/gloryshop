 		<table class="table table-bordered table-hover">
               <tr>
               
               <td width="150"><?php echo $entry_template;?> </td>
               <td>
 <select name="display" id="display" class="form-control tr_change with-nav" onchange="Plus.activeObj('display',this.options[this.selectedIndex].value);">  
    <option value="featured_block" <?php echo ($display=='featured_block')?'selected="selected"':'';?>><?php echo $text_style;?> 1</option> 
    <option value="featured_block2" <?php echo ($display=='featured_block2')?'selected="selected"':'';?>><?php echo $text_style;?> 2</option> 
    <option value="featured_block3" <?php echo ($display=='featured_block3')?'selected="selected"':'';?>><?php echo $text_style;?> 3</option> 
    <option value="featured_block4" <?php echo ($display=='featured_block4')?'selected="selected"':'';?>><?php echo $text_style;?> 4</option> 
    <option value="featured_block5" <?php echo ($display=='featured_block5')?'selected="selected"':'';?>><?php echo $text_style;?> 5</option> 
    <option value="featured_block6" <?php echo ($display=='featured_block6')?'selected="selected"':'';?>><?php echo $text_style;?> 6</option> 
    <option value="featured_block7" <?php echo ($display=='featured_block7')?'selected="selected"':'';?>><?php echo $text_style;?> 7</option> 
    <option value="featured_block8" <?php echo ($display=='featured_block8')?'selected="selected"':'';?>><?php echo $text_style;?> 8</option>
    <option value="featured_block9" <?php echo ($display=='featured_block9')?'selected="selected"':'';?>><?php echo $text_style;?> 9</option>
    <option value="featured_block10" <?php echo ($display=='featured_block10')?'selected="selected"':'';?>><?php echo $text_style;?> 10</option>
            </select>
                  </td></tr>
              <tr>
               <td width="150"></td>
               <td>
               <div style="max-width:600px;">
                <img src="../assets/editor/img/mockup/featured_block.png" class="img-responsive display otp-featured_block"/>
                <img src="../assets/editor/img/mockup/featured_block2.png" class="img-responsive display otp-featured_block2"/>
                <img src="../assets/editor/img/mockup/featured_block3.png" class="img-responsive display otp-featured_block3"/>
                <img src="../assets/editor/img/mockup/featured_block4.png" class="img-responsive display otp-featured_block4"/>
                <img src="../assets/editor/img/mockup/featured_block5.png" class="img-responsive display otp-featured_block5"/>
                <img src="../assets/editor/img/mockup/featured_block6.png" class="img-responsive display otp-featured_block6"/>
                <img src="../assets/editor/img/mockup/featured_block7.png" class="img-responsive display otp-featured_block7"/>
                <img src="../assets/editor/img/mockup/featured_block8.png" class="img-responsive display otp-featured_block8"/>
                <img src="../assets/editor/img/mockup/featured_block9.png" class="img-responsive display otp-featured_block9"/>
                <img src="../assets/editor/img/mockup/featured_block10.png" class="img-responsive display otp-featured_block10"/>
                </div>
                  </td></tr>
                 <tr width="150" class="display otp-featured_block10">
               <td><?php echo $entry_section_image; ?> </td>
               <td>    <a data-toggle="image-upload" onclick="image_upload('section_image','main_thumb');" id="main_thumb" class="img-thumbnail">
            <img src="<?php echo (!empty($section_image))?'../image/'.$section_image:$placeholder;?>" alt="" title="" data-placeholder="<?php echo (!empty($section_image))?'../image/'.$section_image:$placeholder;?>" id="section_image_thumb"/></a>
            <input type="hidden" name="section_image" value="<?php echo $section_image;?>" id="section_image"/>
                  </td></tr> 
          	<tr>
               <td width="150"><?php echo $entry_grid_limit; ?> </td>
               <td>   <select name="grid_limit" class="form-control">   
                  <option value="6" <?php echo($grid_limit=='6')?'selected="selected"':''; ?>>2</option>
                  <option value="4" <?php echo($grid_limit=='4')?'selected="selected"':''; ?>>3</option>
                  <option value="3" <?php echo($grid_limit=='3')?'selected="selected"':''; ?>>4</option>               
                </select> 
                  </td></tr>
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
                    <a href="#section-tab<?php echo $section_row; ?>" data-toggle="tab"><i class="icon-left fa fa-copy" onclick="cloneSection(<?php echo $section_row; ?>)" data-toggle="tooltip" title="<?php echo $text_copy_section;?>"></i>  <?php echo $text_feature; ?> #<?php echo $section_row+1;?> <i class="icon-right fa fa-minus-circle" onclick="removeSection(<?php echo $section_row; ?>)"></i> </a>
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
	<div class="heading-bar"> <?php echo $text_feature; ?> #<?php echo ($section_row+1); ?></div>
                    <div>
                <table class="table table-bordered table-hover">
               <tr><td><?php echo $text_icon;?></td><td>
                     
                  
                     <div class="input-group">
          <a class="icon-preview">
         <i class="<?php echo $section['icon'];?>" id="section_icon_thumb<?php echo $section_row; ?>"></i>
         <input type="hidden" name="sections[<?php echo $section_row; ?>][icon]" value="<?php echo $section['icon'];?>" id="section_icon<?php echo $section_row; ?>" /></a> 
                <i class="fa fa-trash-o clear-ico"></i>
                </div>
                </td>
                </tr>
             
               <tr class="display otp-featured_block6"><td width="150"><?php echo $text_image;?> <br>  (100x100px)</td><td>
            <a onclick="image_upload('section_image<?php echo $section_row;?>','thumb-thumb<?php echo $section_row;?>');" id="thumb-thumb<?php echo $section_row;?>" class="img-thumbnail">
            <img src="<?php echo (!empty($section['image']))?'../image/'.$section['image']:$placeholder;?>" alt="" title="" data-placeholder="<?php echo (!empty($section['image']))?'../image/'.$section['image']:$placeholder;?>" id="section_image_thumb<?php echo $section_row;?>"/></a>
            <input type="hidden" name="sections[<?php echo $section_row; ?>][image]" value="<?php echo $section['image'];?>" id="section_image<?php echo $section_row;?>"/>
                   
                  </td></tr>
             
             
              <tr><td><?php echo $text_title;?>:</td><td>
                <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
                  <input type="text" name="sections[<?php echo $section_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($section['title'][$language['language_id']]) ? $section['title'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
                  
              <tr>
              <td width="150"><?php echo $text_description;?>:</td><td>
                <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
                  <textarea  id="section-description-<?php echo $section_row; ?>-<?php echo $language['language_id']; ?>" name="sections[<?php echo $section_row; ?>][description][<?php echo $language['language_id']; ?>]" class="form-control summernote" rows="5"><?php echo isset($section['description'][$language['language_id']]) ? $section['description'][$language['language_id']] : ''; ?></textarea>
              </div><?php } ?>
                  </td></tr>
                 
                 
         
                     <tr>
                     <td><?php echo $text_link;?></td><td>
                     
                     <div class="row">
                     <div class="col-sm-8 col-xs-12"><?php echo $text_button_link;?>
                  <input type="text" name="sections[<?php echo $section_row; ?>][btn_href]" value="<?php echo $section['btn_href']; ?>" class="form-control" />
                  </div>
                  
                  <div class="col-sm-4 col-xs-12"><?php echo $text_target;?>
                <select name="sections[<?php echo $section_row; ?>][btn_target]" class="form-control">
                    <option value="_self" <?php if ($section['btn_target']=='_self') { ?>selected="selected"<?php } ?>><?php echo $text_no;?></option>
                   <option value="_blank" <?php if ($section['btn_target']=='_blank') { ?>selected="selected"<?php } ?>><?php echo $text_yes;?></option>
                   </select>
                   </div>
                   </div>
                  </td></tr>
    
                 </table>
                 </div>
                    
                    </div><!--//tab-pane -->
                  
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
	
	html += '<div class="heading-bar"> <?php echo $text_feature; ?> #' + parseInt(section_row+1) + '</div>';
	
	html += '<div class="table-responsive">';
    html += '<table class="table table-bordered table-hover">';
	
	html += '<tr class="display otp-featured_block otp-featured_block2 otp-featured_block3 otp-featured_block4 otp-featured_block5 otp-featured_block7  otp-featured_block8"><td><?php echo $text_icon;?></td><td>';
	html += '<div class="input-group"><a class="icon-preview">';
	html += '<i class="fa fa-rocket" id="section_icon_thumb' + section_row + '"></i>';
	html += '<input type="hidden" name="sections[' + section_row + '][icon]" value="fa fa-rocket" id="section_icon' + section_row + '" /></a> ';
	html += '<i class="fa fa-trash-o clear-ico"></i>';
	html += '</div>';
	html += '</td></tr>';
	
	html += '    <tr class="display otp-featured_block6"><td width="150"><?php echo $text_image;?> <br>  (100x100px)</td><td>';
    html += '<a onclick="image_upload(\'section_image' + section_row + '\',\'thumb-thumb' + section_row + '\');" id="thumb-thumb' + section_row + '" class="img-thumbnail">';
    html += '<img src="<?php echo $placeholder;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>" id="section_image_thumb' + section_row + '"/>';
    html += '</a><input type="hidden" name="sections[' + section_row + '][image]" value="<?php echo $placeholder;?>" id="section_image' + section_row + '"/>';
	html += '</td></tr>';	
		
	html += '    <tr><td><?php echo $text_title;?>:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][title][<?php echo $language['language_id']; ?>]" class="form-control" value="Tabs ' + parseInt(section_row+1) + '" /></div>';
				<?php } ?>
	html += '    </td></tr>';	
	
	html += '    <tr><td width="150"><?php echo $text_description;?>:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += ' <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
	html += ' <textarea id="section-description-' + section_row + '-<?php echo $language['language_id']; ?>" name="sections[' + section_row + '][description][<?php echo $language['language_id']; ?>]" class="form-control summernote" rows="3">Description</textarea></div>';
				<?php } ?>
	html += '    </td></tr>';	
	
html += '<tr><td><?php echo $text_link;?></td><td>';
                     
	html += '<div class="row">';
	html += '<div class="col-sm-8 col-xs-12"><?php echo $text_button_link;?>';
	html += '<input type="text" name="sections[' + section_row + '][btn_href]" value="" class="form-control" />';
	html += '</div>';
                  
	html += '<div class="col-sm-4 col-xs-12"><?php echo $text_target;?>';
	html += '<select name="sections[' + section_row + '][btn_target]" class="form-control">';
	html += '<option value="_self"><?php echo $text_no;?></option>';
	html += '<option value="_blank"><?php echo $text_yes;?></option>';
	html += '</select>';
                   
	html += ' </div></div>';
	html += '</td></tr>';
	html += '    	</table>';
	html += '</div></div>';
	
	$('#section_nav > li,#section-tab>.tab-pane').removeClass('active');
	$('#section-tab.tab-content').append(html);
		$('#section_nav > li:last-child').before('<li class="active"><a href="#section-tab' + section_row + '" data-toggle="tab"><i class="icon-left fa fa-copy" onclick="cloneSection(' + section_row + ')" data-toggle="tooltip" title="<?php echo $text_copy_section;?>"></i>  <?php echo $text_feature; ?> #' + parseInt(section_row+1) + ' <i class="icon-right fa fa-minus-circle" onclick="removeSection(' + section_row + ')"></i></li>');
		$('#section_nav a[href=\'#section-tab' + section_row + '\']').tab('show');
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});
		
		
	section_row++;
	$('#add_section').attr('data-section',parseInt(section_row));
}

//--></script> 
   