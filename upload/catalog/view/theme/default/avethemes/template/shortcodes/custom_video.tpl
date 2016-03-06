<div class="content_row">
    <h3 class="heading_title"><?php echo $heading_title;?></h3>
    <div class="clearfix centered">
    <?php if($sections['type']=='vimeo'){?>
    <a class="elem_vid_con popup-vimeo" href="<?php echo $sections['vimeo_href'];?>">
							<span class="vid_icon"><i class="fa fa-play"></i></span>
							<img alt="<?php echo isset($sections['title'][$language_id])?html_entity_decode($sections['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?>" src="<?php echo !empty($sections['image'])?'image/'.$sections['image']:''?>">
	</a>
    <?php } else{ ?>
    
    <a class="elem_vid_con popup-youtube" href="<?php echo $sections['youtube_href'];?>">
							<span class="vid_icon"><i class="fa fa-play"></i></span>
							<img alt="<?php echo isset($sections['title'][$language_id])?html_entity_decode($sections['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?>" src="<?php echo !empty($sections['image'])?'image/'.$sections['image']:''?>">
	</a>
    
    <?php } ?>

       
    </div>
</div>