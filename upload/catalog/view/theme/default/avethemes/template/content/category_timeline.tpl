<?php global $ave;
 echo $header; ?>
<section class="section page_title">
    <div class="content clearfix">
        <h1><?php echo $heading_title; ?></h1>
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo $breadcrumb['href']; ?>"><span itemprop="title"><?php echo str_replace('<i class="fa fa-home"></i>','<i class="fa fa-home"></i><b>Home</b>',$breadcrumb['text']); ?></span></a></li>
        <?php } ?>
    </ul>
    </div>
</section>
<section class="section">
  <div class="content content_spacer clearfix">
<div class="content_row clearfix">
		<?php echo $column_left; ?>
        <div id="content" class="<?php echo $ave->layout('content');?>">
        <?php echo $content_top; ?>
        
     <div class="heading_title centered upper">
				<h2><span class="line"><i class="fa fa-pencil"></i></span><?php echo $heading_title; ?></h2>
			</div>
  <?php  if ($articles) { ?>
<!-- Filter Content -->
			<div class="isotope_filter_wrapper timeline">  
				<ul class="isotope_filter_wrapper_con timeline">
                
           <?php foreach ($articles as $article) { ?>
			    		<li class="filter_item_block animated" data-animation-delay="300" data-animation="bounceInUp">
						<div class="timeline_block clearfix">
							<a href="<?php echo $article['href'];?>" class="timeline_post_format image"><i class="fa fa-<?php echo $article['icon'];?>"></i></a>
							<div class="timeline_feature"> 
								<a data-rel="magnific-popup" href="<?php echo $article['popup'];?>"> 
									<span class="image-zoom"><i class="fa fa-plus"></i></span> 
									<img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name'];?>" title="<?php echo $article['name'];?>"> 
								</a>
							</div>
							  
							<h6 class="timeline_title"><a href="<?php echo $article['href'];?>"><?php echo $article['name'];?></a></h6>
							<span class="meta">
								<span class="meta_part">
										<i class="fa fa-clock"></i>
										<span><?php echo $article['date_added'];?></span>
								</span>
								<span class="meta_part">
									<i class="fa fa-user"></i>
									<span>
										<a href="<?php echo $article['author_href'];?>"><?php echo $article['author'];?></a>
									</span>
								</span>
								<span class="meta_part">
										<i class="fa fa-comment-o"></i>
										<span><?php echo $article['comments_text'];?></span>
								</span>
							</span>
							<div class="article"><?php echo $article['description'];?></div>
							<div class="clearfix">
								<a class="read_more_button" href="<?php echo $article['href'];?>">
									<i class="fa fa-arrow-forward"></i><?php echo $text_more; ?>
								</a>
							</div>
						</div>
					</li><!-- Item -->            
    	<?php } ?>
                    
				</ul>
				<div class="centered">
					
				</div>
			</div>
			<!-- End Filter Content -->                                 
    <?php } ?>
    <!--for article -->  
                              </div><!-- row--> 

  <div class="content_row pagination_row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><span class="pagination_results"><?php echo $results; ?></span></div>
  </div>
  
  <?php if (!$articles) { ?>
  <div class="alert alert-info">
      <div class="content_row clearfix">
        <div class="col-sm-6 text-left"><?php echo $text_empty; ?></div>
        <div class="col-sm-6 text-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><span><?php echo $button_continue; ?></span></a></div>
      </div>
  </div>
  <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div><!-- //content row--> 
</section><!-- //main section--> 
<?php echo $footer; ?>