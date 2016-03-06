<?php
global $ave;
 echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
    <div>   
     <?php echo $shortcut_group;?>
      </div>
    </div>
    <div class="container-fluid">
      <div class="pull-right">
           <?php if($ave_confirm_installed){?>
            <button type="submit" form="form-blog" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
          <a href="<?php echo $cancel; ?>" class="btn btn-primary btn-sm"><span><i class="fa fa-share-square-o"></i> <?php echo $button_cancel; ?></span></a>
          <?php }else{?>
          <a href="<?php echo $cancel; ?>" class="btn btn-primary btn-sm"><span><i class="fa fa-share-square-o"></i> <?php echo $button_cancel; ?></span></a>
           <?php }?>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
     
 
     <?php if(!$ave_confirm_installed){?>
 <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
 <?php echo $button_sample; ?>
 <div class="pull-right">
      <a href="<?php echo $sample; ?>" class="btn btn-success"> <?php echo $text_yes;?> <span class="icon-thumbs-up-alt"></span></a>   
      <a href="<?php echo $hide_sample; ?>" class="btn btn-danger"><?php echo $text_no;?> <span class="icon-share-alt"></span></a>
</div>  
<div class="clearfix"></div>
    </div>
  <div class="row" style="min-height:400px;">
  <div class="col-md-6 col-xs-12">
  <img class="img-responsive" src="../assets/global/img/blog.png"  style="margin:0 auto; max-width:100%;"/>
  </div>
  <div class="col-md-6 col-xs-12">
      <?php echo $text_install_help;?> 
      </div>
  </div>
	<?php }else{?>
    
<?php if ($ave->validate()==false) { ?>
  <div style="min-height:400px;"><div class="warning"><?php echo $text_error_register; ?></div></div>
	<?php }else{?>
      <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-blog" class="form-horizontal">
     <input type="hidden" name="ave_cms_installed" value="<?php echo $ave_cms_installed;?>" />
   
        
      <?php if(!$ave_confirm_installed){?>
      <div style="padding:20px; border:1px solid #fdfdfd; line-height:18px; text-align:justify; max-width:600px; float:right">
      <?php echo $text_install_help;?> 
      </div>
      <?php }else{?>    
      
        <div class="row">
        <div class="col-sm-8 pull-right">
             <h3 class="ds_heading"><?php echo $text_general;?></h3>
              <div class="ds_content">
              
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $text_backend_shortcut; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_backend_shortcut" class="form-control" >
                  <option value="1" <?php echo ($ave_cms_backend_shortcut=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                  <option value="0" <?php echo ($ave_cms_backend_shortcut=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option>
              </select>
              
                                  </div>
              </div><!-- form-group--> 
              
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $text_sitemap_status; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_sitemap_status" class="form-control">
                  <option value="1" <?php echo ($ave_cms_sitemap_status=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                  <option value="0" <?php echo ($ave_cms_sitemap_status=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option>
              </select> <a href="../index.php?route=information/sitemap" target="_blank">Sitemap Here</a>
                                  </div>
              </div><!-- form-group--> 
     
            </div>
             
            
       <div class="dds_accordion">
        <h3 class="ds_heading"><?php echo $text_category_settings;?></h3>
            <div class="ds_content">
            
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_content_limit; ?></label>
                <div class="col-sm-9">
                <input type="text" name="ave_cms_content_limit" value="<?php echo $ave_cms_content_limit; ?>" class="form-control"/>
               
                
                <?php if ($error_content_limit) { ?>
                <span class="text-danger"><?php echo $error_content_limit; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_article_category; ?></label>
                <div class="col-sm-9">
                
                <div class="row">
    <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_category_width" value="<?php echo $ave_cms_category_width; ?>" class="form-control"/></div>
    <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_category_height" value="<?php echo $ave_cms_category_height; ?>" class="form-control"/></div>
                </div>
                
                <?php if ($error_image_category) { ?>
                <span class="text-danger"><?php echo $error_image_category; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
              
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_default_article_sort ?></label>
                <div class="col-sm-9">
                <select name="ave_cms_sort" class="form-control">
                  
                  <option value="p.date_added" <?php echo ($ave_cms_sort=='p.date_added')?'selected="selected"':'';?>><?php echo $text_sort_date; ?></option>
                  <option value="p.sort_order" <?php echo ($ave_cms_sort=='p.sort_order')?'selected="selected"':'';?>><?php echo $text_sort_order; ?></option>              
                  <option value="pd.name" <?php echo ($ave_cms_sort=='pd.name')?'selected="selected"':'';?>><?php echo $text_sort_name; ?></option>              
                  <option value="p.viewed" <?php echo ($ave_cms_sort=='p.viewed')?'selected="selected"':'';?>><?php echo $text_sort_viewed; ?></option>          
                  <?php if ($ave_cms_comment_status) {?>
                  <option value="rating" <?php echo ($ave_cms_sort=='rating')?'selected="selected"':'';?>><?php echo $text_sort_rating; ?></option>
                  <?php }?>
                </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_default_article_order; ?></label>
                <div class="col-sm-9">
                <select name="ave_cms_order" class="form-control margin-bottom-15">                
                  <option value="DESC" <?php echo ($ave_cms_order=='DESC')?'selected="selected"':''; ?>><?php echo $text_order_desc; ?></option>               
                  <option value="ASC" <?php echo ($ave_cms_order=='ASC')?'selected="selected"':''; ?>><?php echo $text_order_asc; ?></option>
                </select> 
                
                  <div class="well clearfix">
              &nbsp;  &nbsp; &nbsp;  <?php echo $entry_desc_help ;?> &nbsp;  &nbsp; &nbsp; <?php echo $entry_asc_help ;?> 
              </div>
                                  </div>
              </div><!-- form-group--> 
            
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_article_date_format; ?></label>
                <div class="col-sm-9">
                
                <div class="row">
        <div class="col-md-6 col-xs-6">
         <select name="date_format" class="form-control">
                  <option value="d/m/Y" <?php echo($ave_cms_date_format=='d/m/Y')?' selected="selected"':''; ?>>d/m/Y</option>                 
                  <option value="d/m/Y h:i:s" <?php echo($ave_cms_date_format=='d/m/Y h:i:s')?' selected="selected"':''; ?>>d/m/Y h:i:s</option>
                  <option value="d/m/Y h:i:s A" <?php echo($ave_cms_date_format=='d/m/Y h:i:s A')?' selected="selected"':''; ?>>d/m/Y h:i:s A</option>                 
                  <option value="d-m-Y" <?php echo($ave_cms_date_format=='d-m-Y')?' selected="selected"':''; ?>>d-m-Y</option>                 
                  <option value="d-m-Y h:i:s" <?php echo($ave_cms_date_format=='d-m-Y h:i:s')?' selected="selected"':''; ?>>d-m-Y h:i:s</option>
                  <option value="d-m-Y h:i:s A" <?php echo($ave_cms_date_format=='d-m-Y h:i:s A')?' selected="selected"':''; ?>>d-m-Y h:i:s A</option>
                  <option value="d M Y" <?php echo($ave_cms_date_format=='d M Y')?' selected="selected"':''; ?>>d M Y</option>
                  <option value="d M Y h:i:s" <?php echo($ave_cms_date_format=='d M Y h:i:s')?' selected="selected"':''; ?>>d M Y h:i:s</option>
                  <option value="d M Y h:i:s A" <?php echo($ave_cms_date_format=='d M Y h:i:s A')?' selected="selected"':''; ?>>d M Y h:i:s A</option>
                  <option value="d-M-Y" <?php echo($ave_cms_date_format=='d-M-Y')?' selected="selected"':''; ?>>d-M-Y</option>
                  <option value="d-M-Y h:i:s" <?php echo($ave_cms_date_format=='d-M-Y h:i:s')?' selected="selected"':''; ?>>d-M-Y h:i:s</option>
                  <option value="d-M-Y h:i:s A" <?php echo($ave_cms_date_format=='d-M-Y h:i:s A')?' selected="selected"':''; ?>>d-M-Y h:i:s A</option>
                  <option value="Y/m/d" <?php echo($ave_cms_date_format=='Y/m/d')?' selected="selected"':''; ?>>Y/m/d</option>
                  <option value="Y/m/d h:i:s" <?php echo($ave_cms_date_format=='Y/m/d h:i:s')?' selected="selected"':''; ?>>Y/m/d h:i:s</option>
                  <option value="Y/m/d h:i:s A" <?php echo($ave_cms_date_format=='Y/m/d h:i:s A')?' selected="selected"':''; ?>>Y/m/d h:i:s A</option>
                  <option value="Y-m-d" <?php echo($ave_cms_date_format=='Y-m-d')?' selected="selected"':''; ?>>Y-m-d</option>
                  <option value="Y-m-d h:i:s" <?php echo($ave_cms_date_format=='Y-m-d h:i:s')?' selected="selected"':''; ?>>Y-m-d h:i:s</option>
                  <option value="Y-m-d h:i:s A" <?php echo($ave_cms_date_format=='Y-m-d h:i:s A')?' selected="selected"':''; ?>>Y-m-d h:i:s A</option>                  
                </select>
        </div>
        <div class="col-md-6 col-xs-6">
                <input type="text" name="ave_cms_date_format" value="<?php echo $ave_cms_date_format;?>" size="10" style=" di" class="form-control"/>
        </div>
                </div>
                
                                  </div>
              </div><!-- form-group--> 
              
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_ave_cms_content_description_limit; ?></label>
                <div class="col-sm-9">
      <input type="text" name="ave_cms_content_description_limit" value="<?php echo $ave_cms_content_description_limit; ?>" size="5" nKeyPress="if((event.keyCode< 48)|| (event.keyCode > 57)) event.returnValue =false" class="form-control"/>
                <?php if ($error_ave_cms_content_desc_limit) { ?>
                <span class="text-danger"><?php echo $error_ave_cms_content_desc_limit; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_related_description_limit; ?></label>
                <div class="col-sm-9">
      <input type="text" name="ave_cms_related_description_limit" value="<?php echo $ave_cms_related_description_limit; ?>" size="5" nKeyPress="if((event.keyCode< 48)|| (event.keyCode > 57)) event.returnValue =false" class="form-control"/>
                <?php if ($error_ave_cms_related_desc_limit) { ?>
                <span class="text-danger"><?php echo $error_ave_cms_related_desc_limit; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
           </div><!--end  box-content--> 
              <h3 class="ds_heading"><?php echo $text_blog_page; ?></h3>
            <div class="ds_content">
            
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_article_grid_limit; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_post_grid_limit" class="form-control">
                  <option value="2" <?php echo ($ave_cms_post_grid_limit=='2')?'selected="selected"':'';?>>2</option>
                  <option value="3" <?php echo ($ave_cms_post_grid_limit=='3')?'selected="selected"':'';?>>3</option>
                  <option value="4" <?php echo ($ave_cms_post_grid_limit=='4')?'selected="selected"':'';?>>4</option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group required">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_image_article; ?></label>
                <div class="col-sm-9">
                
                <div class="row">
    <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_blog_list_image_width" value="<?php echo $ave_cms_blog_list_image_width; ?>" class="form-control"/></div>
    <div class="col-md-6 col-xs-6">
                <input type="text" name="ave_cms_blog_list_image_height" value="<?php echo $ave_cms_blog_list_image_height; ?>" class="form-control"/></div>
                </div>
                <?php if ($error_blog_list_image) { ?>
                <span class="text-danger"><?php echo $error_blog_list_image; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_article_banner; ?></label>
                <div class="col-sm-9">
                <div class="row">
                <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_article_popup_width" value="<?php echo $ave_cms_article_popup_width; ?>" class="form-control"/></div>
                <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_article_popup_height" value="<?php echo $ave_cms_article_popup_height; ?>" class="form-control"/></div>
                </div>               
                <?php if ($error_image_banner) { ?>
                <span class="text-danger"><?php echo $error_image_banner; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
              
              <h3><?php echo $entry_blog_post; ?></h3>
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_blog_image; ?>
                 <br> <span class="help">Suggestion ratio: 3:1<br>Ex: 1200 x 400</span>
                 </label>
                <div class="col-sm-9">
                
                <div class="row">
    <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_blog_details_image_width" value="<?php echo $ave_cms_blog_details_image_width; ?>" class="form-control"/></div>
    <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_blog_details_image_height" value="<?php echo $ave_cms_blog_details_image_height; ?>" class="form-control"/></div>
                </div>
                
                <?php if ($error_image_article) { ?><br> 
                <span class="text-danger"><?php echo $error_image_article; ?></span>
                <?php } ?>
                
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $text_related_display; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_blog_related_display"  class="form-control tr_change with-nav" id="blog_display" onchange="Plus.activeObj('blog_display',this.options[this.selectedIndex].value);">
<option value="post-carousel-grid"  <?php if ($ave_cms_blog_related_display=='post-carousel-grid'){ ?>selected="selected"<?php } ?>><?php echo $text_carousel_grid; ?></option>
<option value="post-grid"  <?php if ($ave_cms_blog_related_display=='post-grid'){ ?>selected="selected"<?php } ?>><?php echo $text_post_grid; ?></option>
<option value="post-carousel-list"  <?php if ($ave_cms_blog_related_display=='post-list-carousel'){ ?>selected="selected"<?php } ?>><?php echo $text_carousel_list; ?></option>  
<option value="post-list"  <?php if ($ave_cms_blog_related_display=='post-list'){ ?>selected="selected"<?php } ?>><?php echo $text_post_list; ?></option>   
              </select>
                                  </div>
              </div><!-- form-group--> 
              
          <div class="form-group">
            <label class="col-sm-4 control-label"></label>
            <div class="col-sm-8">
            <div style="max-width:480px;">
            <img src="../assets/editor/img/mockup/post-carousel-grid.png" class="img-responsive blog_display otp-post-carousel-grid" style="display:none;"/>
            <img src="../assets/editor/img/mockup/post-grid.png" class="img-responsive blog_display otp-post-grid" style="display:none;"/>
            <img src="../assets/editor/img/mockup/post-carousel-list.png" class="img-responsive blog_display otp-post-list-carousel" style="display:none;"/>
            <img src="../assets/editor/img/mockup/post-list.png" class="img-responsive blog_display otp-post-list" style="display:none;"/>
            </div>
            </div>
          </div>     
          
              <div class="form-group blog_display otp-post-grid">
                <label class="col-sm-3 control-label" for=""><?php echo $text_relate_grid_limit; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_gallery_grid_limit" class="form-control">
                  <option value="2" <?php echo ($ave_cms_gallery_grid_limit=='2')?'selected="selected"':'';?>>2</option>
                  <option value="3" <?php echo ($ave_cms_gallery_grid_limit=='3')?'selected="selected"':'';?>>3</option>
                  <option value="4" <?php echo ($ave_cms_gallery_grid_limit=='4')?'selected="selected"':'';?>>4</option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group blog_display otp-post-carousel-grid">
                <label class="col-sm-3 control-label" for=""><?php echo $text_relate_carousel_limit; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_gallery_grid_limit" class="form-control">
                  <option value="2" <?php echo ($ave_cms_gallery_grid_limit=='2')?'selected="selected"':'';?>>2</option>
                  <option value="3" <?php echo ($ave_cms_gallery_grid_limit=='3')?'selected="selected"':'';?>>3</option>
                  <option value="4" <?php echo ($ave_cms_gallery_grid_limit=='4')?'selected="selected"':'';?>>4</option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              
           </div><!--end  box-content--> 
              <h3 class="ds_heading"><?php echo $text_gallery_page; ?></h3>
            <div class="ds_content">
            
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_article_grid_limit; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_gallery_grid_limit" class="form-control">
                  <option value="2" <?php echo ($ave_cms_gallery_grid_limit=='2')?'selected="selected"':'';?>>2</option>
                  <option value="3" <?php echo ($ave_cms_gallery_grid_limit=='3')?'selected="selected"':'';?>>3</option>
                  <option value="4" <?php echo ($ave_cms_gallery_grid_limit=='4')?'selected="selected"':'';?>>4</option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group required">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_image_article; ?></label>
                <div class="col-sm-9">
                
                <div class="row">
    <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_gallery_list_image_width" value="<?php echo $ave_cms_gallery_list_image_width; ?>" class="form-control"/></div>
    <div class="col-md-6 col-xs-6">
                <input type="text" name="ave_cms_gallery_list_image_height" value="<?php echo $ave_cms_gallery_list_image_height; ?>" class="form-control"/></div>
                </div>
                <?php if ($error_gallery_list_image) { ?>
                <span class="text-danger"><?php echo $error_gallery_list_image; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_article_banner; ?></label>
                <div class="col-sm-9">
                <div class="row">
                <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_gallery_popup_width" value="<?php echo $ave_cms_gallery_popup_width; ?>" class="form-control"/></div>
                <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_gallery_popup_height" value="<?php echo $ave_cms_gallery_popup_height; ?>" class="form-control"/></div>
                </div>               
                <?php if ($error_image_gallery_popup) { ?>
                <span class="text-danger"><?php echo $error_image_gallery_popup; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
              <h3><?php echo $entry_gallery; ?></h3>
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_gallery_image; ?></label>
                <div class="col-sm-9">
                <div class="row">
        <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_gallery_details_image_width" value="<?php echo $ave_cms_gallery_details_image_width; ?>" class="form-control"/></div>
        <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_gallery_details_image_height" value="<?php echo $ave_cms_gallery_details_image_height; ?>" class="form-control"/></div>
                </div>                
                <?php if ($error_image_gallery) { ?>
                <span class="text-danger"><?php echo $error_image_gallery; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $text_cms_gallery_image_limit; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_gallery_details_image_limit" class="form-control">
                  <option value="6" <?php echo ($ave_cms_gallery_details_image_limit=='6')?'selected="selected"':'';?>>2</option>
                  <option value="4" <?php echo ($ave_cms_gallery_details_image_limit=='4')?'selected="selected"':'';?>>3</option>
                  <option value="3" <?php echo ($ave_cms_gallery_details_image_limit=='3')?'selected="selected"':'';?>>4</option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $text_related_display; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_gallery_related_display"  class="form-control tr_change with-nav" id="gallery_display" onchange="Plus.activeObj('gallery_display',this.options[this.selectedIndex].value);">
<option value="gallery-carousel"  <?php if ($ave_cms_gallery_related_display=='gallery-carousel'){ ?>selected="selected"<?php } ?>><?php echo $text_gallery_carousel; ?></option>
<option value="gallery-grid"  <?php if ($ave_cms_gallery_related_display=='gallery-grid'){ ?>selected="selected"<?php } ?>><?php echo $text_gallery_grid; ?></option>
<option value="gallery-popup"  <?php if ($ave_cms_gallery_related_display=='gallery-popup'){ ?>selected="selected"<?php } ?>><?php echo $text_popup_gallery; ?></option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
          <div class="form-group">
            <label class="col-sm-4 control-label"></label>
            <div class="col-sm-8">
            <div style="max-width:480px;">
            <img src="../assets/editor/img/mockup/post-carousel-grid.png" class="img-responsive gallery_display otp-gallery-carousel" style="display:none;"/>
            <img src="../assets/editor/img/mockup/post-grid.png" class="img-responsive gallery_display otp-gallery-grid otp-gallery-column-list" style="display:none;"/>
            <img src="../assets/editor/img/mockup/post-grid.png" class="img-responsive gallery_display otp-gallery-popup" style="display:none;"/>
            
            
            </div>
            </div>
          </div>     
          
              <div class="form-group gallery_display otp-gallery-grid">
                <label class="col-sm-3 control-label" for=""><?php echo $text_relate_grid_limit; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_gallery_grid_limit" class="form-control">
                  <option value="2" <?php echo ($ave_cms_gallery_grid_limit=='2')?'selected="selected"':'';?>>2</option>
                  <option value="3" <?php echo ($ave_cms_gallery_grid_limit=='3')?'selected="selected"':'';?>>3</option>
                  <option value="4" <?php echo ($ave_cms_gallery_grid_limit=='4')?'selected="selected"':'';?>>4</option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group gallery_display otp-gallery-carousel">
                <label class="col-sm-3 control-label" for=""><?php echo $text_relate_carousel_limit; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_gallery_carousel_limit" class="form-control">
                  <option value="2" <?php echo ($ave_cms_gallery_carousel_limit=='2')?'selected="selected"':'';?>>2</option>
                  <option value="3" <?php echo ($ave_cms_gallery_carousel_limit=='3')?'selected="selected"':'';?>>3</option>
                  <option value="4" <?php echo ($ave_cms_gallery_carousel_limit=='4')?'selected="selected"':'';?>>4</option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              
           </div><!--end  box-content--> 
              <h3 class="ds_heading"><?php echo $text_project_page; ?></h3>
            <div class="ds_content">
            
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_article_grid_limit; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_project_grid_limit" class="form-control">
                  <option value="2" <?php echo ($ave_cms_project_grid_limit=='2')?'selected="selected"':'';?>>2</option>
                  <option value="3" <?php echo ($ave_cms_project_grid_limit=='3')?'selected="selected"':'';?>>3</option>
                  <option value="4" <?php echo ($ave_cms_project_grid_limit=='4')?'selected="selected"':'';?>>4</option>
              </select>
                                  </div>
              </div><!-- form-group--> 
      
              <div class="form-group required">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_image_article; ?></label>
                <div class="col-sm-9">
                
                <div class="row">
    <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_project_list_image_width" value="<?php echo $ave_cms_project_list_image_width; ?>" class="form-control"/></div>
    <div class="col-md-6 col-xs-6">
                <input type="text" name="ave_cms_project_list_image_height" value="<?php echo $ave_cms_project_list_image_height; ?>" class="form-control"/></div>
                </div>
                <?php if ($error_project_list_image) { ?>
                <span class="text-danger"><?php echo $error_project_list_image; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_article_banner; ?></label>
                <div class="col-sm-9">
                <div class="row">
                <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_project_popup_width" value="<?php echo $ave_cms_project_popup_width; ?>" class="form-control"/></div>
                <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_project_popup_height" value="<?php echo $ave_cms_project_popup_height; ?>" class="form-control"/></div>
                </div>               
                <?php if ($error_image_project_popup) { ?>
                <span class="text-danger"><?php echo $error_image_project_popup; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
              
               
              <h3><?php echo $entry_project; ?></h3>
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_project_image; ?></label>
                <div class="col-sm-9">
                
                <div class="row">
        <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_project_details_image_width" value="<?php echo $ave_cms_project_details_image_width; ?>" class="form-control"/></div>
        <div class="col-md-6 col-xs-6"><input type="text" name="ave_cms_project_details_image_height" value="<?php echo $ave_cms_project_details_image_height; ?>" class="form-control"/></div>
                </div>
                <?php if ($error_image_project) { ?>
                <span class="text-danger"><?php echo $error_image_project; ?></span>
                <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $text_related_display; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_project_related_display"  class="form-control tr_change with-nav" id="project_display" onchange="Plus.activeObj('project_display',this.options[this.selectedIndex].value);">
<option value="project-cover-photo"  <?php if ($ave_cms_project_related_display=='project-cover-photo'){ ?>selected="selected"<?php } ?>><?php echo $text_project_cover; ?></option>
<option value="project-carousel"  <?php if ($ave_cms_project_related_display=='project-carousel'){ ?>selected="selected"<?php } ?>><?php echo $text_project_carousel; ?></option>
<option value="project-grid"  <?php if ($ave_cms_project_related_display=='project-grid'){ ?>selected="selected"<?php } ?>><?php echo $text_project_grid; ?></option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
          <div class="form-group">
            <label class="col-sm-4 control-label"></label>
            <div class="col-sm-8">
            <div style="max-width:480px;">
            <img src="../assets/editor/img/mockup/post-grid.png" class="img-responsive project_display otp-project-cover-photo" style="display:none;"/>
            <img src="../assets/editor/img/mockup/post-carousel-grid.png" class="img-responsive project_display otp-project-carousel" style="display:none;"/>
            <img src="../assets/editor/img/mockup/post-grid.png" class="img-responsive project_display otp-project-grid" style="display:none;"/>
            </div>
            </div>
          </div>     
          
          
              <div class="form-group project_display otp-project-grid">
                <label class="col-sm-3 control-label" for=""><?php echo $text_relate_grid_limit; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_project_grid_limit" class="form-control">
                  <option value="2" <?php echo ($ave_cms_project_grid_limit=='2')?'selected="selected"':'';?>>2</option>
                  <option value="3" <?php echo ($ave_cms_project_grid_limit=='3')?'selected="selected"':'';?>>3</option>
                  <option value="4" <?php echo ($ave_cms_project_grid_limit=='4')?'selected="selected"':'';?>>4</option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group project_display otp-project-carousel">
                <label class="col-sm-3 control-label" for=""><?php echo $text_relate_carousel_limit; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_project_carousel_limit" class="form-control">
                  <option value="2" <?php echo ($ave_cms_gallery_carousel_limit=='2')?'selected="selected"':'';?>>2</option>
                  <option value="3" <?php echo ($ave_cms_project_carousel_limit=='3')?'selected="selected"':'';?>>3</option>
                  <option value="4" <?php echo ($ave_cms_project_carousel_limit=='4')?'selected="selected"':'';?>>4</option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              
           </div><!--end  box-content--> 
        <h3 class="ds_heading"><?php echo $text_article_details;?></h3>
            <div class="ds_content">
            
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $text_cms_addthis; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_addthis" class="form-control">
                  <option value="1" <?php echo ($ave_cms_addthis=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                  <option value="0" <?php echo ($ave_cms_addthis=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $text_cms_disqus_comment; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_disqus_comment" class="form-control">
                  <option value="1" <?php echo ($ave_cms_disqus_comment=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                  <option value="0" <?php echo ($ave_cms_disqus_comment=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $text_cms_fb_comment; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_fb_comment" class="form-control">
                  <option value="1" <?php echo ($ave_cms_fb_comment=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                  <option value="0" <?php echo ($ave_cms_fb_comment=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $text_cms_gplus_comment; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_gplus_comment" class="form-control">
                  <option value="1" <?php echo ($ave_cms_gplus_comment=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                  <option value="0" <?php echo ($ave_cms_gplus_comment=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              
              
             
              
              <h3><?php echo $entry_related_item; ?></h3>
              
                <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $text_related_display; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_related_product_display"  class="form-control tr_change with-nav" id="product_display" onchange="Plus.activeObj('product_display',this.options[this.selectedIndex].value);">
    <option value="product-carousel-grid" <?php echo ($ave_cms_related_product_display=='product-carousel-grid')?'selected="selected"':'';?>><?php echo $text_product_carousel_grid;?></option>
    <option value="product-carousel-list" <?php echo ($ave_cms_related_product_display=='product-carousel-list')?'selected="selected"':'';?>><?php echo $text_product_carousel_list;?></option>
    <option value="product-grid" <?php echo ($ave_cms_related_product_display=='product-grid')?'selected="selected"':'';?>><?php echo $text_product_grid;?></option>
    <option value="product-list" <?php echo ($ave_cms_related_product_display=='product-list')?'selected="selected"':'';?>><?php echo $text_product_list;?></option>
              
              </select>
                                  </div>
              </div><!-- form-group-->
              
               <div class="form-group">
            <label class="col-sm-4 control-label" ></label>
            <div class="col-sm-8">
            <div style="max-width:480px;">
            <img src="../assets/editor/img/mockup/product-carousel-grid.png" class="img-responsive product_display otp-product-carousel-grid" style="display:none;"/>
            <img src="../assets/editor/img/mockup/product-carousel-list.png" class="img-responsive product_display otp-product-carousel-list" style="display:none;"/>
            <img src="../assets/editor/img/mockup/product-grid.png" class="img-responsive product_display otp-product-grid" style="display:none;"/>
            <img src="../assets/editor/img/mockup/product-list.png" class="img-responsive product_display otp-product-list" style="display:none;"/>
            </div>
            </div>
          </div>     
              
              <div class="form-group product_display otp-product-grid">
                <label class="col-sm-3 control-label" for=""><?php echo $text_relate_grid_limit; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_product_grid_limit" class="form-control">
                  <option value="6" <?php echo ($ave_cms_product_grid_limit=='6')?'selected="selected"':'';?>>2</option>
                  <option value="4" <?php echo ($ave_cms_product_grid_limit=='4')?'selected="selected"':'';?>>3</option>
                  <option value="3" <?php echo ($ave_cms_product_grid_limit=='3')?'selected="selected"':'';?>>4</option>
              </select>
                                  </div>
              </div><!-- form-group--> 
              <div class="form-group product_display otp-product-carousel-grid">
                <label class="col-sm-3 control-label" for=""><?php echo $text_relate_carousel_limit; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_product_carousel_limit" class="form-control">
                  <option value="2" <?php echo ($ave_cms_product_carousel_limit=='2')?'selected="selected"':'';?>>2</option>
                  <option value="3" <?php echo ($ave_cms_product_carousel_limit=='3')?'selected="selected"':'';?>>3</option>
                  <option value="4" <?php echo ($ave_cms_product_carousel_limit=='4')?'selected="selected"':'';?>>4</option>
              </select>
                                  </div>
              </div><!-- form-group--> 
           </div><!--end  box-content--> 
        <h3 class="ds_heading"><?php echo $text_download_settings;  ?></h3>
            <div class="ds_content">  
            
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_upload_allowed; ?></label>
                <div class="col-sm-9">
                <textarea name="ave_cms_upload_allowed" cols="40" rows="5" class="form-control"><?php echo $ave_cms_upload_allowed; ?></textarea>
                                  </div>
              </div><!-- form-group--> 
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_login_to_download; ?></label>
                <div class="col-sm-9">                
      <label><input type="radio" name="ave_cms_login_to_download" value="1" <?php echo (!empty($ave_cms_login_to_download))?'checked="checked"':''; ?> /><?php echo $text_yes; ?></label>
      <label><input type="radio" name="ave_cms_login_to_download" value="0" <?php echo (empty($ave_cms_login_to_download))?'checked="checked"':''; ?>/><?php echo $text_no; ?></label>
                          </div>
              </div><!-- form-group--> 
        
           </div><!--end  box-content--> 
        <h3 class="ds_heading"><?php echo $text_comment_settings;?></h3>   
            <div class="ds_content"> 
            
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_comment; ?></label>
                <div class="col-sm-9">
       <label> <input type="radio" name="ave_cms_comment_status" value="1" <?php echo (!empty($ave_cms_comment_status))?'checked="checked"':''; ?> /> <?php echo $text_yes; ?></label>
       <label><input type="radio" name="ave_cms_comment_status" value="0" <?php echo (empty($ave_cms_comment_status))?'checked="checked"':''; ?>/> <?php echo $text_no; ?></label>
                                  </div>
              </div><!-- form-group--> 
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_comment_email; ?></label>
                <div class="col-sm-9">
                <input type="radio" name="ave_cms_comment_email" value="1" <?php echo (!empty($ave_cms_comment_email))?'checked="checked"':''; ?>/> <?php echo $text_yes; ?>
                <input type="radio" name="ave_cms_comment_email" value="0" <?php echo (empty($ave_cms_comment_email))?'checked="checked"':''; ?>/><?php echo $text_no; ?>
                                  </div>
              </div><!-- form-group--> 
              
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_comment_email_value; ?></label>
                <div class="col-sm-9">
                <input type="text" name="ave_cms_comment_email_notifications" value="<?php echo $ave_cms_comment_email_notifications; ?>" size="50" class="form-control"/>
                <?php if ($error_email) { ?>
            <br/> <span class="text-danger"><?php echo $error_email; ?></span>
            <?php } ?>
                                  </div>
              </div><!-- form-group--> 
              <div class="form-group">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_comment_approved; ?></label>
                <div class="col-sm-9">
                <label>
                <input type="radio" name="ave_cms_comment_approved" value="1" <?php echo (!empty($ave_cms_comment_approved))?'checked="checked"':''; ?>/>
                <?php echo $text_yes; ?></label>
                <label> <input type="radio" name="ave_cms_comment_approved" value="0" <?php echo (empty($ave_cms_comment_approved))?'checked="checked"':''; ?>/>
                <?php echo $text_no; ?></label>
                
                                  </div>
              </div><!-- form-group--> 
           
           </div><!--end  box-content--> 
       <h3 class="ds_heading"><?php echo $text_testimonials;?></h3>
              <div class="ds_content">
              
              <div class="form-group required">
                <label class="col-sm-3 control-label" for=""><?php echo $entry_login_to_testimonial; ?></label>
                <div class="col-sm-9">
              <select name="ave_cms_testimonial_login" class="form-control">
                  <option value="1" <?php echo ($ave_cms_testimonial_login=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                  <option value="0" <?php echo ($ave_cms_testimonial_login=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option>
              </select>
                                  </div>
              </div><!-- form-group--> 
            </div>
        
           </div><!--end accordion -->   
           
        </div><!--// --> 
        <div class="col-sm-4">
        <div class="dds_accordion">
          <h3 class="ds_heading"><?php echo $text_news_overview; ?></h3>
          <div class="ds_content">
            <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
              <td width="150"><?php echo $text_total_category; ?></td>
              <td><div style="float:right;color:#F00; font-weight:bold;">(<?php echo $total_category; ?>)</div>
              </td>
            </tr>
            <tr>
              <td><?php echo $text_total_article; ?></td>
              <td>             <div style="float:right;color:#F00; font-weight:bold;">(<?php echo $total_article; ?>)</div>
              </td>
            </tr>
            <tr>
              <td><?php echo $text_total_author; ?></td>
              <td>  <div style="float:right;color:#F00; font-weight:bold;">(<?php echo $total_author; ?>)</div>  
              </td>
            </tr> 
            <tr>
              <td><?php echo $text_total_poll; ?></td>
               <td><div style="float:right;color:#F00; font-weight:bold;">(<?php echo $total_poll; ?>)</div></td>
            </tr>     
          
            <tr>
              <td><?php echo $text_total_download; ?></td>
              <td> <div style="float:right;color:#F00; font-weight:bold;">(<?php echo $total_download; ?>)</div>
              </td>
            </tr>
            
            <tr>
              <td><?php echo $text_total_comment; ?></td>
              <td><div style="float:right;color:#F00; font-weight:bold;">(<?php echo $total_comment; ?>)</div></td>
            </tr>      
           
              
          </table>
          </div>
          </div><!-- //ds_content--> 
          <h3 class="ds_heading"><?php echo $text_database; ?></h3>
          <div class="ds_content">
             <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
              <td width="150"><?php echo $text_optimize_db; ?>: </td>
              <td>
              <a href="<?php echo $optimize;?>" class="btn btn-primary btn-sm"><span><?php echo $text_optimize;?></span></a>
              </td>
            </tr>
             <tr>
              <td colspan="2">
          <div class="warning" align="center">Please be careful in this area because you may lose all your Bog Database.<br> 
           Only manipulation when you really want to reset your Blog!</div></td>
              
            </tr>
            <tr>
              <td><?php echo $text_uninstall_module; ?>:</td>
              <td>
              <a href="<?php echo $uninstall_module;?>" class="btn btn-danger btn-sm"><span><?php echo $text_uninstall;?> </span></a>     
              
              </td>
            </tr>
            
            <tr>
              <td><?php echo $text_empty_db; ?>: </td>
              <td>
              <a href="<?php echo $empty_db;?>" class="btn btn-danger  btn-sm"><span><?php echo $text_empty;?></span></a>
              </td>
            </tr>
            <tr>
              <td><?php echo $text_drop_db; ?>:</td>
              <td>
              <a href="<?php echo $drop_db;?>" class="btn btn-danger  btn-sm"><span><?php echo $text_drop;?></span></a>
              
              </td>
            </tr>
           
            <tr>
              <td colspan="2">Thank you for using this extension!</td>
            </tr>  
          
          </table>
          </div><!--table --> 
          
          </div></div><!-- ds_accordion--> 
        
        </div><!--//col--> 
        </div><!-- //row--> 
          
           
          <?php } ?>   
          
          
      </form>
      
          </div><!-- /panel-body--> 
          
          </div><!-- panel--> 
       <?php }?>
<?php } ?>
 
          </div><!-- container-fluid--> 
          </div><!-- #content--> 
<script type="text/javascript"><!--
			$('select[name=\'date_format\']').bind('change', function() {
			var format=this.value;
				$('input[name=\'ave_cms_date_format\']').val(format);
			});
			//--></script> 
<script type="text/javascript">
//-----------------------------------------
// Confirm Actions (delete, uninstall)
//-----------------------------------------
$(document).ready(function(){    	
    // Confirm Uninstall
    $('a').click(function(){
        if ($(this).attr('href') != null && $(this).attr('href').indexOf('install_sample', 1) != -1) {
            if (!confirm('<?php echo $text_confirm; ?>')) {
                return false;
            }
        }
    });
});
</script>
<script type="text/javascript">
//-----------------------------------------
// Confirm Actions (delete, uninstall)
//-----------------------------------------
$(document).ready(function(){    	
    // Confirm Uninstall
    $('a').click(function(){
        if ($(this).attr('href') != null && $(this).attr('href').indexOf('empty_db', 1) != -1) {
            if (!confirm('<?php echo $text_confirm_empty; ?>')) {
                return false;
            }
        }
    });
});
</script>
<script type="text/javascript">
//-----------------------------------------
// Confirm Actions (delete, uninstall)
//-----------------------------------------
$(document).ready(function(){    	
    // Confirm Uninstall
    $('a').click(function(){
        if ($(this).attr('href') != null && $(this).attr('href').indexOf('drop_db', 1) != -1) {
            if (!confirm('<?php echo $text_confirm_drop; ?>')) {
                return false;
            }
        }
    });
});
</script>
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
	});
</script>
<?php echo $footer; ?>