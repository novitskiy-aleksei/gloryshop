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
          <a onclick="$('#form').attr('action', '<?php echo $copy; ?>'); $('#form').submit();" class="btn btn-primary btn-sm"><span><i class="fa fa-files-o"></i> <?php echo $button_copy; ?></span></a>
          <a href="<?php echo $insert; ?>" class="btn btn-success btn-sm"><span><i class="fa fa-plus"></i> <?php echo $button_add; ?></span></a>
          <a onclick="$('form').submit();" class="btn btn-danger btn-sm"><span><i class="fa fa-trash-o"></i> <?php echo $button_delete; ?></span></a>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $import; ?>" method="post" enctype="multipart/form-data" id="import">
                          <div class="table-responsive">
        <table class="table table-bordered table-hover">
                 <tbody>
                    <tr>
                    <td><input type="file" name="import" /></td>  
                    <td><a onclick="$('#import').submit();" class="btn btn-primary btn-xs"><span><?php echo $button_import; ?></span></a></td>   
                    </tr>
                    </tbody>
                    </table>
</div>
      </form>
      <form action="<?php echo $delete_selected; ?>" method="post" enctype="multipart/form-data" id="form">
              <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr> 
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
              <td class="left">
                <a href="<?php echo $sort_name; ?>" <?php if ($sort == 'name') { ?>class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_name; ?></a>
                </td>            
              <td class="text-center"><?php echo $text_preview; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($sliders) { ?>
            <?php foreach ($sliders as $slider) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($slider['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $slider['primary_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $slider['primary_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $slider['title']; ?></td>
              <td class="text-center"><a href="<?php echo $slider['preview']; ?>" class="modalbox" data-size="modal-fw" data-type="iframe" data-title="<?php echo $text_preview;?>" title="<?php echo $text_preview;?>"><i class="fa fa-search"></i></a></td>
              
              
            <td class="right">
                <input type="radio" style="display:none" name="primary_id" id="primary_id<?php echo $slider['primary_id']; ?>" value="<?php echo $slider['primary_id']; ?>" />
            <div class="buttons"> 
            <a class="btn btn-primary btn-xs" onclick="$('#primary_id<?php echo $slider['primary_id']; ?>').attr('checked', 'checked');$('#form').attr('action', '<?php echo $export;?>');$('#form').submit();"><?php echo $text_export; ?></a>
            	<?php foreach ($slider['action'] as $action) { ?>
              <a class="btn btn-primary btn-xs <?php echo $action['class']; ?>" href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a>
              <?php } ?>
             
             </div>
              </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
</div>

    </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div><!--row --> 
      </div><!--panel-body --> 
    </div><!--panel --> 
  </div><!--container-fluid --> 
</div><!--#content -->
<?php echo $footer; ?>
