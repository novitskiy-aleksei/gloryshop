<?php if($products){  ?>
  <?php 
  
		   $mconfig=$ave->get('pin_binding');
  ?>
<li class="elem_image_menu mobile_menu_toggle">
              <a>
                <span><?php echo $text;?></span></a>
              <ul class="image_menu">
                <li class="image_menu_slide elem_item_grid product-layout">
               <?php foreach ($products as $product) { ?>

<div class="item_list_block item_block flipp_effect">
						<div class="item_content">
							<div class="front face">
								<div class="item_image">
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
                                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>">
                                    </div>
                                </div>
                                <div class="clearfix">
                                        <div class="">
                                            <a href="<?php echo $product['href']; ?>" class="person_name"><?php echo $product['name']; ?></a>
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
                                    </div>
							</div><!-- front--> 
							<div class="back face">
								<span class="person_name"><a href="<?php echo $product['href']; ?>" class="item_product_name"><?php echo $product['name']; ?></a></span>
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
								<span class="person_desc"><?php echo $product['description']; ?></span>
            <div class="combo-btn">
                <div class="input-group input-group-sm">
                <span class="input-group-btn">
                <button class="btn quantity-down" type="button" onclick="compare.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_compare; ?>"><i class="fa fa-exchange"></i></button></span>
                <button type="button" class="btn-cart" onclick="cart.add('<?php echo $product['product_id']; ?>');"><span><?php echo $button_cart; ?></span></button>
                <span class="input-group-btn"><button class="btn quantity-up" type="button" onclick="wishlist.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>"><i class="fa fa-heart"></i></button></span>
                </div>
            </div>
							</div><!-- front--> 
						</div>
					</div>
<?php } ?>
                </li>
              </ul>
            </li>
<?php } ?>