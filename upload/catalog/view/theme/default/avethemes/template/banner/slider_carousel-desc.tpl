<?php if(!empty($banners )){?>
<div class="content_row content_spacer <?php echo $mobile_display;?>">
     <?php if(!empty($heading_title )){?> <h3 class="heading_title"><?php echo $heading_title; ?></h3><?php } ?>
        <div class="content_row">
          <div class="col-md-3">
            <p><?php echo $description;?></p>
          </div>
          <div class="col-md-9">
            <div id="<?php echo $module;?>" class="owl-carousel carousel-nav-middle">
 <?php foreach ($banners as $banner) { ?>
  <div class="c_logo text-center">
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['full_image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['full_image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <?php } ?>
  </div>
  <?php } ?>              
            </div><!--owl-carousel --> 
            
<script type="text/javascript"><!--
$(document).ready(function(){
	var rtl_direction = false;
		if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
			rtl_direction = true;
		};
	$("#<?php echo $module; ?>").owlCarousel({
		rtl: rtl_direction,
			smartSpeed : <?php echo $smartSpeed;?>,
		items : <?php echo $carousel_limit;?>,
		<?php echo ($carousel_autoplay!='false')?'autoplay: true, autoplayTimeout:'.$carousel_autoplay.',':'';?> 
		autoWidth:false,
		responsive: {
				0: {items: 1},
				479: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
				768: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
				979: {items: <?php echo ($carousel_limit>1)?'3':'1';?>},
				1199: {items: <?php echo $carousel_limit;?>}
		},
		nav : true,
		navText : [
			"<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
			"<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
		dots: false,
	});
});
--></script>
          </div>          
        </div><!-- END ROW -->
    </div>
  <?php } ?>