<!-- Demos -->
	<div class="section centered">
		<div class="content content_spacer clearfix">
	<?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>
		
			<!-- Filter Content -->
			<div class="live_preview project_text_nav boxed_portos has_sapce_portos nav_with_nums upper_title upper_title">	   
			 <?php  foreach($sections as $section){?>	       
				<div class="col-md-<?php echo $grid_limit;?> col-sm-6 col-xs-12">
					<div class="filter_item_block">
                            <div class="ave_block centered">
                                <div class="porto_type simple_porto_img">
                                    <a href="<?php echo $section['href'];?>" target="<?php echo $section['target'];?>">
                                        <img src="image/<?php echo $section['image'];?>" alt="<?php echo (isset($section['title'][$language_id]))?html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?>">
                                    </a>
                                </div>
                                <div class="ave_desc simple_ave_desc">
                                    <h6 class="name"><?php echo (isset($section['title'][$language_id]))?html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></h6>
                                    <span class="meta" style="line-height:30px;">
											<span class="meta_part">
                                            <?php if(!empty($section['admin'])){?>
                                            <a href="<?php echo $section['admin'];?>" target="<?php echo $section['target'];?>">
                                            <?php echo (isset($section['desc'][$language_id]))?html_entity_decode($section['desc'][$language_id], ENT_QUOTES, 'UTF-8'):'';?>
                                    			</a>
                                            <?php }else{?>
                                            <?php echo (isset($section['desc'][$language_id]))?html_entity_decode($section['desc'][$language_id], ENT_QUOTES, 'UTF-8'):'';?>
                                            <?php } ?>    
                                            &nbsp;</span>
									</span>
                                </div>
                            </div>
                        </div>
					</div><!-- Item -->
               <?php } ?>     
             </div>
			<!-- End Filter Content -->
		</div>    
	</div>
	<!-- End Demos -->
