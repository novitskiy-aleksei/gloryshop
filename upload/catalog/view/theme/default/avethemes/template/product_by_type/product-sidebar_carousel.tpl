<?php
 if (!empty($products)) { ?>
 <div class="content_row">
    <h3 class="heading_title"><?php echo $heading_title;?></h3>
    <div id="<?php echo $module;?>" class="sidebar_slider carousel-nav-top">
<?php foreach (array_chunk($products, $num_row) as $products_row) { ?>
<div class="item">
<?php foreach ($products_row as $product) { ?>
<div class="sidebar_slide">
							<a onclick="cart.add('<?php echo $product['product_id']; ?>');" class="btn-quick-view2" data-text="<?php echo $button_cart; ?>">
								<i class="fa fa-shopping-cart"></i>
							</a>
							<a class="sidebar_slide_link" href="<?php echo $product['href']; ?>">
								<span class="sidebar_slide_details">
									<span class="sidebar_slide_title">
										<span class="index_top bold"><?php echo $product['name']; ?></span>
									</span>
									<span class="sidebar_slide_price">
										<span class="index_top light">
                                        
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                 <?php echo $product['special']; ?>
                  <?php } ?>
                                        
                                        </span>
									</span>
                        <?php if ($product['special']) { ?>
									<span class="sidebar_slide_discount">
										<span class="index_top light"><?php echo $product['sales_percent'];?>%</span>
									</span>
                  		<?php } ?>
								</span>
								<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>">
							</a>
						</div>
<?php } ?>
    </div><!--//item --> 
<?php } ?>
    </div>
    
<script type="text/javascript">

$(document).ready(function(){
		var rtl_direction = false;
		if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
			rtl_direction = true;
		};
$('#<?php echo $module;?>').owlCarousel({
		rtl: rtl_direction,
		smartSpeed : <?php echo $smartSpeed;?>,
		slideBy:<?php echo $slideBy;?>,
		autoplay: true,
		autoplayTimeout:4000,
		items:1,
		stopOnHover : true,
		nav : true,
		navText : [
			"<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
			"<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
		dots: true,
		transitionStyle : "backSlide"
	});
});
</script>
</div>
    <?php } ?>