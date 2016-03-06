<?php global $config; echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
    <div>   
     <?php echo $shortcut_group;?>
      </div>
    </div>
    <div class="container-fluid">
      <div class="pull-right">   
          <button type="submit" form="form" class="btn btn-success btn-sm"><i class="fa fa-save"></i> <?php echo $button_save_rule; ?></button>
          <a href="<?php echo $cancel;?> " class="btn btn-primary btn-sm"><span><i class="fa fa-share-square-o"></i> <?php echo $button_cancel; ?></span></a>
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
	<div class="message"></div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="form" class="form-horizontal">
        <ul id="tab_auto_kw" class="nav nav-tabs">     
        <li class="active"><a href="#form_setting" data-toggle="tab"><?php echo $text_setting;?> </a></li>
        <li><a href="#form_page" data-toggle="tab" onclick="loadResult('page');"><?php echo $text_page;?> </a></li>
        <li><a href="#form_product" data-toggle="tab" onclick="loadResult('product');"><?php echo $text_product;?> </a></li>
        <li><a href="#form_category" data-toggle="tab" onclick="loadResult('category');"><?php echo $text_category;?> </a></li>
        <li><a href="#form_manufacturer" data-toggle="tab" onclick="loadResult('manufacturer');"><?php echo $text_manufacturer;?> </a></li>
        <li><a href="#form_information" data-toggle="tab" onclick="loadResult('information');"><?php echo $text_information;?> </a></li>
        <li><a href="#form_content" data-toggle="tab" onclick="loadResult('content');"><?php echo $text_content;?> </a></li>
        <li><a href="#form_article" data-toggle="tab" onclick="loadResult('article');"><?php echo $text_article;?> </a></li>
        <li><a href="#form_author" data-toggle="tab" onclick="loadResult('author');"><?php echo $text_author;?> </a></li>
        </ul>
        <div class="row">     
        <div class="col-sm-6">
          <div class="tab-content">
        <div id="form_setting"  class="tab-pane clearfix active">
            <div class="form-group clearfix">
            <label class="col-md-4"><?php echo $entry_handle_keyword;?></label>
            <div class="col-sm-8">
             <select name="autokw_status" class="form-control">
                <option value="1" <?php echo ($autokw_status=='1')?'selected="selected"':''; ?>><?php echo $text_enabled;?></option>
                <option value="0" <?php echo ($autokw_status=='0')?'selected="selected"':''; ?>><?php echo $text_disabled;?></option>
            </select>
            </div>
        </div><!-- form-group--> 
        
        <div class="alert alert-info clearfix">
         <?php echo $help_handle_keyword;?>
         <?php echo $seo_url_warning;?>
         </div>
        
        </div>
        
        <div id="form_page" class="tab-pane otp-page clearfix">
      <h2><?php echo $text_page;?></h2>
      <div class="table-responsive">
         <table id="page" class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="left" style="min-width:200px;"><?php echo $entry_page; ?></td>
              <td class="left" style="min-width:150px;"><?php echo $entry_url; ?></td>
              <td></td>
            </tr>
          </thead>
          <?php $page_row = 0; ?>
          <?php foreach ($autokw_pages as $page) { ?>
          <tbody id="page-row<?php echo $page_row; ?>">
            <tr>
              <td class="left""><input type="text" name="autokw_page_routes[<?php echo $page_row; ?>][page_route]" value="<?php echo $page['page_route']; ?>"  class="form-control"/>
                <?php if (isset($error_route[$page_row])) { ?><br/> 
                <span class="text-danger"><?php echo $error_route[$page_row]; ?></span>
                <?php } ?>
              
              </td>
              <td class="left"><input type="text" name="autokw_page_routes[<?php echo $page_row; ?>][page_url]" value="<?php echo $page['page_url']; ?>" class="form-control"/>              
                <?php if (isset($error_url[$page_row])) { ?><br/> 
                <span class="text-danger"><?php echo $error_url[$page_row]; ?></span>
                <?php } ?>
                </td>             
              <td class="text-right"><a onclick="$('#page-row<?php echo $page_row; ?>').remove();" class="btn btn-primary btn-xs"><i class="fa fa-minus"></i> <?php echo $button_remove_page; ?></a></td>
            </tr>
          </tbody>
          <?php $page_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="2"></td>
              <td class="text-right"><a onclick="addPage();" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> <?php echo $button_add_page; ?></a></td>
            </tr>
          </tfoot>
        </table>
        </div>
       </div>
      <div id="form_product" class="tab-pane otp-product">
      <h2><?php echo $text_product;?></h2>
       <div class="form-group">
            <label class="col-md-4"><?php echo $entry_prefix;?></label>
            <div class="col-sm-8">
            
     <select name="autokw_seo_config[product][prefix]" class="form-control">
    <option value="" <?php echo ($autokw_seo_config['product']['prefix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
    <option value="product_id" <?php echo ($autokw_seo_config['product']['prefix']=='product_id')?'selected="selected"':''; ?>><?php echo $text_product_id;?></option>
    <option value="model" <?php echo ($autokw_seo_config['product']['prefix']=='model')?'selected="selected"':''; ?>><?php echo $text_model;?></option>
    <option value="manufacturer" <?php echo ($autokw_seo_config['product']['prefix']=='manufacturer')?'selected="selected"':''; ?>><?php echo $text_manufacturer_name;?></option>
    <option value="meta_title" <?php echo ($autokw_seo_config['product']['prefix']=='meta_title')?'selected="selected"':''; ?>><?php echo $text_meta_title;?></option>
    </select>
            </div>
        </div><!-- form-group-->
       <div class="form-group">
            <label class="col-md-4"><?php echo $entry_sufix;?></label>
            <div class="col-sm-8"><select name="autokw_seo_config[product][sufix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['product']['sufix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="product_id" <?php echo ($autokw_seo_config['product']['sufix']=='product_id')?'selected="selected"':''; ?>><?php echo $text_product_id;?></option>
            <option value="model" <?php echo ($autokw_seo_config['product']['sufix']=='model')?'selected="selected"':''; ?>><?php echo $text_model;?></option>
            <option value="manufacturer" <?php echo ($autokw_seo_config['product']['sufix']=='manufacturer')?'selected="selected"':''; ?>><?php echo $text_manufacturer_name;?></option>
    <option value="meta_title" <?php echo ($autokw_seo_config['product']['sufix']=='meta_title')?'selected="selected"':''; ?>><?php echo $text_meta_title;?></option>
           </select>
            
            </div>
        </div><!-- form-group-->
        
       <div class="form-group">
            <label class="col-md-4"><?php echo $entry_separator;?></label>
            <div class="col-sm-8">
         <select name="autokw_seo_config[product][separator]" class="form-control">
            <option value="-" <?php echo ($autokw_seo_config['product']['separator']=='-')?'selected="selected"':''; ?>>-</option>
            <option value="_" <?php echo ($autokw_seo_config['product']['separator']=='_')?'selected="selected"':''; ?>>_</option>
        </select>
            
            </div>
        </div><!-- form-group-->
       <div class="form-group">
            <label class="col-md-4"><?php echo $text_page_extension;?> </label>
            <div class="col-sm-8">
            <select name="autokw_seo_config[product][extension]" class="form-control">
                    <option value="" <?php echo ($autokw_seo_config['product']['extension']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
                    <option value=".htm" <?php echo ($autokw_seo_config['product']['extension']=='.htm')?'selected="selected"':''; ?>>.htm</option>
                    <option value=".html" <?php echo ($autokw_seo_config['product']['extension']=='.html')?'selected="selected"':''; ?>>.html</option>
                    <option value=".php" <?php echo ($autokw_seo_config['product']['extension']=='.php')?'selected="selected"':''; ?>>.php</option>
                    <option value=".asp" <?php echo ($autokw_seo_config['product']['extension']=='.asp')?'selected="selected"':''; ?>>.asp</option>
                    <option value=".aspx" <?php echo ($autokw_seo_config['product']['extension']=='.aspx')?'selected="selected"':''; ?>>.aspx</option>
             </select>
            
            </div>
        </div><!-- form-group-->

        
       <div class="form-group">
            <label class="col-md-4"><?php echo $entry_keyword_based;?></label>
            <div class="col-sm-8">
            <select name="autokw_seo_config[product][language_id]" class="form-control">
        <?php foreach ($languages as $language) { ?>
        <option value="<?php echo $language['language_id'];?>"  <?php echo($autokw_seo_config['product']['language_id']==$language['language_id'])?'selected="selected"':''; ?>><?php echo $language['name'];?></option>        
          <?php } ?>
        </select>
            
            </div>
        </div><!-- form-group-->
        
           <div class="form-group">
                <label class="col-md-4"><?php echo $entry_action;?></label>
                <div class="col-sm-8">
                       <a onclick="kw_build('product')" class="btn btn-sm btn-success"><?php echo $text_generate;?> </a>
                       <a onclick="kw_clean('product')" class="btn btn-sm btn-danger"><?php echo $text_clean;?> </a>
                  
                </div>
            </div><!-- form-group-->
       </div>
       
       
       
       
       
       
       
       
       
       
       
      <div id="form_category" class="tab-pane otp-category">
      <h2><?php echo $text_category;?></h2>
       <div class="form-group">
    <label class="col-md-4"><?php echo $entry_prefix;?> </label>
    <div class="col-sm-8">
         <select name="autokw_seo_config[category][prefix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['category']['prefix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="category_id" <?php echo ($autokw_seo_config['category']['prefix']=='category_id')?'selected="selected"':''; ?>><?php echo $text_category_id;?></option>
    <option value="meta_title" <?php echo ($autokw_seo_config['category']['prefix']=='meta_title')?'selected="selected"':''; ?>><?php echo $text_meta_title;?></option>
        </select>
    
    </div>
</div><!-- form-group-->
       <div class="form-group">
    <label class="col-md-4"><?php echo $entry_sufix;?> </label>
    <div class="col-sm-8"><select name="autokw_seo_config[category][sufix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['category']['sufix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="category_id" <?php echo ($autokw_seo_config['category']['sufix']=='category_id')?'selected="selected"':''; ?>><?php echo $text_category_id;?></option>
    <option value="meta_title" <?php echo ($autokw_seo_config['category']['sufix']=='meta_title')?'selected="selected"':''; ?>><?php echo $text_meta_title;?></option>
           </select>
    
    </div>
</div><!-- form-group-->
       <div class="form-group">
    <label class="col-md-4"><?php echo $entry_separator;?></label>
    <div class="col-sm-8">
         <select name="autokw_seo_config[category][separator]" class="form-control">
            <option value="-" <?php echo ($autokw_seo_config['category']['separator']=='-')?'selected="selected"':''; ?>>-</option>
            <option value="_" <?php echo ($autokw_seo_config['category']['separator']=='_')?'selected="selected"':''; ?>>_</option>
        </select>
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_keyword_based;?> </label>
    <div class="col-sm-8">
    
    </div>
</div><!-- form-group--> 
 <div class="form-group">
    <label class="col-md-4"></label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[category][language_id]" class="form-control">
        <?php foreach ($languages as $language) { ?>
        <option value="<?php echo $language['language_id'];?>"  <?php echo($autokw_seo_config['category']['language_id']==$language['language_id'])?'selected="selected"':''; ?>><?php echo $language['name'];?></option>        
          <?php } ?>
        </select>
    </div>
</div><!-- form-group--> 
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_action;?> </label>
    <div class="col-sm-8">
       <a onclick="kw_build('category')" class="btn btn-sm btn-success"><?php echo $text_generate;?> </a>
       <a onclick="kw_clean('category')" class="btn btn-sm btn-danger"><?php echo $text_clean;?> </a>
    </div>
</div><!-- form-group-->
       </div>
       
       
       
       
       
       
       
       
       
       
       
       
      <div id="form_manufacturer" class="tab-pane otp-manufacturer">
      <h2><?php echo $text_manufacturer;?></h2>
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_prefix;?></label>
    <div class="col-sm-8">
    
         <select name="autokw_seo_config[manufacturer][prefix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['manufacturer']['prefix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="manufacturer_id" <?php echo ($autokw_seo_config['manufacturer']['prefix']=='manufacturer_id')?'selected="selected"':''; ?>><?php echo $text_manufacturer_id;?></option>
        </select>
        
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_sufix;?> </label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[manufacturer][sufix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['manufacturer']['sufix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="manufacturer_id" <?php echo ($autokw_seo_config['manufacturer']['sufix']=='manufacturer_id')?'selected="selected"':''; ?>><?php echo $text_manufacturer_id;?></option>
           </select>
        
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_separator;?></label>
    <div class="col-sm-8">
    
         <select name="autokw_seo_config[manufacturer][separator]" class="form-control">
            <option value="-" <?php echo ($autokw_seo_config['manufacturer']['separator']=='-')?'selected="selected"':''; ?>>-</option>
            <option value="_" <?php echo ($autokw_seo_config['manufacturer']['separator']=='_')?'selected="selected"':''; ?>>_</option>
        </select>
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_keyword_based;?></label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[manufacturer][language_id]" class="form-control">
        <?php foreach ($languages as $language) { ?>
        <option value="<?php echo $language['language_id'];?>"  <?php echo($autokw_seo_config['manufacturer']['language_id']==$language['language_id'])?'selected="selected"':''; ?>><?php echo $language['name'];?></option>        
          <?php } ?>
        </select>
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_action;?></label>
    <div class="col-sm-8">
    
       <a onclick="kw_build('manufacturer')" class="btn btn-sm btn-success"><?php echo $text_generate;?> </a>
       <a onclick="kw_clean('manufacturer')" class="btn btn-sm btn-danger"><?php echo $text_clean;?> </a>
 
    </div>
</div><!-- form-group-->
       </div>
       
       
       
      <div id="form_information" class="tab-pane otp-information">
      <h2><?php echo $text_information;?></h2>
     
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_prefix;?></label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[information][prefix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['information']['prefix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="information_id" <?php echo ($autokw_seo_config['information']['prefix']=='information_id')?'selected="selected"':''; ?>><?php echo $text_information_id;?></option>
    <option value="meta_title" <?php echo ($autokw_seo_config['information']['prefix']=='meta_title')?'selected="selected"':''; ?>><?php echo $text_meta_title;?></option>
        </select>
    </div>
</div><!-- form-group-->
         
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_sufix;?></label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[information][sufix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['information']['sufix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="information_id" <?php echo ($autokw_seo_config['information']['sufix']=='information_id')?'selected="selected"':''; ?>><?php echo $text_information_id;?></option>
    <option value="meta_title" <?php echo ($autokw_seo_config['information']['sufix']=='meta_title')?'selected="selected"':''; ?>><?php echo $text_meta_title;?></option>
           </select>
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_separator;?></label>
    <div class="col-sm-8">
    
         <select name="autokw_seo_config[information][separator]" class="form-control">
            <option value="-" <?php echo ($autokw_seo_config['information']['separator']=='-')?'selected="selected"':''; ?>>-</option>
            <option value="_" <?php echo ($autokw_seo_config['information']['separator']=='_')?'selected="selected"':''; ?>>_</option>
        </select>
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $text_page_extension;?> </label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[information][extension]" class="form-control">
                    <option value="" <?php echo ($autokw_seo_config['information']['extension']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
                    <option value=".htm" <?php echo ($autokw_seo_config['information']['extension']=='.htm')?'selected="selected"':''; ?>>.htm</option>
                    <option value=".html" <?php echo ($autokw_seo_config['information']['extension']=='.html')?'selected="selected"':''; ?>>.html</option>
                    <option value=".php" <?php echo ($autokw_seo_config['information']['extension']=='.php')?'selected="selected"':''; ?>>.php</option>
                    <option value=".asp" <?php echo ($autokw_seo_config['information']['extension']=='.asp')?'selected="selected"':''; ?>>.asp</option>
                    <option value=".aspx" <?php echo ($autokw_seo_config['information']['extension']=='.aspx')?'selected="selected"':''; ?>>.aspx</option>
             </select>
     
    </div>
</div><!-- form-group--> 
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_keyword_based;?></label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[information][language_id]" class="form-control">
        <?php foreach ($languages as $language) { ?>
        <option value="<?php echo $language['language_id'];?>"  <?php echo($autokw_seo_config['information']['language_id']==$language['language_id'])?'selected="selected"':''; ?>><?php echo $language['name'];?></option>        
          <?php } ?>
        </select>
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_action;?> </label>
    <div class="col-sm-8">
    
       <a onclick="kw_build('information')" class="btn btn-sm btn-success"><?php echo $text_generate;?> </a>
       <a onclick="kw_clean('information')" class="btn btn-sm btn-danger"><?php echo $text_clean;?> </a>
      
    </div>
</div><!-- form-group-->
       </div>
       
       
       
   
<!-- ARTICLE-->        
       
      <div id="form_article" class="tab-pane otp-article">
      <h2><?php echo $text_article;?></h2>
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_prefix;?></label>
    <div class="col-sm-8">
         <select name="autokw_seo_config[article][prefix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['article']['prefix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="article_id" <?php echo ($autokw_seo_config['article']['prefix']=='article_id')?'selected="selected"':''; ?>><?php echo $text_article_id;?></option>
            <option value="author" <?php echo ($autokw_seo_config['article']['prefix']=='author')?'selected="selected"':''; ?>><?php echo $text_author_name;?></option>
        </select>
    
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_sufix;?></label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[article][sufix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['article']['sufix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="article_id" <?php echo ($autokw_seo_config['article']['sufix']=='article_id')?'selected="selected"':''; ?>><?php echo $text_article_id;?></option>
            <option value="author" <?php echo ($autokw_seo_config['article']['sufix']=='author')?'selected="selected"':''; ?>><?php echo $text_author_name;?></option>
           </select>
        
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_separator;?></label>
    <div class="col-sm-8">
         <select name="autokw_seo_config[article][separator]" class="form-control">
            <option value="-" <?php echo ($autokw_seo_config['article']['separator']=='-')?'selected="selected"':''; ?>>-</option>
            <option value="_" <?php echo ($autokw_seo_config['article']['separator']=='_')?'selected="selected"':''; ?>>_</option>
        </select>
    
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $text_page_extension;?> </label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[article][extension]" class="form-control">
                    <option value="" <?php echo ($autokw_seo_config['article']['extension']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
                    <option value=".htm" <?php echo ($autokw_seo_config['article']['extension']=='.htm')?'selected="selected"':''; ?>>.htm</option>
                    <option value=".html" <?php echo ($autokw_seo_config['article']['extension']=='.html')?'selected="selected"':''; ?>>.html</option>
                    <option value=".php" <?php echo ($autokw_seo_config['article']['extension']=='.php')?'selected="selected"':''; ?>>.php</option>
                    <option value=".asp" <?php echo ($autokw_seo_config['article']['extension']=='.asp')?'selected="selected"':''; ?>>.asp</option>
                    <option value=".aspx" <?php echo ($autokw_seo_config['article']['extension']=='.aspx')?'selected="selected"':''; ?>>.aspx</option>
             </select>
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_keyword_based;?> </label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[article][language_id]" class="form-control">
        <?php foreach ($languages as $language) { ?>
        <option value="<?php echo $language['language_id'];?>"  <?php echo($autokw_seo_config['article']['language_id']==$language['language_id'])?'selected="selected"':''; ?>><?php echo $language['name'];?></option>        
          <?php } ?>
        </select>
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_action;?> </label>
    <div class="col-sm-8">
       <a onclick="kw_build('article')" class="btn btn-sm btn-success"><?php echo $text_generate;?> </a>
       <a onclick="kw_clean('article')" class="btn btn-sm btn-danger"><?php echo $text_clean;?> </a>
    
    </div>
</div><!-- form-group-->
       </div>
       
       
<!-- CONTENT-->  
      <div id="form_content" class="tab-pane otp-content">
      <h2><?php echo $text_content;?></h2>
       
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_prefix;?></label>
    <div class="col-sm-8">
    
         <select name="autokw_seo_config[content][prefix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['content']['prefix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="content_id" <?php echo ($autokw_seo_config['content']['prefix']=='content_id')?'selected="selected"':''; ?>><?php echo $text_content_id;?></option>
        </select>
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_sufix;?></label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[content][sufix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['content']['sufix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="content_id" <?php echo ($autokw_seo_config['content']['sufix']=='content_id')?'selected="selected"':''; ?>><?php echo $text_content_id;?></option>
           </select> 
    
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_separator;?></label>
    <div class="col-sm-8">
         <select name="autokw_seo_config[content][separator]" class="form-control">
            <option value="_" <?php echo ($autokw_seo_config['content']['separator']=='_')?'selected="selected"':''; ?>>_</option>
            <option value="-" <?php echo ($autokw_seo_config['content']['separator']=='-')?'selected="selected"':''; ?>>-</option>
        </select>
    
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_keyword_based;?></label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[content][language_id]" class="form-control">
        <?php foreach ($languages as $language) { ?>
        <option value="<?php echo $language['language_id'];?>"  <?php echo($autokw_seo_config['content']['language_id']==$language['language_id'])?'selected="selected"':''; ?>><?php echo $language['name'];?></option>        
          <?php } ?>
        </select>
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_action;?> </label>
    <div class="col-sm-8">
    
       <a onclick="kw_build('content')" class="btn btn-sm btn-success"><?php echo $text_generate;?> </a>
       <a onclick="kw_clean('content')" class="btn btn-sm btn-danger"><?php echo $text_clean;?> </a>
    </div>
</div><!-- form-group-->
       </div>
       
<!-- AUTHOR-->      
      <div id="form_author" class="tab-pane otp-author">
      <h2><?php echo $text_author;?></h2>
      
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_prefix;?></label>
    <div class="col-sm-8">
         <select name="autokw_seo_config[author][prefix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['author']['prefix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="author_id" <?php echo ($autokw_seo_config['author']['prefix']=='author_id')?'selected="selected"':''; ?>><?php echo $text_author_id;?></option>
        </select>
    
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_sufix;?></label>
    <div class="col-sm-8">
    <select name="autokw_seo_config[author][sufix]" class="form-control">
            <option value="" <?php echo ($autokw_seo_config['author']['sufix']=='')?'selected="selected"':''; ?>><?php echo $text_none;?></option>
            <option value="author_id" <?php echo ($autokw_seo_config['author']['sufix']=='author_id')?'selected="selected"':''; ?>><?php echo $text_author_id;?></option>
           </select>
        
    
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_separator;?></label>
    <div class="col-sm-8">
         <select name="autokw_seo_config[author][separator]" class="form-control">
            <option value="-" <?php echo ($autokw_seo_config['author']['separator']=='-')?'selected="selected"':''; ?>>-</option>
            <option value="_" <?php echo ($autokw_seo_config['author']['separator']=='_')?'selected="selected"':''; ?>>_</option>
        </select>
    
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_keyword_based;?></label>
    <div class="col-sm-8"><select name="autokw_seo_config[author][language_id]" class="form-control">
        <?php foreach ($languages as $language) { ?>
        <option value="<?php echo $language['language_id'];?>"  <?php echo($autokw_seo_config['author']['language_id']==$language['language_id'])?'selected="selected"':''; ?>><?php echo $language['name'];?></option>        
          <?php } ?>
        </select>
    
    </div>
</div><!-- form-group-->
 <div class="form-group">
    <label class="col-md-4"><?php echo $entry_action;?></label>
    <div class="col-sm-8">
    
       <a onclick="kw_build('author')" class="btn btn-sm btn-success"><?php echo $text_generate;?> </a>
       <a onclick="kw_clean('author')" class="btn btn-sm btn-danger"><?php echo $text_clean;?> </a>
    </div>
</div><!-- form-group-->
       </div> 
       </div><!--//tab-content --> 
        </div>
        
        <div class="col-sm-6">
        <textarea id="seo_result" wrap="off" class="form-control" style="width: 98%; height: 400px;padding: 5px; border: 1px solid #CCCCCC; background: #FFFFFF; overflow-y: scroll; overflow-x: hidden;" readonly="readonly"></textarea>
        </div>
</div>
    </form>
      </div><!--panel-body --> 
    </div><!--panel --> 
  </div><!--container-fluid --> 
</div><!--#content -->
<script type="text/javascript"><!--
function kw_build(query){
	$('.query_group').remove();
	$('#form_'+query).append('<input type="hidden" class="query_group" name="query" value="'+query+'"/>');
			$.ajax({
				url: 'index.php?route=ave/seo_keyword/build&token=<?php echo $token;?>',
				type: 'post',
				dataType: 'json',
				data: $('#form_'+query+' input[type=\'text\'], #form_'+query+' input[type=\'hidden\'], #form_'+query+' input[type=\'radio\']:checked, #form_'+query+' input[type=\'checkbox\']:checked, #form_'+query+' select'),
				beforeSend: function() {
				},
				complete: function() {					
				},
				success: function(json) {					
					if (json['error']) {
							$('.message').html('<div class="alert alert-danger">' + json['error'] + '<button type="button" class="close" data-dismiss="alert">×</button></div>');
					} 
					if (json['success']) {
						$('#seo_result').html(json['log']);
						
						$('.message').html('<div class="alert alert-success" style="display: none;">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">×</button></div>');
						$('.success').fadeIn('slow');
					}	
				}
			});
}
function loadResult(query){
			$('#seo_result').html('');
			if(query!=='page'){
				$.ajax({
					url: 'index.php?route=ave/seo_keyword/result&token=<?php echo $token;?>&query='+query,
					dataType: 'json',
					beforeSend: function() {
					},
					complete: function() {					
					},
					success: function(json) {					
						if (json['error']) {
								$('.message').html('<div class="alert alert-danger">' + json['error'] + '<button type="button" class="close" data-dismiss="alert">×</button></div>');
						} 
						if (json['success']) {
							$('#seo_result').html(json['log']);
						}	
					}
				});
			}
}

function kw_clean(query){
			$.ajax({
				url: 'index.php?route=ave/seo_keyword/clean&token=<?php echo $token;?>&query='+query,
				type: 'get',
				dataType: 'json',
				beforeSend: function() {
				},
				complete: function() {					
				},
				success: function(json) {					
					if (json['error']) {
							$('.message').html('<div class="alert alert-danger">' + json['error'] + '<button type="button" class="close" data-dismiss="alert">×</button></div>');
					} 
					if (json['success']) {
						$('#seo_result').html(json['log']);
						$('.message').html('<div class="alert alert-success" style="display: none;">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">×</button></div>');
						$('.alert').fadeIn('slow');
					}	
				}
			});
}
//--></script> 
<script type="text/javascript"><!--
var page_row = <?php echo $page_row; ?>;

function addPage() {	
	html  = '<tbody id="page-row' + page_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><input type="text" name="autokw_page_routes[' + page_row + '][page_route]" value="account/register" class="form-control"/></td>';
	html += '    <td class="left"><input type="text" name="autokw_page_routes[' + page_row + '][page_url]" value="register" class="form-control"/></td>';
	html += '    <td class="text-right"><a onclick="$(\'#page-row' + page_row + '\').remove();" class="btn btn-primary btn-xs"><i class="fa fa-minus"></i> <?php echo $button_remove_page; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#page tfoot').before(html);
	
	page_row++;
}
$(document).ready(function() { 
		$('#tab_auto_kw a').click( function(){
			localStorage.setItem("tab_auto_kw", $(this).attr("href") );
		} );
		if( localStorage.getItem("tab_auto_kw") !="undefined" ){
			$('#tab_auto_kw a').each( function(){ 
				if( $(this).attr("href") ==  localStorage.getItem("tab_auto_kw") ){
					$(this).click();
					return ;
				}
			} );
		}
});	
//--></script> 
<?php echo $footer; ?>