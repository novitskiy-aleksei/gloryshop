 <?php 
  if ($testimonials) { ?>
<div class="section">
  <!-- Client Say -->
		<div class="content content_spacer clearfix">	
			<div class="heading_title <?php echo $heading_align;?> upper">
				<h2><span class="line"><i class="fa fa-comments-o"></i></span><?php echo $heading_title;?></h2>
			</div>                
      <!-- Content Slider -->
			<div id="<?php echo $module;?>" class="owl_slider">	
            <?php foreach (array_chunk($testimonials, $num_row) as $testimonial_row) { ?>
        <div class="content_slide clearfix">
        <?php foreach ($testimonial_row as $testimonial) { ?>	
						<div class="testimonials_block">
							<span class="client_img"><a href="#"><img class="img-responsive" src="<?php echo $testimonial['avatar'];?>" alt="<?php echo $testimonial['name'];?>"></a></span>
							<div class="say_datils">
								<h5><?php echo $testimonial['name'];?> /<span><?php echo $testimonial['competence'];?></span></h5>
                                
                    <div class="item-rating"><span class="star-<?php echo $testimonial['rating'];?>" title="<?php echo $testimonial['rating'];?> stars"></span></div>
								<span class="ribbon_text"><?php echo $testimonial['message'];?></span>
							</div>
						</div>
    <?php } ?>
                    </div><!--//content_slide --> 
    <?php } ?>
			</div>
			<!-- End Content Slider -->
            <script type="text/javascript">
			var rtl_direction = false;
				if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
					rtl_direction = true;
				};
		$('#<?php echo $module;?>').owlCarousel({
				rtl: rtl_direction,
				smartSpeed : 1000,
				items: <?php echo $carousel_limit;?>, 
				<?php echo ($carousel_autoplay!='false')?'autoplay: true, autoplayTimeout:'.$carousel_autoplay.',':'';?> 
				autoHeight : false,
				stopOnHover : true,
				dots: true,
				responsive: {
					0: {items: 1},
					479: {items: 1},
					768: {items: <?php echo ($carousel_limit>2)?'2':1;?>},
					979: {items: <?php echo ($carousel_limit>3)?'3':$carousel_limit;?>},
					1199: {items: <?php echo $carousel_limit;?>}
				}
			});
			</script>
            
            	</div>
      </div>
	<!-- End Client Say  -->

<?php } ?>