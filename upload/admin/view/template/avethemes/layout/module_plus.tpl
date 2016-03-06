<?php
global $config;
$module_display = $config->get('skin_layout_builder_module_display');
 echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
     	<div class="pull-right">
            <a class="btn btn-primary" href="<?php echo $layout_builder;?>"><i class="fa fa-cubes"></i> Layout Composer</a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?> Selected" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-module').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
    <div class="alert alert-info"><i class="fa fa-info-circle" style="float:left;"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
        
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
  
        <form action="<?php echo $delete_module;?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
		<?php if($module_display==1){?>
          <div class="ds_accordion modules_list">
                <?php if ($extensions) {
                //print('<pre>');print_r($extensions);print('</pre>'); 
                 ?>
                <?php foreach ($extensions as $extension) { ?>
                <div class="ds_heading"><?php echo $extension['name']; ?></td>
                  <div class="btn-group pull-right"><?php if (!$extension['installed']) { ?>
                    <a href="<?php echo $extension['install']; ?>" data-toggle="tooltip" title="<?php echo $button_install; ?>" class="btn btn-xs btn-success"><i class="fa fa-sign-in"></i></a>
                    <?php } ?>
                    <?php if ($extension['installed']) { ?>
                    <?php if(!empty($extension['module'])) { ?>
<a href="<?php echo $extension['edit']; ?>" data-toggle="tooltip" title="Add" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i></a>
                    <?php }else{ ?>
<a href="<?php echo $extension['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>                 
                    <?php } ?>
                    <a onclick="confirm('<?php echo $text_confirm; ?>') ? location.href='<?php echo $extension['uninstall']; ?>' : false;" data-toggle="tooltip" title="<?php echo $button_uninstall; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a>
                    <?php } ?>
                    </div><!-- //btn-group--> 
                    </div><!-- //ds_heading--> 
                        <?php if(!empty($extension['module'])) { ?>
                            <div class="ds_content">
                        <?php foreach ($extension['module'] as $module) { ?>
                         <div class="module-block"><input type="checkbox" name="selected[]" value="<?php echo $module['module_id']; ?>" />  <?php echo $module['name']; ?>
                         <div class="btn-group pull-right">
                         <a onclick="confirm('<?php echo $text_confirm; ?>') ? location.href='<?php echo $module['delete']; ?>' : false;" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>
                         <a href="<?php echo $module['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
                        
                            </div><!-- //btn-group--> 
                            </div><!-- //module-block--> 
                        <?php } ?>
                 <br/>        
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);">Select All</a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);">Unselect All</a>
                        </div><!-- //ds_content-->  
                        <?php }else{ ?>
              <?php if ($extension['installed']) { ?> 
                        <div class="ds_content">
               <div class="module-block">&raquo; <?php echo $extension['name']; ?></div><!-- //module-block-->
                        </div><!-- //ds_content-->  
               <?php } ?>
                        <?php } ?>
                <?php } ?>
                <?php } else { ?>
                <div class="ds_heading"><?php echo $text_no_results; ?> </div><!-- //ds_heading-->
                <?php } ?>  
		</div><!-- //ds_accordion--> 
    <?php } else { ?>
      <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $column_name; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($extensions) { ?>
                <?php foreach ($extensions as $extension) { ?>
                <tr>
                  <td><?php echo $extension['name']; ?></td>
                  <td class="text-right"><?php if (!$extension['installed']) { ?>
                    <a href="<?php echo $extension['install']; ?>" data-toggle="tooltip" title="<?php echo $button_install; ?>" class="btn btn-success"><i class="fa fa-sign-in"></i></a>
                    <?php } else { ?>
                    <a onclick="confirm('<?php echo $text_confirm; ?>') ? location.href='<?php echo $extension['uninstall']; ?>' : false;" data-toggle="tooltip" title="<?php echo $button_uninstall; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a>
                    <?php } ?>
                   <?php if ($extension['installed']) { ?>
                    <?php if(!empty($extension['module'])) { ?>
<a href="<?php echo $extension['edit']; ?>" data-toggle="tooltip" title="Add" class="btn btn-success"><i class="fa fa-plus"></i></a>
                    <?php }else{ ?>
<a href="<?php echo $extension['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>                 
                    <?php } ?>
                    <?php } ?>
                    
                    </td>
                </tr>
                <?php foreach ($extension['module'] as $module) { ?>
                <tr>
                  <td class="text-left"><input type="checkbox" name="selected[]" value="<?php echo $module['module_id']; ?>" /> <?php echo $module['name']; ?></td>
                  <td class="text-right"><a onclick="confirm('<?php echo $text_confirm; ?>') ? location.href='<?php echo $module['delete']; ?>' : false;" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a> <a href="<?php echo $module['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="2"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
    <?php } ?>
      </div>
    </div>
</div><!--//container-fluid -->
  </div><!--//content --> 
<?php echo $footer; ?>