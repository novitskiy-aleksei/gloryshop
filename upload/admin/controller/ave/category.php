<?php 
class ControllerAveCategory extends Controller { 
	private $error = array();

    public function index() {
        $this->document->addStyle('../assets/editor/plugins/jstree/themes/default/style.min.css', 'stylesheet');
        $this->document->addScript('../assets/editor/plugins/jstree/jstree.js');
		
		$language_data = $this->load->language('avethemes/category');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
		/*Language*/ 
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
        $this->load->model('setting/setting');

        $this->document->setTitle($this->language->get('heading_title'));
		
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
       
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
        );
        
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('ave/category', 'token=' . $this->session->data['token']. '', 'SSL'),
        );


        $data['action'] = $this->url->link('ave/category', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $data['token'] = $this->session->data['token'];

        $data['token'] = $this->session->data['token'];
		$this_template = 'avethemes/content/category.tpl';
		
		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view($this_template, $data));

    }
	
    public function tree() {
        $json = array();

        $operation = isset($this->request->get['operation']) ? $this->request->get['operation'] : '';
        $root = (isset($this->request->get['id']) && $this->request->get['id'] == '#');
        $node = isset($this->request->get['id']) && ctype_digit($this->request->get['id']) ? $this->request->get['id'] : 0;
        $this->load->model('avethemes/category');
        if ($operation == 'get_node') {
            if ($root) {
                $json[] = array('data' => array('status' => 1 ), 'text' => '', 'children' => true,  'id' => "0", 'icon' => 'jstree-folder');
            }
            else {
                $cats = $this->model_avethemes_category->getChildren($node);
                foreach ($cats as $cat) {
                    $json[]=array(
						'data'=>array(
							'status'=>$cat['status']),
							'text'=>$cat['name'],
							'children'=>$cat['children']>0,
							'id'=>$cat['content_id'],
							'icon'=>'jstree-folder',
							'a_attr'=>array(
								'ico-disabled'=>!(bool)$cat['status']
								)
						);
                }
            }
        }

        $this->response->addHeader('Content-Type: application/json; charset=utf-8');
        $this->response->setOutput(json_encode($json));
    }
	
	public function delete(){
		$json = array();
		$this->load->language('avethemes/category');
		$this->load->model('avethemes/category');
		$errors = array(
			'error_warning'
		);
	
		if (isset($this->request->get['content_id']) && $this->validateDelete()){			
			$this->model_avethemes_category->deleteCategory($this->request->get['content_id']);
			$json['success'] = $this->language->get('text_success');
		}else{
			if (isset($this->error['error_warning'])) {
				$json['error'] = $this->error['error_warning'];
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}
	
	public function apply(){
		$json = array();
		$this->load->language('avethemes/category');
		$this->load->model('avethemes/category');
		$errors = array(
			'error_warning',
			'error_name',
			'error_meta_title',
			'error_keyword'
		);
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()){
			if(isset($this->request->post['content_id'])&&$this->request->post['content_id']!=0){				
				$this->model_avethemes_category->editCategory($this->request->post['content_id'], $this->request->post);
			}else{
				$this->session->data['success'] = $this->language->get('text_success');
				$content_id = $this->model_avethemes_category->addCategory($this->request->post);
			}
			$json['success'] = $this->language->get('text_success');
		}else{
			foreach($errors as $key){
				if (isset($this->error[$key])) {
					$json['error'] = $this->error[$key];
				}
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}
	
	public function form() {	

		$this->load->model('avethemes/category');
		$category_lang = $this->load->language('avethemes/category');
		foreach($category_lang as $key=>$value){
			$data[$key] = $value;
		}	
		$url = '';
						
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
	
 		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}
 		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/category', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		
			$data['title'] = $this->language->get('text_add_new');
			$data['filter'] = $data['view'] = false;
		if (isset($this->request->get['content_id'])&&$this->request->get['content_id']!=0) {
			$data['title'] =$this->language->get('text_edit_cate');
			$data['view'] = HTTP_CATALOG.'index.php?route=content/category&content_id='.$this->request->get['content_id'];
			$data['filter'] = $this->url->link('ave/article', 'filter_content_category=' . $this->request->get['content_id'].'&token=' . $this->session->data['token'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('ave/category', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['content_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$category_info = $this->model_avethemes_category->getCategory($this->request->get['content_id']);
    	}
		/*Content Data*/ 
		$form_data = array(
		'category_description'=>array(),
		'content_id'=>FALSE,
		'parent_id'=>0,
		'category_store'=>array(0),
		'keyword'=>'',
		'color'=>'',
		'icon'=>'',
		'image'=>'',
		'top'=>0,
		'type'=>'category',
		'link'=>'',
		'target'=>'_self',
		'column'=>1,
		'display'=>'multi_level',
		'item_display'=>'blog',
		'content_size'=>'col-3',
		'sort_order'=>999,
		'status'=>'',
		'nav_thumb'=>1,
		'category_layout'=>array()
		);
		
		foreach($form_data as $key=>$value){
			if (isset($this->request->post[$key])) {
				$data[$key] = $this->request->post[$key];
			} elseif (!empty($category_info)) {
				$data[$key] = isset($category_info[$key])?$category_info[$key]:$value;
			} else {
				$data[$key] = $value;
			}
		}
		
		if (isset($this->request->get['parent_id'])) {
			$parent_info = $this->model_avethemes_category->getCategory($this->request->get['parent_id']);
			if($parent_info){
				$data['path'] = $parent_info['name'];
				$data['parent_id'] =  $this->request->get['parent_id'];
			}
		}
		
		
		$data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		if (isset($this->request->get['content_id'])) {
			$data['category_description'] = $this->model_avethemes_category->getCategoryDescriptions($this->request->get['content_id']);
		}
		$categories = $this->model_avethemes_category->getCategories(0);
		// Remove own id from list
		if (!empty($category_info)) {
			foreach ($categories as $key => $category) {
				if ($category['content_id'] == $category_info['content_id']) {
					unset($categories[$key]);
				}
			}
		}
		$data['categories'] = $categories;
						
		$this->load->model('setting/store');
		
		$data['stores'] = $this->model_setting_store->getStores();
		if (isset($this->request->get['content_id'])&&!empty($category_info)) {
			$data['category_store'] = $this->model_avethemes_category->getCategoryStores($this->request->get['content_id']);
		}
		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($category_info) && $category_info['image'] && file_exists(DIR_IMAGE . $category_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($category_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		
		if (isset($this->request->post['content_faq'])) {
			$content_faqs = $this->request->post['content_faq'];
		} elseif (isset($this->request->get['content_id'])) {
			$content_faqs = $this->model_avethemes_category->getContentFaqs($this->request->get['content_id']);	
		} else {
			$content_faqs = array();
		}
		$data['content_faqs'] = $content_faqs;
		
		$this->load->model('design/layout');
		$data['language_id'] = $this->config->get('config_language_id');
		$data['layouts'] = $this->model_design_layout->getLayouts();
		if (isset($this->request->get['content_id'])) {
			$data['category_layout'] = $this->model_avethemes_category->getCategoryLayouts($this->request->get['content_id']);
		}		
		$this_template = 'avethemes/content/category_form.tpl';
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'ave/category')) {
			$this->error['error_warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['category_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['error_name'] = $this->language->get('error_name');
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['error_warning'] = $this->language->get('error_warning');
		}
		/*SEO Keyword
		$this->load->model('avethemes/article');
		if (isset($this->request->post['content_id'])&&isset($this->request->post['keyword'])) {
		 $keyword_total = $this->model_avethemes_article->getTotalKeywordByObjectID($this->request->post['keyword'],'content_id',$this->request->post['content_id']);    
			if ($keyword_total) {
	  			$this->error['keyword'] = $this->language->get('error_keyword');	
			}				
		}elseif (!isset($this->request->post['content_id'])&&isset($this->request->post['keyword'])) {
		 $keyword_total = $this->model_avethemes_article->getTotalKeyword($this->request->post['keyword']);    
			if ($keyword_total) {
	  			$this->error['keyword'] = $this->language->get('error_keyword');	
			}	
		}		*/ 
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'ave/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
			
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('avethemes/category');
			
			$filter = array(
				'parent_id' => 0,
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$results = $this->model_avethemes_category->filterCategories($filter);
				
			foreach ($results as $result) {
				if($result['type']=='category'){
					$json[] = array(
						'content_id' => $result['content_id'], 
						'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
					);
				}
			}		
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}	
}
?>