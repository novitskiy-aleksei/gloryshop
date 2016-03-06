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
  
  <?php if ($articles) { ?>
   <div class="item-sorting clearfix">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group item-sort-order">
              <label class="col-md-4 control-label"><?php echo $text_limit; ?></label>
                    <div class="col-md-8">
                    	<div class="item-sort-label">
             <select onchange="location = this.value;" class="form-control">
                    <?php foreach ($limits as $limits) { ?>
                    <?php if ($limits['value'] == $limit) { ?>
                    <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                    <?php } ?>
                    <?php } ?>
              </select>
                      </div>
                    </div>
            </div><!--// item-sort-order --> 
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group item-sort-order">
                  <label class="col-md-4 control-label"><?php echo $text_sort; ?></label>
                    <div class="col-md-8">
                        <div class="item-sort-label">
                              <select onchange="location = this.value;" class="form-control">
                                    <?php foreach ($sorts as $sorts) { ?>
                                    <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                                    <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                               </select>
                        </div>
                    </div>
                </div><!--// item-sort-order --> 
        </div>
      </div>
               
  <div class="elem_item_list clearfix">
    <?php foreach ($articles as $article) { ?>
    <div class="item_list_block clearfix">
					<div class="item_image">
						<div class="item_image_corners">
                        <div class="item_image_btns">
								<a href="<?php echo $article['popup']; ?>" class="expand_image"><i class="fa fa-external-link"></i></a>
								<a href="<?php echo $article['href']; ?>" class="icon_link"><i class="fa fa-link"></i></a>
							</div>
							<a href="<?php echo $article['href']; ?>" class="item_image_ling">
								<img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name']; ?>">
							</a>
						</div>
					</div>
					<div class="item_desc">
						<h6 class="title"><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h6>
						<span class="meta">
							<span class="meta_part">
								<a href="#">
									<i class="fa fa-clock"></i>
									<span><?php echo $article['date_added']; ?></span>
								</a>
							</span>
							<span class="meta_part">
								<a href="<?php echo $article['author_href']; ?>">
									<i class="fa fa-user"></i>
									<span><?php echo $article['author']; ?></span>
								</a>
							</span>
							<span class="meta_part">
									<i class="fa fa-comment-o"></i>
									<span><?php echo $article['comments']; ?></span>
							</span>
						</span>
						<p class="desc"><?php echo $article['description']; ?></p>
						<a class="btn_a" href="<?php echo $article['href']; ?>">
							<span>
								<i class="in_left fa fa-angle-right"></i>
								<span><?php echo $text_more; ?></span>
								<i class="in_right fa fa-angle-right"></i>
							</span>
						</a>
					</div>
				</div>
    <?php } ?><!--for article --> 
    
  </div>
  <div class="row pagination_row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><span class="pagination_results"><?php echo $results; ?></span></div>
  </div>
  <?php } ?>
  <?php if (!$categories && !$articles) { ?>
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