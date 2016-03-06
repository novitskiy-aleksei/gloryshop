<?php global $ave;
 echo $header; ?>
<section class="section page_title">
    <div class="content clearfix">
        <h1><?php echo $heading_title; ?></h1>
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo $breadcrumb['href']; ?>"><span itemprop="title"><?php echo str_replace('<i class="fa fa-home"></i>','<i class="fa fa-home"></i><b>Home</b>',$breadcrumb['text']); ?></span></a></li>
        <?php } ?>
    </ul>
    </div>
</section>
<section class="section">
  <div class="content content_spacer clearfix">
<div class="content_row clearfix">
<?php echo $column_left; ?>
        <div id="content" class="<?php echo $ave->layout('content');?>" itemscope itemtype="http://schema.org/Product">
        <?php echo $content_top; ?>
      <div class="row margin-bottom-30">
        <div class="col-sm-6 col-xs-12">
	
	<?php
 $product_config =$ave->get('product_binding'); 
$tnwidth = $ave->getConfig('config_image_thumb_width');
$tnheight = $ave->getConfig('config_image_thumb_height');
  ?>  
  <div class="item_slider_wrapper">
                  <div class="product-main-image item_img">
      				<?php if ($special&&$product_config['special_label']=='1') { ?>
                        <span class="ribbon_label pc_dis">
                            <span class="ribbon_text"><strong><?php echo $sales_percent;?>%</strong><br/> 
                                     <small><?php echo $ave->text('special_label');?></small>
                            </span>
                            <span class="ribbon_circle special_bg"></span>
                        </span>
                    <?php } ?>
                     <?php if($thumb){ ?>
                      <a <?php if($product_config['image_type']=='0'){ ?>href="<?php echo $popup; ?>"<?php } ?> title="<?php echo $heading_title; ?>">
                    <img id="product<?php echo $product_id;?>" src="<?php echo $thumb; ?>" itemprop="image" alt="<?php echo $heading_title; ?>" class="img-responsive" data-zoom-image="<?php echo $zoom_image; ?>"></a>
                    
                    <?php } else { ?>
                     <img id="product<?php echo $product_id;?>" src="<?php echo $ave->image('no_image.png',$tnwidth,$tnheight); ?>" itemprop="image" alt="no_image.png">
                    <?php } ?>
                    
                  </div>
     <div id="additional_images" class="gall_thumbs <?php echo $product_config['add_image_view'];?>">
               <?php if($thumb&&$product_config['image_type']=='1'){ ?>
				  <div class="item">
             <a <?php if($product_config['image_type']=='0'){ ?>href="<?php echo $popup; ?>"<?php } ?> class="active" data-image="<?php echo $thumb; ?>" data-zoom-image="<?php echo $zoom_image; ?>" title="<?php echo $heading_title; ?>" data-gallery-id="open_gallery0"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"></a>
					</div>
              	<?php } ?>
                    
      <?php if ($images) { $i=1; ?>
        <?php foreach ($images as $image) { ?>
				  <div class="item">
                    <a <?php if($product_config['image_type']=='0'){ ?>href="<?php echo $image['popup']; ?>"<?php } ?> class="<?php echo ($i==1&&(!$thumb))?'active':'';?>" data-image="<?php echo $image['thumb']; ?>" data-zoom-image="<?php echo $image['zoom_image']; ?>" title="<?php echo $heading_title; ?>" data-gallery-id="open_gallery<?php echo $i;?>"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"></a>
					</div>
        <?php $i++;  } ?>
        <?php } ?>
                  </div>
        </div><!--lightbox_gallery --> 
    <!--image_type=zoom --> 
 
	
         
        </div><!--//col -->
        <div class="col-sm-6 col-xs-12">
        
          
          <h2 class="item-info-title" itemprop="name"><?php echo $heading_title; ?></h2> 
          <div class="item-info-bar clearfix">
          <?php if ($review_status) { ?>
						<div class="item-rating f_left">
							<span class="star-<?php echo $rating;?>"></span>
						</div> 
                        <div class="hide" itemprop="AggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                       <span itemprop="ratingValue" class="hide"><?php echo $rating; ?>/<span itemprop="bestRating">5</span></span>
                       <span itemprop="ratingCount"><?php echo $rating_total;?></span>
                       </div>
                        <?php echo $reviews; ?>
                        
				
                
            <?php } ?>   
                   
                        <a onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;" class="write_review f_right"><?php echo $text_write; ?></a> 
                </div>
                <div class="item-info-bar clearfix">
          <ul class="list-unstyled">
            <?php if ($manufacturer) { ?>
            <li><?php echo $text_manufacturer; ?> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></li>
            <?php } ?>
            <li><?php echo $text_model; ?> <?php echo $model; ?></li>
            <?php if ($reward) { ?>
            <li><?php echo $text_reward; ?> <?php echo $reward; ?></li>
            <?php } ?>
            <li><?php echo $text_stock; ?> <?php echo $stock; ?></li>
          </ul>
          <?php if ($price) { ?>
          <ul class="list-unstyled item-info-price">
            <li itemprop="offers" itemscope itemtype="http://schema.org/Offer">
        <meta itemprop="name" content="<?php echo $heading_title; ?>"/>
            <?php if (!$special) { ?>
              <ins itemprop="price"><?php echo $price; ?></ins>
            <?php } else { ?>
            <ins itemprop="price"><?php echo $special; ?></ins> <del><?php echo $price; ?></del>
            <?php } ?>
            </li>
            <?php if ($tax) { ?>
            <li><?php echo $text_tax; ?> <?php echo $tax; ?></li>
            <?php } ?>
            <?php if ($points) { ?>
            <li><?php echo $text_points; ?> <?php echo $points; ?></li>
            <?php } ?>
            <?php if ($discounts) { ?>
            <li>
              <hr />
            </li>
            <?php foreach ($discounts as $discount) { ?>
            <li><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
            <?php } ?>
            <?php } ?>
          </ul>
          <?php } ?>
          </div>
          <div id="product">
            <?php if ($options) { ?>
            <h3><?php echo $text_option; ?></h3>
            <?php foreach ($options as $option) { ?>
            <?php if ($option['type'] == 'select') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                <?php if ($option_value['price']) { ?>
                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                <?php } ?>
                </option>
                <?php } ?>
              </select>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'radio') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <div id="input-option<?php echo $option['product_option_id']; ?>">
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="radio">
                  <label>
                    <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                    <?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'checkbox') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <div id="input-option<?php echo $option['product_option_id']; ?>">
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                    <?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'image') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <div id="input-option<?php echo $option['product_option_id']; ?>">
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="radio">
                  <label>
                    <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                    <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> <?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'text') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'textarea') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'file') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
              <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'date') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group date">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'datetime') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group datetime">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'time') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group time">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php if ($recurrings) { ?>
            <hr />
            <h3><?php echo $text_payment_recurring ?></h3>
            <div class="form-group required">
              <select name="recurring_id" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($recurrings as $recurring) { ?>
                <option value="<?php echo $recurring['recurring_id'] ?>"><?php echo $recurring['name'] ?></option>
                <?php } ?>
              </select>
              <div class="help-block" id="recurring-description"></div>
            </div>
            <?php } ?>
            <div class="form-group">
              <label class="control-label" for="input-quantity"><?php echo $entry_qty; ?></label>
              <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
              
						<div class="quantity buttons_added clearfix">
              <div>
                    <input type="button" value="-" class="quantity_controll minus">
                    <input type="text" step="1" min="1" name="quantity" value="<?php echo $minimum; ?>" id="input-quantity" class="input-text" size="4">
                    <input type="button" value="+" class="quantity_controll plus">
				</div>
                 
              <div class="btn_cart">           
            <?php if($product_config['btn_cart']){?>  
            <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> <span class="hidden-sm"><?php echo $button_cart; ?></span></button>
            <?php } ?>
            <?php if($product_config['btn_whistlist']){?>
               <button type="button" data-toggle="tooltip" class="btn btn-default" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="fa fa-heart"></i></button> 
            <?php } ?>
               <?php if($product_config['btn_compare']){?>
            <button type="button" data-toggle="tooltip" class="btn btn-default" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><i class="fa fa-exchange"></i></button>
            <?php } ?>
              </div>
              
              </div><!-- quantity --> 
            </div>
            <?php if ($minimum > 1) { ?>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
            <?php } ?>
             <?php if ($product_config['addthis_widget']==1) { ?>
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style margin-top-30">
            <a class="addthis_button_facebook_like" ></a>
            <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a>
            <a class="addthis_counter addthis_pill_style"></a>
            </div>
            <!-- AddThis Button END -->
          <?php } ?>
          </div>
         
        </div>
      </div><!-- row --> 
      <div class="row margin-bottom-30 clearfix">
      <div class="col-sm-12">
       
          <div class="elem-tabs tabs2 is-ended clearfix">
		  <nav>
          <ul id="tabs_info" class="tabs-navi">
            <li class="active"><a href="#tab-description" data-toggle="tab" class="selected"><?php echo $tab_description; ?></a></li>
            <?php if ($attribute_groups) { ?>
            <li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
            <?php } ?>
            <?php if ($review_status) { ?>
            <li><a href="#tab-review" data-toggle="tab"><?php echo $tab_review; ?></a></li>
            <?php } ?>
          </ul>
		  </nav>
          <div class="tabs-body tab-content clearfix">
            <div class="tab-pane active selected" id="tab-description"><?php echo $description; ?></div>
            <?php if ($attribute_groups) { ?>
            <div class="tab-pane" id="tab-specification">
              <table class="table table-bordered">
                <?php foreach ($attribute_groups as $attribute_group) { ?>
                <thead>
                  <tr>
                    <td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                  <tr>
                    <td><?php echo $attribute['name']; ?></td>
                    <td><?php echo $attribute['text']; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
                <?php } ?>
              </table>
            </div>
            <?php } ?>
            <?php if ($review_status) { ?>
            <div class="tab-pane" id="tab-review">
              <form class="form-horizontal" id="form-review">
                <div id="review" class="commerce_comments"></div>
                <h2><?php echo $text_write; ?></h2>
                <?php if ($review_guest) { ?>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                    <input type="text" name="name" value="" id="input-name" class="form-control" />
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
                    <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                    <div class="help-block"><?php echo $text_note; ?></div>
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label"><?php echo $entry_rating; ?></label>
                    &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                    <input type="radio" name="rating" value="1" />
                    &nbsp;
                    <input type="radio" name="rating" value="2" />
                    &nbsp;
                    <input type="radio" name="rating" value="3" />
                    &nbsp;
                    <input type="radio" name="rating" value="4" />
                    &nbsp;
                    <input type="radio" name="rating" value="5" />
                    &nbsp;<?php echo $entry_good; ?></div>
                </div>
                    
              <?php echo isset($captcha)?$captcha:''; ?>
                  <?php if (isset($site_key)) { ?>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
                    </div>
                  </div>
                <?php } ?>
            
                <div class="buttons clearfix">
                  <div class="pull-right">
                    <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
                  </div>
                </div>
                <?php } else { ?>
                <?php echo $text_login; ?>
                <?php } ?>
              </form>
            </div>
            <?php } ?>
          </div>
          </div><!--//elem tab --> 
          </div><!-- col--> 
          </div><!-- row decription--> 
          
          
      <?php
      $product_related = $ave->get('product_related');
      $related_class = ($product_related['type']=='carousel-grid')?'owl-carousel':'';
       if ($products&&$product_related['status']==1) { ?>
     <div class="clearfix">
<h2 class="heading_title"><span class="line"></span><?php echo $text_related; ?></h2>
</div>
<?php  if ($product_related['type']=='item-grid') { ?>
<div class="row">
<?php } ?>
<div id="product_related" class="elem_item_grid <?php echo $related_class; ?> carousel-nav-top product-layout">
<?php foreach ($products as $product) { ?>
<?php  if ($product_related['type']=='item-grid') { ?>
<div class="<?php echo 'col-md-'.$product_related['grid_limit'].' col-sm-'.$product_related['grid_limit'];?>">
<?php } ?>
<div class="item_list_block ">
        <div class="item_image">
            <a href="<?php echo $product['href']; ?>" data-id="<?php echo $product['product_id']; ?>" class="btn-quick-view" title="<?php echo $product['name']; ?>" data-text="<?php echo $ave->text('btn_quickview');?>"><i class="fa fa-eye"></i></a>
            <div class="item_img">
                <?php if ($product['special']) { ?>
                <span class="ribbon_label">
                    <span class="ribbon_text"><?php echo $ave->text('special_label');?></span><span class="ribbon_circle sale"></span>
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
<?php  if ($product_related['type']=='item-grid') { ?>
    </div><!-- //grid limit--> 
<?php } ?>
    
<?php } ?>
<?php  if ($product_related['type']=='item-grid') { ?>
    </div><!-- //grid row--> 
<?php } ?>
</div>
<?php if ($product_related['type']=='carousel-grid') { ?>
<script type="text/javascript">
$('#product_related').owlCarousel({
		margin: 10,
		loop: true,
		items: <?php echo $product_related['carousel_limit'];?>, 
		autoWidth: false,
		dots: false,
		nav: true,
		navText: ["<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>","<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
		responsive: {
			0: {items: 1},
			479: {items: <?php echo ($product_related['carousel_limit']>1)?'2':'1';?>},
			768: {items: <?php echo ($product_related['carousel_limit']>1)?'2':'1';?>},
			979: {items: <?php echo ($product_related['carousel_limit']>1)?'3':'1';?>},
			1199: {items: <?php echo $product_related['carousel_limit'];?>}
		}
	});
</script>
<?php } ?>
      <?php } ?>
   <?php if (!empty($tags)) { ?>
         <div class="tagcloud clearfix">
        <span class="pull-left"><?php echo $text_tags;?> </span>&nbsp;&nbsp;
           <?php foreach ($tags as $tag) { ?>
    <a href="<?php echo $tag['href'];?>"><span class="tag"><i class="fa fa-tags"></i> <?php echo $tag['tag'];?></span></a>
        <?php } ?>
    </div>
  <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div><!-- //content row--> 
    </div><!-- //content spacer--> 
</section><!-- //main section--> <script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
					$('.notify').remove();
					$('#page_wrapper').append('<div class="notify"><div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
					$('.notify').addClass('active');
						
				$('#cart > button').html('<i class="fa fa-shopping-cart"></i> ' + json['total']);

				$('#cart > ul').load('index.php?route=common/cart/info');
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});
/**/

<?php if($product_config['image_type']=='0'){?> 
$(document).ready(function() {
	$('.item_slider_wrapper').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});
<?php } ?>
//--></script>
 
<script type="text/javascript"><!--

	$(document).ready(function() {	
		var rtl_direction = false;
		if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
			rtl_direction = true;
		};
		$("#additional_images.owl-carousel").owlCarousel({
						rtl: rtl_direction,
						slideSpeed : 1000,
						autoplay: true,
						autoplayTimeout:4000,
						autoHeight : true,
						items:4,
						stopOnHover : true,
						nav : false,
						navText : [
							"<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
							"<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
						dots: false,
		});
<?php if($product_config['image_type']=='1'){ ?>
<?php
	$zoom_setting		="";
	$rtl_setting 		="";
	$direction 			= $ave->layout('direction');
	$zoomWindowWidth 	= (!empty($product_config['zoomWindowWidth']))?$product_config['zoomWindowWidth']:480;
	$zoomWindowHeight 	= (!empty($product_config['zoomWindowHeight']))?$product_config['zoomWindowHeight']:480;
	
		$external_setting 	="lensSize:100, zoomWindowWidth:".$zoomWindowHeight.",zoomWindowHeight:".$zoomWindowHeight;	
		$lensSize = (!empty($product_config['lensSize']))?$product_config['lensSize']:250;
		$lens_setting 		="zoomType: 'lens', containLensZoom: true, cursor: 'pointer', lensShape: 'round',lensSize:".$lensSize;
		$inner_setting 		="zoomType : 'inner', cursor: 'crosshair'";		
		if($direction=='rtl'){
			$rtl_setting .="zoomWindowPosition: 11,";	
		}
		
	 if($product_config['zoom_type']=='lens'){
		 $zoom_setting		.=$lens_setting;
	}else if($product_config['zoom_type']=='inner'){	
		 $zoom_setting		.=$inner_setting;	
	}else{	
		 $zoom_setting		.=$rtl_setting.$external_setting;	
	}
?>
		var otps =[];
		otps['desktop']={gallery : 'additional_images',easing: true,galleryActiveClass: 'active',<?php echo $zoom_setting;?>}	
		
		<?php if($product_config['zoom_type']=='external'){?>
		otps['tablet']={gallery : 'additional_images',easing: true,galleryActiveClass: 'active',<?php echo $rtl_setting;?>zoomWindowWidth:480,zoomWindowHeight:480}	
		otps['lmobile']={gallery : 'additional_images',easing: true,galleryActiveClass: 'active',<?php echo $lens_setting;?>}
		<?php }else{ ?>		
		otps['tablet']={gallery : 'additional_images',easing: true,galleryActiveClass: 'active',<?php echo $zoom_setting;?>}	
		otps['lmobile']={gallery : 'additional_images',easing: true,galleryActiveClass: 'active',<?php echo $zoom_setting;?>}
		<?php } ?>
			
		<?php if($product_config['zoom_type']=='inner'){?>
		otps['mobile']={gallery : 'additional_images',easing: true,galleryActiveClass: 'active',<?php echo $inner_setting;?>}
			<?php }else{ ?>	
		otps['mobile']={gallery : 'additional_images',easing: true,galleryActiveClass: 'active',<?php echo $lens_setting;?>}
		<?php } ?>
		Ave.handleElevateZoom("#product<?php echo $product_id;?>",otps);
<?php } ?>
	});
//--></script> 
<?php echo $footer; ?>