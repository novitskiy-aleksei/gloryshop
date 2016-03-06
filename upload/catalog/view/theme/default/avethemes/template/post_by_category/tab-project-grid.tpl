<?php
     if (!empty($categories)) { ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
      <div class="content large_spacer">
      <?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>
 				<div class="elem-tabs tabs2 fill_active hide_arrow">
 <nav class="clearfix">
		<ul id="product_list<?php echo $module;?>" class="tabs-navi">

             <?php $i=0;?>
 <?php foreach ($categories as $category) { $i++; ?>
       <?php if ($category['total']>0){ ?>
                <li class="<?php echo ($i==1)?'active':'';?>"><a href="#tab-product-grid_<?php echo $category['tab_id']; ?>" data-toggle="tab" class="<?php echo ($i==1)?'selected':'';?>"><?php echo $category['name']; ?></a></li>
  <?php } ?>  
  <?php } ?>  
                  </ul> 
                  </nav>				
                  <div class="tab-content">
                     <?php $i=0;?>
 <?php foreach ($categories as $category) { $i++;  ?>
       <?php if ($category['total']>0){ ?>
                    <div class="tab-pane fade in <?php echo ($i==1)?'active':'';?>" id="tab-product-grid_<?php echo $category['tab_id']; ?>">
                    
<div class="post-layout elem_item_grid clearfix project_text_nav boxed_portos upper_title">
<div class="row">
   		<?php if($category['articles']){ ?> 
      <?php foreach ($category['articles'] as $article) { ?>
   	 <div class="col-md-<?php echo $grid_limit;?> col-sm-12 col-xs-12">
              <div class="item_list_block animated" data-animation-delay="300" data-animation="<?php echo $animation;?>">
              	 <div class="ave_block">
					    <div class="ave_type">
						    <a data-rel="magnific-popup" href="<?php echo $article['popup'];?>">
							    <img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name'];?>">
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
        </div><!-- //col --> 
      <?php } ?><!--for --> 
      <?php } else { ?> <?php echo $text_empty; ?> <?php } ?>
    </div>   <!--//row-->  
    </div>   <!--//item-grid-->  
                    </div><!--tab-pane --> 
        <?php } ?>  <!-- count-->   
  <?php } ?>  
                  </div><!--tab-content --> 
                    
  
  </div><!--//box-content-->   
</div>
</div>
<?php } ?>  