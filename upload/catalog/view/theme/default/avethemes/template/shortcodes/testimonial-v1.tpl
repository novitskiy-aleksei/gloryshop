 <?php 
  if ($testimonials) { ?>
  <!-- Client Say -->
	<div class="section">
		<div class="content content_spacer clearfix">	
			<div class="heading_title <?php echo $heading_align;?> upper">
				<h2><span class="line"><i class="fa fa-comments-o"></i></span><?php echo $heading_title;?></h2>
			</div>                
			<div id="<?php echo $module;?>" class="owl_text_slider client_say_slider">
            
      <?php foreach ($testimonials as $testimonial) { ?>
				<div class="c_say">
					<div class="centered">
						<span class="client_img">
							<span>
								<img class="img-responsive" src="<?php echo $testimonial['avatar'];?>" alt="<?php echo $testimonial['name'];?>">
							</span>
						</span>
					</div>
					<div class="client_details">
						<span class="name"><?php echo $testimonial['name'];?></span>
						<span class="url"> - <?php echo $testimonial['competence'];?></span>
					</div>
					<div>
                    <div class="item-rating btn-block" style="margin: 0 auto;"><span class="star-<?php echo $testimonial['rating'];?>"></span></div>
					</div>
					<span class="desc"><?php echo $testimonial['message'];?></span>
				</div><!--//c_say --> 
		<?php } ?>
				
			</div>
            <script type="text/javascript">
			var rtl_direction = false;
				if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
					rtl_direction = true;
				};
			$('#<?php echo $module;?>').owlCarousel({
				rtl: rtl_direction,
				smartSpeed : 250,
				<?php echo ($carousel_autoplay!='false')?'autoplay: true, autoplayTimeout:'.$carousel_autoplay.',':'';?> 
				autoHeight : false,
				items:1,
				stopOnHover : true,
				dots: true,
				nav : true,
				navText : [
					"<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
					"<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
				dots: false,
			});
			</script>
            
            	</div>
      </div>
	<!-- End Client Say  -->

<?php } ?>