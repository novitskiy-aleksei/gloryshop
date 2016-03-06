<?php if ($articles) { ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?>
<?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="content large_spacer">
      <?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>

 <div class="content_row">
          <div class="col-md-3">
            <p class="main_desc"><?php echo $description;?></p>
          </div>
          <div class="col-md-9">
<div id="<?php echo $module;?>" class="elem_item_grid owl-carousel carousel-nav-<?php echo $carousel_nav;?> project_text_nav boxed_portos upper_title">
<?php foreach (array_chunk($articles, $num_row) as $article_row) { ?>
<div class="item">
    <?php foreach ($article_row as $article) { ?>
              <div class="item_list_block">
              	 <div class="ave_block">
					    <div class="ave_type">
						    <a data-rel="magnific-popup" href="<?php echo $article['popup'];?>">
							    <img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="Portfolio Name">
						    </a>
						    <div class="ave_nav">
							<a href="<?php echo $article['popup'];?>" class="expand_img"><?php echo $text_larger;?></a>
							<a href="<?php echo $article['href'];?>" class="detail_link"><?php echo $text_more;?></a>
						    </div>
					    </div>
					    <div class="ave_desc">
						<h6 class="name"><?php echo $article['name'];?></h6>
						<div class="ave_meta clearfix">
						    <span class="ave_date"><?php echo $article['date_added']; ?></span>
						    <span class="ave_nums">
							<span class="comm"><i class="fa fa-comments"></i><?php echo $article['comments']; ?></span>
							<span class="author"><i class="fa fa-user"></i><a href="<?php echo $article['author_href'];?>"><?php echo $article['author'];?></a></span>
						    </span>
						</div>
					    </div>
				    </div>
        </div><!--post-item --> 
    <?php } ?>
    </div><!-- //item--> 
    <?php } ?>
    </div><!--elem_item_grid --> 
    
<script type="text/javascript">
$('#<?php echo $module;?>').owlCarousel({
		margin: 20,
		loop: false,
		items: <?php echo $carousel_limit;?>, 
		smartSpeed : <?php echo $smartSpeed;?>,
		slideBy:<?php echo $slideBy;?>,
		autoWidth: false,
		dots: false,
		nav: true,
		navText: ["<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>","<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
		responsive: {
			0: {items: 1},
			479: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
			768: {items: <?php echo ($carousel_limit>2)?'3':'2';?>},
			979: {items: <?php echo ($carousel_limit>3)?'4':'3';?>},
			1199: {items: <?php echo $carousel_limit;?>}
		}
	});
</script>
          </div><!-- col-md-9 --> 
      </div>
</div>
</div>
<?php } ?>