<div class="section  <?php echo $bgmode;?> <?php echo $paralax_class;?> bg_fixed" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
            <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
		<div class="<?php echo ($bgmode=='white_section')?'bg_overlay':'';?>">
			<div class="content large_spacer">	
				
            <div class="heading_title <?php echo $heading_align;?> upper">
                <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
            </div>
				
				<div id="<?php echo $module;?>" class="owl_text_slider centered">
                
			<?php foreach($sections as $section){?>
					<div class="text_slide">
						<span class="desc">
							   <?php echo (isset($section['description'][$language_id]))?html_entity_decode($section['description'][$language_id], ENT_QUOTES, 'UTF-8'):'';?>
						</span>
						<a class="btn_a" href="<?php echo $section['btn_href'];?>" target="<?php echo $section['btn_target'];?>" >
							<span>
								<i class="in_left <?php echo $section['icon'];?>"></i>
                                
			<?php if(isset($section['btn_title'][$language_id])){?>
			<span><?php echo $section['btn_title'][$language_id];?></span>
             <?php } ?>
                    
								<i class="in_right <?php echo $section['icon'];?>"></i>
							</span>
						</a>
					</div>
                <?php } ?>
                    
				</div>
			    
			</div>
		</div>
 <script type="text/javascript">
    var rtl_direction = false;
    if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
        rtl_direction = true;
    };
 $("#<?php echo $module;?>").owlCarousel({
                rtl: rtl_direction,
                loop: true,
                smartSpeed : 2000,
                autoplay: true,
                autoplayTimeout:3000,
                autoHeight : true,
                items:1,
                stopOnHover : true,
                nav : true,
                navText : [
                    "<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
                    "<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
                dots: true,
                transitionStyle : "backSlide"
            });
 </script>   
	</div>