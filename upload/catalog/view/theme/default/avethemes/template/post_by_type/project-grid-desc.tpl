<?php if ($articles) { ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?>
<?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="content large_spacer">
      <?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>

     <div class="content_row">
              <div class="col-md-3">
                <p class="main_desc"><?php echo $description;?></p>
              </div>
              <div class="col-md-9">
    <div id="<?php echo $module;?>" class="elem_item_grid project_text_nav boxed_portos upper_title">
    <div class="row">
        <?php foreach ($articles as $article) { ?>
          <div class="col-md-<?php echo $grid_limit;?> col-sm-6 col-xs-12 col-xxs-12">
                  <div class="item_list_block animated" data-animation-delay="300" data-animation="<?php echo $animation;?>">
                     <div class="ave_block">
                            <div class="ave_type">
                                <a data-rel="magnific-popup" href="<?php echo $article['popup'];?>">
                                    <img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="Portfolio Name">
                                </a>
                                <div class="ave_nav">
                                <a href="<?php echo $article['popup'];?>" class="expand_img"><?php echo $text_larger;?></a>
                                <a href="<?php echo $article['href'];?>" class="detail_link"><?php echo $text_more;?></a>
                                </div>
                            </div>
                            <div class="ave_desc">
                            <h6 class="name"><?php echo $article['name'];?></h6>
                            <div class="ave_meta clearfix">
                                <span class="ave_date"><?php echo $article['date_added']; ?></span>
                                <span class="ave_nums">
                                <span class="comm"><i class="fa fa-comments"></i><?php echo $article['comments']; ?></span>
                                <span class="author"><i class="fa fa-user"></i><a href="<?php echo $article['author_href'];?>"><?php echo $article['author'];?></a></span>
                                </span>
                            </div>
                            </div>
                        </div>
            </div><!--post-item --> 
            </div><!-- //col--> 
        <?php } ?>
        </div><!--row--> 
        </div><!--elem_item_grid --> 
              </div><!-- col-md-9 --> 
          </div>
    </div>
</div>
<?php } ?>