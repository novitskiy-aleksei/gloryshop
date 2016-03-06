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
 <a data-group="general_group" data-action="general_header" class="modal-form btn btn-block btn-info margin-bottom-15" data-title="<?php echo $text_general;?>"><i class="fa fa-chevron-left"></i>  <?php echo $text_back;?></a>
              
            <h4><?php echo $text_support_info;?></h4>
               <div class="table-responsive">
        <table class="table table-bordered table-hover">
                  <thead>
                  <tr>
                  <th width="1"><?php echo $entry_icon;?></th>
                  <th><?php echo $entry_title_desc;?></th>
                   </tr>
                  </thead>
                  
                  <tbody>
                  <?php           
				  for( $i= 0 ; $i < 3 ; $i++ ){ ?>
                  <tr>
                  <td>
                  
                 <a class="icon-preview">
                    <i class="<?php echo $skin_header_step_info[$i]['icon'];?>" id="hinfo_icon<?php echo $i;?>_thumb"></i>
                     <input type="hidden" name="skin_header_step_info[<?php echo $i;?>][icon]" value="<?php echo $skin_header_step_info[$i]['icon'];?>" id="header_step_icon<?php echo $i;?>"/>
                  </a> 
                  
                          </td>
                          <td>
                          <?php foreach ($languages as $language){ ?>
                        <div class="lang-field clearfix">
                          <input type="text" name="skin_header_step_info[<?php echo $i;?>][title][<?php echo $language['language_id'];?>]" value="<?php echo isset($skin_header_step_info[$i]['title'][$language['language_id']]) ? $skin_header_step_info[$i]['title'][$language['language_id']] : 'Goal definition';?>" class="form-control"/>
                          <img src="image/flags/<?php echo $language['image'];?>" title="<?php echo $language['name'];?>"/>
                          </div>
                          
                        <div class="lang-field clearfix">
                          <input type="text" name="skin_header_step_info[<?php echo $i;?>][description][<?php echo $language['language_id'];?>]" value="<?php echo isset($skin_header_step_info[$i]['description'][$language['language_id']]) ? $skin_header_step_info[$i]['description'][$language['language_id']] : 'Lorem ipsum';?>" class="form-control"/>
                          <img src="image/flags/<?php echo $language['image'];?>" title="<?php echo $language['name'];?>"/>
                     </div>
                        <?php } ?>
                        
                          <div class="input-group pull-left">
              <span class="input-group-addon"><i class="fa fa-chain"></i></span>
               <input type="text" name="skin_header_step_info[<?php echo $i;?>][href]" value="<?php echo $skin_header_step_info[$i]['href'];?>" class="form-control"/>
              </div>
                        </td>
                        </tr>
                  <?php } ?>
                  </tbody>
                  </table>                
              </div><!-- table-responsive--> 
                  
                
                
              </div>
           </div>