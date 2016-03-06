 <div class="content_row">
                <div class="elem-tabs tabs2 hide_arrow sidebar-tabs">
        <nav class="clearfix">
               <ul id="product_tabs<?php echo $module;?>" class="tabs-navi">
                             <?php $i=0;?>
              <?php foreach ($products_sort as $key=>$value) { ?>
              <?php if (!empty($product_tabs[$value])) { ?> 
        <li class="<?php echo ($i==0)?'active':'';?>"><a href="#product<?php echo $module;?>-tabs-grid_<?php echo $value; ?>" data-toggle="tab" class="<?php echo ($i==0)?'selected':'';?>"><span <?php echo ($i==0)?'':'data-toggle="tooltip" title="'.$tabs_title[$value].'" class="icon_alone"';?>><?php echo $tabs_icon[$value]; ?></span><span class="tlabel <?php echo ($i==0)?'':'hide';?>"><?php echo $tabs_title[$value]; ?></span></a></li>      
                  
              <?php $i++; } ?>      
              <?php } ?> 
               </ul>
        </nav>
                  <div class="tab-content">
                  <?php $i=0;?>
      <?php foreach ($products_sort as $key=>$value) {  ?>
      <?php if (!empty($product_tabs[$value])) { ?>
 <div class="tab-pane fade in <?php echo ($i==0)?'active':'';?>" id="product<?php echo $module;?>-tabs-grid_<?php echo $value; ?>">
<div id="<?php echo $module;?>_<?php echo $i;?>">
 
      <div class="posts_widget">
        <ul class="posts_widget_list">
     <?php foreach ($product_tabs[$value] as $product) { ?>
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
<?php } ?><!-- for--> 
        </ul>
    </div>
      
    </div><!--item-grid-->
   
    </div><!-- //tab-pane--> 
      <?php $i++; } ?>      
      <?php } ?>  
      </div><!-- //tab-content-->  
       </div><!-- elem-tabs--> 
    </div>