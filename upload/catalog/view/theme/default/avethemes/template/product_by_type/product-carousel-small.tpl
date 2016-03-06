<?php
 if (!empty($products)) { ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">

    <div class="content large_spacer">
      <?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>
      
    <?php if(!empty($description)){?><p class="main_desc centered"><?php echo $description;?></p><?php } ?>
<div id="<?php echo $module;?>" class="elem_item_grid posts_widget owl-carousel carousel-nav-<?php echo $carousel_nav;?> ">
<?php foreach (array_chunk($products, $num_row) as $products_row) { ?>
<ul class="posts_widget_list">
<?php foreach ($products_row as $product) { ?>
            <li class="clearfix">
                <a href="<?php echo $product['href']; ?>">
                    <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>">
                    <span><?php echo $product['name']; ?></span>
                </a>
                <div class="item-rating"><span class="star-<?php echo $product['rating'];?>"></span></div>
                <?php if ($product['price']) { ?>
                    <span class="item_price_group">
                        <?php if (!$product['special']) { ?>
                  <ins><?php echo $product['price']; ?></ins>
                  <?php } else { ?>
                  <ins class="price-new"><?php echo $product['special']; ?></ins> <del class="price-old"><?php echo $product['price']; ?></del>
                  <?php } ?>
                        </span>
        		<?php } ?>
            </li>
<?php } ?>
    </ul><!--//item row --> 
<?php } ?>
</div>
<script type="text/javascript">
$('#<?php echo $module;?>').owlCarousel({
		margin: 20,
		loop: false,
		items: <?php echo $carousel_limit;?>, 
		smartSpeed : <?php echo $smartSpeed;?>,
		slideBy:<?php echo $slideBy;?>,
		<?php echo ($carousel_autoplay!='false')?'autoplay: true, autoplayTimeout:'.$carousel_autoplay.',':'';?> 
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