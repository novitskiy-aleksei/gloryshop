 	<div class="row">
    
    <div class="col-sm-6">
    <table class="table table-bordered table-hover">
               <tr>
               
               <td width="150"><?php echo $entry_template;?> </td>
               <td>
 <select name="display" id="display" class="form-control tr_change with-nav" onchange="Plus.activeObj('display',this.options[this.selectedIndex].value);">  
    <option value="pricing-1" <?php echo ($display=='pricing-1')?'selected="selected"':'';?>><?php echo $text_style;?> 1</option> 
    <option value="pricing-2" <?php echo ($display=='pricing-2')?'selected="selected"':'';?>><?php echo $text_style;?> 2</option> 
    <option value="pricing-3" <?php echo ($display=='pricing-3')?'selected="selected"':'';?>><?php echo $text_style;?> 3</option> 
</select>
                  </td></tr>
              <tr>
               
       <td width="150"></td>
       <td>
       <div style="max-width:600px;">
        <img src="../assets/editor/img/mockup/pricing-1.png" class="img-responsive display otp-pricing-1"/>
        <img src="../assets/editor/img/mockup/pricing-2.png" class="img-responsive display otp-pricing-2"/>
        <img src="../assets/editor/img/mockup/pricing-3.png" class="img-responsive display otp-pricing-3"/>
        </div>
    </td></tr>
    </table>
    </div>
    <div class="col-sm-6">
    
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
                    <li class="<?php echo ($section_row==0)?'active':'';?>"><a href="#section-tab<?php echo $section_row; ?>" data-toggle="tab"><i class="icon-left fa fa-copy" onclick="cloneSection(<?php echo $section_row; ?>)" data-toggle="tooltip" title="<?php echo $text_copy_section;?>"></i>  <?php echo $text_section; ?> #<?php echo $section_row+1;?> <i class="icon-right fa fa-minus-circle" onclick="removeSection(<?php echo $section_row; ?>)"></i> </a></li>
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
	<div class="heading-bar"> <?php echo $text_section; ?> #<?php echo ($section_row+1); ?></div>
                    <div>
                <table class="table table-bordered table-hover">
              
               <tr><td width="150"><?php echo $text_image_icon;?> </td><td>
            <a onclick="image_upload('section_image<?php echo $section_row;?>','thumb-thumb<?php echo $section_row;?>');" id="thumb-thumb<?php echo $section_row;?>" class="hide img-thumbnail">
            <img src="<?php echo (!empty($section['image']))?'../image/'.$section['image']:$placeholder;?>" alt="" title="" data-placeholder="<?php echo (!empty($section['image']))?'../image/'.$section['image']:$placeholder;?>" id="section_image_thumb<?php echo $section_row;?>"/></a>
            <input type="hidden" name="sections[<?php echo $section_row; ?>][image]" value="<?php echo $section['image'];?>" id="section_image<?php echo $section_row;?>"/>
                   
          <a class="icon-preview">
         <i class="<?php echo $section['icon'];?>" id="section_icon_thumb<?php echo $section_row;?>"></i>
         <input type="hidden" name="sections[<?php echo $section_row; ?>][icon]" value="<?php echo $section['icon'];?>" id="section_icon<?php echo $section_row;?>" /></a> 
                      
                  </td></tr>
               <tr><td> <?php echo $text_set_active;?></td><td>
                  <select name="sections[<?php echo $section_row; ?>][state]" class="form-control">
                <option value="" <?php if ($section['state']=='') { ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
                <option value="active" <?php if ($section['state']=='active') { ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
                  </select>
              
                  </td></tr>
             
              <tr><td><?php echo $text_title;?>:</td><td>
                <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
                  <input type="text" name="sections[<?php echo $section_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['title'][$language['language_id']]) ? $sections[$section_row]['title'][$language['language_id']] : ''; ?>" class="form-control" />
              
              </div><?php } ?>
                  </td></tr>
                  
              <tr class="hide"><td><?php echo $text_description;?>:</td><td>
                <?php foreach ($languages as $language) {?>
              <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
                  <input type="text" name="sections[<?php echo $section_row; ?>][description][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['description'][$language['language_id']]) ? $sections[$section_row]['description'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
                  
                  <tr><td><?php echo $text_price;?>:</td><td>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][line_price][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['line_price'][$language['language_id']]) ? $sections[$section_row]['line_price'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
                  
<tr><td><?php echo $text_currency_code;?>:</td><td>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][line_currency][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['line_currency'][$language['language_id']]) ? $sections[$section_row]['line_currency'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
                  
<tr><td><?php echo $text_period;?>:</td><td>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][line_period][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['line_period'][$language['language_id']]) ? $sections[$section_row]['line_period'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
                  
<tr><td><?php echo $text_button_title;?>:</td><td>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][btn_title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['btn_title'][$language['language_id']]) ? $sections[$section_row]['btn_title'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
             
                  </td></tr>
                     <tr><td></td><td>
                     <div class="row"><div class="col-sm-6 col-xs-6"><?php echo $text_button_link;?>
                  <input type="text" name="sections[<?php echo $section_row; ?>][href]" id="[sections][<?php echo $section_row; ?>][href]" value="<?php echo $section['href']; ?>" class="form-control" />
                  </div><div class="col-sm-6 col-xs-6">
<?php echo $text_target;?></label><select name="sections[<?php echo $section_row; ?>][target]" class="form-control">
    <option value="_self" <?php if ($section['target']=='_self') { ?>selected="selected"<?php } ?>><?php echo $text_no;?></option>
   <option value="_blank" <?php if ($section['target']=='_blank') { ?>selected="selected"<?php } ?>><?php echo $text_yes;?></option>
   </select>
   </div>
   </div>
                  </td></tr>
                  
                  
<tr><td><?php echo $text_feature;?> 1:</td><td>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][line_feature1][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['line_feature1'][$language['language_id']]) ? $sections[$section_row]['line_feature1'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
<tr><td><?php echo $text_feature;?> 2:</td><td>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][line_feature2][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['line_feature2'][$language['language_id']]) ? $sections[$section_row]['line_feature2'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
<tr><td><?php echo $text_feature;?> 3:</td><td>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][line_feature3][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['line_feature3'][$language['language_id']]) ? $sections[$section_row]['line_feature3'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
<tr><td><?php echo $text_feature;?> 4:</td><td>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][line_feature4][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['line_feature4'][$language['language_id']]) ? $sections[$section_row]['line_feature4'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
<tr><td><?php echo $text_feature;?> 5:</td><td>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][line_feature5][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['line_feature5'][$language['language_id']]) ? $sections[$section_row]['line_feature5'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
<tr><td><?php echo $text_feature;?> 6:</td><td>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][line_feature6][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['line_feature6'][$language['language_id']]) ? $sections[$section_row]['line_feature6'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
<tr><td><?php echo $text_feature;?> 7:</td><td>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][line_feature7][<?php echo $language['language_id']; ?>]"  value="<?php echo isset($sections[$section_row]['line_feature7'][$language['language_id']]) ? $sections[$section_row]['line_feature7'][$language['language_id']] : ''; ?>" class="form-control" />
              </div><?php } ?>
                  </td></tr>
<tr><td><?php echo $text_feature;?> 8:</td><td>
                <?php foreach ($languages as $language) {?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[<?php echo $section_row; ?>][line_feature8][<?php echo $language['language_id']; ?>]" value="<?php echo isset($sections[$section_row]['line_feature8'][$language['language_id']]) ? $sections[$section_row]['line_feature8'][$language['language_id']] : ''; ?>" class="form-control" />
              </div>
              <?php  } ?>
                  </td></tr>
                 
  <tr><td><?php echo $text_more_desc;?></td><td>
					<?php foreach ($languages as $language) { ?>
<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><textarea name="sections[<?php echo $section_row; ?>][more_desc][<?php echo $language['language_id']; ?>]" rows="3" class="form-control"/><?php echo isset($sections[$section_row]['more_desc'][$language['language_id']]) ? $sections[$section_row]['more_desc'][$language['language_id']] : ''; ?></textarea></div>
				<?php } ?>		
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
	
	html += '<div class="heading-bar"> <?php echo $text_section; ?> #' + parseInt(section_row+1) + '</div>';
	
	html += '<div class="table-responsive">';
    html += '<table class="table table-bordered table-hover">';
	html += '    <tr><td width="150"><?php echo $text_image_icon;?></td><td>';
	
    html += '<a onclick="image_upload(\'section_image' + section_row + '\',\'thumb-thumb' + section_row + '\');" id="thumb-thumb' + section_row + '" class="hide img-thumbnail">';
    html += '<img src="<?php echo $placeholder;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>" id="section_image_thumb' + section_row + '"/>';
    html += '</a><input type="hidden" name="sections[' + section_row + '][image]" value="<?php echo $placeholder;?>" id="section_image' + section_row + '"/>';
                   
    html += '<a class="icon-preview">';
    html += '<i class="fa fa-rocket" id="section_icon_thumb' + section_row + '"></i>';
    html += '<input type="hidden" name="sections[' + section_row + '][icon]" value="fa fa-rocket" id="section_icon' + section_row + '" /></a> ';
		
	html += '</td></tr>';	
	html += '    <tr><td><?php echo $text_set_active;?></td><td>';
	html += '<select name="sections[' + section_row + '][state]" class="form-control">';
	html += '    <option value=""><?php echo $text_no;?></option>';	
	html += '    <option value="pricing-active"><?php echo $text_yes;?></option>';
	html += '    </select>';
	html += '    </td></tr>';	
	     
	html += '    <tr><td><?php echo $text_title;?>:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][title][<?php echo $language['language_id']; ?>]" class="form-control" value="Starter ' + parseInt(section_row+1) + '" /></div>';
				<?php } ?>
	html += '    </td></tr>';	
	html += '    <tr class="hide"><td><?php echo $text_description;?>:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][description][<?php echo $language['language_id']; ?>]" class="form-control" value="Description"/></div>';
				<?php } ?>
	html += '    </td></tr>';	
	
	
	
	html += '    <tr><td><?php echo $text_price;?>:</td><td>';		
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][line_price][<?php echo $language['language_id']; ?>]" class="form-control" value="49"/></div>';
				<?php } ?>	
	html += '    </td></tr>';	
	
	html += '    <tr><td><?php echo $text_currency_code;?>:</td><td>';
					<?php foreach ($languages as $language) { ?>
		html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][line_currency][<?php echo $language['language_id']; ?>]" class="form-control" value="$"/></div>';
				<?php } ?>
	html += '</td></tr>';
	
	
	html += '    <tr><td><?php echo $text_period;?>:</td><td>';
					<?php foreach ($languages as $language) { ?>
		html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][line_period][<?php echo $language['language_id']; ?>]" class="form-control" value="month"/></div>';
				<?php } ?>
	html += '</td></tr>';
	
	html += '    <tr><td><?php echo $text_button_title;?>:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][btn_title][<?php echo $language['language_id']; ?>]" class="form-control" value="Sign up"/></div>';
				<?php } ?>
	html += '</td></tr>';
	
	html += '    <tr><td></td><td>';
	
	html += '    <div class="row"><div class="col-sm-6 col-xs-6"><?php echo $text_button_link;?>';
	html += '<input type="text" name="sections[' + section_row + '][href]" id="sections' + section_row + '][href]" class="form-control" />';
	
	html += '    </div><div class="col-sm-6 col-xs-6">';
	html += '<label><?php echo $text_target;?> <select name="sections[' + section_row + '][target]" class="form-control">';
	html += '    <option value="_self"><?php echo $text_no;?></option>';	
	html += '    <option value="_blank"><?php echo $text_yes;?></option>';
	html += '    </select>';
	html += '    </div></div>';
	html += '<hr size="1"/></td></tr>';	
	
	
	
	
	
	html += '    <tr><td><?php echo $text_feature;?> 1:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][line_feature1][<?php echo $language['language_id']; ?>]" class="form-control" value="Feature 1"/></div>';
				<?php } ?>
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_feature;?> 2:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][line_feature2][<?php echo $language['language_id']; ?>]" class="form-control" value="Feature 2"/></div>';
				<?php } ?>
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_feature;?> 3:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][line_feature3][<?php echo $language['language_id']; ?>]" class="form-control" value="Feature 3"/></div>';
				<?php } ?>
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_feature;?> 4:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][line_feature4][<?php echo $language['language_id']; ?>]" class="form-control" value="Feature 4"/></div>';
				<?php } ?>
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_feature;?> 5:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][line_feature5][<?php echo $language['language_id']; ?>]" class="form-control" value="Feature 5"/></div>';
				<?php } ?>
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_feature;?> 6:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][line_feature6][<?php echo $language['language_id']; ?>]" class="form-control" value="Feature 6"/></div>';
				<?php } ?>
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_feature;?> 7:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][line_feature7][<?php echo $language['language_id']; ?>]" class="form-control" /></div>';
				<?php } ?>
	html += '    </td></tr>';	
	html += '    <tr><td><?php echo $text_feature;?> 8:</td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="sections[' + section_row + '][line_feature8][<?php echo $language['language_id']; ?>]" class="form-control" /></div>';
				<?php } ?>		
				
	html += '    </td></tr>';	
	
	html += '    <tr><td><?php echo $text_more_desc;?></td><td>';
					<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><text'+'area name="sections[' + section_row + '][line_feature8][<?php echo $language['language_id']; ?>]" rows="3" class="form-control"/></text'+'area></div>';
				<?php } ?>		
	html += '    </td></tr>';
	html += '    	</table>';
	html += '</div></div>';
	
	$('#section-tab.tab-content').append(html);
	
		$('#section_nav > li:last-child').before('<li><a href="#section-tab' + section_row + '" data-toggle="tab"><i class="icon-left fa fa-copy" onclick="cloneSection(' + section_row + ')" data-toggle="tooltip" title="<?php echo $text_copy_section;?>"></i>  <?php echo $text_section; ?> #' + parseInt(section_row+1) + ' <i class="icon-right fa fa-minus-circle" onclick="removeSection(' + section_row + ')"></i></li>');
		$('#section_nav a[href=\'#section-tab' + section_row + '\']').tab('show');
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});
		
	section_row++;
	$('#add_section').attr('data-section',parseInt(section_row));
}
//--></script> 