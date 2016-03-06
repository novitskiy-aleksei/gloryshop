<?php if(!empty($banners )){?>
<div class="section clearfix <?php echo $mobile_display;?>">
<?php if(!empty($heading_title )){?>
		<div class="title_banner upper centered">
			<div class="content">
				<h2><?php echo $heading_title;?></h2>
			</div>
		</div>
        <?php } ?>
		<div id="<?php echo $module;?>" class="featured_slider full_carousel lightbox_gallery has_hoverdir"  data-options="{attr:&#39;data-source&#39;,path:&#39;horizontal&#39;,skin:&#39;smooth&#39;}">
        <?php foreach ($banners as $banner) { ?>
			<div class="featured_slide_block">
				<a href="<?php echo $banner['full_image']; ?>" data-source="<?php echo $banner['full_image']; ?>" data-caption="<?php echo $banner['title'];?>" class="featured_slide_img">
					<span class="img_cart_con_normal">
						<img class="img-responsive" src="<?php echo $banner['image'];?>" alt="<?php echo $banner['title']; ?>">
					</span>
				</a>
				<div class="hoverdir_con">
					<div class="hoverdir_meta clearfix">
       				 	<?php if ($banner['title']) { ?>
						<h6 class="proj_name"><?php echo $banner['title']; ?></h6>
                         <?php } ?>
                        <?php if (!empty($banner['link'])) { ?>
						<span class="proj_date"><?php echo $banner['description']; ?></span>
   		 				<?php } ?>
						<a class="expand_img" href="<?php echo $banner['full_image']; ?>"><?php echo $text_larger;?></a>
                        
                        <?php if (!empty($banner['link'])) { ?>
						<a class="detail_link" href="<?php echo $banner['link']; ?>"><?php echo $text_more;?></a>
                         <?php } ?>
					</div>
				</div>
			</div>
            <?php } ?>
		</div>
        <script type="text/javascript">
$(document).ready(function(){
		var rtl_direction = false;
		if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
			rtl_direction = true;
		};
		$("#<?php echo $module;?>").owlCarousel({
				rtl: rtl_direction,
			smartSpeed : <?php echo $smartSpeed;?>,
				items : <?php echo $carousel_limit;?>,
				<?php echo ($carousel_autoplay!='false')?'autoplay: true, autoplayTimeout:'.$carousel_autoplay.',':'';?> 
				autoHeight : true,
				responsive: {
					0: {items: 1},
					479: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
					768: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
					979: {items: <?php echo ($carousel_limit>1)?'3':'1';?>},
					1199: {items: <?php echo $carousel_limit;?>}
				},
				stopOnHover : true,
				nav : true,
				navText : [
					"<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
					"<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
				dots: true,
			});
});
		</script>
</div>
<?php } ?>