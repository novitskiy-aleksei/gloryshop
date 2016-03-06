<!-- Features Group-->
    <div class="section bg_fixed <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
           <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
             
    	<div class="<?php echo ($bgmode=='white_section')?'bg_overlay':'';?>">
            <div class="content large_spacer clearfix">
             <?php if(!empty($heading_title)){?>
                <div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
                    <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
                </div>
              <?php } ?>
                
                <!-- Features Slider -->
                <div id="<?php echo $module;?>" class="feature_icon_slider">
                 <?php  foreach ($sections as $section) {?>
                    <!--feature_icon_slide start-->
                    <div class="feature_icon_slide">
                        <div class="col-md-4 col-sm-4 col-xs-12">
							<div class="feature_icon on_right">
                                 <?php foreach ($section['column_left'] as $column) { ?>
                                    <div class="item">
                                        <h5>
                                            <span class="icon"><span><i class="<?php echo $column['icon'];?>"></i></span></span>
                                            <?php if(!empty($column['href'])){?>
                    <a class="title" href="<?php echo $column['href'];?>" target="<?php echo $column['target'];?>"><?php echo (isset($column['title'][$language_id]))?html_entity_decode($column['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></a>
                                            <?php }else{ ?> 
                    <span class="title"><?php echo (isset($column['title'][$language_id]))?html_entity_decode($column['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                                             <?php } ?> 
                                        </h5>
                                        <span><?php echo (isset($column['desc'][$language_id]))?html_entity_decode($column['desc'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                                    </div>
                                   <?php } ?>  
                            </div>
                        </div><!-- //col--> 
                        
                        <div class="col-md-4 col-sm-4 col-xs-12">
					<div class="feature_icon_img">
                                <div class="item">
                                    <div class="f_s_block circle">
                                        <a href="<?php echo !empty($section['image'])?'image/'.$section['image']:''?>" class="magnific-popup img_popup">
                                            <span><i class="fa fa-external-link"></i></span>
                                            <img class="img-responsive" src="<?php echo !empty($section['image'])?'image/'.$section['image']:''?>" alt="Feature Title">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- //col--> 
                        
                        <div class="col-md-4 col-sm-4 col-xs-12">
					<div class="feature_icon">
                                 <?php foreach ($section['column_right'] as $column) { ?>
                                    <div class="item">
                                        <h5>
                                            <span class="icon"><span><i class="<?php echo $column['icon'];?>"></i></span></span>
                                            <?php if(!empty($column['href'])){?>
                    <a class="title" href="<?php echo $column['href'];?>" target="<?php echo $column['target'];?>"><?php echo (isset($column['title'][$language_id]))?html_entity_decode($column['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></a>
                                            <?php }else{ ?> 
                    <span class="title"><?php echo (isset($column['title'][$language_id]))?html_entity_decode($column['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                                             <?php } ?> 
                                        </h5>
                                        <span><?php echo (isset($column['desc'][$language_id]))?html_entity_decode($column['desc'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                                    </div>
                                   <?php } ?>   

                                
                            </div>
                        </div><!-- //col--> 
                    </div>
                    <!--feature_icon_slide end-->
                    <?php } ?>
                   
                </div>
                <!-- End Features Slider -->
                
            </div>
       
        </div>
        <script>
		$(document).ready(function(){
			var rtl_direction = false;
			if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
				rtl_direction = true;
			};
			$("#<?php echo $module;?>").owlCarousel({
					rtl: rtl_direction,
					smartSpeed : 900,
					loop: true,
					autoplay: true,
					autoplayTimeout:10000,
					autoHeight : true,
					items:1,
					stopOnHover : true,
					dots: true,
					transitionStyle : "goDown" //fade - fadeUp - backSlide - goDown
				});
		});
		</script>
</div>
    <!-- End Features Group -->