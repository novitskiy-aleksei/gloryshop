<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>

<ul class="nav nav-tabs nav-justified margin-bottom-10">
                    <li class="active"> <a href="#advance_developer" data-toggle="tab"><?php echo $text_developer_otp;?></a> </li>
                    <li> <a href="#advance_bonus" data-toggle="tab"><?php echo $text_optimization;?></a></li>
                    <li> <a href="#advance_license" data-toggle="tab"><?php echo $text_license;?></a></li>
       </ul> 
<div class="container-fluid">
            <div class="tab-content clearfix">
                    <div class="tab-pane active" id="advance_developer">                    
		
        <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_frontend_cp; ?></label>
<div class="col-sm-12">

              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($skin_cp_enabled==1){ echo 'active tr_click';}?>" onclick="MCP.activeObj('frontend_cp',1);">
        <input type="radio" name="skin_cp_enabled" value="1" <?php if($skin_cp_enabled==1){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_cp_enabled==0){ echo 'active tr_click';}?>" onclick="MCP.activeObj('frontend_cp',0);">
        <input type="radio" name="skin_cp_enabled" value="0" <?php if($skin_cp_enabled==0){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
         
			<div class="form-group frontend_cp otp-1">
                    <label class="col-sm-12 control-label"><?php echo $text_db_query; ?>
                        <a onclick="MCP.viewPerformance()" data-toggle="tooltip" title="<?php echo $help_db_query;?>"><i class="fa fa-info-circle"></i></a></label>
<div class="col-sm-12">

              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($skin_query_details==1){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_query_details" value="1" <?php if($skin_query_details==1){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_query_details==0){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_query_details" value="0" <?php if($skin_query_details==0){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
                   
              
			<div class="form-group frontend_cp otp-1">
                    <label class="col-sm-12 control-label"><?php echo $text_frontend_cp_for; ?></label>
<div class="col-sm-12">

              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($skin_cp_user==1){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_cp_user" value="1" <?php if($skin_cp_user==1){ echo 'checked';}?>/><?php echo $text_admin_only;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_cp_user==0){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_cp_user" value="0" <?php if($skin_cp_user==0){ echo 'checked';}?>/><?php echo $text_all;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
             
              
			<div class="form-group frontend_cp otp-1">
                    <label class="col-sm-12 control-label"><?php echo $text_admin_dir;?></label>
<div class="col-sm-12"><input type="text" name="skin_admin_dir" value="<?php echo $skin_admin_dir;?>" class="form-control"/>
                     </div>
              </div><!-- form-group--> 
              
              <div class="form-group frontend_cp otp-1">
                    <label class="col-sm-12 control-label"><?php echo $text_admin_path;?></label>
<div class="col-sm-12"><input type="text" name="skin_admin_path" value="<?php echo $skin_admin_path;?>" class="form-control"/>
                     </div>
              </div><!-- form-group--> 
                   
                   
        </div><!-- //tab pane--> 
        <div class="tab-pane" id="advance_bonus">
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_internal_link;?></label>
<div class="col-sm-12">
              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
              
        
    <label class="btn btn-xs btn-success <?php if($skin_internal_link==1){ echo 'active tr_click';}?>" data-toggle="tooltip" title="<?php echo $help_relative_url;?>">
        <input type="radio" name="skin_internal_link" value="1" <?php if($skin_internal_link==1){ echo 'checked';}?>/><?php echo $text_relative;?>
        </label>
    <label class="btn btn-xs btn-info <?php if($skin_internal_link==0){ echo 'active tr_click';}?>" data-toggle="tooltip" title="<?php echo $help_absolute_url;?>">
        <input type="radio" name="skin_internal_link" value="0" <?php if($skin_internal_link==0){ echo 'checked';}?>/><?php echo $text_absolute;?> (<?php echo $text_default;?>)
        </label>
</div>
                     </div>
              </div><!-- form-group--> 
              
              
              
              
              <div class="form-group">
                   <label class="col-sm-12 control-label"><?php echo $text_minify_html; ?></label>
<div class="col-sm-12">

              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($skin_compression_html==1){ echo 'active tr_click';}?>" onclick="MCP.activeObj('skin_compression_html',1);">
        <input type="radio" name="skin_compression_html" value="1" <?php if($skin_compression_html==1){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_compression_html==0){ echo 'active tr_click';}?>" onclick="MCP.activeObj('skin_compression_html',0);">
        <input type="radio" name="skin_compression_html" value="0" <?php if($skin_compression_html==0){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
               
                  
              <div class="form-group skin_compression_html otp-0">
                    <label class="col-sm-12 control-label"><?php echo $text_skin_remove_comment;?></label>
                    
<div class="col-sm-12">

              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($skin_remove_comment==1){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_remove_comment" value="1" <?php if($skin_remove_comment==1){ echo 'checked';}?>/><?php echo $text_yes;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_remove_comment==0){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_remove_comment" value="0" <?php if($skin_remove_comment==0){ echo 'checked';}?>/><?php echo $text_no;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
              
<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_put_javascript;?></label>
<div class="col-sm-12">
              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($skin_put_js_bottom==1){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_put_js_bottom" value="1" <?php if($skin_put_js_bottom==1){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_put_js_bottom==0){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_put_js_bottom" value="0" <?php if($skin_put_js_bottom==0){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>
                     </div>
              </div><!-- form-group-->
              
          <div class="form-group">
                   <label class="col-sm-12 control-label"><?php echo $text_minify; ?></label>
<div class="col-sm-12">

              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($skin_minify_code==1){ echo 'active tr_click';}?>" onclick="MCP.activeObj('skin_minify_code',1);">
        <input type="radio" name="skin_minify_code" value="1" <?php if($skin_minify_code==1){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_minify_code==0){ echo 'active tr_click';}?>" onclick="MCP.activeObj('skin_minify_code',0);">
        <input type="radio" name="skin_minify_code" value="0" <?php if($skin_minify_code==0){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>
                     </div>
              </div><!-- form-group-->
            
<div class="form-group">
            <label class="col-sm-12 control-label"><?php echo $text_query_optimize;?> <span class="fa fa-info-circle" data-toggle="tooltip" title="<?php echo $help_query_optimize;?>"></span></label>
<div class="col-sm-12">

              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($skin_seo_optimize==1){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_seo_optimize" value="1" <?php if($skin_seo_optimize==1){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($skin_seo_optimize==0){ echo 'active tr_click';}?>">
        <input type="radio" name="skin_seo_optimize" value="0" <?php if($skin_seo_optimize==0){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>
                     </div>
              </div><!-- form-group-->
              
               
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_sub_domain;?></label>
<div class="col-sm-12">
<input type="text" name="skin_sub_domain" value="<?php echo $skin_sub_domain;?>" class="form-control"/>

                     </div>
              </div><!-- form-group-->      
                    <div class="margin-bottom-20 margin-top-20">
                      <a onclick="MCP.viewPerformance()" class="btn btn-xs btn-success" data-toggle="tooltip" title="<?php echo $text_performance;?>" style="margin-top:15px"><i class="fa fa-tachometer"></i> </a>
                      <a href="http://validator.w3.org/check?uri=<?php echo $store_url;?>" class="btn btn-xs btn-success" target="_blank" style="margin-top:15px"><i class="fa fa-check"></i> W3C Validate</a>
                       <a href="https://developers.google.com/speed/pagespeed/insights/?url=<?php echo $store_url;?>" class="btn btn-xs btn-success" target="_blank" style="margin-top:15px"><i class="fa fa-clock-o"></i> <?php echo $text_page_speed;?></a>
                    </div>      
        </div><!-- //tab pane--> 
        <div class="tab-pane" id="advance_license">
        
               		<h4><?php echo $text_license;?> <span id="license_info"></span>  </h4>
              
              
                      <div class="row">
                    <label class="col-sm-12 control-label"><?php echo $text_license_key;?></label>
<div class="col-sm-12">
<div class="input-group">
                    <input style="background:<?php echo $rbg;?>" type="text" id="skin_lic_key" name="skin_lic_key" class="license_field form-control" value="<?php echo $skin_lic_key;?>">
                     <a onclick="MCP.apply(0);" class="input-group-addon btn btn-primary" data-toggle="tooltip" title="<?php echo $button_apply;?>"><i class="fa fa-bolt"></i> </a>
                    </div>
                     </div>
              </div><!-- form-group--> 
              <br/> 
                    <div class="clearfix register_message"><div class="alert alert-success"><?php echo (!empty($skin_lic_message))?html_entity_decode($skin_lic_message, ENT_QUOTES, 'UTF-8'):'';?></div></div>
              
                   <ul class="nav nav-tabs nav-justified margin-bottom-5">
                    <li class="active"><a href="#tab_register" data-toggle="tab"><?php echo $text_about_register;?></a></li>
                    <li><a href="#tab_license" data-toggle="tab"><?php echo $text_about_license;?></a></li>
                    </ul>
                   <div class="tab-content clearfix">
                    <div class="tab-pane active" id="tab_register">
                    
                   
                     <div class="row">
                    <label class="control-label"><strong><?php echo $text_purchase_code;?></strong></label>
                        <div class="clearfix"> 
                        <div class="input-group">
                        
                    <input type="hidden" id="skin_lic_message" name="skin_lic_message" class="form-control" value="<?php echo $skin_lic_message;?>">
                    <input type="hidden" id="skin_config_domain" name="skin_config_domain" class="form-control" value="<?php echo $skin_config_domain;?>">
                    <input type="hidden" id="skin_config_email" name="skin_config_email" class="form-control" value="<?php echo $skin_config_email;?>">
                    <input type="text" id="skin_purchase_code" name="skin_purchase_code" class="form-control" value="<?php echo $skin_purchase_code;?>">
                     <a onclick="MCP.register();" class="input-group-addon btn btn-primary" style="width:80px;"><?php echo $button_register;?></a>
                    </div>
                     </div>
                     
              </div><!-- row--> 
                    <?php echo $help_register;?>
                    
                    
                    </div>
                    <div class="tab-pane" id="tab_license"><?php echo $help_license;?></div>
                    </div>
                 
                    <div class="margin-bottom-20">
                      <a href="<?php echo $register_uri;?>" class="btn btn-xs btn-success" target="_blank" style="margin-top:15px"><i class="fa fa-key"></i> <?php echo $text_request_license;?></a>
                       <a href="http://www.avethemes.com" class="btn btn-xs btn-success" target="_blank" style="margin-top:15px"><?php echo $text_document;?></a>
                    </div>
                
            
        </div><!-- //tab pane--> 
    </div><!--//tab-content --> 
</div>