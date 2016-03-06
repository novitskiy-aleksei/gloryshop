<!-- Flex Slider -->
	<div class="flex_slider_container flex_style1 <?php if(!$thumb_display){?>flex_no_thumb<?php } ?>">
		<div id="flex_carousel" class="flexslider has_ovellay">
			<a class="flex_previous" href="#">
				<span class="flex_previous_arrow"><i class="fa fa-angle-left"></i></span>
			</a>
			<a class="flex_next" href="#">
				<span class="flex_next_arrow"><i class="fa fa-angle-right"></i></span>
			</a>
			<ul class="slides">
  <?php foreach ($banners as $banner) { ?>
				<li>
                
                <?php if ($banner['title']){ ?>
					<div class="flex_in_flex flexslider">
						<ul class="flex_in_slides">
							<li>
								<div class="flex_in">
									<span class="flex_in1"><?php echo $banner['title']; ?></span>
									<span class="flex_in2 upper oswald_font"><?php echo $banner['title2']; ?>
									</span>
									<span class="flex_in3 upper light oswald_font"><?php echo $banner['title3']; ?>
									</span>
                                    
                <?php if ($banner['link']){ ?>
                          <a href="<?php echo $banner['link'];?>" class="bordered_btn_white upper"><?php echo $banner['title4']; ?></a>
                <?php } ?>
								</div>
							</li>
							
						</ul>
					</div>
                <?php } ?>
					<img class="img-responsive" src="<?php echo $banner['image'];?>" alt="<?php echo $banner['title']; ?>" />
				</li>
  <?php } ?>
			</ul>
		</div>
        <?php if($thumb_display){?>
		<div id="flex_thumbs" class="flexslider">
			<a class="flex_previous" href="#"><i class="fa fa-angle-left"></i></a>
			<a class="flex_next" href="#"><i class="fa fa-angle-right"></i></a>
			<ul class="slides">
  <?php foreach ($banners as $banner) { ?>
				<li>
					<img class="img-responsive" src="<?php echo $banner['thumb'];?>" alt="<?php echo $banner['title']; ?>" />
				</li>
  <?php } ?>
			
			</ul>
		</div>
  <?php } ?>
	</div>
	<!-- End Flex Slider -->