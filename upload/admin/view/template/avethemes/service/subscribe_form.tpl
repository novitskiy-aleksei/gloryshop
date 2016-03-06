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
        <button type="submit" form="form-subscribe" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <?php if(!$config->get('ave_confirm_installed')){?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_error_install; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
	<?php }else{?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-subscribe" class="form-horizontal">
    <input type="hidden" name="code" value="<?php echo isset($code)?$code:""; ?>" />
            <div class="table-responsive">
        <table class="table table-bordered table-hover">
       
        <tr>
          <td><span class="required"></span> <?php echo $entry_first_name; ?></td>
          <td><input type="text" name="firstname" value="<?php echo isset($firstname)?$firstname:""; ?>" class="form-control"/></td>
        </tr>
        <tr>
          <td><span class="required"></span> <?php echo $entry_last_name; ?></td>
          <td><input type="text" name="lastname" value="<?php echo isset($lastname)?$lastname:""; ?>" class="form-control"/></td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:20px;"><span class="required">*</span> <?php echo $entry_code; ?></td>
          <td>
          <input type="text" name="email" id="email" value="<?php echo $email; ?>" class="form-control">
          </textarea> 
          	<?php if (isset($error_firstname)) { ?>
            <span class="text-danger"><?php echo $error_firstname; ?></span>
            <?php  } ?>
			<?php if (isset($error_email_exist)) { ?>
            <span class="text-danger"><?php echo $error_email_exist; ?></span>
            <?php  } ?>
            
            </td>
        </tr>
        <tr>
          <td><?php echo $entry_subscribed; ?></td>
          <td>
          <select name="subscribed">
           <option value="1" <?php if($subscribed==1){ ?> selected='selected' <?php } ?>><?php echo $text_yes; ?></option>   
           <option value="0" <?php if($subscribed==0){ ?> selected='selected' <?php } ?>><?php echo $text_no; ?></option>           	
          </select></td>
        </tr> <tr>
          <td><span class="required"></span> <?php echo $entry_store; ?></td>
          <td>
          <select name="store_id">
           <option value="0" <?php if($store_id==0){ ?> selected='selected' <?php } ?>><?php echo $text_default; ?></option>
          	<?php 
            	if($stores){ 
                	foreach($stores as $store){ 
             
                        if($store_id == $store['store_id'])
                    		echo "<option selected='selected' value='".$store['store_id']."'>".$store['name']."</option>";
                        else
                    		echo "<option value='".$store['store_id']."'>".$store['name']."</option>";
                    }
                }
            ?>
          </select></td>
        </tr>
      </table>
</div>
      </form>
<?php }?>
 </div>
    </div>
  </div>
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
	});
</script>
<?php echo $footer; ?>