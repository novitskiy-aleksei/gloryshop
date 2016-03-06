<?php
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveProductFilter extends Controller {
	public function index($setting=array()) {
		if(defined('ave_check')){
		$language_data = $this->load->language('avethemes/product_filter');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$data['ave']  = $this->ave;		
		$data['position'] = $position = isset($setting['layout_position'])?$setting['layout_position']:'content_top';
		$data['side_position'] = $side_position = $this->ave->sidePosition();

		$data['currency_code']  = $this->currency->getCode();

		$data['setting'] = $setting;

			$ave_product_filter_setting = $this->config->get('ave_product_filter_setting');
	

		if(isset($this->request->get['path'])) {

		$parts = explode('_', (string)$this->request->get['path']);
		$category_id = array_pop($parts);
		$this->load->model('avethemes/filter_product');

		$data['manufacturers'] = false;
		if(isset($ave_product_filter_setting['display_manufacturer'])){
			if($ave_product_filter_setting['display_manufacturer'] != 'none') {
				$data['manufacturers'] = $this->model_avethemes_filter_product->getManufacturersByCategoryId($category_id);
				$data['display_manufacturer'] = $ave_product_filter_setting['display_manufacturer'];
			}
		}
		$data['options'] = $this->model_avethemes_filter_product->getOptionsByCategoryId($category_id);
		foreach($data['options'] as $i => $option) {			
					if(isset($ave_product_filter_setting['display_option_' . $option['option_id']])){
						$display_option = $ave_product_filter_setting['display_option_' . $option['option_id']];
						if($display_option != 'none') {
							$data['options'][$i]['display'] = $display_option;
						}else{
							$data['options'][$i]['display'] = 'none';
						}
					} else {
						unset($data['options'][$i]);
					}
				
		}

		$data['attributes'] = $this->model_avethemes_filter_product->getAttributesByCategoryId($category_id);

		foreach($data['attributes'] as $j => $attribute_group) {
			foreach($attribute_group['attribute_values'] as $attribute_id => $attribute) {
				
					if(isset($ave_product_filter_setting['display_attribute_' . $attribute_id])){
						$display_attribute = $ave_product_filter_setting['display_attribute_' . $attribute_id];
						if($display_attribute != 'none') {
							$data['attributes'][$j]['attribute_values'][$attribute_id]['display'] = $display_attribute;							
						}else{
							unset($data['attributes'][$j]['attribute_values'][$attribute_id]);
							if(!$data['attributes'][$j]['attribute_values']) {
								unset($data['attributes'][$j]);
							}
						}
					} else {
							unset($data['attributes'][$j]['attribute_values'][$attribute_id]);
							if(!$data['attributes'][$j]['attribute_values']) {
								unset($data['attributes'][$j]);
							}
					}
				
			}
		}

		$data['category_id'] = $category_id;
		$data['path'] = $this->request->get['path'];

		if($data['options'] || $data['manufacturers'] || $data['attributes']) {
			$this->document->addStyle('assets/editor/plugins/jquery-ui/jquery-ui.css');
			$this->document->addScript('assets/editor/plugins/jquery-ui/jquery-ui.js');
	  		$this->document->addScript('assets/plugins/jquery-migrate-1.2.1.min.js');
			$this->document->addStyle('assets/theme/widget/filter/filter.css');
		}

		if (isset($this->request->get['sort'])) {
			$data['sort'] = $this->request->get['sort'];
		} else {
			$data['sort'] = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$data['order'] = $this->request->get['order'];
		} else {
			$data['order'] = 'ASC';
		}
		
							
		if (isset($this->request->get['page'])) {
			$data['page'] = $this->request->get['page'];
		} else {
			$data['page'] = 1;
		}
							
		if (isset($this->request->get['limit'])) {
			$data['limit'] = $this->request->get['limit'];
		} else {
			$data['limit'] = $this->config->get('config_product_limit');
		}
		
		if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/module/filter_product.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/module/filter_product.tpl';
		} else {
			$this_template = 'default/avethemes/template/module/filter_product.tpl';
		}
		return $this->load->view($this_template, $data);
		}
		}
	}

	private function array_clean(array $haystack) {
		foreach($haystack as $key => $value) {
			if(is_array($value)) {
				$haystack[$key] = $this->array_clean($value);
				if(!count($haystack[$key])) {
					unset($haystack[$key]);
				}
			} elseif(is_string($value)) {
				$value = trim($value);
				if(!$value) {
					unset($haystack[$key]);
				}
			}
		}
		return $haystack;
	}

	public function parse_filter_data() {
		$language_data = $this->load->language('avethemes/product_filter');
		
			$ave_product_filter_setting = $this->config->get('ave_product_filter_setting');
			$page = 1;
			
		if(isset($this->request->post['page'])) {
			$page = (int)$this->request->post['page'];
		}
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		}elseif(isset($this->request->post['sort'])) {
			$sort = $this->request->post['sort'];
		}else{
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$sort = $this->request->get['order'];
		}elseif(isset($this->request->post['order'])) {
			$order = $this->request->post['order'];
		}else{
			$order = 'ASC';
		}
		if (isset($this->request->get['limit'])) {
			$sort = $this->request->get['limit'];
		}elseif(isset($this->request->post['limit'])) {
			$limit = $this->request->post['limit'];
		}else{
			$limit = $this->config->get('config_product_limit');
		}


		$this->load->model('avethemes/filter_product');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$manufacturer = false;
		if(isset($this->request->post['manufacturer'])) {
			$manufacturer = $this->array_clean($this->request->post['manufacturer']);
			if(!count($manufacturer)) {
				$manufacturer = false;
			}
		}

		$option_value = false;
		if(isset($this->request->post['option_value'])) {
			$option_value = $this->array_clean($this->request->post['option_value']);
			if(!count($option_value)) {
				$option_value = false;
			}
		}

		$attribute_value = false;
		if(isset($this->request->post['attribute_value'])) {
			$attribute_value = $this->array_clean($this->request->post['attribute_value']);
			if(!count($attribute_value)) {
				$attribute_value = false;
			}
		}

		$filter_data = array(
			'option_value' => $option_value,
			'manufacturer' => $manufacturer,
			'attribute_value' => $attribute_value,
			'category_id' => $this->request->post['pid'],
			'pmin' => $this->request->post['pmin'],
			'pmax' => $this->request->post['pmax'],
			'start' => ($page - 1) * $limit,
			'limit' => $limit,
			'sort' => $sort,
			'order' => $order
		);

		$product_total = $this->model_avethemes_filter_product->getTotalProducts($filter_data);

		$totals_manufacturers = $this->model_avethemes_filter_product->getTotalManufacturers($filter_data);

		$totals_options = $this->model_avethemes_filter_product->getTotalOptions($filter_data);

		$totals_attributes = $this->model_avethemes_filter_product->getTotalAttributes($filter_data);

		$products = $this->model_avethemes_filter_product->getProducts($filter_data);


		$result = array();

		$pmin = false;
		$pmax = false;

		if(isset($this->request->post['getPriceLimits']) && $this->request->post['getPriceLimits']) {
			$priceLimits = $this->model_avethemes_filter_product->getPriceLimits($filter_data);
			$pmin = $priceLimits['pmin'];
			$pmax = $priceLimits['pmax'];
		}
		
		$special_label = $this->ave->get('category_special_label');
		$no_image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
		foreach($products as $product) {
			if ($product['image']&&file_exists(DIR_IMAGE.$product['image'])) {
				$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			} else {
				$image = $no_image;
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}

			if ((float)$product['special']&&$special_label==1) {
				$special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$product['special'] ? $product['special'] : $product['price']);
			} else {
				$tax = false;
			}

			if ($this->config->get('config_review_status')) {
				$rating = (int)$product['rating'];
			} else {
				$rating = false;
			}


			if($product['quantity'] <= 0) {
				$rstock = $product['stock_status'];
			} elseif($this->config->get('config_stock_display')) {
				$rstock = $product['quantity'];
			} else {
				$rstock = $this->language->get('text_instock');
			}
			$result[] = array(
				'product_id' => $product['product_id'],
				'sku' => $ave_product_filter_setting['sku_display'] ? $product['sku'] : false,
				'model' => $ave_product_filter_setting['model_display'] ? $product['model'] : false,
				'brand' => $ave_product_filter_setting['brand_display'] ? $product['manufacturer'] : false,
				'location' => $ave_product_filter_setting['location_display'] ? $product['location'] : false,
				'upc' => $ave_product_filter_setting['upc_display'] ? $product['upc'] : false,
				'stock' => $ave_product_filter_setting['stock_display'] ? $rstock : false,
				'image' => $image,
				'thumb' => $image,
				'special' => $special,
				'tax' => $tax,
				'rating' => $rating,
				'reviews'     => sprintf($this->language->get('text_reviews'), (int)$product['reviews']),
				'name' => $product['name'],
				'description' => utf8_substr(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
				'price' => $price,
				'href' => $this->url->link('product/product', 'path=' . $this->request->post['path'] . '&product_id=' . $product['product_id'])
			);
		}
		
		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = 'page={page}';
			
		$json['pagination']  = $pagination->render();
		$json['pagination_results']  =  sprintf($this->language->get('text_pagination'), ($product_total) ? ((int)($page - 1) * $limit) + 1 : 0, (((int)($page - 1) * $limit) > (int)($product_total - $limit)) ? $product_total : (((int)($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
		

		$pmin = $this->currency->convert($pmin, $this->config->get('config_currency'), $this->currency->getCode());
		$pmax = $this->currency->convert($pmax, $this->config->get('config_currency'), $this->currency->getCode());
		
		$json['code']	 = $this->currency->getCode();
		$json['product']	 = $result;
		$json['pmin'] 	 = $pmin;
		$json['pmax'] 	 = $pmax;
		
		$json['btn_cart'] 	 =  $this->ave->get('category_btn_cart');
		$json['btn_whistlist'] 	 =  $this->ave->get('category_btn_whistlist');
		$json['btn_compare'] 	 =  $this->ave->get('category_btn_compare');
		
		
		foreach($language_data as $key=>$value){
			$json[$key] = $value;
		}
		
		$json['totals_data'] = array(
									'manufacturers' => $totals_manufacturers,
									'options' => $totals_options,
									'attributes' => $totals_attributes
								);
		$json_encode = 		json_encode($json);	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput($json_encode);		
	}
}

?>