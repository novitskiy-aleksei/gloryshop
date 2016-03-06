<?php if ($articles) { ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?>
<?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="content large_spacer">
      <?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>

  
<!-- Filter Content -->
		<span class="spacer20"></span>
    <?php if(!empty($description)){?><p class="main_desc centered"><?php echo $description;?></p><?php } ?>
			
			<div class="content_row clearfix">
				<div class="elem_item_full_width elem_item_list clearfix">

           <?php foreach ($articles as $article) { ?>
					<div class="item_list_block clearfix">
						<div class="item_icon">
							<span>
								<a href="<?php echo $article['href'];?>">
									<i class="<?php echo $article['icon'];?>"></i>
								</a>
							</span>
						</div>
						<div class="item_image">
							<div class="item_image_corners">
								<a href="<?php echo $article['popup'];?>" class="item_image_ling" data-rel="magnific-popup">
									<img class="img-responsive" src="<?php echo $article['popup'];?>" alt="<?php echo $article['name'];?>">
								</a>
							</div>
						</div>
						<div class="item_desc">
							<h6 class="title"><a href="<?php echo $article['href'];?>"><?php echo $article['name'];?></a></h6>
							<span class="meta">
								<span class="meta_part">
										<i class="fa fa-clock"></i>
										<span><?php echo $article['date_added'];?></span>
								</span>
								<span class="meta_part">
										<i class="fa fa-comment-o"></i>
										<span><?php echo $article['comments_text'];?></span>
								</span>
								<span class="meta_part">
									<a href="<?php echo $article['author_href'];?>">
										<i class="fa fa-user"></i>
										<span><?php echo $article['author'];?></span>
									</a>
								</span>
							</span>
							<p class="desc"><?php echo $article['description'];?></p>
							<a class="btn_a" href="<?php echo $article['href'];?>">
								<span>
									<i class="in_left fa fa-angle-right"></i>
									<span><?php echo $text_more; ?></span>
									<i class="in_right fa fa-angle-right"></i>
								</span>
							</a>
						</div>
					</div>
                    <?php } ?><!--for article -->  

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
</div><!-- End blog standard--> 
<?php } ?>