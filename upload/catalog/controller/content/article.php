<?php  
/******************************************************
 * @package AveThemes Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerContentArticle extends Controller {
	private $error = array(); 
	
	public function index() { 		
		$language_data = $this->load->language('avethemes/article');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		$data['ave'] = $this->ave;
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),			
			'separator' => false
		);
		
		$this->load->model('avethemes/category');	
		
		if (isset($this->request->get['content_id'])) {
			$path = '';
				
			foreach (explode('_', $this->request->get['content_id']) as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
				
				$category_info = $this->model_avethemes_category->getCategory($path_id);
				
				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text'      => $category_info['name'],
						'href'      => $this->url->link('content/category', 'content_id=' . $path),
						'separator' => $this->language->get('text_separator')
					);
				}
			}
		}
		
		$this->load->model('avethemes/author');	
		
		if (isset($this->request->get['author_id'])) {
			$data['breadcrumbs'][] = array( 
				'text'      => $this->language->get('text_authors'),
				'href'      => $this->url->link('content/author'),
				'separator' => $this->language->get('text_separator')
			);	
				
			$author_info = $this->model_avethemes_author->getAuthor($this->request->get['author_id']);

			if ($author_info) {	
				$data['breadcrumbs'][] = array(
					'text'	    => $author_info['author'],
					'href'	    => $this->url->link('content/author/info', 'author_id=' . $this->request->get['author_id']),					
					'separator' => $this->language->get('text_separator')
				);
			}
		}
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_tag'])) {
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
						
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
						
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
			
			if (isset($this->request->get['filter_content_id'])) {
				$url .= '&filter_content_id=' . $this->request->get['filter_content_id'];
			}	
						
			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_search'),
				'href'      => $this->url->link('content/search', $url),
				'separator' => $this->language->get('text_separator')
			); 	
		}
		
		if (isset($this->request->get['article_id'])) {
			$article_id = (int)$this->request->get['article_id'];
		} else {
			$article_id = 0;
		}
		
		$this->load->model('avethemes/article');
		
		$article_info = $this->model_avethemes_article->getArticle($article_id);
		
		if ($article_info) {
			//$this->document->addStyle('assets/theme/widget/call_action.css');
			$this->document->addStyle('assets/theme/widget/icon_boxed.css');
			$this->document->addScript('assets/plugins/owl-carousel/owl.carousel.min.js');
			
			$this->load->model('tool/image');
			
			$this->document->setTitle($article_info['name']);
			
			$this->document->setDescription($article_info['meta_description']);
			$this->document->setKeywords($article_info['meta_keyword']);
			$this->document->addLink($this->url->link('content/article','article_id=' .$article_info['article_id']), 'canonical');			
			$this->model_avethemes_article->updateViewed($article_id);
			$data['heading_title'] = $article_info['name'];
			$data['href'] = $this->url->link('content/article','article_id=' .$article_info['article_id']);
			$data['date_added'] = date($this->config->get('ave_cms_date_format'), strtotime($article_info['date_added']));
			
			$template = $article_info['item_display'];	
		
			
						
			$this->load->model('avethemes/comment');
			$data['tab_comment'] = sprintf($this->language->get('tab_comment'), $this->model_avethemes_comment->getTotalCommentsByArticleId($article_info['article_id']));
			
			
			$data['article_id'] = $article_info['article_id'];
			$data['author'] = $article_info['author'];
			$data['author_href'] = $this->url->link('content/author/info', 'author_id=' . $article_info['author_id']);
			
			$this->load->model('avethemes/author');
			$author_info = $this->model_avethemes_author->getAuthor($article_info['author_id']);
	
			$data['author_info'] = false;
		if ($author_info) {
			$data['author_info'] = true;
			$data['author_competence'] = $author_info['competence'];
			$data['author_socials'] = json_decode($author_info['socials'], true);
			$data['author_thumb'] = 'image/'.$author_info['image'];
			$data['author_description'] = html_entity_decode($author_info['author_description'], ENT_QUOTES, 'UTF-8');
		}
			
			
      		$data['submit_testimonial'] = $this->url->link('content/testimonial');
      		$data['get_quote'] = $this->url->link('content/quote');
			
			$url = '';
			if (isset($this->request->get['content_id'])) {
				$url .= '&content_id=' . $this->request->get['content_id'];
			}
			
			if (isset($this->request->get['author_id'])) {
				$url .= '&author_id=' . $this->request->get['author_id'];
			}			

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
						
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
			
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}	
						
			if (isset($this->request->get['filter_content_id'])) {
				$url .= '&filter_content_id=' . $this->request->get['filter_content_id'];
			}
												
			$data['breadcrumbs'][] = array(
				'text'      => $article_info['name'],
				'href'      => $this->url->link('content/article', $url . '&article_id=' . $article_info['article_id']),
				'separator' => $this->language->get('text_separator')
			);			
			
			
			$data['services'] = array();	
			if(!empty($article_info['article_service'])){
				$this->load->model('avethemes/service');
				$services =  $this->model_avethemes_service->getServiceGroup(explode(',', $article_info['article_service']));
					foreach ($services as $service) {	
					    $href = false;
						if(!empty($service['link_id'])){
							$href = $this->url->link('content/category', 'content_id=' . $service['link_id']);
						}
						$data['services'][] =array(
							'name' =>		$service['name'],
							'color' =>		$service['color'],
							'description' =>html_entity_decode($service['description'], ENT_QUOTES, 'UTF-8'),
							'href' =>		$href,
							'icon' =>		$service['icon']
						);
					}
				
			}
			$this->load->model('avethemes/testimonial');
			
			$services_testimonial = (isset($article_info['article_service']))?$article_info['article_service']:false;
			
			$data['testimonials'] = array();
			
			if(!empty($services_testimonial)){
				$testimonials = $this->model_avethemes_testimonial->getTestimonialByServiceGroupID($services_testimonial);	
				foreach ($testimonials as $testimonial_info) {	
						$testimonial_id = $testimonial_info['testimonial_id'];						
						if ($testimonial_info['avatar'] && file_exists(DIR_IMAGE . $testimonial_info['avatar'])) {
							$avatar =  $this->model_tool_image->resize($testimonial_info['avatar'],150,150);
						} else {
							$avatar = $this->model_tool_image->resize('no_image.png',150,150);
						}	
							
					if ($testimonial_info) {					
						$data['testimonials'][$testimonial_id] = array(
						'name' => $testimonial_info['customer_name'],		
						'services' => $services,		
						'message' => html_entity_decode($testimonial_info['message'], ENT_QUOTES, 'UTF-8'),		
						'competence' => $testimonial_info['competence'],			
						'rating' => $testimonial_info['rating'],							
						'avatar' => $avatar,					
						);
					}
				}	
			}
						
			/*version*/ 
			$data['downloads'] = array();
			if(!empty($article_info['article_download'])){
				$downloads_results= $this->model_avethemes_article->getDownloadGroup($article_info['article_download']);
				foreach ($downloads_results as $download) {
						$ext='assets/global/img/file_icon/'.substr(strrchr($download['mask'], '.'), 1).'.png';
					
					$data['downloads'][] = array(
					'name' => html_entity_decode($download['name'], ENT_QUOTES, 'UTF-8'),		
					'description' => html_entity_decode($download['description'], ENT_QUOTES, 'UTF-8'),		
					'color' => $download['color'],		
					'mask' => $download['mask'],		
					'ext' => substr(strrchr($download['mask'], '.'), 1),		
					'thumb' => $ext,		
					'href' => $this->url->link('content/article/download','&auth_key=' . $download['auth_key']),			
					);
				}
			}
			/*Image*/ 				
			$data['width'] = $this->config->get('ave_cms_article_popup_width');
			$data['height'] = $this->config->get('ave_cms_article_popup_height');				
			$data['comment_status'] = $this->config->get('ave_cms_comment_status');
			$data['comments'] = sprintf($this->language->get('text_comments'), (int)$article_info['comments']);
			$data['rating'] = (int)$article_info['rating'];
			$data['description'] = html_entity_decode($article_info['description'], ENT_QUOTES, 'UTF-8');
			
			
			$data['tags'] = array();
					
			$tags = explode(',', $article_info['tag']);
			
			foreach ($tags as $tag) {
				$data['tags'][] = array(
					'tag'  => trim($tag),
					'href' => $this->url->link('content/search', 'filter_tag=' . trim($tag))
				);
			}
			
			
			$data['poll_id'] = $article_info['poll_id'];
			
			$poll_settings=array(
			'poll_id'=>$article_info['poll_id'],
			'display-title'=>false
			);
			if($article_info['poll_id']!=0){
				$data['article_poll'] = $this->load->controller('avethemes/community_poll',$poll_settings);
			}else{
				$data['article_poll'] = false;
			}
			
			
		/*RELATED ARTICLE*/ 	 		
			$relate_heading = $this->language->get('text_related_'.$template);
		$relate_display = 'post-carousel-grid';
		$relate_carousel_limit = 3;
		$relate_grid_limit = 4;
		
		$config_relate_display = $this->config->get('ave_cms_'.$template.'_related_display');
		if($config_relate_display){
			$relate_display = $config_relate_display;
		}
		$config_relate_carousel_limit =  $this->config->get('ave_cms_'.$template.'_carousel_limit');
		if($config_relate_carousel_limit){
			$relate_carousel_limit = $config_relate_carousel_limit;
		}
		$config_relate_grid_limit =  $this->config->get('ave_cms_'.$template.'_grid_limit');
		if($config_relate_grid_limit){
			$relate_grid_limit = $config_relate_grid_limit;
		}
		$relate_total = $this->model_avethemes_article->getTotalArticleRelated($this->request->get['article_id']);
		$relate_setting=array(
				'status'	=> true,
				'article_type'	=> 'relate_article',
				'parent_id'	=> $article_id,
				'module'	=> 'relate_post_'.$article_id,
				'heading_title'	=> $relate_heading.' ('.$relate_total.')',
				'display'	=> $relate_display,
				'template'	=> $relate_display,
				'grid_limit'	=> $relate_grid_limit,
				'carousel_nav'	=> 'top',
				'description_limit'	=> $this->config->get('ave_cms_related_description_limit'),
				'carousel_limit'	=> $relate_carousel_limit,
				'position'	=> 'content_bottom'
		);
		$data['article_related'] = $this->load->controller('module/ave_content_post_type',$relate_setting);
		
		/*RELATED PRODUCT*/ 	
		$data['product_related'] = false;
		if($this->config->get('config_image_thumb_width')){
			$product_width = $this->config->get('config_image_thumb_width');
		}else{			
			$product_width = 300;
		}
		if($this->config->get('config_image_thumb_height')){
			$product_height = $this->config->get('config_image_thumb_height');
		}else{			
			$product_height = 360;
		}
			
		$product_grid_limit = 4;
		if($this->config->has('ave_cms_product_grid_limit')){
			$product_grid_limit = $this->config->get('ave_cms_product_grid_limit');
		}
		$product_carousel_limit = 4;
		if($this->config->has('ave_cms_product_carousel_limit')){
			$product_carousel_limit = $this->config->get('ave_cms_product_carousel_limit');
		}
		$product_template = 'product-carousel-grid';
		if($this->config->has('ave_cms_related_product_display')){
			$product_template = $this->config->get('ave_cms_related_product_display');
		}
		$product_total = $this->model_avethemes_article->getTotalProductRelated($this->request->get['article_id']);
		$products_results = $this->model_avethemes_article->getProductRelated($this->request->get['article_id']);
			if($product_total){
				$product_related_setting=array(
						'heading_title'	=> $this->language->get('text_related_product').' ('.$product_total.')',
						'module'	=> 'relate_products'.$article_id,
						'products'	=> $products_results,
						'btn_cart'	=> $this->ave->get('category_btn_cart'),
						'btn_whistlist'	=> $this->ave->get('category_btn_whistlist'),
						'btn_compare'	=> $this->ave->get('category_btn_compare'),
						'product_type'	=> 'related',
						'position'	=> 'content_bottom',
						'num_row'	=> 1,
						'carousel_nav'	=> 'top',
						'carousel_autoplay'	=> 'false',
						'display'	=> $product_template,
						'grid_limit'	=> $product_grid_limit,
						'carousel_limit'	=> $product_carousel_limit,
						'image_width'	=>$product_width, 
						'image_height'	=>$product_height
				);
				$data['product_related'] = $this->load->controller('module/ave_product',$product_related_setting);
			}
			/*Article Banner*/			
					$banner_images = $this->model_avethemes_article->getArticleImages($this->request->get['article_id']);	
					
					if($template=='blog'){
						$image_width = $this->config->get('ave_cms_blog_details_image_width');		
						$image_height= $this->config->get('ave_cms_blog_details_image_height');
						$pop_width = $this->config->get('ave_cms_article_popup_width');		
						$pop_height= $this->config->get('ave_cms_article_popup_height');
						
						$image_display='blog';
					}
					if($template=='project'){
						$image_width = $this->config->get('ave_cms_project_details_image_width');		
						$image_height= $this->config->get('ave_cms_project_details_image_height');	
						$pop_width = $this->config->get('ave_cms_project_popup_width');		
						$pop_height= $this->config->get('ave_cms_project_popup_height');
						$image_display='project';
					}
					if($template=='gallery'){
						$image_width = $this->config->get('ave_cms_gallery_details_image_width');		
						$image_height= $this->config->get('ave_cms_gallery_details_image_height');	
						$pop_width = $this->config->get('ave_cms_gallery_popup_width');		
						$pop_height= $this->config->get('ave_cms_gallery_popup_height');
						$image_display='gallery';
					}
					
					$banner_settings= array(
										'width'			=>$image_width,
										'height'		=>$image_height,
										'popup_width'			=>$pop_width,
										'popup_height'		=>$pop_height,
										'display'		=>$image_display,
										'images'		=>$banner_images
										);
					$data['banner_images'] = $this->load->controller('content/article/article_images',$banner_settings);
			/*Template*/ 
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/content/article_'.$template.'.tpl')) {
				$this_template = $this->config->get('config_template') . '/avethemes/template/content/article_'.$template.'.tpl';
			} else {
				$this_template = 'default/avethemes/template/content/article_'.$template.'.tpl';
			}
					
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
						
			$this->response->setOutput($this->load->view($this_template, $data));
		} else {
			$url = '';
			
			if (isset($this->request->get['content_id'])) {
				$url .= '&content_id=' . $this->request->get['content_id'];
			}
			
			if (isset($this->request->get['author_id'])) {
				$url .= '&author_id=' . $this->request->get['author_id'];
			}			

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}	
					
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
							
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
					
			if (isset($this->request->get['filter_content_id'])) {
				$url .= '&filter_content_id=' . $this->request->get['filter_content_id'];
			}
								
      		$data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('content/article', $url . '&article_id=' . $article_id),
        		'separator' => $this->language->get('text_separator')
      		);			
		
      		$this->document->setTitle($this->language->get('text_error'));

      		$data['heading_title'] = $this->language->get('text_error');

      		$data['text_error'] = $this->language->get('text_error');

      		$data['button_continue'] = $this->language->get('button_continue');

      		$data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this_template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this_template = 'default/template/error/not_found.tpl';
			}
			
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
						
			$this->response->setOutput($this->load->view($this_template, $data));
    	}
  	}
	public function article_images($setting) {
		$this->load->model('tool/image');		
			$width = 560;
			$height = 420;
			$popup_width = 800;
			$popup_height = 500;		
		if (!empty($setting['width'])&&!empty($setting['height'])) {	
			$width = $setting['width'];
			$height = $setting['height'];		
		} 
		if (!empty($setting['popup_width'])&&!empty($setting['popup_height'])) {	
			$popup_width = $setting['popup_width'];
			$popup_height = $setting['popup_height'];		
		} 			
		
		
		$display = $setting['display'];
		$images = $setting['images'];
		
		$data['width']=$width;		
		$data['height']=$height;
		$grid_limit=$this->config->get('ave_cms_gallery_image_limit');
		
		if(!empty($grid_limit)){			
			$data['grid_limit']=$grid_limit;	
		}else{
			$data['grid_limit']=4;	
		}
		$data['banners'] = array();
		
		foreach ($images as $image) {
		
			if ($image['image'] && file_exists(DIR_IMAGE . $image['image'])) {
				$thumb =  $this->model_tool_image->resize($image['image'], $width, $height);
				$popup =  $this->model_tool_image->resize($image['image'], $popup_width, $popup_height);
			} else {
				$thumb = false;
				$popup = false;
			}		
			if (file_exists(DIR_IMAGE . $image['image'])) {
				$data['banners'][] = array(
					'title' => $image['image_title'],
					'description' => html_entity_decode($image['image_description'], ENT_QUOTES, 'UTF-8'),
					'full_image' => HTTPS_SERVER.'image/'.$image['image'],
					'thumb' => $thumb,		
					'popup' => $popup,				
				);
			}
		}
			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/content/image_'.$display.'.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/content/image_'.$display.'.tpl';
		} else {
			$this_template = 'default/avethemes/template/content/image_'.$display.'.tpl';
		}
		return $this->load->view($this_template, $data);
	}
	
	public function comment() {
    	$this->load->language('avethemes/article');
		
		$this->load->model('avethemes/comment');

		$data['text_on'] = $this->language->get('text_on');
		$data['text_no_comments'] = $this->language->get('text_no_comments');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$data['comments'] = array();
		
		$comment_total = $this->model_avethemes_comment->getTotalCommentsByArticleId($this->request->get['article_id']);
			
		$results = $this->model_avethemes_comment->getCommentsByArticleId($this->request->get['article_id'], ($page - 1) * 5, 5);
      		
		foreach ($results as $result) {
        	$data['comments'][] = array(
        		'author'     => $result['author'],
				'text'       => $result['text'],
				'rating'     => (int)$result['rating'],
        		'comments'    => sprintf($this->language->get('text_comments'), (int)$comment_total),
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}			
			
		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = 5; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('content/article/comment', 'article_id=' . $this->request->get['article_id'] . '&page={page}');
			
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($comment_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($comment_total - 5)) ? $comment_total : ((($page - 1) * 5) + 5), $comment_total, ceil($comment_total / 5));

		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/content/comment.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/content/comment.tpl';
		} else {
			$this_template = 'default/avethemes/template/content/comment.tpl';
		}
		
		$this->response->setOutput($this->load->view($this_template, $data));
	}
	
	public function write() {
		$this->load->language('avethemes/article');
		
		$this->load->model('avethemes/comment');
		
		
		$json = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}
			
			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}
	
			if (empty($this->request->post['rating'])) {
				$json['error'] = $this->language->get('error_rating');
			}
	
			if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
				$json['error'] = $this->language->get('error_captcha');
			}
				
			if (!isset($json['error'])) {
				$this->model_avethemes_comment->addComment($this->request->get['article_id'], $this->request->post);
				
				$json['success'] = $this->language->get('text_success');
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function download(){	
		$language_data = $this->load->language('avethemes/article');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}	
		
		$this->load->model('avethemes/article');
		if (isset($this->request->get['auth_key'])) {
			$auth_key = $this->request->get['auth_key'];
		} else {
			$auth_key = 0;
		}
	
		if ($this->config->get('ave_cms_login_to_download')) {
				if (!$this->customer->isLogged()) {
					$this->session->data['redirect'] = $this->url->link('content/article/download','&auth_key='.$auth_key);
			  
					$this->response->redirect($this->url->link('account/login', '', 'SSL'));
				} 
		}
		$download_info=$this->model_avethemes_article->getDownloadFile($auth_key);
						
		if($download_info) {
			$file = DIR_DOWNLOAD.$download_info['filename'];
			$mask = basename($download_info['mask']);
			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));					
					readfile($file, 'rb');					
					exit;
				} else {//error					
						$data['breadcrumbs'][] = array(
							'text'      => $this->language->get('text_download_error'),
							'href'      => $this->url->link('content/article/download','auth_key='.$auth_key),
							'separator' => $this->language->get('text_separator')
						);					
						$this->document->setTitle($this->language->get('text_download_error'));
						$this->document->setTitle($this->language->get('text_download_error'));
						$data['heading_title'] = $this->language->get('text_download_error');
						$data['text_error'] = $this->language->get('text_download_not_found');
						$data['button_continue'] = $this->language->get('button_continue');
									
						
					$data['column_left'] = $this->load->controller('common/column_left');
					$data['column_right'] = $this->load->controller('common/column_right');
					$data['content_top'] = $this->load->controller('common/content_top');
					$data['content_bottom'] = $this->load->controller('common/content_bottom');
					$data['footer'] = $this->load->controller('common/footer');
					$data['header'] = $this->load->controller('common/header');
							
						$data['continue'] = $this->url->link('common/home');
						if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
							$this_template = $this->config->get('config_template') . '/template/error/not_found.tpl';
						} else {
							$this_template = 'default/template/error/not_found.tpl';
						}
						$this->response->setOutput($this->load->view($this_template, $data));
				}
			} else {
				exit('Error: Headers already sent out!');
			}	
		} else {//error								
      		$data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_download_error'),
				'href'      => $this->url->link('content/article/download','auth_key='.$auth_key),
        		'separator' => $this->language->get('text_separator')
      		);					
						$this->document->setTitle($this->language->get('text_download_error'));
						$this->document->setTitle($this->language->get('text_download_error'));
						$data['heading_title'] = $this->language->get('text_download_error');
						$data['text_error'] = $this->language->get('text_download_not_found');
						$data['button_continue'] = $this->language->get('button_continue');
						
      		$data['continue'] = $this->url->link('common/home');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');	
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this_template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this_template = 'default/template/error/not_found.tpl';
			}								
			$this->response->setOutput($this->load->view($this_template, $data));
		}
	}
	public function info() { 
		$this->load->model('avethemes/article');
		if (isset($this->request->get['info_id'])) {
			$article_id = $this->request->get['info_id'];
		} else {
			$article_id = 0;
		}	
		$article_info = $this->model_avethemes_article->getArticle($article_id);

		$output = '<div class="content-info">';
		if ($article_info) {
			$output .= html_entity_decode($article_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}
		$output .= '</div>';
		$this->response->setOutput($output);
		
  	}
	public function free_download($setting=array()) {
		if(defined('ave_check')){
		$data['ave'] = $this->ave;
		$data['position'] = $position = isset($setting['layout_position'])?$setting['layout_position']:'content_top';
		$data['side_position'] = $side_position = $this->ave->sidePosition();
		$this->load->language('avethemes/global_lang');
		
		$this->document->addStyle('assets/theme/widget/call_action.css');
		
    	$data['text_download'] = $this->language->get('text_download');
		
		$this->load->model('avethemes/global');
				
		$free_file = $setting['sections']['free_file'];
		$data['downloads'] = array();
		
		$downloads = $this->model_avethemes_global->getDownloadsGroup($free_file);
		foreach ($downloads as $download_info) {			
			if ($download_info) {					
				$ext='assets/global/img/file_icon/'.substr(strrchr($download_info['mask'], '.'), 1).'.png';
				$data['downloads'][] = array(
				'name' => html_entity_decode($download_info['name'], ENT_QUOTES, 'UTF-8'),		
				'description' => html_entity_decode($download_info['description'], ENT_QUOTES, 'UTF-8'),		
				'mask' => $download_info['mask'],		
				'ext' => substr(strrchr($download_info['mask'], '.'), 1),		
				'thumb' => $ext,		
				'href' => $this->url->link('content/article/download','&auth_key=' . $download_info['auth_key']),				
				);
			}
		}	
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/avethemes/template/shortcodes/free_download_section.tpl')) {
			$this_template = $this->config->get('config_template') . '/avethemes/template/shortcodes/free_download_section.tpl';
		} else {
			$this_template = 'default/avethemes/template/shortcodes/free_download_section.tpl';
		}
        return $this->load->view($this_template, $data);
		}
	}
}
?>