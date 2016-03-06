<?php global $ave;?>

	<script src="assets/plugins/jquery-elevatezoom/elevatezoom.min.js"></script>
	<script src="catalog/view/javascript/jquery/datetimepicker/moment.js"></script>
	<script src="catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js"></script>

<!-- Body BEGIN -->
<div id="quickview-frame" class="quickview-frame">
<section class="section">
  <div class="content clearfix margin-top-20 margin-bottom-20">
<div class="content_row clearfix">
		<div class="notification"></div>
        <div id="content" class="<?php echo $ave->layout('content');?>">
       
      <div class="content_row margin-bottom-30">
        
        <div class="col-sm-6 col-xs-12">
	
	<?php
 $product_config =$ave->get('product_binding'); 
$tnwidth = $ave->getConfig('config_image_thumb_width');
$tnheight = $ave->getConfig('config_image_thumb_height');
  ?>  
    <div class="item_slider_wrapper lightbox_gallery" data-options="{attr:&#39;data-source&#39;,path:&#39;horizontal&#39;,skin:&#39;<?php echo $product_config['lightbox_skin'];?>&#39;}">
                  <div class="product-main-image item_img">
                  
      				<?php if ($special&&$sales_percent&&$product_config['special_label']=='1') { ?>
                        <span class="ribbon_label pc_dis">
                            <span class="ribbon_text"><strong><?php echo $sales_percent;?>%</strong><br/> 
                                     <small><?php echo $ave->text('special_label');?></small>
                            </span>
                            <span class="ribbon_circle special_bg"></span>
                        </span>
                    <?php } ?>
                     <?php if($thumb){ ?>
                    <img id="product<?php echo $product_id;?>" src="<?php echo $thumb; ?>" itemprop="image" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" class="img-responsive" data-zoom-image="<?php echo $zoom_image; ?>">
                  <a href="<?php echo $popup; ?>" data-source="<?php echo $popup; ?>" data-caption="<?php echo $heading_title; ?>" class="open_gallery active" id="open_gallery0"></a>
                  
                    <?php } else { ?>
                     <img id="product<?php echo $product_id;?>" src="<?php echo $ave->image('no_image.png',$tnwidth,$tnheight); ?>" alt="no_image.png">
                    <?php } ?>
                    
       <?php if ($images) {
         $i=0;
       foreach ($images as $image) {
            ?>
                    <a href="<?php echo $image['popup']; ?>" data-source="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="open_gallery" id="open_gallery<?php echo $i;?>"></a>
       		<?php  $i++; } ?>
    <?php } ?> 
                  </div>
     <div id="additional_images" class="gall_thumbs <?php echo $product_config['add_image_view'];?>">
               <?php if($thumb){ ?>
				  <div class="item">
             <a class="active" data-image="<?php echo $thumb; ?>" data-zoom-image="<?php echo $zoom_image; ?>" title="<?php echo $heading_title; ?>" data-gallery-id="open_gallery0"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"></a>
					</div>
              	<?php } ?>
                    
      <?php if ($images) { $i=0; ?>
        <?php foreach ($images as $image) { ?>
				  <div class="item">
                    <a class="<?php echo ($i==1&&(!$thumb))?'active':'';?>" data-image="<?php echo $image['thumb']; ?>" data-zoom-image="<?php echo $image['zoom_image']; ?>" title="<?php echo $heading_title; ?>" data-gallery-id="open_gallery<?php echo $i;?>"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"></a>
					</div>
        <?php $i++;  } ?>
        <?php } ?>
                  </div>
        </div><!--lightbox_gallery --> 
    <!--image_type=zoom --> 

  
	
           <?php if ($product_config['addthis_widget']==1) { ?>
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style margin-bottom-20">
            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
            <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a>
            <a class="addthis_counter addthis_pill_style"></a>
            </div>
            <!-- AddThis Button END -->
          <?php } ?>
        </div>
        <div class="col-sm-6 col-xs-12">
          <h2 class="item-info-title"><?php echo $heading_title; ?></h2>     
        <div class="item-info-bar clearfix">
        
				  <div class="btn-group btn-group-justified">
                   <div class="btn-group" role="group">
            <button type="button" id="button-whishlist" data-toggle="tooltip" class="btn btn-default btn-block" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="fa fa-heart"></i></button> </div>
             	<div class="btn-group" role="group">
            <button type="button" id="button-compare" data-toggle="tooltip" class="btn btn-default btn-block" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><i class="fa fa-exchange"></i></button>
            </div>
          </div>
          
            	</div>
        
        <div class="clearfix  margin-bottom-20">
        
          <?php if ($review_status) { ?>
						<div class="item-rating f_left">
							<span class="star-<?php echo $rating;?>"></span>
						</div><?php echo $reviews; ?>
            <?php } ?>   
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
            <li>
            <?php if (!$special) { ?>
              <ins><?php echo $price; ?></ins>
            <?php } else { ?>
            <ins><?php echo $special; ?></ins> <del><?php echo $price; ?></del>
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
                    <input type="number" step="1" min="1" name="quantity" value="<?php echo $minimum; ?>" id="input-quantity" class="input-text" size="4">
                    <input type="button" value="+" class="quantity_controll plus">
				</div>
                 
              <div class="btn_cart">           
              <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-block" style="width:100% !important;"><i class="fa fa-shopping-cart"></i> <?php echo $button_cart; ?></button>
              </div>
              
              </div><!-- quantity --> 
            </div>
            <?php if ($minimum > 1) { ?>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
            <?php } ?>
          </div>
         
        </div>
      </div>
      
      
     </div>
    </div><!-- //content row--> 
    </div><!-- //content spacer--> 
</section><!-- //main section-->
<script type="text/javascript"><!--
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
				$('.notification').html('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				$('.notification').find('a').attr('target','_parent');//modify frame target

				$('#cart > button').html('<i class="fa fa-shopping-cart"></i> ' + json['total']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');

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
<script type="text/javascript"><!--

	$(document).ready(function() {	
		var rtl_direction = false;
		if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
			rtl_direction = true;
		};
		$("#additional_images.owl-carousel").owlCarousel({
						rtl: rtl_direction,
						smartSpeed : 1000,
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
	});
//--></script> 
</div><!--//page_wrapper --> 