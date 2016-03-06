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
      		<?php if($ave_status){?>
          <a href="<?php echo $clear_session;?>" class="btn btn-primary btn-sm"><span><i class="fa fa-undo"></i> <?php echo $text_clear_session; ?></span></a>
  	 <a onclick="$('#form').attr('action', '<?php echo $copy; ?>').submit();" class="btn green-meadow-bg btn-sm"><span><i class="fa fa-copy"></i> <?php echo $button_copy; ?></span></a>
          <a href="<?php echo $insert; ?>" class="btn btn-success btn-sm"><span><i class="fa fa-plus"></i> <?php echo $button_add; ?></span></a>
          <a onclick="$('#form').submit();" class="btn btn-danger btn-sm"><span><i class="fa fa-trash-o"></i> <?php echo $button_delete; ?></span></a>
          <?php } ?>
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
    
            <?php if($ave_status==false){?>
      <a href="#module-modal" data-toggle="modal" class="btn btn-<?php echo ($ave_status==true)?'primary':'danger';?> btn-sm pull-right"><i class="fa fa-gear"></i> <?php echo $text_register_license;?></a>
      
    <?php } ?>  
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    
     
       
            <?php if($ave_status==true){?>
          <div class="skinbox">
      <form action="<?php echo $import; ?>" method="post" enctype="multipart/form-data" id="import">
                          <div class="table-responsive">
        <table class="table table-bordered table-hover">
                 <tbody>
                    <tr>
                    <td><input type="file" name="import" /></td>  
                    <td><a onclick="$('#import').submit();" class="btn btn-primary btn-sm"><span><?php echo $button_import; ?></span></a></td>   
                    </tr>
                    </tbody>
                    </table>
</div>
      </form>
         </div>
    <?php } ?>      
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
        
        <a href="#module-modal" data-toggle="modal" class="btn btn-<?php echo ($ave_status==true)?'primary':'danger';?> btn-sm pull-right"><i class="fa fa-gear"></i> <?php echo ($ave_status==1)?$text_settings:$text_register_license;?></a>
      </div>
      <div class="panel-body">
      <form action="<?php echo $delete_selected; ?>" method="post" enctype="multipart/form-data" id="form">
      
              <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr> 
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
              <td width="1" style="text-align: center;"></td>
             
              
               <td class="left">
                <a href="<?php echo $sort_name; ?>" <?php if ($sort == 'skin_name') { ?>class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_name; ?></a>
                </td>
              <td class="left"></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($skins) { ?>
            <?php foreach ($skins as $skin) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($skin['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $skin['skin_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $skin['skin_id']; ?>" />
                <?php } ?></td>
              <td class="left"><div class="img-thumbnail small"><div style="background-color:<?php echo $skin['color']; ?>"> &nbsp;&nbsp; </div></div></td>
              <td class="left"><?php echo $skin['skin_name']; ?><br/><span style="color:#ddd;"><?php echo $skin['date_added']; ?></span></td>
            <td class="right">
            <?php if($ave_status){?>
            <div class="buttons">              
              <a class="btn btn-primary btn-xs <?php echo $skin['export']['class']; ?>" href="<?php echo $skin['export']['href']; ?>"><?php echo $skin['export']['text']; ?></a>
             </div>
              <?php } ?>
              </td>
              <td class="left">
            	<?php
                 foreach ($skin['store_actions'] as $store_action) { ?>
                 <div class="clearfix">
                 <?php echo $store_action['name']; ?>
              <div class="buttons pull-right">
              <?php if(!empty($store_action['active'])){?>
              <a href="<?php echo $store_action['active']; ?>" class="btn blue-bg btn-xs"><i class="fa fa-bolt"></i> <?php echo $text_active;?></a>
              <?php } else{?>
              <a class="btn green-bg btn-xs"><i class="fa fa-check"></i> <?php echo $text_being_active;?></a>
              <?php } ?>
              <a class="btn blue-bg btn-xs modalbox" data-type="iframe" data-sandbox="true" href="<?php echo $store_action['preview']; ?>" data-size="modal-fw" data-backdrop="true" title="<?php echo $text_preview;?>"><i class="fa fa-search"></i> <?php echo $text_preview; ?></a>
              <a class="btn blue-bg btn-xs" data-type="iframe" href="<?php echo $store_action['edit']; ?>" data-toggle="tooltip" title="<?php echo $text_edit;?>"><i class="fa fa-edit"></i> <?php echo $text_edit; ?></a>
              </div>
              </div> <br> 
              <?php } ?>
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
		<div class="row margin-bottom-10">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
        
      </div>
    </div>
  </div>
</div>

<div id="module-modal" class="modal-box modal fade">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>         
            	<h4 class="modal-title">&nbsp;   <a onclick="$('#form-setting').submit();$('#module-modal').modal('hide');" class="btn btn-primary btn-xs pull-right"><span><i class="fa fa-save"></i> <?php echo $button_save; ?></span></a></h4>
            </div>
            <div class="modal-body modal-html">
             <div class="container-fluid " style="padding-bottom:50px;">
      <form action="<?php echo $modal_action; ?>" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">
             
             <div class="alert alert-info"><?php echo $text_about_general_setting;?></div>
           
       <ul class="nav nav-tabs margin-bottom-10">
                    <li class="active"> <a href="#advance_license" data-toggle="tab"><?php echo $text_license;?></a></li>
                    
            
                    <li class=""> <a href="#advance_developer" data-toggle="tab"><?php echo $text_developer_otp;?></a> </li>
                    <li class=""> <a href="#advance_bonus" data-toggle="tab"><?php echo $text_optimization;?></a></li>
       </ul> 
            <div class="tab-content clearfix">
             <div id="advance_license" class="tab-pane active">
       			 <h4><?php echo $text_license;?> <span id="license_info"></span>  </h4>
                      <div class="form-group">
                    <label class="col-sm-4 control-label" for=""><?php echo $text_license_key;?></label>
                    <div class="col-sm-8">
                    <input type="text" name="skin_lic_key" id="skin_lic_key" class="license_field form-control" value="<?php echo $skin_lic_key;?>">
                     </div>
              </div><!-- form-group--> 
              
                   <div class="clearfix register_message"><div class="alert alert-success"><?php echo (!empty($skin_lic_message))?html_entity_decode($skin_lic_message, ENT_QUOTES, 'UTF-8'):'';?></div></div>
                    
                    
                   <ul class="nav nav-tabs nav-justified" style="margin:20px auto;">
                    <li class="active"><a href="#tab_register" data-toggle="tab"><?php echo $text_about_register;?></a></li>
                    <li><a href="#tab_license" data-toggle="tab"><?php echo $text_about_license;?></a></li>
                    </ul>
                   <div class="tab-content clearfix">
                    <div class="tab-pane active" id="tab_register">
                     <div class="row">
                    <label class="control-label"><strong><?php echo $text_purchase_code;?></strong></label>
                        <div class="clearfix" style="margin:15px auto;"> 
                        <div class="input-group">
                    <input type="hidden" id="skin_lic_message" name="skin_lic_message" class="form-control" value="<?php echo $skin_lic_message;?>">
                    <input type="hidden" id="skin_config_domain" name="skin_config_domain" class="form-control" value="<?php echo $skin_config_domain;?>">
                    <input type="hidden" id="skin_config_email" name="skin_config_email" class="form-control" value="<?php echo $skin_config_email;?>">
                    <input type="text" id="skin_purchase_code" name="skin_purchase_code" class="form-control" value="<?php echo $skin_purchase_code;?>">
                     <a onclick="registerLicense();" class="input-group-addon btn btn-primary" style="width:80px;"><?php echo $button_register;?></a>
                    </div>
                     </div>
                     </div><!--//row --> 
                    
                    
                    <?php echo $help_register;?></div>
                    <div class="tab-pane" id="tab_license"><?php echo $help_license;?></div>
                    </div>
                    <div class="margin-bottom-20">
                      <a href="http://www.avethemes.com/index.php?route=support/license" class="btn btn-xs btn-success" target="_blank" style="margin-top:15px"><i class="fa fa-key"></i> <?php echo $text_request_license;?></a>
                       <a href="http://www.avethemes.com" class="btn btn-xs btn-success" target="_blank" style="margin-top:15px">Documentation</a>
                    </div>
               		
            
    </div><!--//tab-panel --> 
                    <div class="tab-pane" id="advance_developer">
                    
		
			<div class="form-group">
                    <label class="col-sm-4 control-label" for=""><?php echo $text_frontend_cp;?></label>
                    <div class="col-sm-8">
                    <select name="skin_cp_enabled" class="form-control tr_change with-nav" onchange="Plus.activeObj('frontend_cp',this.options[this.selectedIndex].value);">
                        <option value="1" <?php echo ($skin_cp_enabled==1)?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                        <option value="0" <?php echo ($skin_cp_enabled==0)?'selected="selected"':'';?>><?php echo $text_disabled;?></option>
                        </select>
                     </div>
              </div><!-- form-group--> 
			<div class="form-group frontend_cp otp-1">
                    <label class="col-sm-4 control-label" for=""><?php echo $text_user;?></label>
                    <div class="col-sm-8">
                    <select name="skin_cp_user" class="form-control with-nav">
                        <option value="1" <?php echo ($skin_cp_user==1)?'selected="selected"':'';?>><?php echo $text_admin_only;?></option>
                        <option value="0" <?php echo ($skin_cp_user==0)?'selected="selected"':'';?>><?php echo $text_all;?></option>
                        </select>
                     </div>
              </div><!-- form-group--> 
			<div class="form-group frontend_cp otp-1">
                    <label class="col-sm-4 control-label" for=""><?php echo $text_admin_dir;?></label>
                    <div class="col-sm-8"><input type="text" name="skin_admin_dir" value="<?php echo $skin_admin_dir;?>" class="form-control"/>
                     </div>
              </div><!-- form-group--> 
              
              <div class="form-group frontend_cp otp-1">
                    <label class="col-sm-4 control-label" for=""><?php echo $text_admin_path;?></label>
                    <div class="col-sm-8"><input type="text" name="skin_admin_path" value="<?php echo $skin_admin_path;?>" class="form-control"/>
                     </div>
              </div><!-- form-group--> 
                    <div class="form-group frontend_cp otp-1">
                    <label class="col-sm-4 control-label" for=""><?php echo $text_db_query;?></label>
                    <div class="col-sm-8">
                    <select name="skin_query_details" class="form-control">
                        <option value="1" <?php echo ($skin_query_details=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                        <option value="0" <?php echo ($skin_query_details=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option>
                        </select>
                     </div>
              </div><!-- form-group--> 
                  
        </div><!-- //tab pane--> 
        <div class="tab-pane" id="advance_bonus">
                <div class="form-group">
                    <label class="col-sm-4 control-label" for=""><?php echo $text_internal_link;?></label>
                    <div class="col-sm-8">
                    <select name="skin_internal_link" class="form-control">
                        <option value="1" <?php echo ($skin_internal_link=='1')?'selected="selected"':'';?>><?php echo $text_relative_url;?></option>
                        <option value="0" <?php echo ($skin_internal_link=='0')?'selected="selected"':'';?>><?php echo $text_absolute_url;?></option></select>
                     </div>
              </div><!-- form-group--> 
                <div class="form-group">
                    <label class="col-sm-4 control-label" for=""><?php echo $text_minify_html;?></label>
                    <div class="col-sm-8">
                    <select name="skin_compression_html" class="form-control tr_change" onchange="Plus.activeObj('skin_compression_html',this.options[this.selectedIndex].value);">
                        <option value="1" <?php echo ($skin_compression_html=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                        <option value="0" <?php echo ($skin_compression_html=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option></select>
                     </div>
              </div><!-- form-group--> 
                  
              <div class="form-group skin_compression_html otp-0">
                    <label class="col-sm-4 control-label" for=""><?php echo $text_skin_remove_comment;?></label>
                    <div class="col-sm-8">
                    <select name="skin_remove_comment" class="form-control">
                        <option value="1" <?php echo ($skin_remove_comment=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                        <option value="0" <?php echo ($skin_remove_comment=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option></select>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-4 control-label" for=""><?php echo $text_put_javascript;?></label>
                    <div class="col-sm-8">
                    
                    <select name="skin_put_js_bottom" class="form-control">
                        <option value="1" <?php echo ($skin_put_js_bottom=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                        <option value="0" <?php echo ($skin_put_js_bottom=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option></select>
                     </div>
              </div><!-- form-group--> 
<div class="form-group">
                    <label class="col-sm-4 control-label" for=""><?php echo $text_minify;?></label>
                    <div class="col-sm-8">
                    <select name="skin_minify_code" id="skin_minify_code" class="form-control tr_change" onchange="Plus.activeObj('skin_minify_code',this.options[this.selectedIndex].value);">
                        <option value="1" <?php echo ($skin_minify_code=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                        <option value="0" <?php echo ($skin_minify_code=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option></select>
                        
                     </div>
              </div><!-- form-group--> 
 		
     <div class="margin-bottom-20">
                      <a href="http://validator.w3.org/check?uri=<?php echo $store_url;?>" class="btn btn-xs btn-success" target="_blank" style="margin-top:15px"><i class="fa fa-check"></i> W3C Validate</a>
                       <a href="https://developers.google.com/speed/pagespeed/insights/?url=<?php echo $store_url;?>" class="btn btn-xs btn-success" target="_blank" style="margin-top:15px"><i class="fa fa-tachometer"></i> Check page speed</a>
                    </div>      
        </div><!-- //tab pane--> 
       
    </div><!--//tab-content --> 
      </form> 
      </div><!--/container-fluid --> 
            </div>
        </div>
      </div>
</div><!--//general-setting -->
<script type="text/javascript">
	$(document).ready(function() {	
		Plus.init();
	});
	
  	function registerLicense() {
			var regdomain = '//www.avethemes.com/';
			var rdomain =$('#skin_config_domain').val();
			var remail =$('#skin_config_email').val();
			var purchase_code =$('#skin_purchase_code').val();
			$.ajax({
				url: regdomain+'index.php?route=support/license/api',
				type: 'post',
				dataType: 'json',
				data: 'domain=' + rdomain +'&email=' + remail +'&purchase_code=' + purchase_code,
				beforeSend: function() {
					$('.register_message alert').fadeOut(350);
				},
				success: function(json) {	
						if (json['error']) {
							$('.register_message').html('<div class="alert alert-danger" style="display:none;"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							$('.register_message .alert').fadeIn(350);
						} 
						if (json['success']) {	
							$('.register_message').html('<div class="alert alert-success" style="display:none;"><i class="fa fa-check-circle"></i> ' + json['text_message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							
							$('#skin_lic_message').val(json['success']);
							$('#skin_lic_key').val(json['license']);
							$('.register_message .alert').fadeIn(350);
						}
				}
			});
   }
</script>
<?php echo $footer; ?>