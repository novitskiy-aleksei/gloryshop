<?php global $config;
echo $header
?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
    <div>   
     <?php echo $shortcut_group;?>
      </div>
    </div>
    <div class="container-fluid">
  <div class="col-md-6"> 
      <h1><?php echo $heading_title; ?></h1>
     
         <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
      </div>
        
    </div>
  </div>
  <div class="container-fluid">
   <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i style="float:left;" class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="message"></div>
    
        <?php if($rstatus){?>
        
         <form action="<?php echo $import_layout; ?>" method="post" enctype="multipart/form-data" id="import">
      
      		<input type="hidden" name="layout_id" value="<?php echo $layout_id;?>"/>
      		<input type="hidden" name="redirect" value="<?php echo $redirect;?>"/>
                          <div class="table-responsive">
        <table class="table table-bordered table-hover">
                 <tbody>
                    <tr>
                    <td><input type="file" name="import" /></td>  
                    <td>
   <?php if(!empty($export_layout)){?>
    <a href="<?php echo $export_layout;?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Export this layout modules data"><span><i class="fa fa-download"></i></span></a>
    <?php } ?>
    <a onclick="$('#import').submit();" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> <span>Import overwrite layout modules</span></a>
                    </td>   
                    </tr>
                    </tbody>
                    </table>
</div>
      </form>
      
        <?php } ?>
       
     
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><span class="hidden-xs"><i class="fa fa-pencil"></i><?php echo $text_form; ?></span></h3>
                    <div class="col-sm-6 col-xs-10 pull-right text-right">
                    </div>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-buildlayout" class="form-horizontal">
       

 
        	<input type="hidden" name="layout_id" value="<?php echo $layout_id;?>" />
            <div class="row">
          <div class="form-group required col-sm-7">
            <label class="col-sm-3 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-9">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>  
            </div>
          </div>
            	<div class="form-group col-sm-5">
            <label class="col-sm-4 control-label" for="input-name"><?php echo $entry_layout; ?></label>
            <div class="col-sm-8">
            	<div class="input-group">
                <?php if($delete){?>
              <a class="input-group-addon input-sm" onclick="confirm('<?php echo $text_confirm; ?>') ? location.href='<?php echo $delete; ?>' : false;" data-toggle="tooltip" title="<?php echo $button_delete; ?>"><i class="fa fa-trash"></i></a>
              <?php } ?> 
              <select type="text" name="change_layouts" id="change_layouts" class="form-control" onchange="window.location.href=this.options [this.selectedIndex].value">
               <option value="<?php echo $add;?>"> - <?php echo $button_add;?> - </option>
              <?php foreach($layouts as $layout){?>
              <option value="<?php echo $layout['edit'];?>" <?php if($layout['layout_id']==$layout_id){?>selected="selected"<?php } ?>><?php echo $layout['name'];?> </option>
              <?php } ?> 
              </select>
              <a class="input-group-addon input-sm" onclick="Plus.navSelect('prev','#change_layouts')"><i class="fa fa-chevron-left"></i></a>
              <a class="input-group-addon input-sm" onclick="Plus.navSelect('next','#change_layouts')"><i class="fa fa-chevron-right"></i></a>
              <a class="input-group-addon input-sm" href="<?php echo $add;?>" data-toggle="tooltip" title="<?php echo $button_add; ?>"><i class="fa fa-plus"></i></a>
            </div><!--//input-group --> 
            </div>
          </div>
                      <div class="mpadding">
          <table id="route" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left"><?php echo $entry_store; ?></td>
                <td class="text-left"><?php echo $entry_route; ?></td>
                <td></td>
              </tr>
            </thead>
            <tbody>
              <?php $route_row = 0; ?>
              <?php foreach ($layout_routes as $layout_route) { ?>
              <tr id="route-row<?php echo $route_row; ?>">
                <td class="text-left"><select name="layout_route[<?php echo $route_row; ?>][store_id]" class="form-control">
                    <option value="0"><?php echo $text_default; ?></option>
                    <?php foreach ($stores as $store) { ?>
                    <?php if ($store['store_id'] == $layout_route['store_id']) { ?>
                    <option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
                <td class="text-left"><input type="text" name="layout_route[<?php echo $route_row; ?>][route]" value="<?php echo $layout_route['route']; ?>" placeholder="<?php echo $entry_route; ?>" class="form-control" /></td>
                <td class="text-left"><button type="button" onclick="$('#route-row<?php echo $route_row; ?>').remove();" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
              </tr>
              <?php $route_row++; ?>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2"></td>
                <td class="text-left"><button type="button" onclick="addRoute();" data-toggle="tooltip" title="<?php echo $button_route_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
              </tr>
            </tfoot>
          </table>
          </div><!--//mpadding--> 
          
          </div>
          
                  
          <div class="row layout-builder" id="layout-builder">
          <div class="col-md-3 col-sm-5 col-xs-0">
          <div class="block_relative">
          <div class="module_list">
          <div id="module_list" data-text-confirm="<?php echo $text_confirm;?>" data-text-edit="<?php echo $text_edit_module;?>">          
          <div class="heading-bar">
          <?php echo $text_module_list;?>
          <div class="btn-group pull-right">
<a class="btn btn-xs" href="<?php echo $module_list; ?>" data-toggle="tooltip" title="<?php echo $text_all_module; ?>" target="_blank"><i class="fa fa-external-link"></i></a>
<a class="btn btn-xs" onclick="Layout.refresh_module_list();" data-toggle="tooltip" title="<?php echo $text_refresh_module; ?>"><i class="fa fa-refresh"></i></a>
		</div>
          
          </div>
          <div class="module_accordion ds_accordion">
              <?php foreach ($extensions as $extension) { ?>
          		<div class="ds_heading"> <?php echo strip_tags($extension['name']); ?>
                <div class="btn-group">
                 <?php if($extension['has_data']){?>
                <a class="btn btn-xs" href="<?php echo $extension['export']; ?>" data-toggle="tooltip" title="<?php echo $text_export_data;?>"><i class="fa fa-download"></i></a>
                  <?php } ?>
                <?php if($extension['add']){?>
                <a class="btn btn-xs btn-edit" href="<?php echo $extension['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($extension['name']); ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                <?php }else{?>
                <a class="btn btn-xs btn-edit" href="<?php echo $extension['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($extension['name']); ?>" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"><i class="fa fa-edit"></i></a>
                <?php } ?>
                
                
                </div>
                </div>
                <div class="ds_content drag_area">
               
                <?php if($extension['quick_add']){?> 
                <div class="module-block quick_add" data-href="<?php echo $extension['quick_href']; ?>" data-code="0" data-title="<?php echo strip_tags($extension['name']); ?>">
                 <a data-toggle="tooltip" title="<?php echo $help_add_default;?>"><i class="fa fa-arrows"></i> <?php echo $text_add_default;?></a>
           		</div>       
                <?php } ?>    
                
                <?php foreach ($extension['module'] as $module){ ?>       
                <div class="module-block" data-code="<?php echo $module['code']; ?>" <?php echo ($module['thumb'])?'data-thumb="'.$module['thumb'].'"':''; ?> data-title="<?php echo strip_tags($extension['name']); ?>">
               <?php echo strip_tags($module['name']); ?>    
           <a class="btn btn-sm btn-edit" href="<?php echo $module['edit']; ?>"><i class="fa fa-edit" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"></i></a>   
           		</div>                 
                    <?php } ?>    
                </div><!--ds_content --> 
              <?php } ?>                
          </div><!--//ds_accordion --> 
          </div><!--//#module_list --> 
          </div><!--//.module_list --> 
          </div><!--//block_relative --> 
          </div><!--//col-md-3 --> 
          
          <div class="col-md-9  col-sm-7  margin-bottom-15">
          <div class="heading-bar">
                 <div class="pull-right">
                 
                    <a onclick="Layout.apply()" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-success btn-sm"><i class="fa fa-save"></i></a>
                <?php if(isset($skin_layout_builder_preview_urls[$layout_id])){?>
                    <a href="<?php echo HTTP_CATALOG.$skin_layout_builder_preview_urls[$layout_id]['preview_url'];?>" data-toggle="tooltip" title="<?php echo $text_preview; ?>" class="btn btn-info btn-sm btn-edit"><i class="fa fa-search"></i></a>
              	<?php } ?>
                    
                 <a href="<?php echo $module_list; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></a>
                
				</div>
          
          </div><!--//heading-bar --> 
          
          	<div class="drop_area">
 <div class="row colsliders">
    <div class="col-md-12 position">
        <div class="ps_header">
        		<span><?php echo $text_pre_header;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=pre_header" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a> 
                </div>
        </div>
        <div class="dashed" data-position="pre_header">
       <i><?php echo $text_drop_module;?></i>
            <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'pre_header') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label"><?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                          <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="pre_header">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                      </div>
   				<?php } ?>
              <?php $module_row++; ?>
    		<?php } ?>
        </div>
    </div>
    </div><!--//row --> 
    <div class="row colsliders"><div class="col-md-12 position"><div class="ps_header fill_bg"><span><?php echo $text_header;?></span></div></div></div>
    <div class="row colsliders">
        <div class="col-md-12 position">
            <div class="ps_header"><span><?php echo $text_after_header;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=after_header" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
            </div>
            <div class="dashed" data-position="after_header">
       <i><?php echo $text_drop_module;?></i>
            <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'after_header') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label"><?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                          <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">  
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="after_header">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                      </div>
   				<?php } ?>
              <?php $module_row++; ?>
    		<?php } ?>
            </div>
        </div>
    </div><!--//row --> 
    
    
        
    <div class="row colsliders">
    <div class="col-md-6 position">
        <div class="ps_header"><span><?php echo $text_top_left;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=top_left" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        
        </div>
        <div class="dashed" data-position="top_left">
       <i><?php echo $text_drop_module;?></i>
            <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'top_left') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label"><?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                          <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">  
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="top_left">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                      </div>
   				<?php } ?>
              <?php $module_row++; ?>
    		<?php } ?>
        </div>
    </div>
    <div class="col-md-6 position">
        <div class="ps_header"><span><?php echo $text_top_right;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=top_right" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        </div>
        <div class="dashed" data-position="top_right">
       <i><?php echo $text_drop_module;?></i>
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'top_right') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label"><?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                          <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">  
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="top_right">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                      </div>
   				<?php } ?>
              <?php $module_row++; ?>
    		<?php } ?>
        </div>
    </div>
    </div><!--//row --> 
        
   
    
    <div class="row colsliders">
    <div class="col-md-12 position">
        <div class="ps_header"><span><?php echo $text_extra_top;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=extra_top" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        </div>
        <div class="dashed" data-position="extra_top">
       <i><?php echo $text_drop_module;?></i>
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'extra_top') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label"><?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                          <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">  
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="extra_top">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                      </div>
   				<?php } ?>
              <?php $module_row++; ?>
    		<?php } ?>
        </div>
    </div>
    </div><!--//row --> 
    
    <div class="row colsliders">
    <div class="col-md-3 position">
        <div class="ps_header"><span><?php echo $text_column_left;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=column_left" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>        
        </div><div class="dashed" data-position="column_left">
       <i><?php echo $text_drop_module;?></i>
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'column_left') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label"><?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">  
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="column_left">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                      </div>
   				<?php } ?>
              <?php $module_row++; ?>
    		<?php } ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
        <div class="col-md-12 position">
            <div class="ps_header"><span><?php echo $text_content_top;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=content_top" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
            </div>
            <div class="dashed" data-position="content_top">
       <i><?php echo $text_drop_module;?></i>
            	 <?php $module_row = 0; ?>
                  <?php foreach ($layout_modules as $layout_module) { ?>
                    <?php if ($layout_module['position'] == 'content_top') { ?>
                          <div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label"><?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                          <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">   
                          <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="content_top">
                          <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                          </div>
                    <?php } ?>
                  <?php $module_row++; ?>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-12 position">
        <div class="ps_header"><span><?php echo $text_content_bottom;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=content_bottom" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        </div>
        <div class="dashed" data-position="content_bottom">
       <i><?php echo $text_drop_module;?></i>
        
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'content_bottom') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label"><?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">  
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="content_bottom">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                      </div>
   				<?php } ?>
              <?php $module_row++; ?>
    		<?php } ?>
        
        </div></div>
        </div><!--//row --> 
    </div>
    <div class="col-md-3 position"><div class="ps_header"><span><?php echo $text_column_right;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=column_right" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
    
    </div>
    <div class="dashed" data-position="column_right">
       <i><?php echo $text_drop_module;?></i>
        
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'column_right') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label"><?php echo $layout_module['title']; ?></div>         
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">   
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="column_right">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                      </div>
   				<?php } ?>
              <?php $module_row++; ?>
    		<?php } ?>
    
    </div></div>
    </div><!--//row --> 
    
     
    
    <div class="row colsliders">
    <div class="col-md-12 position">
    	<div class="ps_header"><span><?php echo $text_extra_bottom;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=extra_bottom" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        
        </div>
    	<div class="dashed" data-position="extra_bottom">   
       <i><?php echo $text_drop_module;?></i>     
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'extra_bottom') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label"><?php echo $layout_module['title']; ?></div>                  
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                              <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">  
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="extra_bottom">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                      </div>
   				<?php } ?>
              <?php $module_row++; ?>
    		<?php } ?>
        </div>
    </div>
    </div>
    <!--//row --> 
    <div class="row colsliders">
    <div class="col-md-6 position">
        <div class="ps_header"><span><?php echo $text_bottom_left;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=bottom_left" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        
        </div>
        <div class="dashed" data-position="bottom_left">
       <i><?php echo $text_drop_module;?></i>
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'bottom_left') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                  <div class="module_label"><?php echo $layout_module['title']; ?></div>
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                     <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">   
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="bottom_left">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                      </div>
   				<?php } ?>
              <?php $module_row++; ?>
    		<?php } ?>
        </div>
    </div>
    <div class="col-md-6 position">
        <div class="ps_header"><span><?php echo $text_bottom_right;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=bottom_right" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        
        </div>
        <div class="dashed" data-position="bottom_right">
       <i><?php echo $text_drop_module;?></i>
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'bottom_right') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                  <div class="module_label"><?php echo $layout_module['title']; ?></div>                
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">    
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="bottom_right">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                      </div>
   				<?php } ?>
              <?php $module_row++; ?>
    		<?php } ?>
        </div>
    </div>
    </div>
    <!--//row --> 
    
    <div class="row colsliders">
    <div class="col-md-12 position">
        <div class="ps_header"><span><?php echo $text_pre_footer;?></span><div class="btn-group hidden-lg hidden-md">

                	<a class="btn btn-xs btn-success btn-edit" href="<?php echo $add_module;?>&position=pre_footer" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        
        
        </div>
        <div class="dashed" data-position="pre_footer">
       <i><?php echo $text_drop_module;?></i>
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'pre_footer') { ?>
                      <div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                  <div class="module_label"><?php echo $layout_module['title']; ?></div>
<div class="btn-group">
<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>
</div>
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">    
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="pre_footer">
                      <input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
                      </div>
   				<?php } ?>
              <?php $module_row++; ?>
    		<?php } ?>
        </div>
    </div>
    </div>
    <div class="row colsliders"><div class="col-md-12 position"><div class="ps_header fill_bg"><span><?php echo $text_footer;?></span></div></div></div>
    
          </div><!--//drop_area --> 
          </div><!--//col --> 
          
          </div><!--//row --> 
       
    <div class="clearfix" style="z-index:1003">
            <div class="heading-bar">
                    <div class="pull-right">                    
                    <a onclick="Layout.apply()" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-success btn-sm"><i class="fa fa-save"></i></a>
                    <a href="<?php echo $module_list; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></a>
                    </div>
            </div>
    </div>   
          <div id="data_index" data-index="<?php echo count($layout_modules);?>"></div>
        </form>
      </div>
    </div>
  </div>
</div><!--//content --> 
<div id="module-modal" class="modal-box modal fade <?php echo $skin_layout_builder_show_option;?>">
        <div class="modal-dialog modal-fw">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            	<h4 class="modal-title">&nbsp;  </h4>
            </div>
            <div class="modal-body modal-iframe">
                <iframe id="modal-iframe" class="modal-iframe loading" frameborder="0" allowtransparency="true" seamless></iframe>
            </div>
        </div>
      </div>
</div><!--//module-modal --> 
  <script type="text/javascript"><!--
var route_row = <?php echo $route_row; ?>;
function addRoute() {
	html  = '<tr id="route-row' + route_row + '">';
	html += '  <td class="text-left"><select name="layout_route[' + route_row + '][store_id]" class="form-control">';
	html += '  <option value="0"><?php echo $text_default; ?></option>';
	<?php foreach ($stores as $store) { ?>
	html += '<option value="<?php echo $store['store_id']; ?>"><?php echo addslashes($store['name']); ?></option>';
	<?php } ?>   
	html += '  </select></td>';
	html += '  <td class="text-left"><input type="text" name="layout_route[' + route_row + '][route]" value="" placeholder="<?php echo $entry_route; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#route-row' + route_row + '\').remove();" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';
	
	$('#route tbody').append(html);
	$('.tooltip').remove();
	
	route_row++;
}
//--></script>
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
		Layout.init();
		$.lockfixed("#module_list",{offset: {top: 10,right: 20, bottom: 250}});
	});
	if(typeof(console)=='undefined' || console==null) { console={}; console.log=function(){}}
</script>
<?php echo $footer; ?>