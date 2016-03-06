<div class="section bg_fixed <?php echo $bgmode;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
            <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
	<div class="<?php echo ($bgmode=='white_section')?'bg_overlay1':'content_spacer';?>">

	     <div class="content large_spacer_t ">
            <div class="heading_title <?php echo $heading_align;?> upper">
                <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
            </div>
		  <div id="<?php echo $module;?>" class="png_slider">
          
			<?php foreach($sections as $section){?>
			    <div class="png_slide">
				     <span class="description4 centered">
                     <?php echo (isset($section['description'][$language_id]))?str_replace('../image/','image/',html_entity_decode($section['description'][$language_id], ENT_QUOTES, 'UTF-8')):'';?></span>
				    <img class="img-responsive" src="<?php echo !empty($section['image'])?'image/'.$section['image']:''?>" alt="">
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
					smartSpeed : 900,
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