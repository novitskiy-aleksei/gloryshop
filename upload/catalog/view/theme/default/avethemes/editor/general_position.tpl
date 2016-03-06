<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>


  <a data-group="general_group" data-action="layout_assign" class="modal-form btn btn-block btn-info margin-bottom-15" data-title="<?php echo $text_header;?>"><i class="fa fa-chevron-left"></i>  <?php echo $text_back;?></a>
        
        
 <div class="container-fluid ds_accordion">
 <h4><?php echo $text_mobile_position;?></h4>
 <div class="ds_content">
 
              		<div class="form-group">
                    <label class="col-sm-4 col-xs-12 control-label"><?php echo $text_pre_header;?></label>
<div class="col-sm-8 col-xs-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($mobile['pre_header']=='xs-visible'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][pre_header]" value="xs-visible" <?php if($mobile['pre_header']=='xs-visible'){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($mobile['pre_header']=='hidden-xs'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][pre_header]" value="hidden-xs" <?php if($mobile['pre_header']=='hidden-xs'){ echo 'checked';}?>/><?php echo $text_hidden;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
              
                
              		<div class="form-group">
                    <label class="col-sm-4 col-xs-12 control-label"><?php echo $text_after_header;?></label>
<div class="col-sm-8 col-xs-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($mobile['after_header']=='xs-visible'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][after_header]" value="xs-visible" <?php if($mobile['after_header']=='xs-visible'){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($mobile['after_header']=='hidden-xs'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][after_header]" value="hidden-xs" <?php if($mobile['after_header']=='hidden-xs'){ echo 'checked';}?>/><?php echo $text_hidden;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
                      
 		
              		<div class="form-group">
                    <label class="col-sm-4 col-xs-12 control-label"><?php echo $text_top_left;?> - <?php echo $text_top_right;?></label>
<div class="col-sm-8 col-xs-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($mobile['top']=='xs-visible'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][top]" value="xs-visible" <?php if($mobile['top']=='xs-visible'){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($mobile['top']=='hidden-xs'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][top]" value="hidden-xs" <?php if($mobile['top']=='hidden-xs'){ echo 'checked';}?>/><?php echo $text_hidden;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
              
              		<div class="form-group">
                    <label class="col-sm-4 col-xs-12 control-label"><?php echo $text_extra_top;?></label>
<div class="col-sm-8 col-xs-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($mobile['extra_top']=='xs-visible'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][extra_top]" value="xs-visible" <?php if($mobile['extra_top']=='xs-visible'){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($mobile['extra_top']=='hidden-xs'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][extra_top]" value="hidden-xs" <?php if($mobile['extra_top']=='hidden-xs'){ echo 'checked';}?>/><?php echo $text_hidden;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
                
              
              		<div class="form-group">
                    <label class="col-sm-4 col-xs-12 control-label"><?php echo $text_column_left;?></label>
<div class="col-sm-8 col-xs-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($mobile['column_left']=='xs-visible'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][column_left]" value="xs-visible" <?php if($mobile['column_left']=='xs-visible'){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($mobile['column_left']=='hidden-xs'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][column_left]" value="hidden-xs" <?php if($mobile['column_left']=='hidden-xs'){ echo 'checked';}?>/><?php echo $text_hidden;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
          
              		<div class="form-group">
                    <label class="col-sm-4 col-xs-12 control-label"><?php echo $text_column_right;?></label>
<div class="col-sm-8 col-xs-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($mobile['column_right']=='xs-visible'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][column_right]" value="xs-visible" <?php if($mobile['column_right']=='xs-visible'){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($mobile['column_right']=='hidden-xs'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][column_right]" value="hidden-xs" <?php if($mobile['column_right']=='hidden-xs'){ echo 'checked';}?>/><?php echo $text_hidden;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
 
 		
              		<div class="form-group">
                    <label class="col-sm-4 col-xs-12 control-label"><?php echo $text_extra_bottom;?></label>
<div class="col-sm-8 col-xs-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($mobile['extra_bottom']=='xs-visible'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][extra_bottom]" value="xs-visible" <?php if($mobile['extra_bottom']=='xs-visible'){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($mobile['extra_bottom']=='hidden-xs'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][extra_bottom]" value="hidden-xs" <?php if($mobile['extra_bottom']=='hidden-xs'){ echo 'checked';}?>/><?php echo $text_hidden;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
       
              		<div class="form-group">
                    <label class="col-sm-4 col-xs-12 control-label"><?php echo $text_bottom_left;?> - <?php echo $text_bottom_right;?></label>
<div class="col-sm-8 col-xs-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($mobile['bottom']=='xs-visible'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][bottom]" value="xs-visible" <?php if($mobile['bottom']=='xs-visible'){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($mobile['bottom']=='hidden-xs'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][bottom]" value="hidden-xs" <?php if($mobile['bottom']=='hidden-xs'){ echo 'checked';}?>/><?php echo $text_hidden;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
              
 			
              		<div class="form-group">
                    <label class="col-sm-4 col-xs-12 control-label"><?php echo $text_pre_footer;?></label>
<div class="col-sm-8 col-xs-12">
                  
<div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($mobile['pre_footer']=='xs-visible'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][pre_footer]" value="xs-visible" <?php if($mobile['pre_footer']=='xs-visible'){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($mobile['pre_footer']=='hidden-xs'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[mobile][pre_footer]" value="hidden-xs" <?php if($mobile['pre_footer']=='hidden-xs'){ echo 'checked';}?>/><?php echo $text_hidden;?></label>
</div>
                     </div>
              </div><!-- form-group--> 
              </div><!--ds_content --> 
                </div>