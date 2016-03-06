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
        <button type="submit" form="form-download" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-success btn-sm"><i class="fa fa-save"></i></button>
      <a href="<?php echo $cancel; ?>" class="btn btn-primary btn-sm"><span><i class="fa fa-share-square-o"></i> <?php echo $button_cancel; ?></span></a>
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
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-download" name="form-download" class="form-horizontal">
       <div class="table-responsive">
       <table class="table table-bordered table-hover">
          <tr>
            <td width="120"><?php echo $entry_filename; ?></td>
            <td>
            <div class="input-group">
            <input type="text" name="filename" value="<?php echo $filename; ?>" class="form-control"/>
            <span class="input-group-btn">
                <button type="button" id="button-upload" data-loading-text="Loading..." class="btn btn-primary"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                </span>
                </div>
              <?php if ($error_filename) { ?>
              <span class="text-danger"><?php echo $error_filename; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_mask; ?></td>
            <td><input type="text" name="mask" value="<?php echo $mask; ?>" class="form-control"/>
              <?php if ($error_mask) { ?>
              <span class="text-danger"><?php echo $error_mask; ?></span>
              <?php } ?></td>
          </tr>
            <tr style="display:none">
              <td><?php echo $entry_color; ?></td>
              <td><select name="color" data-selected="<?php echo $color;?>" class="form-control">
             <?php foreach ($setcolors as $value => $label) {	?>
                  <option value="<?php echo $value;?>"  <?php if ($color==$value) { ?>selected="selected" <?php } ?>><?php echo $label;?></option>	 
			<?php	 }   ?>
                </select>
            </td>
            </tr>
         <tr>
            <td><?php echo $entry_auth_key; ?></td>
            <td><input type="text" name="auth_key" value="<?php echo $auth_key; ?>" class="form-control"/>
              <?php if ($error_auth_key) { ?>
              <span class="text-danger"><?php echo $error_auth_key; ?></span>
              <?php } ?></td>
          </tr>
          <?php if ($download_id) { ?>
          <tr style="display:none">
            <td><?php echo $entry_update; ?></td>
            <td><?php if ($update) { ?>
              <input type="checkbox" name="update" value="1" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="update" value="1" />
              <?php } ?></td>
          </tr>
          <?php } ?>
          
          <tr>
            <td colspan="2">
            
            <ul class="nav nav-tabs">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
            <?php } ?>
          </ul><div class="tab-content">
          <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>">
          
          <div class="form-group">
          <label class="col-sm-3"><?php echo $entry_name; ?></label>
          <div class="col-sm-9"><input type="text" name="download_description[<?php echo $language['language_id']; ?>][name]" class="form-control" value="<?php echo isset($download_description[$language['language_id']]) ? $download_description[$language['language_id']]['name'] : ''; ?>" />
                  <?php if (isset($error_name[$language['language_id']])) { ?>
                  <span class="text-danger"><?php echo $error_name[$language['language_id']]; ?></span>
                  <?php } ?></div>
          </div><!-- //form-group--> 
          
          <div class="form-group">
          <label class="col-sm-3"><?php echo $entry_description; ?></label>
          <div class="col-sm-9"><textarea name="download_description[<?php echo $language['language_id']; ?>][description]" cols="60" rows="5" class="form-control"><?php echo isset($download_description[$language['language_id']]) ? $download_description[$language['language_id']]['description'] : ''; ?></textarea>
                <?php if (isset($error_description[$language['language_id']])) { ?>
                  <span class="text-danger"><?php echo $error_description[$language['language_id']]; ?></span>
                  <?php } ?></div>
          </div><!-- //form-group--> 
          
          </div>
          <?php } ?>
          </div>
          </td>
          </tr>
        </table>
</div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/jquery/ajaxupload.js"></script> 
<script type="text/javascript"><!--
new AjaxUpload('#button-upload', {
	action: 'index.php?route=ave/download/upload&token=<?php echo $token; ?>',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-upload').after('<img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-upload').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-upload').attr('disabled', false);
		
		if (json['success']) {
			alert(json['success']);
			
			$('input[name=\'filename\']').attr('value', json['filename']);
			$('input[name=\'mask\']').attr('value', json['mask']);
			$('input[name=\'auth_key\']').attr('value', json['auth_key']);
		}
		
		if (json['error']) {
			alert(json['error']);
		}
		
		$('.loading').remove();	
	}
});
//--></script> 
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
	});
</script>
<?php }?>
<?php echo $footer; ?>