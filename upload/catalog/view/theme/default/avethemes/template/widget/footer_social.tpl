<div class="<?php echo $class;?>">
<h5><i class="<?php echo $social_icon;?>"></i><?php echo $social_title; ?></h5>
          <div class="<?php echo $social_class;?>"> 
          <ul class="social-icons <?php echo ($ave->get('footer_style')=='light')?'social-icons-color':'';?>">
          <?php if(!empty($social_data)){
          foreach ($social_data as $social) { ?>      
          <?php if(!empty($social['image'])&&$social_type=='image'){ ?>  
               <li><a class="<?php echo $social['image']; ?> with-tooltip" href="<?php echo $social['link'];?>" title="<?php echo (isset($social['title'][$language_id]))?$social['title'][$language_id]:'';?>" target="<?php echo (!empty($social['target']))?'_blank':'_self';?>"></a></li>
          <?php } ?>
          <?php if(!empty($social['icon'])&&$social_type=='icon'){ ?>         
               <li><a class="social-icon with-tooltip" href="<?php echo $social['link'];?>" title="<?php echo (isset($social['title'][$language_id]))?$social['title'][$language_id]:'';?>" target="<?php echo (!empty($social['target']))?'_blank':'_self';?>"><i class="<?php echo $social['icon']; ?>"></i></a></li>
          <?php } ?>
          <?php } ?>
          <?php } ?>
          </ul>
</div>   
</div>   