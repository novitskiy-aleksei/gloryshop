<?php  
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerAvethemesWidget extends Controller {
	public function quicksearch() { 	
		$language_data = $this->load->language('avethemes/global_lang');
		
		$width = $this->ave->get('search_image_width');
		$height = $this->ave->get('search_image_height');
		
		if(empty($width)||empty($height)){
			$width = 100;
			$height = 75;
		}
		$this->load->model('tool/image');
			
		$content_installed = false;
		if ($this->config->get('ave_confirm_installed')==1) {
			$content_installed = 1;
		}
		
		$search_content = false;
		if (isset($this->request->get['search_content'])) {
			$search_content = true;
		}
		$filter_name = '';
		if (isset($this->request->get['search'])) {
			$filter_name = $this->request->get['search'];
		}		
			
		$limit = $this->ave->get('search_result_limit');
		if (empty($limit)) {
			$limit = 4;	
		} 							
		$filter_data = array(
			'filter_name'  => $filter_name,
			'start'        => 0,
			'limit'        => $limit
		);
			
			$data['no_image'] = $this->model_tool_image->resize('no_image.png', $width, $height);
			$data['text_empty_product'] =  $this->language->get('text_empty_product');
			$data['text_empty_content'] =  $this->language->get('text_empty_content');
			$data['text_search_product'] =  $this->language->get('text_search_product');
			$data['text_search_content'] =  $this->language->get('text_search_content');
			$data['text_advance_search'] =  $this->language->get('text_advance_search');
			$data['button_cart'] =  $this->language->get('button_cart');

			$data['search_catalog'] = $this->url->link('product/search','&search=' . $filter_name);
			$data['search_content'] = $this->url->link('content/search','&search=' . $filter_name);
		
			$data['products'] = array();
			$data['articles'] = array();
			$data['content_installed'] = $content_installed;
			
			$this->load->model('avethemes/global');					
			$products = $this->model_avethemes_global->getProducts($filter_data);
			
			foreach ($products as $product) {	
				if ($product['image']&&file_exists(DIR_IMAGE.$product['image'])) {
					$image = $this->model_tool_image->resize($product['image'], $width, $height);
				} else {
					$image = $this->model_tool_image->resize('no_image.png', $width, $height);
				}
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
				
				if ((float)$product['special']) {
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
				$data['products'][] = array(
					'product_id'  => $product['product_id'],
					'thumb'       => $image,
					'name'        => $product['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8')), 0, 64) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $product['rating'],
					'href'        => $this->url->link('product/product','product_id=' . $product['product_id'] )
				);
		}
		
		if (!empty($filter_name)&&$content_installed==1) {
			$this->load->model('avethemes/article');
			$articles = $this->model_avethemes_article->getArticles($filter_data);
			
			foreach ($articles as $article) {	
				if ($article['image']&&file_exists(DIR_IMAGE.$article['image'])) {
					$image = $this->model_tool_image->resize($article['image'],$width, $height);
				} else {
					$image = $this->model_tool_image->resize('no_image.png', $width, $height);
				}				
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$article['rating'];
				} else {
					$rating = false;
				}			
				$data['articles'][] = array(
					'article_id'  => $article['article_id'],
					'name'        => $article['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($article['description'], ENT_QUOTES, 'UTF-8')), 0, 64) . '..',
					'thumb'       => $image,
					'date_added' => date($this->config->get('ave_cms_date_format'), strtotime($article['date_added'])),
					'author'        => $article['author'],
					'rating'      => $article['rating'],
					'viewed'     => sprintf($this->language->get('text_viewed'), (int)$article['viewed']),
					'comments'     => sprintf($this->language->get('text_comments'), (int)$article['comments']),
					'href'        => $this->url->link('content/article','article_id=' . $article['article_id'] )
				);
			}	
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/widget/quicksearch.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/widget/quicksearch.tpl';
		} else {
			$this_template = 'default/avethemes/template/widget/quicksearch.tpl';
		}			
		$this->response->setOutput($this->load->view($this_template, $data));	
		
	}
	public function nav_catalog($setting) {	
		$this->load->model('tool/image');	
		   foreach ($setting as $key=>$value) {        
				$data[$key] = $value;
		   }
		$active_id = 0;
		$active_class =	'';
	   	if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}
		if (isset($parts[0])) {
			$active_id = $parts[0];
		}
		if (isset($parts[1])) {
			$active_id = $parts[1];
		}
		if (isset($parts[2])) {
			$active_id = $parts[2];
		}
		if (isset($parts[3])) {
			$active_id= $parts[3];
		} 
			
        $this->load->language('avethemes/global_lang');
		$data['categories'] = array();
					
		$count_total	=	$this->ave->get('menu_count_item');	
		$this->load->model('avethemes/global');	
		$categories = $this->model_avethemes_global->getProductCategories(0);
		$preview_desc_limit = $this->ave->get('preview_desc_limit');
		$description_limit=!empty($preview_desc_limit)?(int)$preview_desc_limit:64;
		$category_width=$this->ave->get('preview_image_width');
		$category_height=$this->ave->get('preview_image_height');
		$data['width']=$category_width;
		$data['height']=$category_height;
		foreach ($categories as $category) {
			if ($category['top']) {
				if($active_id==$category['category_id']){
					$active_class = 'active';
				}
				if (!empty($category['image'])&&file_exists(DIR_IMAGE.$category['image'])) {
					$thumb = $this->model_tool_image->resize($category['image'], $category_width, $category_height);
				} else {
					$thumb = $this->model_tool_image->resize('no_image.png', $category_width, $category_height);
				}		
				// Level 1
				$children_data = array();
				
				$children = $this->model_avethemes_global->getProductCategories($category['category_id']);
				$children_total = array();
				if($count_total=='1'){
					$children_total = $this->model_avethemes_global->getTotalProductsByCategories($children);	
				}
				foreach ($children as $child) {	
						if($active_id==$child['category_id']){
							$active_class = 'active';
						}
						$child_total = '';						
						if(isset($children_total[$child['category_id']])){
							$child_total = ' <span class="badge">' .$children_total[$child['category_id']]['total']. '</span>';
						}				
						if (!empty($child['image'])&&file_exists(DIR_IMAGE.$child['image'])) {
							$child_thumb = $this->model_tool_image->resize($child['image'], $category_width, $category_height);
						} else {
							$child_thumb = $thumb;
						}	
					// Level 2
					$level2_data = array();					
					$level2 = $this->model_avethemes_global->getProductCategories($child['category_id']);	
					$level2_total = array();
					if($count_total=='1'){	
						$level2_total = $this->model_avethemes_global->getTotalProductsByCategories($level2);	
					}
					foreach ($level2 as $level_2) {	
						if($active_id==$level_2['category_id']){
							$active_class = 'active';
						}
						$level_2_total = '';				
						if(isset($level2_total[$level_2['category_id']])){
							$level_2_total = ' <span class="badge">' .$level2_total[$level_2['category_id']]['total']. '</span>';
						}					
						if (!empty($level_2['image'])) {
							$level_2_thumb = $this->model_tool_image->resize($level_2['image'], $category_width, $category_height);
						} else {
							$level_2_thumb = $child_thumb;
						}	
							// Level 3
							$level3_data = array();					
							$level3 = $this->model_avethemes_global->getProductCategories($level_2['category_id']);
							$level3_total = array();
							if($count_total=='1'){				
									$level3_total = $this->model_avethemes_global->getTotalProductsByCategories($level3);	
							}
							foreach ($level3 as $level_3) {	
								if($active_id==$level_3['category_id']){
									$active_class = 'active';
								}
								$level_3_total = '';
								if(isset($level3_total[$level_3['category_id']])){
									$level_3_total = ' <span class="badge">' .$level3_total[$level_3['category_id']]['total']. '</span>';
								}	
								if (!empty($level_3['image'])) {
									$level_3_thumb = $this->model_tool_image->resize($level_3['image'], $category_width, $category_height);
								} else {
									$level_3_thumb = $level_2_thumb;
								}
										// Level 4
										$level4_data = array();					
										$level4 = $this->model_avethemes_global->getProductCategories($level_3['category_id']);
										$level4_total = array();
										if($count_total=='1'){				
												$level4_total = $this->model_avethemes_global->getTotalProductsByCategories($level4);	
										}
										foreach ($level4 as $level_4) {	
											if($active_id==$level_4['category_id']){
												$active_class = 'active';
											}
											$level_4_total = '';
											if(isset($level4_total[$level_4['category_id']])){
												$level_4_total = ' <span class="badge">' .$level4_total[$level_4['category_id']]['total']. '</span>';
											}	
											if (!empty($level_4['image'])) {
												$level_4_thumb = $this->model_tool_image->resize($level_4['image'], $category_width, $category_height);
											} else {
												$level_4_thumb = $level_3_thumb;
											}	
												// Level 5
												$level5_data = array();					
												$level5 = $this->model_avethemes_global->getProductCategories($level_4['category_id']);
												$level5_total = array();
												if($count_total=='1'){				
														$level5_total = $this->model_avethemes_global->getTotalProductsByCategories($level5);	
												}
												foreach ($level5 as $level_5) {	
													if($active_id==$level_5['category_id']){
														$active_class = 'active';
													}
													$level_5_total = '';
													if(isset($level5_total[$level_5['category_id']])){
														$level_5_total = ' <span class="badge">' .$level5_total[$level_5['category_id']]['total']. '</span>';
													}	
													if (!empty($level_5['image'])) {
														$level_5_thumb = $this->model_tool_image->resize($level_5['image'], $category_width, $category_height);
													} else {
														$level_5_thumb = $level_4_thumb;
													}	
													$level5_data[] = array(
														'id'     => $level_5['category_id'],
														'name'  => $level_5['name'] ,		
														'count'  => $level_5_total,
														'thumb'  => $level_5_thumb,						
														'description' => utf8_substr(strip_tags(html_entity_decode($level_5['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
														'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_'. $child['category_id'] . '_'. $level_4['category_id']  . '_'  . $level_5['category_id'])
													);		
												 }
											$level4_data[] = array(
												'id'     => $level_4['category_id'],
												'level_5' => $level5_data,
												'name'  => $level_4['name'] ,		
												'count'  => $level_4_total,
												'thumb'  => $level_4_thumb,						
												'description' => utf8_substr(strip_tags(html_entity_decode($level_4['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
												'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_'. $child['category_id'] . '_'. $level_3['category_id']  . '_'  . $level_4['category_id'])
											);		
										 }
								$level3_data[] = array(
									'id'     => $level_3['category_id'],
									'level_4' => $level4_data,
									'name'  => $level_3['name'] ,		
									'count'  => $level_3_total,
									'thumb'  => $level_3_thumb,						
									'description' => utf8_substr(strip_tags(html_entity_decode($level_3['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
									'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_'. $child['category_id'] . '_'. $level_2['category_id']  . '_'  . $level_3['category_id'])
								);		
							 }
						$level2_data[] = array(
							'id'     => $level_2['category_id'],
							'level_3' => $level3_data,
							'name'  => $level_2['name'] ,		
							'count'  => $level_2_total,
							'thumb'  => $level_2_thumb,						
							'description' => utf8_substr(strip_tags(html_entity_decode($level_2['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
							'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_'. $child['category_id'] . '_'  . $level_2['category_id'])
						);		
                     }	
					$children_data[] = array(
						'id'     => $child['category_id'],
						'level_2' => $level2_data,
						'thumb' => $child_thumb,
						'name'  => $child['name'],
						'count'  => $child_total,
						'description' => utf8_substr(strip_tags(html_entity_decode($child['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);						
				}
				
				//Parent
				$data['categories'][] = array(
					'id'     => $category['category_id'],
					'name'     => $category['name'],
					'display'  => isset($category['display'])?$category['display']:'multilevel',
					'class'     => $active_class,
					'nav_thumb'     => $this->ave->get('preview_category_thumb'),
					'thumb'     => $thumb,
					'level_1' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'description' => utf8_substr(strip_tags(html_entity_decode($category['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
					$active_class='';
			}
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl';
		} else {
			$this_template = 'default/avethemes/template/widget/'.$data['template'] .'.tpl';
		}
		return $this->load->view($this_template, $data);
	}
	public function nav_content($setting) {	
		$this->load->model('tool/image');	
       foreach ($setting as $key=>$value) {        
			$data[$key] = $value;
       }
	   
		$active_id = 0;
		$active_class =	'';
	   	if (isset($this->request->get['content_id'])) {
			$parts = explode('_', (string)$this->request->get['content_id']);
		} else {
			$parts = array();
		}
		if (isset($parts[0])) {
			$active_id = $parts[0];
		}
		if (isset($parts[1])) {
			$active_id = $parts[1];
		}
		if (isset($parts[2])) {
			$active_id = $parts[2];
		}
		if (isset($parts[3])) {
			$active_id= $parts[3];
		} 
		
        $this->load->language('avethemes/global_lang');
		
		$count_total	=	$this->ave->get('menu_count_item');		
		$preview_desc_limit = $this->ave->get('preview_desc_limit');
		$description_limit=!empty($preview_desc_limit)?(int)$preview_desc_limit:64;
		
		$category_width=$this->ave->get('preview_content_image_width');
		$category_height=$this->ave->get('preview_content_image_height');
		
		$data['width']=$category_width;
		$data['height']=$category_height;
			
		// Blog Menu
		$this->load->model('avethemes/category');				
		$data['categories'] = array();
		$categories = array();
		if ($this->config->get('ave_confirm_installed')) {		
			$categories = $this->model_avethemes_category->getCategories(0);			
		}
		if(!empty($categories)){
			foreach ($categories as $category) {
				if ($category['top']) {
					if($active_id==$category['content_id']){
						$active_class = 'active';
					}
					if (!empty($category['image'])&&$category['nav_thumb']==1) {
						$thumb = $this->model_tool_image->resize($category['image'], $category_width, $category_height);
					} else{
						$thumb = $this->model_tool_image->resize('no_image.png', $category_width, $category_height);
					}
					// Level 1
					$children_data = array();
					
					$children = $this->model_avethemes_category->getCategories($category['content_id']);
					$children_total = array();
					if($count_total=='1'){	
						$children_total = $this->model_avethemes_category->getTotalArticlesByCategories($children);	
					}
					foreach ($children as $child) {
							if($active_id==$child['content_id']){
								$active_class = 'active';
							}
							$child_total = '';
							if(isset($children_total[$child['content_id']])&&$child['type']=='category'){
								$child_total = ' <span class="badge">' .$children_total[$child['content_id']]['total']. '</span>';
							}	
							if (!empty($child['image'])&&$category['nav_thumb']==1) {
								$child_thumb = $this->model_tool_image->resize($child['image'], $category_width, $category_height);
							} else {
								$child_thumb = $thumb;
							}	
						// Level 2
						$level2_data = array();					
						$level2 = $this->model_avethemes_category->getCategories($child['content_id']);	
						$level2_total = array();
						if($count_total=='1'){	
							$level2_total = $this->model_avethemes_category->getTotalArticlesByCategories($level2);
						}
						foreach ($level2 as $level_2) {	
								if($active_id==$level_2['content_id']){
									$active_class = 'active';
								}	
								$level_2_total = '';								
								if(isset($level2_total[$level_2['content_id']])&&$level_2['type']=='category'){
									$level_2_total = ' <span class="badge">' .$level2_total[$level_2['content_id']]['total']. '</span>';
								}							
								if (!empty($level_2['image'])&&$category['nav_thumb']==1) {
									$level_2_thumb = $this->model_tool_image->resize($level_2['image'], $category_width, $category_height);
								} else {
									$level_2_thumb = $child_thumb;
								}	
									// Level 3
									$level3_data = array();					
									$level3 = $this->model_avethemes_category->getCategories($level_2['content_id']);	
									$level3_total = array();
									if($count_total=='1'){
										$level3_total = $this->model_avethemes_category->getTotalArticlesByCategories($level3);
									}
									foreach ($level3 as $level_3) {	
											if($active_id==$level_3['content_id']){
												$active_class = 'active';
											}	
											$level_3_total = '';																			
											if(isset($level3_total[$level_3['content_id']])&&$level_3['type']=='category'){
												$level_3_total = ' <span class="badge">' .$level3_total[$level_3['content_id']]['total']. '</span>';
											}			
											if (!empty($level_3['image'])&&$category['nav_thumb']==1) {
												$level_3_thumb = $this->model_tool_image->resize($level_3['image'], $category_width, $category_height);
											} else {
												$level_3_thumb = $level_2_thumb;
											}	
											$level_3_href = $this->url->link('content/category', 'content_id=' . $category['content_id'] . '_'. $child['content_id']. '_'. $level_2['content_id']  . '_'  . $level_3['content_id']);
											
											if($level_3['type']=='link'){
												$level_3_href =  html_entity_decode($level_3['link'], ENT_QUOTES, 'UTF-8');
											}
											$level3_data[] = array(
												'id'     => $level_3['content_id'],
												'name'  => $level_3['name'] ,	
												'target'  => $level_3['target'],	
												'type'   => $level_3['type'],		
												'count'  => $level_3_total,
												'thumb'  => $level_3_thumb,						
												'description' => utf8_substr(strip_tags(html_entity_decode($level_3['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
												'href'  => $level_3_href
											);						
									}
									
								$level_2_href = $this->url->link('content/category', 'content_id=' . $category['content_id'] . '_'. $child['content_id'] . '_'  . $level_2['content_id']);
								if($level_2['type']=='link'){
									$level_2_href =  html_entity_decode($level_2['link'], ENT_QUOTES, 'UTF-8');
								}
								$level2_data[] = array(
									'id'     => $level_2['content_id'],
									'level_3' => $level3_data,
									'name'  => $level_2['name'] ,
									'target'  => $level_2['target'],	
									'type'   => $level_2['type'],	
									'count'  => $level_2_total,
									'thumb'  => $level_2_thumb,						
									'description' => utf8_substr(strip_tags(html_entity_decode($level_2['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
									'href'  => $level_2_href
								);						
						}	
						
					$child_href = $this->url->link('content/category', 'content_id=' . $category['content_id'] . '_' . $child['content_id']);
					if($child['type']=='link'){
						$child_href =  html_entity_decode($child['link'], ENT_QUOTES, 'UTF-8');
					}
					
						$children_data[] = array(
							'id'     => $child['content_id'],
							'level_2' => $level2_data,
							'name'  => $child['name'],
							'target'  => $child['target'],
							'type'     => $child['type'],
							'count'  => $child_total,
							'thumb' => $child_thumb,
							'description' => utf8_substr(strip_tags(html_entity_decode($child['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
							'href'  => $child_href
						);						
					}
					$category_description = utf8_substr(strip_tags(html_entity_decode($category['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..';
					if($category['type']=='content'){
						$category_description =  html_entity_decode($category['description'], ENT_QUOTES, 'UTF-8');
					}
					$category_href = $this->url->link('content/category', 'content_id=' . $category['content_id']);
					if($category['type']=='link'){
						$category_href =  html_entity_decode($category['link'], ENT_QUOTES, 'UTF-8');
					}
					//Parent 
					$data['categories'][] = array(
						'id'    	=> $category['content_id'],
						'class'     => $active_class,
						'name'     => $category['name'],
						'target'  => $category['target'],
						'type'     => $category['type'],
						'content_size'     => $category['content_size'],
						'display'  => $category['display'],
						'nav_thumb'     => $category['nav_thumb'],
						'thumb'     => $thumb,
						'level_1' => $children_data,
						'column'   => $category['column'] ? $category['column'] : 1,
						'description' => $category_description,
						'href'     => $category_href
					);
					$active_class='';
				}
			}
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl';
		} else {
			$this_template = 'default/avethemes/template/widget/'.$data['template'] .'.tpl';
		}
		return $this->load->view($this_template, $data);
	}
	
	public function nav_shortcode($data) {
	
		$this->load->language('avethemes/global_lang'); 
		$data['text_shortcode'] = $this->language->get('text_shortcode');
	   
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl';
		} else {
			$this_template = 'default/avethemes/template/widget/'.$data['template'] .'.tpl';
		}
		return $this->load->view($this_template, $data);	
	}
	public function skin_pin_brand($setting) {	
		$this->load->model('tool/image');			
		
       foreach ($setting as $key=>$value) {        
			$data[$key] = $value;
       }
	   $data['brand_href'] = $this->url->link('product/manufacturer');
	   	
		$data['ave'] = $this->ave;	
	   if (!empty($setting['width'])&&!empty($setting['height'])) {			
			$width = $setting['width'];
			$height = $setting['height'];
		} else {		
			$width = '400';
			$height = '300';
		}
		
	   $this->load->model('avethemes/global');
	   
		$data['manufacturers']=array();
		if (is_array($setting['skin_pin_brand'])) {
			$manufacturers = $this->model_avethemes_global->getManufacturersGroup($setting['skin_pin_brand']);
			foreach ($manufacturers as $manufacturer) {    			
					if ($manufacturer['image']) {
						$manufacturer_image = $this->model_tool_image->resize($manufacturer['image'], $width, $height);
					} else {
						$manufacturer_image = $this->model_tool_image->resize('no_image.png', $width, $height);
					}	
					$data['manufacturers'][] = array(
						'manufacturer_id' => $manufacturer['manufacturer_id'],
						'thumb' => $manufacturer_image,
						'name'       => $manufacturer['name'],					
						'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id'])
					);
		   }
		}
	   
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl';
		} else {
			$this_template = 'default/avethemes/template/widget/'.$data['template'] .'.tpl';
		}
		return $this->load->view($this_template, $data);
	}
	
	public function skin_pin_product($setting) {		
	   foreach ($setting as $key=>$value) {        
			$data[$key] = $value;
	   }
		$data['ave'] = $this->ave;	
		$data['special_label'] = $this->ave->get('ribbon_special_status');
		$this->load->model('tool/image');	
		
		$this->load->language('avethemes/global_lang'); 
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_more'] = $this->language->get('text_more');
		
        $data['text_display'] = $this->language->get('text_display');
        $data['text_list'] = $this->language->get('text_list');
        $data['text_grid'] = $this->language->get('text_grid');
		$data['text_tax'] = $this->language->get('text_tax');
		   
		$data['btn_cart'] = $this->ave->get('btn_cart');
		$data['btn_whistlist'] = $this->ave->get('btn_whistlist'); 
		$data['btn_compare'] = $this->ave->get('btn_compare');
		
		   $config=$this->ave->get('pin_binding');
		   
		if (!empty($config['image_width'])&&!empty($config['image_height'])) {			
			$width = $config['image_width'];
			$height = $config['image_height'];
		} else {
			$width = $this->config->get('config_image_product_width');
			$height = $this->config->get('config_image_product_height');
		}	
		 
		if (!empty($setting['description_limit'])) {	
			$description_limit = $setting['description_limit'];
		} else {
			$description_limit=64;
		}	
		
		$data['products'] = array();	
	   /*Define Pin Products*/ 				
		if (!empty($setting['skin_pin_product'])) {
			$pin_products = $setting['skin_pin_product'];	
		   $this->load->model('avethemes/global');
		   		$products = array();
				$product_query = $this->model_avethemes_global->getProductsGroup(array('id_group'=>$pin_products));	
				if(!empty($product_query)){
					foreach ($pin_products as $pin_id) {	
						$products[$pin_id] = $product_query[$pin_id];
					}
					unset($product_query);
				
				foreach ($products as $result) {					
					if ($result['image']&&file_exists(DIR_IMAGE.$result['image'])) {
						$thumb = $this->model_tool_image->resize($result['image'], $width, $height);
					} else {
						$thumb = false;
					}		
					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}
							
					if ((float)$result['special']) { 
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
						$sales_percent = str_replace('.00','',number_format((100-(($result['special']*100)/$result['price'])),0));
					} else {
						$special = false;
						$sales_percent = false;
					}
				
					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
					} else {
						$tax = false;
					}	
					
					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
					} else {
						$rating = false;
					}
					
					$data['products'][] = array(
						'product_id' => $result['product_id'],
						'full_image'   	 => HTTPS_SERVER.'image/'.$result['image'],
						'thumb'       => $thumb,
						'name'    	 => $result['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
						'price'   	 => $price,
						'special' 	 => $special,
						'sales_percent' 	 => $sales_percent,
						'tax'         => $tax,
						'rating'     => $rating,
						'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
						'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
					);
				}
			}//if exist
		} //
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl';
		} else {
			$this_template = 'default/avethemes/template/widget/'.$data['template'] .'.tpl';
		}
		return $this->load->view($this_template, $data);
	}
	public function skin_pin_information($setting) {	
       foreach ($setting as $key=>$value) {        
			$data[$key] = $value;
       }
	   $this->load->model('avethemes/global');
		$data['informations']=array();		
	   
		if (is_array($setting['skin_pin_information'])) {		
			$informations = $this->model_avethemes_global->getInformationsGroup($setting['skin_pin_information']);			
			foreach ($informations as $information) {    
				$data['informations'][] = array(
					'information_id' => $information['information_id'],
					'title'       => $information['title'],					
					'href' => $this->url->link('information/information', 'information_id=' . $information['information_id'])
				);
		   }
		}
	   
	   
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl';
		} else {
			$this_template = 'default/avethemes/template/widget/'.$data['template'] .'.tpl';
		}
		return $this->load->view($this_template, $data);
	}
	public function skin_pin_download($setting) {	
       foreach ($setting as $key=>$value) {        
			$data[$key] = $value;
       }
		$data['downloads'] = array();	
	   /*Define Pin Download*/ 	
		if (!empty($setting['skin_pin_download'])) {
			$pin_downloads = $setting['skin_pin_download'];	
		   $this->load->model('avethemes/global');
		   if($this->config->get('ave_confirm_installed')){
				$downloads = $this->model_avethemes_global->getDownloadsGroup($pin_downloads);	
					
				foreach ($downloads as $download) {		
							$ext=substr(strrchr($download['mask'], '.'), 1);
						if (file_exists(DIR_TEMPLATE . $this->config->get('config_template').'/img/file_icon/'.$ext.'.png')) {
							$thumb=HTTP_SERVER.'catalog/view/theme/'.$this->config->get('config_template').'/img/file_icon/'.$ext.'.png';
						}else{
							$thumb=HTTP_SERVER.'catalog/view/theme/'.$this->config->get('config_template').'/img/file_icon/default.png';			
						}
						$data['downloads'][] = array(
						'name' => html_entity_decode($download['name'], ENT_QUOTES, 'UTF-8'),		
						'description' => html_entity_decode($download['description'], ENT_QUOTES, 'UTF-8'),		
						'mask' => $download['mask'],		
						'ext' => $ext,		
						'thumb' => $thumb,		
						'href' => $this->url->link('content/article/download','&auth_key=' . $download['auth_key']),			
						);
				}
			}//ace_confirm_installed
		} //
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/widget/'.$data['template'] .'.tpl';
		} else {
			$this_template = 'default/avethemes/template/widget/'.$data['template'] .'.tpl';
		}
		return $this->load->view($this_template, $data);
	}
	public function quickview() { 
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$data['base'] = $server;
		$language_data = $this->load->language('product/product');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$data['ave'] = $this->ave;
		$data['config'] = $this->config;
		$data['language'] = $this->language;
		$data['lang'] = $this->language->get('code');
		$this->load->model('catalog/category');	
		
		
		$this->load->model('catalog/manufacturer');	
		
		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
		
		$this->load->model('catalog/product');
		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			$url = '';

			$data['breadcrumbs'][] = array(
				'text' => $product_info['name'],
				'href' => $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id'])
			);

			$this->document->setTitle($product_info['meta_title']);
			$this->document->setDescription($product_info['meta_description']);
			$this->document->setKeywords($product_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/product', 'product_id=' . $this->request->get['product_id']), 'canonical');
			

			$data['heading_title'] = $product_info['name'];

			$data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
			

			$this->load->model('catalog/review');

			$data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);

			$data['product_id'] = (int)$this->request->get['product_id'];
			$data['manufacturer'] = $product_info['manufacturer'];
			$data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
			$data['model'] = $product_info['model'];
			$data['reward'] = $product_info['reward'];
			$data['points'] = $product_info['points'];

			if ($product_info['quantity'] <= 0) {
				$data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$data['stock'] = $product_info['quantity'];
			} else {
				$data['stock'] = $this->language->get('text_instock');
			}

			$this->load->model('tool/image');

			if ($product_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			} else {
				$data['popup'] = '';
			}

			if ($product_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			} else {
				$data['thumb'] = '';
			}

			$zoom_width = 600;
			if($this->config->has('skin_zoom_image_width')==true){
				$zoom_width = $this->config->get('skin_zoom_image_width');
			}
			$zoom_height = 600;
			if($this->config->has('skin_zoom_image_height')==true){
				$zoom_height = $this->config->get('skin_zoom_image_height');
			}
			if ($product_info['image']) {
				$data['zoom_image'] = $this->model_tool_image->resize($product_info['image'], $zoom_width, $zoom_height);
			} else {
				$data['zoom_image'] = '';
			}
			
			$data['images'] = array();

			$results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);

			foreach ($results as $result) {
				$data['images'][] = array(
					'zoom_image' => $this->model_tool_image->resize($result['image'], $zoom_width,$zoom_height),
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
				);
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$data['price'] = false;
			}

			if ((float)$product_info['special']) {
				$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				$data['sales_percent'] = str_replace('.00','',number_format((100-(($product_info['special']*100)/$product_info['price'])),0));
			} else {
				$data['special'] = false;
				$data['sales_percent'] = false;
			}

			if ($this->config->get('config_tax')) {
				$data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
			} else {
				$data['tax'] = false;
			}

			$discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);

			$data['discounts'] = array();

			foreach ($discounts as $discount) {
				$data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')))
				);
			}

			$data['options'] = array();

			foreach ($this->model_catalog_product->getProductOptions($this->request->get['product_id']) as $option) {
				$product_option_value_data = array();

				foreach ($option['product_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							$price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false));
						} else {
							$price = false;
						}

						$product_option_value_data[] = array(
							'product_option_value_id' => $option_value['product_option_value_id'],
							'option_value_id'         => $option_value['option_value_id'],
							'name'                    => $option_value['name'],
							'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
							'price'                   => $price,
							'price_prefix'            => $option_value['price_prefix']
						);
					}
				}

				$data['options'][] = array(
					'product_option_id'    => $option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $option['option_id'],
					'name'                 => $option['name'],
					'type'                 => $option['type'],
					'value'                => $option['value'],
					'required'             => $option['required']
				);
			}

			if ($product_info['minimum']) {
				$data['minimum'] = $product_info['minimum'];
			} else {
				$data['minimum'] = 1;
			}

			$data['review_status'] = $this->config->get('config_review_status');

			if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
				$data['review_guest'] = true;
			} else {
				$data['review_guest'] = false;
			}

			if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
			} else {
				$data['customer_name'] = '';
			}

			$data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
			$data['rating'] = (int)$product_info['rating'];
			$data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
			$data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);

			$data['products'] = array();

			$results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}

			$data['tags'] = array();

			if ($product_info['tag']) {
				$tags = explode(',', $product_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('product/search', 'tag=' . trim($tag))
					);
				}
			}

			$data['text_payment_recurring'] = $this->language->get('text_payment_recurring');
			$data['recurrings'] = $this->model_catalog_product->getProfiles($this->request->get['product_id']);

			$this->model_catalog_product->updateViewed($this->request->get['product_id']);
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/child/quickview.tpl')) {
				$this_template = $this->config->get('config_template') . '/avethemes/template/child/quickview.tpl';
			} else {
				$this_template = 'default/avethemes/template/child/quickview.tpl';
			}
					
			$this->response->setOutput($this->load->view($this_template, $data));
			
		}else{													
			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('product/product', '&product_id=' . $this->request->get['product_id']),
				'separator' => $this->language->get('text_separator')
			);		
				
			$this->document->setTitle($this->language->get('text_error'));

      		$data['heading_title'] = $this->language->get('text_error');

      		$data['text_error'] = $this->language->get('text_error');

      		$data['button_continue'] = $this->language->get('button_continue');

      		$data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/child/not_found.tpl')) {
				$this_template = $this->config->get('config_template') . '/avethemes/template/child/not_found.tpl';
			} else {
				$this_template = 'default/avethemes/template/child/not_found.tpl';
			}
			$this->response->setOutput($this->load->view($this_template, $data));
		}
  	}
}
?>