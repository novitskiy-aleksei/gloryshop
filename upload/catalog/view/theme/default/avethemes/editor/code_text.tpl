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
           <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>
            <?php echo $help_translate;?><button type="button" class="close" data-dismiss="alert">×</button>
   			 </div>    
             </div>
               <?php
    foreach ($skin_texts_default as $object=>$value){ ?>
    			 <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $value; ?><br><i class="help"><?php echo $object; ?></i></label>
<div class="col-sm-12">
                    <?php foreach ($languages as $language){?>
                      <div class="lang-field">
                        <input type="text" name="theme_setting[translate][<?php echo $object;?>][<?php echo $language['code'];?>]" value="<?php echo isset($translate[$object][$language['code']]) ? $translate[$object][$language['code']]: $value;?>" class="form-control"/>
                        <img src="image/flags/<?php echo $language['image'];?>" title="<?php echo $language['name'];?>"/> </div>
                        <?php }?>
                        
                     </div>
              </div><!-- form-group-->                      
   <?php } ?>

                                       
               
</div>