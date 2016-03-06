		<table class="table table-bordered table-hover">
               <tr>
               
               <td width="150"><?php echo $entry_template;?> </td>
               <td>
 <select name="display" id="display" class="form-control tr_change with-nav" onchange="Plus.activeObj('display',this.options[this.selectedIndex].value);">  
    <option value="featured_group" <?php echo ($display=='featured_group')?'selected="selected"':'';?>><?php echo $text_style;?> 1</option> 
    <option value="featured_group2" <?php echo ($display=='featured_group2')?'selected="selected"':'';?>><?php echo $text_style;?> 2</option> 
            </select>
                  </td></tr>
              <tr>
               <td width="150"></td>
               <td>
               <div style="max-width:600px;">
                <img src="../assets/editor/img/mockup/featured_group.png" class="img-responsive display otp-featured_group"/>
                <img src="../assets/editor/img/mockup/featured_group2.png" class="img-responsive display otp-featured_group2"/>
                </div>
                  </td></tr>
                  
                    <tr class="display otp-featured_group2" style="display:none;">
                  <td><?php echo $text_description;?></td><td>
                                    <?php foreach ($languages as $language) { ?>
                <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                <textarea name="description[<?php echo $language['language_id']; ?>]" rows="3" class="form-control" id="section-description<?php echo $language['language_id']; ?>"/><?php echo isset($description[$language['language_id']]) ? $description[$language['language_id']] : ''; ?></textarea></div>
                                <?php } ?>		
                    </td>
                </tr>	
                
                
                  </table>
           <div class="row">
                <div class="col-sm-2 col-xs-12 pull-right">
                 <ul class="nav nav-pills nav-stacked" id="section_nav">
                    <?php $section_row = 0; ?>
                    <?php 
                    foreach ($sections as $section) {
                      ?>
                    <li class="<?php echo ($section_row==0)?'active':'';?>">
                    <a href="#section-tab<?php echo $section_row; ?>" data-toggle="tab"> <?php echo $text_slide; ?> #<?php echo $section_row+1;?> <i class="icon-right fa fa-minus-circle" onclick="removeSection(<?php echo $section_row; ?>)"></i> </a>
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
	<div class="heading-bar"> <?php echo $text_slide; ?> #<?php echo ($section_row+1); ?></div>
                    <div>
                <table class="table table-bordered table-hover">
               
              <tr>
               <td width="150"><?php echo $text_image;?></td><td>
            <a onclick="image_upload('section_image<?php echo $section_row;?>','thumb-thumb<?php echo $section_row;?>');" id="thumb-thumb<?php echo $section_row;?>" class="img-thumbnail">
            <img src="<?php echo (!empty($section['image']))?'../image/'.$section['image']:$placeholder;?>" alt="" title="" data-placeholder="<?php echo (!empty($section['image']))?'../image/'.$section['image']:$placeholder;?>" id="section_image_thumb<?php echo $section_row;?>"/></a>
            <input type="hidden" name="sections[<?php echo $section_row; ?>][image]" value="<?php echo $section['image'];?>" id="section_image<?php echo $section_row;?>"/>
                   
                  </td>
                  </tr>
        
                     
<!--*************************************COLUMN LEFT START********************************************************** -->           
              
                     <tr><td class="heading-bar" colspan="2"><?php echo $text_col_left;?></td></tr>
                   <?php
                    
                    $c=0;
                     foreach ($section['column_left'] as $column) { ?>
           <tr>
           <td>
         <strong>  <?php echo $text_feature;?> <?php echo $c+1;?></strong>
                                </td>
                   <td>   
                     <div class="row">
                       <div class="col-sm-6 col-xs-12">
                     <?php echo $text_title;?>
                   <?php foreach ($languages as $language) {?>
                <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <input type="text" name="sections[<?php echo $section_row; ?>][column_left][<?php echo $c; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($column['title'][$language['language_id']]) ? $column['title'][$language['language_id']] : ''; ?>" class="form-control" /></div>
              <?php } ?>
              </div><!--col --> 
                     <div class="col-sm-3 col-xs-12"><?php echo $text_link;?>
                  <input type="text" name="sections[<?php echo $section_row; ?>][column_left][<?php echo $c; ?>][href]" value="<?php echo $column['href']; ?>" class="form-control" />
                  </div><!--col --> 
                  
                  <div class="col-sm-3 col-xs-12"><?php echo $text_target;?>
                <select name="sections[<?php echo $section_row; ?>][column_left][<?php echo $c; ?>][target]" class="form-control">
                    <option value="_self" <?php if ($column['target']=='_self') { ?>selected="selected"<?php } ?>><?php echo $text_no;?></option>
                   <option value="_blank" <?php if ($column['target']=='_blank') { ?>selected="selected"<?php } ?>><?php echo $text_yes;?></option>
                   </select>
                   </div><!--col --> 
                   </div>
                  </td></tr>
                <tr>
                   <td> </td>
                   
                   <td> 
                   
                     <div class="row">
                  
                  <div class="col-sm-6 col-xs-12"><?php echo $text_description;?>   
                    <?php foreach ($languages as $language) {?>
                <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <input type="text" name="sections[<?php echo $section_row; ?>][column_left][<?php echo $c; ?>][desc][<?php echo $language['language_id']; ?>]" value="<?php echo isset($column['desc'][$language['language_id']]) ? $column['desc'][$language['language_id']] : ''; ?>" class="form-control" /></div>
              <?php } ?>
              
                   </div><!--col --> 
                       <div class="col-sm-3 col-xs-12">
           <?php echo $text_icon;?><br> 
                       
                          <a class="icon-preview">
                         <i class="<?php echo $column['icon'];?>" id="colleft_icon_thumb<?php echo $section_row; ?>_<?php echo $c; ?>"></i>
                         <input type="hidden" name="sections[<?php echo $section_row; ?>][column_left][<?php echo $c; ?>][icon]" value="<?php echo $column['icon'];?>" id="colleft_icon<?php echo $section_row; ?>_<?php echo $c; ?>" /></a> 
                                <i class="fa fa-trash-o clear-ico"></i>
                              </div><!--col -->
                              
	<div class="col-sm-3 col-xs-12">
	<?php echo $text_color;?><br> 
	<input type="text" name="sections[<?php echo $section_row; ?>][column_left][<?php echo $c; ?>][color]" value="<?php echo $column['color'];?>" class="form-control colorpicker" />
	</div><!--col -->
	
     
                   </div>
                   </td> 
               </tr>     
              <tr>
                   <td colspan="2"> </td>
                   </tr>
                    <?php
                    $c++;
                     } ?>  <!--//end column left --> 
                     
<!--*************************************COLUMN RIGHT START********************************************************** -->        
                 <tr>
                     <td class="heading-bar" colspan="2"><?php echo $text_col_right;?></td>
                     
                     </tr>
                          
                       <?php
                    
                    $c=0;
                     foreach ($section['column_right'] as $column) { ?>
           <tr>
           <td>
         <strong>  <?php echo $text_feature;?> <?php echo $c+1;?></strong>
                                </td>
                   <td>   
                     <div class="row">
                       <div class="col-sm-6 col-xs-12">
                     <?php echo $text_title;?>
                   <?php foreach ($languages as $language) {?>
                <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <input type="text" name="sections[<?php echo $section_row; ?>][column_right][<?php echo $c; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($column['title'][$language['language_id']]) ? $column['title'][$language['language_id']] : ''; ?>" class="form-control" /></div>
              <?php } ?>
              </div><!--col --> 
                     <div class="col-sm-3 col-xs-12"><?php echo $text_link;?>
                  <input type="text" name="sections[<?php echo $section_row; ?>][column_right][<?php echo $c; ?>][href]" value="<?php echo $column['href']; ?>" class="form-control" />
                  </div><!--col --> 
                  
                  <div class="col-sm-3 col-xs-12"><?php echo $text_target;?>
                <select name="sections[<?php echo $section_row; ?>][column_right][<?php echo $c; ?>][target]" class="form-control">
                    <option value="_self" <?php if ($column['target']=='_self') { ?>selected="selected"<?php } ?>><?php echo $text_no;?></option>
                   <option value="_blank" <?php if ($column['target']=='_blank') { ?>selected="selected"<?php } ?>><?php echo $text_yes;?></option>
                   </select>
                   </div><!--col --> 
                   </div>
                  </td></tr>
                <tr>
                   <td> </td>
                   
                   <td> 
                   
                     <div class="row">
                  
                  <div class="col-sm-6 col-xs-12"><?php echo $text_description;?>   
                    <?php foreach ($languages as $language) {?>
                <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>
                  <input type="text" name="sections[<?php echo $section_row; ?>][column_right][<?php echo $c; ?>][desc][<?php echo $language['language_id']; ?>]" value="<?php echo isset($column['desc'][$language['language_id']]) ? $column['desc'][$language['language_id']] : ''; ?>" class="form-control" /></div>
              <?php } ?>
              
                   </div><!--col --> 
                       <div class="col-sm-3 col-xs-12">
           <?php echo $text_icon;?><br> 
                       
                          <a class="icon-preview">
                         <i class="<?php echo $column['icon'];?>" id="colright_icon_thumb<?php echo $section_row; ?>_<?php echo $c; ?>"></i>
                         <input type="hidden" name="sections[<?php echo $section_row; ?>][column_right][<?php echo $c; ?>][icon]" value="<?php echo $column['icon'];?>" id="colright_icon<?php echo $section_row; ?>_<?php echo $c; ?>" /></a> 
                                <i class="fa fa-trash-o clear-ico"></i>
                              </div><!--col --> 
                              
	<div class="col-sm-3 col-xs-12">
	<?php echo $text_color;?><br> 
	<input type="text" name="sections[<?php echo $section_row; ?>][column_right][<?php echo $c; ?>][color]" value="<?php echo $column['color'];?>" class="form-control colorpicker" />
	</div><!--col -->
	
    
                   </div>
                   </td> 
               </tr>     
              <tr>
                   <td colspan="2"> </td>
                   </tr>
                    <?php
                    $c++;
                     } ?>  <!--//end column right --> 
                    
             
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
	
	html += '<div class="heading-bar"> <?php echo $text_slide; ?> #' + parseInt(section_row+1) + '</div>';
	
	html += '<div class="table-responsive">';
    html += '<table class="table table-bordered table-hover">';
	
	html += '    <tr><td width="150"><?php echo $text_image;?></td><td>';
    html += '<a onclick="image_upload(\'section_image' + section_row + '\',\'thumb-thumb' + section_row + '\');" id="thumb-thumb' + section_row + '" class="img-thumbnail">';
    html += '<img src="<?php echo $placeholder;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>" id="section_image_thumb' + section_row + '"/>';
    html += '</a><input type="hidden" name="sections[' + section_row + '][image]" value="<?php echo $placeholder;?>" id="section_image' + section_row + '"/>';
	html += '</td></tr>';	
	
<!--*************************************COLUMN LEFT START********************************************************** -->    
	
	html += '<tr><td class="heading-bar" colspan="2"><?php echo $text_col_left;?></td> </tr>';
             <?php for ($c = 0; $c <= 2; $c++) {?>
	html += '<tr> <td><strong><?php echo $text_feature;?> <?php echo $c+1;?></strong>';
                    
	html += '</td><td>';
	html += '<div class="row">';
	html += '<div class="col-sm-6 col-xs-12"><?php echo $text_title;?>';
                       
                   <?php foreach ($languages as $language) {?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>';
	html += '<input type="text" name="sections[' + section_row + '][column_left][<?php echo $c; ?>][title][<?php echo $language['language_id']; ?>]" value="Easy to customize" class="form-control" /></div>';
                  
              <?php } ?>
	html += '</div><!--col --> ';
	html += '<div class="col-sm-3 col-xs-12"><?php echo $text_link;?>';
                     
	html += '<input type="text" name="sections[' + section_row + '][column_left][<?php echo $c; ?>][href]" value="http://codecanyon.net/user/legendtheme" class="form-control" />';
	html += '</div><!--col --> ';
	html += '<div class="col-sm-3 col-xs-12"><?php echo $text_target;?>';
                  
	html += '<select name="sections[' + section_row + '][column_left][<?php echo $c; ?>][target]" class="form-control">';
	html += '<option value="_self" selected="selected"><?php echo $text_no;?></option>';
	html += '<option value="_blank"><?php echo $text_yes;?></option>';
	html += '</select>';
                   
	html += '</div><!--col --> ';
	html += '</div> </td></tr>';
                  
                  
	html += '<tr><td></td><td> ';
                   
	html += '<div class="row"><div class="col-sm-6 col-xs-12"><?php echo $text_description;?>';
                 
                    <?php foreach ($languages as $language) {?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>';
	html += '<input type="text" name="sections[' + section_row + '][column_left][<?php echo $c; ?>][desc][<?php echo $language['language_id']; ?>]" value="There are many variations of passages of Lorem Ipsum available but the majority." class="form-control" /></div>';
              <?php } ?>
              
	html += '</div><!--col --><div class="col-sm-3 col-xs-12">';
	html += '<?php echo $text_icon;?><br> ';
                       
	html += '<a class="icon-preview">';
	html += '<i class="<?php echo $column['icon'];?>" id="colleft_icon_thumb' + section_row + '_<?php echo $c; ?>"></i>';
	html += '<input type="hidden" name="sections[' + section_row + '][column_left][<?php echo $c; ?>][icon]" value="fa fa-rocket" id="colleft_icon' + section_row + '_<?php echo $c; ?>" /></a>'; 
	html += '<i class="fa fa-trash-o clear-ico"></i>';
	html += '</div><!--col -->';
	
	html += '<div class="col-sm-3 col-xs-12">';
	html += '<?php echo $text_color;?><br> ';
	html += '<input type="text" name="sections[' + section_row + '][column_left][<?php echo $c; ?>][color]" value="#0072A5" class="form-control colorpicker" />';
	html += '</div><!--col -->';
	
	html += '</div></td> ';
	html += '</tr><tr><td colspan="2"> </td>';
	html += '</tr>'; 
		   <?php } ?> 	<!--//end for column left --> 
           
	
<!--*************************************COLUMN RIGHT START********************************************************** -->    
	
	html += '<tr><td class="heading-bar" colspan="2"><?php echo $text_col_right;?></td> </tr>';
             <?php for ($c = 0; $c <= 2; $c++) {?>
	html += '<tr> <td><strong><?php echo $text_feature;?> <?php echo $c+1;?></strong>';
                    
	html += '</td><td>';
	html += '<div class="row">';
	html += '<div class="col-sm-6 col-xs-12"><?php echo $text_title;?>';
                       
                   <?php foreach ($languages as $language) {?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>';
	html += '<input type="text" name="sections[' + section_row + '][column_right][<?php echo $c; ?>][title][<?php echo $language['language_id']; ?>]" value="Easy to customize" class="form-control" /></div>';
                  
              <?php } ?>
	html += '</div><!--col --> ';
	html += '<div class="col-sm-3 col-xs-12"><?php echo $text_link;?>';
                     
	html += '<input type="text" name="sections[' + section_row + '][column_right][<?php echo $c; ?>][href]" value="http://codecanyon.net/user/legendtheme" class="form-control" />';
	html += '</div><!--col --> ';
	html += '<div class="col-sm-3 col-xs-12"><?php echo $text_target;?>';
                  
	html += '<select name="sections[' + section_row + '][column_right][<?php echo $c; ?>][target]" class="form-control">';
	html += '<option value="_self" selected="selected"><?php echo $text_no;?></option>';
	html += '<option value="_blank"><?php echo $text_yes;?></option>';
	html += '</select>';
                   
	html += '</div><!--col --> ';
	html += '</div> </td></tr>';
                  
                  
	html += '<tr><td></td><td> ';
                   
	html += '<div class="row"><div class="col-sm-6 col-xs-12"><?php echo $text_description;?>';
                 
                    <?php foreach ($languages as $language) {?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>"/></span>';
	html += '<input type="text" name="sections[' + section_row + '][column_right][<?php echo $c; ?>][desc][<?php echo $language['language_id']; ?>]" value="There are many variations of passages of Lorem Ipsum available but the majority." class="form-control" /></div>';
              <?php } ?>
              
	html += '</div><!--col -->';
	
	html += '<div class="col-sm-3 col-xs-12">';
	html += '<?php echo $text_icon;?><br> ';
	html += '<a class="icon-preview">';
	html += '<i class="<?php echo $column['icon'];?>" id="colright_icon_thumb' + section_row + '_<?php echo $c; ?>"></i>';
	html += '<input type="hidden" name="sections[' + section_row + '][column_right][<?php echo $c; ?>][icon]" value="fa fa-rocket" id="colright_icon' + section_row + '_<?php echo $c; ?>" /></a>'; 
	html += '<i class="fa fa-trash-o clear-ico"></i>';
	html += '</div><!--col -->';
	
	html += '<div class="col-sm-3 col-xs-12">';
	html += '<?php echo $text_color;?><br> ';
	html += '<input type="text" name="sections[' + section_row + '][column_right][<?php echo $c; ?>][color]" value="#0072A5" class="form-control colorpicker" />';
	html += '</div><!--col -->';
	
	html += '</div></td> ';
	html += '</tr><tr><td colspan="2"> </td>';
	html += '</tr>'; 
		   <?php } ?> 
		   <!--//end for column left --> 	
		
	html += '    	</table>';
	html += '</div></div>';
	
	$('#section_nav > li,#section-tab>.tab-pane').removeClass('active');
	$('#section-tab.tab-content').append(html);
		$('#section_nav > li:last-child').before('<li class="active"><a href="#section-tab' + section_row + '" data-toggle="tab"> <?php echo $text_slide; ?> #' + parseInt(section_row+1) + ' <i class="icon-right fa fa-minus-circle" onclick="removeSection(' + section_row + ')"></i></li>');
		$('#section_nav a[href=\'#section-tab' + section_row + '\']').tab('show');
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});
		
		
	section_row++;
			Plus.handleColorpicker();
	$('#add_section').attr('data-section',parseInt(section_row));
}

//--></script> 
   