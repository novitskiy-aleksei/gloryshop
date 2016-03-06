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

<div class="elem_item_grid post-layout clearfix lightbox_gallery" data-options="{attr:&#39;data-source&#39;,path:&#39;horizontal&#39;,skin:&#39;smooth&#39;}">
<div class="row">
   		<?php if($category['articles']){ ?> 
      <?php foreach ($category['articles'] as $article) { ?>
     <div class="col-md-<?php echo $grid_limit;?> col-sm-12 col-xs-12">
    <div class="item_list_block animated" data-animation-delay="300" data-animation="<?php echo $animation;?>">
            <div class="item_image">
                <div class="item_image_corners">
                    <div class="item_image_btns">
                        <a href="<?php echo $article['popup'];?>" data-source="<?php echo $article['popup']; ?>" data-caption="<?php echo $article['name'];?>"  class="expand_image"><i class="fa fa-external-link"></i></a>
                        
						<a href="<?php echo $article['href']; ?>" class="icon_link"><i class="fa fa-link"></i></a>

                    </div>
                    <a href="<?php echo $article['href']; ?>" title="<?php echo $article['name'];?>">
                        <img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name'];?>">
                    </a>
                </div>
            </div>
            
        </div>
        </div>
      <?php } ?><!--for --> 
      <?php } ?>
    </div>   <!--//item-grid-->    
  </div><!--row --> 
</div>
</div>
  <?php } ?>  <!-- count--> 
  <?php } ?>  
  <?php } ?>  