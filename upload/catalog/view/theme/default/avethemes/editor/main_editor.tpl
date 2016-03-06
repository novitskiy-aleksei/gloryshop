<?php 
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>
<!-- BEGIN QUICK SIDEBAR -->
<div id="design_editor" data-skin-id="<?php echo $skin_active_id;?>">
<a class="design_content-toggler"><i class="fa fa-cogs"></i></a> 
<div id="design_cp_form" class="clearfix">
    <div id="design_bar" class="design_content-wrapper lite-shadow" data-skin-id="<?php echo $skin_active_id;?>">
        <div class="design_content-inner">
        <div class="design_header">
                  
        <ul class="nav">
        <!--//General-->
<li> <a onclick="MCP.apply(0);" class="btn btn-xs" data-toggle="tooltip" title="<?php echo $button_apply;?>"><i class="fa fa-bolt"></i></a> </li>             
 <li> <a class="btn btn-xs reversedbar" onclick="MCP.reversedDesignBar('bar_right');" data-toggle="tooltip" title="<?php echo $text_reverse;?>"><i class="fa fa-exchange"></i> </a></li>
      
<li>  <a data-group="general_group" data-action="advance_dev" class="modal-form" data-tooltip="right"  data-title="<?php echo $text_developer_otp;?>" title="<?php echo $text_developer_otp;?>">
                                <i class="fa fa-icon fa-cog"></i> <span class="hidden-xs hidden-sm"><?php echo $text_developer_otp;?></span>
                            </a></li>  
                             </ul>
       
        <div class="size_btn">
        <div class="pull-right margin-right-20">
                <button id="button-apply" type="button" onclick="MCP.apply(1);" class="btn btn-sm btn-primary">
                    <i class="fa fa-save"></i>  <?php echo $button_save;?>
                </button>
         <a onclick="MCP.switchView('editor-size-sm');" data-toggle="tooltip" title="<?php echo $text_small_editor;?>" class="btn btn-xs sizesm">
                                    <i class="fa fa-mobile"></i>
                                </a>
                          
                                <a onclick="MCP.switchView('editor-size-lg');" data-toggle="tooltip" title="<?php echo $text_large_editor;?>" class="btn btn-xs sizelg">
                                    <i class="fa fa-desktop"></i>
                                </a>
                                </div>
                             
        </div>
            
        </div>
             
     <div class="design_title"> 
        <div class="form-group">
           <div class="active_section" id="active_section"><?php echo $action_title;?></div>
        </div><!-- //form-group-->      
        </div><!-- //editor-title-->       
      <div class="design_loader"></div>  <!-- -->  
     <nav id="editor-left">
     <ul id="editor-menu">
         <li class="dropdown active">
                            <ul>
                                <li>
                                    <a id="general_href" data-action="general" class="modal-form" data-title="<?php echo $text_general;?>">
                                    <i class="fa fa-globe"></i><span><?php echo $text_general;?></span></a></li>  
                               
                            <li>
                                <a data-action="general_header" class="modal-form" data-title="<?php echo $text_header;?>"><i class="fa fa-list-alt"></i><span><?php echo $text_header;?></span></a></li>
                            <li>
                                <a data-action="general_footer" class="modal-form" data-title="<?php echo $text_footer;?>"><i class="fa fa-th"></i><span><?php echo $text_footer;?></span></a></li>
                             <li><a onclick="MCP.switchView('editor-size-lg');" data-action="layout_assign" class="modal-form" data-title="<?php echo $text_page_layout;?>"><i class="fa fa-sliders"></i><span><?php echo $text_page_layout;?></span></a></li>
                              
                              
 <li> <a onclick="MCP.switchView('editor-size-sm');" data-action="product_general" class="modal-form" data-title="<?php echo $text_product_general_setting;?>"><i class="fa fa-globe"></i><span><?php echo $text_product_general_setting;?></span></a></li>
 <li> <a onclick="MCP.switchView('editor-size-sm');" data-action="product_category" class="modal-form" data-title="<?php echo $text_category_setting;?>"><i class="fa fa-globe"></i><span><?php echo $text_category_setting;?></span></a></li>    
<li><a onclick="MCP.switchView('editor-size-sm');" data-action="code_text" class="modal-form" data-title="<?php echo $text_translate;?>"><i class="fa fa-font"></i><span><?php echo $text_translate;?></span></a></li>

          
                            </ul>
                        </li>             
                  
                       <li class="lbtn"> 
       <a data-toggle="modal" href="#modal-custom-css" class="btn btn-xs" data-tooltip="right" title="<?php echo $text_custom_css;?>"><i class="fa fa-file-text-o"></i></a>
       <a data-toggle="modal" href="#modal-custom-js" class="btn btn-xs" data-tooltip="right" title="<?php echo $text_custom_js;?>"><i class="fa fa-file-code-o"></i></a>
                       
                         </li><!----> 
        
                        
        </ul><!-- editor0manu--> 
     </nav>
     <div id="editor-content">
     
        <div class="design_content form-horizontal" data-distance="3px" data-height="450" data-rail-color="#00BFFF" >
        	<?php echo $default_section;?>
        </div>
        </div><!-- editor-content--> 
        			<input type="hidden" name="skin_name" value="<?php echo $skin_name; ?>"/>
         			<input type="hidden" name="skin_color" class="skin_color_scheme" value="<?php echo $skin_color;?>"/>
         			<input type="hidden" name="store_id" value="<?php echo $store_id;?>"/>
         			<input type="hidden" name="redirect" id="redirect" value="<?php echo $redirect;?>">
         			<input type="hidden" name="skin_id" id="skin_id" value="<?php echo $skin_id;?>">
                  <input type="hidden" name="skin_active_id" value="<?php echo $skin_active_id;?>"/>
                <input type="hidden" name="theme_setting[menu_sort]" readonly="readonly" value="<?php echo $menu_sort;?>"/>
                <input type="hidden" name="theme_setting[default_footer_sort]" readonly="readonly" value="<?php echo $default_footer_sort;?>"/>
       	 <div class="design_message message">
          <?php if ($error_message) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_message; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success_message) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success_message; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?> 
         </div>
        </div><!--design_content-inner -->
        
    </div><!--//design_bar -->
    
<div id="modal-custom-css" class="modal-box modal">
        <div class="modal-dialog modal-fw">
        <div class="modal-content">        
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?php echo $text_custom_css; ?>
                 <a onclick="MCP.apply(1);$('#modal-custom-css').modal('hide');" class="btn btn-xs btn-success pull-right"><i class="fa fa-bolt"></i> <?php echo $button_apply;?></a></h4>
            </div>
            <div class="modal-body">
                  <div class="form-group clearfix">
                  
                        <label class="col-sm-4 control-label"><?php echo $entry_status;?></label>
<div class="col-sm-8">

         <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success">
        <input type="radio" name="theme_setting[custom_css_status]" value="1" <?php if($custom_css_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info">
        <input type="radio" name="theme_setting[custom_css_status]" value="0" <?php if($custom_css_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>
                         </div>
             		</div><!-- form-group--> 
                  <div class="form-group">
                    <pre id="custom_css" style="width:94% !important; height:450px; font-size:1.1em; display:none;"><?php echo $custom_css;?></pre>
    				 <textarea name="theme_setting[custom_css]" id="custom_css_code" style="display:none"><?php echo $custom_css;?></textarea>
                  </div>
            </div>
        </div>
      </div>
</div>   <!--modal-custom-css -->  

<div id="modal-custom-js" class="modal-box modal">
        <div class="modal-dialog modal-fw">
        <div class="modal-content">        
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?php echo $text_custom_js; ?>
               <a onclick="MCP.apply(1);$('#modal-custom-js').modal('hide');" class="btn btn-xs btn-success pull-right"><i class="fa fa-bolt"></i> <?php echo $button_apply;?></a>
            </h4>
            </div>
            <div class="modal-body">
                <div class="form-group clearfix">
                        <label class="col-sm-4 control-label"><?php echo $entry_status;?></label>
<div class="col-sm-8">

         <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success">
        <input type="radio" name="theme_setting[custom_js_status]" value="1" <?php if($custom_js_status=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info">
        <input type="radio" name="theme_setting[custom_js_status]" value="0" <?php if($custom_js_status=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>
                              
                         </div>
                  </div><!-- form-group--> 
                  <div class="form-group">
                    <pre id="custom_js" style="width:94% !important; height:450px; font-size:1.1em; display:none;"><?php echo $custom_js;?></pre>
     				<textarea name="theme_setting[custom_js]" id="custom_js_code" style="display:none"><?php echo $custom_js;?></textarea>
                  </div>  
              </div>          
        </div>
      </div>
</div>   <!--modal-custom-js -->  
     
<div id="module-modal" class="modal-box modal <?php echo $skin_layout_builder_show_option;?>">
        <div class="modal-dialog modal-fw">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h4 class="modal-title">&nbsp;  </h4>
            </div>
            <div class="modal-body modal-iframe">
                <iframe id="modal-iframe" class="modal-iframe loading" frameborder="0" allowtransparency="true" seamless></iframe>
            </div>
        </div>
      </div>
</div><!--//module-modal --> 

<div id="module-popup" class="modal-box modal">
        <div class="modal-dialog modal-fw">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h4 class="modal-title">&nbsp;  </h4>
            </div>
            <div class="modal-body modal-iframe">
                <iframe id="modal-popup" class="modal-iframe loading" frameborder="0" allowtransparency="true" seamless></iframe>
            </div>
        </div>
      </div>
</div><!--//module-modal -->
<div id="system_performance" class="modal-box modal fade" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
						<div class="modal-header dark">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
						 <h4 class="modal-title"><?php echo $text_performance;?></h4>
						 </div>
						<div class="modal-body modal-html" id="performance_info"></div>
</div><!-- //modal-content--> 
</div><!-- //modal-dialog--> 
</div><!-- //system_performance--> 
    

</div><!-- /design_bar--> 
	<!-- End design menu -->
    </div><!--//design_editor--> 