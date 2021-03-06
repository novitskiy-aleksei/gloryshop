<?php
     if (!empty($categories)) { ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="content large_spacer">
      <?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>
 				<div class="elem-tabs tabs2 fill_active hide_arrow">
 <nav class="clearfix">
		<ul id="product_list<?php echo $module;?>" class="tabs-navi">

             <?php $i=0;?>
 <?php foreach ($categories as $category) { $i++; ?>
       <?php if ($category['total']>0){ ?>
                <li class="<?php echo ($i==1)?'active':'';?>"><a href="#tab-product-grid_<?php echo $category['tab_id']; ?>" data-toggle="tab" class="<?php echo ($i==1)?'selected':'';?>"><?php echo $category['name']; ?></a></li>
  <?php } ?>  
  <?php } ?>  
                  </ul> 
                  </nav>				
                  <div id="myTabContent" class="tab-content">
                     <?php $i=0;?>
 <?php foreach ($categories as $category) { $i++;  ?>
       <?php if ($category['total']>0){ ?>
                    <div class="tab-pane fade in <?php echo ($i==1)?'active':'';?>" id="tab-product-grid_<?php echo $category['tab_id']; ?>">
<div id="<?php echo $module;?>_<?php echo $i; ?>" class=" product-layout elem_item_list owl-carousel carousel-nav-<?php echo $carousel_nav;?>">
   		<?php if($category['products']){ ?> 
     <?php foreach (array_chunk($category['products'], $num_row) as $products_row) { ?>
<div class="item">
<?php foreach ($products_row as $product) { ?>
<div class="item_list_block">
   <div class="clearfix">
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
           	<?php } ?>
          <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>">
         </div>
      </div>
      <div class="item_desc">
         <div class="title"><a href="<?php echo $product['href']; ?>" class="item_product_name"><?php echo $product['name']; ?></a></div>
         <div class="item-rating"><span class="star-<?php echo $product['rating'];?>"></span></div>
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
         <p class="desc"><?php echo $product['description']; ?></p>
         <div class="button-group">
            <?php if($btn_cart=='1'){ ?>
<button type="button" class="btn btn-cart btn-primary" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
		<?php } ?>
            <?php if($btn_whistlist=='1'){ ?>
<button type="button" class="btn btn-wish-list btn-primary" onclick="wishlist.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>"><i class="fa fa-heart"></i></button>
		<?php } ?>
            <?php if($btn_compare=='1'){ ?>
<button type="button" class="btn btn-compare btn-primary" onclick="compare.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_compare; ?>"><i class="fa fa-exchange"></i></button>
		<?php } ?>
			</div>
      </div>
   </div>
</div>
<?php } ?>
    </div><!--//item --> 
<?php } ?><!--for --> 
<script type="text/javascript">
$('#<?php echo $module;?>_<?php echo $i; ?>').owlCarousel({
		margin: 20,
		loop: false,
		smartSpeed : <?php echo $smartSpeed;?>,
		slideBy:<?php echo $slideBy;?>,
		items: 1, 
		autoWidth: false,
		dots: false,
		nav: true,
		navText: ["<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>","<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"]
	});
</script>
<?php } ?>
</div>   <!--//item-grid-->  
                    </div><!--tab-pane --> 
        <?php } ?>  <!-- count-->   
  <?php } ?>  
                  </div><!--tab-content --> 
                    
  
  </div><!--//box-content-->   
</div>
</div><!--//section --> 
<?php } ?>  