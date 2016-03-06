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
				<h2><span class="line"><i class="fa fa-search"></i></span><?php echo $heading_title; ?></h2>
		</div>
      
   <label class="control-label"><strong><?php echo $text_critea; ?></strong></label>
      <div class="content_row margin-bottom-20">
        <div class="col-sm-4">
          <input type="text" name="search" class="form-control" value="<?php echo $search; ?>" <?php if (!$search) { ?>onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;"<?php } ?>/>
          
            <label class="checkbox-inline">
           <input type="checkbox" name="filter_description" value="1" id="filter_description" <?php if ($filter_description) { ?>checked="checked"<?php } ?>/>
          <?php echo $entry_description; ?></label>
        </div>
        <div class="col-sm-4">
           <select name="filter_content_id" class="form-control">
        <option value="0"><?php echo $text_category; ?></option>
        <?php foreach ($categories as $category_1) { ?>
        <?php if ($category_1['content_id'] == $filter_content_id) { ?>
        <option value="<?php echo $category_1['content_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_1['content_id']; ?>"><?php echo $category_1['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_1['children'] as $category_2) { ?>
        <?php if ($category_2['content_id'] == $filter_content_id) { ?>
        <option value="<?php echo $category_2['content_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_2['content_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_2['children'] as $category_3) { ?>
        <?php if ($category_3['content_id'] == $filter_content_id) { ?>
        <option value="<?php echo $category_3['content_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_3['content_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php } ?>
      </select>
          <label class="checkbox-inline">
            <input type="checkbox" name="filter_sub_category" value="1" id="filter_sub_category"  <?php if ($filter_sub_category) { ?>checked="checked"<?php } ?>/>    
      <?php echo $text_sub_category; ?></label>
        </div>
        <div class="col-sm-4">
      <button id="btn-search" class="btn btn-primary"><?php echo $button_search; ?></button>
        </div>
      </div>
       <?php if ($articles) { ?>
  <h3 class="clearfix"><?php echo $text_search; ?></h3>
    <?php } ?>
    <?php 
      $desc=$ave->get('desc'); 
  ?>
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
									<i class="fa fa-clock"></i>
									<span><?php echo $article['date_added']; ?></span>
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
  <div class="content_row pagination_row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><span class="pagination_results"><?php echo $results; ?></span></div>
  </div>
  <?php } ?>
  <?php if (!$articles) { ?>
  <div class="alert alert-info">
      <div class="content_row">
        <div class="col-sm-12 text-left"><?php echo $text_empty; ?></div>
      </div>
  </div>
  <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div><!-- //content row--> 
    </div><!-- //content spacer--> 
</section><!-- //main section--> 

<script type="text/javascript"><!--
$('#content input[name=\'search\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#btn-search').trigger('click');
	}
});

$('select[name=\'filter_content_id\']').bind('change', function() {
	if (this.value == '0') {
		$('input[name=\'filter_sub_category\']').attr('disabled', 'disabled');
		$('input[name=\'filter_sub_category\']').removeAttr('checked');
	} else {
		$('input[name=\'filter_sub_category\']').removeAttr('disabled');
	}
});

$('#btn-search').bind('click', function() {
	url = 'index.php?route=content/search';
	
	var search = $('#content input[name=\'search\']').attr('value');
	
	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var filter_content_id = $('#content select[name=\'filter_content_id\']').attr('value');
	
	if (filter_content_id > 0) {
		url += '&filter_content_id=' + encodeURIComponent(filter_content_id);
	}
	
	var filter_sub_category = $('#content input[name=\'filter_sub_category\']:checked').attr('value');
	
	if (filter_sub_category) {
		url += '&filter_sub_category=true';
	}		
	var filter_description = $('#content input[name=\'filter_description\']:checked').attr('value');	
	if (filter_description) {
		url += '&filter_description=true';
	}
	location = url;
});
//--></script>
<?php echo $footer; ?>
