<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>

<div class="container-fluid">
<div class="col-md-5 col-sm-5 size-sm-12">   
<div class="block_relative header_otp_block">
            <div class="s_list">

<div class="form-group">
                    <label class="col-sm-12 control-label"> Change <?php echo $text_section;?></label>
                    <div class="col-sm-12">
<select name="change_section" id="change_section" class="form-control with-nav">
 <option value="0"> - New Section - </option>
              <?php foreach($sections as $section){?>
              <option value="<?php echo $section['section_id'];?>" <?php echo ($section['section_id']==$section_active_id)?'selected="selected"':'';?>><?php echo $section['section_name'];?> </option>
              <?php } ?> 
              </select> 
                  </div>
             </div><!--//form-group --> 
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_name;?></label>
<div class="col-sm-12">
<input type="text" name="section_info[section_name]" value="<?php echo $section_info['section_name'];?>" class="form-control">
       <input type="hidden" name="section_id" value="<?php echo $section_active_id;?>"/>
                     </div>
              </div>
              
 <div class="ds_content margin-top-20">
 
              <h4><?php echo $text_section_only;?></h4>  
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background_image;?></label>
<div class="col-sm-12">
<?php 
$background_image = ($section_info['section']['background-image'])?$section_info['section']['background-image']:'';
?>
<a id="thumb-section_background_image" data-toggle="imagex" class="img-thumbnail file-browse"><img src="<?php echo $background_image; ?>" alt="" title="" data-placeholder="<?php echo $background_image; ?>"/></a>
                 <input type="hidden" name="section_info[section][background-image]" value="<?php echo $section_info['section']['background-image'];?>" id="input-section_background_image"/>
                 
                     </div>
              </div>
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background_color;?></label>
<div class="col-sm-12">
<input class="form-control colorpicker" type="text" name="section_info[section][background-color]" value="<?php echo $section_info['section']['background-color'];?>">
                     </div>
              </div>
              
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background_position;?></label>
<div class="col-sm-12">

 <select name="section_info[section][background-position]" class="form-control data_set with-nav" data-set="bg_position" data-selected="<?php echo $section_info['section']['background-position'];?>" id="background-position"></select>
                     </div>
              </div>
              
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background_repeat;?></label>
<div class="col-sm-12">
 <select name="section_info[section][background-repeat]" class="form-control data_set with-nav" data-set="bg_repeat" data-selected="<?php echo $section_info['section']['background-repeat'];?>" id="background-repeat"></select>
                     </div>
              </div>
              <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background_attachment;?></label>
<div class="col-sm-12">
 <select name="section_info[section][background-attachment]" class="form-control data_set with-nav" data-set="bg_attachment" data-selected="<?php echo $section_info['section']['background-attachment'];?>" id="background-attachment"></select>
                     </div>
              </div><!--//form-group --> 
              
 
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_background_video;?></label>
<div class="col-sm-12">
<input class="form-control" type="text" name="section_info[background_video]" value="<?php echo $section_info['background_video'];?>">
                     </div>
              </div><!--//form-group --> 
              
 
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_paralax_level;?></label>
<div class="col-sm-12">
<input class="form-control with-val" data-min="-3" data-max="5" type="text" name="section_info[paralax_level]" value="<?php echo $section_info['paralax_level'];?>" id="paralax-level">
                     </div>
              </div><!--//form-group --> 
              
 
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $text_margin;?></label>
<div class="col-sm-8">
<input class="form-control" type="text" name="section_info[section][margin]" value="<?php echo $section_info['section']['margin'];?>">
                     </div>
              </div><!--//form-group --> 
              
 
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $text_padding;?></label>
<div class="col-sm-8">

<input class="form-control" type="text" name="section_info[section][padding]" value="<?php echo $section_info['section']['padding'];?>">
                     </div>
              </div><!--//form-group --> 
              
</div>   <!--//ds_content -->   

              </div><!-- module_list--> 
</div><!-- block_relative--> 
</div><!--//size-sm-12 --> 
<div class="col-md-7 col-sm-7 size-sm-12">   


             
 
<h4><?php echo $text_section_element;?></h4>  
 
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_text_align;?></label>
<div class="col-sm-12">

 <select name="section_info[element][text-align]" data-selected="<?php echo $section_info['element']['text-align'];?>" class="form-control data_set with-nav" data-set="text_align"></select>
 
                     </div>
              </div><!--//form-group -->
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_color;?></label>
<div class="col-sm-12">
<input class="form-control colorpicker" type="text" name="section_info[element][color]" value="<?php echo $section_info['element']['color'];?>">
                     </div>
              </div><!--//form-group --> 
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_border_color;?></label>
<div class="col-sm-12">
<input class="form-control colorpicker" type="text" name="section_info[element][border-color]" value="<?php echo $section_info['element']['border-color'];?>">
                     </div>
              </div><!--//form-group --> 
              
              
                   
<h4><?php echo $text_heading;?></h4>  
 
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_style;?></label>
                    <div class="col-sm-12"><select name="section_info[heading_class]" id="heading_class" data-selected="<?php echo $section_info['heading_class'];?>" class="form-control data_set with-nav" data-set="heading_title" onchange="MCP.switchClass('#section_heading_title ','<?php echo $section_info['heading_class'];?>',this.options[this.selectedIndex].value);"></select>
                    
                     </div>
              </div><!-- form-group--> 
  <div class="form-group margin-top-20 margin-bottom-20">
                    <div class="col-sm-12">
                    <div id="section_heading_title" class="<?php echo $section_info['heading_class'];?>">
				<h2 class="heading_title"><span class="line"></span>YOUR SECTION TITLE</h2>
			</div>
                     </div>
  </div><!-- form-group--> 
              
               
  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_font;?></label>
                    <div class="col-sm-12">
                    <select name="section_info[font]" id="heading_font" class="form-control data_set chosen-select" data-set="setfont" data-selected="<?php echo $section_info['font'];?>" onChange=" MCP.changeFontFamily('heading_font',this.options[this.selectedIndex].value);" data-selector="#section_heading_title .heading_title" data-attr="font-family" data-type="css"></select>
                      
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_font_size;?></label>
                    <div class="col-sm-12"><input type="text" name="section_info[heading][font-size]" id="heading_font_size" value="<?php echo ($section_info['heading']['font-size'])?$section_info['heading']['font-size']:20;?>" class="form-control with-val" data-min="8" data-max="36" data-selector="#section_heading_title .heading_title" data-attr="font-size" data-suffix="px" data-type="css"/>
                    
                     </div>
              </div><!-- form-group--> 
                  <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_font_weight;?></label>
                    <div class="col-sm-12"><select name="section_info[heading][font-weight]" id="heading_font_weight" data-selected="<?php echo $section_info['heading']['font-weight'];?>" data-set="font_weight"  class="form-control data_set with-nav" data-attr="font-weight" data-type="css" data-selector="#section_heading_title .heading_title"></select>
                    
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_font_style;?></label>
                    <div class="col-sm-12"><select name="section_info[heading][font-style]" data-selected="<?php echo $section_info['heading']['font-style'];?>" class="form-control data_set with-nav" data-set="font_style" data-attr="font-style" data-type="css"  data-selector="#section_heading_title .heading_title"></select>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_line_height;?></label>
                    <div class="col-sm-12"><input type="text" name="section_info[heading][line-height]" id="heading_line_height" value="<?php echo ($section_info['heading']['line-height'])?$section_info['heading']['line-height']:30;?>" class="form-control with-val" data-min="10" data-max="50" data-selector="#section_heading_title .heading_title" data-attr="line-height" data-suffix="px" data-type="css" />
                    
                     </div>
              </div><!-- form-group--> 
                     
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_transform;?></label>
                    <div class="col-sm-12"><select name="section_info[heading][text-transform]" id="heading-text-transform" data-selected="<?php echo $section_info['heading']['text-transform'];?>" data-set="text_transform" class="form-control data_set with-nav" data-attr="text-transform" data-selector="#section_heading_title .heading_title" data-type="css"></select>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_letter_spacing;?></label>
                    <div class="col-sm-12"><input type="text" name="section_info[heading][letter-spacing]" id="heading_letter_spacing"  value="<?php echo ($section_info['heading']['letter-spacing'])?$section_info['heading']['letter-spacing']:'0';?>" class="form-control with-val" data-min="-3" data-max="5"   data-attr="letter-spacing" data-suffix="px" data-type="css" data-selector="#section_heading_title .heading_title"/>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_color;?></label>
                    <div class="col-sm-12">
                      <input class="form-control colorpicker" type="text" name="section_info[heading][color]" id="heading_color" value="<?php echo $section_info['heading']['color'];?>" data-attr="color" data-type="css" data-selector="#section_heading_title .heading_title"/>
                     </div>
              </div><!-- form-group--> 

                   <div class="form-group">
            <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>
            <?php echo $help_section;?><button type="button" class="close" data-dismiss="alert">×</button>
   			 </div>
   			 </div>
             
             
</div><!--//size-sm-12 --> 

</div><!--//container-fluid --> 

             