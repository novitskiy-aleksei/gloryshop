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
 <div class="row">
 
 <div class="col-md-6 size-sm-12">
<ul class="color-mode pull-center">
                            
                               <li class="nav-header nav-header-top text-centerr clearfix">
                               
<a href="<?php echo $dashboard;?>" target="_blank" data-toggle="tooltip" title="<?php echo $text_go_to_admin;?>" class="btn ">
    <i class="fa fa-user"></i>
</a>
<a onclick="MCP.viewPerformance()" data-toggle="tooltip" title="<?php echo $text_performance;?>" class="btn "><i class="fa fa-signal"></i></a>
          
<a onclick="MCP.clearCache();" data-toggle="tooltip" title="<?php echo $text_clear_cache;?>" class="btn">
    <i class="fa fa-eraser"></i>
</a>                       
<a class="btn add-skin"><i class="fa fa-plus" data-toggle="tooltip" title="<?php echo $button_add_skin;?>"></i></a>
<?php if($skin_active_id!=$skin_id){?><a class="btn btn-xs change-skin" data-id="<?php echo $skin_active_id; ?>">
<i class="fa fa-refresh" data-toggle="tooltip" title="<?php echo $text_reset_skin;?>"></i></a><?php } ?>

                               </li>
                               <li class="nav-header clearfix">
                              <b><?php echo $text_skin;?>:</b> <a class="change-skin" data-id="<?php echo $skin_id; ?>"><?php echo $skin_name;?></a>
                              <?php if($skin_active_id!=$skin_id){?>
                              <div class="btn-group pull-right">
                               <a class="btn btn-xs delete-skin" data-id="<?php echo $skin_id; ?>"><i class="fa fa-times" data-toggle="tooltip" title="<?php echo $button_delete_skin;?>"></i></a>
                               <a class="btn btn-xs" id="active-skin" data-id="<?php echo $skin_id; ?>"><i class="fa fa-flash" data-toggle="tooltip" title="<?php echo $text_active_skin;?>"></i></a>
                               </div>
                               <?php } ?>
                               </li>
                               <hr size="1" />
                          <?php foreach($skins as $skin){?>
                                      <li class="nav-kin <?php echo ($skin_id==$skin['skin_id'])?'active':'';?>" style="background-color:<?php echo $skin['color'];?>;"><a class="change-skin" data-id="<?php echo $skin['skin_id']; ?>" data-toggle="tooltip" title="<?php echo $skin['skin_name'];?>">&nbsp;</a></li>
                              <?php } ?>
                            </ul>
 <h4><?php echo $text_general;?></h4>
 
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_skin_name; ?></label>
<div class="col-sm-12">
                    <input type="text" name="skin_name" value="<?php echo $skin_name; ?>" class="form-control"/>
                     </div>
              </div><!-- form-group--> 
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_profile_color; ?></label>
<div class="col-sm-12">
                    <input type="text" id="profile_color" name="theme_setting[skin_color]" value="<?php echo $skin_color; ?>" class="colorpicker form-control"/>
                     </div>
              </div><!-- form-group--> 
              
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_direction; ?></label>
<div class="col-sm-12">
                        <?php foreach ($languages as $language){ ?>      
                        <div class="lang-field">              
                          <img src="image/flags/<?php echo $language['image'];?>" class="with-tooltip" title="<?php echo $language['name'];?>"/>                      
              <select name="skin_lang_dir[<?php echo $language['code'];?>]" class="form-control">
                  <option value="ltr" <?php if(isset($skin_lang_dir[$language['code']])){if($skin_lang_dir[$language['code']]=='ltr'){ echo ' selected="selected"'; }} ?>><?php echo $text_ltr;?></option>
                  <option value="rtl" <?php if(isset($skin_lang_dir[$language['code']])){if($skin_lang_dir[$language['code']]=='rtl'){ echo ' selected="selected"'; }} ?>><?php echo $text_rtl;?></option>
              </select>
                             
                       </div><!--lang-field --> 
                       <?php } ?>
                     </div>
              </div><!-- form-group--> 
              
              
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_layout_style; ?></label>
<div class="col-sm-12">
             
              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($body_style=='body_wide'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $body_style;?>','body_wide');">
        <input type="radio" name="theme_setting[body_style]" value="body_wide" <?php if($body_style=='body_wide'){ echo 'checked';}?>/><?php echo $text_wide;?></label>
    <label class="btn btn-xs btn-info <?php if($body_style=='body_boxed'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $body_style;?>','body_boxed');">
        <input type="radio" name="theme_setting[body_style]" value="body_boxed" <?php if($body_style=='body_boxed'){ echo 'checked';}?>/><?php echo $text_boxed;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_animated; ?></label>
<div class="col-sm-12">
             
              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($animated=='with-animated'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $animated;?>','with-animated');">
        <input type="radio" name="theme_setting[animated]" value="with-animated" <?php if($animated=='with-animated'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
        
    <label class="btn btn-xs btn-info <?php if($animated=='without-animated'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $animated;?>','without-animated');">
        <input type="radio" name="theme_setting[animated]" value="without-animated" <?php if($animated=='without-animated'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
          
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_color_mode; ?></label>
<div class="col-sm-12">
						
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($color_mode=='body_light'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $color_mode;?>','body_light');">
        <input type="radio" name="theme_setting[color_mode]" value="body_light" <?php if($color_mode=='body_light'){ echo 'checked';}?>/><?php echo $text_light;?></label>
    <label class="btn btn-xs btn-info <?php if($color_mode=='body_dark'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $color_mode;?>','body_dark');">
        <input type="radio" name="theme_setting[color_mode]" value="body_dark" <?php if($color_mode=='body_dark'){ echo 'checked';}?>/><?php echo $text_dark;?></label>
</div>
</div>
              
              </div><!-- form-group-->   
            
              
              
              <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_back_top; ?></label>
<div class="col-sm-12">
                 
              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($back_to_top==1){ echo 'active tr_click';}?>" onclick="MCP.switchClass('#scroll_to_top','','<?php echo ($back_to_top==1)?'nhide':'hide'; ?>');">
        <input type="radio" name="theme_setting[back_to_top]" value="1" <?php if($back_to_top==1){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($back_to_top==0){ echo 'active tr_click';}?>" onclick="MCP.switchClass('#scroll_to_top','','<?php echo ($back_to_top==0)?'nhide':'hide'; ?>');">
        <input type="radio" name="theme_setting[back_to_top]" value="0" <?php if($back_to_top==0){ echo 'checked';}?>/><?php echo $text_hide;?></label>
</div>
                     </div>
              </div><!-- form-group-->    
              
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_logo; ?></label>
<div class="col-sm-12">

              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($custom_logo==0){ echo 'active tr_click';}?>" onclick="MCP.activeObj('custom_logo',0);">
        <input type="radio" name="theme_setting[custom_logo]" value="0" <?php if($custom_logo==0){ echo 'checked';}?>/><?php echo $text_default;?></label>
    <label class="btn btn-xs btn-info <?php if($custom_logo==1){ echo 'active tr_click';}?>" onclick="MCP.activeObj('custom_logo',1);">
        <input type="radio" name="theme_setting[custom_logo]" value="1" <?php if($custom_logo==1){ echo 'checked';}?>/><?php echo $text_colored;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
              
             <div class="form-group custom_logo otp-1" style="display:<?php echo ($custom_logo==0)?'none':'block';?>">
                <label class="col-sm-12 control-label"><?php echo $text_logo; ?></label>
<div class="col-sm-12">
                <a id="thumb-config_custom_logo" data-toggle="imagex" class="img-thumbnail file-browse" data-previewsrc="logo"><img src="<?php echo ($config_custom_logo)?$config_custom_logo:'';?>" alt="" title="" data-placeholder="<?php echo ($config_custom_logo)?$config_custom_logo:'';?>"/></a>
                  <i class="fa fa-trash-o clear-img"></i><input type="hidden" name="theme_setting[config_custom_logo]" value="<?php echo $config_custom_logo; ?>" id="input-config_custom_logo" data-selector=".site-logo img" data-attr="src"/>
                </div>
              </div>

<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_default_btn;?></label>
                    <div class="col-sm-12"><select name="theme_setting[default_btn]" id="default_btn"class="form-control with-nav" onchange="MCP.switchClass('#default_btn_style','<?php echo $default_btn;?>',this.options[this.selectedIndex].value);">
                    <option value="default-btn"  <?php echo ($default_btn=='default-btn')?'selected="selected"':'';?>>Default Color</option>
                    <option value="btn-default-base"  <?php echo ($default_btn=='btn-default-base')?'selected="selected"':'';?>>Base Profile Color</option>
                    <option value="btn-default-grey"  <?php echo ($default_btn=='btn-default-grey')?'selected="selected"':'';?>>Grey Color</option>
                    <option value="btn-default-dark"  <?php echo ($default_btn=='btn-default-dark')?'selected="selected"':'';?>>Dark Color</option>
                    <option value="btn-default-blue"  <?php echo ($default_btn=='btn-default-blue')?'selected="selected"':'';?>>Blue Color</option>
                    <option value="btn-default-turquoise"  <?php echo ($default_btn=='btn-default-turquoise')?'selected="selected"':'';?>>Turquoise Color</option>
                    <option value="btn-default-green"  <?php echo ($default_btn=='btn-default-green')?'selected="selected"':'';?>>Green Color</option>
                    <option value="btn-default-lime"  <?php echo ($default_btn=='btn-default-lime')?'selected="selected"':'';?>>Lime Color</option>
                    <option value="btn-default-yellow"  <?php echo ($default_btn=='btn-default-yellow')?'selected="selected"':'';?>>Yellow Color</option>
                    <option value="btn-default-orange"  <?php echo ($default_btn=='btn-default-orange')?'selected="selected"':'';?>>Orange Color</option>
                    <option value="btn-default-red"  <?php echo ($default_btn=='btn-default-red')?'selected="selected"':'';?>>Red Color</option>
                    <option value="btn-default-purple"  <?php echo ($default_btn=='btn-default-purple')?'selected="selected"':'';?>>Purple Color</option>
                    <option value="btn-default-brown"  <?php echo ($default_btn=='btn-default-brown')?'selected="selected"':'';?>>Brown Color</option>                    </select>
                     </div>
              </div><!-- form-group--> 
  <div class="form-group margin-top-20 margin-bottom-20">
                    <div class="col-sm-12">
                    <div id="default_btn_style" class="<?php echo $default_btn;?>">
				<a class="btn btn-default">Default Button</a>
			</div>
                     </div>
  </div><!-- form-group--> 
  
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_primary_btn;?></label>
                    <div class="col-sm-12"><select name="theme_setting[primary_btn]" id="primary_btn"class="form-control with-nav" onchange="MCP.switchClass('#primary_btn_style','<?php echo $primary_btn;?>',this.options[this.selectedIndex].value);">
                    <option value="btn-primary-base"  <?php echo ($primary_btn=='btn-primary-base')?'selected="selected"':'';?>>Base Profile Color</option>
                    <option value="btn-primary-grey"  <?php echo ($primary_btn=='btn-primary-grey')?'selected="selected"':'';?>>Grey Color</option>
                    <option value="btn-primary-dark"  <?php echo ($primary_btn=='btn-primary-dark')?'selected="selected"':'';?>>Dark Color</option>
                    <option value="btn-primary-blue"  <?php echo ($primary_btn=='btn-primary-blue')?'selected="selected"':'';?>>Blue Color</option>
                    <option value="btn-primary-turquoise"  <?php echo ($primary_btn=='btn-primary-turquoise')?'selected="selected"':'';?>>Turquoise Color</option>
                    <option value="btn-primary-green"  <?php echo ($primary_btn=='btn-primary-green')?'selected="selected"':'';?>>Green Color</option>
                    <option value="btn-primary-lime"  <?php echo ($primary_btn=='btn-primary-lime')?'selected="selected"':'';?>>Lime Color</option>
                    <option value="btn-primary-yellow"  <?php echo ($primary_btn=='btn-primary-yellow')?'selected="selected"':'';?>>Yellow Color</option>
                    <option value="btn-primary-orange"  <?php echo ($primary_btn=='btn-primary-orange')?'selected="selected"':'';?>>Orange Color</option>
                    <option value="btn-primary-red"  <?php echo ($primary_btn=='btn-primary-red')?'selected="selected"':'';?>>Red Color</option>
                    <option value="btn-primary-purple"  <?php echo ($primary_btn=='btn-primary-purple')?'selected="selected"':'';?>>Purple Color</option>
                    <option value="btn-primary-brown"  <?php echo ($primary_btn=='btn-primary-brown')?'selected="selected"':'';?>>Brown Color</option>                    </select>
                     </div>
              </div><!-- form-group--> 
  <div class="form-group margin-top-20 margin-bottom-20">
                    <div class="col-sm-12">
                    <div id="primary_btn_style" class="<?php echo $primary_btn;?>">
				<a class="btn btn-primary">Primary Button</a>
			</div>
                     </div>
  </div><!-- form-group--> 
 </div><!-- //ds_content--> 
 <div class="col-md-6 size-sm-12"> 
 <div class="ds_accordion">
 
 <h4><?php echo $text_preloader;?></h4>
 
   <div class="form-group">
                    <div class="col-sm-12"><select name="theme_setting[preloader]" id="page_preloader" data-selected="<?php echo $preloader;?>" class="form-control with-nav"onchange="MCP.switchClass('#section_preloader','<?php echo $preloader;?>',this.options[this.selectedIndex].value);">
                    <option value="" <?php echo ($preloader=='')?'selected="selected"':'';?>><?php echo $text_none;?></option>
                    <option value="preloader1" <?php echo ($preloader=='preloader1')?'selected="selected"':'';?>><?php echo $text_style;?> 1</option>
                    <option value="preloader2" <?php echo ($preloader=='preloader2')?'selected="selected"':'';?>><?php echo $text_style;?> 2</option>
                    <option value="preloader3" <?php echo ($preloader=='preloader3')?'selected="selected"':'';?>><?php echo $text_style;?> 3</option>
                    </select>
                    
                     </div>
              </div><!-- form-group--> 
  <div class="form-group margin-top-20 margin-bottom-20 clearfix">
                    <div class="col-sm-12">
                    <div id="section_preloader" class="<?php echo $preloader;?>" style="position:relative; min-height:80px;">
                    <div id="preloader" style="position:relative;">
                        <div class="spinner">
                            <div class="sk-dot1"></div><div class="sk-dot2"></div>
                            <div class="rect3"></div><div class="rect4"></div>
                            <div class="rect5"></div>
                        </div>
                    </div><!-- //preloader--> 
			</div>
                     </div>
  </div><!-- form-group--> 
 
 <h4><?php echo $text_general_color;?></h4>
 
 <div class="ds_content">
            <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_font;?></label>
<div class="col-sm-12">      
                    <select name="theme_setting[body_font]" id="body_font" class="form-control data_set chosen-select" data-set="setfont" data-selected="<?php echo $body_font;?>" onChange="MCP.changeFontFamily('body_font',this.options[this.selectedIndex].value)" data-selector="body" data-attr="font-family" data-type="css" data-css-media="all"></select>     
                     </div>
              </div><!-- form-group-->
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_font_size;?></label>
<div class="col-sm-12"> <input type="text" name="theme_setting[body_css][body_font_size]" id="body_font_size" value="<?php echo ($body_css['body_font_size'])?$body_css['body_font_size']:12;?>" data-selector="body" data-attr="font-size" data-suffix="px" size="6" class="form-control with-val" data-min="8" data-max="36" data-type="css"/>
                    
                     </div>
              </div><!-- form-group-->
<div class="form-group">
                    <label class="col-sm-12 control-label"></b><?php echo $text_font_weight;?></label>
<div class="col-sm-12"> <select name="theme_setting[body_css][body_font_weight]" id="body_font_weight" class="form-control data_set with-nav" data-set="font_weight" data-trigger="change" data-selected="<?php echo $body_css['body_font_weight'];?>" data-selector="body" data-attr="font-weight" data-css-media="all"></select>
                     </div>
              </div><!-- form-group-->
				<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_letter_spacing;?></label>
<div class="col-sm-12"> <input type="text" data-attr="letter-spacing" name="theme_setting[body_css][body_letter_spacing]" id="body_letter_spacing"  value="<?php echo ($body_css['body_letter_spacing'])?$body_css['body_letter_spacing']:'0';?>" size="6" data-selector="body" data-suffix="px" class="form-control with-val" data-min="-3" data-max="5"/>
                     </div>
              </div><!-- form-group-->
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_text_color;?></label>
<div class="col-sm-12"> <input class="form-control colorpicker" type="text" name="theme_setting[body_css][body_color]" id="body_color" value="<?php echo $body_css['body_color'];?>" data-selector="body" data-attr="color"/>
                     </div>
              </div><!-- form-group-->
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_link_color;?></label>
<div class="col-sm-12"> <input class="form-control colorpicker" type="text" name="theme_setting[body_css][link_color]" value="<?php echo $body_css['link_color'];?>" id="link_color" data-selector="body a" data-attr="color" data-type="css" data-css-media="all"/>
                     </div>
              </div><!-- form-group-->
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_link_hover_color;?></label>
<div class="col-sm-12"> <input class="form-control colorpicker" type="text" name="theme_setting[body_css][link_hover_color]" id="link_hover_color" value="<?php echo $body_css['link_hover_color'];?>" data-selector="a:hover" data-attr="color" data-type="css" data-css-media="all" data-suffix=" !important"/>
                     </div>
              </div><!-- form-group-->
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_link_active_color;?></label>
<div class="col-sm-12"> <input class="form-control colorpicker" type="text" name="theme_setting[body_css][link_active_color]" id="link_active_color" value="<?php echo $body_css['link_active_color'];?>" data-selector="a:active" data-attr="color" data-type="css" data-css-media="all" data-suffix=" !important"/>
                     </div>
              </div><!-- form-group-->
                  
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_selected_bg;?></label>
<div class="col-sm-12"> <input class="form-control colorpicker" type="text" name="theme_setting[body_css][selection_bg]" id="selection_bg" value="<?php echo $body_css['selection_bg'];?>" data-selector="::selection" data-attr="background" data-type="css" data-css-media="all" data-suffix=" !important"/>
                     </div>
              </div><!-- form-group-->
			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_selected_color;?></label>
<div class="col-sm-12"> <input class="form-control colorpicker" type="text" name="theme_setting[body_css][selection_color]" id="selection_color" value="<?php echo $body_css['selection_color'];?>" data-selector="::selection" data-attr="color" data-type="css" data-css-media="all" data-suffix=" !important"/>
                     </div>
              </div><!-- form-group-->
             
            <div class="form-group">
                    <label class="col-sm-12 control-label">Heading <?php echo $text_font;?></label>
<div class="col-sm-12">      
                    <select name="theme_setting[heading_font]" id="heading_font" class="form-control data_set chosen-select" data-set="setfont" data-selected="<?php echo $heading_font;?>" onChange="MCP.changeFontFamily('heading_font',this.options[this.selectedIndex].value)" data-selector=".heading_title,.heading_title h3,.heading_title h2" data-attr="font-family" data-type="css" data-css-media="all"></select>     
                     </div>
              </div><!-- form-group-->
              
</div><!--//ds_content --> 
          
 <h4><?php echo $text_boxed_style;?></h4>
 
 <div class="ds_content">     
            
			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background_image ;?></label>
<div class="col-sm-12"> 
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($body_bg==0){ echo 'active tr_click';}?>" onclick="MCP.activeObj('body_bg',0);">
        <input type="radio" name="theme_setting[body_bg]" value="0" <?php if($body_bg==0){ echo 'checked';}?>/><?php echo $text_preset;?></label>
    <label class="btn btn-xs btn-info <?php if($body_bg==1){ echo 'active tr_click';}?>" onclick="MCP.activeObj('body_bg',1);">
        <input type="radio" name="theme_setting[body_bg]" value="1" <?php if($body_bg==1){ echo 'checked';}?>/><?php echo $text_own;?></label>
</div>
                          
                      
                     </div>
              </div><!-- form-group-->
                  <div class="form-group body_bg otp-0">
                    <label class="col-sm-12 control-label">
                    <?php echo $text_preset;?></label>
<div class="col-sm-12"> 
                    <div class="image"> <img src="<?php echo ($body_css['body_bg_image'])?$body_css['body_bg_image']:'';?>" alt="" id="body_bg_image_thumb" style=" max-width:100px; max-height:100px;"/>
                        <input type="hidden" id="body_bg_image" name="theme_setting[body_css][body_bg_image]" value="<?php echo $body_css['body_bg_image'];?>" data-selector="body" data-attr="background-image"/>
                        <br/>
                        <a onclick="MCP.bg_select('body_bg_image', '#body_bg_image_preview', 'body_bg_image_thumb');"><?php echo $text_browse;?></a>&nbsp;&nbsp;|&nbsp;&nbsp; <a onclick="MCP.destroyAttr('#body_bg_image');$('#body_bg_image_thumb').attr('src', '');"><?php echo $text_clear;?></a></div>
                     
                     </div>
              </div><!-- form-group-->
                 <div class="form-group body_bg otp-1">
                     <label class="col-sm-12 control-label">
                      <?php echo $text_own;?></label>
<div class="col-sm-12"> 
                    <a id="thumb-body_bg_custom_image" data-toggle="imagex" class="img-thumbnail file-browse"><img src="<?php echo ($body_css['body_bg_custom_image'])?$body_css['body_bg_custom_image']:'';?>" alt="" title="" data-placeholder="<?php echo ($body_css['body_bg_custom_image'])?$body_css['body_bg_custom_image']:'';?>"/></a>
                 <input type="hidden" name="theme_setting[body_css][body_bg_custom_image]" value="<?php echo $body_css['body_bg_custom_image'];?>" id="input-body_bg_custom_image" data-selector="body" data-attr="background-image"/>
                  
                  </div>
              </div><!-- form-group-->
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background_color ;?></label>
<div class="col-sm-12"> 
                    <input class="form-control colorpicker" type="text" name="theme_setting[body_css][body_bg_color]" id="body_bg_color" value="<?php echo $body_css['body_bg_color'];?>" data-selector="body" data-attr="background-color"/>
                    
                     </div>
              </div><!-- form-group-->
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background_position ;?></label>
<div class="col-sm-12"> 
                    <select name="theme_setting[body_css][body_bg_position]" class="form-control data_set with-nav" data-set="bg_position" data-selected="<?php echo $body_css['body_bg_position'];?>" id="body_bg_position" data-selector="body" data-attr="background-position"></select>
                    
                    
                     </div>
              </div><!-- form-group-->
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background_repeat;?></label>
<div class="col-sm-12"> 
                    <select name="theme_setting[body_css][body_bg_repeat]" class="form-control data_set with-nav" data-set="bg_repeat" data-selected="<?php echo $body_css['body_bg_repeat'];?>" id="body_bg_repeat" data-selector="body" data-attr="background-repeat"></select>
                    
                     </div>
              </div><!-- form-group-->
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background_attachment;?></label>
<div class="col-sm-12"> 
                    <select name="theme_setting[body_css][body_bg_attachment]" class="form-control data_set with-nav" data-set="bg_attachment" data-selected="<?php echo $body_css['body_bg_attachment'];?>" id="body_bg_attachment" data-selector="body" data-attr="background-attachment"></select>
                    
                     </div>
              </div><!-- form-group-->
              
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background_size;?></label>
<div class="col-sm-12"> 
                    <select name="theme_setting[body_css][body_bg_size]" class="form-control data_set with-nav" data-set="bg_size" data-selected="<?php echo $body_css['body_bg_size'];?>" id="body_bg_size" data-selector="body" data-attr="background-size"></select>
                    
                     </div>
              </div><!-- form-group-->
              
      </div><!--//ds_content --> 
 
 
</div><!--//ds_accordion --> 
</div><!-- size--> 
 
</div><!-- row--> 
</div><!-- container-fluid--> 
 
 