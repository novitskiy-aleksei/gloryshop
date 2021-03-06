<!-- Skills 1 -->
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>">
      <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
		<div class="content large_spacer no_padding">	
          <?php if(!empty($heading_title)){?>
            <div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
                <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
            </div>
          <?php } ?>
          
			<div class="content_row clearfix">
            
                <?php if($desc_position=='left'){?>
                    <div class="col-md-6">
                    <?php if($description){?>
                    <?php echo $description;?>
                     <?php } ?>
                    </div><!-- Grid 6 -->
                 <?php } ?>
				<div class="col-md-6">
                <?php if($skill_title){?>
                <h2 class="title1 upper"><?php echo $skill_title;?></h2>
                 <?php } ?>
         <?php  foreach($sections as $section){?>
					<div class="progress_bar" data-progress-val="<?php echo $section['percent'];?>" data-progress-animation="easeOutQuad" data-progress-delay="300" data-progress-color="<?php echo $section['color'];?>">
						<div class="fill_con">
							<div class="fill">
                <?php if(isset($section['title'][$language_id])){?>
                <span class="title"><?php echo html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8');?></span>
                 <?php } ?>
								<span class="value"><span class="num"></span><span>%</span></span>
							</div>
						</div>
					</div>
                 <?php } ?>
					
				</div><!-- Grid 6 -->
				
				
                <?php if($desc_position=='right'){?>
                    <div class="col-md-6">
                    <?php if($description){?>
                    <?php echo $description;?>
                     <?php } ?>
                    </div><!-- Grid 6 -->
                 <?php } ?>
			</div>
		</div>
	</div>
	<!-- End Skills 1 -->
