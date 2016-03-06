<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>

<div class="container-fluid">

           <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_refine_search; ?></label>
<div class="col-sm-12">
             
              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($category_refine=='show'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('.category_refine','<?php echo $category_refine;?>','show');">
        <input type="radio" name="theme_setting[category_refine]" value="show" <?php if($category_refine=='show'){ echo 'checked';}?>/><?php echo $text_show;?></label>
    <label class="btn btn-xs btn-info <?php if($category_refine=='hide'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('.category_refine','<?php echo $category_refine;?>','hide');">
        <input type="radio" name="theme_setting[category_refine]" value="hide" <?php if($category_refine=='hide'){ echo 'checked';}?>/><?php echo $text_hide;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
 
 
              <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $entry_special_label; ?></label>
<div class="col-sm-12">
             
              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($category_special_label=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[category_special_label]" value="1" <?php if($category_special_label=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($category_special_label=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[category_special_label]" value="0" <?php if($category_special_label=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group-->  
				<div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_btn_cart; ?></label>
<div class="col-sm-12">
             
              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($category_btn_cart=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[category_btn_cart]" value="1" <?php if($category_btn_cart=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($category_btn_cart=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[category_btn_cart]" value="0" <?php if($category_btn_cart=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group-->
               <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_btn_whistlist; ?></label>
<div class="col-sm-12">
             
              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($category_btn_whistlist=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[category_btn_whistlist]" value="1" <?php if($category_btn_whistlist=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($category_btn_whistlist=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[category_btn_whistlist]" value="0" <?php if($category_btn_whistlist=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
              <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $text_btn_compare; ?></label>
<div class="col-sm-12">
             
              <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
    <label class="btn btn-xs btn-success <?php if($category_btn_compare=='1'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[category_btn_compare]" value="1" <?php if($category_btn_compare=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
    <label class="btn btn-xs btn-info <?php if($category_btn_compare=='0'){ echo 'active tr_click';}?>">
        <input type="radio" name="theme_setting[category_btn_compare]" value="0" <?php if($category_btn_compare=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
</div>

                     </div>
              </div><!-- form-group--> 
           
</div>