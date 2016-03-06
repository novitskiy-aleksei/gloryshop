<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-custom_html" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-custom_html" class="form-horizontal">
        
        <input type="hidden" name="element" value="<?php echo $element; ?>" id="input-element" class="form-control" />
       
            
            <div class="clearfix">
        <div class="col-md-3 col-sm-3">
         
          <div class="form-group">
          
            <h5><?php echo $entry_template;?></h5>
             
                <div class="col-sm-12">
              <?php foreach ($elements as $elem) {
              if(!empty($elem['key'])){
               ?>
                <img src="../assets/editor/img/mockup/<?php echo $elem['key'];?>.png" data-key="<?php echo $elem['key'];?>" class="<?php echo ($elem['key']==$element)?'show':'hide';?>"/>
              <?php } ?>
              <?php } ?>
              </div>  
          </div>    <!--//form-group --> 
        
          <div class="form-group">
          <div class="col-sm-12">
 <select id="template_display" class="form-control with-nav" onchange="location = this.value;"> 
              <?php foreach ($elements as $elem) { ?>
    <option value="<?php echo $elem['value'];?>" <?php echo ($elem['key']==$element)?'selected="selected"':'';?>><?php echo $elem['label'];?></option> 
              <?php } ?>
            </select>
              </div>  
          </div>    <!--//form-group --> 
          
          </div> <!--//col--> 
        <div class="col-md-9 col-sm-9">
           <div class="form-group">
            <label class="col-sm-3 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-9">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div> <!--//form group--> 
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-9">
              <select name="status" id="input-status" class="form-control">
                <option value="1" <?php if ($status=='1') { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php if ($status=='0') { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
              </select>
            </div>
          
          </div> <!--//form group--> 
          </div> <!--//col--> 
          </div><!--//row-->
          
           <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12 pull-right">
             <div class="section">
          <div class="tab-pane clearfix">
            <ul class="nav nav-tabs" id="language">
              <?php foreach ($languages as $language) { ?>
              <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
              <?php } ?>
            </ul>
            <div class="tab-content">
              <?php foreach ($languages as $language) { ?>
              <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                <div class="form-group">
                  <div class="col-sm-12">
                  <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i><?php echo $help_description;?>
    </div>
                    <textarea name="module_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($module_description[$language['language_id']]['description']) ? $module_description[$language['language_id']]['description'] : ''; ?></textarea>
                    
                    
                     <?php if (isset($error_description[$language['language_id']])) { ?>
                      <br/> <div class="text-danger"><?php echo $error_description[$language['language_id']]; ?></div>
                      <?php } ?>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div><!--tab-pane --> 
          </div>
        </div><!-- //col--> 
        <div class="col-md-3 col-sm-3 col-xs-12">
         <div class="block_relative">
          <div id="module_list">
          <div class="heading-bar"><?php echo $text_installed_modules;?></div>
          <div class="module_accordion ds_accordion">
          <div>
              <div class="ds_content" style="display:block !important">
                   <?php foreach ($module_data as $module) { ?>
                  <div class="module-block <?php echo ($module['module_id']==$module_id)?'active':'';?>">
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
  </div>
  <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({height: 600});
<?php } ?>
//--></script> 
  <script type="text/javascript"><!--
$('.nav-tabs a:first').tab('show');
//--></script>
</div>
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
	});
</script>
<!-- 
<script type="text/javascript" src="../assets/theme/js/theme_init.js"></script>--> 
<?php echo $footer; ?>