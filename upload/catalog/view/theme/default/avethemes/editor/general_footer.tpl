<?php  
 foreach ($theme_settings_default as $object=>$value){
     if (!isset($theme_setting[$object])){  
        $$object = $value;
     }else{              	
        $$object =  $theme_setting[$object];  
     }                 
  }  
?>
         
        
                  <?php        
     
		 $footer_sort=explode(',', $default_footer_sort);	         
        
         $footer_information=$footer_information; 
         $footer_service=$footer_service; 
         $footer_extras=$footer_extras; 
         $footer_account=$footer_account; 
         
         
        $footer_links['information'] = array(
                'label' => 'information',
                'status' =>$footer_information['status'],
                'display' =>$footer_information['display'],
                'icon' => $footer_information['icon'],
                'text' => $text_information,
                'links' => array(),
        );
       $footer_links['service'] = array(
                'label' => 'service',
                'status' =>$footer_service['status'],
                'display' =>$footer_service['display'],
				'icon' => $footer_service['icon'],
				'text' => $text_service,
				'links' => array(),
		);
        $footer_links['extras'] = array(
                'label' => 'extras',
                'status' =>$footer_extras['status'],
                'display' =>$footer_extras['display'],
				'icon' => $footer_extras['icon'],
				'text' => $text_extra,
				'links' => array(),
		);
         $footer_links['account'] = array(
                'label' => 'account',
                'status' =>$footer_account['status'],
                'display' =>$footer_account['display'],
				'icon' => $footer_account['icon'],
				'text' => $text_account,
				'links' => array(),
		);
             
        
       if ($footer_informations){
            foreach ($footer_informations as $information){ 
             $footer_links['information']['links'][]= array('id'=>$information['id'],'title'=>$information['title']);
            }
       }    
       
         $footer_links['service']['links'][]= array('id'=>'1','title'=>$text_contact);
         $footer_links['service']['links'][]= array('id'=>'2','title'=>$text_return);
         $footer_links['service']['links'][]= array('id'=>'3','title'=>$text_sitemap);
         
         $footer_links['extras']['links'][]= array('id'=>'1','title'=>$text_manufacturer);
         $footer_links['extras']['links'][]= array('id'=>'2','title'=>$text_voucher);
         $footer_links['extras']['links'][]= array('id'=>'3','title'=>$text_affiliate);
         $footer_links['extras']['links'][]= array('id'=>'4','title'=>$text_special);
         
         
         $footer_links['account']['links'][]= array('id'=>'1','title'=>$text_account);
         $footer_links['account']['links'][]= array('id'=>'2','title'=>$text_order);
         $footer_links['account']['links'][]= array('id'=>'3','title'=>$text_wishlist);
         $footer_links['account']['links'][]= array('id'=>'4','title'=>$text_newsletter);
      ?>
        
<ul class="nav nav-tabs nav-justified margin-bottom-10">
<li> <a onclick="MCP.switchView('editor-size-lg');" data-group="general_group"  data-action="general_custom_footer" data-title="<?php echo $text_custom_footer;?>" class="modal-form"><?php echo $text_custom_footer;?></a></li>
<li> <a data-group="general_group"  data-action="widget_footer_payment_icon" data-title="<?php echo $text_powered_payment;?>" class="modal-form"><?php echo $text_powered_payment;?></a></li>
</ul>
 <div class="container-fluid">
                     
                
      <div class="row">
            <label class="col-sm-12 control-label"><?php echo $entry_footer_style; ?></label>
                <div class="col-sm-12">
                    <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-xs btn-success <?php if($footer_style=='footer_dark'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $footer_style;?>','footer_dark');">
                            <input type="radio" name="theme_setting[footer_style]" value="footer_dark" <?php if($footer_style=='footer_dark'){ echo 'checked';}?>/><?php echo $text_dark;?></label>
                        <label class="btn btn-xs btn-info <?php if($footer_style=='footer_light'){ echo 'active tr_click';}?>" onclick="MCP.switchClass('body','<?php echo $footer_style;?>','footer_light');">
                            <input type="radio" name="theme_setting[footer_style]" value="footer_light" <?php if($footer_style=='footer_light'){ echo 'checked';}?>/><?php echo $text_light;?></label>
                    </div>
             </div>
      </div><!-- form-group--> 
                   <p>  <div class="btn btn-info btn-sm" style="display:block">                          
                         
                            <?php echo $text_default_footer;?>
                            
                            </div>
                            
                            </p>
              
              
                      <div class="widget_sort" id="default_footer_sort">
                      <?php
                       foreach ($footer_sort as $sort_key){ ?>
                          <div class="btn btn-info btn-sm">
                              <a href="#default_footer_<?php echo $footer_links[$sort_key]['label'];?>" data-toggle="tab"><i class="fa fa-edit"></i> <?php echo $footer_links[$sort_key]['text'];?>
                              </a>
                              <input type="hidden" class="sort_order" value="<?php echo $footer_links[$sort_key]['label'];?>"/>
                          </div>
                          <?php 
                          } ?>
                        </div>    
                        
            <div class="tab-content clearfix">
                    
               <?php
               $ii =0;
                foreach ($footer_sort as $sort_key){ ?>
                          <?php if(!empty($footer_links[$sort_key])){ ?>     
                   <div class="tab-pane <?php echo ($ii==0)?'active':'';?>" id="default_footer_<?php echo $footer_links[$sort_key]['label'];?>">
                           <h4><i class="<?php echo $footer_links[$sort_key]['icon'];?>"></i><?php echo $footer_links[$sort_key]['text'];?></h4>
                
      
      <div class="form-group margin-bottom-20">
          <div class="row">
            <label class="col-sm-4 control-label"><?php echo $entry_status; ?></label>
                <div class="col-sm-8">
                    <div class="btn-group input-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-xs btn-success <?php if($footer_links[$sort_key]['status']=='1'){ echo 'active tr_click';}?>">
                            <input type="radio" name="theme_setting[footer_<?php echo $footer_links[$sort_key]['label'];?>][status]" value="1" <?php if($footer_links[$sort_key]['status']=='1'){ echo 'checked';}?>/><?php echo $text_enabled;?></label>
                        <label class="btn btn-xs btn-info <?php if($footer_links[$sort_key]['status']=='0'){ echo 'active tr_click';}?>">
                            <input type="radio" name="theme_setting[footer_<?php echo $footer_links[$sort_key]['label'];?>][status]" value="0" <?php if($footer_links[$sort_key]['status']=='0'){ echo 'checked';}?>/><?php echo $text_disabled;?></label>
                    </div>
             </div>
      	</div><!-- row --> 
      </div><!-- form group--> 
				<div class="form-group">
                
                 <div class="col-sm-4">
                    <label class="control-label"><?php echo $entry_icon; ?></label>
                   <a class="icon-preview">
                    <i class="<?php echo $footer_links[$sort_key]['icon'];?>" id="<?php echo $footer_links[$sort_key]['label'];?>_icon_thumb"></i>
                 <input type="hidden" name="theme_setting[footer_<?php echo $footer_links[$sort_key]['label'];?>][icon]" value="<?php echo $footer_links[$sort_key]['icon'];?>" id="<?php echo $footer_links[$sort_key]['label'];?>_icon"/>
                 </a> 
                 <i class="fa fa-trash-o clear-ico"></i>
                 </div>
                 <div class="col-sm-8">
                 
                
                                  <div class="well well-sm">
                                    <?php foreach ($footer_links[$sort_key]['links'] as $link){ ?>
                                    <?php $checked=($footer_links[$sort_key]['display']&&in_array($link['id'],$footer_links[$sort_key]['display']))?'checked="checked"':''; ?>
                                    <?php $li_display=($footer_links[$sort_key]['display']&&in_array($link['id'],$footer_links[$sort_key]['display']))?'checked':'unchecked'; ?>
                                    <div class="<?php echo $li_display;?>">
                                      <input type="checkbox" name="theme_setting[footer_<?php echo $footer_links[$sort_key]['label'];?>][display][]" value="<?php echo $link['id']; ?>" <?php echo $checked;?>/>
                                      <a><?php echo $link['title']; ?></a> </div>
                                    <?php } ?>
                                  </div><!--well --> 
                                  
                      <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all;?></a> / 
                      <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all;?></a>
                      
                            </div>   
              </div><!-- form-group--> 
              </div><!-- tab-pane--> 
                          <?php } ?>
                          <?php
              				$ii++;
                           } ?>
                           
                           
                        </div><!--/default_footer -->
         				<div class="alert alert-info"><?php echo $help_sort_order;?></div>
                        
              
</div>