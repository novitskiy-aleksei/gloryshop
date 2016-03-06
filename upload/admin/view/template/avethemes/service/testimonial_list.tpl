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
    <a href="<?php echo HTTP_CATALOG;?>index.php?route=content/testimonial" class="btn blue-bg btn-sm pull-right" target="_blank">Front-end testimonial form</a>
      </div>
      <div class="panel-body">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
              <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
              
              
               <td width="1" style="text-align: center;"><?php echo $column_avatar; ?></td>
              <td class="left"><?php if ($sort == 'r.customer_name') { ?>
                <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
                <?php } ?></td>
            <td class="left"><?php if ($sort == 'r.service') { ?>
                <a href="<?php echo $sort_service; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_service; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_service; ?>"><?php echo $column_service; ?></a>
                <?php } ?></td>
            <td class="text-center"><?php if ($sort == 'r.rating') { ?>
                <a href="<?php echo $sort_rating; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_rating; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_rating; ?>"><?php echo $column_rating; ?></a>
                <?php } ?></td>
            <td class="right"><?php if ($sort == 'r.read') { ?>
                <a href="<?php echo $sort_read; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_read; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_read; ?>"><?php echo $column_read; ?></a>
                <?php } ?></td>
            <td class="right"><?php if ($sort == 'r.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
                
                
              <td class="right"><?php if ($sort == 'r.date_added') { ?>
                <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($testimonials) { ?>
            <?php foreach ($testimonials as $testimonial) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($testimonial['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $testimonial['testimonial_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $testimonial['testimonial_id']; ?>" />
                <?php } ?></td>
                    <td style="text-align: center;" class="avatar"><img src="<?php echo $testimonial['avatar']; ?>" alt="<?php echo $testimonial['customer_name']; ?>"/></td>
              <td class="left"><?php echo $testimonial['customer_name']; ?><br> <span class="help"><?php echo $testimonial['competence']; ?></span></td>
             <td style="padding:5px;"><div class="filterbox"><?php foreach ($services as $service){?>
                <?php if (in_array($service['service_id'], $testimonial['service_selection'])){?>
                <?php echo $service['name'];?><br>
                <?php }?> <?php }?></div>
				</td>
              <td class="text-center"><img src="../assets/global/img/rating/stars-<?php echo $testimonial['rating']; ?>.png" /></td>
              <td class="right"><?php echo $testimonial['read']; ?></td>
              <td class="right"><?php echo $testimonial['status']; ?></td>
              <td class="right"><?php echo $testimonial['date_added']; ?></td>
              <td class="right">
              
              
              <div class="buttons">
              <?php foreach ($testimonial['action'] as $action) { ?>
                 <a class="btn btn-primary btn-xs" href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a>
                <?php } ?>
                </div>
                </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
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
<?php echo $footer; ?>