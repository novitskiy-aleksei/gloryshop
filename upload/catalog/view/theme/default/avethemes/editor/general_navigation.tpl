<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>

<?php    
    $custommenu_sort=explode(',', $menu_sort);	        
    $custom_menu['nav_catalog'] = array(
            'label' => 'nav_catalog',
            'status' => $nav_catalog_status,
            'text' => $text_catalog_menu
    );
   $custom_menu['nav_content'] = array(
            'label' => 'nav_content',
            'status' => $nav_content_status,
            'text' => $text_content_menu
    );
   $custom_menu['nav_shortcode'] = array(
            'label' => 'nav_shortcode',
            'status' => $skin_nav_shortcode,
            'text' => $text_shortcode
    );
    $custom_menu['skin_pin_brand'] = array(
            'label' => 'skin_pin_brand',
            'status' => $skin_pin_brand_status,
            'text' => $text_skin_pin_brand
    );
   $custom_menu['skin_pin_product'] = array(
            'label' => 'skin_pin_product',
            'status' => $skin_pin_product_status,
            'text' =>$text_skin_pin_product
    );     
   $custom_menu['skin_pin_information'] = array(
            'label' => 'skin_pin_information',
            'status' => $skin_pin_information_status,
            'text' => $text_skin_pin_information
    ); 
   $custom_menu['skin_pin_download'] = array(
            'label' => 'skin_pin_download',
            'status' => $skin_pin_download_status,
            'text' => $text_skin_pin_download
    );
?>

  <a onclick="MCP.switchView('editor-size-sm');"  data-group="general_group" data-action="general_header" class="modal-form btn btn-block btn-info margin-bottom-15" data-title="<?php echo $text_header;?>"><i class="fa fa-chevron-left"></i>  <?php echo $text_back;?></a>
<div class="container-fluid">
         				<div class="alert alert-info"><?php echo $help_sort_order;?></div>
                   
                      <div class="widget_sort" id="menu_sort"><?php foreach ($custommenu_sort as $sort_key){ ?>
                          <div class="btn btn-info btn-sm">
                             <a data-group="general_group" data-action="widget_<?php echo $custom_menu[$sort_key]['label'];?>" class="modal-form" data-title="<?php echo $custom_menu[$sort_key]['text'];?>"><?php echo $custom_menu[$sort_key]['text'];?></a>
                              <input type="hidden" class="sort_order" value="<?php echo $custom_menu[$sort_key]['label'];?>"/>
                            </div>
                          <!--col-md-->
                          <?php } ?>
                        </div>
     
 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_count_item; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($menu_count_item=='1'){ echo 'active tr_click';}?>" onclick="MCP.checkMenuCount();">
        <input type="radio" name="theme_setting[menu_count_item]" value="1" <?php if($menu_count_item=='1'){ echo 'checked';}?>/><?php echo $text_yes;?></label>
    <label class="btn btn-xs btn-info <?php if($menu_count_item=='0'){ echo 'active tr_click';}?>" onclick="MCP.checkMenuCount();">
        <input type="radio" name="theme_setting[menu_count_item]" value="0" <?php if($menu_count_item=='0'){ echo 'checked';}?>/><?php echo $text_no;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
          
              
               
 			<div class="form-group <?php echo($header_style=='navigation_aside')?'hide':'';?>">
                    <label class="col-sm-12 control-label"><?php echo $entry_navigation_sub; ?></label>
<div class="col-sm-12">
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($navigation_sub=='sub_nav_light'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $navigation_sub;?>','sub_nav_light');">
        <input type="radio" name="theme_setting[navigation_sub]" value="sub_nav_light" <?php if($navigation_sub=='sub_nav_light'){ echo 'checked';}?>/><?php echo $text_light;?></label>
    <label class="btn btn-xs btn-info <?php if($navigation_sub=='sub_nav_dark'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $navigation_sub;?>','sub_nav_dark');">
        <input type="radio" name="theme_setting[navigation_sub]" value="sub_nav_dark" <?php if($navigation_sub=='sub_nav_dark'){ echo 'checked';}?>/><?php echo $text_dark;?></label>
</div>

              
                     </div>
              </div><!-- form-group-->  

 			<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_nav_btn_mode; ?></label>
<div class="col-sm-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($nav_btn_mode==''){ echo 'active tr_click';}?>" >
        <input type="radio" name="theme_setting[nav_btn_mode]" value="" <?php if($nav_btn_mode==''){ echo 'checked';}?>/><?php echo $text_default;?></label>
    <label class="btn btn-xs btn-info <?php if($nav_btn_mode=='menu_button_mode'){ echo 'active tr_click';}?>" >
        <input type="radio" name="theme_setting[nav_btn_mode]" value="menu_button_mode" <?php if($nav_btn_mode=='menu_button_mode'){ echo 'checked';}?>/><?php echo $text_button;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
          
                    
              
              
</div>