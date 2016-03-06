<?php
global $ave;
$carousel_limit = isset($carousel_limit)?$carousel_limit:3;
$module = rand();
 if (!empty($products)) { ?>
<div class="content">
<h3 class="heading_title centered upper"><span class="line"><i class="fa fa-shopping-cart"></i></span><?php echo $heading_title; ?></h3>

<div id="bestseller_module<?php echo $module;?>" class="elem_item_grid owl-carousel carousel-nav-top product-layout">
<?php foreach ($products as $product) { ?>
<div class="item_list_block">
        <div class="item_image">
            <a href="<?php echo $product['href']; ?>" data-id="<?php echo $product['product_id']; ?>" class="btn-quick-view" title="<?php echo $product['name']; ?>" data-text="<?php echo $ave->text('btn_quickview');?>"><i class="fa fa-eye"></i></a>
            <div class="item_img">
             <?php if ($product['special']) { ?>
                <span class="ribbon_label">
                    <span class="ribbon_text"><?php echo $ave->text('special_label');?></span><span class="ribbon_circle special_bg"></span>
                </span>
             <?php }else{ ?>
            <span class="ribbon_label">
                <span class="ribbon_text"><?php echo $ave->text('bestseller_label');?></span><span class="ribbon_circle bestseller_bg"></span>
            </span>
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
<button type="button" class="btn btn-cart" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
<button type="button" class="btn btn-wish-list" onclick="wishlist.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>"><i class="fa fa-heart"></i></button>
<button type="button" class="btn btn-compare" onclick="compare.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_compare; ?>"><i class="fa fa-exchange"></i></button>
			</div>
        </div>
    </div>
<?php } ?>
</div>
<script type="text/javascript">
$('#bestseller_module<?php echo $module;?>').owlCarousel({
		margin: 20,
		loop: false,
		items: <?php echo $carousel_limit;?>, 
		autoWidth: false,
		dots: false,
		nav: true,
		navText: ["<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>","<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
		responsive: {
			0: {items: 1},
			479: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
			768: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
			979: {items: <?php echo ($carousel_limit>1)?'3':'1';?>},
			1199: {items: <?php echo $carousel_limit;?>}
		}
	});
</script>
</div>
<?php } ?>