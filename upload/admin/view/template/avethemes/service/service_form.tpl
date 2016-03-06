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
      	<input type="hidden" name="service_id" value="<?php echo $service_id;?>" />
        <div class="row">
          <!--Data Form  --> 
          <div class="col-sm-6">
           <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_parent; ?></label>
                <div class="col-sm-8">  <select name="parent_id" id="parent_id" class="form-control tr_change" onchange="Plus.activeObj('parent_id',this.options[this.selectedIndex].value);">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($services as $service) { ?>
                  <?php if ($service['service_id'] == $parent_id) { ?>
                  <option value="<?php echo $service['service_id']; ?>" selected="selected"><?php echo $service['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $service['service_id']; ?>"><?php echo $service['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                 
              </div>
              </div><!-- form-group-->
              
           <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_name; ?></label>
                <div class="col-sm-8">
                 
            <?php foreach ($languages as $language) { ?>
            <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span>
                <input class="form-control" id="title" type="text" name="service_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($service_description[$language['language_id']]) ? $service_description[$language['language_id']]['name'] : ''; ?>" />
                  <?php if (isset($error_name[$language['language_id']])) { ?><br/> 
                  <span class="text-danger"><?php echo $error_name[$language['language_id']]; ?></span>
                  <?php } ?>
                  </div>
            <?php } ?>
              </div>
              </div><!-- form-group-->
              
              
           <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_store; ?></label>
                <div class="col-sm-8"> 
                 
              </div>
              </div><!-- form-group-->
              
              
           <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_link; ?></label>
                <div class="col-sm-8"> 
              <select name="link_id" class="form-control">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($categories as $category) { ?>
                      <?php if ($category['type']=='category'&&($category['item_display']=='project'||$category['item_display']=='gallery')) { ?>
                          <?php if ($category['content_id'] == $link_id) { ?>
                          <option value="<?php echo $category['content_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $category['content_id']; ?>"><?php echo $category['name']; ?></option>
                          <?php } ?>
                      <?php } ?>
                  <?php } ?>
                </select>
                 
              </div>
              </div><!-- form-group-->
           <div class="form-group">
                <label class="col-sm-4 control-label" for=""><?php echo $entry_description; ?></label>
                <div class="col-sm-8"> 
                 
            <?php foreach ($languages as $language) { ?>
            <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></span><textarea class="form-control" type="text" name="service_description[<?php echo $language['language_id']; ?>][description]" rows="8"><?php echo isset($service_description[$language['language_id']]) ? $service_description[$language['language_id']]['description'] : ''; ?></textarea>
                  </div>
                  <?php if (isset($error_description[$language['language_id']])) { ?><br/> 
                  <span class="text-danger"><?php echo $error_description[$language['language_id']]; ?></span>
                  <?php } ?>
            <?php } ?>
              </div>
              </div><!-- form-group-->
            
          </div>
        <div class="col-sm-6">
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
                <label class="col-sm-4 control-label" for=""><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-8"> 
                 <input type="text" name="sort_order" value="<?php echo $sort_order; ?>"  class="form-control"/>
              </div>
              </div><!-- form-group-->>
            
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
                <label class="col-sm-4 control-label" for=""><?php echo $entry_store; ?></label>
                <div class="col-sm-8"> 
                 
              <div class="well well-sm">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array(0, $service_store)) { ?>
                    <input type="checkbox" name="service_store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="service_store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($store['store_id'], $service_store)) { ?>
                    <input type="checkbox" name="service_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="service_store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
              </div>
              </div><!-- form-group-->
               
          </div>
          </div><!-- row -->
        
      </form>
    </div>
  </div>
</div>
<?php }?>
<?php echo $footer; ?>