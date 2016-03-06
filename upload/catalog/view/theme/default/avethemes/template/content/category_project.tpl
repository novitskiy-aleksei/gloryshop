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
				<h2><span class="line"><i class="fa fa-<?php echo $icon;?>"></i></span><?php echo $heading_title; ?></h2>
		</div>
      

          <?php if (!empty($description)) { ?>
                  <div class="clearfix margin-bottom-25">
            <?php echo $description; ?>
            </div>
          <?php } ?>
  
  <?php
  
  $grid_limit = $ave_cms_project_grid_limit;
   if ($articles) { ?>
   <!-- Filter Content -->
		    <div class="isotope_filter_wrapper blocks_<?php echo $grid_limit;?> project_text_nav boxed_portos has_sapce_portos nav_with_nums upper_title upper_title">
			<div id="options" class="sort_options clearfix">
			    <ul data-option-key="filter" class="option-set clearfix" id="filter-by">
				<li><a data-option-value="*" class="selected" href="#"><span><?php echo $text_show_all;?></span><span class="num"></span></a></li>
                <?php foreach ($filter_services as $filter) { ?>
				<li><a data-option-value=".<?php echo $filter['section'];?>" class="" href="#"><span><?php echo $filter['name'];?></span><span class="num"></span></a></li>
 				<?php } ?>
			    </ul>
			    
			</div>   
            <div class="row">
            <div class="isotope_filter_wrapper_con">
			    
           <?php foreach ($articles as $article) { ?>
          <?php $article_section ='';
               foreach ($article['services'] as $sv) { $article_section .= $sv['section'].' ';  } ?>
			    <div class="filter_item_block <?php echo $article_section;?>">
				    <div class="ave_block">
					    <div class="ave_type">
						    <a data-rel="magnific-popup" href="<?php echo $article['popup'];?>">
							    <img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="Portfolio Name">
						    </a>
						    <div class="ave_nav">
							<a href="<?php echo $article['popup'];?>" class="expand_img"><?php echo $text_view_larger;?></a>
							<a href="<?php echo $article['href']; ?>" class="detail_link"><?php echo $text_more; ?></a>
						    </div>
					    </div>
					    <div class="ave_desc">
						<a href="<?php echo $article['href']; ?>" class="name"><?php echo $article['name']; ?></a>
						<div class="ave_meta clearfix">
						    <span class="ave_date"><span class="number"></span><?php echo $article['date_added']; ?></span>
						    <span class="ave_nums">
							<span class="comm"><i class="fa fa-comments"></i><span class="comm_counter"><?php echo $article['comments']; ?></span></span>
							<span class="like"><a href="<?php echo $article['author_href']; ?>" data-toggle="tooltip" title="<?php echo $article['author']; ?>"><i class="fa fa-user"></i></a><span class="like_counter hide">100</span></span>
						    </span>
						</div>
					    </div>
				    </div>
			    </div><!-- Item  -->               
    	<?php } ?>
			    
			</div>
			</div>
		    </div>
		    <!-- End Filter Content -->
                                 
    <?php } ?>
  
    <!--for article -->  

  <div class="row pagination_row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><span class="pagination_results"><?php echo $results; ?></span></div>
  </div>
  
  <?php if (!$categories && !$articles) { ?>
  <div class="alert alert-info">
      <div class="content_row clearfix">
        <div class="col-sm-6 text-left"><?php echo $text_empty; ?></div>
        <div class="col-sm-6 text-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><span><?php echo $button_continue; ?></span></a></div>
      </div>
  </div>
  <?php } ?>
      <?php echo $content_bottom; ?></div> 
	  <?php echo $column_right; ?>
                              </div><!-- row--> 
  </div><!-- //content row--> 
</section><!-- //main section--> 
<?php echo $footer; ?>