<?php global $ave;  global $config; echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">        
      <button type="submit" form="form-banner_plus" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-sm btn-success"><i class="fa fa-save"></i> <?php echo $button_save; ?></span></button>
      
      <a onclick="location = '<?php echo $cancel; ?>';" class="btn btn-danger btn-sm"><span><i class="fa fa-share-square-o"></i> <?php echo $button_cancel; ?></span></a>
        </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
     
  <?php if(!$config->get('ave_confirm_installed')){?>  
   <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_error_install; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
	<?php }else{?>    
    
        <?php if($rstatus){?>
      <form action="<?php echo $import_module; ?>" method="post" enctype="multipart/form-data" id="import">
      		<input type="hidden" value="<?php echo $redirect;?>" name="redirect" />
                          <div>
        <table class="table table-bordered table-hover">
                 <tbody>
                    <tr>
                    <td><input type="file" name="import" /></td>  
                    <td>
    <a href="<?php echo $export_module;?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Export this module data"><span><i class="fa fa-download"></i></span></a>
    <a onclick="$('#import').submit();" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> <span>Import Backup data</span></a>
                    </td>   
                    </tr>
                    </tbody>
                    </table>
</div>
      </form>
        <?php } ?>
    
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-banner_plus" class="form-horizontal">
        
        <div class="row">
        <div class="col-sm-4">
         	<div class="form-group">
                <label class="col-sm-12"><?php echo $entry_display; ?></label>
                <div class="col-sm-12">
              <div class="input-group">
              <a class="input-group-addon input-sm" onclick="Plus.navSelect('prev','#item_display')"><i class="fa fa-chevron-left"></i></a>
              <select name="display" id="item_display" class="form-control tr_change" onchange="Plus.activeObj('item_display',this.options[this.selectedIndex].value);callEditor(this.options[this.selectedIndex].value);">  
                  <option value="slider_flat_slider"  <?php if ($display=='slider_flat_slider'){ ?>selected="selected"<?php } ?>><?php echo $text_flat_slideshow; ?></option>
                  <option value="slider_camera_slider"  <?php if ($display=='slider_camera_slider'){ ?>selected="selected"<?php } ?>><?php echo $text_camera_slider; ?></option>
                  <option value="slider_flex_slider"  <?php if ($display=='slider_flex_slider'){ ?>selected="selected"<?php } ?>><?php echo $text_flex_slider; ?></option>
                  <option value="slider_four_slider"  <?php if ($display=='slider_four_slider'){ ?>selected="selected"<?php } ?>><?php echo $text_four_slider; ?></option>
                  <option value="slider_carousel"  <?php if ($display=='slider_carousel'){ ?>selected="selected"<?php } ?>><?php echo $text_logo_carousel; ?></option>
                  <option value="slider_carousel_lightbox"  <?php if ($display=='slider_carousel_lightbox'){ ?>selected="selected"<?php } ?>><?php echo $text_slider_carousel_lightbox; ?></option>
                  <option value="slider_carousel-desc"  <?php if ($display=='slider_carousel-desc'){ ?>selected="selected"<?php } ?>><?php echo $text_logo_carousel_desc; ?></option>
                  <option value="slider_banner"  <?php if ($display=='slider_banner'){ ?>selected="selected"<?php } ?>><?php echo $text_adv_banner; ?></option>
                  <option value="slider_popup-gallery"  <?php if ($display=='slider_popup-gallery'){ ?>selected="selected"<?php } ?>><?php echo $text_popup_gallery; ?></option>
                  <option value="slider_cover-photo"  <?php if ($display=='slider_cover-photo'){ ?>selected="selected"<?php } ?>><?php echo $text_cover_photo; ?></option>
                </select>    
            <a class="input-group-addon input-sm" onclick="Plus.navSelect('next','#item_display')"><i class="fa fa-chevron-right"></i></a>
              </div> <!--input-group --> 
                   </div>
        </div><!-- form-group-->  
         	<div class="form-group">
             <div class="col-sm-12">
            <img src="../assets/editor/img/mockup/slider_carousel_lightbox.png" class="img-responsive item_display otp-slider_carousel_lightbox" style="display:none;"/>
            <img src="../assets/editor/img/mockup/slider_camera_slider.png" class="img-responsive item_display otp-slider_camera_slider" style="display:none;"/>
            <img src="../assets/editor/img/mockup/slider_flex_slider.png" class="img-responsive item_display otp-slider_flex_slider" style="display:none;"/>
            <img src="../assets/editor/img/mockup/slider_four_slider.png" class="img-responsive item_display otp-slider_four_slider" style="display:none;"/>
            <img src="../assets/editor/img/mockup/slider_flat_slider.png" class="img-responsive item_display otp-slider_flat_slider" style="display:none;"/>
            <img src="../assets/editor/img/mockup/slider_popup-gallery.png" class="img-responsive item_display otp-slider_popup-gallery" style="display:none;"/>
            <img src="../assets/editor/img/mockup/slider_carousel.png" class="img-responsive item_display otp-slider_carousel otp-slider_carousel-desc" style="display:none;"/>
            <img src="../assets/editor/img/mockup/slider_cover-photo.png" class="img-responsive item_display otp-slider_cover-photo" style="display:none;"/>
            <img src="../assets/editor/img/mockup/slider_banner.png" class="img-responsive item_display otp-slider_banner" style="display:none;"/>
              </div>
            </div>
       
        
        </div>
        <div class="col-sm-8">
         <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_name; ?></label>
                <div class="col-sm-9">
                <input type="text" name="name" value="<?php echo $name; ?>" class="form-control"/>
            
              <?php if ($error_name) { ?>
                <span class="clearfix"></span>
              <span class="text-danger"><?php echo $error_name; ?></span>
              <?php } ?>

                                  </div>
              </div><!-- form-group--> 
           
         <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_status; ?></label>
                <div class="col-sm-9">
                <select name="status" class="form-control">
                <option value="1" <?php if ($status=='1') { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php if ($status=='0') { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
              </select>
                   </div>
        </div><!-- form-group-->  
        
          
        
         <div class="form-group item_display otp-slider_carousel otp-slider_carousel-desc otp-slider_carousel_lightbox">
                <label class="col-sm-3 control-label" for=""><?php echo $text_bgmode; ?></label>
                <div class="col-sm-9">
                <select name="bgmode" class="form-control">
                <option value="" <?php if ($bgmode=='') { ?>selected="selected"<?php } ?>><?php echo $text_inherit; ?></option>
                <option value="white_section" <?php if ($bgmode=='white_section') { ?>selected="selected"<?php } ?>><?php echo $text_bg_dark; ?></option>
                <option value="bg-base" <?php if ($bgmode=='bg-base') { ?>selected="selected"<?php } ?>><?php echo $text_bg_base; ?></option>
   				 <option value="bg_gray" <?php echo ($bgmode=='bg_gray')?'selected="selected"':'';?>>Grey Bg</option> 
              </select>
                   </div>
        </div><!-- form-group-->  
        
           
         <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $text_mobile_display; ?></label>
                <div class="col-sm-9">
                <select name="mobile_display" class="form-control">
                <option value="" <?php if ($mobile_display=='') { ?>selected="selected"<?php } ?>><?php echo $text_visible; ?></option>
                <option value="hidden-xs" <?php if ($mobile_display=='hidden-xs') { ?>selected="selected"<?php } ?>><?php echo $text_hidden; ?></option>
              </select>
                   </div>
        </div><!-- form-group-->  
        
          
         <div class="form-group item_display otp-slider_popup-gallery otp-slider_carousel_lightbox otp-slider_carousel-desc otp-slider_cover-photo otp-slider_four_slider">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_custom_title; ?></label>
                <div class="col-sm-9">
                <?php foreach ($languages as $language) { ?>
            <div class="input-group">
            <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
          <input type="text" name="custom_title[<?php echo $language['language_id']; ?>]" class="form-control custom_title" value="<?php echo isset($custom_title[$language['language_id']]) ? $custom_title[$language['language_id']] : ''; ?>"  />
          </div>
          <?php } ?>
                   </div>
        </div><!-- form-group-->  
         <div class="form-group item_display otp-slider_carousel-desc otp-slider_four_slider otp-slider_carousel_lightbox">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_custom_description; ?></label>
                <div class="col-sm-9">
                <ul class="nav nav-tabs">
              <?php foreach ($languages as $language) { ?>
            <li><a href="#custom_description<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
          <?php } ?>
          </ul>
          <div class="tab-content">
              <?php foreach ($languages as $language) { ?>
              <div class="tab-pane fade" id="custom_description<?php echo $language['language_id']; ?>">
          <textarea name="custom_description[<?php echo $language['language_id']; ?>]" id="custom_description_<?php echo $language['language_id']; ?>" class="form-control custom_description" rows="6"><?php echo isset($custom_description[$language['language_id']]) ? $custom_description[$language['language_id']] : ''; ?></textarea></div>
          <?php } ?>
          </div><!--//tab-content --> 
                   </div>
        </div><!-- form-group-->  
        
          
         <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_dimension; ?></label>
                <div class="col-sm-9">
                <div class="row">
                <div class="col-sm-6"> <input type="text" name="image_width" value="<?php echo $image_width; ?>" class="form-control"/> </div>
                <div class="col-sm-6"><input type="text" name="image_height" value="<?php echo $image_height; ?>" class="form-control"/></div>
                </div><!-- //row--> 
                <?php if ($error_image) { ?>
                <span class="text-danger"><?php echo $error_image; ?></span>
                <?php } ?>   
                   </div>
        </div><!-- form-group-->  
        
        
          
            <div class="form-group item_display otp-slider_flex_slider">
                <label class="col-sm-3 control-label" for=""><?php echo $text_thumb_display; ?></label>
                <div class="col-sm-9">
                <select name="thumb_display" class="form-control">
                <option value="0" <?php if ($thumb_display==0) { ?>selected="selected"<?php } ?>><?php echo $text_no; ?></option>
                <option value="1" <?php if ($thumb_display==1) { ?>selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
              </select>
                   </div>
        </div><!-- form-group-->  
         <div class="form-group item_display otp-slider_camera_slider otp-slider_flex_slider otp-slider_carousel_lightbox">
                <label class="col-sm-3 control-label" for=""><?php echo $text_thumb_size; ?></label>
                <div class="col-sm-9">
                <div class="row">
                <div class="col-sm-6"><input type="text" name="thumb_width" value="<?php echo $thumb_width; ?>" class="form-control" /> </div>
                <div class="col-sm-6"><input type="text" name="thumb_height" value="<?php echo $thumb_height; ?>" class="form-control"/></div>
                </div><!-- //row--> 
                
                   </div>
        </div><!-- form-group-->  
        
          
         <div class="form-group item_display otp-slider_popup-gallery otp-slider_cover-photo  otp-slider_carousel_lightbox">
                <label class="col-sm-3 control-label" for=""><?php echo $text_popup_size; ?></label>
                <div class="col-sm-9">
                <div class="row">
                <div class="col-sm-6"><input type="text" name="popup_width" value="<?php echo $popup_width; ?>" class="form-control" /> </div>
                <div class="col-sm-6"><input type="text" name="popup_height" value="<?php echo $popup_height; ?>" class="form-control"/></div>
                </div><!-- //row--> 
                <?php if ($error_popup) { ?>
                <span class="text-danger"><?php echo $error_popup; ?></span>
                <?php } ?>   
                   </div>
        </div><!-- form-group-->  
        
        
          
         <div class="form-group item_display otp-slider_popup-gallery ">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_grid_limit; ?></label>
                <div class="col-sm-9">
              		<select name="grid_limit" class="form-control">  
                  <option value="12" <?php echo($grid_limit=='12')?'selected="selected"':''; ?>>1</option>
                  <option value="6" <?php echo($grid_limit=='6')?'selected="selected"':''; ?>>2</option>
                  <option value="4" <?php echo($grid_limit=='4')?'selected="selected"':''; ?>>3</option>    
                  <option value="3" <?php echo($grid_limit=='3')?'selected="selected"':''; ?>>4</option>    
                  <option value="2" <?php echo($grid_limit=='2')?'selected="selected"':''; ?>>6</option>                   
                </select>
                   </div>
        </div><!-- form-group-->  
        
        
          
         <div class="form-group item_display otp-carousel otp-slider_carousel-desc otp-slider_cover-photo otp-slider_carousel">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_carousel_limit; ?></label>
                <div class="col-sm-9">
              		<select name="carousel_limit" class="form-control">  
                  <option value="1" <?php echo($carousel_limit=='1')?'selected="selected"':''; ?>>1</option>
                  <option value="2" <?php echo($carousel_limit=='2')?'selected="selected"':''; ?>>2</option>
                  <option value="3" <?php echo($carousel_limit=='3')?'selected="selected"':''; ?>>3</option>    
                  <option value="4" <?php echo($carousel_limit=='4')?'selected="selected"':''; ?>>4</option>      
                  <option value="5" <?php echo($carousel_limit=='5')?'selected="selected"':''; ?>>5</option>      
                  <option value="6" <?php echo($carousel_limit=='6')?'selected="selected"':''; ?>>6</option>                 
                </select>
                   </div>
        </div><!-- form-group-->  
         <div class="form-group item_display otp-carousel otp-slider_carousel-desc otp-slider_banner otp-slider_flat_slider otp-slider_cover-photo otp-slider_carousel">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_carousel_autoplay; ?></label>
                <div class="col-sm-9">
              		<select name="carousel_autoplay" class="form-control">  
                  <option value="false" <?php echo($carousel_autoplay=='false')?'selected="selected"':''; ?>>false</option>
                  <option value="1000" <?php echo($carousel_autoplay=='1000')?'selected="selected"':''; ?>>1000</option>
                  <option value="2000" <?php echo($carousel_autoplay=='2000')?'selected="selected"':''; ?>>2000</option>
                  <option value="3000" <?php echo($carousel_autoplay=='3000')?'selected="selected"':''; ?>>3000</option>    
                  <option value="4000" <?php echo($carousel_autoplay=='4000')?'selected="selected"':''; ?>>4000</option>      
                  <option value="5000" <?php echo($carousel_autoplay=='5000')?'selected="selected"':''; ?>>5000</option>      
                  <option value="6000" <?php echo($carousel_autoplay=='6000')?'selected="selected"':''; ?>>6000</option>      
                  <option value="7000" <?php echo($carousel_autoplay=='7000')?'selected="selected"':''; ?>>7000</option>      
                  <option value="8000" <?php echo($carousel_autoplay=='8000')?'selected="selected"':''; ?>>8000</option>      
                  <option value="9000" <?php echo($carousel_autoplay=='9000')?'selected="selected"':''; ?>>9000</option>                 
                </select>
                   </div>
        </div><!-- form-group-->  
        
        
         <div class="form-group item_display otp-carousel otp-slider_carousel-desc otp-slider_banner otp-slider_flat_slider otp-slider_cover-photo otp-slider_carousel">
                <label class="col-sm-4 control-label" for=""><?php echo $text_slide_speed; ?></label>
                <div class="col-sm-8">
              		<select name="smartSpeed" class="form-control">  
                  <option value="100" <?php echo($smartSpeed=='100')?'selected="selected"':''; ?>>100</option>
                  <option value="200" <?php echo($smartSpeed=='200')?'selected="selected"':''; ?>>200</option>
                  <option value="300" <?php echo($smartSpeed=='300')?'selected="selected"':''; ?>>300</option>
                  <option value="400" <?php echo($smartSpeed=='400')?'selected="selected"':''; ?>>400</option>
                  <option value="500" <?php echo($smartSpeed=='500')?'selected="selected"':''; ?>>500</option>    
                  <option value="600" <?php echo($smartSpeed=='600')?'selected="selected"':''; ?>>600</option>      
                  <option value="700" <?php echo($smartSpeed=='700')?'selected="selected"':''; ?>>700</option>      
                  <option value="800" <?php echo($smartSpeed=='800')?'selected="selected"':''; ?>>800</option>      
                  <option value="900" <?php echo($smartSpeed=='900')?'selected="selected"':''; ?>>900</option>      
                  <option value="1000" <?php echo($smartSpeed=='1000')?'selected="selected"':''; ?>>1000</option>      
                  <option value="1100" <?php echo($smartSpeed=='1100')?'selected="selected"':''; ?>>1100</option>       
                  <option value="1200" <?php echo($smartSpeed=='1200')?'selected="selected"':''; ?>>1200</option>       
                  <option value="1300" <?php echo($smartSpeed=='1300')?'selected="selected"':''; ?>>1300</option>       
                  <option value="1400" <?php echo($smartSpeed=='1400')?'selected="selected"':''; ?>>1400</option>       
                  <option value="1500" <?php echo($smartSpeed=='1500')?'selected="selected"':''; ?>>1500</option>       
                  <option value="1600" <?php echo($smartSpeed=='1600')?'selected="selected"':''; ?>>1600</option>       
                  <option value="1700" <?php echo($smartSpeed=='1700')?'selected="selected"':''; ?>>1700</option>       
                  <option value="1800" <?php echo($smartSpeed=='1800')?'selected="selected"':''; ?>>1800</option>       
                  <option value="1900" <?php echo($smartSpeed=='1900')?'selected="selected"':''; ?>>1900</option>       
                  <option value="2000" <?php echo($smartSpeed=='2000')?'selected="selected"':''; ?>>2000</option>                 
                </select>
                   </div>
        </div><!-- form-group-->  
        
       
      
        
        
        </div>
        
        </div><!-- end row--> 
        
        
        
        
        
        
        
        <div class="row">
            <div class="col-md-9 col-sm-12 pull-right">
     
        
	<?php if($config->get('image_manager_plus_status')==1){ ?>
    <div class="alert alert-info clearfix"><i class="fa fa-life-ring"></i> <?php echo $help_image_manager;?>
               <a onclick="filemanager();" class="btn btn-sm blue-bg pull-right"><?php echo $text_browse_manager; ?></a>
     <img class="pull-right" src="../assets/theme/img/aright.gif" style="width:32px; margin-top:2px;"/>
               </div>
       <?php }?> 
              
              
                    <div class="table-responsive">
        <table id="images" class="table table-bordered table-hover">
          <thead>
            <tr>
              <td width="100"><?php echo $entry_image; ?></td>    
              <td></td>    
            </tr>
          </thead>
          <?php $image_row = 0; ?>
          <?php foreach ($data_banner_images as $banner_image) {  ?>
          <tbody class="image-row" id="image-row<?php echo $image_row; ?>">
          <tr><td colspan="2" class="heading-bar text-right"><a onclick="$('#image-row<?php echo $image_row; ?>').remove();" class="btn btn-danger btn-sm pull-right"><span><?php echo $button_remove; ?></span></a></td></tr>
            <tr>
              <td class="vtop">
      <a onclick="image_upload('input-image<?php echo $image_row;?>','thumb-thumb<?php echo $image_row;?>');" id="thumb-thumb<?php echo $image_row; ?>" class="img-thumbnail">
      <img src="<?php echo $banner_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $banner_image['thumb']; ?>" /></a>
     <input type="hidden" name="banner_image[<?php echo $image_row; ?>][image]" value="<?php echo $banner_image['image']; ?>" id="input-image<?php echo $image_row; ?>"/>
              </td>
              
              <td class="left">
              
              
         <div class="form-group">
         <label class="col-sm-3 control-label" for=""><?php echo $entry_link; ?></label>
         <div class="col-sm-9"><input type="text" name="banner_image[<?php echo $image_row; ?>][link]" value="<?php echo $banner_image['link']; ?>" class="form-control"/>
        </div></div><!-- form-group-->    
        
         <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_title; ?></label>
                <div class="col-sm-9">
           <?php foreach ($languages as $language) { ?>  
           
                <?php echo $entry_line;?> 1<br> 
              <div class="input-group">
            <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
          <input type="text" name="banner_image[<?php echo $image_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($banner_image['title'][$language['language_id']]) ? $banner_image['title'][$language['language_id']] : ''; ?>" class="form-control"/>
                  
              </div> 
           <?php if (isset($error_banner_image[$image_row][$language['language_id']])) { ?><br/> 
                <span class="text-danger"><?php echo $error_banner_image[$image_row][$language['language_id']]; ?></span>
                <?php } ?>
                <?php echo $entry_line;?> 2<br> 
              <div class="input-group">
            <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
          <input type="text" name="banner_image[<?php echo $image_row; ?>][title2][<?php echo $language['language_id']; ?>]" value="<?php echo isset($banner_image['title2'][$language['language_id']]) ? $banner_image['title2'][$language['language_id']] : ''; ?>" class="form-control"/>
                  
              </div> 
              <?php echo $entry_line;?> 3<br> 
              <div class="input-group">
            <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
          <input type="text" name="banner_image[<?php echo $image_row; ?>][title3][<?php echo $language['language_id']; ?>]" value="<?php echo isset($banner_image['title3'][$language['language_id']]) ? $banner_image['title3'][$language['language_id']] : ''; ?>" class="form-control"/>
                  
              </div> 
              
        
      <?php } ?>
                   </div>
        </div><!-- form-group-->  
         <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_button_title; ?></label>
                <div class="col-sm-9">
           <?php foreach ($languages as $language) { ?>  
              
              <div class="input-group">
            <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
          <input type="text" name="banner_image[<?php echo $image_row; ?>][title4][<?php echo $language['language_id']; ?>]" value="<?php echo isset($banner_image['title4'][$language['language_id']]) ? $banner_image['title4'][$language['language_id']] : ''; ?>" class="form-control"/>
                  
              </div> 
      <?php } ?>
                   </div>
        </div><!-- form-group-->  
        
        
                </td>
            </tr>
          </tbody>
          <?php $image_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="2" class="text-right"><a onclick="addImage();" class="btn btn-primary btn-sm pull-right"><span><?php echo $button_add; ?></span></a></td>
            </tr>
          </tfoot>
        </table>
        </div><!-- //table--> 
          </div><!-- //col-->
           <div class="col-md-3 col-sm-12 col-xs-12">
         <div class="block_relative">
          <div id="module_list">
          <div class="heading-bar"><?php echo $text_installed_modules;?></div>
          <div class="module_accordion ds_accordion">
          <div>
              <div class="ds_content" style="display:block !important">
                   <?php foreach ($module_data as $module) { ?>
                  <div class="module-block <?php echo ($module['module_id']==$module_id)?'active':'';?>" <?php echo ($module['thumb'])?'data-thumb="'.$module['thumb'].'"':''; ?>>
                    <a style="display:block;float: left;width: 80%;text-align:left;" class="btn btn-sm btn-edit" href="<?php echo $module['href'];?>"><i class="fa fa-edit"></i> <?php echo $module['name'];?> </a> 
                    <a style="float:right;text-align:right;"onclick="confirm('<?php echo $text_confirm;?>') ? location.href='<?php echo $module['delete'];?>' : false;" data-toggle="tooltip" title="<?php echo $text_delete;?>" class="btn btn-sm btn-edit"><i class="fa fa-trash-o"></i></a>     
                    </div>
                  <?php } ?>
              
              </div>    <!--//ds_content --> 
          </div>    <!--//form-group --> 
          </div>    <!--//module_accordion--> 
          </div>    <!--//module_list--> 
          </div>    <!--//block_relative--> 
          
         
          
          </div><!--//col --> 
        </div><!-- //row--> 
        </form>
      </div>
    </div>
  </div></div>
  <script type="text/javascript"><!--
	<?php if($config->get('image_manager_plus_status')==1){ 
				if (isset($this->request->get['banner_id'])) {
							$banner_id=$this->request->get['banner_id'];
				} else {
							$banner_id=0;
				}
			?>			
			$.rcookie('banner<?php echo $banner_id; ?>_image_row',null);
	<?php	} else {	?>
	var image_row = <?php echo $image_row; ?>;	
	<?php } ?>
function addImage() {
	
	<?php if($config->get('image_manager_plus_status')==1){ ?>
		if ($.rcookie('banner<?php echo $banner_id; ?>_image_row')==null||$.rcookie('banner<?php echo $banner_id; ?>_image_row')=='') {
			var cookie_image_row = <?php echo $image_row; ?>;	
		}else{	
			var cookie_image_row = $.rcookie('banner<?php echo $banner_id; ?>_image_row');	
		}	
		var image_row =cookie_image_row;	
		$.rcookie('banner<?php echo $banner_id; ?>_image_row',null);
    <?php } ?>
    html  = '<tbody class="image-row" id="image-row' + image_row + '">';
	
	html += '<tr><td colspan="3" class="heading-bar text-right"><a onclick="$(\'#image-row' + image_row  + '\').remove();" class="btn btn-danger btn-sm pull-right"><span><?php echo $button_remove; ?></span></a></td><tr>';
	html += '<tr>';
	html += '<td class="vtop">';
	html += '<a onclick="image_upload(\'input-image' + image_row  + '\',\'thumb-thumb' + image_row  + '\');" id="thumb-thumb' + image_row + '" class="img-thumbnail">';
	html += '<img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />';
	html += '</a><input type="hidden" name="banner_image[' + image_row + '][image]" value="<?php echo $placeholder; ?>" id="input-image' + image_row + '"/>';	 
    html += '</td>';
    html += '<td class="left">';
	
    html += '<div class="form-group">';
    html += '<label class="col-sm-3 control-label" for=""><?php echo $entry_link; ?></label>';
    html += '<div class="col-sm-9">';
    html += '<input type="text" name="banner_image[' + image_row + '][link]" value="" class="form-control"/>';
    html += '</div></div>';<!-- form-group-->  
	
    html += '<div class="form-group">';
    html += '<label class="col-sm-3 control-label" for=""></label>';
    html += '<div class="col-sm-9">';
            <?php foreach ($languages as $language) { ?>
    html += '<?php echo $entry_line;?> 1<br> <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
    html += '<input type="text" name="banner_image[' + image_row + '][title][<?php echo $language['language_id']; ?>]" value="<?php echo $text_image_title;?>" class="form-control"/>';
	 html += '    </div>';
	 
    html += '<?php echo $entry_line;?> 2<br> <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
    html += '<input type="text" name="banner_image[' + image_row + '][title2][<?php echo $language['language_id']; ?>]" value="" class="form-control"/>';
	 html += '    </div>';
	 
    html += '<?php echo $entry_line;?> 3<br> <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
    html += '<input type="text" name="banner_image[' + image_row + '][title3][<?php echo $language['language_id']; ?>]" value="" class="form-control"/>';
	 html += '    </div>';
	
            <?php } ?>
    html += '</div></div>';<!-- form-group-->  
	
	 html += '<div class="form-group">';
    html += '<label class="col-sm-3 control-label" for=""><?php echo $entry_button_title;?></label>';
    html += '<div class="col-sm-9">';
            <?php foreach ($languages as $language) { ?>
    html += '    <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
    html += '<input type="text" name="banner_image[' + image_row + '][title3][<?php echo $language['language_id']; ?>]" value="" class="form-control"/>';
	 html += '    </div>';
            <?php } ?>
    html += '</div></div>';<!-- form-group-->  
			
	html += '</td>';		
	
	html += '</tr>';
	html += '</tbody>'; 
	
	$('#images tfoot').before(html);	
		$('#image-row' + image_row + ' .nav-tabs li a:first').tab('show');
		
	<?php if($config->get('image_manager_plus_status')==1){ ?>
			var numrow= parseInt(cookie_image_row)+1;
			$.rcookie('banner<?php echo $banner_id; ?>_image_row',numrow);		
	<?php } ?>		
	image_row++;
}
//--></script>

	<?php if($config->get('image_manager_plus_status')==1){ ?>
<script type="text/javascript">
function insertImage(fileName) {							 
			if ($.rcookie('banner<?php echo $banner_id; ?>_image_row')==null||$.rcookie('banner<?php echo $banner_id; ?>_image_row')=='') {
				var cookie_add_row = <?php echo $image_row; ?>;	
			}else{	
				var cookie_add_row = $.rcookie('banner<?php echo $banner_id; ?>_image_row');		
			}					
			var add_row = cookie_add_row;	 
		 

    html  = '<tbody class="image-row" id="image-row' + add_row + '">';
	html += '<tr><td colspan="3" class="heading-bar text-right"><a onclick="$(\'#image-row' + add_row  + '\').remove();" class="btn btn-danger btn-sm pull-right"><span><?php echo $button_remove; ?></span></a></td><tr>';
	html += '<tr>';	
	html += '<td class="vtop">';
	html += '<a onclick="image_upload(\'input-image' + add_row  + '\',\'thumb-thumb' + add_row  + '\');" id="thumb-thumb' + add_row + '" data-toggle="image" class="img-thumbnail">';
	html += '<img src="../image/' + fileName + '" alt="" title="" data-placeholder="../image/' + fileName + '" />';
	html += '</a><input type="hidden" name="banner_image[' + add_row + '][image]" value="' + fileName + '" id="input-image' + add_row + '"/>';	 
    html += '</td>';
	
    html += '<td class="left">';
	
    html += '<div class="form-group">';
    html += '<label class="col-sm-3 control-label" for=""><?php echo $entry_link; ?></label>';
    html += '<div class="col-sm-9">';
    html += '<input type="text" name="banner_image[' + add_row + '][link]" value="" class="form-control"/>';	
    html += '</div></div>';<!-- form-group-->  
		
    html += '<div class="form-group">';
    html += '<label class="col-sm-3 control-label" for=""><?php echo $entry_title; ?></label>';
    html += '<div class="col-sm-9">';
            <?php foreach ($languages as $language) { ?>
    html += '<?php echo $entry_line;?> 1<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
    html += '<input type="text" name="banner_image[' + add_row + '][title][<?php echo $language['language_id']; ?>]" value="<?php echo $text_image_title;?>" class="form-control"/>';
	 html += '    </div>';
	 
    html += '<?php echo $entry_line;?> 2<br> <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
    html += '<input type="text" name="banner_image[' + add_row + '][title2][<?php echo $language['language_id']; ?>]" value="" class="form-control"/>';
	 html += '    </div>';
	 
    html += '<?php echo $entry_line;?> 3<br> <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
    html += '<input type="text" name="banner_image[' + add_row + '][title3][<?php echo $language['language_id']; ?>]" value="" class="form-control"/>';
	 html += '    </div>';
            <?php } ?>
    html += '</div></div>';<!-- form-group-->  
	
		
    html += '<div class="form-group">';
    html += '<label class="col-sm-3 control-label" for=""><?php echo $entry_button_title; ?></label>';
    html += '<div class="col-sm-9">';
            <?php foreach ($languages as $language) { ?>
	 
    html += '    <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
    html += '<input type="text" name="banner_image[' + add_row + '][title4][<?php echo $language['language_id']; ?>]" value="" class="form-control"/>';
	 html += '    </div>';
	 
            <?php } ?>
    html += '</div></div>';<!-- form-group-->  
		
  
	html += '</td>';		
	html += '</tr>';
	html += '</tbody>'
									
		$('#images tfoot').before(html);
		var numrow= parseInt(cookie_add_row)+1;
		$.rcookie('banner<?php echo $banner_id; ?>_image_row',numrow);	
		$('#image-row' + add_row + ' .nav-tabs li a:first').tab('show');
		add_row++;
};
								
</script>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
		
	});
function callEditor(otp) {
	if(otp=='slider_carousel_lightbox'){
	<?php foreach ($languages as $language) { ?>
		$('#custom_description_<?php echo $language['language_id']; ?>').summernote({
			height: 300
		});
	<?php } ?>
	}
}
</script>
<?php }?>
<?php echo $footer; ?>