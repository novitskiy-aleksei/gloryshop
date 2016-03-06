<div class="fullwidth_banner clearfix">
<!-- OWL Slider -->
	<div id="<?php echo $module; ?>" class="owl_slider_elem owl-carousel <?php echo $mobile_display;?>">
  <?php
  $i=0;
   foreach ($banners as $banner) { ?>
	    <div class="item">
 		<?php if(!empty($banner['title'])&&(!empty($banner['title2'])||!empty($banner['title3'])||!empty($banner['title4']))){?>
<img class="img-responsive" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>">
 <div class="owl_slider_con">
 		<?php if(!empty($banner['title'])){?>
			<span class="owl_text_a <?php echo ($i==0)?'transform_owl':'';?>">
			    <span>
					<span><?php echo $banner['title'];?></span>
				<a href="#"><span><i class="fa fa-angle-right"></i></span></a>
			    </span>
			</span>
 		<?php } ?>
 		<?php if(!empty($banner['title2'])){?>
			<span class="owl_text_b <?php echo ($i==0)?'transform_owl':'';?>"><span><?php echo $banner['title2'];?></span></span>
 		<?php } ?>
 		<?php if(!empty($banner['title3'])){?>
			<span class="owl_text_c <?php echo ($i==0)?'transform_owl':'';?>"><span><?php echo $banner['title3'];?></span></span>
 		<?php } ?>
 		<?php if(!empty($banner['title4'])){?>
			<span class="owl_text_d <?php echo ($i==0)?'transform_owl':'';?>">
				<a href="<?php echo $banner['link']; ?>" class="btn_a">
				<span><i class="in_left fa fa-angle-right"></i><span><?php echo $banner['title4'];?></span><i class="in_right fa fa-angle-right"></i></span>
			    </a>
			</span>
 		<?php } ?>
	</div>
 		<?php }else{ ?>
      <a href="<?php echo $banner['link']; ?>">
<img class="img-responsive" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>">  
</a>
 		<?php } ?>



	    </div>
  <?php
  $i++;
   } ?>
	</div>
<script type="text/javascript"><!--
$(document).ready(function(){
		var rtl_direction = false;
		if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
			rtl_direction = true;
		};
		var owl = $("#<?php echo $module; ?>");
		owl.owlCarousel({
			rtl: rtl_direction,
			smartSpeed : <?php echo $smartSpeed;?>,
			<?php echo ($carousel_autoplay!='false')?'autoplay: true, autoplayTimeout:'.$carousel_autoplay.',':'';?> 
			autoHeight : false,
			items:1,
			stopOnHover : true,
			loop:true,
			nav : true,
			navText : [
				"<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
				"<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"
			],
			dots: true
		});
		owl.on('changed.owl.carousel', function(event) {
			owl_moved(owl);
		});
});
--></script>
	<!-- End OWL Slider -->
    </div>