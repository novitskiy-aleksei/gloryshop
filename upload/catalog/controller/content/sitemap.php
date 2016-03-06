<?php  
class ControllerContentSitemap extends Controller {
   public function index() {
			$output  = '<?xml version="1.0" encoding="UTF-8"?>';
			$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		 $this->load->model('avethemes/article');
		 $articles = $this->model_avethemes_article->getArticles();
		 
		 foreach ($articles as $article) {
			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('content/article', 'article_id=' . $article['article_id']) . '</loc>';
		 	$output .= '<lastmod>' . date('Y-m-d',  strtotime($article['date_modified'])) . '</lastmod>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>1.0</priority>';
			$output .= '</url>';   
		 }
		 		 
		$output .= $this->getCategories(0);
			 
		 $this->load->model('avethemes/author');
		 
		 $authors = $this->model_avethemes_author->getAuthors();
		 foreach ($authors as $author) {
			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('content/author/info', 'author_id=' . $author['author_id']) . '</loc>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>0.7</priority>';
			$output .= '</url>';         
		 }
		 
		 
			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('content/author') . '</loc>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>1.0</priority>';
			$output .= '</url>';  
			$output .= '</urlset>';

			$this->response->addHeader('Content-Type: application/xml');
			$this->response->setOutput($output);
   }
   
   protected function getCategories($parent_id, $current_content_id = '') {
	  $output = '';	  
		$this->load->model('avethemes/category');
	  $results = $this->model_avethemes_category->getCategories($parent_id);
	  
	  foreach ($results as $result) {
		 if (!$current_content_id) {
			$new_content_id = $result['content_id'];
		 } else {
			$new_content_id = $current_content_id . '_' . $result['content_id'];
		 }

		 $output .= '<url>';
		 $output .= '<loc>' . $this->url->link('content/category', 'content_id=' . $new_content_id) . '</loc>';
		 $output .= '<lastmod>' . date('Y-m-d',  strtotime($result['date_modified'])) . '</lastmod>';
		 $output .= '<changefreq>weekly</changefreq>';
		 $output .= '<priority>0.7</priority>';
		 $output .= '</url>';         
		 
		   $output .= $this->getCategories($result['content_id'], $new_content_id);
	  }

	  return $output;
   }   
}
?>