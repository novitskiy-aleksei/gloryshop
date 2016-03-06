<?php if ($articles) { ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?>
<?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="large_spacer_t clearfix">
      <?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>
<?php
?>
    <!-- Filter Content -->
    <?php if(!empty($description)){?><p class="main_desc centered"><?php echo $description;?></p><?php } ?>
            <div class="isotope_filter_wrapper blocks_<?php echo ($carousel_limit<2||$carousel_limit>4)?'3':$carousel_limit;?> project_text_nav full_portos no_sapce_portos nav_in_center upper_title ave_hidden_title">
			<div id="options" class="sort_options clearfix">
			    <ul data-option-key="filter" class="option-set clearfix" id="filter-by">
				<li><a data-option-value="*" class="selected"><span>all</span><span class="num"></span></a></li>
        <?php foreach($filter_services as $service){?>
				<li><a data-option-value=".<?php echo $service['section'];?>" class=""><span><?php echo $service['name'];?></span><span class="num"></span></a></li>
          <?php } ?>
			    </ul>
			</div>     
				   
			<div class="isotope_filter_wrapper_con">
        <?php foreach($articles as $article){?>
        <?php $filter_services ='';  foreach ($article['filter_services'] as $sv) { $filter_services .= $sv.' ';  } ?>
			    <div class="filter_item_block <?php echo $filter_services;?>">
				    <div class="ave_block">
					    <div class="ave_type">
						    <a data-rel="magnific-popup" href="<?php echo $article['popup'];?>">
							    <img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name']; ?>">
						    </a>
						    <div class="ave_nav">
							<a href="<?php echo $article['popup'];?>" class="expand_img"><?php echo $text_larger;?></a>
							<a href="<?php echo $article['href'];?>" class="detail_link"><?php echo $text_more;?></a>
						    </div>
					    </div>
					    <div class="ave_desc">
						<h6 class="name"><?php echo $article['name']; ?></h6>
						<div class="ave_meta clearfix">
						    <span class="ave_date"><span class="number"><?php echo $article['strtotime']; ?></span><?php echo $article['date_added']; ?></span>
						    <span class="ave_nums">
							<span class="comm"><i class="fa fa-comments"></i><span class="comm_counter"><?php echo $article['comments']; ?></span></span>
							<span class="like"><i class="fa fa-user"></i><a href="<?php echo $article['author_href']; ?>"><?php echo $article['author']; ?></a></span>
						    </span>
						</div>
					    </div>
				    </div>
			    </div><!-- Item -->
		 <?php } ?> <!-- for -->
			</div>
		    </div>
		    <!-- End Filter Content -->
		

</div>
</div>
<?php } ?>