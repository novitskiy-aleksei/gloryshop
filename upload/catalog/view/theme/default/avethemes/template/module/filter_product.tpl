<?php if($options || $manufacturers || $attributes) { ?>
<div class="content_row">
      <h3 class="heading_title"><?php echo $heading_title; ?></h3>
	<div class="box-content">
    <div class="sidebar-filter">
		<form id="filter_product_form">
            
			<input type="hidden" name="pid" value="<?php echo $category_id ?>">
			<input type="hidden" name="path" value="<?php echo $path ?>">
			<input type="hidden" name="page" id="filter_product_page" value="<?php echo $page;?>">
			<input type="hidden" name="sort" id="filter_product_sort" value="<?php echo $sort;?>">
			<input type="hidden" name="order" id="filter_product_order" value="<?php echo $order;?>">
			<input type="hidden" name="limit" id="filter_product_limit" value="<?php echo $limit;?>">
			<?php if($manufacturers) { ?>
			<?php foreach($manufacturers as $manufacturer) { ?>
				<input type="hidden" class="m_name" id="m_<?php echo $manufacturer['manufacturer_id']?>" value="<?php echo $manufacturer['name']?>">
				<?php } ?>
			<?php } ?>

			<?php if($options) { ?>
			<?php foreach($options as $option) { ?>
				<?php foreach($option['option_values'] as $option_value) { ?>
					<input type="hidden" class="o_name" id="o_<?php echo $option_value['option_value_id']?>" value="<?php echo $option_value['name']?>">
					<?php } ?>
				<?php } ?>
			<?php } ?>

			<div class="portlet clearfix margin-bottom-20">
				<div class="portlet-title">
                <div class="caption thin"><?php echo $text_price_range?></div>
                <div class="tools"><a class="reload clear_filter" data-toggle="tooltip" title="<?php echo $text_reset_filter?>"></a></div>
                </div><!-- portlet-title--> 
				<div class="portlet-body">
				<label><?php echo $text_currency;?> <b class="badge yellow-bg"><?php echo $currency_code;?></b></label><br/>
				<div class="content_row margin-bottom-20">
                <div class="col-md-6 col-xs-6 pmin"><input class="price_limit" type="text" name="pmin" value="-1" id="pmin"/></div>
				<div class="col-md-6 col-xs-6 pmax"><input class="price_limit" type="text" name="pmax" value="-1" id="pmax"/></div>
                
                
				</div>
<div class="content_row">
	<div class="col-md-12 col-xs-12">
			<div id="price-range"></div>
     </div>
</div>
                </div><!-- portlet-body--> 
            </div><!-- portlet--> 
            
			<?php if($manufacturers&&isset($display_manufacturer)) { ?>
			<div class="portlet clearfix margin-bottom-20">
				<div class="portlet-title">
                <div class="caption thin"><?php echo $text_manufacturers; ?></div>
                <div class="tools"><a class="collapse"></a></div>
                </div><!-- portlet-title--> 
				<div class="portlet-body">
				<?php if($display_manufacturer == 'select') { ?>
					<select name="manufacturer[]" class="filtered form-control">
						<option value=""><?php echo $text_all?></option>
						<?php foreach($manufacturers as $manufacturer) { ?>
						<option id="manufacturer_<?php echo $manufacturer['manufacturer_id']?>" class="manufacturer_value" value="<?php echo $manufacturer['manufacturer_id']?>"><?php echo $manufacturer['name']?></option>
						<?php } ?>
					</select>
				<?php } elseif($display_manufacturer == 'checkbox') { ?>
                <div class="checkbox-list">
					<?php foreach($manufacturers as $manufacturer) { ?>
							<label for="manufacturer_<?php echo $manufacturer['manufacturer_id']?>">
							<input id="manufacturer_<?php echo $manufacturer['manufacturer_id']?>" class="manufacturer_value filtered"
								   type="checkbox" name="manufacturer[]" value="<?php echo $manufacturer['manufacturer_id']?>">
                                   <span><?php echo $manufacturer['name']?> </span>
                                   </label>
					<?php } ?>
				  </div><!--// --> 
				<?php } elseif($display_manufacturer == 'radio') { ?>
                <div class="radio-list">
					<?php foreach($manufacturers as $manufacturer) { ?>
						<label for="manufacturer_<?php echo $manufacturer['manufacturer_id']?>">
							<input id="manufacturer_<?php echo $manufacturer['manufacturer_id']?>" class="manufacturer_value filtered"
								   type="radio" name="manufacturer[]"
								   value="<?php echo $manufacturer['manufacturer_id']?>">
                                   <span><?php echo $manufacturer['name']?> </span>
						</label>
					
					<?php } ?>
				 </div><!--radio-list --> 
				<?php }?>
				</div><!--//portlet-body --> 
			</div><!--//portlet --> 
			<?php } ?>

			<?php if($attributes) {?>
			<?php foreach($attributes as $attribute_group_id => $attribute) {  ?>
			<?php if(!empty($attribute['attribute_values'])) {?>
			<div class="portlet clearfix margin-bottom-20">
				<div class="portlet-title">
                <div class="caption thin"><?php echo $attribute['name']; ?></div>
                <div class="tools"><a class="collapse"></a></div>
                </div><!-- portlet-title--> 
				<div class="portlet-body">
                
			<?php foreach($attribute['attribute_values'] as $attribute_value_id => $attribute_value) {?>
			<?php if($attribute_value['display']!='none') { ?>
                
			<div class="portlet">
				<div class="portlet-title">
                <div class="caption thin"><?php echo $attribute_value['name']; ?></div>
                <div class="tools"><a class="collapse"></a></div>
                </div><!-- portlet-title--> 
				<div class="portlet-body">
					<?php if(isset($attribute_value['display'])) { ?>
					<?php if($attribute_value['display'] == 'select') { ?>
						<select name="attribute_value[<?php echo $attribute_value_id?>][]" class="filtered form-control">
							<option value=""><?php echo $text_all?></option>
							<?php foreach($attribute_value['values'] as $i => $value) { ?>
							<option class="a_name"
									data-attr_id="<?php echo $attribute_value_id . '_' . $value ?>"
									data-attr_group_id="<?php echo $attribute_value_id . '_' . $value ?>"
									value="<?php echo $value ?>"><?php echo $value ?></option>
							<?php }?>
						</select>
					<?php } elseif($attribute_value['display'] == 'checkbox') {?>
					<div class="checkbox-list">
						<?php foreach($attribute_value['values'] as $i => $value) { ?>
								<label for="attribute_value_<?php echo $attribute_value_id . $i; ?>"
									   data-attr_group_id="<?php echo $attribute_value_id . '_' . $value ?>" data-value="<?php echo $value ?>">
						
								<input class="filtered a_name"
									   id="attribute_value_<?php echo $attribute_value_id . $i; ?>"
									   type="checkbox" name="attribute_value[<?php echo $attribute_value_id?>][]"
									   data-attr_id="<?php echo $attribute_value_id . '_' . $value ?>"
									   value="<?php echo $value ?>">
                                       
                                       <span><?php echo $value?></span></label>
						<?php } ?>
					</div><!--checkbox-list --> 
					<?php } elseif($attribute_value['display'] == 'radio') {?>
					<div class="radio-list">
						<?php foreach($attribute_value['values'] as $i => $value) { ?>
					<label for="attribute_value_<?php echo $attribute_value_id . $i; ?>" data-attr_group_id="<?php echo $attribute_value_id . '_' . $value ?>" data-value="<?php echo $value ?>">
								<input class="filtered a_name"
									   id="attribute_value_<?php echo $attribute_value_id . $i; ?>"
									   type="radio" name="attribute_value[<?php echo $attribute_value_id?>][]"
									   data-attr_id="<?php echo $attribute_value_id . '_' . $value ?>"
									   value="<?php echo $value ?>">
							<span><?php echo $value?></span>
                            
                            </label>
						
						<?php } ?>
					</div><!-- radio-list--> 
					<?php }?>
					<?php }?><!-- --> 
                
                </div><!-- portlet-body--> 
            </div><!-- portlet--> 
			<?php }//display ?>
            
				<?php } ?>
                
                </div><!-- portlet-body--> 
            </div><!-- portlet--> 
            
                
			<?php } ?>
                
			<?php } ?>
			<?php } ?>

			<?php if($options) { ?>
			<?php foreach($options as $option) { ?>
			<?php if($option['display']!='none') { ?>
            
			<div class="portlet clearfix margin-bottom-20">
				<div class="portlet-title">
                <div class="caption thin"><?php echo $option['name']; ?></div>
                <div class="tools"><a class="collapse"></a></div>
                </div><!-- portlet-title--> 
				<div class="portlet-body">
                
				<?php if(isset($option['display'])) { ?>
				<?php if($option['display'] == 'select') { ?>
					<select name="option_value[<?php echo $option['option_id']?>][]" class="filtered form-control">
						<option value=""><?php echo $text_all?></option>
						<?php foreach($option['option_values'] as $option_value) { ?>
						<option class="option_value" id="option_value_<?php echo $option_value['option_value_id']?>" value="<?php echo $option_value['option_value_id'] ?>"><?php echo $option_value['name']?></option>
						<?php }?>
					</select>
				<?php } elseif($option['display'] == 'checkbox') {?>
					<div class="checkbox-list">
						<?php foreach($option['option_values'] as $option_value) { ?>
						
								<label for="option_value_<?php echo $option_value['option_value_id']?>">
								<input class="filtered option_value" id="option_value_<?php echo $option_value['option_value_id']?>"
									   type="checkbox" name="option_value[<?php echo $option['option_id']?>][]"
									   value="<?php echo $option_value['option_value_id']?>">
                               <span> <?php echo $option_value['name']?></span>
                                
                                </label>
						
						<?php } ?>
					</div><!--checkbox-list --> 
				<?php } elseif($option['display'] == 'radio') {?>
					<div class="radio-list">
					<?php foreach($option['option_values'] as $option_value) { ?>
						<label for="option_value_<?php echo $option_value['option_value_id']?>">
							<input class="filtered option_value" id="option_value_<?php echo $option_value['option_value_id']?>"
								   type="radio" name="option_value[<?php echo $option['option_id']?>][]"
								   value="<?php echo $option_value['option_value_id']?>">
                               <span> <?php echo $option_value['name']?></span>
                            </label>
					
					<?php } ?>
					</div><!--radio-list --> 
				<?php }?>
				<?php }?>
                
                </div><!-- portlet-body--> 
            </div><!-- portlet option--> 
            
			<?php } ?>
			<?php } ?>
			<?php } ?>
		</form>
        </div>
	</div>
<script type="text/javascript">
	function getFilter(b) {
		var filter_product_query = $("#filter_product_form").serialize();
		var a = filter_product_query.replace(/[^&]+=\.?(?:&|$)/g, "").replace(/&+$/, "");
		if (!b) {
			window.location.hash = a;
		}
		$.ajax({url:"index.php?route=module/ave_product_filter/parse_filter_data",
		type:"POST",
		data:a + (b ? "&getPriceLimits=true" : ""),
		dataType:"json",
		success:function (json) {
			if (json['product']) {
				html_output='';		
				for (i = 0; i < json['product'].length; i++) {
					item_img = json['product'][i]['thumb'];
					html_output += '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
					html_output += '<div class="item_list_block">';
					html_output += '<div class="item_image">';
					html_output += '<a href="'+json['product'][i]['href']+'" data-id="'+json['product'][i]['product_id']+'" class="btn-quick-view" data-text="'+json['text_quickview']+'"><i class="fa fa-eye"></i> </a>';
					html_output += '<div class="item_img">';
							if(json['product'][i]['special']!=false){
					html_output += '<span class="ribbon_label">';
					html_output += '<span class="ribbon_text">'+json['text_sale']+'</span><span class="ribbon_circle sale"></span>';
					html_output += '</span>';
							}
					html_output += '<a href="'+json['product'][i]['href']+'" class="desc">'+json['product'][i]['description']+'</a>';
					html_output += '<img src="'+item_img+'" alt="'+json['product'][i]['name']+'">';
					html_output += '</div>';
					html_output += '</div>';
					html_output += '<div class="item_desc clearfix">';
					html_output += '<div class="title">';
					html_output += '<a href="'+json['product'][i]['href']+'" class="item_product_name">'+json['product'][i]['name']+'</a>';
					html_output += '</div>';
					html_output += '<div class="item-rating">';
					html_output += '<span class="star-'+json['product'][i]['rating']+'"></span>';
					html_output += '</div>';
					html_output += '<span class="item_price_group">';
							if(json['product'][i]['special']!=false){
					html_output += '<ins class="price-new">'+json['product'][i]['special']+'</ins> <del class="price-old">'+json['product'][i]['price']+'</del>';
							} else { 
					html_output += '<ins>'+json['product'][i]['price']+'</ins>';
							   }
							if(json['product'][i]['tax']!=false){	
					html_output += '<span class="price-tax">'+json['text_tax']+' '+json['product'][i]['tax']+'</span>';
							}
					html_output += '</span>';
					html_output += '<div class="button-group btn-cart-group">';
							if(json['btn_cart']==1){
					html_output += '<button type="button" class="btn btn-cart" onclick="cart.add(\''+json['product'][i]['product_id']+'\');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">'+json['text_cart']+'</span></button>';
							}
							if(json['btn_whistlist']==1){
					html_output += '<button type="button" class="btn btn-wish-list" onclick="wishlist.add(\''+json['product'][i]['product_id']+'\');" data-toggle="tooltip" title="'+json['text_wishlist']+'"><i class="fa fa-heart"></i> </button>';
							}
							if(json['btn_compare']==1){
					html_output += '<button type="button" class="btn btn-compare" onclick="compare.add(\''+json['product'][i]['product_id']+'\');" data-toggle="tooltip" title="'+json['text_compare']+'"><i class="fa fa-exchange"></i> </button>';
							}
					html_output += '</div>';
					html_output += '</div>';
					html_output += '</div>';
					html_output += '</div>';
					
				}//for items
				$("#product-layout").html(html_output);		
				var view='list';
				var storage_ready=false;
				if($("#product-layout").length){
				 storage_ready=true;
				}
				if(storage_ready==true&&localStorage.getItem('display')!=null){
					view = localStorage.getItem('display');
				}
				if (view == 'list') {
					$('#list-view').trigger('click');
				} else {
					$('#grid-view').trigger('click');
					Ave.handleQuickview();
				}
			}
		   $(".pagination_row .text-left").html(json['pagination']);
		   $(".pagination_row .text-right").html(json['pagination_results']);
		   parseFilter(b,json);
		}})
	}
</script>
<script src="assets/theme/widget/filter/filter.js" type="text/javascript"></script>
</div>
<?php } ?>
