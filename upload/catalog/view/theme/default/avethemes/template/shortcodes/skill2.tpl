<!-- Skills -->
	<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>">
      <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
             
		<div class="content large_spacer clearfix">
			  <?php if(!empty($heading_title)){?>
            <div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
                <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
            </div>
          <?php } ?>
			<div class="content_row clearfix">
				
         <?php  foreach($sections as $section){?>
				<div class="col-md-<?php echo $grid_limit;?> col-sm-6 col-xs-12">
						<div class="elem_circle_progressbar_con">
                                <div class="elem_circle_progressbar style1 square" data-percentag="<?php echo $section['percent'];?>" data-start-color="<?php echo $section['color'];?>" data-end-color="<?php echo $section['color'];?>" data-delay="300" data-animation="easeInOut"></div>  
                             <?php if(isset($section['title'][$language_id])){?>
                            <span class="elem_circle_title"><?php echo html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8');?></span>
                             <?php } ?>
						</div>
				</div><!-- //col--> 
		<?php } ?>
                
			</div>
		</div>
	</div>
<!-- End Skills  -->