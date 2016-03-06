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
                    
<div class="post-layout elem_item_grid clearfix project_text_nav boxed_portos upper_title lightbox_gallery" data-options="{attr:&#39;data-source&#39;,path:&#39;horizontal&#39;,skin:&#39;smooth&#39;}">
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
                    <a href="<?php echo $article['popup']; ?>" title="<?php echo $article['name'];?>">
                        <img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name'];?>">
                    </a>
                </div>
            </div>
            
        </div>
        </div>
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