<?php 
class ControllerAvePoll extends Controller {
	private $error = array();
	
	public function index() {
		
		$this->getList();
	}

	public function insert() {
		$this->load->language('avethemes/poll');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/poll');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_poll->addPoll($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('ave/poll', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('avethemes/poll');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/poll');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_avethemes_poll->editPoll($this->request->get['poll_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
					
			$this->response->redirect($this->url->link('ave/poll', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('avethemes/poll');
 
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('avethemes/poll');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $poll_id) {
				$this->model_avethemes_poll->deletePoll($poll_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('ave/poll', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
	
		$this->load->model('avethemes/poll');
	
		$poll_lang = $this->load->language('avethemes/poll');
		foreach($poll_lang as $key=>$value){
			$data[$key] = $value;
		}
		
		$this->document->setTitle($this->language->get('heading_title'));	

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'question';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
			
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ave/poll', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['insert'] = $this->url->link('ave/poll/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('ave/poll/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		 
		$data['polls'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$poll_total = $this->model_avethemes_poll->getTotalPolls();
		
		$results = $this->model_avethemes_poll->getPolls($filter_data);
		
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('ave/poll/update', 'token=' . $this->session->data['token'] . '&poll_id=' . $result['poll_id'] . $url, 'SSL')
			);

			$data['polls'][] = array(
				'poll_id' => $result['poll_id'],
				'question'       => $result['question'],				
				'selected'  => isset($this->request->post['selected']) && in_array($result['poll_id'], $this->request->post['selected']),				
				'action'    => $action
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_no_results'] = $this->language->get('text_no_results');
		
		$data['column_question'] = $this->language->get('column_question');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');	

		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_module']=$this->language->get('button_module');
		$data['text_error_install']=$this->language->get('text_error_install');
 
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['sort_question'] = $this->url->link('ave/poll', 'token=' . $this->session->data['token'] . '&sort=question' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('ave/poll', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $poll_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ave/poll', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
$data['results'] = sprintf($this->language->get('text_pagination'), ($poll_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($poll_total - $this->config->get('config_limit_admin'))) ? $poll_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $poll_total, ceil($poll_total / $this->config->get('config_limit_admin')));
	
		$data['sort'] = $sort;
		$data['order'] = $order;

		$this_template = 'avethemes/content/poll_list.tpl';
				$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}

	private function getForm() {
		
		$poll_lang = $this->load->language('avethemes/poll');
		foreach($poll_lang as $key=>$value){
			$data[$key] = $value;
		}

		$this->load->model('avethemes/poll');
		

		// Extract results
		if(isset($this->request->get['poll_id'])){
			$poll_id=$this->request->get['poll_id'];
			$data['poll_data']=$this->model_avethemes_poll->getPollData($poll_id);
			$data['text_poll_results']=$this->language->get('text_poll_results');
			$data['poll_results']=$this->url->link('module/ave_community_poll/full_result&poll_id='.$poll_id);
			$data['action']=$this->url->link('content/poll');
			$reactions=$this->model_avethemes_poll->getPollResults($poll_id);
			$total_votes=$this->model_avethemes_poll->getTotalResults($poll_id);
			$percent=array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
			$totals=array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
			$vote=array();
			
			if($reactions){ 
				$data['reactions']=TRUE;
				foreach($reactions as $reaction){ 
				$totals[$reaction['answer'] - 1]++;
					}
		
					for($i=0;
					$i < 15;
					$i++){ 
						$percent[$i]=round(100 * ($totals[$i]/$total_votes));
						$vote[$i]=$totals[$i];
					}
				}
			$data['percent']=$percent;
			$data['vote']=$vote;
			$data['total_votes']=$total_votes;
		}
		// End extraction of results

		if(isset($this->error['warning'])){
			$data['error_warning']=$this->error['warning'];
		}else{
			$data['error_warning']='';
		}
			if(isset($this->error['question'])){
			$data['error_question']=$this->error['question'];
		}else{
			$data['error_question']='';
		}

		if (isset($this->error['banner_image'])) {
			$data['error_banner_image'] = $this->error['banner_image'];
		} else {
			$data['error_banner_image'] = array();
		}	
		
		for ($i = 1;$i <= 2;$i++){//at least 2 possible answers
			if(isset($this->error['answer'][$i])){
				$data['errors_answer'][$i]	=	$this->error['answer'][$i];
			}else{
				$data['errors_answer'][$i]	=	array();
			}
		}
		
			$data['breadcrumbs']=array();
		$data['breadcrumbs'][]=array(
			'href'      =>$this->url->link('common/dashboard','token='.$this->session->data['token'], 'SSL'),
			'text'      =>$this->language->get('text_home'),
			'separator' =>FALSE
		);
		$data['breadcrumbs'][]=array(
			'href'      =>$this->url->link('ave/poll','token='.$this->session->data['token'], 'SSL'),
			'text'      =>$this->language->get('heading_title'),
			'separator' =>' :: '
		);
    	if(!isset($this->request->get['poll_id'])){
    		$data['new_poll']=TRUE;
		$data['action']=$this->url->link('ave/poll/insert','token='.$this->session->data['token'], 'SSL');
		}else{
			$data['action']=$this->url->link('ave/poll/update','token='.$this->session->data['token'].'&poll_id='.$this->request->get['poll_id'], 'SSL');
		}
			$data['cancel']=$this->url->link('ave/poll','token='.$this->session->data['token'], 'SSL');
			$data['poll_setting']=$this->url->link('module/ave_community_poll','token='.$this->session->data['token'], 'SSL');
			
			
    	if((isset($this->request->get['poll_id']))&&($this->request->server['REQUEST_METHOD'] != 'POST')){
     		$poll_info=$this->model_avethemes_poll->getPoll($this->request->get['poll_id']);
    	}
			$this->load->model('localisation/language');
		$data['languages']=$this->model_localisation_language->getLanguages();
		

		if (isset($this->request->post['color'])) {
			$data['color'] = $this->request->post['color'];
		} elseif (!empty($download_info)) {
			$data['color'] = $download_info['color'];
		} else {
			$data['color'] = 'blue-sky';
		}
		$data['setcolors'] = $this->ave->getColors();
		
    	if(isset($this->request->post['poll_description'])){
			$data['poll_description']=$this->request->post['poll_description'];
		}elseif(isset($poll_info)){
			$data['poll_description']=$this->model_avethemes_poll->getPollDescriptions($this->request->get['poll_id']);
		}else{
			$data['poll_description']=array();
		}
		
		$this->load->model('setting/store');
		$data['stores']=$this->model_setting_store->getStores();
    	if(isset($this->request->post['poll_store'])){
			$data['poll_store']=$this->request->post['poll_store'];
		}elseif(isset($poll_info)){
			$data['poll_store']=$this->model_avethemes_poll->getPollStores($this->request->get['poll_id']);
		}else{
			$data['poll_store']=array(0);
		}
		$this_template = 'avethemes/content/poll_form.tpl';
				$this->load->controller('ave/shortcut');
$data['shortcut_group'] = $this->load->controller('ave/shortcut/blog');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
				
		$this->response->setOutput($this->load->view($this_template, $data));
	}

	private function validateForm() {
	
		if (!$this->user->hasPermission('modify', 'ave/poll')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		
    	foreach ($this->request->post['poll_description'] as $language_id => $value) {
      		if ((utf8_strlen($value['question']) < 1) || (utf8_strlen($value['question']) > 255)) {
        		$this->error['question'][$language_id] = $this->language->get('error_question');
      		}
			
			for ($i = 1;
		$i <= 2;
		$i++){
				if(((utf8_strlen(utf8_decode($value['answer_'.$i])) < 2)||(utf8_strlen(utf8_decode($value['answer_'.$i])) > 128))){
					$this->error['answer'][$i][$language_id]=$this->language->get('error_answer');
				}
			}
    	}
		
		
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'ave/poll')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>