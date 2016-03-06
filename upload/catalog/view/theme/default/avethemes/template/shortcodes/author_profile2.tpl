<!-- Our Team 2 -->
	<div class="section">
		<div class="content large_spacer">	
			<div class="heading_title <?php echo $heading_align;?> upper">
				<h2><span class="line"><i class="fa fa-user"></i></span><?php echo $heading_title;?></h2>
			</div>
			  <?php if(!empty($description)){?>
			<div class="main_desc half_desc centered">
				<p><?php echo $description;?></p>
			</div>
            <?php } ?>
			<span class="spacer30"></span>
			
			<div class="item_block3 content_row clearfix">
            
   				 <?php foreach ($authors as $author) { ?>
				<div class="team-col no_padding clearfix" data-color="">
					<div class="team-col-1">
						<a class="member_img2" href="<?php echo $author['image']; ?>" data-rel="magnific-popup">
							<span>
								<img alt="<?php echo $author['author']; ?>" src="<?php echo $author['image']; ?>">
							</span>
						</a>
					</div>
					<div class="team-col-2">
						<div class="team-col-2-con">
							<a href="#"><span class="person_name"><?php echo $author['author']; ?></span></a>
							<span class="person_jop"><?php echo $author['competence']; ?></span>
							<span class="person_desc">
                      <?php if(!empty($author['description'])){ ?><?php echo $author['description'];?><?php } ?></span>
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
						<span class="arrow"></span>
					</div>
				</div><!-- Col -->
            <?php } ?>
			</div>
            <div class="centered">
					<a href="<?php echo $author_list;?>" class="btn_c">
						<span class="btn_c_ic_a"><i class="fa fa-refresh"></i></span>
						<span class="btn_c_t"><?php echo $text_viewmore;?></span>
						<span class="btn_c_ic_b"><i class="fa fa-refresh"></i></span>
					</a>
				</div>
		</div>
	</div>
	<!-- End Our Team 3 -->
