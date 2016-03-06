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
    
    <div id="<?php echo $module;?>" class="featured_slider">
    <?php foreach (array_chunk($articles, $num_row) as $article_row) { ?>
<div class="item">
    <?php foreach ($article_row as $article) { ?>
            <div class="featured_slide_block">
                <a href="<?php echo $article['popup'];?>" class="featured_slide_img" data-rel="magnific-popup">
                    <span class="f_s_i_format"><i class="fa fa-image"></i></span>
                    <span class="img_cart_con_normal">
                        <img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name']; ?>">
                    </span>
                </a>
                <div class="featured_slide_details">
                    <span class="f_s_i_date">
                        <span class="day"><?php echo $article['date'];?></span>
                        <span class="mounth"><?php echo $article['month'];?></span>
                    </span>
                    <a href="<?php echo $article['href'];?>" class="f_s_d_link"><?php echo $article['name']; ?></a>
                </div>
            </div><!-- --> 
    <?php } ?><!--for article --> 
                </div><!--item -->
    <?php } ?><!--array_chunk --> 
    </div>
    <script type="text/javascript">
$('#<?php echo $module;?>').owlCarousel({
		margin: 0,
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
</div>
</div>
<?php } ?>