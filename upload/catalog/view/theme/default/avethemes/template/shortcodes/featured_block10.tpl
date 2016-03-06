<!-- Featured Block (Icon Boxes) Style 1 A -->
	<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="<?php echo ($bgmode=='white_section')?'bg_overlay':'';?>">
            <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
		<div class="content large_spacer clearfix">
         <?php if(!empty($heading_title)){?>
		  <div class="heading_title <?php echo $heading_align;?> upper">
                <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
            </div>
             <?php } ?>
			<!-- Rows Container -->
			<div class="icon_boxes_con style2 icon_box_no_border upper_title clearfix">
				<div class="col-md-6">
                
			<?php foreach($sections as $section){?>
					<div class="service_box">
						<a <?php echo ($section['btn_href'])?'href="'.$section['btn_href'].'"':'';?>><span class="icon circle"><i class="<?php echo $section['icon'];?>"></i></span></a>
						<div class="service_box_con">
							<h3><?php echo (isset($section['title'][$language_id]))?html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></h3>
							<span class="desc"><?php echo (isset($section['description'][$language_id]))?html_entity_decode($section['description'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
						</div>
					</div>
                <?php } ?>
                
				</div>
				<div class="col-md-6">
					<img class="img-responsive" src="<?php echo !empty($section_image)?'image/'.$section_image:'';?>" alt="<?php echo $heading_title;?>">
				</div>
			</div>
			<!-- End Rows Container -->
		</div>
        </div><!--//bg_overlay --> 
	</div>
<!-- End Features 3 -->