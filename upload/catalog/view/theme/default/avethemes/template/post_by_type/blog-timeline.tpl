<?php if ($articles) { ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?>
<?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="content large_spacer">
      <?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>

  
  <?php  if ($articles) { ?>
    <?php if(!empty($description)){?><p class="main_desc centered"><?php echo $description;?></p><?php } ?>
<!-- Filter Content -->
			<div class="isotope_filter_wrapper timeline">  
				<ul class="isotope_filter_wrapper_con timeline">
                
           <?php foreach ($articles as $article) { ?>
			    		<li class="filter_item_block animated" data-animation-delay="300" data-animation="bounceInUp">
						<div class="timeline_block clearfix">
							<a href="<?php echo $article['href'];?>" class="timeline_post_format image"><i class="fa fa-<?php echo $article['icon'];?>"></i></a>
							<div class="timeline_feature"> 
								<a data-rel="magnific-popup" href="<?php echo $article['popup'];?>"> 
									<span class="image-zoom"><i class="fa fa-plus"></i></span> 
									<img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name'];?>" title="<?php echo $article['name'];?>"> 
								</a>
							</div>
							  
							<h6 class="timeline_title"><a href="<?php echo $article['href'];?>"><?php echo $article['name'];?></a></h6>
							<span class="meta">
								<span class="meta_part">
										<i class="fa fa-clock"></i>
										<span><?php echo $article['date_added'];?></span>
								</span>
								<span class="meta_part">
									<i class="fa fa-user"></i>
									<span>
										<a href="<?php echo $article['author_href'];?>"><?php echo $article['author'];?></a>
									</span>
								</span>
								<span class="meta_part">
										<i class="fa fa-comment-o"></i>
										<span><?php echo $article['comments_text'];?></span>
								</span>
							</span>
							<div class="article"><?php echo $article['description'];?></div>
							<div class="clearfix">
								<a class="read_more_button" href="<?php echo $article['href'];?>">
									<i class="fa fa-arrow-forward"></i><?php echo $text_more; ?>
								</a>
							</div>
						</div>
					</li><!-- Item -->            
    	<?php } ?>
                    
				</ul>
				<div class="centered">
					
				</div>
			</div>
			<!-- End Filter Content -->                                 
    <?php } ?>
    <!--for article -->  
    
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