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
        
        <!-- Post Container -->
						<div class="elem_item_full_width elem_item_list clearfix">
							<div class="post_title_con">
								<h6 class="title"><?php echo $heading_title; ?></h6>
								<span class="meta">
									<span class="meta_part">
											<i class="fa fa-clock"></i>
											<span><?php echo $date_added;?> </span>
									</span>
									<span class="meta_part">
										<a onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">
											<i class="fa fa-comment-o"></i>
											<span><?php echo $comments; ?></span>
										</a>
									</span>
									
									<span class="meta_part">
										<a href="<?php echo $author_href;?>">
											<i class="fa fa-user"></i>
											<span><?php echo $author;?></span>
										</a>
									</span>
								</span>
							</div>
							
							<div class="item_icon">
								<span>
									<a href="<?php echo $href;?>">
										<i class="fa fa-photo"></i>
									</a>
								</span>
							</div>
							<div class="item_image">
  <?php echo $banner_images;  ?> 
							</div>
							<div class="item_desc clearfix">
								
                            <?php if ($poll_id) { ?>
                             <div class="content_row clearfix"> 
                              <div class="col-md-5 col-sm-12 col-xs-12 pull-right margin-bottom-10">  
                                <?php echo $article_poll;  ?> 
                              </div>
                              <div class="col-md-7 col-sm-12 col-xs-12 pull-left"> 
                            <?php echo $description; ?>
                            </div><!-- //description--> 
                          </div><!-- row--> 
                            <?php }else{ ?>    
                          <?php echo $description; ?>  
                            <?php } ?>
    
							</div>
							
                         <?php if($ave->getConfig('ave_cms_addthis')==1){?>
                                       <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style margin-bottom-20">
            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
            <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a>
            <a class="addthis_counter addthis_pill_style"></a>
            </div>
            <!-- AddThis Button END -->
                                   <?php } ?>
							
							<!-- Tags -->
							
  <?php if (!empty($tags)) { ?>
    <div class="small_title">
        <span class="small_title_con">
            <span class="s_icon"><i class="fa fa-tag"></i></span>
            <span class="s_text"><?php echo $text_tags;?> </span>
        </span>
    </div>   
    <div class="tags_con">
      <?php foreach ($tags as $tag) { ?>
        <a href="<?php echo $tag['href']; ?>" rel="tag"><?php echo $tag['tag']; ?></a>
        <?php } ?>
      </div>
  <?php } ?>
							<!-- End Tags -->
							<?php if($author_info){?>
							<!-- About the author -->
							<div class="about_author">
								<div class="small_title">
									<span class="small_title_con">
										<span class="s_icon"><i class="fa fa-user"></i></span>
										<span class="s_text"><?php echo $text_about_author;?></span>
									</span>
								</div>
								
								<div class="about_author_con clearfix">
									<span class="avatar_img">
										<img alt="client name" src="<?php echo $author_thumb;?>">
									</span>
									<div class="about_author_details">
										<a href="<?php echo $author_href;?>" class="author_link"><?php echo $author;?></a>
										<div class="desc"><?php echo $author_description;?></div>
                                        
             <?php if(!empty($author_socials)){?>
										<div class="social_media clearfix">
                <?php foreach($author_socials as $social){?>
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
                             <?php } ?>
						</div>
						<!-- End Post Container -->
						
                        
                        
<div class="content_row">
  <div class="box-content">
  
    <?php if ($comment_status||$downloads) { ?>
    <div class="elem-tabs tabs2 is-ended clearfix">
    <nav>
     <ul class="tabs-navi">
    <?php if ($comment_status) { ?>
               <li class="active"><a href="#tab-review" data-toggle="tab" class="selected"><?php echo $tab_comment; ?></a></li>
      <?php } ?>
      
     <?php if ($downloads) { ?>
    <li><a href="#tab-download" data-toggle="tab"><?php echo $tab_download; ?> (<?php echo count($downloads); ?>)</a></li>
    <?php } ?>
    </ul>
    </nav>
    
    
    <div class="tabs-body tab-content clearfix">
    
    <?php if ($downloads) { ?>
 <div class="tab-pane" id="tab-download">  
   <?php if ($ave->getConfig('ave_cms_login_to_download')==1) { ?>
    <div class="alert alert-attention"><?php echo $text_login_to_download;?></div>
    <?php } ?>
 		<?php foreach ($downloads as $download) { ?>
       	 <div class="call_to_action boxed_white container">
		    <div class="content clearfix">
			    <h3><?php echo $download['name']; ?></h3>
			<a href="<?php echo $download['href'];?>" class="btn_a bg-1 f_right">
			    <span><i class="in_left fa fa-download"></i><span><?php echo $text_download;?></span><i class="in_right fa fa-download"></i></span>
			</a>
			<span class="intro_text"><?php echo $download['description']; ?></span>
		    </div>
		</div>
      <?php } ?>
    </div>
<?php } ?>
    
  
  <?php if ($comment_status) { ?>
    <div class="tab-pane active selected" id="tab-review">    
            <div class="post-comment margin-bottom-20">    
    <div id="review" class="commerce_comments"></div>
    <h2 id="review-title"><?php echo $text_write; ?></h2>                     
                      <div class="form-group">
                        <label><?php echo $entry_name; ?></label>
    <input type="text" name="name" value="" class="form-control"/>
                      </div>          
                      <div class="form-group">
                        <label><?php echo $entry_comment; ?></label>
    <textarea name="text" cols="40" rows="8" class="form-control"></textarea>
                      </div>
                                      
    <span style="font-size: 11px;"><?php echo $text_note; ?></span><br/><br/> 
    
                      <div class="form-group">
                        <label><?php echo $entry_rating; ?></label>                       
                      <div class="checkbox_radio_con">
                        <span><?php echo $entry_bad; ?> &nbsp;</span>
                        <input type="radio" name="rating" value="1" checked> &nbsp;
                        <input type="radio" name="rating" value="2" checked> &nbsp;
                        <input type="radio" name="rating" value="3" checked> &nbsp;
                        <input type="radio" name="rating" value="4" checked> &nbsp;
                        <input type="radio" name="rating" value="5" checked>
                        <span> &nbsp;<?php echo $entry_good; ?></span>
                      </div>
                      </div>

                      <div class="form-group clearfix">
                      <div class="input-group pull-left"> 
                        <div class="input-group-addon captcha">
                                <img src="index.php?route=avethemes/common/captcha" alt="" id="captcha" onclick="reload_captcha('captcha');">
                              </div>
                          <input type="text" name="captcha" value="" id="input-captcha" class="form-control">
                             
                        </div>
                       
                      <div class="pull-right"><a id="button-review" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
                      </div>
                      
                    </div><!--post-comment--> 
                    </div><!--tab-review  --> 
                    <?php } ?> 
    </div><!--tabContent --> 
    </div><!--elem tabs --> 
     <?php } ?><!--end comment and poll --> 
              
  
   </div><!-- end main box-content -->
</div><!-- //end main box -->

<div class="row">
 <?php echo $article_related;  ?>  
 <?php echo $product_related;  ?>
</div><!-- //row--> 
 
   <?php echo $content_bottom; ?>
   </div>
    <?php echo $column_right; ?>
    </div><!-- //content row--> 
    </div><!-- //content spacer--> 
</section><!-- //main section--> 
    
<script type="text/javascript"><!--
function reload_captcha(id) {
	var obj =document.getElementById(id);
	var src ='index.php?route=avethemes/common/captcha';
	var date =new Date();
	obj.src = src + '&time=' + date.getTime();
	return false;
}
$('#review .pagination a').on('click', function() {
	$('#review').fadeOut('slow');
		
	$('#review').load(this.href);
	
	$('#review').fadeIn('slow');
	
	return false;
});			

$('#review').load('index.php?route=content/article/comment&article_id=<?php echo $article_id; ?>');

$('#button-review').bind('click', function() {
	function clear_data(){ 
		$('input[name=\'name\']').val('');
			$('textarea[name=\'text\']').val('');
			$('input[name=\'rating\']:checked').attr('checked','');
			$('input[name=\'captcha\']').val('');
	}
	function show_review(){ 
		$.get("index.php?route=content/article/comment&article_id=<?php echo $article_id;?>",function(data){ 
		$("#review").html(data);
		});	
	}
	$.ajax({
		url: 'index.php?route=content/article/write&article_id=<?php echo $article_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.alert').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="alert alert-attention"><img src="assets/global/img/loading.gif" alt=""/> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.alert-attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#review-title').after('<div class="alert alert-warning">' + data['error'] + '</div>'); 
			}
			
			if (data['success']) {
				$('#review-title').after('<div class="alert alert-success">' + data['success'] + '</div>');
				clear_data();
				show_review();
				reload_captcha('captcha');
			}
		}
	});
});
//--></script>

<?php echo $footer; ?>