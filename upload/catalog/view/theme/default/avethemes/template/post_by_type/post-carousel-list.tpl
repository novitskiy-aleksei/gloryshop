<?php if ($articles) { ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?>
<?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="content large_spacer">
      <?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>

    <div id="<?php echo $module;?>" class="elem_item_list owl-carousel carousel-nav-<?php echo $carousel_nav;?>">
    <?php foreach (array_chunk($articles, $num_row) as $article_row) { ?>
<div class="item">
    <?php foreach ($article_row as $article) { ?>
    <div class="item_list_block clearfix">
					<div class="item_image">
						<div class="item_image_corners">
							<div class="item_image_btns">
								<a href="<?php echo $article['popup'];?>" class="expand_image"><i class="fa fa-external-link"></i></a>
								<a href="<?php echo $article['href'];?>" class="icon_link"><i class="fa fa-link"></i></a>
							</div>
							<a href="<?php echo $article['popup'];?>" class="item_image_ling" data-rel="magnific-popup">
								<img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name']; ?>">
							</a>
						</div>
					</div>
					<div class="item_desc">
						<h6 class="title"><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h6>
						<span class="meta">
							<span class="meta_part">
									<i class="fa fa-clock"></i>
									<span><?php echo $article['date_added']; ?></span>
							</span>
							<span class="meta_part">
								<a href="<?php echo $article['author_href']; ?>"><i class="fa fa-user"></i><span><?php echo $article['author']; ?></span></a>
							</span>
							<span class="meta_part">
									<i class="fa fa-comment-o"></i>
									<span><?php echo $article['comments']; ?></span>
							</span>
						</span>
						<p class="desc"><?php echo $article['description']; ?></p>
						<a class="btn_a" href="<?php echo $article['href']; ?>">
							<span>
								<i class="in_left fa fa-angle-right"></i>
								<span><?php echo $text_more;?></span>
								<i class="in_right fa fa-angle-right"></i>
							</span>
						</a>
					</div>
				</div><!-- //item--> 
    <?php } ?><!--for article --> 
				</div><!-- //carousel item--> 
    <?php } ?>
    
    <script type="text/javascript">
$('#<?php echo $module;?>').owlCarousel({
		smartSpeed : <?php echo $smartSpeed;?>,
		margin: 0,
		loop: false,
		items: 1, 
		autoWidth: false,
		dots: false,
		nav: true,
		navText: ["<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>","<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"]
	});
</script>
    </div>
</div>
<?php } ?>