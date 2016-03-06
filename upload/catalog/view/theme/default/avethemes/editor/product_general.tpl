<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>

<div class="container-fluid ds_accordion">

 <h4><?php echo $entry_product_name;?></h4>
 <div class="ds_content">
 
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_font;?>
                    </label>
<div class="col-sm-12">       
                    <select name="theme_setting[name_font]" id="name_font" class="form-control data_set chosen-select" data-set="setfont" data-selected="<?php echo $name_font;?>" onChange=" MCP.changeFontFamily('name_font',this.options[this.selectedIndex].value);" data-selector=".item_product_name" data-attr="font-family" data-type="css" data-css-media="all"></select>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_font_size;?></label>
<div class="col-sm-12">
                    <input type="text" name="theme_setting[catalog_css][name_font_size]" id="name_font_size" value="<?php echo ($catalog_css['name_font_size'])?$catalog_css['name_font_size']:12;?>" data-selector=".item_product_name" data-attr="font-size" data-suffix="px" size="6" class="form-control with-val" data-min="8" data-max="36"/>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"></b><?php echo $text_font_weight;?></label>
<div class="col-sm-12"><select name="theme_setting[catalog_css][name_font_weight]" id="name_font_weight" class="form-control data_set with-nav" data-set="font_weight" data-selected="<?php echo $catalog_css['name_font_weight'];?>" data-selector=".item_product_name" data-attr="font-weight" data-type="css" data-css-media="all"></select>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_font_style;?></label>
<div class="col-sm-12"><select name="theme_setting[catalog_css][name_font_style]" class="form-control data_set with-nav" data-set="font_style" data-trigger="change" data-selected="<?php echo $catalog_css['name_font_style'];?>" data-selector=".item_product_name" data-attr="font-style" data-type="css" data-css-media="all"></select>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_transform;?></label>
<div class="col-sm-12"><select id="name_text_transform" name="theme_setting[catalog_css][name_text_transform]" class="form-control data_set with-nav" data-set="text_transform" data-trigger="change" data-selected="<?php echo $catalog_css['name_text_transform'];?>" data-selector=".item_product_name" data-attr="text-transform" data-type="css" data-css-media="all"></select>
                     </div>
              </div><!-- form-group--> 
                  
				<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_letter_spacing;?></label>
<div class="col-sm-12"><input type="text" data-attr="letter-spacing" name="theme_setting[catalog_css][name_letter_spacing]" id="name_letter_spacing"  value="<?php echo ($catalog_css['name_letter_spacing'])?$catalog_css['name_letter_spacing']:'0';?>" size="6" data-selector=".item_product_name" data-suffix="px" class="form-control with-val" data-min="-3" data-max="5"/>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_color;?></label>
<div class="col-sm-12"><input class="form-control colorpicker" type="text" name="theme_setting[catalog_css][name_color]" id="name_color" value="<?php echo $catalog_css['name_color'];?>" data-selector=".item_product_name" data-attr="color"/>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_mouseover_color;?></label>
<div class="col-sm-12"><input class="form-control colorpicker" type="text" name="theme_setting[catalog_css][name_hover_color]" value="<?php echo $catalog_css['name_hover_color'];?>" id="name_hover_color" data-selector=".page-item h3:hover a" data-attr="color" data-type="css" data-css-media="all"/>
                     </div>
              </div><!-- form-group--> 
              
              
 </div><!--//ds_content-->    
 <h4><?php echo $text_product_price;?></h4>
 <div class="ds_content">
 
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_font;?></label>
<div class="col-sm-12">       
                    <select name="theme_setting[price_font]" id="price_font" class="form-control data_set chosen-select" data-set="setfont" data-selected="<?php echo $price_font;?>" onChange="MCP.changeFontFamily('price_font',this.options[this.selectedIndex].value)" data-selector=".page-item .price span,.page-item .price .price-new,.page-item .price .price-old" data-attr="font-family" data-type="css" data-css-media="all"></select>
                    
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_font_size;?></label>
<div class="col-sm-12"><input type="text" name="theme_setting[catalog_css][price_font_size]" id="price_font_size" value="<?php echo ($catalog_css['price_font_size'])?$catalog_css['price_font_size']:12;?>" data-selector=".price" data-attr="font-size" data-suffix="px" size="6" class="form-control with-val" data-min="8" data-max="36"/>
                    
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"></b><?php echo $text_font_weight;?></label>
<div class="col-sm-12"><select name="theme_setting[catalog_css][price_font_weight]" id="price_font_weight" class="form-control data_set with-nav" data-set="font_weight" data-trigger="change" data-selected="<?php echo $catalog_css['price_font_weight'];?>" data-selector=".page-item .price span,.page-item .price .price-new,.page-item .price .price-old" data-attr="font-weight" data-type="css" data-css-media="all"></select>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_price_new;?></label>
<div class="col-sm-12"><input class="form-control colorpicker" type="text" name="theme_setting[catalog_css][price_new_color]" id="price_new_color" value="<?php echo $catalog_css['price_new_color'];?>" data-selector=".price .price-new" data-attr="color"/>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_price_old;?></label>
<div class="col-sm-12"><input class="form-control colorpicker" type="text" name="theme_setting[catalog_css][price_old_color]" value="<?php echo $catalog_css['price_old_color'];?>" id="price_old_color" data-selector=".page-item .price .price-old,.price .price-old" data-attr="color" data-type="css" data-css-media="all"/>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_price_tax;?></label>
<div class="col-sm-12"><input class="form-control colorpicker" type="text" name="theme_setting[catalog_css][price_tax_color]" id="price_tax_color" value="<?php echo $catalog_css['price_tax_color'];?>" data-selector=".price .price-tax" data-attr="color" data-type="css" data-css-media="all" data-suffix=" !important"/>
                     </div>
              </div><!-- form-group--> 
                  
				<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_letter_spacing;?></label>
<div class="col-sm-12"><input type="text" name="theme_setting[catalog_css][price_letter_spacing]" id="price_letter_spacing"  value="<?php echo ($catalog_css['price_letter_spacing'])?$catalog_css['price_letter_spacing']:'0';?>" size="6" data-selector=".page-item .price"  data-attr="letter-spacing" data-suffix="px" class="form-control with-val" data-min="-3" data-max="5"/>
                     </div>
              </div><!-- form-group--> 
 </div><!--//ds_content-->    
 <h4><?php echo $text_rating_star;?></h4>
 <div class="ds_content">
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_color; ?></label>
<div class="col-sm-12"><input class="form-control colorpicker" type="text" name="theme_setting[catalog_css][rating_color]" value="<?php echo $catalog_css['rating_color'];?>" id="catalog_css" data-selector=".item-rating span:before" data-attr="color" data-type="css" data-css-media="all"/>
                     </div>
              </div><!-- form-group-->       
    
 </div><!--//ds_content rating_star-->
 


 <h4><?php echo $text_module_item;?></h4>
 <div class="ds_content">
     
     <h4><?php echo $entry_product_name;?></h4>
     
              		<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_name_display;?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($name_display_type=='name_1line'){ echo 'active tr_click';}?>" onclick="MCP.activeObj('name_display_type','name_1line');MCP.switchClass('body','<?php echo $name_display_type;?>','name_1line');">
        <input type="radio" name="theme_setting[name_display_type]" value="name_1line" <?php if($name_display_type=='name_1line'){ echo 'checked';}?>/>Single <?php echo $text_line;?></label>
    <label class="btn btn-xs btn-info <?php if($name_display_type=='name_2line'){ echo 'active tr_click';}?>" onclick="MCP.activeObj('name_display_type','name_2line');MCP.switchClass('body','<?php echo $name_display_type;?>','name_2line');">
        <input type="radio" name="theme_setting[name_display_type]" value="name_2line" <?php if($name_display_type=='name_2line'){ echo 'checked';}?>/>Multi <?php echo $text_line;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
              
            <div class="alert alert-info  name_display_type otp-name_1line" style="display:none;">
            <i class="fa fa-exclamation-circle"></i>
            <?php echo $help_name_display_0;?>
            <button type="button" class="close" data-dismiss="alert">×</button>
   			 </div>
             
            <div class="alert alert-info  name_display_type otp-name_2line" style="display:none;">
            <i class="fa fa-exclamation-circle"></i>
            <?php echo $help_name_display_1;?>
            <button type="button" class="close" data-dismiss="alert">×</button>
   			 </div>
            
               			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_btn_quickview;?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($btn_quickview=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[btn_quickview]" value="1" <?php if($btn_quickview=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($btn_quickview=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[btn_quickview]" value="0" <?php if($btn_quickview=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
             
              		<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_btn_cart;?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($btn_cart=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[btn_cart]" value="1" <?php if($btn_cart=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($btn_cart=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[btn_cart]" value="0" <?php if($btn_cart=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
             
     
             
              		<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_btn_whistlist;?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($btn_whistlist=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[btn_whistlist]" value="1" <?php if($btn_whistlist=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($btn_whistlist=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[btn_whistlist]" value="0" <?php if($btn_whistlist=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
             
    
              		<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_btn_compare;?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($btn_compare=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[btn_compare]" value="1" <?php if($btn_compare=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($btn_compare=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[btn_compare]" value="0" <?php if($btn_compare=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
             
    
                        
 </div><!--//ds_content-->    


 <h4><?php echo $text_module_ribbon;?></h4>
 <div class="ds_content">
 
    
              		<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_special;?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($ribbon_special_status=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[ribbon_special_status]" value="1" <?php if($ribbon_special_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($ribbon_special_status=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[ribbon_special_status]" value="0" <?php if($ribbon_special_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
             <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background; ?></label>
<div class="col-sm-12"><input class="form-control colorpicker" type="text" name="theme_setting[catalog_css][special_bg]" value="<?php echo $catalog_css['special_bg'];?>" id="special_bg" data-selector=".item_img .ribbon_circle.special" data-attr="background" data-type="css" data-css-media="all"/>
                     </div>
              </div><!-- form-group--> 
    
    
              		<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_featured;?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($ribbon_featured_status=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[ribbon_featured_status]" value="1" <?php if($ribbon_featured_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($ribbon_featured_status=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[ribbon_featured_status]" value="0" <?php if($ribbon_featured_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
              
             <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background; ?></label>
<div class="col-sm-12"><input class="form-control colorpicker" type="text" name="theme_setting[catalog_css][featured_bg]" value="<?php echo $catalog_css['featured_bg'];?>" id="featured_bg" data-selector=".item_img .ribbon_circle.featured" data-attr="background" data-type="css" data-css-media="all"/>
                     </div>
              </div><!-- form-group--> 
              
              
              		<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_latest;?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($ribbon_latest_status=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[ribbon_latest_status]" value="1" <?php if($ribbon_latest_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($ribbon_latest_status=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[ribbon_latest_status]" value="0" <?php if($ribbon_latest_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
              
             <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background; ?></label>
<div class="col-sm-12"><input class="form-control colorpicker" type="text" name="theme_setting[catalog_css][latest_bg]" value="<?php echo $catalog_css['latest_bg'];?>" id="latest_bg" data-selector=".item_img .ribbon_circle.latest_bg" data-attr="background" data-type="css" data-css-media="all"/>
                     </div>
              </div><!-- form-group--> 
              
              
              		<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_bestseller;?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($ribbon_bestseller_status=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[ribbon_bestseller_status]" value="1" <?php if($ribbon_bestseller_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($ribbon_bestseller_status=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[ribbon_bestseller_status]" value="0" <?php if($ribbon_bestseller_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
              
             <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_background; ?></label>
<div class="col-sm-12"><input class="form-control colorpicker" type="text" name="theme_setting[catalog_css][bestseller_bg]" value="<?php echo $catalog_css['bestseller_bg'];?>" id="bestseller_bg" data-selector=".item_img .ribbon_circle.bestseller_bg" data-attr="background" data-type="css" data-css-media="all"/>
                     </div>
              </div><!-- form-group--> 
              
         
            <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>
            <?php echo $help_product_module;?><button type="button" class="close" data-dismiss="alert">×</button>
   			 </div>
 </div><!--//ds_content-->    
  <h4><?php echo $text_product_details;?></h4>
 <div class="ds_content">     
 		<h4><?php echo $text_image_view;?></h4>
            
              <div class="form-group">
<div class="col-sm-12">
 <select name="theme_setting[product_binding][image_type]" class="form-control tr_change" onchange="MCP.activeObj('image_preview_type',this.value);">
                        <option value="0" <?php echo ($product_binding['image_type']==0)?'selected="selected"':'';?>>Magnific Popup</option>
                        <option value="1" <?php echo ($product_binding['image_type']==1)?'selected="selected"':'';?>>Elevate Zoom</option>
                        </select>

                     </div>
              </div><!-- form-group--> 
            <div class="form-group image_preview_type otp-1">
                    <label class="col-sm-12 control-label"><?php echo $entry_zoom_type;?></label>
<div class="col-sm-12">
                    <select name="theme_setting[product_binding][zoom_type]" class="form-control tr_change" onchange="MCP.activeObj('zoom_type',this.value);">
                        <option value="external" <?php echo ($product_binding['zoom_type']=='external')?'selected="selected"':'';?>>External</option>
                        <option value="lens" <?php echo ($product_binding['zoom_type']=='lens')?'selected="selected"':'';?>>Lens</option>
                        <option value="inner" <?php echo ($product_binding['zoom_type']=='inner')?'selected="selected"':'';?>>Inner</option>
                        </select>
                     </div>
              </div><!-- form-group--> 
              
            <div class="image_preview_type otp-1"> 
                <div class="form-group">            
                        <label class="col-sm-12 control-label"><?php echo $entry_zoom_size;?>
                        </label>
<div class="col-sm-12">                        
                            <input type="text" name="skin_zoom_image_width" size="2" value="<?php echo $skin_zoom_image_width; ?>" class="form-control half-width"/>
                              
                              <input type="text" name="skin_zoom_image_height" size="2" value="<?php echo $skin_zoom_image_height; ?>" class="form-control half-width"/>
                         </div>
                </div>
            </div>
            <div class="image_preview_type otp-1"> 
                <div class="form-group zoom_type otp-external">            
                        <label class="col-sm-12 control-label">
                        <?php echo $entry_zoom_window;?>
                        </label>
<div class="col-sm-12">
                        <input type="text" name="theme_setting[product_binding][zoomWindowWidth]" size="2" value="<?php echo $product_binding['zoomWindowWidth']; ?>" class="form-control half-width"/>
                          
                          <input type="text" name="theme_setting[product_binding][zoomWindowHeight]" size="2" value="<?php echo $product_binding['zoomWindowHeight']; ?>" class="form-control half-width"/>
                         </div>
                </div>
            </div>
            
            <div class="image_preview_type otp-1"> 
                <div class="form-group zoom_type otp-lens">            
                        <label class="col-sm-12 control-label"> <?php echo $entry_zoom_lens;?> </label>
<div class="col-sm-12"> 
                         <input type="text" name="theme_setting[product_binding][lensSize]" size="2" value="<?php echo $product_binding['lensSize']; ?>" class="form-control"/>
                         </div>
                </div>
            </div>
            
            <div class="form-group image_preview_type otp-1 hide">
                    <label class="col-sm-12 control-label">Lightbox Popup <?php echo $entry_skin;?></label>
<div class="col-sm-12 hide"><select name="theme_setting[product_binding][lightbox_skin]" class="form-control">
                        <option value="dark" <?php echo ($product_binding['lightbox_skin']=='dark')?'selected="selected"':'';?>>Dark</option>
                        <option value="light" <?php echo ($product_binding['lightbox_skin']=='light')?'selected="selected"':'';?>>Light</option>
                        <option value="mac" <?php echo ($product_binding['lightbox_skin']=='mac')?'selected="selected"':'';?>>Mac</option>
                        <option value="metro-black" <?php echo ($product_binding['lightbox_skin']=='metro-black')?'selected="selected"':'';?>>Metro Black</option>
                        <option value="metro-white" <?php echo ($product_binding['lightbox_skin']=='metro-white')?'selected="selected"':'';?>>Metro White</option>
                        <option value="smooth" <?php echo ($product_binding['lightbox_skin']=='smooth')?'selected="selected"':'';?>>Smooth</option></select>
                     </div>
              </div><!-- form-group--> 
  <div class="form-group image_preview_type otp-1">
                    <label class="col-sm-12 control-label"><?php echo $text_add_image_view; ?></label>
<div class="col-sm-12">
        <select name="theme_setting[product_binding][add_image_view]" class="form-control">
        <option value="normal-view" <?php echo ($product_binding['add_image_view']=='normal-view')?'selected="selected"':'';?>><?php echo $text_grid;?></option>
        <option value="owl-carousel" <?php echo ($product_binding['add_image_view']=='owl-carousel')?'selected="selected"':'';?>><?php echo $text_carousel;?></option>
     </select>
                     </div>
              </div><!-- form-group--> 
              

 <h4><?php echo $text_product_details;?> <?php echo $text_button;?></h4>
 
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_btn_cart; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($product_binding['btn_cart']=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[product_binding][btn_cart]" value="1" <?php if($product_binding['btn_cart']=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($product_binding['btn_cart']=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[product_binding][btn_cart]" value="0" <?php if($product_binding['btn_cart']=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_btn_whistlist; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($product_binding['btn_whistlist']=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[product_binding][btn_whistlist]" value="1" <?php if($product_binding['btn_whistlist']=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($product_binding['btn_whistlist']=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[product_binding][btn_whistlist]" value="0" <?php if($product_binding['btn_whistlist']=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_btn_compare; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($product_binding['btn_compare']=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[product_binding][btn_compare]" value="1" <?php if($product_binding['btn_compare']=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($product_binding['btn_compare']=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[product_binding][btn_compare]" value="0" <?php if($product_binding['btn_compare']=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
         			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_addthis; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($product_binding['addthis_widget']=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[product_binding][addthis_widget]" value="1" <?php if($product_binding['addthis_widget']=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($product_binding['addthis_widget']=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[product_binding][addthis_widget]" value="0" <?php if($product_binding['addthis_widget']=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group-->    
               
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_special_label; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($product_binding['special_label']=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[product_binding][special_label]" value="1" <?php if($product_binding['special_label']=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($product_binding['special_label']=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[product_binding][special_label]" value="0" <?php if($product_binding['special_label']=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group-->    
 <h4><?php echo $text_related_view;?></h4>
 
 			 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_status; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($product_related['status']=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[product_related][status]" value="1" <?php if($product_related['status']=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($product_related['status']=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[product_related][status]" value="0" <?php if($product_related['status']=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_view_type; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($product_related['type']=='item-grid'){ echo 'active tr_click';}?>" onclick="MCP.activeObj('product_related','item-grid');">
        <input type="radio" name="theme_setting[product_related][type]" value="item-grid" <?php if($product_related['type']=='item-grid'){ echo 'checked';}?>/><?php echo $text_grid;?></label>
    <label class="btn btn-xs btn-info <?php if($product_related['type']=='carousel-grid'){ echo 'active tr_click';}?>" onclick="MCP.activeObj('product_related','carousel-grid');">
        <input type="radio" name="theme_setting[product_related][type]" value="carousel-grid" <?php if($product_related['type']=='carousel-grid'){ echo 'checked';}?>/><?php echo $text_carousel_grid;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
               
       <div class="form-group product_related otp-item-grid">
                    <label class="col-sm-12 control-label"><?php echo $entry_display;?></label>
<div class="col-sm-12">
            <select name="theme_setting[product_related][grid_limit]" class="form-control data_set with-nav" data-set="grid_limit" data-selected="<?php echo $product_related['grid_limit'];?>"></select>
             
             
                     </div>
              </div><!-- form-group-->   
       <div class="form-group product_related otp-carousel-grid">
                    <label class="col-sm-12 control-label"><?php echo $entry_display;?></label>
<div class="col-sm-12">
             <select name="theme_setting[product_related][carousel_limit]" class="form-control data_set with-nav" data-set="carousel_limit" data-selected="<?php echo $product_related['carousel_limit'];?>"></select>
                     </div>
              </div><!-- form-group-->     
       

            <div class="form-group product_related otp-carousel-grid">
                    <label class="col-sm-12 control-label"><?php echo $entry_auto_play;?></label>
<div class="col-sm-12">
            <select name="theme_setting[product_related][carousel_autoplay]" class="form-control data_set with-nav" data-set="carousel_autoplay" data-selected="<?php echo $product_related['carousel_autoplay'];?>"></select>
                     </div>
              </div><!-- form-group-->
               			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_special_label; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($related_with_special=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[related_with_special]" value="1" <?php if($related_with_special=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($related_with_special=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[related_with_special]" value="0" <?php if($related_with_special=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
        
            


 <h4><?php echo $text_product_comment;?></h4>
 
               			<div class="form-group">
                    <label class="col-sm-12 control-label"> Opencart <?php echo $text_comment;?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($skin_oc_comment=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_oc_comment" value="1" <?php if($skin_oc_comment=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_oc_comment=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_oc_comment" value="0" <?php if($skin_oc_comment=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              
        
              
</div><!-- //ds_content-->
</div><!-- //ds_accordion-->