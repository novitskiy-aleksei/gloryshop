<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>
<input type="hidden" name="skin_name" value="<?php echo $skin_name;?>"/>
<input type="hidden" name="color" value="<?php echo $color;?>"/>

  <a onclick="MCP.switchView('editor-size-sm');" data-group="general_group" data-action="general_footer" class="modal-form btn btn-block btn-info margin-bottom-15" data-title="<?php echo $text_header;?>"><i class="fa fa-chevron-left"></i>  <?php echo $text_back;?></a>
<div class="container-fluid clearfix">
      <div id="formcustomfooter">
                          <div class="block_relative">
                          <div class="module_list">
                           <div class="heading-bar"><?php echo $text_module_list;?></div>
<div class="module_accordion ds_accordion drag_area">
                       
              <?php foreach ($extensions as $extension) { ?>
                        <div class="ds_heading">
                            <?php echo strip_tags($extension[ 'name']);?>
                              <div class="btn-group">
                
                <a class="btn btn-xs btn-edit" data-href="<?php echo $extension['edit'].'&token='.$token;?>" data-type="iframe" data-title="<?php echo strip_tags($extension['name']);?>" data-toggle="tooltip" title="<?php echo $text_edit." - ".strip_tags($extension['name']);?>"><i class="fa fa-edit"></i></a>
                
                
                </div>
                
                        </div>
                        <div class="ds_content">
                            <?php foreach ($extension[ 'module'] as $emod) { ?>
<div class="module-block add-mod" data-code="<?php echo $emod['code'];?>" data-type="module" data-name="<?php echo $emod['name'];?>">
                                <div class="module_label"><?php echo $emod['title'];?></div>
                                <div class="btn-group">
                                    <a title="<?php echo $text_edit." - ".$emod['name'];?>" data-href="<?php echo $emod['edit'].'&token='.$token;?>" data-code="<?php echo $emod['code'];?>" data-type="iframe" data-title="<?php echo $emod['name'];?>"  data-placement="top" data-toggle="tooltip" class="btn btn-edit"><i class="fa fa-edit"></i> <?php echo $emod['name'];?></a>
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

                          </div><!--//class module_list --> 
                          </div><!--//block_relative --> 
                         <div id="css-layout-margin" class="layout_modules">
      
<div class="form-group">                
      <div class="row">
            <label class="col-sm-4 control-label"><?php echo $entry_status; ?></label>
                <div class="col-sm-8">
                    <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-xs btn-success <?php if($ave_custom_footer_status=='1'){ echo 'active tr_click';}?>">
                            <input type="radio" name="ave_custom_footer_status" value="1" <?php if($ave_custom_footer_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
                        <label class="btn btn-xs btn-info <?php if($ave_custom_footer_status=='0'){ echo 'active tr_click';}?>">
                            <input type="radio" name="ave_custom_footer_status" value="0" <?php if($ave_custom_footer_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
                    </div>
             </div>
      </div><!-- row-->    
      </div><!-- form-group-->    
                        <div class="form-group">
                            <label class="control-label"><?php echo $text_module_class;?></label>
                                <input class="form-control" name="ave_custom_footer_class" value="<?php echo $ave_custom_footer_class;?>">
                        </div>


                        <div class="form-group margin-top-10">
                            		<label class="control-label clearfix">Design In</label>
                                    <div class="btn-group button-alignments">
                                        <button class="btn btn-default active " data-option="large-screen" data-size="col-lg-" type="button" data-toggle="tooltip" data-placement="top" title="Large Devices, Wide Screens"><span class="fa fa-desktop"></span>
                                        </button>
                                        <button class="btn btn-default " data-option="medium-screen" data-size="col-md-" type="button" data-toggle="tooltip" data-placement="top" title="Medium Devices, Desktops"><span class="fa fa-laptop"></span>
                                        </button>
                                        <button class="btn btn-default " data-option="tablet-screen" data-size="col-sm-" type="button" data-toggle="tooltip" data-placement="top" title="Small Devices, Tablets"> <span class="fa fa-tablet"></span>
                                        </button>
                                        <button class="btn btn-default " data-option="mobile-screen" data-size="col-xs-" type="button" data-toggle="tooltip" data-placement="top" title="Extra Small Devices, Phones"><span class="fa fa-mobile"></span> </button>
                                    </div>
                                    <a class="add-row btn btn-primary btn-xs pull-right text-right"><i class="fa fa-plus"></i> <?php echo $text_add_row;?></a>
                            </div>
                         	<div id="screen-mod" class="col-lg-">
                                <div class="footer-builder-wrapper">
                                    <div id="footer-builder" class="footer-builder"></div>
                                    <div>
                                        <textarea name="ave_custom_footer_layout" class="hidden-content-layout hide" cols="30" rows="6"><?php echo (!empty($ave_custom_footer_layout))?$ave_custom_footer_layout:'';?></textarea>
                                    </div>
                                </div>
                            </div>
                          </div><!--//layout_modules--> 
</div><!-- //formcustomfooter--> 
               
</div> <!-- End container-fluid -->

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
                        <div class="ds_heading"><?php echo strip_tags($extension[ 'name']);?></div>
                        <div class="ds_content drag_area">
                            <?php foreach ($extension['module'] as $emod) { ?>
<div class="module-block add-mod" data-code="<?php echo $emod['code'];?>" data-type="module" data-name="<?php echo $emod['name'];?>"><div class="module_label"><?php echo $emod['title'];?></div>
                                <div class="btn-group">
                                    <a title="<?php echo $text_edit;?>" data-href="<?php echo $emod['edit'].'&token='.$token;?>" data-code="<?php echo $emod['code'];?>" data-placement="top" data-toggle="tooltip" class="btn btn-edit"><i class="fa fa-edit"></i> <?php echo $emod['name'];?></a>
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
	                      <label>Addition Class<input class="form-control" type="text" name="clss" /></label>
	                    </div>
	                   <div class="inpt-setting">
	                              <button type="submit" class="btn btn-sm btn-primary">Save</button>     
	                            </div>
	                </div>
	              
	            </form>
                </div>
       </div>
    </div>
</div><!--//row-builder modal--> 

</div>  <!--layout-setting -->    