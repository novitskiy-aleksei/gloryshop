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
        <button type="submit" form="form-quote" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-success btn-sm"><i class="fa fa-save"></i></button>
      <a onclick="location = '<?php echo $cancel; ?>';" class="btn btn-danger btn-sm"><span><i class="fa fa-share-square-o"></i> <?php echo $button_cancel; ?></span></a>
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
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-quote" class="form-horizontal">
      <div class="row">
      <div class="col-sm-6">
      
      <h2><?php echo $text_h2_sender;?></h2>
      
      <div class="form-group">
      <label class="col-sm-3"><?php echo $entry_customer_name; ?></label>
      <div class="col-sm-9">
      <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" class="form-control"/>
              <?php if ($error_customer_name) { ?>
              <span class="text-danger"><?php echo $error_customer_name; ?></span>
              <?php } ?>
      </div>
      </div><!-- //form-group--> 
      <div class="form-group">
      <label class="col-sm-3"> <?php echo $entry_customer_telephone; ?></label>
      <div class="col-sm-9">
      <input type="text" name="customer_telephone" value="<?php echo $customer_telephone; ?>" class="form-control"/>
              <?php if ($error_customer_telephone) { ?>
              <span class="text-danger"><?php echo $error_customer_telephone; ?></span>
              <?php } ?>
      </div>
      </div><!-- //form-group--> 
      <div class="form-group">
      <label class="col-sm-3"><?php echo $entry_customer_email; ?></label>
      <div class="col-sm-9">
      <input type="text" name="customer_email" value="<?php echo $customer_email; ?>" class="form-control"/>
              <?php if ($error_customer_email) { ?>
              <span class="text-danger"><?php echo $error_customer_email; ?></span>
              <?php } ?>
      </div>
      </div><!-- //form-group-->
      <div class="form-group">
      <label class="col-sm-3"><?php echo $entry_competence; ?></label>
      <div class="col-sm-9">
      <input type="text" name="competence" value="<?php echo $competence; ?>" class="form-control"/>
      </div>
      </div><!-- //form-group-->
      <div class="form-group">
      <label class="col-sm-3"><?php echo $entry_company; ?></label>
      <div class="col-sm-9">
      <input type="text" name="customer_company" value="<?php echo $customer_company; ?>" class="form-control"/>
      </div>
      </div><!-- //form-group-->
      <div class="form-group">
      <label class="col-sm-3"><?php echo $entry_store; ?></label>
      <div class="col-sm-9">
      <select name="store_id" class="form-control">
                <option value="0"><?php echo $text_default; ?></option>
                <?php foreach ($stores as $store) { ?>
                <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                <?php } ?>
              </select>
      </div>
      </div><!-- //form-group-->
      <div class="form-group">
      <label class="col-sm-3"><?php echo $entry_status; ?></label>
      <div class="col-sm-9">
      <select name="status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_processed; ?></option>
                <option value="0"><?php echo $text_waiting; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_processed; ?></option>
                <option value="0" selected="selected"><?php echo $text_waiting; ?></option>
                <?php } ?>
              </select>
      </div>
      </div><!-- //form-group-->
      <div class="form-group">
      <label class="col-sm-3"><?php echo $entry_read; ?></label>
      <div class="col-sm-9">
      
              <?php if ($read == 0) { ?>
              <input type="radio" name="read" value="0" checked /><?php echo $text_unread;?>
              <?php } else { ?>
              <input type="radio" name="read" value="0" /><?php echo $text_unread;?>
              <?php } ?>&nbsp;
              <?php if ($read == 1) { ?>
              <input type="radio" name="read" value="1" checked /> <?php echo $text_read;?> 
              <?php } else { ?>
              <input type="radio" name="read" value="1" /><?php echo $text_read;?>
              <?php } ?>
      </div>
      </div><!-- //form-group-->
      
      
      </div><!--//col -->
      
      <div class="col-sm-6">
      <h2><?php echo $text_h2_service;?></h2>
      <div class="form-group">
      <label class="col-sm-3"><?php echo $entry_service; ?></label>
      <div class="col-sm-9">
      		<div class="autosuggest">
                <div class="autosuggest_heading">
                <input type="text" name="filter_service" value="" class="form-control"/>
                </div>
                <div class="autosuggest_content" id="services">            
                </div>
                <div id="service_selection" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($service_selections as $service_selection) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="service_selection<?php echo $service_selection['service_id']; ?>" class="<?php echo $class; ?>"><?php echo $service_selection['name']; ?><img src="../assets/theme/img/delete.png" alt="" onclick="$(this).parent().remove();"/>
                    <input type="hidden" name="service_selection[]" value="<?php echo $service_selection['service_id']; ?>" />
                  </div>
                  <?php } ?>
                </div>
                </div>
      </div>
      </div><!-- //form-group-->
            <div class="form-group">
      <label class="col-sm-3"><?php echo $entry_budget; ?></label>
      <div class="col-sm-9"><select name="budget" class="form-control">
                     <?php if (!empty($budgets)) { ?>  
                         <?php foreach ($budgets as $bud) { ?>      
                                 <?php if ($bud['value'] == $budget) { ?>
                                <option value="<?php echo $bud['value']; ?>" selected="selected"><?php echo $bud['label']; ?></option>
                                 <?php } else { ?>                                    
                                <option value="<?php echo $bud['value']; ?>"><?php echo $bud['label']; ?></option>     
                                <?php } ?>  
                          <?php } ?>
                      <?php } ?>
	        </select>
      </div>
      </div><!-- //form-group-->
            <div class="form-group">
      <label class="col-sm-3"><?php echo $text_h2_request; ?></label>
      <div class="col-sm-9">
      <textarea name="message" style="width:100%; height:200px; resize:none;" rows="10" class="form-control"><?php echo $message; ?></textarea>
              <?php if ($error_message) { ?><br> 
              <span class="text-danger"><?php echo $error_message; ?></span>
              <?php } ?>
      </div>
      </div><!-- //form-group-->
      </div><!--//col --> 
      
      </div><!--//row --> 
          
          
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
// Services
$('input[name=\'filter_service\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=ave/service/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(data) {		
					var from='services';
					var to='service_selection';
					
					$('#'+from+' div').remove();		
					for (i = 0; i < data.length; i++) {
						var value=data[i]['service_id'] ;
						var name=data[i]['name'] ;
						$("#"+from).append('<div id="div'+from+value+'"><input data-name="service_selection[]" type="hidden" value="' + value + '"/>' + name +'<img src="../assets/theme/img/add.png" onclick="Plus.addObject(\''+from+'\',\''+to+'\',\''+value+'\')" title="Add"/></div>');										
						$('#'+from+' div:odd').attr('class', 'even');
						$('#'+from+' div:even').attr('class', 'odd');	
						
					}
			}
		});
		
	}
});

$('#service_selection div img').live('click', function() {
	$(this).parent().remove();
	
	$('#service_selection div:odd').attr('class', 'odd');
	$('#service_selection div:even').attr('class', 'even');	
});


//--></script> 
<script type="text/javascript"><!--
	$(document).ready(function() {	
		Plus.init();
	});
//--></script> 
<?php }?>
<?php echo $footer; ?>