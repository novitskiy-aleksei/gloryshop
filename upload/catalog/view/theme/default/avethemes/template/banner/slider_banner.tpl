<?php if(!empty($banners)){?>
  <!-- Banner -->
				<div class="clearfix <?php echo $mobile_display;?>">	
					<div id="<?php echo $module; ?>">
  <?php foreach ($banners as $banner) { ?>
						<div class="sidebar_slide">
					<?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['full_image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['full_image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <?php } ?>
						</div>
  <?php } ?>
					</div>
	<script type="text/javascript"><!--
    $(document).ready(function(){
    var rtl_direction = false;
        if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
            rtl_direction = true;
        };
    $("#<?php echo $module; ?>").owlCarousel({
                        rtl: rtl_direction,
						smartSpeed : <?php echo $smartSpeed;?>,
                        autoplay: true,
                        autoplayTimeout:4000,
                        items:1,
                        stopOnHover : true,
                        nav : true,
                        navText : [
                            "<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
                            "<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
                        dots: true,
                        transitionStyle : "backSlide"
                    });
    });
    --></script>
				</div>
				<!-- End Banner -->
  <?php } ?>
  
