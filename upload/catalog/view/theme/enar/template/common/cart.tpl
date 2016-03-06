<?php global $ave;?>
<a class="nav_cart_toggle">
    <strong class="nav_cart_label"><?php echo $ave->text('text_shopping_cart');?></strong>
    <i class="fa fa-shopping-cart"></i>
    <span class="nav_cart_count"><?php echo $item_info; ?></span>
</a>
<div class="nav_cart_content">
    <div class="nav_cart_header"><h3><?php echo $ave->text('text_shopping_cart');?></h3><i class="fa fa-times"></i></div>
    <?php if ($products || $vouchers) { ?>
    <div class="nav_cart_block">
        <ul class="nav_item_list">
        <?php foreach ($products as $product) { ?>
        <li>
            <a href="<?php echo $product['href']; ?>">
                <img class="img-responsive" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/>  </a>
                <span class="nav_cart_details">
                    <span class="nav_cart_title"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a><span class="nav_cart_quantity">x <?php echo $product['quantity']; ?></span></span>
               <span class="nav_cart_otp">
                     <?php if ($product['option']) { ?>
                        <?php foreach ($product['option'] as $option) { ?>
                       <small>- <?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
                        <?php } ?>
                        <?php } ?>
                        <?php if ($product['recurring']) { ?><br/> 
                        <small>- <?php echo $text_recurring; ?> <?php echo $product['recurring']; ?></small>
                        <?php } ?>
            </span><!--//nav_cart_otp --> 
            
                    <span class="nav_cart_price"><?php echo $product['total']; ?></span>
                    <a class="nav_cart_remove" onclick="cart.remove('<?php echo isset($product['key'])?$product['key']:$product['cart_id']; ?>');" title="<?php echo $button_remove; ?>"></a>
                </span><!--nav_cart_details --> 
          
        </li>
    <?php } ?>
    <?php foreach ($vouchers as $voucher) { ?>
        <li>
                <span class="nav_cart_details">
                    <span class="nav_cart_title"><?php echo $voucher['description']; ?><span class="nav_cart_quantity">x&nbsp;1</span></span>
                    <span class="nav_cart_price"><?php echo $voucher['amount']; ?></span>
                    <a class="nav_cart_remove"  onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" ></a>
                </span>
            
        </li>
    <?php } ?>
       
     
        </ul>
    </div>
	<!-- End nav_cart_block -->
    <div class="nav_cart_footer clearfix">
    <div>
        <table class="table">
          <?php foreach ($totals as $total) { ?>
          <tr>
            <td class="text-right"><strong><?php echo $total['title']; ?></strong></td>
            <td class="text-right"><?php echo $total['text']; ?></td>
          </tr>
          <?php } ?>
        </table>
      </div>
     <p class="text-right">
     <a class="button nav_cart_btn shadow_btn" href="<?php echo $cart; ?>"><strong><i class="fa fa-shopping-cart"></i> <?php echo $text_cart; ?></strong></a>&nbsp;&nbsp;&nbsp;
     <a class="button nav_cart_btn shadow_btn"  href="<?php echo $checkout; ?>"><strong><i class="fa fa-share"></i> <?php echo $text_checkout; ?></strong></a></p>
    </div>
    <?php } else { ?>
    <div class="nav_cart_block">
     <ul class="nav_item_list">
        <li>
          <p class="text-center"><?php echo $text_empty; ?></p>
        </li>
    </ul>
    </div>
	<!-- End nav_cart_block -->
    <?php } ?>
</div><!-- End nav_cart_content -->