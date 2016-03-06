<!-- Skills -->
	<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="<?php echo ($bgmode=='white_section')?'bg_overlay':'';?>">
      <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
             
		<div class="content large_spacer clearfix">
			  <?php if(!empty($heading_title)){?>
            <div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
                <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
            </div>
          <?php } ?>
            <?php if($description){?>
                <span class="description4 centered"> <?php echo $description;?></span>
                 <?php } ?>
                 

			<div class="content_row clearfix">
				
         <?php  foreach($sections as $section){?>
				<div class="col-md-<?php echo $grid_limit;?> col-sm-6 col-xs-12">
						<div class="elem_circle_progressbar_con">
						<div class="elem_circle_progressbar style1" data-percentag="<?php echo $section['percent'];?>" data-start-color="<?php echo $section['color'];?>" data-end-color="<?php echo $section['color'];?>" data-delay="300" data-animation="easeInOut"></div>
                        <?php if(isset($section['title'][$language_id])){?>
                <span class="elem_circle_title"><?php echo html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8');?></span>
                 <?php } ?>
					</div>
				</div>
		<?php } ?>
                
			</div>
		</div>
        </div><!--//bg_overlay --> 
	</div>
<!-- End Skills  -->
