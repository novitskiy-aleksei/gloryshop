<?php echo $header; echo $column_left;?>
<div id="content">
    <div class="page-header">
    <div class="container-fluid">
    <div>   
     <?php echo $shortcut_group;?>
      </div>
    </div>
        <div class="container-fluid">
            <div class="pull-right">

                <a class="btn btn-primary" id="saveform" onclick="$('#formcustomfooter').submit();">
                    <?php echo $button_save;?>
                </a>
               
            </div>
            <h1><?php echo $heading_title;?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li>
                    <a href="<?php echo $breadcrumb['href'];?>">
                        <?php echo $breadcrumb[ 'text'];?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <!-- End div#page-header -->


    <div id="page-content" class="container-fluid">
        <div class="message">
            <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
                <?php echo $error_warning;?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
            <?php if (isset($success) && !empty($success)) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                <?php echo $success;?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>
        </div>
        <?php if($rstatus){?>
      <form action="<?php echo $import_setting; ?>" method="post" enctype="multipart/form-data" id="import">
      		<input type="hidden" value="<?php echo $redirect;?>" name="redirect" />
                          <div>
        <table class="table table-bordered table-hover">
                 <tbody>
                    <tr>
                    <td><input type="file" name="import" /></td>  
                    <td>
    <a href="<?php echo $export_setting;?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Export this module data"><span><i class="fa fa-download"></i></span></a>
    <a onclick="$('#import').submit();" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> <span>Import Backup data</span></a>
                    </td>   
                    </tr>
                    </tbody>
                    </table>
</div>
      </form>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title;?></h3> <span></span>
            </div>
            <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="formcustomfooter">
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="form-group row">
                            <label class="col-sm-2 control-label" for="input-status">
                                <?php echo $entry_status;?>
                            </label>
                            <div class="col-sm-10">
                                <select name="ave_custom_footer_status" id="input-status" class="form-control no-width">
                                    <option value="1" <?php if ($ave_custom_footer_status) { ?>selected="selected"<?php } ?>>
                                        <?php echo $text_enabled;?>
                                    </option>
                                    <option value="0" <?php if (!$ave_custom_footer_status) { ?>selected="selected"<?php } ?>>
                                        <?php echo $text_disabled;?>
                                    </option>
                                </select>
                                <br>
                            </div>
                        </div>
                        <div class="module-class form-group row">
                            <label class="col-sm-2">
                                <?php echo $text_module_class;?>
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" name="ave_custom_footer_class" value="<?php echo $ave_custom_footer_class;?>">
                            </div>
                        </div>

                        <hr>
                        <div class="row module-group">
                        <!-- --> 
                         <div class="col-md-3 col-sm-5 col-xs-0">
                          <div class="block_relative">
                           <div class="heading-bar">
          <?php echo $text_module_list;?>
          </div>
<div id="module_list" class="module_accordion ds_accordion">
                        
                        <?php foreach ($extensions as $extension) { ?>
                        <div class="ds_heading">
                            <?php echo strip_tags($extension[ 'name']);?>
                              <div class="btn-group">
                
                <a class="btn btn-xs btn-edit" data-href="<?php echo $extension['edit'];?>" data-type="iframe" data-title="<?php echo strip_tags($extension['name']);?>" data-toggle="tooltip" title="<?php echo $text_edit;?>"><i class="fa fa-edit"></i></a>
                
                
                </div>
                
                        </div>
                        <div class="ds_content drag_area">
                            <?php foreach ($extension['module'] as $emod) { ?>
                            <div class="module-block add-mod" data-code="<?php echo $emod['code'];?>" data-type="module" data-name="<?php echo $emod['name'];?>" <?php echo ($emod['thumb'])?'data-thumb="'.$emod['thumb'].'"':''; ?>>
                                <div class="module_label">
                                    <?php echo $extension[ 'name'];?>
                                </div>
                                <div class="btn-group">
                                    <a title="<?php echo $text_edit;?>" data-href="<?php echo $emod['edit'];?>" data-code="<?php echo $emod['code'];?>" data-placement="top" data-toggle="tooltip" class="btn btn-edit"><i class="fa fa-edit"></i> <?php echo $emod['name'];?></a>
                                    <a title="<?php echo $text_delete;?>" data-placement="top" data-toggle="tooltip" class="btn btn-remove"><i class="fa fa-trash-o"></i></a>
                                </div>
                                <!-- btn-group-->
                            </div>
                            <!-- /module-block-->
                            <?php } ?>
                        </div>
                        <!-- /ds_content-->
                        <?php } ?>

                    </div> <!-- //module_accordion -->

                          </div><!--//block_relative --> 
                          </div><!--//col-md-3 --> 
                         <div class="col-md-9 col-sm-7 col-xs-12">
                           <div class="row margin-bottom-15">
                                <div class="col-md-9"> Design In
                                    <div class="btn-group button-alignments">
                                        <button class="btn btn-default active " data-option="large-screen" data-size="col-lg-" type="button" data-toggle="tooltip" data-placement="top" title="Large Devices, Wide Screens"><span class="fa fa-desktop"></span>
                                        </button>
                                        <button class="btn btn-default " data-option="medium-screen" data-size="col-md-" type="button" data-toggle="tooltip" data-placement="top" title="Medium Devices, Desktops"><span class="fa fa-laptop"></span>
                                        </button>
                                        <button class="btn btn-default " data-option="tablet-screen" data-size="col-sm-" type="button" data-toggle="tooltip" data-placement="top" title="Small Devices, Tablets"> <span class="fa fa-tablet"></span>
                                        </button>
                                        <button class="btn btn-default " data-option="mobile-screen" data-size="col-xs-" type="button" data-toggle="tooltip" data-placement="top" title="Extra Small Devices, Phones"><span class="fa fa-mobile"></span> </button>
                                    </div>
                                </div>
                                <div class="col-md-3 pull-right">
                                    <a class="add-row btn btn-primary btn-xs pull-right"><i class="fa fa-plus"></i> <?php echo $text_add_row;?></a>
                                </div>
                            </div>
                         	<div id="screen-mod" class="col-lg-">
                                <div class="footer-builder-wrapper">
                                    <div id="footer-builder" class="footer-builder"></div>
                                    <div>
                                        <textarea name="ave_custom_footer_layout" class="hidden-content-layout hide" cols="30" rows="6"><?php echo (!empty($ave_custom_footer_layout))?$ave_custom_footer_layout:'';?></textarea>
                                    </div>
                                </div>
                            </div>
                          </div><!--//col-md-9 --> 
                          
                        </div>


                    </div>

                </div>
                <!-- End div .panel-body -->
            </form>
        </div>
    </div>
    <!-- End div#page-content -->

</div>
<!-- End div#content -->


<div id="modallistmodules" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Modules
		            	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></h4>
            </div>
            <div class="modal-body clearfix">
                <div id="listmods">
                
                    <div class="module_accordion ds_accordion">
                        <?php foreach ($extensions as $extension) { ?>
                        <div class="ds_heading">
                            <?php echo strip_tags($extension['name']);?>
                        </div>
                        <div class="ds_content drag_area">
                            <?php foreach ($extension[ 'module'] as $emod) { ?>
                            <div class="module-block add-mod" data-code="<?php echo $emod['code'];?>" data-type="module" data-name="<?php echo $emod['name'];?>">
                                <div class="module_label">
                                    <?php echo $extension[ 'name'];?>
                                </div>
                                <div class="btn-group">
                                    <a title="<?php echo $text_edit;?>" data-href="<?php echo $emod['edit'];?>" data-code="<?php echo $emod['code'];?>" data-placement="top" data-toggle="tooltip" class="btn btn-edit"><i class="fa fa-edit"></i> <?php echo $emod['name'];?></a>
                                    <a title="<?php echo $text_delete;?>" data-placement="top" data-toggle="tooltip" class="btn btn-remove"><i class="fa fa-trash-o"></i></a>
                                </div>
                                <!-- btn-group-->
                            </div>
                            <!-- /module-block-->
                            <?php } ?>
                        </div>
                        <!-- /ds_content-->
                        <?php } ?>

                    </div> <!-- //module_accordion -->
                </div>

            </div>
        </div>
    </div>
</div><!-- //modallistmodules--> 
<div id="row-builder"  class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
            <div class="modal-header">
            	<h4>Column Setting  
            	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
           <div class="modal-body clearfix">
           <form action="" name="frmcol">
	                <div class="row-form ">
	                   <div class="inpt-setting">
	                      <label>Addition Class
	                         <input class="form-control" type="text" name="clss" />
	                      </label>
	                    </div>
	                   <div class="inpt-setting">
	                              <button type="submit" class="btn btn-sm btn-primary">Save</button>     
	                            </div>
	                </div>
	              
	            </form>
                </div>
       </div>
    </div>
</div>
<script type="text/javascript">
/* */
$(document).ready( function(){
  CustomLayout.init("#footer-builder");
		Plus.init();
});
$(document).on('click', '.btn-edit', function(event) {
		event.preventDefault();
		$('#modal-editmodule').remove();
		var data_href = $(this).attr('data-href');
 			var button = '<button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
 			var html  = '<iframe id="ifmeditmodule" src="'+data_href+'" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe>';
 			var content ='<div class="modal-dialog"><div class="modal-content"><div class="modal-header">&nbsp;'+button+'</div><div class="modal-body">'+html+'</div></div></div>';
 			$('body').append('<div id="modal-editmodule" class="modal">' + content + '</div>');
 		
            var iframe = $('#ifmeditmodule');
 			iframe.load( function(){
		 		$('#modal-editmodule').modal('show');
            	var current_url = document.getElementById("ifmeditmodule").contentWindow.location.href;
                iframe.contents().find('#header,#content .page-header .breadcrumb,#column-left,#footer').hide();
                iframe.contents().find('#content').css({ padding: '10px 0 0 0',margin: '0 0 0 0'});
				if (current_url.indexOf('extension/module') > -1) {
					$('#modal-editmodule').modal('hide');               
				}
 			});
});/**/
/* */
</script>