<?php global $config; echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
    <div>   
     <?php echo $shortcut_group;?>
      </div>
    </div>
    <div class="container-fluid">
      <div class="pull-right">
      <a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a> 
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-subscribe').submit() : false;"><i class="fa fa-trash-o"></i></button>
        
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
  
  <?php if(!$config->get('ave_confirm_installed')){?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_error_install; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
	<?php }else{?>
   <ul id="tabs" class="nav nav-tabs">
   <li class="active"><a href="#tab-list" data-toggle="tab"><?php echo $tab_email_list; ?></a></li>
   <li><a href="#tab-import" data-toggle="tab"><?php echo $tab_import; ?></a></li>
   <li><a href="#tab-export" data-toggle="tab"><?php echo $tab_export; ?></a>   </li>
   <li><a href="#tab-setting" data-toggle="tab"><?php echo $tab_setting; ?></a>   </li>
   </ul>
   
    
   <div class="tab-content">
            <div class="tab-pane" id="tab-setting">
            
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">  
          <div class="table-responsive">
        <table class="table table-bordered table-hover">
       
        <tr>
    	    <td></td>
    	    <td>
          	<a onclick="$('#form-setting').submit();" class="btn btn-primary btn-sm pull-right"><span><?php echo $button_save; ?></span></a>
          </td> <tr>
          <td> <?php echo $entry_unsubscribe; ?></td>
          <td>
              <select name="ave_newsletter_unsubscribe" id="input-unsubscribe" class="form-control">
                
                <option value="1" <?php if ($ave_newsletter_unsubscribe==1) { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php if ($ave_newsletter_unsubscribe==0) { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
                
              </select>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_mail; ?> </td>
          <td>
              <select name="ave_newsletter_mail_status" id="input-mail" class="form-control">
                <option value="1" <?php if ($ave_newsletter_mail_status==1) { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php if ($ave_newsletter_mail_status==0) { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
              </select>
          </td>
        </tr>
        <tr>
          <td> <?php echo $entry_registered; ?><span data-toggle="tooltip" title="When you enable this option open cart registered users also can subscribe or un subscribe using this."></span></td>
          <td>
              <select name="ave_newsletter_registered" id="input-registered" class="form-control">
                <option value="1" <?php if ($ave_newsletter_registered==1) { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php if ($ave_newsletter_registered==0) { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
              </select>
          </td>
        </tr>
        </tr>
      </table>
</div>
    </form>
            
            </div>
            <div class="tab-pane active" id="tab-list">
        
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-subscribe">
     
            <div class="table-responsive">
        <table class="table table-bordered table-hover">
        
					<thead>
						<tr>
							<td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
							<td class="left">
								<?php if ($sort == 'name') { ?>
								<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
								<?php } ?>
							</td>
							<td class="left">
								<?php if ($sort == 'email') { ?>
								<a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
								<?php } ?>
							</td>
						<td class="right">
								<?php if ($sort == 'subscribed') { ?>
								<a href="<?php echo $sort_subscribed; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_subscribed; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_subscribed; ?>"><?php echo $column_subscribed; ?></a>
								<?php } ?>
							</td>
							<td class="right">
								<?php if ($sort == 'store_id') { ?>
								<a href="<?php echo $sort_store; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_store; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_store; ?>"><?php echo $column_store; ?></a>
								<?php } ?>
							</td>
							<td class="right"><?php echo $column_action; ?></td>
						</tr>
					</thead>
        <tbody>
        <tr class="filter">
							<td> <select onchange="location = this.value;" class="form-control">
        <?php foreach ($limits as $limits) { ?>
        <?php if ($limits['value'] == $filter_limit) { ?>
        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select></td>
							<td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" class="form-control"/></td>
							<td><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" class="form-control"/></td>
                            <td class="right">
								<select name="filter_subscribed" class="form-control">
									<option value=""></option>
									<?php if ($filter_subscribed == '1') { ?>
									<option value="1" selected="selected"><?php echo $entry_yes; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $entry_yes; ?></option>
									<?php } ?>
									<?php if ($filter_subscribed == '0') { ?>
									<option value="0" selected="selected"><?php echo $entry_no; ?></option>
									<?php } else { ?>
									<option value="0"><?php echo $entry_no; ?></option>
									<?php } ?>
								</select>
							</td>
							<td class="right">
								<select name="filter_store" class="form-control">
									<option value=""><?php echo $text_default; ?></option>
									<?php foreach ($stores as $store) { ?>
									<?php if ($filter_store == $store['store_id'] && $filter_store != '') { ?>
									<option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</td>
							<td align="right">
								<a onclick="filter();" class="btn btn-primary btn-xs"><span><?php echo $button_filter; ?></span></a>
							</td>
						</tr>
          <?php if ($emails) { ?>
          <?php foreach ($emails as $email) { ?>
          <tr>
            <td style="text-align: center;">
              <input type="checkbox" name="selected[]" value="<?php echo $email['email_id']; ?>"/>
             </td>
            <td class="left"><?php echo $email['name']; ?></td>
            <td class="left"><?php echo $email['email']; ?></td>
            <td class="right"><?php if ($email['subscribed'] == '1') { ?>
									<?php echo $entry_yes; ?>
								<?php } else { ?>
									<?php echo $entry_no; ?>
								<?php } ?></td>
            <td align="right"><?php echo $email['store_name']; ?></td>
            <td class="right">
            <div class="buttons">
            <?php foreach ($email['action'] as $action) { ?>
              <a class="btn btn-primary btn-xs" href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a>
              <?php } ?></div></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
</div>
      </form>
  <div class="pagination"><?php echo $pagination; ?></div>
  </div>
  <div class="tab-pane fade" id="tab-import">
      <form action="<?php echo $import; ?>" method="post" enctype="multipart/form-data" id="import">
            <div class="table-responsive">
        <table class="table table-bordered table-hover">
      	<!-- mapping fields to names -->
		<tr>
			<td colspan="2">
				<table>
					<tr><td width="150"><h2><?php echo $text_oc_title; ?></h2></td><td><h2><?php echo $text_csv_title; ?></h2></td></tr>
                    
              <?php foreach ($field_data as $field) { ?>
					<tr><td width="150"><?php echo $language[$field]; ?></td>
                    <td><div class="form-group"><input type="text" name="<?php echo $field; ?>" value="<?php echo $field; ?>" class="form-control"></div></td></tr>
              <?php } ?>   
              
				</table> 
					<a class="btn btn-primary btn-sm" style="margin-left:250px;" onclick="$(this).parent().parent().find(':input').val('');">Clear All</a>
			</td>
		</tr>
		<!-- ignore where FIELD equals VALUE -->
		<tr>
			<td><?php echo $entry_ignore_fields; ?></td>
			<td>
				<input onfocus="$(this).val('');" type="text" name="subcriber_import_ignore_field" value="<?php if (isset($subcriber_import_ignore_field)) { echo $subcriber_import_ignore_field; } else { echo 'COLUMN'; }  ?>" class="form-control">
				&nbsp;<?php echo $entry_contains; ?>&nbsp;
				<input onfocus="$(this).val('');" type="text" name="subcriber_import_ignore_value" value="<?php if (isset($subcriber_import_ignore_value)) { echo $subcriber_import_ignore_value; } else { echo 'VALUE'; } ?>" class="form-control"></td>
		</tr>
      	<!-- delimiter -->
		<tr>
			<td width="150"><?php echo $entry_delimiter; ?></td>
			<td>
				<select name="subcriber_import_delimiter" class="form-control">
					<option value=";" <?php if (isset($subcriber_import_delimiter) && $subcriber_import_delimiter == ';') { echo 'selected="true"'; } ?>>;</option>
					<option value="," <?php if (isset($subcriber_import_delimiter) && $subcriber_import_delimiter == ',') { echo 'selected="true"'; } ?>>,</option>
					<option value="\t" <?php if (isset($subcriber_import_delimiter) && $subcriber_import_delimiter == '\t') { echo 'selected="true"'; } ?>><?php echo $entry_tab; ?></option>
					<option value="|" <?php if (isset($subcriber_import_delimiter) && $subcriber_import_delimiter == '|') { echo 'selected="true"'; } ?>>|</option>
					<option value="^" <?php if (isset($subcriber_import_delimiter) && $subcriber_import_delimiter == '^') { echo 'selected="true"'; } ?>>^</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="150"><?php echo $entry_import; ?></td>
          	<td><input type="file" name="import" class="pull-left"/><a onclick="$('#import').submit();" class="btn btn-primary btn-xs pull-left"><span><?php echo $button_import; ?></span></a></td>
		</tr>
      </table>
</div>
      </form>
    </div>
   <div class="tab-pane fade" id="tab-export">
    <form action="<?php echo $export; ?>" method="post" enctype="multipart/form-data" id="export">
            <div class="table-responsive">
        <table class="table table-bordered table-hover">
        <tr>
          <td><?php echo $entry_export; ?></td>
          <td class='scroll_cell'><div class="scrollbox">
              <?php $class = 'odd'; ?>
              <?php foreach ($field_data as $field) { ?>
              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
              <div class="<?php echo $class; ?>">
                <input type="checkbox" name="export[]" value="<?php echo $field; ?>" checked="checked" />
                <?php echo $field; ?>
               </div>
              <?php } ?>
            </div>
            <a onclick="$(this).parent().find(':checkbox').attr('checked', true);">Select All</a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);">Unselect All</a>
          </td>
        </tr>
        <tr>
    	    <td colspan="2">
          	<a onclick="$('#export').submit();" class="btn btn-primary btn-sm"><span><?php echo $button_export; ?></span></a>
          </td>
        </tr>
      </table>
</div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div><!--row --> 
        </div><!--//tab-pane --> 
        </div><!--//tab-content --> 
    <?php } ?>
        
      </div><!--panel-body --> 
    </div><!--panel --> 
  </div><!--container-fluid --> 
</div><!--#content -->
<script language="javascript">
function ajax_upload(){ 
  $('#subscribe_import').trigger('click');
}
</script>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=ave/newsletter&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_email = $('input[name=\'filter_email\']').attr('value');
	
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}

	var filter_subscribed = $('select[name=\'filter_subscribed\']').attr('value');
	
	if (filter_subscribed) {
		url += '&filter_subscribed=' + encodeURIComponent(filter_subscribed);
	}

	var filter_list = [];

	$.each($('input[name=\'filter_list[]\']:checked'), function() {
		filter_list.push($(this).val());
	});
		
	if (filter_list.length) {
		url += '&filter_list=' + encodeURIComponent(filter_list.join());
	}

	var filter_store = $('select[name=\'filter_store\']').attr('value');
	
	if (filter_store) {
		url += '&filter_store=' + encodeURIComponent(filter_store);
	}
	
	location = url;
}
//--></script>
<script type="text/javascript"><!--
$('#list' + $('select[name=\'store_id\']').attr('value')).show();

$('select[name=\'store_id\']').change(function(){
	$('.list_display').hide();
	$('#list' + $(this).attr('value')).show();
});

if ($('select[name=\'filter_store\']').attr('value') != '') {
	$('.list_store' + $('select[name=\'filter_store\']').attr('value')).show();
} else {
	$('.list_hide').show();
}

$('select[name=\'filter_store\']').change(function(){
	$('.list_hide').hide();
	if ($(this).attr('value') != '') {
		$('.list_store' + $(this).attr('value')).show();
	} else {
		$('.list_hide').show();
	}
});

$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script>
<script>
	$(function() {
		var dates = $( "#from, #to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			onSelect: function( selectedDate ) {
				var option = this.id == "from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
				dateFormat: 'yy-mm-dd';
			}
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
	});
</script>
<?php echo $footer; ?>