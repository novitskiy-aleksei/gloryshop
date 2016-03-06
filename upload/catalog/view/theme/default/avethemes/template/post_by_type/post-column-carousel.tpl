<?php if ($articles) { ?>
<div class="content_row">
      <?php if(!empty($heading_title)){?>
		    <h3 class="heading_title"><?php echo $heading_title;?></h3>
      <?php } ?>
<div id="<?php echo $module;?>" class="owl_slider_widget centered owl-carousel carousel-nav-top">
    <?php foreach (array_chunk($articles, $num_row) as $article_row) { ?>
<div class="item">
    <?php foreach ($article_row as $article) { ?>
    <div class="related_posts_slide">
        <div class="related_img_con">
            <a href="<?php echo $article['href']; ?>" class="related_img">
                <img alt="<?php echo $article['name']; ?>" src="<?php echo $article['thumb'];?>">
                <span><i class="fa fa-pencil"></i></span>
            </a>
        </div>
        <a class="related_title" href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a>
        <span class="post_date"><?php echo $article['date_added']; ?></span>
    </div>
    <?php } ?><!--for article --> 
                </div><!--item -->
    <?php } ?><!--for article --> 
    </div><!--item-grid-->
    <script type="text/javascript">
	
$(document).ready(function(){
		var rtl_direction = false;
		if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
			rtl_direction = true;
		};
	$('#<?php echo $module;?>').owlCarousel({
				rtl: rtl_direction,
		smartSpeed : <?php echo $smartSpeed;?>,
				autoplay: true,
				autoplayTimeout:3000,
				autoHeight : true,
				items:1,
				itemsMobile: false,
				stopOnHover : true,
				nav : true,
				dots: true, 
				navText : [
					"<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
					"<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
			});
});
</script>
    </div>
<?php } ?>
       