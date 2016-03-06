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
                <li class="<?php echo ($i==1)?'active':'';?>"><a href="#tab-post-grid_<?php echo $category['tab_id']; ?>" data-toggle="tab" class="<?php echo ($i==1)?'selected':'';?>"><?php echo $category['name']; ?></a></li>
  <?php } ?>  
  <?php } ?>  
                  </ul> 
                  </nav>				
                  <div id="myTabContent" class="tab-content">
                     <?php $i=0;?>
 <?php foreach ($categories as $category) { $i++;  ?>
       <?php if ($category['total']>0){ ?>
                    <div class="tab-pane fade in <?php echo ($i==1)?'active':'';?>" id="tab-post-grid_<?php echo $category['tab_id']; ?>">
<div id="<?php echo $module;?>_<?php echo $i; ?>" class="post-layout elem_item_grid owl-carousel carousel-nav-<?php echo $carousel_nav;?>">
   		<?php if($category['articles']){ ?> 
     <?php foreach (array_chunk($category['articles'], $num_row) as $article_row) { ?>
<div class="item">
<?php foreach ($article_row as $article) { ?>
    <div class="item_list_block">
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
<?php } ?>
    </div><!--//item --> 
<?php } ?><!--for --> 
<script type="text/javascript">
$('#<?php echo $module;?>_<?php echo $i; ?>').owlCarousel({
		margin: 20,
		loop: false,
		items: <?php echo $carousel_limit;?>, 
		smartSpeed : <?php echo $smartSpeed;?>,
		slideBy:<?php echo $slideBy;?>,
		autoWidth: false,
		dots: false,
		nav: true,
		navText: ["<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>","<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
		responsive: {
			0: {items: 1},
			479: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
			768: {items: <?php echo ($carousel_limit>2)?'3':'2';?>},
			979: {items: <?php echo ($carousel_limit>3)?'4':'3';?>},
			1199: {items: <?php echo $carousel_limit;?>}
		}
	});
</script>
      <?php } else { ?> <?php echo $text_empty; ?> <?php } ?>
</div>   <!--//item-grid-->  
                    </div><!--tab-pane --> 
        <?php } ?>  <!-- count-->   
  <?php } ?>  
                  </div><!--tab-content --> 
                    
  
  </div><!--//box-content-->   
</div>
</div>
<?php } ?>  