  <?php
    if (!empty($categories)) { ?>
 <?php foreach ($categories as $category) { ?>
       <?php if ($category['total']>0){ ?> 
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
      
    <div class="content large_spacer">
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $category['name']; ?> 
            <div class="control-btn pull-right"><a href="<?php echo $category['href']; ?>" class="view_more" data-toggle="tooltip" title="<?php echo $text_viewmore.$category['name']; ?>"><i class="fa fa-angle-right"></i></a></div>
            </h3>
		</div>
        <div class="content_row">
          <div class="col-md-3">
            <p class="main_desc"><?php echo $category['description']; ?></p>
          </div>
          <div class="col-md-9">
<?php if($category['articles']){ ?> 
     <div class="content_row elem_item_grid post-layout">
    <?php foreach ($category['articles'] as $article) { ?>
 <div class="col-md-<?php echo $grid_limit;?> col-sm-12 col-xs-12">
    <div class="item_list_block animated" data-animation-delay="300" data-animation="<?php echo $animation;?>">
            <div class="item_image">
                <div class="item_image_corners">
                    <div class="item_image_btns">
                        <a href="<?php echo $article['popup'];?>" class="expand_image"><i class="fa fa-external-link"></i></a>
                        <a href="<?php echo $article['href'];?>" class="icon_link"><i class="fa fa-link"></i></a>
                    </div>
                    <a href="<?php echo $article['popup'];?>" class="item_image_ling" data-rel="magnific-popup">
                        <img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name']; ?>">
                    </a>
                </div>
            </div>
            <div class="item_desc">
                <a href="<?php echo $article['href'];?>" class="blog_grid_format"><i class="<?php echo ($article['icon'])?$article['icon']:'fa fa-pencil';?>"></i></a>
                <h6 class="title"><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h6>
                <span class="meta">
                    <span class="meta_part"><?php echo $article['date_added']; ?></span>
                    <span class="meta_slash">/</span>
                    <span class="meta_part"><?php echo $article['comments']; ?></span>
                    <span class="meta_slash">/</span>
                    <span class="meta_part"><a href="<?php echo $article['author_href']; ?>"><?php echo $article['author']; ?></a></span>
                </span>
                <p class="desc"><?php echo $article['description']; ?></p>
            </div>
        </div>
        </div>
    <?php } ?>
    </div><!-- row --> 
    <?php } ?><!-- article exist --> 
    </div><!--col-md-9-->

      </div><!-- END ROW -->
    </div>
    </div>
  <?php } ?>  <!-- count--> 
  <?php } ?>  
  <?php } ?>  