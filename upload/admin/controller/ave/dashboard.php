<?php
class ControllerAveDashboard extends Controller {	
	private $error = array();
	public function index() {
		if(!$this->config->get('ave_confirm_installed')){
			$this->load->model('avethemes/install');		
			$this->model_avethemes_install->checkInstall();	
		}
		$this->info();	
	}
	public function info(){			
		$language_data = $this->load->language('avethemes/content_dashboard');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
		$this->document->setTitle($data['heading_title']);
		
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateContent()) {
			$this->model_setting_setting->editSetting('ave_cms', $this->request->post);	
					
			$this->session->data['success'] = $data['text_success'];
						
			$this->response->redirect($this->url->link('ave/dashboard/info', 'token=' . $this->session->data['token'], 'SSL'));
		}		
		
		
		$data['sample']=$this->url->link('ave/dashboard/install_sample','token='.$this->session->data['token'], 'SSL');
		$data['uninstall_module']=$this->url->link('ave/dashboard/uninstall_module','token='.$this->session->data['token'], 'SSL');
		$data['optimize']=$this->url->link('ave/dashboard/optimize','token='.$this->session->data['token'], 'SSL');
		$data['empty_db']=$this->url->link('ave/dashboard/empty_db','token='.$this->session->data['token'], 'SSL');
		$data['drop_db']=$this->url->link('ave/dashboard/drop_db','token='.$this->session->data['token'], 'SSL');
		
		$data['setting'] = $this->url->link('ave/dashboard/info', 'token=' . $this->session->data['token'], 'SSL');
		$data['category'] = $this->url->link('ave/category', 'token=' . $this->session->data['token'], 'SSL');
		$data['article'] = $this->url->link('ave/article', 'token=' . $this->session->data['token'], 'SSL');
		$data['author'] = $this->url->link('ave/author', 'token=' . $this->session->data['token'], 'SSL');
		$data['download'] = $this->url->link('ave/download', 'token=' . $this->session->data['token'], 'SSL');
		$data['comment'] = $this->url->link('ave/comment', 'token=' . $this->session->data['token'], 'SSL');
		$data['poll'] = $this->url->link('ave/poll', 'token=' . $this->session->data['token'], 'SSL');		
		$data['general'] = $this->url->link('ave/skin', 'token=' . $this->session->data['token'], 'SSL');	
		
		$data['sample']=$this->url->link('ave/dashboard/install_sample','token='.$this->session->data['token'], 'SSL');
		$data['hide_sample']=$this->url->link('ave/dashboard/hide_sample','token='.$this->session->data['token'], 'SSL');	
		$data['ave_confirm_installed'] = $this->config->get('ave_confirm_installed');
		if($data['ave_confirm_installed']){
		$this->load->model('avethemes/category');
		$this->load->model('avethemes/article');
		$this->load->model('avethemes/author');
		$this->load->model('avethemes/comment');
		$this->load->model('avethemes/download');
		$this->load->model('avethemes/poll');
		
		$data['total_category'] = $this->model_avethemes_category->getTotalCategories();
		$data['total_article'] = $this->model_avethemes_article->getTotalArticle();
		$data['total_author'] = $this->model_avethemes_author->getTotalAuthors();
		$data['total_download'] = $this->model_avethemes_download->getTotalDownloads();
		$data['total_comment'] = $this->model_avethemes_comment->getTotalComments();
		$data['total_comment_awaiting'] = $this->model_avethemes_comment->getTotalCommentsAwaitingApproval();
		$data['total_poll'] = $this->model_avethemes_poll->getTotalPolls();
		}
		/*Success*/ 
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		/*Error*/ 
		$errors = array(
			'error_warning',
			'error_content_limit',
			'error_email',
			'error_ave_cms_related_desc_limit',
			'error_ave_cms_content_desc_limit',
			'error_image_gallery',
			'error_image_gallery_popup',
			'error_image_project',
			'error_image_project_popup',
			'error_image_article',
			'error_image_category',
			'error_blog_list_image',
			'error_gallery_list_image',
			'error_project_list_image',
			'error_image_banner'
		);
		foreach ($errors as $error_key) {
			if (isset($this->error[$error_key])) {
				$data[$error_key] = $this->error[$error_key];
			} else {
				$data[$error_key] = '';
			}
        }
		
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $data['text_home'],
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $data['text_module'],
			'href'      => $this->url->link('ave/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $data['heading_title'],
			'href'      => $this->url->link('ave/skin', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		/*General Settings*/
		$this->load->model('avethemes/install');
		$config_data = $this->model_avethemes_install->getContentConfig();
		if (isset($this->request->post['ave_cms_installed'])) {
			$data['ave_cms_installed'] = $this->request->post['ave_cms_installed'];
		} else {
			$data['ave_cms_installed'] = $this->config->get('ave_cms_installed');
		}
			
        foreach ($config_data as $config_key=>$config_value) {
			$data[$config_key] = $config_value;
				
            if (isset($this->request->post[$config_key])) {
                $data[$config_key] = $this->request->post[$config_key];
            } else {
                $data[$config_key] = $this->config->get($config_key);
            }
        }
		/*User_group*/ 
		$user_group_data = array();
		$this->load->model('user/user_group');
		$data['user_groups'] = array();
		$user_group_results = $this->model_user_user_group->getUserGroups($user_group_data);
		foreach ($user_group_results as $result) {		
			$data['user_groups'][] = array(
				'user_group_id' => $result['user_group_id'],
				'name'          => $result['name']
			);
		}
		
		$data['cancel'] = $this->url->link('ave/skin', 'token=' . $this->session->data['token'], 'SSL');
		$data['token'] = $this->session->data['token'];
		$data['action'] = $this->url->link('ave/dashboard/info', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['info'] = $this->url->link('ave/dashboard/info', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['sample']=$this->url->link('ave/dashboard/install_sample','token='.$this->session->data['token'], 'SSL');
		$data['hide_sample']=$this->url->link('ave/dashboard/hide_sample','token='.$this->session->data['token'], 'SSL');

		$this->load->controller('ave/shortcut');
		$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this_template = 'avethemes/content/content_dashboard.tpl';
		$this->response->setOutput($this->load->view($this_template, $data));
	}	
	private function validateContent() {
		if (!$this->user->hasPermission('modify', 'ave/dashboard')) {
			$this->error['error_warning'] = $this->language->get('error_permission');
		}		
		if ($this->request->post['ave_cms_comment_email']==1&&(utf8_strlen($this->request->post['ave_cms_comment_email_notifications']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['ave_cms_comment_email_notifications'])&&$this->request->post['ave_cms_comment_email']==1) {
      		$this->error['error_email'] = $this->language->get('text_error_email');
    	}
		if (!$this->request->post['ave_cms_content_limit']) {
			$this->error['error_content_limit'] = $this->language->get('error_content_limit');
		}
		
		/*General Setting	*/ 
		if (($this->request->post['ave_cms_content_description_limit']) < 3 || ($this->request->post['ave_cms_content_description_limit']) > 1024) {
			$this->error['error_ave_cms_content_desc_limit'] = $this->language->get('text_error_article_description_limit');
		}
		if (($this->request->post['ave_cms_related_description_limit']) < 3 || ($this->request->post['ave_cms_related_description_limit']) > 1024) {
			$this->error['error_ave_cms_related_desc_limit'] = $this->language->get('text_error_related_description_limit');
		}
							
		if (!$this->request->post['ave_cms_category_width'] || !$this->request->post['ave_cms_category_height']) {
			$this->error['error_image_category'] = $this->language->get('text_error_image_dimension');
		} 				
		if (!$this->request->post['ave_cms_blog_list_image_width'] || !$this->request->post['ave_cms_blog_list_image_height']) {
			$this->error['error_blog_list_image'] = $this->language->get('text_error_image_dimension');
		} 
			
		if (!$this->request->post['ave_cms_article_popup_width'] || !$this->request->post['ave_cms_article_popup_height']) {
			$this->error['error_image_banner'] = $this->language->get('text_error_image_dimension');
		}	
		
		if (!$this->request->post['ave_cms_project_details_image_width'] || !$this->request->post['ave_cms_project_details_image_height']) {
			$this->error['error_image_project'] = $this->language->get('text_error_image_dimension');
		}
		
		if (!$this->request->post['ave_cms_project_popup_width'] || !$this->request->post['ave_cms_project_popup_height']) {
			$this->error['error_image_project_popup'] = $this->language->get('text_error_image_dimension');
		}
		if (!$this->request->post['ave_cms_gallery_details_image_width'] || !$this->request->post['ave_cms_gallery_details_image_height']) {
			$this->error['error_image_gallery'] = $this->language->get('text_error_image_dimension');
		}	
		if (!$this->request->post['ave_cms_gallery_popup_width'] || !$this->request->post['ave_cms_gallery_popup_height']) {
			$this->error['error_image_gallery_popup'] = $this->language->get('text_error_image_dimension');
		}
		
		
		if (!$this->request->post['ave_cms_blog_details_image_width'] || !$this->request->post['ave_cms_blog_details_image_height']) {
			$this->error['error_image_article'] = $this->language->get('text_error_image_dimension');
		}	
		
			
		if ($this->error && !isset($this->error['error_warning'])) {
			$this->error['error_warning'] = $this->language->get('text_error_warning');
		}
		/*general*/ 
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}		
	public function uninstall_module(){
		if ($this->validate()) {
			$this->load->model('avethemes/install');
			$this->model_avethemes_install->delete_module_setting();	
			$this->model_avethemes_install->uninstall_module();	
			$this->session->data['success']='Success: Successfully drop Blog database!';
			$this->response->redirect($this->url->link('ave/dashboard','token='.$this->session->data['token'], 'SSL'));
		}
	}		
	public function drop_db(){
		if ($this->validate()) {
			$this->load->model('avethemes/install');
			$this->model_avethemes_install->drop_db();			
					$this->db->query("DELETE FROM `".DB_PREFIX."setting` WHERE `code` = 'ave_cms'");	
					$this->db->query("DELETE FROM `". DB_PREFIX. "setting` WHERE `key` = 'ave_confirm_installed'");
							
			$this->session->data['success']='Success: Successfully drop Blog database!';
			$this->response->redirect($this->url->link('extension/module','token='.$this->session->data['token'], 'SSL'));
		}
	}
	public function optimize() {
		if ($this->validate()) {
			$this->load->model('avethemes/install');
			$this->model_avethemes_install->optimize();
			$this->session->data['success']='Success: Successfully optimize your store database!';
			$this->response->redirect($this->url->link('ave/dashboard','token='.$this->session->data['token'], 'SSL'));
		}
	}		
	public function empty_db() {
		if ($this->validate()) {
			$this->load->model('avethemes/install');
			$this->model_avethemes_install->empty_db();
			$this->model_avethemes_install->delete_module_setting();
			$this->model_avethemes_install->uninstall_module();	
			$this->session->data['success']='Success: Successfully empty Blog database!';
			$this->response->redirect($this->url->link('ave/dashboard','token='.$this->session->data['token'], 'SSL'));
		}
	}		
	public function install_sample(){
		if ($this->validate()) {
			$this->load->model('avethemes/install');
			$this->model_avethemes_install->installSampleNews();
			$this->session->data['success']='Success: Successfully installed sample database!';
			$this->response->redirect($this->url->link('ave/dashboard/info','token='.$this->session->data['token'], 'SSL'));
		}
	}	
	public function hide_sample(){
		if ($this->validate()) {
			$this->load->model('avethemes/install');
			$this->model_avethemes_install->hideSampleNews();
			$this->response->redirect($this->url->link('ave/dashboard/info','token='.$this->session->data['token'], 'SSL'));
		}
	}	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'ave/dashboard')) {
			$this->error['error_warning'] = $this->session->data['success'] = 'Error permission!';
		}
		if (!$this->error) {
			return true;
		} else {
			$this->response->redirect($this->url->link('ave/dashboard/info','token='.$this->session->data['token'], 'SSL'));
		}	
	}
}
?>