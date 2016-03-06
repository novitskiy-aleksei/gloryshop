<!-- Featured Block (Icon Boxes) Style 1 A -->
	<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="<?php echo ($bgmode=='white_section')?'bg_overlay':'';?>">
		<div class="container large_spacer">
            <?php if(!empty($heading_title)){?>
		  <div class="heading_title <?php echo $heading_align;?> upper">
                <h2><span class="line"> <?php if(!empty($icon)){?><i class="<?php echo $icon;?>"></i> <?php } ?></span><?php echo $heading_title;?></h2>
            </div>
             <?php } ?>
                <?php foreach($sections as $section){?>
                 
                 <div class="content content_spacer no_padding">	
			<div class="content_row clearfix animated"  data-animation-delay="300" data-animation="<?php echo $section['animation'];?>">
				
				<div class="col-md-4 <?php echo $section['img_pos'];?>">
					<span class="spacer30"></span>
					<img alt="<?php echo (isset($section['title'][$language_id]))?html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?>" src="image/<?php echo $section['image'];?>">
				</div>
				<div class="col-md-8">
					<h2 class="title1"><?php echo (isset($section['title'][$language_id]))?html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></h2>
					<p><?php echo (isset($section['description'][$language_id]))?html_entity_decode($section['description'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></p>
				</div>
			</div>
		</div><!--fadeIn --> 
                    <?php } ?>
		</div>
        </div><!--//bg_overlay --> 
	</div>