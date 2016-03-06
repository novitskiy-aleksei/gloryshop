 <div class="content_row">
    <h3 class="title1 upper"><?php if(!empty($icon)){?><i class="<?php echo $icon;?>"></i><?php } ?><?php echo $heading_title;?></h3>
		
<?php $i=0;
 foreach($sections as $section){?>   
  <?php if(isset($section['title'])){?>			
                    <span class="c_detail">
						<span class="c_name"><?php echo (isset($section['title'][$language_id]))?html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
						<span class="c_desc"><?php echo (isset($section['desc'][$language_id]))?html_entity_decode($section['desc'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
					</span>
		
   <?php } ?>
	<?php
$i++;
 } ?>			

</div>