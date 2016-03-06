<div class="section clearfix <?php echo $bgmode;?> border_t_n">
		<div class="container large_spacer">
        <?php if($heading_title){?>
			<div class="heading_title centered upper">
				<h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
			</div>
             <?php } ?>
			<!-- Columns Container -->
			<div class="content_row clearfix">
				<!-- grid 6-->
				<div class="col-md-6">
<!-- Gallery -->
					<div class="thumbs_gall_slider_con content_thumbs_gall gall_arrow2 clearfix">
						<div class="thumbs_gall_slider_larg owl-carousel">
  <?php foreach ($banners as $banner) { ?>
							<div class="item">
								<a href="<?php echo $banner['popup'];?>">
									<img class="img-responsive" src="<?php echo $banner['image'];?>" alt="<?php echo $banner['title']; ?>">
								</a>
							</div>
  <?php } ?>
						</div>
						<div class="gall_thumbs owl-carousel">
  <?php foreach ($banners as $banner) { ?>
							<div class="item"><img class="img-responsive" src="<?php echo $banner['thumb'];?>" alt="<?php echo $banner['title']; ?>"></div>
  <?php } ?>
						</div>
					</div>
					<!-- End Gallery -->
</div>
				<!-- End grid 6-->
				
				<!-- grid 6-->
				<div class="col-md-6">
					<?php echo $description;?>
				</div>
				<!-- End grid 6-->
			</div>
			<!-- End Columns Container -->
		</div>
	</div>
	<!-- End Galleries -->
