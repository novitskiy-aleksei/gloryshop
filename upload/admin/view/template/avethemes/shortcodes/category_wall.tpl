
 <input type="hidden" name="display" value="<?php echo $element;?>"/>
  	<div class="row">
  
    <div class="col-sm-12">
    
    	<table class="table table-bordered table-hover">
              
              <tr>
           <td width="150"><?php echo $entry_display; ?> </td>
           <td>
           <select name="display_type" class="form-control tr_change with-nav" id="grid_carousel_display" onchange="Plus.activeObj('grid_carousel_display',this.options[this.selectedIndex].value);">   
              <option value="grid" <?php echo($display_type=='grid')?'selected="selected"':''; ?>><?php echo $text_grid;?></option>
              <option value="carousel" <?php echo($display_type=='carousel')?'selected="selected"':''; ?>><?php echo $text_carousel;?></option>
            </select> 
              </td>
           </tr>
              
          <tr class="grid_carousel_display otp-carousel">
           <td width="150"><?php echo $entry_carousel_limit; ?> </td>
               <td>
               <select name="carousel_limit" class="form-control">   
                  <option value="2" <?php echo($grid_limit=='2')?'selected="selected"':''; ?>>2</option>
                  <option value="3" <?php echo($grid_limit=='3')?'selected="selected"':''; ?>>3</option>
                  <option value="4" <?php echo($grid_limit=='4')?'selected="selected"':''; ?>>4</option>               
                </select> 
               </td>
           </tr>
          <tr class="grid_carousel_display otp-grid">
           <td width="150"> <?php echo $entry_grid_limit; ?> </td>
           <td>
           <select name="grid_limit" class="form-control">   
              <option value="6" <?php echo($grid_limit=='6')?'selected="selected"':''; ?>>2</option>
              <option value="4" <?php echo($grid_limit=='4')?'selected="selected"':''; ?>>3</option>
              <option value="3" <?php echo($grid_limit=='3')?'selected="selected"':''; ?>>4</option>               
            </select> 
              </td>
           </tr>
         </table>
         
    </div>
    </div>
    <!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++--> 
    
           <div class="row">
                <div class="col-sm-2 col-xs-12 pull-right">
                 <ul class="nav nav-pills nav-stacked" id="section_nav">
                    <?php $section_row = 0; ?>
                    <?php 
                    foreach ($sections as $section) {  ?>
                    <li class="<?php echo ($section_row==0)?'active':'';?>"><a href="#section-tab<?php echo $section_row; ?>" data-toggle="tab"><i class="icon-left fa fa-copy" onclick="cloneSection(<?php echo $section_row; ?>)" data-toggle="tooltip" title="<?php echo $text_copy_section;?>"></i>  <?php echo $text_group; ?> #<?php echo $section_row+1;?> <i class="icon-right fa fa-minus-circle" onclick="removeSection(<?php echo $section_row; ?>)"></i> </a></li>
                    <?php $section_row++; ?>
                    <?php } ?>
                    <li>
                      <a data-toggle="tab" onclick="addSection()" style="background-color: #8fbb6c; color:#fff;text-align:right;"><?php echo $button_add; ?> <i class="fa fa-plus-circle"></i> </a>
                    </li>
                  </ul>
                  
          		</div><!--//col --> 
                
                <div class="col-sm-10 col-xs-12">
                 <div class="tab-content" id="section-tab">
                    <?php $section_row = 0;
                    //print('<pre>');print_r($sections);print('</pre>'); ?>
                    <?php foreach ($sections as $section) { ?>
                    <div class="tab-pane <?php echo ($section_row==0)?'active':'';?>" id="section-tab<?php echo $section_row; ?>">
	<div class="heading-bar"> <?php echo $text_group; ?> #<?php echo ($section_row+1); ?></div>
                    <div>
                <table class="table table-bordered table-hover">
              
               <tr><td width="150"><?php echo $text_image_icon;?> </td><td>
            <a onclick="image_upload('section_image<?php echo $section_row;?>','thumb-thumb<?php echo $section_row;?>');" id="thumb-thumb<?php echo $section_row;?>" class="img-thumbnail">
            <img src="<?php echo (!empty($section['image']))?'../image/'.$section['image']:$placeholder;?>" alt="" title="" data-placeholder="<?php echo (!empty($section['image']))?'../image/'.$section['image']:$placeholder;?>" id="section_image_thumb<?php echo $section_row;?>"/></a>
            <input type="hidden" name="sections[<?php echo $section_row; ?>][image]" value="<?php echo $section['image'];?>" id="section_image<?php echo $section_row;?>"/>
                   
        
                      
                  </td></tr>
          
             
              <tr><td><?php echo $text_group_title;?>:</td><td>
                <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
                  <input type="text" name="sections[<?php echo $section_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['title'][$language['language_id']]) ? $sections[$section_row]['title'][$language['language_id']] : ''; ?>" class="form-control" />
              
              </div><?php } ?>
                  </td></tr>
            
                  
                  
<tr><td><?php echo $text_link;?> 1:</td><td>
<div class="row"><div class="col-sm-6"><?php echo $text_title;?><br/>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][category_1][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['category_1'][$language['language_id']]) ? $sections[$section_row]['category_1'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
              </div>
<div class="col-sm-6"><?php echo $text_link;?><br> 
<input type="text" name="sections[<?php echo $section_row; ?>][href_1]" value="<?php echo isset($sections[$section_row]['href_1']) ? $sections[$section_row]['href_1'] : ''; ?>" class="form-control" />
</div>
</div><!-- //row--> 
              
                  </td></tr>
<tr><td><?php echo $text_link;?> 2:</td><td>
<div class="row"><div class="col-sm-6"><?php echo $text_title;?><br/>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][category_2][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['category_2'][$language['language_id']]) ? $sections[$section_row]['category_2'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
              </div>
<div class="col-sm-6"><?php echo $text_link;?><br> 
<input type="text" name="sections[<?php echo $section_row; ?>][href_2]" value="<?php echo isset($sections[$section_row]['href_2']) ? $sections[$section_row]['href_2'] : ''; ?>" class="form-control" />
</div>
</div><!-- //row--> 
                  </td></tr>
<tr><td><?php echo $text_link;?> 3:</td><td>
<div class="row"><div class="col-sm-6"><?php echo $text_title;?><br/>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][category_3][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['category_3'][$language['language_id']]) ? $sections[$section_row]['category_3'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
              </div>
<div class="col-sm-6"><?php echo $text_link;?><br> 
<input type="text" name="sections[<?php echo $section_row; ?>][href_3]" value="<?php echo isset($sections[$section_row]['href_3']) ? $sections[$section_row]['href_3'] : ''; ?>" class="form-control" />
</div>
</div><!-- //row--> 
                  </td></tr>
<tr><td><?php echo $text_link;?> 4:</td><td>
<div class="row"><div class="col-sm-6"><?php echo $text_title;?><br/>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][category_4][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['category_4'][$language['language_id']]) ? $sections[$section_row]['category_4'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
              </div>
<div class="col-sm-6"><?php echo $text_link;?><br> 
<input type="text" name="sections[<?php echo $section_row; ?>][href_4]" value="<?php echo isset($sections[$section_row]['href_4']) ? $sections[$section_row]['href_4'] : ''; ?>" class="form-control" />
</div>
</div><!-- //row--> 
                  </td></tr>
<tr><td><?php echo $text_link;?> 5:</td><td>
<div class="row"><div class="col-sm-6"><?php echo $text_title;?><br/>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][category_5][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['category_5'][$language['language_id']]) ? $sections[$section_row]['category_5'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
              </div>
<div class="col-sm-6"><?php echo $text_link;?><br> 
<input type="text" name="sections[<?php echo $section_row; ?>][href_5]" value="<?php echo isset($sections[$section_row]['href_5']) ? $sections[$section_row]['href_5'] : ''; ?>" class="form-control" />
</div>
</div><!-- //row--> 
                  </td></tr>
    
                 </table>
                 </div>
                    
                    </div><!--//tab-pane -->
                    <?php $section_row++; ?>
                    <?php } ?> 
                    </div><!--//tab-content --> 
          		</div><!--//col --> 
          </div><!--//row --> 
               
      
      <div id="add_section" data-section="<?php echo count($sections);?>"></div>
    
    
<script type="text/javascript"><!--
var section_row;
function addSection() {
	data_section = $('#add_section').attr('data-section');
	section_row = parseInt(data_section);
	html = '<div class="tab-pane" id="section-tab' + section_row + '">';
	
	html += '<div class="heading-bar"> <?php echo $text_group; ?> #' + parseInt(section_row+1) + '</div>';
	
	html += '<div class="table-responsive">';
    html += '<table class="table table-bordered table-hover">';
	html += '    <tr><td width="150"><?php echo $text_image_icon;?></td><td>';
	
    html += '<a onclick="image_upload(\'section_image' + section_row + '\',\'thumb-thumb' + section_row + '\');" id="thumb-thumb' + section_row + '" class="img-thumbnail">';
    html += '<img src="<?php echo $placeholder;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>" id="section_image_thumb' + section_row + '"/>';
    html += '</a><input type="hidden" name="sections[' + section_row + '][image]" value="<?php echo $placeholder;?>" id="section_image' + section_row + '"/>';
       
	html += '</td></tr>';	

	     
	html += '    <tr><td><?php echo $text_group_title;?>:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][title][<?php echo $language['language_id']; ?>]" class="form-control" value="Starter ' + parseInt(section_row+1) + '" /></div>';
				<?php } ?>
	html += '    </td></tr>';	
	
	
	html += '    <tr><td><?php echo $text_link;?> 1:</td><td><div class="row"><div class="col-sm-6"><?php echo $text_title;?><br/>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][category_1][<?php echo $language['language_id']; ?>]" class="form-control" value="Feature 1"/></div>';
				<?php } ?>
	html += '</div><div class="col-sm-6"><?php echo $text_link;?><br> <input type="text" name="sections[<?php echo $section_row; ?>][href_1]" value="" class="form-control" /></div></div>';
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_link;?> 2:</td><td><div class="row"><div class="col-sm-6"><?php echo $text_title;?><br/>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][category_2][<?php echo $language['language_id']; ?>]" class="form-control" value="Feature 2"/></div>';
				<?php } ?>
	html += '</div><div class="col-sm-6"><?php echo $text_link;?><br> <input type="text" name="sections[<?php echo $section_row; ?>][href_2]" value="" class="form-control" /></div></div>';
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_link;?> 3:</td><td><div class="row"><div class="col-sm-6"><?php echo $text_title;?><br/>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][category_3][<?php echo $language['language_id']; ?>]" class="form-control" value="Feature 3"/></div>';
				<?php } ?>
	html += '</div><div class="col-sm-6"><?php echo $text_link;?><br> <input type="text" name="sections[<?php echo $section_row; ?>][href_3]" value="" class="form-control" /></div></div>';
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_link;?> 4:</td><td><div class="row"><div class="col-sm-6"><?php echo $text_title;?><br/>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][category_4][<?php echo $language['language_id']; ?>]" class="form-control" value="Feature 4"/></div>';
				<?php } ?>
	html += '</div><div class="col-sm-6"><?php echo $text_link;?><br> <input type="text" name="sections[<?php echo $section_row; ?>][href_4]" value="" class="form-control" /></div></div>';
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_link;?> 5:</td><td><div class="row"><div class="col-sm-6"><?php echo $text_title;?><br/>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][category_5][<?php echo $language['language_id']; ?>]" class="form-control" value="Feature 5"/></div>';
				<?php } ?>
	html += '</div><div class="col-sm-6"><?php echo $text_link;?><br> <input type="text" name="sections[<?php echo $section_row; ?>][href_5]" value="" class="form-control" /></div></div>';

	html += '    </td></tr>';	
	html += '    	</table>';
	html += '</div></div>';
	
	$('#section-tab.tab-content').append(html);
	
		$('#section_nav > li:last-child').before('<li><a href="#section-tab' + section_row + '" data-toggle="tab"><i class="icon-left fa fa-copy" onclick="cloneSection(' + section_row + ')" data-toggle="tooltip" title="<?php echo $text_copy_section;?>"></i>  <?php echo $text_group; ?> #' + parseInt(section_row+1) + ' <i class="icon-right fa fa-minus-circle" onclick="removeSection(' + section_row + ')"></i></li>');
		$('#section_nav a[href=\'#section-tab' + section_row + '\']').tab('show');
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});
		
	section_row++;
	$('#add_section').attr('data-section',parseInt(section_row));
}
//--></script> 