<!-- Our Team -->
<div class="section bg_gray">
		<div class="content large_spacer no_padding">	
        
			<div class="heading_title <?php echo $heading_align;?> upper">
				<h2><span class="line"><i class="fa fa-user"></i></span><?php echo $heading_title;?></h2>
			</div>
            
            <?php if(!empty($description)){?>
			<div class="main_desc half_desc centered">
				<p><?php echo $description;?></p>
			</div>
            <?php } ?>
			<span class="spacer30"></span>
			
			<div id="<?php echo $module;?>" class="owl_slider our_team_section content_row clearfix">
            
			  <?php if ($authors) { ?>
    <?php foreach (array_chunk($authors, 2) as $author_row) { ?>
				<div class="content_slide">
    <?php foreach ($author_row as $author) { ?>
					<div class="col-md-6">
						<div class="item_block2 clearfix">
							<a class="member_img" href="<?php echo $author['image']; ?>" data-rel="magnific-popup">
								<img alt="Person Name" src="<?php echo $author['image']; ?>">
							</a>
							<div class="team_detail">
								<a href="<?php echo $author['href'];?>"><span class="person_name"><?php echo $author['author']; ?></span></a>
								<span class="person_jop"><?php echo $author['competence']; ?></span>
								<span class="person_desc"><?php echo $author['description'];?></span>
                                    <?php if(!empty($author['socials'])){ ?>
                                        <div class="social_media clearfix">
                                                 <?php foreach ($author['socials'] as $social) { ?>
                                                            <a href="<?php echo $social['href'];?>" target="<?php echo $social['target'];?>">
                                                                <i class="<?php echo $social['social'];?>"></i>
                                                            </a>
                                                 <?php } ?>
                                            </div>
                                    <?php } ?>
							</div>
						</div>

					</div><!-- Col -->
      <?php } ?>
				</div><!--//content_slide --> 
      <?php } ?>
      <?php } ?>
			</div>
		</div>
            <script type="text/javascript">
			var rtl_direction = false;
				if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
					rtl_direction = true;
				};
		$('#<?php echo $module;?>').owlCarousel({
				rtl: rtl_direction,
				smartSpeed : 1000,
				items: 1,
				autoplay: true,autoplayTimeout:3000,
				autoHeight : true,
				stopOnHover : true,
				dots: true,
				responsive: {
					0: {items: 1},
					479: {items: 1},
					768: 1,
					979: 1,
					1199: 1
				}
			});
			</script>
</div><!--//section --> 

	<!-- End Our Team -->
