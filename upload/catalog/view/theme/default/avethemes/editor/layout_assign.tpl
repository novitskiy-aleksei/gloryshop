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
                    <li> <a onclick="MCP.switchView('editor-size-sm');" data-group="general_group" data-action="general_position" class="modal-form" data-title="<?php echo $text_positions_setting;?>"><?php echo $text_mobile_position;?></a></li>
                    <li> <a onclick="MCP.switchView('editor-size-lg');" data-group="general_group" data-action="layout_settings" class="modal-form" data-title="<?php echo $text_layout_setting;?>"><?php echo $text_layout_setting;?></a></li>
                    <li> <a onclick="MCP.switchView('editor-size-lg');" data-group="general_group" data-action="layout_preview" class="modal-form" data-title="<?php echo $text_layout_setting;?>" data-toggle="tooltip" title="<?php echo $text_preview_layout_setting; ?>"><i class="fa fa-gear"></i></a></li>
        </ul>
        
<div class="container-fluid clearfix">

<div class="layout_modules">
			<div class="form-group">
                    <label class="col-sm-3 control-label"> <?php echo $entry_layout;?></label>
                    <div class="col-sm-9">
                     <div class="input-group">
<select name="change_layouts" id="change_layouts" class="form-control" onchange="MCP.getPreviewUrl(this.options[this.selectedIndex].value);">
              <?php foreach($layouts as $layout){?>
              <option value="<?php echo $layout['layout_id'];?>" <?php echo ($layout['layout_id']==$session_layout_id)?'selected="selected"':'';?>><?php echo $layout['name'];?> </option>
              <?php } ?> 
              </select>
              <a class="input-group-addon" onclick="MCP.navSelect('prev','#change_layouts')"><i class="fa fa-chevron-left"></i></a>
              <a class="input-group-addon" onclick="MCP.navSelect('next','#change_layouts')"><i class="fa fa-chevron-right"></i></a>
                     </div>
                     </div>
                     
                     
              </div><!-- form-group--> 
              <!-- //getPreviewUrl() and append here--> 
              <div id="layout_modules">
<!-- LAYOUT MODULE START--> 
       <input type="hidden" name="layout_id" value="<?php echo $session_layout_id;?>"/>    
  <div class="layout-builder" id="layout-builder">
          	<div class="drop_area">
 <div class="row colsliders">
    <div class="col-md-12 position">
        <div class="ps_header">
        		<span><?php echo $text_pre_header;?></span><div class="btn-group hidden-lg hidden-md show-md">
                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=pre_header" data-position="pre_header" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a> 
                </div>
        </div>
        <div class="dashed" data-position="pre_header">
       <i><?php echo $text_drop_module;?></i>
            <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'pre_header') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label">  <?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
            <div class="ps_header"><span><?php echo $text_after_header;?></span><div class="btn-group hidden-lg hidden-md show-md">

                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=after_header" data-position="after_header" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
            </div>
            <div class="dashed" data-position="after_header">
       <i><?php echo $text_drop_module;?></i>
            <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'after_header') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
     <div class="module_label">  <?php echo $layout_module['title']; ?></div>
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
    <div class="position col-md-6 size-sm-12">
        <div class="ps_header"><span><?php echo $text_top_left;?></span><div class="btn-group hidden-lg hidden-md show-md">

                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=top_left" data-position="top_left" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        
        </div>
        <div class="dashed" data-position="top_left">
       <i><?php echo $text_drop_module;?></i>
            <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'top_left') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label">  <?php echo $layout_module['title']; ?></div>
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
    <div class="position col-md-6 size-sm-12">
        <div class="ps_header"><span><?php echo $text_top_right;?></span><div class="btn-group hidden-lg hidden-md show-md">

                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=top_right" data-position="top_right" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        </div>
        <div class="dashed" data-position="top_right">
       <i><?php echo $text_drop_module;?></i>
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'top_right') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label">  <?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
        <div class="ps_header"><span><?php echo $text_extra_top;?></span><div class="btn-group hidden-lg hidden-md show-md">

                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=extra_top" data-position="extra_top" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        </div>
        <div class="dashed" data-position="extra_top">
       <i><?php echo $text_drop_module;?></i>
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'extra_top') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label">  <?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
    <div class="position col-md-3 size-sm-12">
        <div class="ps_header"><span><?php echo $text_column_left;?></span><div class="btn-group hidden-lg hidden-md show-md">

                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=column_left" data-position="column_left" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>        
        </div><div class="dashed" data-position="column_left">
       <i><?php echo $text_drop_module;?></i>
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'column_left') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label">  <?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
    <div class="col-md-6 size-sm-12">
        <div class="row">
        <div class="col-md-12 position">
            <div class="ps_header"><span><?php echo $text_content_top;?></span><div class="btn-group hidden-lg hidden-md show-md">

                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=content_top" data-position="content_top" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
            </div>
            <div class="dashed" data-position="content_top">
       <i><?php echo $text_drop_module;?></i>
            	 <?php $module_row = 0; ?>
                  <?php foreach ($layout_modules as $layout_module) { ?>
                    <?php if ($layout_module['position'] == 'content_top') { ?>
                          <div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label">  <?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
        <div class="ps_header"><span><?php echo $text_content_bottom;?></span><div class="btn-group hidden-lg hidden-md show-md">

                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=content_bottom" data-position="content_bottom" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        </div>
        <div class="dashed" data-position="content_bottom">
       <i><?php echo $text_drop_module;?></i>
        
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'content_bottom') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label">  <?php echo $layout_module['title']; ?></div>              
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
    <div class="position col-md-3 size-sm-12"><div class="ps_header"><span><?php echo $text_column_right;?></span><div class="btn-group hidden-lg hidden-md show-md">

                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=column_right" data-position="column_right" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
    
    </div>
    <div class="dashed" data-position="column_right">
       <i><?php echo $text_drop_module;?></i>
        
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'column_right') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label">  <?php echo $layout_module['title']; ?></div>         
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
    	<div class="ps_header"><span><?php echo $text_extra_bottom;?></span><div class="btn-group hidden-lg hidden-md show-md">

                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=extra_bottom" data-position="extra_bottom" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        
        </div>
    	<div class="dashed" data-position="extra_bottom">   
       <i><?php echo $text_drop_module;?></i>     
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'extra_bottom') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                      <div class="module_label">  <?php echo $layout_module['title']; ?></div>                  
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
    <div class="position col-md-6 size-sm-12">
        <div class="ps_header"><span><?php echo $text_bottom_left;?></span><div class="btn-group hidden-lg hidden-md show-md">

                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=bottom_left" data-position="bottom_left" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        
        </div>
        <div class="dashed" data-position="bottom_left">
       <i><?php echo $text_drop_module;?></i>
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'bottom_left') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                  <div class="module_label">  <?php echo $layout_module['title']; ?></div>
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
    <div class="position col-md-6 size-sm-12">
        <div class="ps_header"><span><?php echo $text_bottom_right;?></span><div class="btn-group hidden-lg hidden-md show-md">

                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=bottom_right" data-position="bottom_right" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        
        </div>
        <div class="dashed" data-position="bottom_right">
       <i><?php echo $text_drop_module;?></i>
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'bottom_right') { ?>
<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                  <div class="module_label">  <?php echo $layout_module['title']; ?></div>                
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
        <div class="ps_header"><span><?php echo $text_pre_footer;?></span><div class="btn-group hidden-lg hidden-md show-md">

                	<a class="btn btn-xs btn-success btn-add" data-href="<?php echo $add_module;?>&position=pre_footer" data-position="pre_footer" data-type="iframe" data-title="<?php echo $text_modules; ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                </div>
        
        
        </div>
        <div class="dashed" data-position="pre_footer">
       <i><?php echo $text_drop_module;?></i>
         <?php $module_row = 0; ?>
              <?php foreach ($layout_modules as $layout_module) { ?>
  				<?php if ($layout_module['position'] == 'pre_footer') { ?>
                      <div class="mblock" data-code="<?php echo $layout_module['code'];?>">
                  <div class="module_label">  <?php echo $layout_module['title']; ?></div>
<div class="btn-group">
<a class="btn btn-xs btn-edit" data-href="<?php echo $layout_module['href']; ?>" data-toggle="tooltip" title="<?php echo $text_edit_module; ?>"><i class="fa fa-edit"></i> <?php echo $layout_module['name']; ?></a>
<a class="btn btn-xs btn-remove" data-toggle="tooltip" title="<?php echo $button_remove;?>"><i class="fa fa-trash-o"></i></a>
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
          </div><!--//row -->        

<div id="data_index" data-index="<?php echo count($layout_modules);?>"></div>
       
<!-- LAYOUT MODULE END--> 
              </div>
              </div>
 <div class="block_relative">
 <div class="module_list">
          <div id="module_list" data-text-edit="<?php echo $text_edit_module;?>">          
          <div class="heading-bar">
          <?php echo $text_module_list;?>
          
          <div class="btn-group pull-right">
<a class="btn btn-xs" href="<?php echo $module_list; ?>" data-toggle="tooltip" title="<?php echo $text_all_module; ?>" target="_blank"><i class="fa fa-external-link"></i></a>
<a class="btn btn-xs" onclick="MCP.refresh_module_list();" data-toggle="tooltip" title="<?php echo $text_refresh; ?>" target="_blank"><i class="fa fa-refresh"></i></a>
		</div>
          </div>
          <div class="module_accordion ds_accordion">
              <?php foreach ($extensions as $extension) { ?>
          		<div class="ds_heading"> <?php echo strip_tags($extension['name']); ?>
                <div class="btn-group">
                <?php if($extension['add']){?>
                <a class="btn btn-xs btn-edit" data-href="<?php echo $extension['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($extension['name']); ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                <?php }else{?>
                <a class="btn btn-xs btn-edit" data-href="<?php echo $extension['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($extension['name']); ?>" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"><i class="fa fa-edit"></i></a>
                <?php } ?>
                
                
                </div>
                </div>
                <div class="ds_content drag_area">
                
                
                <?php if($extension['quick_add']){?> 
                <div class="module-block quick_add" data-href="<?php echo $extension['quick_href']; ?>" data-code="0" data-title="<?php echo strip_tags($extension['name']); ?>">
                 <a data-toggle="tooltip" title="<?php echo $help_add_default;?>"><i class="fa fa-arrows"></i> <?php echo $text_add_default;?></a>
           		</div>       
                <?php } ?>  
                
                
                
                <?php foreach ($extension['module'] as $module) { ?>
                <div class="module-block" data-code="<?php echo $module['code']; ?>" data-title="<?php echo strip_tags($extension['name']); ?>" <?php echo ($module['thumb'])?'data-thumb="'.$module['thumb'].'"':''; ?>>
                 <?php echo strip_tags($module['name']); ?>
           <?php if($extension['add']){?>
           <a class="btn btn-sm" onclick="MCP.deleteModule(<?php echo $module['module_id']; ?>);"><i class="fa fa-trash-o" data-toggle="tooltip" title="<?php echo $text_delete_module;?>"></i></a>
           <?php } ?>   
           <a class="btn btn-sm btn-edit" data-href="<?php echo $module['edit']; ?>"><i class="fa fa-edit" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"></i></a>   
           		</div>                 
                    <?php } ?>    
                </div><!--ds_content --> 
              <?php } ?>                
          </div><!--//ds_accordion --> 
          
          </div><!--//module_list --> 
          </div><!--//module_list --> 
          </div><!--//block_relative --> 
</div>


<!-- /*LAYOUT SETTING*/ --> 