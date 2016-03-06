<?php
global $ave;
 if (!empty($categories)) { ?>
 <?php foreach ($categories as $category) { ?>
       <?php if ($category['total']>0){ ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="content large_spacer">
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $category['name']; ?> 
            <div class="control-btn pull-right"><a href="<?php echo $category['href']; ?>" class="view_more" data-toggle="tooltip" title="<?php echo $text_viewmore.$category['name']; ?>"><i class="fa fa-angle-right"></i></a></div>
            </h3>
		</div>

<div class="product-layout elem_item_list clearfix">
   		<?php if($category['products']){ ?> 
      <?php foreach ($category['products'] as $product) { ?>
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
      <?php } ?><!--for --> 
      <?php } ?>
    </div>   <!--//item-grid-->   
</div>
</div>
  <?php } ?>  <!-- count--> 
  <?php } ?>  
  <?php } ?>  