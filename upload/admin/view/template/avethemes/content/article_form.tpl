<?php global $ave;  global $config; echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
    <div>   
     <?php echo $shortcut_group;?>
      </div>
    </div>
    <div class="container-fluid">
      <div class="pull-right">        
      <a onclick="$('#form').submit();" class="btn btn-success btn-sm"><span><i class="fa fa-save"></i> <?php echo $button_save; ?></span></a>
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
     
  <?php if(!$config->get('ave_confirm_installed')){?>  
   <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_error_install; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
	<?php }else{?>    
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="form" class="form-horizontal">
      <ul class="nav nav-tabs">
      <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
      <li><a href="#tab-image" data-toggle="tab"><?php echo $tab_photo; ?></a></li>
      <li><a href="#tab-layout-store" data-toggle="tab"><?php echo $text_layout_store; ?></a></li>
      </ul>
      <input type="hidden" name="article_id" value="<?php echo $article_id;?>" />
      
        <div class="tab-content">
        <div id="tab-general" class="tab-pane in active">
        <div class="row">
        
          <div class="col-sm-8">
          <h2><?php echo $text_general_info;?></h2>
              
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_item_display; ?></label>
                <div class="col-sm-8">
              <select name="item_display" id="item_display" class="form-control tr_change" onchange="Plus.activeObj('item_display',this.options[this.selectedIndex].value);">
                  <option value="blog" <?php echo ($item_display=='blog')?'selected="selected"':''; ?>><?php echo $text_post;?></option>
                  <option value="gallery" <?php echo ($item_display=='gallery')?'selected="selected"':''; ?>><?php echo $text_gallery;?></option>
                  <option value="project" <?php echo ($item_display=='project')?'selected="selected"':''; ?>><?php echo $text_project;?></option>
                </select>
                </div>
              </div><!-- form-group-->
              <div class="form-group">
                <label class="col-sm-4 control-label required" for=""><?php echo $entry_title; ?></label>
                <div class="col-sm-8">
                
            <?php foreach ($languages as $language) { ?>
            <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input id="title" type="text" name="article_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['name'] : ''; ?>" class="form-control"/>
                  <?php if (isset($error_title[$language['language_id']])) { ?><br> 
                  <span class="text-danger"><?php echo $error_title[$language['language_id']]; ?></span>
                  <?php } ?>
                  
                  </div>
            <?php } ?>
                </div>
              </div><!-- form-group-->
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_keyword; ?></label>
                <div class="col-sm-8">
                
              <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" class="form-control"/>
              <?php if ($error_keyword) { ?>
               <br><span class="text-danger"><?php echo $error_keyword; ?></span>
                <?php } ?>
                </div>
              </div><!-- form-group-->
              
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_tag; ?></label>
                <div class="col-sm-8">
                <?php foreach ($languages as $language) { ?>
            <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="article_description[<?php echo $language['language_id']; ?>][tag]" value="<?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['tag'] : ''; ?>" class="form-control"/>
                  </div>
            <?php } ?>
                
                </div>
              </div><!-- form-group-->  
              
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_meta_description; ?></label>
                <div class="col-sm-8">
                 <ul class="nav nav-tabs">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#meta_desc_language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content">
          <?php foreach ($languages as $language) { ?>
          <div id="meta_desc_language<?php echo $language['language_id']; ?>" class="tab-pane in">
            <textarea class="form-control" name="article_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['meta_description'] : ''; ?></textarea>  
                
            </div>
          <?php } ?>
          </div>
                </div>
              </div><!-- form-group-->  
              
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_meta_keyword; ?></label>
                <div class="col-sm-8">
          <ul class="nav nav-tabs">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#meta_kw_language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content">
          <?php foreach ($languages as $language) { ?>
          <div id="meta_kw_language<?php echo $language['language_id']; ?>" class="tab-pane in">
            <textarea class="form-control" name="article_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea> 
                
            </div>
          <?php } ?>
          </div>
                </div>
              </div><!-- form-group-->  
              
              
                <div class="form-group">
                <label class="control-label text-left" for=""><?php echo $text_content_description; ?></label>
                <div class="col-sm-12">
        
           <table class="form">
         <tr>
                <td colspan="2">               
          <ul class="nav nav-tabs">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#desc_language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
            <?php } ?>
          </ul>
        <div class="tab-content">
          <?php foreach ($languages as $language) { ?>
          <div id="desc_language<?php echo $language['language_id']; ?>" class="tab-pane in">
                <textarea name="article_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['description'] : ''; ?></textarea>
                
            </div>
          <?php } ?>
          </div><!--tab-content --> 
                </td>
              </tr>
              </table>
                </div>
              </div><!-- form-group-->  
              
              
          </div><!--col-sm-7 --> 
          
          
          
          
          
          
          <div class="col-sm-4">
          <div class="heading-bar"><?php echo $text_data;?></div>
             
              <div class="dds_accordion">
              
              <h3 class="ds_heading"><?php echo $tab_general; ?></h3>
              <div class="ds_content">  <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_author; ?></label>
                <div class="col-sm-8">
              <select name="author_id" class="form-control">
                      <?php foreach ($authors as $author) { ?>
                      <?php if ($author['author_id'] == $author_id) { ?>
                      <option value="<?php echo $author['author_id']; ?>" selected="selected"><?php echo $author['author']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $author['author_id']; ?>"><?php echo $author['author']; ?></option>
                      <?php } ?>
                      <?php } ?>
                      <option value="0"><?php echo $text_none; ?></option>
                    </select>
                    <?php if ($error_author) { ?>
                    <span class="text-danger"><?php echo $error_author; ?></span>
                    <?php } ?>
                
                </div>
              </div><!-- form-group-->
              
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_image; ?></label>
                <div class="col-sm-8">
                
              <a href="" id="thumb-thumb" data-toggle="image" class="img-thumbnail">
                    <img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="image" value="<?php echo $image;?>" id="input-image"/>
                </div>
              </div><!-- form-group-->
               
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_icon; ?></label>
                <div class="col-sm-8">
                
             <a class="icon-preview">
                    <i class="<?php echo $icon;?>" id="icon_thumb"></i>
                     <input type="hidden" name="icon" value="<?php echo $icon;?>" id="icon" /></a> 
                </div>
              </div><!-- form-group--> 
              
              <div class="form-group" style="display:none">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_color; ?></label>
                <div class="col-sm-8">
                <div class="pcolor <?php echo $color;?>-bg"></div><select id="bg-color" class="form-control tr_change with-nav" onchange="$('.pcolor').attr('class',this.options[this.selectedIndex].value+'-bg pcolor');" name="color" data-selected="<?php echo $color;?>">
             <?php foreach ($setcolors as $value => $label) {	?>
                  <option value="<?php echo $value;?>"  <?php if ($color==$value) { ?>selected="selected" <?php } ?>><?php echo $label;?></option>	 
			<?php	 }   ?>
                </select>
                </div>
              </div><!-- form-group--> 
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_status; ?></label>
                <div class="col-sm-8">
              <select name="status" class="form-control">
                  <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
                
                </div>
              </div><!-- form-group-->
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-8">
                <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control"/>
                </div>
              </div><!-- form-group-->
              <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_date_added; ?></label>
                <div class="col-sm-8">
                
              <input type="text" name="date_added" value="<?php echo $date_added; ?>" class="form-control datetime"/>
                </div>
              </div><!-- form-group-->
              
              </div><!--//ds_content -->
              <h3 class="ds_heading"><?php echo $entry_category; ?></h3>
              <div class="ds_content">
              <div class="form-group">
                <div class="col-sm-12">
              <div class="autosuggest">
                <div class="autosuggest_heading">
                <input type="text" name="filter_category" value="" class="form-control"/>
                
                </div>
                <div class="autosuggest_content" id="categories">            
                </div>
                <div id="article_category" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($article_categories as $article_category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="article_category<?php echo $article_category['content_id']; ?>" class="<?php echo $class; ?>">
                  <?php echo $article_category['name']; ?>
                  <img src="../assets/theme/img/delete.png" alt="" onclick="$(this).parent().remove();"/>
                    <input type="hidden" name="article_category[]" value="<?php echo $article_category['content_id']; ?>" />
                  </div>
                  <?php } ?>
                </div>
                </div>
                </div>
              </div><!-- form-group-->
           
              </div><!--//ds_content -->
              <h3 class="ds_heading"><?php echo $entry_service; ?></h3>
              <div class="ds_content">
              
              <div class="form-group">
                <div class="col-sm-12">
              <div class="autosuggest">
                <div class="autosuggest_heading">
                <input type="text" name="filter_service" value="" class="form-control"/>
                
                </div>
                <div class="autosuggest_content" id="services">            
                </div>
                <div id="article_service" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($article_services as $article_service) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="article_service<?php echo $article_service['service_id']; ?>" class="<?php echo $class; ?>"><?php echo $article_service['name']; ?><img src="../assets/theme/img/delete.png" alt="" onclick="$(this).parent().remove();"/>
                    <input type="hidden" name="article_service[]" value="<?php echo $article_service['service_id']; ?>" />
                  </div>
                  <?php } ?>
                </div>
                </div>
                </div>
              </div><!-- form-group-->
              
              </div><!--//ds_content --> 
              <h3 class="ds_heading"><?php echo $entry_poll; ?></h3>
              <div class="ds_content">   
              
              <div class="form-group">
                <div class="col-sm-12">
                  <select name="poll_id" class="form-control">
                      <option value="0"><?php echo $text_none; ?></option>
                      <?php foreach ($polls as $poll) { ?>
                      <?php if ($poll['poll_id'] == $poll_id) { ?>
                      <option value="<?php echo $poll['poll_id']; ?>" selected="selected"><?php echo $poll['question']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $poll['poll_id']; ?>"><?php echo $poll['question']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                </div>
              </div><!-- form-group-->
              
               
              </div><!--//ds_content --> 
              <h3 class="ds_heading"><?php echo $text_related_article; ?></h3>
              <div class="ds_content">  
             
              <h4><?php echo $entry_related_article; ?></h4>
              
              <div class="form-group">
                <div class="col-sm-12">
                
             <div class="autosuggest">
                <div class="autosuggest_heading">
                <input type="text" name="filter_article" value="" class="form-control"/>                </div>
                <div class="autosuggest_content" id="articles">            
                </div>
                <div id="related_article" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($related_article as $related_article) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="related_article<?php echo $related_article['article_id']; ?>" class="<?php echo $class; ?>"> <?php echo $related_article['name']; ?><img src="../assets/theme/img/delete.png" alt="" onclick="$(this).parent().remove();"/>
                    <input type="hidden" name="related_article[]" value="<?php echo $related_article['article_id']; ?>" />
                  </div>
                  <?php } ?>
                </div>            </div>
                </div>
              </div><!-- form-group-->
              
                
                
              </div><!--//ds_content --> 
              <h3 class="ds_heading"><?php echo $text_related_product; ?></h3>
              <div class="ds_content">                 
                <label class="col-sm-6 control-label" for=""><?php echo $entry_related_product; ?></label>
              <div class="form-group">
                <div class="col-sm-12">
                
              <div class="autosuggest">
                <div class="autosuggest_heading">
                <input type="text" name="filter_product" value="" class="form-control"/>                
                </div>
                <div class="autosuggest_content" id="products">            
                </div>
                <div id="related_product" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($related_product as $related_product) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="related_product<?php echo $related_product['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $related_product['name']; ?><img src="../assets/theme/img/delete.png" alt="" onclick="$(this).parent().remove();"/>
                    <input type="hidden" name="related_product[]" value="<?php echo $related_product['product_id']; ?>" />
                  </div>
                  <?php } ?>
                </div>
            </div>
                </div>
              </div><!-- form-group-->
            
              </div><!--//ds_content --> 
              <h3 class="ds_heading"><?php echo $entry_download; ?></h3>
              <div class="ds_content">   
              
              <div class="form-group">
                <div class="col-sm-12">
                
              <div class="autosuggest">
                <div class="autosuggest_heading">
                <input type="text" name="filter_download" value="" class="form-control"/>                
                </div>
                <div class="autosuggest_content" id="downloads">            
                </div>
              <div id="article_download" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($downloads as $download) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="article_download<?php echo $download['download_id']; ?>" class="<?php echo $class; ?>"> <?php echo $download['name']; ?><img src="../assets/theme/img/delete.png" alt="" onclick="$(this).parent().remove();"/>
                    <input type="hidden" name="article_download[]" value="<?php echo $download['download_id']; ?>" />
                  </div>
                  <?php } ?>
                </div>
                </div>
                </div>
              </div><!-- form-group-->
              </div><!-- //ds_content--> 
              </div><!-- //ds_accordion--> 
          </div><!--col-md-4 --> 
          </div><!--row --> 
        </div>
                
        <div id="tab-layout-store" class="tab-pane in">
        
          <div class="form-group">
                <label class="col-sm-2 control-label" for=""><?php echo $entry_layout; ?></label>
                <div class="col-sm-10">
                
                <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_store; ?></td>
                <td class="left"><?php echo $entry_layout; ?></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="left"><?php echo $text_default; ?></td>
                <td class="left"><select name="article_layout[0][layout_id]" class="form-control">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($article_layout[0]) && $article_layout[0] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php foreach ($stores as $store) { ?>
            <tbody>
              <tr>
                <td class="left"><?php echo $store['name']; ?></td>
                <td class="left"><select name="article_layout[<?php echo $store['store_id']; ?>][layout_id]" class="form-control">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($article_layout[$store['store_id']]) && $article_layout[$store['store_id']] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php } ?>
          </table>
          </div>
                </div>
              </div><!-- form-group-->
              
          <div class="form-group">
                <label class="col-sm-2 control-label" for=""><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                 <div class="well scrollbox">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array(0, $article_store)) { ?>
                    <input type="checkbox" name="article_store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="article_store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($store['store_id'], $article_store)) { ?>
                    <input type="checkbox" name="article_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="article_store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                </div>
              </div><!-- form-group-->
              
              
       </div>
       
        <div id="tab-image" class="tab-pane in">
          <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
              <td><?php echo $entry_image_dimension; ?>
              
              <span class="item_display otp-blog"><?php echo $ave_cms_blog_details_image_width;?>x<?php echo $ave_cms_blog_details_image_height;?></span>
              <span class="item_display otp-gallery"><?php echo $ave_cms_gallery_details_image_width;?>x<?php echo $ave_cms_gallery_details_image_height;?></span>
              <span class="item_display otp-project"><?php echo $ave_cms_project_details_image_width;?>x<?php echo $ave_cms_project_details_image_height;?></span>
              </td>
              <td>
                
	<?php if($config->get('image_manager_plus_status')==1){ ?>
    <div style="float:right">
     <img src="../assets/theme/img/aright.gif" style="width:32px; margin-top:2px;"/><a onclick="filemanager();" class="btn btn-xs blue-bg pull-right"><?php echo $text_browse_library; ?></a>
               </div>
       <?php }?>        
              </td>
            </tr>
       </table>
         </div>
          <div class="table-responsive">
           <table class="table table-bordered table-hover" id="images">
            <thead>
              <tr>
                <td width="100" class="left"><?php echo $entry_sort_order;?></td>
                <td class="left"><?php echo $entry_image;?></td>
                <td class="left"><?php echo $text_title_desc;?></td>
                <td width="200" class="text-center"><?php echo $text_set_primary_all;?></td>
               <td class="right">
                 
               </td>
              </tr>
          
            </thead>
            
            <?php $image_row = 0;?>
            <?php foreach($article_images as $article_image){?>
            <tbody class="image-row" id="image-row<?php echo $image_row;?>">
             
              <tr>
               <td class="vtop" align="center"><input type="text"  name="article_image[<?php echo $image_row;?>][sort_order]" class="form-control sort_order" value="<?php echo $article_image['sort_order'];?>" id="sort_order<?php echo $image_row;?>"/></td>
               
                <td class="vtop" align="center">
                
                <a href="" id="thumbadd_image<?php echo $image_row;?>" data-toggle="image" class="img-thumbnail">
                    <img src="<?php echo $article_image['thumb'];?>" alt="" title="" data-placeholder="<?php echo $article_image['thumb'];?>" /></a>
                  <input type="hidden" name="article_image[<?php echo $image_row;?>][image]" value="<?php echo $article_image['image'];?>" id="input-add_image<?php echo $image_row;?>"/>
        
        </td> 
               
                <td class="vtop"><?php foreach($languages as $language){?>
                 <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><input type="text" name="article_image[<?php echo $image_row;?>][description][<?php echo $language['language_id'];?>][image_title]" value="<?php echo isset($article_image['description'][$language['language_id']]) ? $article_image['description'][$language['language_id']]['image_title'] : '';?>" class="form-control"/>
                  </div>
                  
                  <br/>                                 
                 
                 <textarea name="article_image[<?php echo $image_row;?>][description][<?php echo $language['language_id'];?>][image_description]" class="form-control" rows="5"><?php echo isset($article_image['description'][$language['language_id']]) ? $article_image['description'][$language['language_id']]['image_description'] : '';?></textarea>
                  <br/> 
                 
                  <?php }?></td>
                  <td class="vtop text-center">
                  <input type="radio" name="primary_image" onclick="changePrimaryImage(<?php echo $image_row; ?>)">
                  </td>
                <td class="vtop text-right"><a onclick="$('#image-row<?php echo $image_row;?>').remove();" class="btn btn-primary btn-xs"><span id="x144y120"></span><?php echo $button_remove;?></a></td>
              </tr>
            </tbody>
            <?php $image_row++;?>
            <?php }?>
            <tfoot>
              <tr>
              
                <td colspan="4"></td>
               <td class="right"><a onclick="addImage();" class="btn btn-primary btn-xs"><?php echo $button_add;?></a></td>
              </tr>
            </tfoot>
          </table>
          </div><!--//table-responsive --> 
        </div>
         
        
        </div><!--//tab-content--> 
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
// Downloads
$('input[name=\'filter_download\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=ave/download/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(data) {		
					var from='downloads';
					var to='article_download';
					
					$('#'+from+' div').remove();	
					for (i = 0; i < data.length; i++) {
						var value=data[i]['download_id'] ;
						var name=data[i]['name'] ;
						$("#"+from).append('<div id="div'+from+value+'"><input data-name="article_download[]" type="hidden" value="' + value + '"/>' + name +'<img src="../assets/theme/img/add.png" onclick="Plus.addObject(\''+from+'\',\''+to+'\',\''+value+'\')" title="Add"/></div>');						
					}
			}
		});
		
	}
});
//--></script> 
<script type="text/javascript"><!--
// Categories
$('input[name=\'filter_category\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=ave/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(data) {		
					var from='categories';
					var to='article_category';					
					$('#'+from+' div').remove();	
					for (i = 0; i < data.length; i++) {
						var value=data[i]['content_id'] ;
						var name=data[i]['name'] ;
						$("#"+from).append('<div id="div'+from+value+'"><input data-name="article_category[]" type="hidden" value="' + value + '"/>' + name +'<img src="../assets/theme/img/add.png" onclick="Plus.addObject(\''+from+'\',\''+to+'\',\''+value+'\')" title="Add"/></div>');	
						$('#'+from+' div:even').attr('class', 'odd');	
						$('#'+from+' div:odd').attr('class', 'even');	
						
					}
			}
		});
		
	}
});
//--></script> 

<script type="text/javascript"><!--
// Services
$('input[name=\'filter_service\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=ave/service/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(data) {		
					var from='services';
					var to='article_service';
					
					$('#'+from+' div').remove();	
					
					for (i = 0; i < data.length; i++) {
						var value=data[i]['service_id'] ;
						var name=data[i]['name'] ;
						$("#"+from).append('<div id="div'+from+value+'"><input data-name="article_service[]" type="hidden" value="' + value + '"/>' + name +'<img src="../assets/theme/img/add.png" onclick="Plus.addObject(\''+from+'\',\''+to+'\',\''+value+'\')" title="Add"/></div>');	
						$('#'+from+' div:even').attr('class', 'odd');	
						$('#'+from+' div:odd').attr('class', 'even');	
					}
			}
		});
		
	}
});
//--></script> 
<script type="text/javascript"><!--
// Related Product
$('input[name=\'filter_product\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=ave/article/product_autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(data) {		
					var from='products';
					var to='related_product';
					
					$('#'+from+' div').remove();
					
					for (i = 0; i < data.length; i++) {
						var value=data[i]['product_id'] ;
						var name=data[i]['name'] ;
						$("#"+from).append('<div id="div'+from+value+'"><input data-name="related_product[]" type="hidden" value="' + value + '"/>' + name +'<img src="../assets/theme/img/add.png" onclick="Plus.addObject(\''+from+'\',\''+to+'\',\''+value+'\')" title="Add"/></div>');		
						$('#'+from+' div:even').attr('class', 'odd');	
						$('#'+from+' div:odd').attr('class', 'even');	
						
					}
			}
		});
		
	}
});
//--></script> 
<script type="text/javascript"><!--
// Related Article
$('input[name=\'filter_article\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=ave/article/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(data) {		
					var from='articles';
					var to='related_article';
					
					$('#'+from+' div').remove();
					for (i = 0; i < data.length; i++) {
						var value=data[i]['article_id'] ;
						var name=data[i]['name'] ;
						$("#"+from).append('<div id="div'+from+value+'"><input data-name="related_article[]" type="hidden" value="' + value + '"/>' + name +'<img src="../assets/theme/img/add.png" onclick="Plus.addObject(\''+from+'\',\''+to+'\',\''+value+'\')" title="Add"/></div>');
						$('#'+from+' div:even').attr('class', 'odd');	
						$('#'+from+' div:odd').attr('class', 'even');	
						
					}
			}
		});
		
	}
});
//--></script>
<script type="text/javascript">
		<?php if($config->get('image_manager_plus_status')==1){
			if (isset($this->request->get['article_id'])) {
						$article_id=$this->request->get['article_id'];
			} else {
						$article_id=0;
			}
		?>			
		$.rcookie('product<?php echo $article_id; ?>_image_row',null);
		<?php } else { ?>
var image_row = <?php echo $image_row;?>+1;
		<?php }?>
		
function addImage() {
	
		<?php if($config->get('image_manager_plus_status')==1){ ?>
		if ($.rcookie('article<?php echo $article_id; ?>_image_row')==null||$.rcookie('article<?php echo $article_id; ?>_image_row')=='') {
			var cookie_image_row = <?php echo $image_row; ?>;	
		}else{	
			var cookie_image_row = $.rcookie('article<?php echo $article_id; ?>_image_row');	
		}	
		var image_row =cookie_image_row;	
		$.rcookie('article<?php echo $article_id; ?>_image_row',null);
		<?php }?>
		
	html  = '<tbody class="image-row" id="image-row' + image_row + '">';
    html += '  <tr>';
	html += '<td class="vtop text-center"><input style="width:20px;" type="text" name="article_image[' + image_row + '][sort_order]" class="form-control sort_order" value="' + image_row + '" id="sort_order' + image_row + '"/></td>';
	
	html += '<td class="vtop" align="center">';
	html += '<a href="" id="thumbadd_image' + image_row + '" data-toggle="image" class="img-thumbnail">';
    html += '<img src="<?php echo $placeholder;?>" alt="" title="" data-placeholder="<?php echo $placeholder;?>" />';
    html += '</a><input type="hidden" name="article_image[' + image_row + '][image]" value="" id="input-add_image' + image_row + '"/>';
	html += '</td>';
	
	html += '    <td class="vtop left">';
	<?php foreach($languages as $language){?>	
	html += ' <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
	html += '<input type="text" value="Title" name="article_image[' + image_row + '][description][<?php echo $language['language_id'];?>][image_title]"  class="form-control"/><img src="view/image/flags/<?php echo $language['image'];?>" title="<?php echo $language['name'];?>"  /></div><br/>';
	html += '  <tex'+'tarea name="article_image[' + image_row + '][description][<?php echo $language['language_id'];?>][image_description]" class="form-control" rows="5">Description</tex'+'tarea><br/>';
    <?php }?>
	html += '    </td>';
	
	html += '    <td class="vtop text-center"><input type="radio" name="primary_image" onclick="changePrimaryImage(' + image_row + ')"/></td>';
	
	html += '    <td class="vtop text-right"><a onclick="$(\'#image-row' + image_row + '\').remove();" class="btn btn-primary btn-xs"><?php echo $button_remove;?></a></td>';
    html += '  </tr>';	
    html += '</tbody>';
	$('#images tfoot').before(html);
	
	<?php if($config->get('image_manager_plus_status')==1){ ?>
		var numrow= parseInt(cookie_image_row)+1;
		$.rcookie('article<?php echo $article_id; ?>_image_row',numrow);		
		$('#images').sortable('refresh');
	<?php }?>
			
	image_row++;
}
</script>

	<?php if($config->get('image_manager_plus_status')==1){ ?>
<script type="text/javascript">
 function insertImage(fileName) { 	 
		if ($.rcookie('article<?php echo $article_id; ?>_image_row')==null||$.rcookie('article<?php echo $article_id; ?>_image_row')=='') {
			var cookie_add_row = <?php echo $image_row; ?>;	
		}else{	
			var cookie_add_row = $.rcookie('article<?php echo $article_id; ?>_image_row');		
		}					
		var add_row = cookie_add_row;	 
		//alert(add_row);
		
	$.rcookie('article<?php echo $article_id; ?>_image_row',null);

	html  = '<tbody class="image-row" id="image-row' + add_row + '">';
    html += '  <tr>';
	html += '<td class="text-center"><input style="width:20px;" type="text" name="article_image[' + add_row + '][sort_order]" value="' + add_row + '" class="form-control sort_order" id="sort_order' + add_row + '"/></td>';
	
	html += '<td align="center">';
	html += '<a href="" id="thumbadd_image' + add_row + '" data-toggle="image" class="img-thumbnail">';
    html += '<img src="../image/' + fileName + '" alt="" title="" data-placeholder="../image/' + fileName + '" />';
    html += '</a><input type="hidden" name="article_image[' + add_row + '][image]" value=' + fileName + '"" id="input-add_image' + add_row + '"/>';
	html += '</td>';
	
	html += '    <td class="left">';
	<?php foreach($languages as $language){?>	
	html += ' <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>';
	html += '<input type="text" value="Title" name="article_image[' + add_row + '][description][<?php echo $language['language_id'];?>][image_title]"  class="form-control"/><img src="view/image/flags/<?php echo $language['image'];?>" title="<?php echo $language['name'];?>"  /></div><br/>';
	html += '  <tex'+'tarea name="article_image[' + add_row + '][description][<?php echo $language['language_id'];?>][image_description]" class="form-control" rows="5">Description</tex'+'tarea><br/>';
    <?php }?>
	html += '    </td>';
	
	html += '    <td class="text-center"><input type="radio" name="primary_image" onclick="changePrimaryImage(' + add_row + ')"/></td>';
	
	html += '    <td class="right"><a onclick="$(\'#image-row' + add_row + '\').remove();" class="btn btn-primary btn-xs"><?php echo $button_remove;?></a></td>';
    html += '  </tr>';	
    html += '</tbody>';
	$('#images tfoot').before(html);
	var numrow= parseInt(cookie_add_row)+1;
	$.rcookie('article<?php echo $article_id; ?>_image_row',numrow);	
	add_row++;    
    $('#images').sortable('refresh');
};	
</script>
	<?php }?>		
      <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#description<?php echo $language['language_id']; ?>').summernote({
	height: 300
});
<?php } ?>
	$(document).ready(function() {	
		Plus.init();
	});
//--></script> 
<?php }?>
<?php echo $footer; ?>