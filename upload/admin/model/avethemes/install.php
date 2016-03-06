<?php
/******************************************************
 * @package Legend Editor Opencart 2.0.x
 * @version 1.0
 * @author http://www.avethemes.com
 * @copyright	Copyright (C) January 2015 www.avethemes.com <@emai:avethemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelAvethemesInstall extends Model {	
	public function getModules(){		
		$modules=array(	
					'ave_content_post_list',
					'ave_content_post_type',
					'ave_custom_html',
					'ave_shortcodes',
					'ave_product',
					'ave_product_category',
					'ave_product_list',
					'ave_product_tabs',
					'ave_sliderbanner'			
		);		
		return $modules;
	}
	
	public function getContentTables(){		
			$tables=array(
					'ave_article',
					'ave_article_description',
					'ave_article_image',
					'ave_article_to_category',
					'ave_article_to_layout',
					'ave_article_to_store',
					'ave_author',
					'ave_category',
					'ave_category_description',
					'ave_category_to_layout',
					'ave_category_to_store',
					'ave_content_faq',
					'ave_comment',
					'ave_download',
					'ave_download_description',
					'ave_poll',
					'ave_poll_description',
					'ave_poll_reactions',
					'ave_poll_to_store',
					'ave_related_article',
					'ave_related_product',
					'ave_service',
					'ave_service_description',
					'ave_service_to_store',
					'ave_service_quote',
					'ave_testimonial_service',
					'ave_testimonial'
			);		
		return $tables;	
	}
	public function checkInstall(){
		$this->load->model('avethemes/global');
			/*Check Database*/ 	
			$this->model_avethemes_global->checkContentCategory();
			$this->model_avethemes_global->checkContentArticle();
			$this->model_avethemes_global->checkDownload();
			$this->model_avethemes_global->checkPoll();
			$this->model_avethemes_global->checkSubscribe();
			$this->model_avethemes_global->checkThemeSkin();
			$this->model_avethemes_global->checkServiceGroup();
			//$this->model_avethemes_global->checkSmushItDb();
			
		
		if ($this->config->has('ave_cms_installed')==false) {
			$config_store_id = $this->config->get('config_store_id');
			/*Add Content Category Layout*/ 			
			$content_category_layout = $this->db->query("SELECT COUNT(*) AS total FROM ". DB_PREFIX. "layout_route WHERE route = 'content/category'");		
			if ($content_category_layout->row['total']==0) {	
				$this->db->query("INSERT INTO ". DB_PREFIX. "layout SET name = 'Content Category'");		
				$layout_id = $this->db->getLastId();
				$this->db->query("INSERT INTO ". DB_PREFIX. "layout_route SET layout_id = '" . (int)$layout_id . "', store_id = '" . (int)$config_store_id. "', route = 'content/category'");	
			}
			/*Add Content Article Layout*/ 			
			$content_category_layout = $this->db->query("SELECT COUNT(*) AS total FROM ". DB_PREFIX. "layout_route WHERE route = 'content/article'");		
			if ($content_category_layout->row['total']==0) {	
				$this->db->query("INSERT INTO ". DB_PREFIX. "layout SET name = 'Content Article'");		
				$layout_id = $this->db->getLastId();
				$this->db->query("INSERT INTO ". DB_PREFIX. "layout_route SET layout_id = '" . (int)$layout_id . "', store_id = '" . (int)$config_store_id . "', route = 'content/article'");	
			}
			
			/*Remove Old Config*/
			$this->db->query("DELETE FROM `". DB_PREFIX. "setting` WHERE `code` = 'ave_cms'");
			
			/*Add Config*/
			$ave_default_settings=$this->getContentConfig();
			foreach ($ave_default_settings as $key=>$value) {
				$this->db->query("INSERT INTO `". DB_PREFIX. "setting` SET `code` = 'ave_cms', `key` = '". $key. "', value = '". $value. "'");		
			}
			
			/*DELETE - CHECK MODULE*/  
			foreach ($this->getModules() as $module) {
				$this->checkModule('module', $module);		
			}
			
		}	
	}
	public function getContentConfig(){	
				$blog_config=array(			
							'ave_cms_installed'			 => '1',
							'ave_cms_backend_shortcut'			 => '1',
							'ave_cms_sitemap_status'			 => '1',
							'ave_cms_addthis'			 => '0',
							'ave_cms_disqus_comment'			 => '0',
							'ave_cms_fb_comment'			 => '0',
							'ave_cms_gplus_comment'			 => '0',
							'ave_cms_testimonial_login'			 => '0',
							'ave_cms_content_limit'	 	=> '6',
							
							'ave_cms_category_width'	 => '320',
							'ave_cms_category_height'	 => '200',
							'ave_cms_related_product_display'	 => 'product-carousel-grid',
							
							'ave_cms_blog_list_image_width'		 => '320',
							'ave_cms_blog_list_image_height'	 => '200',
							'ave_cms_article_popup_width'	 => '800',
							'ave_cms_article_popup_height'	 => '500',
							
							'ave_cms_blog_related_display'	 => 'post-carousel-grid',
							'ave_cms_blog_carousel_limit'	 => '3',
							'ave_cms_blog_grid_limit'	 => '4',
							
							'ave_cms_project_list_image_width'		 => '320',
							'ave_cms_project_list_image_height'	 => '320',
							'ave_cms_project_popup_width'	 => '600',
							'ave_cms_project_popup_height'	 => '600',
							
							'ave_cms_project_related_display'	 => 'project-carousel',
							'ave_cms_project_carousel_limit'	 => '3',
							'ave_cms_project_grid_limit'	 => '4',
							
							'ave_cms_gallery_list_image_width'		 => '320',
							'ave_cms_gallery_list_image_height'	 => '200',
							'ave_cms_gallery_popup_width'		 => '800',
							'ave_cms_gallery_popup_height'	 => '500',
							
							'ave_cms_gallery_related_display'	 => 'gallery-carousel',
							'ave_cms_gallery_carousel_limit'	 => '3',
							'ave_cms_gallery_grid_limit'	 => '4',
							
							'ave_cms_blog_details_image_width'	 	=> '800',
							'ave_cms_blog_details_image_height'	 => '500',
							
							'ave_cms_project_details_image_width'	 => '320',
							'ave_cms_project_details_image_height'	 => '320',
							
							'ave_cms_post_grid_limit'		 => '12',
							'ave_cms_post_grid_limit'		 => '3',
							'ave_cms_gallery_grid_limit'		 => '3',
							'ave_cms_project_grid_limit'		 => '3',
							
							'ave_cms_gallery_details_image_limit'	 	=> '4',
							'ave_cms_gallery_details_image_width'	 	=> '320',
							'ave_cms_gallery_details_image_height'	 => '200',
							
							
							'ave_cms_related_description_limit'		 => '128',
							'ave_cms_content_description_limit'		 => '64',
							'ave_cms_list_class'		 =>'',
							'ave_cms_sort'			 => 'p.date_added',
							'ave_cms_order'			 => 'DESC',
							
							
							'ave_cms_product_grid_limit'		 => '4',
							'ave_cms_product_carousel_limit'		 => '3',
							
							'ave_cms_login_to_download'		 => '0',
							'ave_cms_upload_allowed'			 => 'jpg,png,txt,zip,rar,xls,xlsx,doc,docx',
							'ave_cms_date_format'		 => 'Y/m/d',
							
							'ave_cms_comment_email'			 => '1',
							'ave_cms_comment_email_notifications'=> $this->config->get('config_email'),
							'ave_cms_comment_status'			 => '1',
							'ave_cms_comment_approved'		 => '1'
				);		
		return $blog_config;	
	}
	/*Check Install Blog Module*/ 
	public function checkModule($route, $code) {
			$this->load->model('user/user_group');			
		if (!$this->user->hasPermission('modify', $route. '/'. $code)) {
			$this->model_user_user_group->addPermission($this->user->getId(), 'access', $route. '/'. $code);
			$this->model_user_user_group->addPermission($this->user->getId(), 'modify', $route. '/'. $code);
		}
		/*Module Install*/
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM ". DB_PREFIX. "extension WHERE code = '" . $this->db->escape($code). "'");		
		if ($query->row['total']==0) {		
			$this->load->model('extension/extension');	
			$this->model_extension_extension->install('module',$code);
		}		
	}	
	
	public function hideSampleNews() {		
		$this->db->query("DELETE FROM `". DB_PREFIX. "setting` WHERE `key` = 'ave_confirm_installed'");
		$this->db->query("INSERT INTO `". DB_PREFIX. "setting` SET `key` = 'ave_confirm_installed', value = '1'");		
	}
	
	public function uninstall() {
			$this->delete_module_setting();
			$this->uninstall_module();
			$this->delete_cache();
	}
	public function drop_db() {			
			$this->delete_seo_keyword();	
			foreach ($this->getContentTables() as $table) {
				$this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX. $table. "` CASCADE;");
			}
			$this->delete_content_setting();
			$this->delete_module_setting();
			$this->uninstall_module();
			$this->delete_cache();
	}
	public function empty_db() {	
			$this->delete_seo_keyword();		
			foreach ($this->getContentTables() as $table) {
				$this->db->query("TRUNCATE `". DB_PREFIX. $table. "`;");
			}
			$this->delete_cache();
			
	}
	public function optimize() {	
		$tables = array();		
		$query = $this->db->query("SHOW TABLES FROM `" . DB_DATABASE . "`");		
		foreach ($query->rows as $result) {
			if (utf8_substr($result['Tables_in_' . DB_DATABASE], 0, strlen(DB_PREFIX)) == DB_PREFIX) {
				if (isset($result['Tables_in_' . DB_DATABASE])) {
					$tables[] = $result['Tables_in_' . DB_DATABASE];
				}
			}
		}	
		foreach($tables as $table){
			if(DB_PREFIX){
				if(strpos($table, DB_PREFIX) === false){
					$status = false;
				}else{
					$status = true;
				}
			}else{
				$status = true;
			}
			if($status){
		$query=$this->db->query("OPTIMIZE TABLE `". $table . "`");
			}
		}
	}
	
	public function install_module() {	
			/*CHECK MODULE*/  
			foreach ($this->getModules() as $module) {
				$this->db->query("DELETE FROM `". DB_PREFIX. "setting` WHERE `code` = '". $module. "'");
				$this->checkModule('module', $module);		
			}
	}	
	public function uninstall_module() {	
			/*UNINSTALL MODULE*/  
			foreach ($this->getModules() as $module) {
				$this->db->query("DELETE FROM `". DB_PREFIX. "extension` WHERE `code` = '". $module. "'");						
			}							
	}
	public function delete_module_setting() {	
			/*DELETE MODULE*/  
			foreach ($this->getModules() as $module) {
				$this->db->query("DELETE FROM `". DB_PREFIX. "setting` WHERE `code` = '". $module. "'");					
			}			
	}
	public function delete_content_setting() {		
			$this->db->query("DELETE FROM `". DB_PREFIX. "setting` WHERE `code` = 'ave_cms'");
	}
	public function delete_seo_keyword() {
		$groups_id = array(
		'content_id', 
		'article_id', 
		'author_id', 
		);
		foreach ($groups_id as $group_id) {	
			$queries[] = "DELETE FROM ". DB_PREFIX. "url_alias WHERE `query` LIKE '". $group_id. "=%'";
		}
	}
	public function delete_cache() {	
	/*cache*/ 			
		$this->cache->delete('content_category');
		$this->cache->delete('article');
		$this->cache->delete('poll');
	}
	public function installSampleNews() {	
	
		$this->db->query("DELETE FROM `". DB_PREFIX . "setting` WHERE `key` = 'ave_confirm_installed'");
			$this->empty_db();
		$queries =array();			
				
		/*SINGLE*/ 
$queries[]="INSERT INTO `".DB_PREFIX."ave_article` (`article_id`, `article_service`, `article_download`, `related_article_display`, `grid_limit`, `carousel_limit`, `related_product_display`, `image`, `author_id`, `poll_id`, `icon`, `color`, `item_display`, `sort_order`, `status`) 
VALUES
(1, '', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog1.jpg', 1, 1, '', 'cyan', 'blog', 1, 1), 
(2, '', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog2.jpg', 2, 1, '', 'turquoise', 'blog', 2, 1), 
(3, '', '', 'post-list', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog3.jpg', 3, 1, '', 'violetred', 'blog', 3, 1), 
(4, '', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog4.jpg', 3, 1, '', 'blue', 'blog', 4, 1), 
(5, '', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog5.jpg', 4, 1, '', 'blue-sky', 'blog', 5, 1), 
(6, '', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog6.jpg', 5, 1, 'fa fa-bell', 'blue-steel', 'blog', 6, 1), 
(7, '', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog1.jpg', 6, 1, '', 'blue-madison', 'blog', 7, 1), 
(8, '', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog2.jpg', 7, 1, '', 'blue-chambray', 'blog', 8, 1), 
(9, '', '', 'post-list', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog3.jpg', 8, 1, '', 'blue-ebonyclay', 'blog', 9, 1), 
(10, '', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog4.jpg', 1, 1, '', 'green', 'blog', 10, 1), 
(11, '', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog5.jpg', 2, 1, '', 'green-meadow', 'blog', 11, 1), 
(12, '', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog6.jpg', 3, 1, 'fa fa-bell', 'green-seagreen', 'blog', 12, 1), 

(13, '6, 3, 5, 2, 1, 7, 4, 8', '1, 3', 'project-carousel', 6, 3, 'item-list', 'catalog/avethemes/portfolio/porto1.jpg', 1, 1, '','green-haze', 'project', 13, 1), 
(14, '8', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/portfolio/porto2.jpg', 2, 1, '', 'green-haze', 'project', 14, 1), 
(15, '3, 1', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/portfolio/porto3.jpg', 3, 1, '', 'green-jungle', 'project', 15, 1), 
(16, '1, 4, 2', '3, 1', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/portfolio/porto4.jpg', 4, 1, '', 'aqua', 'project', 16, 1), 
(17, '2, 7, 4', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/portfolio/porto5.jpg', 5, 1, '', 'red', 'project', 17, 1), 
(18, '2, 1, 4', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/portfolio/porto6.jpg', 6, 1, '', 'crimson', 'project', 18, 1), 
(19, '11', '1', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/portfolio/porto7.jpg', 7, 1, '', 'red-pink', 'project', 19, 1), 
(20, '1, 7, 4, 8', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/portfolio/porto8.jpg', 8, 1, '', 'red-sunglo', 'project', 20, 1), 
(21, '5, 1, 4, 3', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/portfolio/porto9.jpg', 1, 1, '', 'red-intense', 'project', 21, 1), 
(22, '5, 7, 4, 3', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/portfolio/porto10.jpg', 2, 1, '', 'red-thunderbird', 'project', 22, 1), 
(23, '5, 6, 7, 4', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/portfolio/porto1.jpg', 3, 1, '', 'red-flamingo', 'project', 23, 1), 
(24, '3, 5, 2, 1', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/portfolio/porto2.jpg', 4, 1, '', 'yellow', 'project', 24, 1), 

(25, '10, 9', '3', 'project-grid', 4, 3, 'carousel-grid', 'catalog/avethemes/blog/blog1.jpg', 1, 0, '', 'yellow-gold', 'gallery', 3, 1), 
(26, '12, 11, 10', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog2.jpg', 1, 1, '', 'yellow-casablanca', 'gallery', 2, 1), 
(27, '9', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog3.jpg', 2, 1, '', 'yellow-crusta', 'gallery', 5, 1), 
(28, '12', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog4.jpg', 3, 1, '', 'yellow-lemon', 'gallery', 4, 1), 
(29, '12, 11', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog5.jpg', 4, 1, '', 'yellow-saffron', 'gallery', 4, 1), 
(30, '9, 11, 1', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog6.jpg', 5, 1, '', 'purple', 'gallery', 4, 1), 
(31, '1', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog1.jpg', 6, 1, '', 'purple-plum', 'gallery', 4, 1), 
(32, '9', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog2.jpg', 7, 1, '', 'purple-medium', 'gallery', 4, 1), 
(33, '10, 1', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog3.jpg', 8, 1, '', 'purple-studio', 'gallery', 4, 1), 
(34, '11, 5, 2', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog4.jpg', 1, 1, '', 'purple-wisteria', 'gallery', 4, 1), 
(35, '10, 9', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog5.jpg', 2, 1, '', 'purple-seance', 'gallery', 4, 1), 
(36, '10', '', 'post-carousel-grid', 4, 3, 'item-grid', 'catalog/avethemes/blog/blog6.jpg', 3, 1, '', 'grey-dark', 'gallery', 4, 1);";

$queries[]="INSERT INTO `".DB_PREFIX."ave_article_to_category` (`article_id`, `content_id`) VALUES
(1, 1),(2, 1),(3, 1),(4, 1),(5, 1),(6, 1),(7, 1),(8, 1),(9, 1),(10, 1),(11, 1),(12, 1),(1, 7),(2, 7),(3, 7),(4, 7),(5, 7),(6, 7),(7, 7),(8, 7),(9, 7),(10, 7),(11, 7),(12, 7),(13, 2),(13, 8),(14, 2),(14, 8),(15, 2),(15, 8),(15, 12),(15, 14),(16, 2),(16, 8),(16, 14),(17, 2),(17, 8),(17, 10),(17, 12),(17, 13),(17, 14),(18, 2),(18, 8),(18, 10),(18, 12),(18, 13),(18, 14),(19, 2),(19, 10),(20, 2),(20, 8),(20, 10),(21, 2),(21, 8),(21, 10),(21, 13),(22, 2),(22, 8),(23, 2),(23, 8),(23, 10),(24, 2),(24, 8),(24, 10),(25, 3),(26, 3),(27, 3),(28, 3),(29, 3),(30, 3),(31, 3),(32, 3),(33, 3),(34, 3),(35, 3),(36, 3);";


$queries[]="INSERT INTO `".DB_PREFIX."ave_article_to_store` (`article_id`, `store_id`) VALUES
(1, 0),(2, 0),(3, 0),(4, 0),(5, 0),(6, 0),(7, 0),(8, 0),(9, 0),(10, 0),(11, 0),(12, 0),(13, 0),(14, 0),(15, 0),(16, 0),(17, 0),(18, 0),(19, 0),(20, 0),(21, 0),(22, 0),(23, 0),(24, 0),(25, 0),(26, 0),(27, 0),(28, 0),(29, 0),(30, 0),(31, 0),(32, 0),(33, 0),(34, 0),(35, 0),(36, 0);";



$queries[]="INSERT INTO `".DB_PREFIX."ave_category` (`content_id`, `type`, `display`, `item_display`, `content_size`, `link`, `image`, `icon`, `color`, `parent_id`, `top`, `column`, `sort_order`, `grid_limit`, `status`, `nav_thumb`) VALUES
(1, 'category', 'mega', 'blog', 'col-3', '', 'catalog/avethemes/blog/blog1.jpg', 'fa fa-pencil', 'cyan', 0, 1, 1, 1, 4, 1, 1), 
(2, 'category', 'mega', 'project', 'col-3', '', 'catalog/avethemes/blog/blog2.jpg', 'fa fa-rocket', 'turquoise', 1, 1, 2, 2, 4, 1, 1), 
(3, 'category', 'mega', 'gallery', 'col-3', '', 'catalog/avethemes/blog/blog3.jpg', 'fa fa-image', 'blue-hoki', 1, 0, 4, 1, 4, 1, 1), 
(4, 'content', 'multi_level', 'blog', 'col-4', '', '', '', 'red-pink', 0, 1, 1, 4, 4, 1, 1), 
(5, 'link', 'multi_level', 'blog', 'col-3', 'index.php?route=account/account', 'catalog/avethemes/photos/img11.jpg', '', 'green-jungle', 0, 1, 1, 5, 4, 1, 1), 
(6, 'link', 'multi_level', 'blog', 'col-3', 'index.php?route=account/forgotten', '', '', 'aqua', 5, 0, 1, 999, 4, 1, 1), 
(7, 'link', 'multi_level', 'blog', 'col-3', 'index.php?route=account/login', '', '', 'red', 5, 0, 1, 999, 4, 1, 1), 
(8, 'link', 'multi_level', 'blog', 'col-3', 'index.php?route=account/register', '', '', 'crimson', 5, 0, 1, 999, 4, 1, 1), 
(9, 'faq', 'multi_level', 'project', 'col-3', '', 'catalog/avethemes/blog/blog5.jpg', 'fa fa-desktop', 'red-intense', 1, 1, 0, 999, 4, 1, 1);";
	
$queries[]="INSERT INTO `".DB_PREFIX."ave_category_to_store` (`content_id`, `store_id`) VALUES
(1, 0),(2, 0),(3, 0),(4, 0),(5, 0),(6, 0),(7, 0),(8, 0),(9, 0);";


$queries[]="INSERT INTO `".DB_PREFIX."ave_author` (`author_id`, `author`,`competence`, `image`, `sort_order`) VALUES
(1, 'Taylor Brown', 'Chief Executive Officer', 'catalog/avethemes/team/team1.jpg',1), 
(2, 'John Boris', 'Graphic Designer', 'catalog/avethemes/team/team2.jpg',2), 
(3, 'Nix Maxwell', 'Porject Manager', 'catalog/avethemes/team/team3.jpg',3), 
(4, 'Jack Smith', 'Games Developer', 'catalog/avethemes/team/team4.jpg',4), 
(5, 'John Doe', 'UX Designer', 'catalog/avethemes/team/team5.jpg',5), 
(6, 'John Smith', 'CCO & Product Manager', 'catalog/avethemes/team/team6.jpg',6), 
(7, 'Walther White', 'Photogropher', 'catalog/avethemes/team/team7.jpg',7), 
(8, 'Josh Clark', 'Programmer & SEO', 'catalog/avethemes/team/team8.jpg',8);";

$queries[]='UPDATE `'.DB_PREFIX.'ave_author` SET `socials` = \'[{"social":"fa fa-facebook","title":"Facebook","href":"https:\\/\\/www.facebook.com","target":"_blank"},{"social":"fa fa-google-plus","title":"Google Plus","href":"https:\\/\\/plus.google.com","target":"_blank"},{"social":"fa fa-instagram","title":"Instagram","href":"http:\\/\\/instagram.com","target":"_blank"},{"social":"fa fa-dropbox","title":"Dropbox","href":"http:\\/\\/www.dropbox.com","target":"_blank"},{"social":"fa fa-pinterest","title":"Pinterest","href":"http:\\/\\/www.pinterest.com","target":"_blank"},{"social":"fa fa-youtube","title":"Youtube","href":"http:\\/\\/www.youtube.com","target":"_blank"}]\',`author_description` = \'&lt;p&gt;At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat.&lt;/p&gt;\r\n\r\n&lt;blockquote&gt;Pellentesque ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante Integer posuere erat a ante.\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;small&gt;Someone famous&amp;nbsp;&lt;cite style=&quot;box-sizing: border-box; font-style: normal;&quot; title=&quot;Source Title&quot;&gt;Source Title&lt;/cite&gt;&lt;/small&gt;&lt;/blockquote&gt;\r\n\';';





$queries[]="INSERT INTO `".DB_PREFIX."ave_comment` (`comment_id`, `article_id`, `customer_id`, `author`, `text`, `rating`, `status`) VALUES
(1, 1, 0, 'Alex Zert', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum bibendum libero et lectus faucibus vehicula. ', 5, 1), 
(2, 1, 0, 'Alexander Skarsgard', 'Quisque fringilla, lectus in pulvinar euismod, tortor lectus fringilla lacus, at sollicitudin mi felis nec quam. ', 5, 0);";
	
$queries[]="INSERT INTO `".DB_PREFIX."ave_download` (`download_id`, `filename`, `mask`, `color`, `auth_key`) VALUES
(1, '01.xls_f6b46ba6cc4659e13bfc77314938d51d', '01.xls', 'green-meadow', '6f308c10bdbd81dae391d0ce90f949f7'), 
(2, '01.xls_f6b46ba6cc4659e13bfc77314938d51d', '01.xls', 'purple-plum', '6f308c10bdbd81dae391d0ce90f949f8'), 
(3, '01.xls_f6b46ba6cc4659e13bfc77314938d51d', '01.xls', 'crimson', '6f308c10bdbd81dae391d0ce90f949f9');";

$queries[]="INSERT INTO `".DB_PREFIX."ave_poll` (`poll_id`, `color`) VALUES
(1, 'red-sunglo');";

$queries[]="INSERT INTO `".DB_PREFIX."ave_poll_description` (`poll_id`, `language_id`, `question`, `answer_1`, `answer_2`, `answer_3`, `answer_4`, `answer_5`, `answer_6`, `answer_7`, `answer_8`, `answer_9`, `answer_10`, `answer_11`, `answer_12`, `answer_13`, `answer_14`, `answer_15`) VALUES
(1, 6, 'How do you find us?', 'Themeforest. net', 'Google.com', 'My friends referral', '', '', '', '', '', '', '', '', '', '', '', ''), 
(1, 1, 'How do you find us?', 'Themeforest. net', 'Google.com', 'My friends referral', '', '', '', '', '', '', '', '', '', '', '', '');";

$queries[]="INSERT INTO `".DB_PREFIX."ave_poll_reactions` (`poll_reaction_id`, `poll_id`, `answer`) VALUES
(1, 1, 3), 
(2, 1, 1), 
(3, 1, 3), 
(4, 1, 3), 
(5, 1, 1);";

$queries[]="INSERT INTO `".DB_PREFIX."ave_poll_to_store` (`poll_id`, `store_id`) VALUES (1, 0),(1, 1);";

$queries[]="INSERT INTO `".DB_PREFIX."ave_related_article` (`article_id`, `article_related_id`) VALUES
(1, 2),(1, 3),(1, 4),(1, 5),(1, 6),(1, 7),(1, 8),(1, 9),(1, 10),(1, 11),(1, 12),
(2, 1),(2, 3),(2, 4),(2, 5),(2, 6),(2, 7),(2, 8),(2, 9),(2, 10),(2, 11),(2, 12),
(3, 1),(3, 2),(3, 4),(3, 5),(3, 6),(3, 7),(3, 8),(3, 9),(3, 10),(3, 11),(3, 12),
(4, 1),(4, 2),(4, 3),(4, 5),(4, 6),(4, 7),(4, 8),(4, 9),(4, 10),(4, 11),(4, 12),
(5, 1),(5, 2),(5, 3),(5, 4),(5, 6),(5, 7),(5, 8),(5, 9),(5, 10),(5, 11),(5, 12),
(6, 1),(6, 2),(6, 3),(6, 4),(6, 5),(6, 7),(6, 8),(6, 9),(6, 10),(6, 11),(6, 12),
(7, 1),(7, 2),(7, 4),(7, 5),(7, 6),(7, 7),(7, 8),(7, 9),(7, 10),(7, 11),(7, 12),
(8, 1),(8, 2),(8, 3),(8, 4),(8, 5),(8, 6),(8, 7),(8, 9),(8, 10),(8, 11),(8, 12),
(9, 1),(9, 2),(9, 3),(9, 4),(9, 5),(9, 6),(9, 7),(9, 8),(9, 10),(9, 11),(9, 12),
(10, 1),(10, 2),(10, 3),(10, 4),(10, 5),(10, 6),(10, 7),(10, 8),(10, 9),(10, 11),(10, 12),
(11, 1),(11, 2),(11, 3),(11, 4),(11, 5),(11, 6),(11, 7),(11, 8),(11, 9),(11, 10),(11, 12),
(12, 1),(12, 2),(12, 3),(12, 4),(12, 5),(12, 6),(12, 7),(12, 8),(12, 9),(12, 10),(12, 11),
(13, 14),(13, 15),(13, 16),(13, 17),(13, 18),(13, 19),(13, 20),(13, 21),(13, 22),(13, 23),(13, 24),
(14, 13),(14, 15),(14, 16),(14, 17),(14, 18),(14, 19),(14, 20),(14, 21),(14, 22),(14, 23),(14, 24),
(15, 13),(15, 14),(15, 16),(15, 17),(15, 18),(15, 19),(15, 20),(15, 21),(15, 22),(15, 23),(15, 24),
(16, 13),(16, 14),(16, 15),(16, 17),(16, 18),(16, 19),(16, 20),(16, 21),(16, 22),(16, 23),(16, 24),
(17, 13),(17, 14),(17, 15),(17, 16),(17, 18),(17, 19),(17, 20),(17, 21),(17, 22),(17, 23),(17, 24),
(18, 13),(18, 14),(18, 15),(18, 16),(18, 17),(18, 19),(18, 20),(18, 21),(18, 22),(18, 23),(18, 24),
(19, 13),(19, 14),(19, 15),(19, 16),(19, 17),(19, 18),(19, 20),(19, 21),(19, 22),(19, 23),(19, 24),
(20, 13),(20, 14),(20, 15),(20, 16),(20, 17),(20, 18),(20, 19),(20, 21),(20, 22),(20, 23),(20, 24),
(21, 13),(21, 14),(21, 15),(21, 16),(21, 17),(21, 18),(21, 19),(21, 20),(21, 22),(21, 23),(21, 24),
(22, 13),(22, 14),(22, 15),(22, 16),(22, 17),(22, 18),(22, 19),(22, 20),(22, 21),(22, 23),(22, 24),
(23, 13),(23, 14),(23, 15),(23, 16),(23, 17),(23, 18),(23, 19),(23, 20),(23, 21),(23, 22),(23, 24),
(24, 13),(24, 14),(24, 15),(24, 16),(24, 17),(24, 18),(24, 19),(24, 20),(24, 21),(24, 22),(24, 23),
(25, 26),(25, 27),(25, 28),(25, 29),(25, 30),(25, 31),(25, 32),(25, 33),(25, 34),(25, 35),(25, 36),
(26, 25),(26, 27),(26, 28),(26, 29),(26, 30),(26, 31),(26, 32),(26, 33),(26, 34),(26, 35),(26, 36),
(27, 25),(27, 26),(27, 28),(27, 29),(27, 30),(27, 31),(27, 32),(27, 33),(27, 34),(27, 35),(27, 36),
(28, 25),(28, 26),(28, 27),(28, 29),(28, 30),(28, 31),(28, 32),(28, 33),(28, 34),(28, 35),(28, 36),
(29, 25),(29, 26),(29, 27),(29, 28),(29, 30),(29, 31),(29, 32),(29, 33),(29, 34),(29, 35),(29, 36),
(30, 25),(30, 26),(30, 27),(30, 28),(30, 29),(30, 31),(30, 32),(30, 33),(30, 34),(30, 35),(30, 36),
(31, 25),(31, 26),(31, 27),(31, 28),(31, 29),(31, 30),(31, 32),(31, 33),(31, 34),(31, 35),(31, 36),
(32, 25),(32, 26),(32, 27),(32, 28),(32, 29),(32, 30),(32, 31),(32, 33),(32, 34),(32, 35),(32, 36),
(33, 25),(33, 26),(33, 27),(33, 28),(33, 29),(33, 30),(33, 31),(33, 32),(33, 34),(33, 35),(33, 36),
(34, 25),(34, 26),(34, 27),(34, 28),(34, 29),(34, 30),(34, 31),(34, 32),(34, 33),(34, 35),(34, 36),
(35, 25),(35, 26),(35, 27),(35, 28),(35, 29),(35, 30),(35, 31),(35, 32),(35, 33),(35, 34),(35, 36),
(36, 25),(36, 26),(36, 27),(36, 28),(36, 29),(36, 30),(36, 31),(36, 32),(36, 33),(36, 34),(36, 35);";

$queries[]="INSERT INTO `".DB_PREFIX."ave_service` (`service_id`, `icon`, `color`, `section`, `parent_id`, `link_id`, `sort_order`, `status`) VALUES
(1, 'fa fa-mobile', 'blue-sky', 'mobile-web-design', 0, 2, 999, 1), 
(2, 'fa fa-html5', 'turquoise', 'html5-web-development', 0, 2, 999, 1), 
(3, 'fa fa-search', 'blue-madison', 'web-analytics', 0, 2, 999, 1), 
(4, 'fa fa-trophy', 'blue-sky', 'search-engine-optimization', 0, 2, 999, 1), 
(5, 'fa fa-edit', 'crimson', 'content-management-systems', 0, 2, 999, 1), 
(6, 'fa fa-random', 'blue-sky', 'multimedia', 0, 2, 999, 1), 
(7, 'fa fa-shopping-cart', 'blue-steel', 'online-marketing', 0, 2, 999, 1), 
(8, 'fa fa-cloud', 'blue-sky', 'web-hosting', 0, 2, 999, 1), 
(9, 'fa fa-camera-retro', 'turquoise', 'graphic', 0, 2, 999, 1), 
(10, 'fa fa-desktop', 'blue-sky', 'design', 0, 2, 999, 1), 
(11, 'fa fa-suitcase', 'blue-sky', 'brochure', 0, 2, 999, 1), 
(12, 'fa fa-rocket', 'blue-sky', 'creative', 0, 2, 999, 1);";



$queries[]="INSERT INTO `".DB_PREFIX."ave_service_quote` (`quote_id`, `customer_id`, `customer_name`, `customer_telephone`, `customer_email`, `customer_company`, `competence`, `avatar`, `service_selection`, `budget`, `message`, `reply_message`, `status`, `read`) VALUES
(1, 0, 'John Doe', '441234567890', 'demo@demo.com', 'eShop+', 'CEO ', '', '5, 1, 4, 3, 8', '300', 'Reprehenderit butcher stache cliche tempor, williamsburg carles vegan helvetica. retro keffiyeh dreamcatcher synth. ', '', 0, 1), 
(2, 0, 'Lis Christensen', '441234567890', 'demo@demo.com', 'eShop+', 'Chief Executive Officer', '', '5, 6, 7, 4, 3', '1000', 'Cras vulputate gravida pellentesque. Mauris ultricies metus id sapien porta vulputate. Cras feugiat nunc id mi condimentum mattis. Duis placerat auctor enim, sed luctus diam tempor posuere. ', '', 0, 1), 
(3, 0, 'Tommy Christensen', '441234567890', 'demo@demo.com', 'eShop+', 'CEO ', '', '5, 2, 6, 1, 7, 4', '200', 'Services you have interest', '', 0, 0);";


$queries[]="INSERT INTO `".DB_PREFIX."ave_service_to_store` (`service_id`, `store_id`) VALUES
(1, 0), 
(2, 0), 
(3, 0), 
(4, 0), 
(5, 0), 
(6, 0), 
(7, 0), 
(8, 0), 
(9, 0), 
(10, 0), 
(11, 0), 
(12, 0);";

$queries[]="INSERT INTO `".DB_PREFIX."ave_testimonial` (`testimonial_id`, `customer_id`, `customer_name`, `customer_telephone`, `customer_email`, `customer_company`, `service_selection`, `competence`, `avatar`, `message`, `rating`, `status`, `read`) VALUES
(1, 0, 'Lis Veniam', '441234567890', 'demo@demo.com', 'eShop+', '7, 4, 3, 1, 8, 5, 6', '', 'catalog/avethemes/author/avatar.jpg', 'Lorem ipsum dolor sit amet, dolore eiusmod quis tempor incididunt ut et dolore Ut veniam unde voluptatem. Sed unde omnis iste natus error sit voluptatem. ', 5, 1, 1), 

(2, 0, 'Magna Aliqua', '441234567890', 'demo@demo.com', 'eShop+', '8', '', 'catalog/avethemes/author/avatar.jpg','Denim you probably haven''t heard of. Lorem ipsum dolor met consectetur adipisicing sit amet, consectetur adipisicing elit, of them jean shorts sed magna aliqua. Lorem ipsum dolor met consectetur adipisicing sit amet do eiusmod dolore. ', 5, 1, 1), 

(3, 0, 'Teo pham', '441234567890', 'demo@demo.com', 'eShop+', '8', 'CEO ', 'catalog/avethemes/author/avatar.jpg', 'Lorem ipsum dolor sit amet, dolore eiusmod quis tempor incididunt ut et dolore Ut veniam unde nostrudlaboris. Sed unde omnis iste natus error sit voluptatem. ', 4, 1, 1), 

(4, 0, 'Quis Tempor', '441234567890', 'demo@demo.com', 'eShop+', '5, 6, 4, 3, 7', 'Team Leader', 'catalog/avethemes/author/avatar.jpg', 'Molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa quis tempor incididunt ut et dolore et dolorum fuga. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus.', 5, 1, 1), 

(5, 0, 'Linda', '441234567890', 'demo@demo.com', 'eShop+', '1, 2, 4, 8', 'Team Leader', 'catalog/avethemes/author/avatar.jpg', 'Denim you probably haven''t heard of. Lorem ipsum dolor met consectetur adipisicing sit amet, consectetur adipisicing elit, of them jean shorts sed magna aliqua. Lorem ipsum dolor met consectetur adipisicing sit amet do eiusmod dolore. ', 5, 1, 1), 

(6, 0, 'Lorem Ipsum', '441234567890', 'demo@demo.com', 'eShop+', '1, 2, 5, 6, 7', 'Team Leader', 'catalog/avethemes/author/avatar.jpg', 'YOUR ENQUIRY\r\nMessage must be between 15 and 1500 characters!', 5, 0, 1), 

(7, 0, 'Molestias', '441234567890', 'root@localhost.com', 'John Doe', '5, 2, 6, 1', 'Team Leader', 'catalog/avethemes/author/avatar.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna psum olor . ', 0, 0, 0), 

(8, 0, 'John Doe', '441234567890', 'root@localhost.com', 'John Doe', '5, 2, 1, 7, 6', 'Team Leader', 'catalog/avethemes/author/avatar.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna psum olor . ', 4, 0, 0);";


$queries[]="INSERT INTO `".DB_PREFIX."ave_testimonial_service` (`testimonial_id`, `service_id`) VALUES
(2, 8),(3, 8),(4, 3),(4, 4),(4, 5),(4, 6),(4, 7),(5, 1),(5, 2),(5, 4),(5, 8),(6, 1),(6, 2),(6, 5),(6, 6),(6, 7),(7, 1),(7, 2),(7, 5),(7, 6),(8, 1),(8, 2),(8, 5),(8, 6),(8, 7);";


		
	$queries[]="UPDATE `".DB_PREFIX."ave_article` SET date_added = NOW(),date_modified = NOW()";
	$queries[]="UPDATE `".DB_PREFIX."ave_category` SET date_added = NOW(),date_modified = NOW()";
	$queries[]="UPDATE `".DB_PREFIX."ave_comment` SET date_added = NOW(),date_modified = NOW()";
	$queries[]="UPDATE `".DB_PREFIX."ave_download` SET date_added = NOW()";
	$queries[]="UPDATE `".DB_PREFIX."ave_poll` SET date_added = NOW()";
	$queries[]="UPDATE `".DB_PREFIX."ave_service` SET date_added = NOW(),date_modified = NOW()";
	$queries[]="UPDATE `".DB_PREFIX."ave_testimonial` SET date_added = NOW(),date_modified = NOW()";
	$queries[]="UPDATE `".DB_PREFIX."ave_service_quote` SET date_added = NOW(),date_modified = NOW()";
	
			foreach ($queries as $query) {
				$this->db->query($query);
			}
						
			$languages = $this->db->query("SELECT * FROM " . DB_PREFIX . "language");
	   		foreach ($languages->rows as $language) {
				$language_id=$language['language_id'];
				$mlqueries[$language_id] =array();	
				
	
/*article_description*/ 			
$mlqueries[$language_id][]="INSERT INTO `".DB_PREFIX."ave_article_description` (`article_id`, `language_id`, `name`, `tag`) VALUES 
(1, ". (int)$language_id. ", 'Post 1 - Duis at malesuada ante','malesuada,ante'), 
(2, ". (int)$language_id. ", 'Post 2 - Quisque nulla', 'quisque,nulla'), 
(3, ". (int)$language_id. ", 'Post 3 - Curabitur quam ', 'curabitur,quam,ante'), 
(4, ". (int)$language_id. ", 'Post 5 - Quisque at libero','quisque,libero'), 
(5, ". (int)$language_id. ", 'Post 5 - Praesent ut augue','praesent,augue'), 
(6, ". (int)$language_id. ", 'Post 6 - Praesent et porta', 'post,Praesent et porta'), 
(7, ". (int)$language_id. ", 'Post 7 - Duis at malesuada', 'post,Duis at malesuada'), 
(8, ". (int)$language_id. ", 'Post 8 - Quisque nulla', 'post,tincidunt,nulla'), 
(9, ". (int)$language_id. ", 'Post 9 - Curabitur ante', 'post,curabitur quam ante'), 
(10, ". (int)$language_id. ", 'Post 10 - Quisque at sapien', 'post,quisque,sapien'), 
(11, ". (int)$language_id. ", 'Post 11 - Praesent ut augue', 'post,praesent,augue'), 
(12, ". (int)$language_id. ", 'Post 12 - Praesent et mauris', 'post,praesent,mauris'), 
(13, ". (int)$language_id. ", 'Project 1 - Phasellus purus', 'project,phasellus,purus'), 
(14, ". (int)$language_id. ", 'Project 2 - Cras metus', 'project,cras,turpis,metus'), 
(15, ". (int)$language_id. ", 'Project 3 - Permentum non', 'project,permentum,nec,non'), 
(16, ". (int)$language_id. ", 'Project 4 - Purus tristique', 'project,purus,tristique'), 
(17, ". (int)$language_id. ", 'Project 5 - Suspendisse cursus', 'Project,suspendisse,cursus'), 
(18, ". (int)$language_id. ", 'Project 6 - Ut ornare congue', 'Project,ornare,congue'), 
(19, ". (int)$language_id. ", 'Project 7 - Mattis dapibus', 'Project,gravida,dapibus'), 
(20, ". (int)$language_id. ", 'Project 8 - Vulputate gravida', 'Project,vulputate,gravida'), 
(21, ". (int)$language_id. ", 'Project 9 - Egestas lacinia', 'Project,egestas lacinia'), 
(22, ". (int)$language_id. ", 'Project 10 - Lectus scelerisque', 'Project,lectus,scelerisque'), 
(23, ". (int)$language_id. ", 'Project 11 - Parturient montes', 'Project,parturient,montes'), 
(24, ". (int)$language_id. ", 'Project 12 - Nullam pretium aliquet', 'Project,pretium,aliquet'), 
(25, ". (int)$language_id. ", 'Gallery 1 - Nascetur ridiculus', 'Gallery,nascetur,ridiculus'), 
(26, ". (int)$language_id. ", 'Gallery 2 - Auctor tempus quis', 'Gallery,auctor,tempus,quis'), 
(27, ". (int)$language_id. ", 'Gallery 3 - Praesent et porta', 'Gallery,praesen,porta'), 
(28, ". (int)$language_id. ", 'Gallery 4 - Fusce nisi turpis', 'Gallery,Fusce,nisi,turpis'), 
(29, ". (int)$language_id. ", 'Gallery 5 - Cum sociis natoque', 'Gallery,sociis,natoque'), 
(30, ". (int)$language_id. ", 'Gallery 6 - Fusce nisi turpis', 'Gallery,Fusce,nisi,turpis'), 
(31, ". (int)$language_id. ", 'Gallery 7 - Tristique at magna', 'Gallery,Tristique,magna'), 
(32, ". (int)$language_id. ", 'Gallery 8 - Mauris libero', 'Gallery,auris,libero'), 
(33, ". (int)$language_id. ", 'Gallery 9 - Orci a eleifend', 'gallery,orci,eleifend'), 
(34, ". (int)$language_id. ", 'Gallery 10 - Dignissim varius', 'Gallery,dignissim,varius'), 
(35, ". (int)$language_id. ", 'Gallery 11 - Mollis felis', 'gallery,mollis,felis'), 
(36, ". (int)$language_id. ", 'Gallery 12 - Curabitur ante', 'gallery,curabitur,ante');";

$mlqueries[$language_id][]="UPDATE `".DB_PREFIX."ave_article_description` SET `description`='&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris non laoreet dui. Morbi lacus massa, euismod ut turpis molestie, tristique sodales est. Integer sit amet mi id sapien tempor molestie in nec massa.&lt;/p&gt;&lt;p&gt;Fusce non ante sed lorem rutrum feugiat. Vestibulum pellentesque, purus ut dignissim consectetur, nulla erat ultrices purus, ut consequat sem elit non sem. Morbi lacus massa, euismod ut turpis molestie, tristique sodales est. Integer sit amet mi id sapien tempor molestie in nec massa. Fusce non ante sed lorem rutrum feugiat.&lt;/p&gt;&lt;blockquote&gt;&lt;i class=&quot;fa fa-quote&quot;&gt;&lt;/i&gt;&lt;span class=&quot;quote_text&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit Mauris non laoreet dui, Morbi lacus massa, euismod ut turpis molestie, tristique sodales est There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.&lt;/span&gt;&lt;/blockquote&gt;&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit Mauris non laoreet dui, Morbi lacus massa, euismod ut turpis molestie, tristique sodales est. Integer sit amet mi id sapien tempor molestie in nec massa Fusce non ante sed lorem rutrum feugiat, Vestibulum pellentesque, purus ut dignissim consectetur, nulla erat ultrices purus, ut consequat sem elit non sem. Morbi lacus massa, euismod ut turpis molestie, tristique sodales est.&lt;/p&gt;';";

/*article_image*/ 
$mlqueries[$language_id][]="INSERT INTO `".DB_PREFIX."ave_article_image` (`article_id`, `image`, `sort_order`, `language_id`, `image_title`, `image_description`) VALUES
(1, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(2, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(3, 'catalog/avethemes/blog/blog3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(4, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(5, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(6, 'catalog/avethemes/blog/blog3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(7, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(8, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(9, 'catalog/avethemes/blog/blog3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(10, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(11, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(12, 'catalog/avethemes/blog/blog3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'),
(1, 'catalog/avethemes/blog/blog4.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(2, 'catalog/avethemes/blog/blog5.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(3, 'catalog/avethemes/blog/blog6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(4, 'catalog/avethemes/blog/blog7.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(5, 'catalog/avethemes/blog/blog8.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(6, 'catalog/avethemes/blog/blog9.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(7, 'catalog/avethemes/blog/blog10.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(8, 'catalog/avethemes/blog/blog11.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(9, 'catalog/avethemes/blog/blog12.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(10, 'catalog/avethemes/blog/blog4.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(11, 'catalog/avethemes/blog/blog5.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(12, 'catalog/avethemes/blog/blog6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 

(1, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(2, 'catalog/avethemes/blog/blog3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(3, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(4, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(5, 'catalog/avethemes/blog/blog3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(6, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(7, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(8, 'catalog/avethemes/blog/blog3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(9, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(10, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(11, 'catalog/avethemes/blog/blog3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(12, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 

(13, 'catalog/avethemes/portfolio/porto1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(14, 'catalog/avethemes/portfolio/porto2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(15, 'catalog/avethemes/portfolio/porto3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(16, 'catalog/avethemes/portfolio/porto3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(17, 'catalog/avethemes/portfolio/porto5.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(18, 'catalog/avethemes/portfolio/porto6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(19, 'catalog/avethemes/portfolio/porto7.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(20, 'catalog/avethemes/portfolio/porto8.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(21, 'catalog/avethemes/portfolio/porto9.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(22, 'catalog/avethemes/portfolio/porto10.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(23, 'catalog/avethemes/portfolio/porto11.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(24, 'catalog/avethemes/portfolio/porto12.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(13, 'catalog/avethemes/portfolio/porto2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(14, 'catalog/avethemes/portfolio/porto3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(15, 'catalog/avethemes/portfolio/porto3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(16, 'catalog/avethemes/portfolio/porto5.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(17, 'catalog/avethemes/portfolio/porto6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(18, 'catalog/avethemes/portfolio/porto7.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(19, 'catalog/avethemes/portfolio/porto8.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(10, 'catalog/avethemes/portfolio/porto9.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(21, 'catalog/avethemes/portfolio/porto10.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(22, 'catalog/avethemes/portfolio/porto11.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(23, 'catalog/avethemes/portfolio/porto12.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(24, 'catalog/avethemes/portfolio/porto1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'),

(13, 'catalog/avethemes/portfolio/porto4.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(14, 'catalog/avethemes/portfolio/porto5.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(15, 'catalog/avethemes/portfolio/porto6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(16, 'catalog/avethemes/portfolio/porto1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(17, 'catalog/avethemes/portfolio/porto2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(18, 'catalog/avethemes/portfolio/porto3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(19, 'catalog/avethemes/portfolio/porto4.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(20, 'catalog/avethemes/portfolio/porto5.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(21, 'catalog/avethemes/portfolio/porto6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(22, 'catalog/avethemes/portfolio/porto4.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(23, 'catalog/avethemes/portfolio/porto5.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 

(13, 'catalog/avethemes/portfolio/porto5.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(14, 'catalog/avethemes/portfolio/porto6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(15, 'catalog/avethemes/portfolio/porto7.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(16, 'catalog/avethemes/portfolio/porto8.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(17, 'catalog/avethemes/portfolio/porto9.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(18, 'catalog/avethemes/portfolio/porto10.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(19, 'catalog/avethemes/portfolio/porto1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(20, 'catalog/avethemes/portfolio/porto2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(21, 'catalog/avethemes/portfolio/porto3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(22, 'catalog/avethemes/portfolio/porto6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(23, 'catalog/avethemes/portfolio/porto7.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 

(24, 'catalog/avethemes/portfolio/porto6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(13, 'catalog/avethemes/portfolio/porto2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(14, 'catalog/avethemes/portfolio/porto3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(15, 'catalog/avethemes/portfolio/porto3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(16, 'catalog/avethemes/portfolio/porto5.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(17, 'catalog/avethemes/portfolio/porto6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(18, 'catalog/avethemes/portfolio/porto7.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(19, 'catalog/avethemes/portfolio/porto8.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(10, 'catalog/avethemes/portfolio/porto9.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(21, 'catalog/avethemes/portfolio/porto10.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(22, 'catalog/avethemes/portfolio/porto11.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(23, 'catalog/avethemes/portfolio/porto12.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(24, 'catalog/avethemes/portfolio/porto1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 

(25, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(26, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(27, 'catalog/avethemes/blog/blog3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(28, 'catalog/avethemes/blog/blog4.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(29, 'catalog/avethemes/blog/blog5.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(30, 'catalog/avethemes/blog/blog6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(31, 'catalog/avethemes/blog/blog7.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(32, 'catalog/avethemes/blog/blog8.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(33, 'catalog/avethemes/blog/blog9.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(34, 'catalog/avethemes/blog/blog10.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(35, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(36, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(25, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(26, 'catalog/avethemes/blog/blog3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(27, 'catalog/avethemes/blog/blog4.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(28, 'catalog/avethemes/blog/blog5.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(29, 'catalog/avethemes/blog/blog6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(30, 'catalog/avethemes/blog/blog7.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(31, 'catalog/avethemes/blog/blog8.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(32, 'catalog/avethemes/blog/blog9.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(33, 'catalog/avethemes/blog/blog10.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(34, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(35, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(36, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(25, 'catalog/avethemes/blog/blog3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(26, 'catalog/avethemes/blog/blog4.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(27, 'catalog/avethemes/blog/blog5.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(28, 'catalog/avethemes/blog/blog6.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(29, 'catalog/avethemes/blog/blog7.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(30, 'catalog/avethemes/blog/blog8.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(31, 'catalog/avethemes/blog/blog9.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(32, 'catalog/avethemes/blog/blog10.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(33, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(34, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(35, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(36, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(25, 'catalog/avethemes/blog/blog7.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(26, 'catalog/avethemes/blog/blog8.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(27, 'catalog/avethemes/blog/blog9.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(28, 'catalog/avethemes/blog/blog10.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(29, 'catalog/avethemes/blog/blog1.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(30, 'catalog/avethemes/blog/blog2.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(31, 'catalog/avethemes/blog/blog3.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(32, 'catalog/avethemes/blog/blog4.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(33, 'catalog/avethemes/blog/blog7.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(34, 'catalog/avethemes/blog/blog8.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(35, 'catalog/avethemes/blog/blog9.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.'), 
(36, 'catalog/avethemes/blog/blog10.jpg', 1, ". (int)$language_id. ", 'Title - curabitur quam ante', 'Description - malesuada et dignissim ac.');";


/*category_description*/ 
$mlqueries[$language_id][]="INSERT INTO `".DB_PREFIX."ave_category_description` (`content_id`, `language_id`, `name`) VALUES
(1, ". (int)$language_id. ", 'Blog'), 
(2, ". (int)$language_id. ", 'Portfolio'), 
(3, ". (int)$language_id. ", 'Gallery'),
(4, ". (int)$language_id. ", 'HTML'), 
(5, ". (int)$language_id. ", 'Link'), 
(6, ". (int)$language_id. ", 'Forgotten Password'), 
(7, ". (int)$language_id. ", 'Register Account'), 
(8, ". (int)$language_id. ", 'Login'), 
(9, ". (int)$language_id. ", 'FAQs');";


$mlqueries[$language_id][]="UPDATE `".DB_PREFIX."ave_category_description` SET `description`='&lt;p class=&quot;main_desc&quot;&gt;Phasellus ac purus id neque faucibus gravida. Curabitur quam ante, malesuada et dignissim ac, varius at urna. Cras turpis metus, fermentum nec ornare non, lacinia a felis. Nam mollis, felis eu tempus ornare, purus tellus tristique nibh, cursus scelerisque tellus eros sit amet justo. Donec sed erat vitae justo pharetra ornare. &lt;/p&gt;';";

$mlqueries[$language_id][]="UPDATE `".DB_PREFIX."ave_category_description` SET `description`='&lt;p&gt;Phasellus ac purus id neque faucibus gravida. Curabitur quam ante, malesuada et dignissim ac, varius at urna. Cras turpis metus, fermentum nec ornare non, lacinia a felis. Nam mollis, felis eu tempus ornare, purus tellus tristique nibh, cursus scelerisque tellus eros sit amet justo. Donec sed erat vitae justo pharetra ornare. &lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;". HTTP_CATALOG. "image/catalog/avethemes/small.jpg&quot; style=&quot;float: left; margin: 0 15px 0 0;&quot; /&gt;Nullam pretium aliquet viverra. Mauris ante libero, auctor in tempus quis, tristique at magna. Praesent et porta mauris. Aliquam erat volutpat. Ut malesuada, orci a eleifend mollis, lectus ligula scelerisque sem, eget consectetur nibh lectus ullamcorper nunc. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce id nisi turpis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi vel metus vestibulum lacus gravida vestibulum. In id est tellus. Ut lectus nisl, tincidunt et feugiat eu, molestie consequat tortor. Suspendisse vitae erat cursus est vestibulum aliquet. Vestibulum in nunc nisl, quis cursus est. Pellentesque placerat neque et ante rhoncus vulputate. Quisque at libero sapien. Morbi nec elit ut elit ornare congue sit amet ut augue. Nulla suscipit, ante mattis gravida dapibus, est orci vestibulum lorem, in eleifend ante tellus ut felis. &lt;/p&gt;\r\n' WHERE `content_id` =4;";

$mlqueries[$language_id][]="UPDATE `".DB_PREFIX."ave_category_description` SET `description`='&lt;p&gt;Please click to a category below to see the related topics. &lt;/p&gt;\r\n' WHERE `content_id` =9;";
$mlqueries[$language_id][]="UPDATE `".DB_PREFIX."ave_category_description` SET `description`='' WHERE `content_id` ='10';";

/*content_faq*/ 
$mlqueries[$language_id][]="INSERT INTO `".DB_PREFIX."ave_content_faq` (`content_id`, `color`, `sort_order`, `language_id`, `question`, `answer`) VALUES
(9, 'fa fa-life-ring', 1, ". (int)$language_id. ", 'Introduction', '&lt;p&gt;We want your experience with our products and support services to be flawless, that is why we take so much time and effort to create this site where you can find useful resources that most likely will answer your questions. Please read through this FAQ section carefully, it deals with the most common questions and issues. If you did not find the answer you are looking for, you can also search for related tickets. Our ticket system is currently under development and will be launched soon. &lt;/p&gt;\r\n'), 
(9, 'fa fa-life-ring', 2, ". (int)$language_id. ", 'What is supported?', '&lt;p&gt;Product support includes:&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Responding to questions and problems regarding your purchased item and its features&lt;/li&gt;\r\n	&lt;li&gt;Fixing bugs and reported issues by releasing updates regularly&lt;/li&gt;\r\n	&lt;li&gt;Assistance with integration questions and incompatibility issues&lt;/li&gt;\r\n&lt;/ul&gt;\r\n'), 
(9, 'fa fa-life-ring', 3, ". (int)$language_id. ", 'Product support does not include', '&lt;p&gt;Product support does not include:&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Customizations beyond the capabilities of the Item or fixing issues caused by your customizations&lt;/li&gt;\r\n	&lt;li&gt;Responsibility for fixing issues caused by faulty 3rd party components&lt;/li&gt;\r\n	&lt;li&gt;Non-product-specific questions&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;We understand that most of our customers are not programmers, that is why we will also help you with issues caused by other components (plugins, themes, etc) and we will provide you instructions to help fixing your problems, even if it is not directly related to our Items. &lt;strong&gt;Although, we cannot guarantee that we will be able to help you fix every issue caused by faulty 3rd party components. &lt;/strong&gt;&lt;/p&gt;\r\n'), 
(9, 'fa fa-life-ring', 4, ". (int)$language_id. ", 'Where should I get help with issues caused by other components?', '&lt;p&gt;If we cannot help you, you should contact with the author of the incompatible plugin or theme. Helping developers by providing feedback is also useful to other users with the same problem. &lt;/p&gt;\r\n'), 
(9, 'fa fa-life-ring', 5, ". (int)$language_id. ", 'Where can I get help if I received the Item by another purchase?', '&lt;p&gt;Our ticket system requires a valid Item Purchase Code to verify your purchase, so if you received the Item by another purchase, you will not be able to open a new support ticket. However, you will still be able to read our FAQ sections and search for related tickets that most likely will help you in most of the cases. It is the job of the theme/template author to provide you support about their integrated plugins, so in a case you did not find an answer here, you have to contact with them. Providing you support is the responsibility of the author whom you purchased your item from. &lt;/p&gt;\r\n'), 
(9, 'fa fa-life-ring', 6, ". (int)$language_id. ", 'Information regarding support response times', '&lt;ul&gt;\r\n	&lt;li&gt;We live in UTC+07:00 (Ho Chi Minh City, Viet Nam) time-zone. Please keep in mind that we may have different daytime in our region compared to yours. &lt;/li&gt;\r\n	&lt;li&gt;Usually, we will respond you in 24 hours. In some cases it might take a few days, but we are trying to be as fast as we can. &lt;/li&gt;\r\n	&lt;li&gt;We are not working on weekends, but we will try to respond you when we can. &lt;/li&gt;\r\n&lt;/ul&gt;\r\n'), 
(9, 'fa fa-life-ring', 7, ". (int)$language_id. ", 'Can I get a refund?', '&lt;p&gt;Yes, you can, by requesting it from Marketplaces. Read further on to find out the conditions and the proper way to request a refund. Please, start with considering the following suggestions:&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;Try to find a solution or answer here, highly likely you will. &lt;/li&gt;\r\n	&lt;li&gt;Let us check out your problems, most of the issues are caused by other components and are usually easy to fix. &lt;/li&gt;\r\n	&lt;li&gt;&lt;span&gt;Report the issue you are having, so we can release an update that fixes it (if any). &lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;\r\n	&lt;p&gt;Please, acknowledge our support policies, we cannot take responsibility for unrelated issues caused by faulty 3rd party solutions, but we will try to help you. &lt;/p&gt;\r\n	&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;Marketplaces offers freedom for authors to choose their own support policies without any obligation. The only exception and way to get a refund from Marketplaces if the given item is faulty or does not work as described, and the author refuses to fix the problems. The &lt;span&gt;&amp;nbsp;refund requests are handled by Marketplaces only, we don''t have any option to send your money back, even if we do agree with your demands. Please, keep in mind the points above, you should ask for help first, and we most likely can solve your problems. &lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Please&amp;nbsp;&lt;a href=&quot;https://help.market.envato.com/hc/en-us/articles/202821460&quot; target=&quot;_blank&quot;&gt;read the related FAQ entry&lt;/a&gt;&amp;nbsp;from Marketplaces about how you can request a refund.&lt;/p&gt;&lt;p&gt;Please Note: As the item you are purchasing is digital goods, by downloading the item you have taken ownership of the item, and we cannot offer refunds or exchanges due to a change of mind.&lt;/p&gt;\r\n');";

/*download_description*/ 

$mlqueries[$language_id][]="INSERT INTO `".DB_PREFIX."ave_download_description` (`download_id`, `language_id`, `name`, `description`) VALUES
(1, ". (int)$language_id. ", 'Monthly Quotations', 'Mauris ultricies metus id sapien porta vulputate. Cras feugiat nunc id mi condimentum mattis. '), 
(2, ". (int)$language_id. ", 'Weekly Quotations', 'Mauris ultricies metus id sapien porta vulputate. Cras feugiat nunc id mi condimentum mattis. '), 
(3, ". (int)$language_id. ", 'Daily Quotations', 'Mauris ultricies metus id sapien porta vulputate. Cras feugiat nunc id mi condimentum mattis. ');";

/*service_description*/ 
$mlqueries[$language_id][]="INSERT INTO `".DB_PREFIX."ave_service_description` (`service_id`, `language_id`, `name`, `description`) VALUES
(1, ". (int)$language_id. ", 'Design', 'Suspendisse aliquam, nisl at pellentesque rutrum, enim nunc venenatis enim, vitae ornare velit leo sit amet metus. '), 
(2, ". (int)$language_id. ", 'Development', 'Suspendisse aliquam, nisl at pellentesque rutrum, enim nunc venenatis enim, vitae ornare velit leo sit amet metus. '), 
(3, ". (int)$language_id. ", 'Analytics', 'Suspendisse aliquam, nisl at pellentesque rutrum, enim nunc venenatis enim, vitae ornare velit leo sit amet metus. '), 
(4, ". (int)$language_id. ", 'Optimization', 'Suspendisse aliquam, nisl at pellentesque rutrum, enim nunc venenatis enim, vitae ornare velit leo sit amet metus. '), 
(5, ". (int)$language_id. ", 'CMS', 'Suspendisse aliquam, nisl at pellentesque rutrum, enim nunc venenatis enim, vitae ornare velit leo sit amet metus. '), 
(6, ". (int)$language_id. ", 'Multimedia', 'Suspendisse aliquam, nisl at pellentesque rutrum, enim nunc venenatis enim, vitae ornare velit leo sit amet metus. '), 
(7, ". (int)$language_id. ", 'Marketing', 'Suspendisse aliquam, nisl at pellentesque rutrum, enim nunc venenatis enim, vitae ornare velit leo sit amet metus. '), 
(8, ". (int)$language_id. ", 'Hosting', 'Suspendisse aliquam, nisl at pellentesque rutrum, enim nunc venenatis enim, vitae ornare velit leo sit amet metus. '), 
(9, ". (int)$language_id. ", 'Graphic', 'Suspendisse aliquam, nisl at pellentesque rutrum, enim nunc venenatis enim, vitae ornare velit leo sit amet metus. '), 
(10, ". (int)$language_id. ", 'Design', 'Suspendisse aliquam, nisl at pellentesque rutrum, enim nunc venenatis enim, vitae ornare velit leo sit amet metus. '), 
(11, ". (int)$language_id. ", 'Creative', 'Suspendisse aliquam, nisl at pellentesque rutrum, enim nunc venenatis enim, vitae ornare velit leo sit amet metus. '), 
(12, ". (int)$language_id. ", 'Brochure', 'Suspendisse aliquam, nisl at pellentesque rutrum, enim nunc venenatis enim, vitae ornare velit leo sit amet metus. ');";	

		foreach ($mlqueries[$language_id] as $key => $mquery) {
			$this->db->query($mquery);
		}
}
	$this->db->query("INSERT INTO `" . DB_PREFIX. "setting` SET `key` = 'ave_confirm_installed', value = '1'");		
	}
	
}
?>