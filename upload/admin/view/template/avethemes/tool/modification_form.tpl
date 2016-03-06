<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
    <div>   
     <?php echo $shortcut_group;?>
      </div>
    </div>
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" onclick="fmction();" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body clearfix">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-modification" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-author"><?php echo $column_author; ?></label>
            <div class="col-sm-10">
              <input type="text" name="author" value="<?php echo $author; ?>" placeholder="<?php echo $column_author; ?>" id="input-author" class="form-control" />
              <?php if ($error_author) { ?>
              <div class="text-danger"><?php echo $error_author; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-author"><?php echo $column_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $column_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-version"><?php echo $column_id; ?></label>
            <div class="col-sm-10">
              <input type="text" name="code" value="<?php echo $code; ?>" placeholder="<?php echo $column_code; ?>" id="input-code" class="form-control"/>  
              <?php if ($error_code) { ?>
              <span class="text-danger">
              <?php echo $error_code; ?></span>
              <?php } ?>           
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-version"><?php echo $column_version; ?></label>
            <div class="col-sm-10">
              <input type="text" name="version" value="<?php echo $version; ?>" placeholder="<?php echo $column_version; ?>" id="input-version" class="form-control" />             
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-link"><?php echo $column_link; ?></label>
            <div class="col-sm-10">
              <input type="text" name="link" value="<?php echo $link; ?>" placeholder="<?php echo $column_link; ?>" id="input-link" class="form-control" />             
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $column_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">                
                <option value="1" <?php if ($status) { ?>selected="selected" <?php } ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php if ($status==0) { ?>selected="selected" <?php } ?>><?php echo $text_disabled; ?></option>               
              </select>
            </div>
          </div>          
          <div class="form-group required">
            <div class="col-sm-12">
            <label class="control-label" for="input-text"><?php echo $column_xml; ?></label>
            <pre id="custom_code" style="width:98% !important; height:480px; position:relative; margin:0 1%; font-size:1.1em;"><?php echo htmlentities($xml); ?></pre>
              <?php if ($error_xml) { ?>
              <span class="text-danger">
              <?php echo $error_xml; ?></span>
              <?php } ?>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
	var path = "../assets/plugins/code_editor";
	var editorconfig = ace.require("ace/config");
	editorconfig.set("workerPath", path);
	var xml_editor = ace.edit("custom_code");
	xml_editor.setTheme("ace/theme/cobalt");
	xml_editor.getSession().setMode("ace/mode/xml");
function fmction(){
		var custom_code = xml_editor.getValue();
		$('#custom_code').after('<text'+'area name="xml" style="display:none" cols="60" rows="15" id="inputcode" class="form-control">'+custom_code+'</text'+'area>');
		$('#form-modification').submit();
}
//--></script> 
<?php echo $footer; ?>