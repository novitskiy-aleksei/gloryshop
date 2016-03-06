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
      <a onclick="location = '<?php echo $insert; ?>'" class="btn btn-success btn-sm"><span><i class="fa fa-plus"></i> <?php echo $button_add; ?></span></a>
      <a onclick="$('#form').submit();" class="btn btn-danger btn-sm"><span><i class="fa fa-trash-o"></i> <?php echo $button_delete; ?></span></a>
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
    
   <?php if(!$config->get('ave_confirm_installed')){?>  
     <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_error_install; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
	<?php }else{?>    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
         <div class="table-responsive">
            <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
              <td width="1" style="text-align: center;"><?php echo $column_image; ?></td>
              <td class="left"><?php if ($sort == 'author') { ?>
                <a href="<?php echo $sort_author; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_author; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_author; ?>"><?php echo $column_author; ?></a>
                <?php } ?></td>
              <td class="right"><?php if ($sort == 'sort_order') { ?>
                <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($authors) { ?>
            <?php foreach ($authors as $author) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($author['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $author['author_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $author['author_id']; ?>" />
                <?php } ?></td>
              <td style="text-align: center;" class="avatar"><img src="<?php echo $author['image']; ?>" alt="<?php echo $author['author']; ?>"/></td>
              <td class="left"><?php echo $author['author']; ?></td>
              <td class="right"><?php echo $author['sort_order']; ?></td>
              <td class="right">
              <div class="buttons">
              <?php foreach ($author['action'] as $action) { ?>
               <a href="<?php echo $action['href']; ?>" class="btn btn-primary btn-xs" target="<?php echo $action['target']; ?>"><?php echo $action['text']; ?></a>
                <?php } ?>
                </div>
                </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
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
    <?php } ?>
  </div><!--container-fluid --> 
</div><!--#content -->
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
	});
</script>
<?php echo $footer; ?>