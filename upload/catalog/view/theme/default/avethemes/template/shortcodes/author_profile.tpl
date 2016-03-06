<!-- Our Team -->
	<div class="section">
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
			
			<div class="content_row clearfix">
				
			  <?php if ($authors) {?>
    <?php foreach (array_chunk($authors, 4) as $author_row) { ?>
    <?php foreach ($author_row as $author) { ?>
      <div class="col-md-3 col-sm-6 col-xs-12">
					<div class="item_block flipp_effect">
						<div class="item_content">
							<div class="front face">
								<span class="team_img">
									<img alt="<?php echo $author['author']; ?>" src="<?php echo $author['image']; ?>">
								</span>
								<span class="person_name"><?php echo $author['author']; ?></span>
								<span class="person_jop"><?php echo $author['competence']; ?></span>
							</div>
							<div class="back face">
								<span class="person_name"><?php echo $author['author']; ?></span>
								<span class="person_jop"><?php echo $author['competence']; ?></span>
								<span class="person_desc">
                      <?php if(!empty($author['description'])){ ?><?php echo $author['description'];?><?php } ?>
                      </span>
                      <?php if(!empty($author['socials'])){ ?>
								<div class="social_media clearfix">
                                
     					 <?php foreach ($author['socials'] as $social) { ?>
									<a href="<?php echo $social['href'];?>" target="<?php echo $social['target'];?>">
										<i class="<?php echo $social['social'];?>"></i>
									</a>
     					 <?php } ?>
								</div>
     			 		<?php } ?>
								<a class="arrow_btn" href="<?php echo $author['href'];?>"><i class="fa fa-arrow-right"></i><?php echo $text_full_profile;?></a>
							</div>
						</div>
					</div>
        </div><!--// col--> 
      <?php } ?>
      <?php } ?>
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
	<!-- End Our Team -->
