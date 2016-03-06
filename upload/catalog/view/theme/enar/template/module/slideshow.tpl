<div class="content">
<!-- OWL Slider -->
	<div id="slideshow<?php echo $module; ?>" class="owl_slider_elem owl-carousel">
  <?php foreach ($banners as $banner) { ?>
	    <div class="item">
<a href="<?php echo $banner['link']; ?>"><img class="img-responsive" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>"></a>
	    </div>
  <?php } ?>
	</div>
<script type="text/javascript"><!--
var rtl_direction = false;
		if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
			rtl_direction = true;
		};
var owl = $("#slideshow<?php echo $module; ?>");
owl.owlCarousel({
	rtl: rtl_direction,
	slideSpeed : 900,
	autoplay: true,
	autoplayTimeout:3000,
	autoHeight : true,
	items:1,
	stopOnHover : true,
	nav : true,
	navText : [
		"<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
		"<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"
	],
	dots: true,
	transitionStyle : "fadeUp" //fade - fadeUp - backSlide - goDown
});
--></script>
	<!-- End OWL Slider -->
</div>