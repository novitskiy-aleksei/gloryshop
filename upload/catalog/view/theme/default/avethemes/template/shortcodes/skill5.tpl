<!-- Section -->
	<section class="section  <?php echo $bgmode;?> <?php echo $paralax_class;?> img_con_cov" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
		
      <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
		<div class="full_con clearfix">
			<div class="half_full_con white_section large_spacer f_left" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?>">
              <?php if(!empty($heading_title)){?>
            <div class="heading_title upper <?php echo $heading_size;?> no_line">
                <h2><?php echo $heading_title;?></h2>
            </div>
          <?php } ?>
          
				
				<span class="spacer30"></span>
				
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
                
                <!-- progress_bar--> 
                
                
			</div>
		</div>
	</section>
	<!-- End Section -->
