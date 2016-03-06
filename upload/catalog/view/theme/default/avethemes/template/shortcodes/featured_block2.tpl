<!-- Featured Block (Icon Boxes) Style 1 A -->
	<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="<?php echo ($bgmode=='white_section')?'bg_overlay':'';?>">
    
            <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
		<div class="container content_spacer">
            <?php if(!empty($heading_title)){?>
		  <div class="heading_title <?php echo $heading_align;?> upper">
                <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
            </div>
             <?php } ?>
			<div class="row icon_boxes_con style1 circle clearfix">
            
			<?php $i=0;
             foreach($sections as $section){?>
				<div class="col-md-<?php echo $grid_limit;?> col-sm-6 col-xs-12">
					<div class="service_box">
						<span class="icon"><i class="color<?php echo $i;?> <?php echo $section['icon'];?>"></i></span>
						<div class="service_box_con centered">
							<h3><?php echo (isset($section['title'][$language_id]))?html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></h3>
							<span class="desc"><?php echo (isset($section['description'][$language_id]))?html_entity_decode($section['description'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
							<?php if(!empty($section['btn_href'])){?><a href="<?php echo $section['btn_href'];?>" target="<?php echo $section['btn_target'];?>" class="ser-box-link"><span></span>Read More</a><?php } ?>
						</div>
					</div>
				</div><!--//col --> 
                <?php
                $i++;
                 } ?>
                
			</div>
		</div>
        </div><!--//bg_overlay --> 
	</div>