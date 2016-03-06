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
						<div class="elem_item_full_width clearfix">
							
                            
							<div class="item_desc clearfix">
                             <div class="content_row clearfix margin-bottom-20"> 
                              <div class="col-md-6 col-xs-12 margin-bottom-20 pull-right">  
                                  <div class="item_image">
                                    <?php echo $banner_images;  ?> 
                                	</div>
                                <?php echo $article_poll;  ?> 
                              </div>
                              <div class="col-md-6 col-xs-12"> 
                              <div class="post_title_con">
                            <div class="upper">
                                <h2 class="heading_title"><?php echo $heading_title; ?></h2>
                            </div>
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
                            <?php echo $description; ?>
                            </div><!-- //description--> 
                          </div><!-- row--> 
                         
    <div class="container">  
      <?php if ($services) { ?>
        <div class="heading_title centered upper">
				<h2><span class="line"><span class="dot"></span></span><?php echo $text_service_provide; ?></h2>
		</div>
        <div class="padding-top-20 icon_boxes_con style1 circle upper_title just_icon_border clearfix">
             
            <?php foreach (array_chunk($services, 4) as $services) { ?>
            <div class="content_row">
                <?php foreach ($services as $service) { ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="service_box"> <span class="icon"><i class="<?php echo $service['icon']; ?>"></i></span>
                    <div class="service_box_con centered">
                        <h3><?php echo $service['name']; ?></h3>
    
                        <span class="desc"><?php echo $service['description']; ?></span>
                         <a href="<?php echo $service['href']; ?>" class="ser-box-link"><span></span>Read More</a>
                     </div>
                </div>
            </div>
          <?php } ?>
            </div><!-- //row--> 
          <?php } ?>
    
    
        </div>
          <?php } ?>  
      <?php 
  if ($testimonials) { ?>
  <!-- Client Say -->
		<div class="clearfix">	
			<div class="heading_title centered upper">
				<h2><span class="line"><i class="fa fa-comments-o"></i></span><?php echo $text_testimonials;?></h2>
			</div>                
			<div id="testimonials<?php echo $article_id;?>" class="owl_text_slider client_say_slider ">
            
      <?php foreach ($testimonials as $testimonial) { ?>
				<div class="c_say">
					<div class="centered">
						<span class="client_img">
							<span>
								<img class="img-responsive" src="<?php echo $testimonial['avatar'];?>" alt="<?php echo $testimonial['name'];?>">
							</span>
						</span>
					</div>
					<span class="client_details">
						<span class="name"><?php echo $testimonial['name'];?></span>
						<span class="url"> - <?php echo $testimonial['competence'];?></span>
					</span>
					<span>
                    <div class="item-rating centered"><span class="star-<?php echo $testimonial['rating'];?>"></span></div>
					</span>
					<span class="desc"><?php echo $testimonial['message'];?></span>
				</div><!--//c_say --> 
		<?php } ?>
				
			</div>
            <script type="text/javascript">
			var rtl_direction = false;
				if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
					rtl_direction = true;
				};
			$('#testimonials<?php echo $article_id;?>').owlCarousel({
				rtl: rtl_direction,
				smartSpeed : 900,
				autoplay: true, 
				 autoplayTimeout:2000,
				autoHeight : true,
				items:1,
				stopOnHover : true,
				nav : true,
				navText : [
					"<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
					"<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
				dots: false,
			});
			</script>
            
            	</div>
	<!-- End Client Say  -->

<?php } ?>
        </div>               
    
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
  <div class="clearfix">
  
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