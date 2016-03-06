<?php
class ControllerContentSeoUrl extends Controller {
	public static $url_alias_data = array();
	public function queryGroup($key) {		
		$return = false;
		if(isset(self::$url_alias_data[$key])){
				$return = self::$url_alias_data[$key];
		}else{
			$query = $this->db->query("SELECT `query`, `keyword` FROM " . DB_PREFIX . "url_alias  WHERE `query` LIKE '" . $this->db->escape($key) . "=%'");			
			if ($query->num_rows) {
				$return = $query->rows;
			} else{
				$return = array();
			}
			self::$url_alias_data[$key] = $return;
		}
			return $return;
	}
	public function index() {
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}
		
		// Decode URL
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);
			
			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");
				
				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);
					
					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}
					
					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}	
					
					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}
					
					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}	
					
					/*LegendTools::ContentRouteQuery*/
					if ($url[0] == 'article_id') {
						$this->request->get['article_id'] = $url[1];
					}
					if ($url[0] == 'content_id') {
						if (!isset($this->request->get['content_id'])) {
							$this->request->get['content_id'] = $url[1];
						} else {
							$this->request->get['content_id'] .= '_' . $url[1];
						}
					}
					if ($url[0] == 'author_id') {
						$this->request->get['author_id'] = $url[1];
					}
					/*ContentRouteQuery*/ 
				} else {
					$this->request->get['route'] = 'error/not_found';	
				}
			}
			
			if (isset($this->request->get['product_id'])) {
				$this->request->get['route'] = 'product/product';
			} elseif (isset($this->request->get['path'])) {
				$this->request->get['route'] = 'product/category';
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$this->request->get['route'] = 'product/manufacturer/info';
			} elseif (isset($this->request->get['information_id'])) {
				$this->request->get['route'] = 'information/information';
			}
			
			/*LegendTools::GetContentRoute*/ 
			elseif (isset($this->request->get['article_id'])) {				
				$this->request->get['route'] = 'content/article';				
			}elseif (isset($this->request->get['content_id'])) {				
				$this->request->get['route'] = 'content/category';				
			}elseif (isset($this->request->get['author_id'])) {				
				$this->request->get['route'] = 'content/author/info';				
			}elseif (isset($this->request->get['author_id'])) {				
				$this->request->get['route'] = 'content/author/info';				
			}
			$page_alias = $this->config->get('autokw_page_routes');
			if(is_array($page_alias)){
				foreach ($page_alias as $page){					
					if ($this->request->get['_route_'] ==  $page['page_url']) {				
						$this->request->get['route'] =  $page['page_route'];				
					}					
				}
			}
			/*EndGetContentRoute*/ 
			
			if (isset($this->request->get['route'])) {
				return new Action($this->request->get['route']);
			}
		}
	}
	
	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));
		$page_alias = $this->config->get('autokw_page_routes');
	
		$url = ''; 
		
		$data = array();
		
		parse_str($url_info['query'], $data);
		
		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
				if (($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
					
						$urls_data[$key]= $this->queryGroup($key);
						if(isset($urls_data[$key])){							
							foreach ($urls_data[$key] as $url_alias) {
							if ($url_alias['query']==($key . '=' . (int)$value)) {
									$url .= '/' . $url_alias['keyword'];
									unset($data[$key]);
									break;
							}									
							}
						}		
				} elseif ($key == 'path') {
					
					$urls_data[$key]= $this->queryGroup('category_id');
					$categories = explode('_', $value);

					foreach ($categories as $category_id) {
						$matched_category_id = false;
						if(isset($urls_data[$key])){						
							foreach ($urls_data[$key] as $url_alias) {								
								if ($url_alias['query']==('category_id=' . (int)$category_id)) {
										$url .= '/' . $url_alias['keyword'];
								$matched_category_id = true;
										unset($data[$key]);
										break;
								}									
							}
						}
						if (!$matched_category_id) {
							$url = '';
							break;
						}
					}

					unset($data[$key]);
				}
				/*LegendTools::RewriteBlogURL*/
				elseif (($data['route'] == 'content/article' && $key == 'article_id')||(($data['route']=='content/author/info'||$data['route']=='content/article')&&$key=='author_id')){				
						$urls_data[$key]= $this->queryGroup($key);
						if(isset($urls_data[$key])){							
							foreach ($urls_data[$key] as $url_alias) {
								if ($url_alias['query']==($key . '=' . (int)$value)) {
										$url .= '/' . $url_alias['keyword'];
										unset($data[$key]);
										break;
								}									
							}
						}
				}elseif ($key == 'content_id') {
						$urls_data[$key]= $this->queryGroup('content_id');
					$ncategories = explode('_', $value);
					foreach ($ncategories as $content_id) {
						$matched_content_id = false;
						if(isset($urls_data[$key])){							
							foreach ($urls_data[$key] as $url_alias) {								
								if ($url_alias['query']==('content_id=' . (int)$content_id)) {
										$url .= '/' . $url_alias['keyword'];
								$matched_content_id = true;
										unset($data[$key]);
										break;
								}									
							}
						}
						if (!$matched_content_id) {
							$url = '';
							break;
						}
					}
					unset($data[$key]);
				} elseif ($key == 'route'&&is_array($page_alias)) {					
					foreach ($page_alias as $page){					
						if ($data['route'] ==  $page['page_route'] && $key != 'remove') {	
							 $url .=  '/'.$page['page_url'];		
						}				
					}					
				}
				/*LegendTools::RewriteBlogURL End*/
			}
		}
	
		if ($url) {
			unset($data['route']);
		
			$query = '';
		
			if ($data) {
				foreach ($data as $key => $value) {
					$query .= '&' . $key . '=' . $value;
				}
				
				if ($query) {
					$query = '?' . trim($query, '&');
				}
			}

			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {
			return $link;
		}
	}	
}
?>