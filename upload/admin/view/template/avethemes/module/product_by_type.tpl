<?php global $ave;  global $config; echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">        
        <button type="submit" form="form-product_by_type" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></span></button>
      <a onclick="location = '<?php echo $cancel; ?>';" class="btn btn-primary btn-sm"><span><i class="fa fa-share-square-o"></i> <?php echo $button_cancel; ?></span></a>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product_by_type" class="form-horizontal">
        <div class="row">
           <div class="col-md-9 col-sm-12 col-xs-12 pull-right">
       <div class="row">
           <div class="col-md-6 col-sm-12 col-xs-12">
             <div class="form-group">
                <label class="col-sm-4 control-label" ><?php echo $entry_name; ?></label>
                <div class="col-sm-8">
                  <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                  <?php if ($error_name) { ?>
                  <div class="text-danger"><?php echo $error_name; ?></div>
                  <?php } ?>
                </div>
              </div>  
           <div class="form-group">
            <label class="col-sm-4 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-8">
              <select name="status" id="input-status" class="form-control">
                <option value="1" <?php if ($status=='1') { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php if ($status=='0') { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
              </select>
            </div>
          </div>
               <div class="form-group">
                <div><?php echo $entry_item_display; ?></div>
                <div class="col-sm-12">
 <select name="display" id="item_display" class="form-control tr_change with-nav" onchange="Plus.activeObj('item_display',this.options[this.selectedIndex].value);">
    <?php foreach ($elements as $elem) { ?>
    <option value="<?php echo $elem['value'];?>"  <?php echo ($elem['value']==$display)?'selected="selected"':'';?>><?php echo $elem['label'];?></option> 
   <?php } ?>
            </select>
                </div>
              </div>  <!--//form-group--> 

          <div class="form-group">
            <div class="col-sm-12">
            <div style="max-width:600px;">
  <?php foreach ($elements as $elem) { ?>
            <img src="../assets/editor/img/mockup/<?php echo $elem['value'];?>.png" class="img-responsive item_display otp-<?php echo $elem['value'];?>" style="display:none;"/>
   <?php } ?>
            </div>
            </div>
          </div>     
            
              
           </div><!-- col-sm-->
           <div class="col-md-6 col-sm-12 col-xs-12">
             
              <div class="well">
          <h5><?php echo $text_section_data;?></h5>
          <small><?php echo $help_section_data;?></small>
          
          <div class="form-group">
            <label class="col-sm-4 control-label" for="input-type"><?php echo $entry_section_icon; ?></label>
            <div class="col-sm-8">
             <a class="icon-preview">
         <i class="<?php echo $icon;?>" id="main_icon_thumb"></i>
         <input type="hidden" name="icon" value="<?php echo $icon;?>" id="main_icon" /></a> 
              <i class="fa fa-trash-o clear-ico"></i>
            </div>
          </div> <!--//form-group--> 
             <div class="form-group">
                <label class="col-sm-4 control-label" ><?php echo $entry_custom_title; ?></label>
                <div class="col-sm-8">
                 <?php foreach ($languages as $language) { ?>
            <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
          <input type="text" name="custom_title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($custom_title[$language['language_id']]) ? $custom_title[$language['language_id']] : ''; ?>" class="form-control custom_title"/>
          </div>
          <?php } ?>
                </div>
              </div>  <!--//form-group--> 
              
              <div class="form-group">
            <label class="col-sm-4 control-label" for="input-classes"><?php echo $text_heading_align; ?></label>
            <div class="col-sm-8">
            <select name="heading_align" id="heading_align" class="form-control">
    <option><?php echo $text_inherit;?></option> 
    <option value="centered" <?php echo ($heading_align=='centered')?'selected="selected"':'';?>><?php echo $text_centered;?></option> 
            </select>
            </div>
          </div> <!--//form-group--> 
          
              <div class="form-group">
            <label class="col-sm-4 control-label" for="input-classes"><?php echo $text_paralax_class; ?></label>
            <div class="col-sm-8">
            <select name="paralax_class" id="paralax_class" class="form-control">
    <option value=""><?php echo $text_none;?></option>
    <option value="bg_gray" <?php echo ($paralax_class=='bg_gray')?'selected="selected"':'';?>>Gray bg</option> 
    <option value="ave_parallax1" <?php echo ($paralax_class=='ave_parallax1')?'selected="selected"':'';?>>Paralax level 1</option> 
    <option value="ave_parallax2" <?php echo ($paralax_class=='ave_parallax2')?'selected="selected"':'';?>>Paralax level 2</option> 
    <option value="ave_parallax3" <?php echo ($paralax_class=='ave_parallax3')?'selected="selected"':'';?>>Paralax level 3</option> 
    <option value="ave_parallax4" <?php echo ($paralax_class=='ave_parallax4')?'selected="selected"':'';?>>Paralax level 4</option> 
    <option value="ave_parallax5" <?php echo ($paralax_class=='ave_parallax5')?'selected="selected"':'';?>>Paralax level 5</option> 
    <option value="ave_parallax6" <?php echo ($paralax_class=='ave_parallax6')?'selected="selected"':'';?>>Paralax level 6</option> 
    <option value="ave_parallax7" <?php echo ($paralax_class=='ave_parallax7')?'selected="selected"':'';?>>Paralax level 7</option> 
    <option value="ave_parallax8" <?php echo ($paralax_class=='ave_parallax8')?'selected="selected"':'';?>>Paralax level 8</option> 
    <option value="ave_parallax9" <?php echo ($paralax_class=='ave_parallax9')?'selected="selected"':'';?>>Paralax level 9</option> 
            </select>
            </div>
          </div> <!--//form-group--> 
          
 
              <div class="form-group">
            <label class="col-sm-4 control-label" for="input-image"><?php echo $entry_section_bgcolor; ?></label>
            <div class="col-sm-8">
            <input class="form-control colorpicker" type="text" name="bgcolor" placeholder="<?php echo $entry_bgcolor;?>" value="<?php echo (!empty($bgcolor))?$bgcolor:'';?>">
            
            </div>
          </div> <!--//form-group--> 
 
          <div class="form-group">
            <label class="col-sm-4 control-label" for="input-image"><?php echo $entry_section_background; ?></label>
            <div class="col-sm-8">
            <a data-toggle="image-upload" onclick="image_upload('main_image','main_thumb');" id="main_thumb" class="img-thumbnail">
            <img src="<?php echo (!empty($bgimage))?'../image/'.$bgimage:$placeholder;?>" alt="" title="" data-placeholder="<?php echo (!empty($bgimage))?'../image/'.$bgimage:$placeholder;?>" id="main_image_thumb"/></a>
            <input type="hidden" name="bgimage" value="<?php echo $bgimage;?>" id="main_image"/>
            
            </div>
          </div> <!--//form-group-->     
              <div class="form-group">
            <label class="col-sm-4 control-label" for="input-image"><?php echo $text_animation; ?></label>
            <div class="col-sm-8">
 <select name="animation" class="form-control tr_change with-nav">  
   <?php foreach ($animations as $key=>$label) { ?>
    <option value="<?php echo $key;?>"  <?php echo ($key==$animation)?'selected="selected"':'';?>><?php echo $label;?></option> 
   <?php } ?>
            </select>
            </div>
          </div> <!--//form-group--> 
          </div><!--//well -->             
           
           <div class="form-group">
                <label class="col-sm-4 control-label" ><?php echo $entry_product_type; ?></label>
                <div class="col-sm-8">
                 <select name="product_type" id="product_type" onchange="Plus.activeObj('product_type',this.options[this.selectedIndex].value);" class="form-control tr_change with-nav">                
      <option value="latest" <?php if ($product_type=='latest') { ?>selected="selected"<?php } ?>><?php echo $text_latest_product; ?></option>   
      <option value="special"  <?php if ($product_type=='special') { ?>selected="selected"<?php } ?>><?php echo $text_special_product; ?></option>
      <option value="most_viewed" <?php if ($product_type=='most_viewed') { ?>selected="selected"<?php } ?>><?php echo $text_most_viewed; ?></option>   
      <option value="bestseller" <?php if ($product_type=='bestseller') { ?>selected="selected"<?php } ?>><?php echo $text_bestseller_product; ?></option>    
      <option value="popular" <?php if ($product_type=='popular') { ?>selected="selected"<?php } ?>><?php echo $text_popular_product; ?></option>         
      <option value="random" <?php if ($product_type=='random') { ?>selected="selected"<?php } ?>><?php echo $text_random; ?></option>              
      <option value="custom_item" <?php if ($product_type=='custom_item') { ?>selected="selected"<?php } ?>><?php echo $text_custom_product; ?></option>
      <option value="related" <?php if ($product_type=='related') { ?>selected="selected"<?php } ?>><?php echo $text_related_product; ?></option>             
                  
                </select>
                </div>
              </div>  <!--//form-group-->  
              
               <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_custom_description; ?></label>
                <div class="col-sm-8">
                     <ul class="nav nav-tabs">
                  <?php foreach ($languages as $language) { ?>
                <li><a href="#custom_description<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
              <?php } ?>
              </ul>
              <div class="tab-content">
                  <?php foreach ($languages as $language) { ?>
                  <div class="tab-pane fade" id="custom_description<?php echo $language['language_id']; ?>">
              <textarea name="custom_description[<?php echo $language['language_id']; ?>]" class="form-control custom_description" rows="6"><?php echo isset($custom_description[$language['language_id']]) ? $custom_description[$language['language_id']] : ''; ?></textarea></div>
              <?php } ?>
              </div><!--/tab-content --> 
                </div>
              </div>  <!--//form-group--> 
             <div class="form-group product_type otp-custom_item">
                <label class="col-sm-3 control-label " for=""><?php echo $entry_custom_item; ?></label>
                <div class="col-sm-9">
                        <div class="autosuggest">
                            <div class="autosuggest_heading">
                            <input type="text" name="filter_input" value="" class="form-control"/>
                            </div>
                            <div class="autosuggest_content" id="filter_result">            
                            </div>
                            <div id="custom_item" class="scrollbox">
                            <?php $class = 'odd'; ?>
                                 
                            <?php if(!empty($products)) {   ?>
                            <?php foreach ($products as $product) {             
                                 $class = ($class=='even' ? 'odd' : 'even'); 
                                 ?>                     
                                <div id="custom_item<?php echo $product['product_id']; ?>" class="<?php echo $class; ?>"><?php echo $product['name']; ?> <img src="../assets/theme/img/delete.png" alt="" onclick="$(this).parent().remove();"/>
                                  <input type="hidden" name="custom_item[]" value="<?php echo $product['product_id']; ?>" />
                                </div>
                                <?php } ?>
                                <?php } ?>
                          </div><!-- //scrollbox--> 
                        </div>
                </div>
              </div>  <!--//form-group-->   
            
          <div class="form-group">
            <label class="col-sm-4 control-label" ><?php echo $entry_limit; ?></label>
            <div class="col-sm-8">
              <input type="text" name="limit" value="<?php echo $limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-name" class="form-control" />            
            </div>
          </div>   
           
            <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_dimension; ?></label>
                <div class="col-sm-8">
                <div class="row">
                <div class="col-sm-6">
               <input type="text" name="image_width"  id="image_width" value="<?php echo $image_width; ?>" class="form-control"/>
               </div>
                <div class="col-sm-6">
                    <input type="text" name="image_height" id="image_height" value="<?php echo $image_height; ?>" class="form-control"/>
                    </div>
                   </div><!--//row -->  
                   <?php if ($error_image) { ?>
                    <span class="text-danger"><?php echo $error_image; ?></span>
                    <?php } ?>
                </div>
          </div> 
          
               <div class="form-group item_display otp-product-carousel-grid otp-product-carousel-small otp-product-carousel-grid-flip otp-product-carousel-list otp-product-grid otp-product-list otp-product-grid-desc otp-product-carousel-grid-desc">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_description_limit; ?></label>
                <div class="col-sm-8">
 <input type="text" name="description_limit" id="description_limit" value="<?php echo $description_limit; ?>" class="form-control" />   
                </div>
              </div>  <!--//form-group--> 
              
          
              <div class="form-group item_display otp-product-grid otp-product-grid-desc">
                 <label class="col-sm-4 control-label"><?php echo $entry_grid_limit; ?> 
                <?php echo $help_grid_limit;?></label>
                <div class="col-sm-8">
              		<select name="grid_limit" class="form-control">  
                  <option value="12" <?php echo($grid_limit=='12')?'selected="selected"':''; ?>>1</option>      
                  <option value="6" <?php echo($grid_limit=='6')?'selected="selected"':''; ?>>2</option>
                  <option value="4" <?php echo($grid_limit=='4')?'selected="selected"':''; ?>>3</option>
                  <option value="3" <?php echo($grid_limit=='3')?'selected="selected"':''; ?>>4</option>   
                  <option value="2" <?php echo($grid_limit=='2')?'selected="selected"':''; ?>>6</option>              
                </select>
                </div>
              </div>  <!--//form-group-->
              <div class="form-group item_display otp-product-carousel-grid otp-product-carousel-small otp-product-carousel-grid-flip otp-product-carousel-grid-desc">
                 <label class="col-sm-4 control-label"><?php echo $entry_carousel_limit; ?></label>
                <div class="col-sm-8">
              		<select name="carousel_limit" class="form-control">  
                  <option value="1" <?php echo($carousel_limit=='1')?'selected="selected"':''; ?>>1</option>
                  <option value="2" <?php echo($carousel_limit=='2')?'selected="selected"':''; ?>>2</option>
                  <option value="3" <?php echo($carousel_limit=='3')?'selected="selected"':''; ?>>3</option>    
                  <option value="4" <?php echo($carousel_limit=='4')?'selected="selected"':''; ?>>4</option>      
                  <option value="5" <?php echo($carousel_limit=='5')?'selected="selected"':''; ?>>5</option>                
                </select>
                </div>
              </div>  <!--//form-group--> 
              
          
              <div class="form-group item_display otp-product-carousel-grid otp-product-carousel-small otp-product-carousel-grid-flip otp-product-carousel-grid-desc">
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
              <div class="form-group item_display otp-product-carousel-grid otp-product-carousel-small otp-product-carousel-grid-flip otp-product-carousel-grid-desc">
                 <label class="col-sm-4 control-label"><?php echo $text_slide_by; ?></label>
                <div class="col-sm-8">
              		<select name="slideBy" class="form-control">  
                  <option value="1" <?php echo($slideBy=='1')?'selected="selected"':''; ?>>1</option>
                  <option value="2" <?php echo($slideBy=='2')?'selected="selected"':''; ?>>2</option>
                  <option value="3" <?php echo($slideBy=='3')?'selected="selected"':''; ?>>3</option>    
                  <option value="4" <?php echo($slideBy=='4')?'selected="selected"':''; ?>>4</option>      
                  <option value="5" <?php echo($slideBy=='5')?'selected="selected"':''; ?>>5</option>                
                </select>
                </div>
              </div>  <!--//form-group-->  
              
              <div class="form-group item_display otp-product-carousel-grid otp-product-carousel-small otp-product-carousel-grid-flip otp-product-carousel-grid-desc">
                 <label class="col-sm-4 control-label"><?php echo $entry_autoplay_duration; ?></label>
                <div class="col-sm-8">
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
                  <option value="10000" <?php echo($carousel_autoplay=='10000')?'selected="selected"':''; ?>>10000</option>             
                </select>
                </div>
              </div>  <!--//form-group--> 
              
          <div class="form-group item_display otp-product-carousel-grid otp-product-carousel-small otp-product-carousel-grid-flip otp-product-carousel-list otp-product-carousel-grid-desc">
                 <label class="col-sm-4 control-label"><?php echo $entry_num_row; ?></label>
                <div class="col-sm-8">
              		<select name="num_row" class="form-control">  
                  <option value="1" <?php echo($num_row=='1')?'selected="selected"':''; ?>>1</option>
                  <option value="2" <?php echo($num_row=='2')?'selected="selected"':''; ?>>2</option>
                  <option value="3" <?php echo($num_row=='3')?'selected="selected"':''; ?>>3</option>            
                </select>
                </div>
          </div>  <!--//form-group-->
          
            <div class="form-group item_display otp-product-carousel-grid otp-product-carousel-small otp-product-carousel-grid-flip otp-product-carousel-list otp-product-carousel-grid-desc">
                 <label class="col-sm-4 control-label"><?php echo $entry_carousel_nav; ?></label>
                <div class="col-sm-8">
              		<select name="carousel_nav" class="form-control">  
                  <option value="top" <?php echo($carousel_nav=='top')?'selected="selected"':''; ?>><?php echo $text_top;?></option>
                  <option value="middle" <?php echo($carousel_nav=='middle')?'selected="selected"':''; ?>><?php echo $text_middle;?></option>
                  <option value="hide" <?php echo($carousel_nav=='hide')?'selected="selected"':''; ?>><?php echo $text_hide;?></option>            
                </select>
                </div>
          </div>  <!--//form-group-->
              
              
              
              
             
      
           </div><!-- col-sm-->
       
       </div>
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
  <script type="text/javascript">
	$('input[name=\'filter_input\']').autocomplete({
		delay: 0,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(data) {		
						var from='filter_result';
						var to='custom_item';
						$('#'+from+' div').remove();	
					for (i = 0; i < data.length; i++) {
						var value=data[i]['product_id'] ;
						var name=data[i]['name'] ;
						$("#"+from).append('<div id="div'+from+value+'"><input data-name="custom_item[]" type="hidden" value="' + value + '"/>' + name +'<img src="../assets/theme/img/add.png" onclick="Plus.addObject(\''+from+'\',\''+to+'\',\''+value+'\')" title="Add"/></div>');	
		$('#'+from+' div:even').attr('class', 'odd');	
		$('#'+from+' div:odd').attr('class', 'even');	
						
					}
				}
			});
			
		}
	});
  </script>
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
		
	});
</script>
<?php echo $footer; ?>