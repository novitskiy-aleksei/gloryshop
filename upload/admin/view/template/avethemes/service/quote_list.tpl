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
    <a href="<?php echo HTTP_CATALOG;?>index.php?route=content/quote" class="btn blue-bg btn-sm pull-right" target="_blank">Front-end quote form</a>
      </div>
      <div class="panel-body">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <ul class="nav nav-tabs">
      <li><a href="#tab-quote" data-toggle="tab"><?php echo $text_request; ?></a></li>
      <li><a href="#tab-setting" data-toggle="tab"><?php echo $tab_budget; ?></a></li>
      </ul>
      <div class="tab-content">
      <div id="tab-quote" class="tab-pane active">
              <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'r.customer_name') { ?>
                <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
                <?php } ?></td>
            <td class="left"><?php echo $column_service; ?></td>
                 <td class="right"><?php echo $column_budget; ?> </td>
              <td class="right"><?php if ($sort == 'r.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>  <td class="right"><?php if ($sort == 'r.read') { ?>
                <a href="<?php echo $sort_read; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_read; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_read; ?>"><?php echo $column_read; ?></a>
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
            <?php if ($quotes) { ?>
            <?php foreach ($quotes as $quote) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($quote['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $quote['quote_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $quote['quote_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $quote['customer_name']; ?><br> <span class="help"><?php echo $quote['competence']; ?></span></td>
               <td style="padding:5px;"><div class="filterbox"><?php foreach ($services as $service){?>
                <?php if (in_array($service['service_id'], $quote['service_selection'])){?>
                <?php echo $service['name'];?><br>
                <?php }?> <?php }?></div>
				</td>
              <td class="right"><?php echo $quote['budget']; ?></td>
              <td class="right"><?php echo $quote['status']; ?></td>
              <td class="right"><?php echo $quote['read']; ?></td>
              <td class="right"><?php echo $quote['date_added']; ?></td>
              <td class="right">
              
              <div class="buttons">
              <?php foreach ($quote['action'] as $action) { ?>
                 <a class="btn btn-primary btn-xs" href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a>
                <?php } ?>
                </div>
                </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div><!--row --> 
      </div><!-- //table--> 
        </div><!-- //tab-pane--> 
        <div id="tab-setting" class="tab-pane fade">
        <div class="buttons clearfix">
        <a onclick="$('#form').attr('action', '<?php echo $budget; ?>'); $('#form').submit();" class="btn btn-primary btn-sm pull-right"><span><i class="fa fa-files-o"></i> <?php echo $button_save_budget; ?></span></a>
        </div>
      <h2><?php echo $text_budget;?></h2>
              <div class="table-responsive">
       <table id="budget" class="table">
          <thead>
            <tr>
              <td>
              <div class="row">
              <div class="col-sm-4 form-group"><?php echo $entry_value; ?></div>
             <div class="col-sm-5 form-group"><?php echo $entry_label; ?></div>
             <div class="col-sm-3 form-group"></div></div>
                </td>
            </tr>
          </thead>
          <?php $budget_row = 0; ?>
          <?php foreach ($budgets as $budget) { ?>
          <tbody id="budget-row<?php echo $budget_row; ?>">
            <tr>
              <td><div class="row">
              <div class="col-sm-4 form-group"><input type="text" name="request_quote_budgets[<?php echo $budget_row; ?>][value]" value="<?php echo $budget['value']; ?>" class="form-control"/>
                <?php if (isset($error_route[$budget_row])) { ?><br/> 
                <span class="text-danger"><?php echo $error_route[$budget_row]; ?></span>
                <?php } ?>
              </div>
             <div class="col-sm-5 form-group"><input type="text" name="request_quote_budgets[<?php echo $budget_row; ?>][label]" value="<?php echo $budget['label']; ?>" class="form-control"/>              
                <?php if (isset($error_url[$budget_row])) { ?><br/> 
                <span class="text-danger"><?php echo $error_url[$budget_row]; ?></span>
                <?php } ?>
                </div>
                <div class="col-sm-3 form-group"><a onclick="$('#budget-row<?php echo $budget_row; ?>').remove();" class="btn btn-primary btn-xs"><i class="fa fa-minus"></i> <?php echo $button_remove; ?></a></div></div></td>
            </tr>
          </tbody>
          <?php $budget_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td><a onclick="addBudget();" class="btn btn-primary btn-xs pull-right"><i class="fa fa-plus"></i> <?php echo $button_add; ?></a></td>
            </tr>
          </tfoot>
        </table>
        </div><!-- --> 
        </div><!-- //tab-pane--> 
        </div><!-- //tab-conetnt--> 
     </form>
      </div><!--panel-body --> 
    </div><!--panel --> 
    <?php } ?>
  </div><!--container-fluid --> 
</div><!--#content -->
<script type="text/javascript"><!--
var budget_row = <?php echo $budget_row; ?>;

function addBudget() {	
	html  = '<tbody id="budget-row' + budget_row + '">';
	html += '  <tr>';
	html += '    <td><div class="row"><div class="col-sm-4 form-group"><input type="text" name="request_quote_budgets[' + budget_row + '][value]" value="100" class="form-control"/></div>';
	html += '    <div class="col-sm-5 form-group"><input type="text" name="request_quote_budgets[' + budget_row + '][label]" value="\$100\" class="form-control"/></div>';
	html += '    <div class="col-sm-3 form-group"><a onclick="$(\'#budget-row' + budget_row + '\').remove();" class="btn btn-primary btn-xs"><i class="fa fa-minus"></i> <?php echo $button_remove; ?></a></div></div></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#budget tfoot').before(html);
	
	budget_row++;
}
//--></script> 
<?php echo $footer; ?>