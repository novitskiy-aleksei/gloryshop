<?php
 if (!empty($products)) { ?>
 <div class="content_row">
    <h3 class="heading_title"><?php echo $heading_title;?></h3>
    <div class="posts_widget">
        <ul class="posts_widget_list">
<?php foreach ($products as $product) { ?>
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
        </ul>
    </div>
</div>
    <?php } ?>