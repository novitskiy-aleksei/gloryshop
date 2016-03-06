<?php
 if (!empty($products)) { ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">

    <div class="content large_spacer <?php echo $heading_align;?>">
      <?php if(!empty($heading_title)){?>
		<div class="heading_title upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>
      
    <?php if(!empty($description)){?><p class="main_desc centered"><?php echo $description;?></p><?php } ?>
<div id="<?php echo $module;?>" class="product-layout elem_item_grid owl-carousel carousel-nav-<?php echo $carousel_nav;?>">
<?php foreach (array_chunk($products, $num_row) as $products_row) { ?>
<div class="item">
<?php foreach ($products_row as $product) { ?>
<div class="item_list_block ">
        <div class="item_image">
            <a href="<?php echo $product['href']; ?>" data-id="<?php echo $product['product_id']; ?>" class="btn-quick-view" title="<?php echo $product['name']; ?>" data-text="<?php echo $ave->text('btn_quickview');?>"><i class="fa fa-eye"></i></a>
            <div class="item_img">
            
            <?php if ($product['sales_percent']&&$special_label) { ?>
                    <span class="ribbon_label pc_dis">
                        <span class="ribbon_text"><strong><?php echo $product['sales_percent'];?>%</strong><br/> 
                                 <small><?php echo $ave->text('special_label');?></small>
                        </span>
                        <span class="ribbon_circle special_bg"></span>
                    </span>
           	<?php }  else { ?>
               <?php if(!empty($ribbon_label)){ ?>
                <span class="ribbon_label">
                    <span class="ribbon_text"><?php echo $ribbon_label;?></span><span class="ribbon_circle <?php echo $ribbon_bg;?>"></span>
                </span>
                 <?php } ?>
             <?php } ?>
             
                <a href="<?php echo $product['href']; ?>" class="desc"><?php echo $product['description']; ?></a>
                <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>">
            </div>
        </div>
        <div class="item_desc clearfix">
            <div class="">
                <a href="<?php echo $product['href']; ?>" class="item_product_name"><?php echo $product['name']; ?></a>
            </div>   
                <div class="item-rating">
                    <span class="star-<?php echo $product['rating'];?>"></span>
                </div>
        <?php if ($product['price']) { ?>
                <span class="item_price_group">
                <?php if (!$product['special']) { ?>
          <ins><?php echo $product['price']; ?></ins>
          <?php } else { ?>
          <ins class="price-new"><?php echo $product['special']; ?></ins> <del class="price-old"><?php echo $product['price']; ?></del>
          <?php } ?>
          <?php if ($product['tax']) { ?>
          <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
          <?php } ?>
                </span>
        <?php } ?>
            <div class="button-group btn-cart-group">
            <?php if($btn_cart=='1'){ ?>
<button type="button" class="btn btn-cart" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
		<?php } ?>
            <?php if($btn_whistlist=='1'){ ?>
<button type="button" class="btn btn-wish-list" onclick="wishlist.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>"><i class="fa fa-heart"></i></button>
		<?php } ?>
            <?php if($btn_compare=='1'){ ?>
<button type="button" class="btn btn-compare" onclick="compare.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_compare; ?>"><i class="fa fa-exchange"></i></button>
		<?php } ?>
			</div>
        </div>
    </div>
<?php } ?>
    </div><!--//item --> 
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