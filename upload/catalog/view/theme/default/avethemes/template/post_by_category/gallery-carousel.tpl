<?php
      if (!empty($categories)) { ?>
 <?php foreach ($categories as $category) { ?>
       <?php if ($category['total']>0){ ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
      
    <div class="content large_spacer">
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $category['name']; ?></h3>
	</div>


<div id="<?php echo $module;?>_<?php echo $category['tab_id'];?>" class=" post-layout elem_item_grid owl-carousel carousel-nav-<?php echo $carousel_nav;?> lightbox_gallery" data-options="{attr:&#39;data-source&#39;,path:&#39;horizontal&#39;,skin:&#39;smooth&#39;}">
   		<?php if($category['articles']){ ?> 
     <?php foreach (array_chunk($category['articles'], $num_row) as $articles_row) { ?>
<div class="item">
      <?php foreach ($articles_row as $article) { ?>
    <div class="item_list_block">
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
      <?php } ?><!--for --> 
    </div>   <!--//item-->  
      <?php } ?>
      <?php } ?>
    </div>   <!--//item-grid-->    
<script type="text/javascript">
$('#<?php echo $module;?>_<?php echo $category['tab_id'];?>').owlCarousel({
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
</div>
</div>
  <?php } ?>  <!-- count--> 
  <?php } ?>  
  <?php } ?>  