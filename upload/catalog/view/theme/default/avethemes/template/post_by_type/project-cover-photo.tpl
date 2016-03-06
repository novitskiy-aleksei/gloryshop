<?php if(!empty($articles )){?>
<div class="section content content_spacer">

              <?php if(!empty($heading_title)){?>
 			 <div class="content no_padding">	
            	<span class="spacer30"></span>
                <div class="heading_title centered upper">
                    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
                </div>
            </div>
               <?php } ?>
             
<div class="content">

    <?php if(!empty($description)){?><p class="main_desc centered"><?php echo $description;?></p><?php } ?>
		<div id="<?php echo $module;?>" class="featured_slider full_carousel has_hoverdir">
        <?php foreach ($articles as $article) { ?>
			<div class="featured_slide_block">
				<a href="<?php echo $article['popup']; ?>" class="featured_slide_img" data-rel="magnific-popup">
					<span class="img_cart_con_normal">
						<img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name']; ?>">
					</span>
				</a>
				<div class="hoverdir_con">
					<div class="hoverdir_meta clearfix">
						<h6 class="proj_name"><?php echo $article['name']; ?></h6>
						<span class="proj_date"><?php echo $article['description']; ?></span>
						<a class="expand_img" href="<?php echo $article['popup']; ?>"><?php echo $text_larger;?></a>
                        
						<a class="detail_link" href="<?php echo $article['href']; ?>"><?php echo $text_more;?></a>
					</div>
				</div>
			</div>
            <?php } ?>
		</div>
        <script type="text/javascript">
		var rtl_direction = false;
		if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
			rtl_direction = true;
		};
		$("#<?php echo $module;?>").owlCarousel({
				rtl: rtl_direction,
				smartSpeed : 900,
				items : <?php echo $carousel_limit;?>,
				responsive: {
					0: {items: 1},
					479: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
					768: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
					979: {items: <?php echo ($carousel_limit>1)?'3':'1';?>},
					1199: {items: <?php echo $carousel_limit;?>}
				},
				autoHeight : true,
				stopOnHover : true,
				nav : true,
				navText : [
					"<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
					"<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
				dots: true,
			});
		</script>
</div></div>
<?php } ?>