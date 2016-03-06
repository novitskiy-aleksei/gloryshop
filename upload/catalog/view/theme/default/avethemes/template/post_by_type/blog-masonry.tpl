<?php if ($articles) { ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?>
<?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="content large_spacer">
      <?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>

    <?php if(!empty($description)){?><p class="main_desc centered"><?php echo $description;?></p><?php } ?>
    <!-- Filter Content -->
			<div class="isotope_filter_wrapper masonry_posts blocks_3 colored_masonry">  
				<ul class="isotope_filter_wrapper_con">
        <?php foreach($articles as $article){?>
					<li class="filter_item_block animated" data-animation-delay="300" data-animation="fadeInUp">
						<div class="item_list_block">
							<div class="blog_grid_desc">
								<h6 class="title"><a href="<?php echo $article['href'];?>"><?php echo $article['name'];?></a></h6>
							</div>
							<div class="item_image">
								<div class="item_image_corners">
									<div class="item_image_btns">
										<a href="<?php echo $article['popup'];?>" class="expand_image"><i class="fa fa-external-link"></i></a>
										<a href="<?php echo $article['href'];?>" class="icon_link"><i class="fa fa-link"></i></a>
									</div>
									<a href="<?php echo $article['popup'];?>" class="item_image_ling" data-rel="magnific-popup">
										<img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name'];?>">
									</a>
								</div>
							</div>
							<div class="item_desc">
								<a href="<?php echo $article['href'];?>" class="blog_grid_format"><i class="<?php echo $article['icon'];?>"></i></a>
								<span class="meta">
									<span class="meta_part">
										<i class="fa fa-clock"></i>
											<span><?php echo $article['date_added'];?></span>
									</span>
									<span class="meta_part">
											<i class="fa fa-comment-o"></i>
											<span><?php echo $article['comments'];?></span>
									</span>
									<span class="meta_part">
										<a href="<?php echo $article['author_href']; ?>">
											<i class="fa fa-user"></i>
											<span><?php echo $article['author']; ?></span>
										</a>
									</span>
								</span>
								<p class="desc"><?php echo $article['description']; ?></p>
							</div>
						</div>
                        
					</li><!-- Item -->
		 <?php } ?> <!-- for -->
                   
				</ul>
			</div>
			<!-- End Filter Content -->
			<div class="centered">
				<a class="btn_c" href="<?php echo $timeline;?>">
					<span class="btn_c_ic_a"><i class="fa fa-arrow-right"></i></span>
					<span class="btn_c_t">See All Posts</span>
					<span class="btn_c_ic_b"><i class="fa fa-arrow-right"></i></span>
				</a>
			</div>
</div>
</div>
<?php } ?>