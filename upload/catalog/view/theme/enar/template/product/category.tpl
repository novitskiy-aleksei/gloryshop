<?php global $ave;
$special_label = $ave->get('category_special_label');
$btn_cart = $ave->get('category_btn_cart');
$btn_whistlist = $ave->get('category_btn_whistlist');
$btn_compare = $ave->get('category_btn_compare');
$num_btn = 0;
if($btn_cart==1){$num_btn++;}
if($btn_whistlist==1){$num_btn++;}
if($btn_compare==1){$num_btn++;}
 echo $header; ?>
<section class="section page_title">
    <div class="content clearfix">
        <h1><?php echo $heading_title; ?></h1>
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo $breadcrumb['href']; ?>"><span itemprop="title"><?php echo str_replace('<i class="fa fa-home"></i>','<i class="fa fa-home"></i> <b>Home</b>',$breadcrumb['text']); ?></span></a></li>
        <?php } ?>
    </ul>
    </div>
</section>
<section class="section">
  <div class="content content_spacer clearfix">
<div class="content_row clearfix">
<?php echo $column_left; ?>
        <div id="content" class="<?php echo $ave->layout('content');?>">
        <?php echo $content_top; ?>
      <h2 class="title1 upper"><?php echo $heading_title; ?></h2>
      <?php if ($thumb || $description) { ?>
      <div class="row">
        <?php if ($thumb) { ?>
        <div class="col-sm-2"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
        <?php } ?>
        <?php if ($description) { ?>
        <div class="col-sm-10"><?php echo $description; ?></div>
        <?php } ?>
      </div>
      <hr>
      <?php } ?>
      <?php if ($categories) { ?>
      <div class="row category_refine <?php echo $ave->get('category_refine');?>">
        <div class="col-sm-12">
      <h3><?php echo $text_refine; ?></h3>
      </div>
      <?php if (count($categories) <= 5) { ?>
        <div class="col-sm-3">
          <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
      <?php } else { ?>
        <?php foreach (array_chunk($categories, ceil(count($categories) / 4)) as $categories) { ?>
        <div class="col-sm-3">
          <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>
      <?php } ?>
      </div>
      <?php } ?>
      <?php if ($products) { ?>
      <p class="text-right"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></p>
      <div class="item-sorting clearfix">
        <div class="col-md-2 col-sm-12 col-xs-12">
            <div class="row">
              <div class="btn-group">
                <button type="button" id="list-view" class="btn btn-primary" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i> </button>
                <button type="button" id="grid-view" class="btn btn-primary" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i> </button>
              </div>
          </div>
        </div>
        <div class="col-md-5 col-sm-6 col-xs-12">
            <div class="form-group  item-sort-order">
                  <label class="col-md-4 control-label"><?php echo $text_sort; ?></label>
                    <div class="col-md-8">
                    <div class="item-sort-label">
                      <select id="input-sort" class="form-control" onchange="location = this.value;">
                        <option><?php echo $text_sort; ?></option>
                        <?php foreach ($sorts as $sorts) { ?>
                        <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                        <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                    </div>
                </div><!--// item-sort-order --> 
        </div>
        <div class="col-md-5 col-sm-6 col-xs-12">
            <div class="form-group  item-sort-order">
              <label class="col-md-4 control-label"><?php echo $text_limit; ?></label>
                    <div class="col-md-8">
                    	<div class="item-sort-label">
                          <select id="input-limit" class="form-control" onchange="location = this.value;">
                            <?php foreach ($limits as $limits) { ?>
                            <?php if ($limits['value'] == $limit) { ?>
                            <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                            <?php } ?>
                            <?php } ?>
                          </select>
                      </div>
                    </div>
            </div><!--// item-sort-order --> 
        </div>
      </div>
      <div class="clearfix">
<div id="product-layout" class="row product-layout elem_item_grid with-<?php echo $num_btn;?>-btn">
<?php foreach ($products as $product) { ?>
<div class="col-md-4">
<div class="item_list_block">
        <div class="item_image">
            <a href="<?php echo $product['href']; ?>" data-id="<?php echo $product['product_id']; ?>" class="btn-quick-view" title="<?php echo $product['name']; ?>" data-text="<?php echo $ave->text('btn_quickview');?>"><i class="fa fa-eye"></i></a>
            <div class="item_img">
                <?php if (isset($product['sales_percent'])&&$product['special']&&$special_label) { ?>
                    <span class="ribbon_label pc_dis">
                            <span class="ribbon_text"><strong><?php echo $product['sales_percent'];?>%</strong><br/> 
                                     <small><?php echo $ave->text('special_label');?></small>
                            </span>
                            <span class="ribbon_circle special_bg"></span>
                     </span>
                <?php } ?>
                <a href="<?php echo $product['href']; ?>" class="desc"><?php echo $product['description']; ?></a>
                <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>">
            </div>
        </div>
        <div class="item_desc clearfix">
            <div class="title">
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
	<?php if($ave->get('category_btn_cart')=='1'){ ?>
<button type="button" class="btn btn-cart" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
        <?php } ?>
               <?php if($ave->get('category_btn_whistlist')=='1'){ ?>
<button type="button" class="btn btn-wish-list" onclick="wishlist.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>"><i class="fa fa-heart"></i> </button>
        <?php } ?>
               <?php if($ave->get('category_btn_compare')=='1'){ ?>
<button type="button" class="btn btn-compare" onclick="compare.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_compare; ?>"><i class="fa fa-exchange"></i> </button>
        <?php } ?>
			</div>
        </div>
    </div>
    </div>
<?php } ?>    
    </div><!--product-layout-->   
</div>
      <div class="row pagination_row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><span class="pagination_results"><?php echo $results; ?></span></div>
      </div>
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div><!-- //content row--> 
    </div><!-- //content spacer--> 
</section><!-- //main section--> 
<?php echo $footer; ?>
