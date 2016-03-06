<?php  
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerModuleAveCustomCategory extends Controller {
	public function sitemap(){		
		if(defined('ave_check')){
			$data['ave'] = $this->ave;
		$data['categories'] = $this->getContentCategories(0,0);
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/content/site_map.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/content/site_map.tpl';
		} else {
			$this_template = 'default/avethemes/template/content/site_map.tpl';
		}
		return $this->load->view($this_template, $data);
		}
	}
	public function index($setting=array()) {		
		if(defined('ave_check')){
		$data['ave'] = $this->ave;
		$data['position'] = $position = isset($setting['layout_position'])?$setting['layout_position']:'content_top';
		$data['side_position'] = $side_position = $this->ave->sidePosition();
				$this->load->language('avethemes/global_lang');
				$data['heading_title'] = FALSE;
				$data['mobile_visible'] = $setting['mobile_visible'];
				$display = $setting['display'];
				
				$type = $setting['type'];
				
				$desc_limit	=	!empty($setting['desc_limit'])?(int)$setting['desc_limit']:64;	
				$count_total	=	$setting['count'];	
				$data['show_icon'] = $setting['show_icon'];	
				$data['show_thumb'] = $setting['show_thumb'];	
				$language_id = $this->config->get('config_language_id');	
				$parent_id = 0;	
				$parts = array();
				$data['href'] = FALSE;	
		
		if ($setting['custom_title']&&isset($setting['custom_title'][$language_id])) {	
      		$data['heading_title'] =  html_entity_decode($setting['custom_title'][$language_id], ENT_QUOTES, 'UTF-8');
		}
		if ($display=='mega') {	
			$dir=$this->ave->layout('dir');
			$this->document->addStyle('assets/theme/widget/vertical_mega_menu'.$dir.'.css');
		}
		
		if ($type=='content') {	
				if (isset($this->request->get['content_id'])) {
					$parts = explode('_', (string)$this->request->get['content_id']);
				}
				$data['content_id'] = 0;
				$data['content_id'] = 0;
				if (isset($parts[0])) {
					$data['content_id'] = $parts[0];
				}
		}
		if ($type=='catalog') {	
			if ($display=='dropdown') {	
				$template = 'custom_catalog_category_dropdown';
			}else{
				$template = 'custom_catalog_category_mega';
			}
			if (isset($this->request->get['path'])) {
				$parts = explode('_', (string)$this->request->get['path']);
			}
			$data['category_id'] = 0;
			if (isset($parts[0])) {
				$data['category_id'] = $parts[0];
			}
		}
		$data['child_id'] = 0;
		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		}
			
		$data['child_2_id'] = 0;
		if (isset($parts[2])) {
			$data['child_2_id'] = $parts[2];
		}
			
		$data['child_3_id'] = 0;
		if (isset($parts[3])) {
			$data['child_3_id'] = $parts[3];
		} 
				
		if ($type=='content') {	
				$content_data = $setting['content_data'];
				$data['categories'] = $this->getCustomContentCategories($content_data,$count_total,$desc_limit);
		}
		if ($setting['type']=='catalog') {
			$catalog_data = $setting['catalog_data'];
			$data['categories'] = $this->getCustomCatalogCategories($catalog_data,$count_total,$desc_limit);
		}
		$template = $type.'_'.$display;
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/category_custom/'.$template.'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/category_custom/'.$template.'.tpl';
		} else {
			$this_template = 'default/avethemes/template/category_custom/'.$template.'.tpl';
		}	
        return $this->load->view($this_template, $data);
		}
	}
	private function getCustomContentCategories($content_data,$count_total=0,$desc_limit=64){
		$this->load->model('tool/image');
		$this->load->model('avethemes/category');	
		
		$id_group = array();
		$sort_orders = array(); 
		foreach ($content_data as $category_ids) {
			if(isset($category_ids['is_parent'])){
				$sort_orders[] = array('vsort_order'=>$category_ids['vsort_order'],'content_id'=>$category_ids['content_id']);
			}
		}
		sort($sort_orders);
		foreach ($sort_orders as $sort_order) {
			foreach ($content_data as $category_ids) {
				if($category_ids['content_id']==$sort_order['content_id']){
					$id_group[] = $category_ids['content_id'];
				}
			}
		}

		$categories = $this->model_avethemes_category->getCategoryGroup($id_group);

//print('<pre>');print_r($categories);print('</pre>');  
		$categories_data = array();
		$categories_total = array();
		if($count_total==1){
			$categories_total = $this->model_avethemes_category->getTotalArticlesByCategories($categories);
		}
		$description_limit=$desc_limit;
		$category_width=$this->ave->get('preview_image_width');
		$category_height=$this->ave->get('preview_image_height');	
		foreach ($categories as $category) {	
			if($category['type']=='category'||$category['type']=='faq'){
				$category_total = '';					
				if(isset($categories_total[$category['content_id']])){
					$category_total = ' <span class="badge">' .$categories_total[$category['content_id']]['total']. '</span>';
				}	
				if (!empty($category['image'])) {
					$thumb = $this->model_tool_image->resize($category['image'], $category_width, $category_height);
				} else{
					$thumb = $this->model_tool_image->resize('no_image.png', $category_width, $category_height);
				}
				// Level 1
				$children_data = array();
				
				$children = $this->model_avethemes_category->getCategories($category['content_id']);
				$children_total = array();
				if($count_total==1){
						$children_total = $this->model_avethemes_category->getTotalArticlesByCategories($children);			
				}
				foreach ($children as $child) {	
						$child_total = '';						
						if(isset($children_total[$child['content_id']])){
							$child_total = ' <span class="badge">' .$children_total[$child['content_id']]['total']. '</span>';
						}	
						if (!empty($child['image'])) {
							$child_thumb = $this->model_tool_image->resize($child['image'], $category_width, $category_height);
						} else {
							$child_thumb = $thumb;
						}		
					// Level 2
					$level2_data = array();					
					$level2 = $this->model_avethemes_category->getCategories($child['content_id']);
					$level2_total = array();
					if($count_total==1){	
						$level2_total = $this->model_avethemes_category->getTotalArticlesByCategories($level2);
					}
					foreach ($level2 as $level_2) {	
						$level_2_total = '';				
						if(isset($level2_total[$level_2['content_id']])){
							$level_2_total = ' <span class="badge">' .$level2_total[$level_2['content_id']]['total']. '</span>';
						}							
							if (!empty($level_2['image'])) {
								$level_2_thumb = $this->model_tool_image->resize($level_2['image'], $category_width, $category_height);
							} else {
								$level_2_thumb = $child_thumb;
							}	
							// Level 3
							$level3_data = array();					
							$level3 = $this->model_avethemes_category->getCategories($level_2['content_id']);	
							$level3_total = array();
							if($count_total==1){			
									$level3_total = $this->model_avethemes_category->getTotalArticlesByCategories($level3);	
							}
							foreach ($level3 as $level_3) {	
								$level_3_total = '';
								if(isset($level3_total[$level_3['content_id']])){
									$level_3_total = ' <span class="badge">' .$level3_total[$level_3['content_id']]['total']. '</span>';
								}			
								if (!empty($level_3['image'])) {
									$level_3_thumb = $this->model_tool_image->resize($level_3['image'], $category_width, $category_height);
								} else {
									$level_3_thumb = $level_2_thumb;
								}	
								$level3_data[] = array(
									'content_id'     => $level_3['content_id'],
									'name'  => $level_3['name'],			
									'count'  => $level_3_total,		
									'thumb'  => $level_3_thumb,						
									'description' => utf8_substr(strip_tags(html_entity_decode($level_3['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',	
									'href'  => $this->url->link('content/category', 'content_id=' . $category['content_id'] . '_'. $child['content_id'] . '_'. $level_2['content_id']  . '_'  . $level_3['content_id'])
								);		
							 }
						$level2_data[] = array(
							'content_id'     => $level_2['content_id'],
							'level_3' => $level3_data,
							'name'  => $level_2['name'],		
							'count'  => $level_2_total,			
							'thumb'  => $level_2_thumb,						
							'description' => utf8_substr(strip_tags(html_entity_decode($level_2['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
							'href'  => $this->url->link('content/category', 'content_id=' . $category['content_id'] . '_'. $child['content_id'] . '_'  . $level_2['content_id'])
						);		
                     }	
					$children_data[] = array(
						'content_id'     => $child['content_id'],
						'level_2' => $level2_data,
						'name'  => $child['name'],
						'count'  => $child_total,
						'thumb' => $child_thumb,
						'description' => utf8_substr(strip_tags(html_entity_decode($child['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
						'href'  => $this->url->link('content/category', 'content_id=' . $category['content_id'] . '_' . $child['content_id'])
					);						
				}
				
				//Parent
				$categories_data[] = array(
					'content_id'     => $category['content_id'],
					'name'     => $category['name'],
					'icon'  => $category['icon'] ,	
					'level_1' => $children_data,
					'count'  => $category_total,
					'thumb'     => $thumb,
					'vcolumn'     => !empty($catalog_data[$category['content_id']]['vcolumn'])?$catalog_data[$category['content_id']]['vcolumn']:'2',
					'description' => utf8_substr(strip_tags(html_entity_decode($category['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
					'href'     => $this->url->link('content/category', 'content_id=' . $category['content_id'])
				);
			}
		}
		return $categories_data;
	}
	private function getContentCategories($parent_id=0,$count_total=0){
		$this->load->model('tool/image');
		$this->load->model('avethemes/category');	
		$categories = $this->model_avethemes_category->getCategories($parent_id);
				
		$categories_data = array();
		$categories_total = array();
		if($count_total==1){
			$categories_total = $this->model_avethemes_category->getTotalArticlesByCategories($categories);
		}
		$description_limit=64;
		$category_width=$this->ave->get('preview_image_width');
		$category_height=$this->ave->get('preview_image_height');	
		foreach ($categories as $category) {	
			if($category['type']=='category'){
				$category_total = '';					
				if(isset($categories_total[$category['content_id']])){
					$category_total = ' <span class="badge">' .$categories_total[$category['content_id']]['total']. '</span>';
				}	
				if (!empty($category['image'])) {
					$thumb = $this->model_tool_image->resize($category['image'], $category_width, $category_height);
				} else{
					$thumb = $this->model_tool_image->resize('no_image.png', $category_width, $category_height);
				}
				// Level 1
				$children_data = array();
				
				$children = $this->model_avethemes_category->getCategories($category['content_id']);
				$children_total = array();
				if($count_total==1){
						$children_total = $this->model_avethemes_category->getTotalArticlesByCategories($children);			
				}
				foreach ($children as $child) {	
						$child_total = '';						
						if(isset($children_total[$child['content_id']])){
							$child_total = ' <span class="badge">' .$children_total[$child['content_id']]['total']. '</span>';
						}	
						if (!empty($child['image'])) {
							$child_thumb = $this->model_tool_image->resize($child['image'], $category_width, $category_height);
						} else {
							$child_thumb = $thumb;
						}		
					// Level 2
					$level2_data = array();					
					$level2 = $this->model_avethemes_category->getCategories($child['content_id']);
					$level2_total = array();
					if($count_total==1){	
						$level2_total = $this->model_avethemes_category->getTotalArticlesByCategories($level2);
					}
					foreach ($level2 as $level_2) {	
						$level_2_total = '';				
						if(isset($level2_total[$level_2['content_id']])){
							$level_2_total = ' <span class="badge">' .$level2_total[$level_2['content_id']]['total']. '</span>';
						}							
							if (!empty($level_2['image'])) {
								$level_2_thumb = $this->model_tool_image->resize($level_2['image'], $category_width, $category_height);
							} else {
								$level_2_thumb = $child_thumb;
							}	
							// Level 3
							$level3_data = array();					
							$level3 = $this->model_avethemes_category->getCategories($level_2['content_id']);	
							$level3_total = array();
							if($count_total==1){			
									$level3_total = $this->model_avethemes_category->getTotalArticlesByCategories($level3);	
							}
							foreach ($level3 as $level_3) {	
								$level_3_total = '';
								if(isset($level3_total[$level_3['content_id']])){
									$level_3_total = ' <span class="badge">' .$level3_total[$level_3['content_id']]['total']. '</span>';
								}			
								if (!empty($level_3['image'])) {
									$level_3_thumb = $this->model_tool_image->resize($level_3['image'], $category_width, $category_height);
								} else {
									$level_3_thumb = $level_2_thumb;
								}	
								$level3_data[] = array(
									'content_id'     => $level_3['content_id'],
									'name'  => $level_3['name'],			
									'count'  => $level_3_total,		
									'thumb'  => $level_3_thumb,						
									'description' => utf8_substr(strip_tags(html_entity_decode($level_3['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',	
									'href'  => $this->url->link('content/category', 'content_id=' . $category['content_id'] . '_'. $child['content_id'] . '_'. $level_2['content_id']  . '_'  . $level_3['content_id'])
								);		
							 }
						$level2_data[] = array(
							'content_id'     => $level_2['content_id'],
							'level_3' => $level3_data,
							'name'  => $level_2['name'],		
							'count'  => $level_2_total,			
							'thumb'  => $level_2_thumb,						
							'description' => utf8_substr(strip_tags(html_entity_decode($level_2['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
							'href'  => $this->url->link('content/category', 'content_id=' . $category['content_id'] . '_'. $child['content_id'] . '_'  . $level_2['content_id'])
						);		
                     }	
					$children_data[] = array(
						'content_id'     => $child['content_id'],
						'level_2' => $level2_data,
						'name'  => $child['name'],
						'count'  => $child_total,
						'thumb' => $child_thumb,
						'description' => utf8_substr(strip_tags(html_entity_decode($child['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
						'href'  => $this->url->link('content/category', 'content_id=' . $category['content_id'] . '_' . $child['content_id'])
					);						
				}
				
				//Parent
				$categories_data[] = array(
					'content_id'     => $category['content_id'],
					'name'     => $category['name'],
					'icon'  => $category['icon'] ,	
					'level_1' => $children_data,
					'count'  => $category_total,
					'thumb'     => $thumb,
					'description' => utf8_substr(strip_tags(html_entity_decode($category['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
					'href'     => $this->url->link('content/category', 'content_id=' . $category['content_id'])
				);
			}
		}
		return $categories_data;
	}
	private function getCustomCatalogCategories($catalog_data=array(),$count_total=0,$desc_limit=64){
		$this->load->model('tool/image');
		$this->load->model('avethemes/global');	
		$id_group = array();
		$sort_orders = array(); 
		foreach ($catalog_data as $category_ids) {
			if(isset($category_ids['is_parent'])){
				$sort_orders[] = array('vsort_order'=>$category_ids['vsort_order'],'category_id'=>$category_ids['category_id']);
			}
		}
		sort($sort_orders);
		foreach ($sort_orders as $sort_order) {
			foreach ($catalog_data as $category_ids) {
				if($category_ids['category_id']==$sort_order['category_id']){
					$id_group[] = $category_ids['category_id'];
				}
			}
		}

		$categories = $this->model_avethemes_global->getProductCategoryGroup($id_group);
		
		$categories_data = array();
		
		$categories_total = array();
		if($count_total==1){			
			$categories_total = $this->model_avethemes_global->getTotalProductsByCategories($categories);
		}
		$description_limit=$desc_limit;
		$category_width=$this->ave->get('preview_image_width');
		$category_height=$this->ave->get('preview_image_height');
		$data['width']=$category_width;
		$data['height']=$category_height;
		foreach ($categories as $category) {	
				$category_total = '';					
				if(isset($categories_total[$category['category_id']])){
					$category_total = ' <span class="badge">' .$categories_total[$category['category_id']]['total']. '</span>';
				}		
				if (!empty($category['image'])) {
					$thumb = $this->model_tool_image->resize($category['image'], $category_width, $category_height);
				} else {
					$thumb = $this->model_tool_image->resize('no_image.png', $category_width, $category_height);
				}
				// Level 1
				$children_data = array();
				
				$children = $this->model_avethemes_global->getProductCategories($category['category_id']);
				$children_total = array();
				if($count_total==1){		
						$children_total = $this->model_avethemes_global->getTotalProductsByCategories($children);			
				}
				foreach ($children as $child) {	
						$child_total = '';						
						if(isset($children_total[$child['category_id']])){
							$child_total = ' <span class="badge">' .$children_total[$child['category_id']]['total']. '</span>';
						}		
						if (!empty($child['image'])) {
							$child_thumb = $this->model_tool_image->resize($child['image'], $category_width, $category_height);
						} else {
							$child_thumb = $thumb;
						}				
					// Level 2
					$level2_data = array();					
					$level2 = $this->model_avethemes_global->getProductCategories($child['category_id']);	
					$level2_total = array();
					if($count_total==1){			
						$level2_total = $this->model_avethemes_global->getTotalProductsByCategories($level2);
					}
					foreach ($level2 as $level_2) {	
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
							if($count_total==1){
								$level3_total = $this->model_avethemes_global->getTotalProductsByCategories($level3);
							}
							foreach ($level3 as $level_3) {	
								$level_3_total = '';
								if(isset($level3_total[$level_3['category_id']])){
									$level_3_total = ' <span class="badge">' .$level3_total[$level_3['category_id']]['total']. '</span>';
								}	
								if (!empty($level_3['image'])) {
									$level_3_thumb = $this->model_tool_image->resize($level_3['image'], $category_width, $category_height);
								} else {
									$level_3_thumb = $level_2_thumb;
								}	
								$level3_data[] = array(
									'category_id'     => $level_3['category_id'],
									'name'  => $level_3['name'] ,		
									'count'  => $level_3_total,		
									'thumb'  => $level_3_thumb,			
									'description' => utf8_substr(strip_tags(html_entity_decode($level_3['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',	
									'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_'. $child['category_id'] . '_'. $level_2['category_id']  . '_'  . $level_3['category_id'])
								);		
							 }
						$level2_data[] = array(
							'category_id'     => $level_2['category_id'],
							'level_3' => $level3_data,
							'name'  => $level_2['name'] ,	
							'thumb'  => $level_2_thumb,		
							'count'  => $level_2_total,			
							'description' => utf8_substr(strip_tags(html_entity_decode($level_2['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
							'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_'. $child['category_id'] . '_'  . $level_2['category_id'])
						);		
                     }	
					$children_data[] = array(
						'category_id'     => $child['category_id'],
						'level_2' => $level2_data,
						'name'  => $child['name'],
						'thumb' => $child_thumb,
						'count'  => $child_total,
						'description' => utf8_substr(strip_tags(html_entity_decode($child['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);						
				}
				
				//Parent
				$categories_data[] = array(
					'category_id'     => $category['category_id'],
					'name'     => $category['name'],
					'vcolumn'     => !empty($catalog_data[$category['category_id']]['vcolumn'])?$catalog_data[$category['category_id']]['vcolumn']:'2',
					'icon'     => !empty($catalog_data[$category['category_id']]['icon'])?$catalog_data[$category['category_id']]['icon']:'fa fa-tasks',
					'thumb'     => $thumb,
					'level_1' => $children_data,
					'count'  => $category_total,
					'description' => utf8_substr(strip_tags(html_entity_decode($category['description'], ENT_QUOTES, 'UTF-8')), 0, $description_limit) . '..',
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
		}
		return $categories_data;
	}
}
?>