<div class="nav_cart_header">
<ul class="nav nav-tabs">
        <li class="active"><a onclick="activeObj('nav_search_result','product')"><?php echo $text_search_product;?></a></li>
<?php if($content_installed==1){?>
        <li><a onclick="activeObj('nav_search_result','content')"><?php echo $text_search_content;?></a></li>
<?php } ?>  
</ul>
<a class="fa fa-times close-btn" onclick="$('.search-widget').removeClass('active');"></a>
</div>
  

<div class="tab-content"> 
<div class="tab-pane in active nav_search_result otp-product"> 
 <?php if ($products) { ?>   
<div class="nav_cart_block">
 <ul class="nav_item_list">
        <?php foreach ($products as $product) { ?>
        
           
        <li>
            <a href="<?php echo $product['href']; ?>">
                <img class="img-responsive" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/>  </a>
                <span class="nav_cart_details">
                    <span class="nav_cart_title"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></span>
            
                    <span class="nav_cart_price"><?php echo $product['price']; ?></span>
                   <!--
                    <a class="nav_cart_btn" onclick="cart.add('<?php echo $product['product_id']; ?>');"><?php echo $button_cart; ?></a> --> 
                </span><!--nav_cart_details --> 
          
        </li>  
            
            
          <?php } ?>     
          
 </ul> 
 </div>
 <?php } else { ?>
    <div class="nav_cart_block"><?php echo $text_empty_product;?></div>
<?php } ?>
     <div class="nav_cart_footer">
         <span class="clearfix">
         <a href="<?php echo $search_catalog;?>" class="btn btn-xs nav_cart_btn pull-right"><?php echo $text_advance_search;?></a>
         </span>
     </div>
 </div><!--search-product-results -->
<div class="tab-pane nav_search_result otp-content">
 <?php if ($articles) { ?>
<div class="nav_cart_block">
<ul class="nav_item_list">
        <?php foreach ($articles as $article) { ?>
              
        <li>
            <a href="<?php echo $article['href']; ?>">
                <img class="img-responsive" src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>"/>  </a>
                <span class="nav_cart_details">
                    <span class="nav_cart_title"><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></span>
            
                    <span class="nav_cart_price"> <em><?php echo $article['author']; ?></em></span>
                </span><!--nav_cart_details --> 
          
        </li>  
        
               
          <?php } ?>           
 </ul> 
 </div>
<?php } else { ?>
    <div class="nav_cart_block"><?php echo $text_empty_content;?></div>
<?php } ?>
 <div class="nav_cart_footer">
     <span class="clearfix">
     <a href="<?php echo $search_content;?>" class="btn btn-xs nav_cart_btn pull-right"><?php echo $text_advance_search;?></a>
     </span>
 </div>
 </div> <!--search-conetnt-results --> 
</div><!-- tab-content--> 