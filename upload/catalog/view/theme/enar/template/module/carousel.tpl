<div class="content">
<div id="carousel<?php echo $module; ?>" class="carousel-nav-middle">
	<?php foreach ($banners as $banner) { ?>
  <div class="c_logo text-center">
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <?php } ?>
  </div>
  <?php } ?>
</div>
<script type="text/javascript"><!--
var rtl_direction = false;
	if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
		rtl_direction = true;
	};
$("#carousel<?php echo $module; ?>").owlCarousel({
	rtl: rtl_direction,
	slideSpeed : 1000,
	autoplay: true,
	autoplayTimeout:4000,
	responsive: {
			0: {items: 1},
			479: {items: 2},
			768: {items: 3},
			979: {items: 4},
			1199: {items: <?php echo (isset($carousel_limit))?$carousel_limit:'5';?>}
		},
	stopOnHover : true,
	nav : true,
	navText : [
		"<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
		"<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
	dots: false,
});
--></script>
</div>