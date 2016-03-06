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
				<h2><span class="line"><i class="fa fa-user"></i></span><?php echo $text_about_me; ?></h2>
			</div>
      
							<!-- About the author -->
							<div class="about_author full_info">
								<div class="about_author_con clearfix">
									<span class="avatar_img centered">
										<img alt="client name" src="<?php echo $thumb;?>">
									</span>
									<div class="about_author_details">
										<h3 class="author_link"><?php echo $author;?></h3>
										<span class="desc"><?php echo $description;?></span>
                                        
             <?php if(!empty($socials)){?>
										<div class="social_media clearfix">
                <?php foreach($socials as $social){?>
											<a href="<?php echo $social['href'];?>" target="<?php echo $social['target'];?>">
												<i class="<?php echo $social['social'];?>"></i>
											</a>
            <?php } ?>
										</div>
            <?php } ?>
									</div>
									
								</div>
							</div>
							<!-- End About the author -->
  
  
  <?php
  
  $grid_limit = $ave_cms_project_grid_limit;
   if ($articles) { ?>
   <!-- Filter Content -->
            <div class="isotope_filter_wrapper blocks_<?php echo $grid_limit;?> project_text_nav boxed_portos has_sapce_portos upper_title ave_full_desc upper_title">
			<div id="options" class="sort_options clearfix">
			    <ul data-option-key="filter" class="option-set clearfix" id="filter-by">
				<li><a data-option-value="*" class="selected" href="#"><span><?php echo $text_show_all;?></span><span class="num"></span></a></li>
                <?php foreach ($filter_services as $filter) { ?>
				<li><a data-option-value=".<?php echo $filter['section'];?>" class="" href="#"><span><?php echo $filter['name'];?></span><span class="num"></span></a></li>
 				<?php } ?>
			    </ul>
				 <div class="item-sort-order pull-right">
                    	<div class="item-sort-label" style="width:120px;">
             <select onchange="location = this.value;" class="form-control">
              		<option value="<?php echo $limit_href;?>"><?php echo $text_limit; ?> <?php echo $limit;?></option>
                    <?php foreach ($limits as $limits) { ?>
                    <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                 <?php } ?>
              </select>
                    </div>
            </div><!--// item-sort-order --> 
			    
			</div>   
            <div class="content_row">
            <div class="isotope_filter_wrapper_con">
			    
           <?php foreach ($articles as $article) { ?>
          <?php $article_section =$article['services'];?>
                 <div class="filter_item_block <?php echo $article_section;?>">
				    <div class="ave_block ave_animate">
					    <div class="ave_type">
						    <a data-rel="magnific-popup" href="<?php echo $article['popup'];?>">
							    <img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name']; ?>">
						    </a>
					    </div>
					    <div class="ave_desc">
						<div class="ave_meta clearfix">
						    <h6 class="name"><?php echo $article['name']; ?></h6>
						    <span class="ave_date"><span class="number"></span><?php echo $article['date_added']; ?></span>
						    <a href="<?php echo $article['popup'];?>" class="expand_img"><?php echo $text_view_larger;?></a>
						    <a href="<?php echo $article['href']; ?>" class="detail_link"><?php echo $text_more; ?></a>
						</div>
					    </div>
				    </div>
			    </div><!-- Item -->            
                
    	<?php } ?>
    <!--for article -->  
			    </div> 
			</div>
		    </div>
		    <!-- End Filter Content -->
                      
    
  <div class="content_row pagination_row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><span class="pagination_results"><?php echo $results; ?></span></div>
  </div>
  <?php }else{ ?>
  <div class="alert alert-info">
      <div class="content_row clearfix">
        <div class="col-sm-6 text-left"><?php echo $text_empty; ?></div>
        <div class="col-sm-6 text-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><span><?php echo $button_continue; ?></span></a></div>
      </div>
  </div>
  <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div><!-- //content row--> 
    </div><!-- //content spacer--> 
</section><!-- //main section--> 
<?php echo $footer; ?>