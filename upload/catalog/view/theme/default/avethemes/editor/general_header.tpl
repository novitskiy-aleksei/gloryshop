<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>

<ul class="nav nav-tabs nav-justified margin-bottom-10">
<li> <a onclick="MCP.switchView('editor-size-lg');"  data-group="general_group"  data-action="general_navigation" data-title="<?php echo $text_header_nav;?>" class="modal-form"><?php echo $text_header_nav;?></a></li>
<li> <a data-group="general_group"  data-action="widget_social" data-title="<?php echo $text_header_nav;?>" class="modal-form"><?php echo $text_manager_social_links;?></a></li>
<!-- <li> <a data-group="general_group"  data-action="general_support_info" data-title="<?php echo $text_support_set;?>" class="modal-form"><?php echo $text_support_set;?></a></li>--> 


                   
                   
       </ul> 
       
 <div class="container-fluid">
 <div class="row">
 
 
 <div class="col-md-4 col-sm-4 size-sm-12">   
              
                
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_navigation_style; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($navigation_mode=='header_light'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $navigation_mode;?>','header_light');">
        <input type="radio" name="theme_setting[navigation_mode]" value="header_light" <?php if($navigation_mode=='header_light'){ echo 'checked';}?>/><?php echo $text_light;?></label>
    <label class="btn btn-xs btn-info <?php if($navigation_mode=='header_dark'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $navigation_mode;?>','header_dark');">
        <input type="radio" name="theme_setting[navigation_mode]" value="header_dark" <?php if($navigation_mode=='header_dark'){ echo 'checked';}?>/><?php echo $text_dark;?></label>
</div>

              
                     </div>
              </div><!-- form-group-->   
              
 			 <div class="form-group <?php echo($header_style=='navigation_aside')?'hide':'';?>">
                    <label class="col-sm-12 control-label"><?php echo $entry_header_fixed; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($header_fixed=='header-fixed'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $header_fixed;?>','header-fixed');MCP.activeObj('header_fixed',1);">
        <input type="radio" name="theme_setting[header_fixed]" value="header-fixed" <?php if($header_fixed=='header-fixed'){ echo 'checked';}?>/><?php echo $text_yes;?></label>
        
    <label class="btn btn-xs btn-info <?php if($header_fixed=='header-scroll'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $header_fixed;?>','header-scroll');MCP.deactiveObj('header_fixed',1);">
        <input type="radio" name="theme_setting[header_fixed]" value="header-scroll" <?php if($header_fixed=='header-scroll'){ echo 'checked';}?>/><?php echo $text_no;?></label>
			</div>
                     </div>
              </div><!-- form-group-->
              
              
 			<div class="header_fixed otp-1 form-group <?php echo($header_style=='navigation_aside')?'hide':'';?>" style="display:none">
                    <label class="col-sm-12 control-label"><?php echo $entry_transparent; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($nav_transparent=='header_not_transparent'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $nav_transparent;?>','header_not_transparent');">
        <input type="radio" name="theme_setting[nav_transparent]" value="header_not_transparent" <?php if($navigation_mode=='header_not_transparent'){ echo 'checked';}?>/><?php echo $text_no;?></label>
    <label class="btn btn-xs btn-info <?php if($nav_transparent=='header_transparent'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $nav_transparent;?>','header_transparent');">
        <input type="radio" name="theme_setting[nav_transparent]" value="header_transparent" <?php if($navigation_mode=='header_transparent'){ echo 'checked';}?>/><?php echo $text_yes;?></label>
</div>

              
                     </div>
              </div><!-- form-group-->   
              
              
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_header_top; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($header_top_status=='header_top_show'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $header_top_status;?>','header_top_show');MCP.activeObj('header_top_status',1);">
        <input type="radio" name="theme_setting[header_top_status]" value="header_top_show" <?php if($header_top_status=='header_top_show'){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($header_top_status=='header_top_hide'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $header_top_status;?>','header_top_hide');MCP.deactiveObj('header_top_status',1);">
        <input type="radio" name="theme_setting[header_top_status]" value="header_top_hide" <?php if($header_top_status=='header_top_hide'){ echo 'checked';}?>/><?php echo $text_hide;?></label>
</div>

                     </div>
              </div><!-- form-group--> 

               
 			<div class="form-group header_top_status otp-1" style="display:none;">
                    <label class="col-sm-12 control-label"><?php echo $text_header_top_style; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($header_top_color=='header-top-colored'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $header_top_color;?>','header-top-colored');">
        <input type="radio" name="theme_setting[header_top_color]" value="header-top-colored" <?php if($header_top_color=='header-top-colored'){ echo 'checked';}?>/><?php echo $text_colored;?></label>
    <label class="btn btn-xs btn-info <?php if($header_top_color=='header-top-default'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $header_top_color;?>','header-top-default');">
        <input type="radio" name="theme_setting[header_top_color]" value="header-top-default" <?php if($header_top_color=='header-top-default'){ echo 'checked';}?>/><?php echo $text_default;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
   
         
             
              
    
 			
    
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_phone_number; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($header_quick_support=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[header_quick_support]" value="1" <?php if($header_quick_support=='1'){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($header_quick_support=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[header_quick_support]" value="0" <?php if($header_quick_support=='0'){ echo 'checked';}?>/><?php echo $text_hide;?></label>
</div>

                     </div>
              </div><!-- form-group--> 

            
                    <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_shopping_cart; ?></label>
<div class="col-sm-12"> 
                 
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($cart_status=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[cart_status]" value="1" <?php if($cart_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($cart_status=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[cart_status]" value="0" <?php if($cart_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                  
                     </div>
              </div><!-- form-group-->    
        
                    <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_search; ?></label>
<div class="col-sm-12"> 
    <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
        <label class="btn btn-xs btn-success <?php if($search_status=='1'){ echo 'active tr_click';}?>">
            <input type="radio" name="theme_setting[search_status]" value="1" <?php if($search_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
        <label class="btn btn-xs btn-info <?php if($search_status=='0'){ echo 'active tr_click';}?>">
            <input type="radio" name="theme_setting[search_status]" value="0" <?php if($search_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
    </div>
                     </div>
              </div><!-- form-group-->
               
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_ajax_search;?></label>
<div class="col-sm-12"> 
                   <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($ajax_search=='with-ajax_search'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[ajax_search]" value="with-ajax_search" <?php if($ajax_search=='with-ajax_search'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($ajax_search=='without-ajax_search'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[ajax_search]" value="without-ajax_search" <?php if($ajax_search=='without-ajax_search'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_search_dimension; ?></label>
<div class="col-sm-12"> <input type="text"name="theme_setting[search_image_width]" size="1" value="<?php echo $search_image_width; ?>" class="form-control half-width"/>
                     <input type="text"  name="theme_setting[search_image_height]" size="1" value="<?php echo $search_image_height; ?>" class="form-control half-width"/>
                     </div>
              </div><!-- form-group-->
                  
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_result_limit; ?></label>
<div class="col-sm-12"> <input type="text" name="theme_setting[search_result_limit]" class="form-control" size="1" value="<?php echo $search_result_limit; ?>"/>
                     </div>
              </div><!-- form-group--> 
  </div><!--//ds_content 
  $(this).parent().parent().find('.custom_header').removeClass('active_header');$(this).addClass('active_header');
  -->   
 <div class="col-md-8 col-sm-8 size-sm-12">  
 <h4><?php echo $entry_header_style;?></h4>
                <?php echo $text_aside_navigation;?>
                <div class="form-group clearfix">
                 <a onclick="$(this).find('input').prop('checked', true);MCP.apply(1);" class="custom_header clearfix <?php if($header_style=='navigation_aside'){?>active_header<?php } ?>">
                        <img src="assets/editor/img/mockup/header/navigation_aside.png" class="img-responsive clearfix">
                        <input style="display:none;" type="radio" name="theme_setting[header_style]" value="navigation_aside" <?php if($header_style=='navigation_aside'){?>checked<?php } ?>>
                        </a>
                        
                  </div><!-- form-group--> 
      <?php for( $i= 1 ; $i <= 1 ; $i++ ){ ?>
                <div class="form-group clearfix">
                        Header <?php echo $i;?>
                         <a onclick="$(this).find('input').prop('checked', true);MCP.apply(1);" class="custom_header clearfix <?php if($header_style=='header_style_'.$i){?>active_header<?php } ?>">
                        <img src="assets/editor/img/mockup/header/header_style_<?php echo $i;?>.png" class="img-responsive clearfix">
                        <input style="display:none;" type="radio" name="theme_setting[header_style]" value="header_style_<?php echo $i;?>" <?php if($header_style=='header_style_'.$i){?>checked<?php } ?>>
                        </a>
                  </div><!-- form-group--> 
                <?php } ?>  
              
  </div><!--//ds_content -->     
                

</div><!--//row --> 
</div><!--//ds_accordion --> 