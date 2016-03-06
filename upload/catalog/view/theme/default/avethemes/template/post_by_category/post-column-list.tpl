<?php
if (!empty($categories)) { ?>
 <?php foreach ($categories as $category) { ?>
       <?php if ($category['total']>0){ ?>
<div class="content">
        <h3 class="heading_title"><?php echo $category['name']; ?> </h3>
        <ul class="recent_posts_list">
   		<?php if($category['articles']){ ?> 
      <?php foreach ($category['articles'] as $article) { ?>
         <li class="clearfix">
                <a href="<?php echo $article['href']; ?>">
                    <span class="recent_posts_img"><img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['thumb'];?>" ></span>
                </a>
               
                    <span><?php echo $article['name']; ?></span>
                <span class="recent_post_detail"><a href="<?php echo $article['author_href']; ?>" title="<?php echo $text_author;?> <?php echo $article['author']; ?>"><?php echo $article['author']; ?></a></span> 
                <span class="recent_post_detail"><?php echo $article['date_added']; ?></span>
               
            </li>
<?php } ?><!--for article --> 
<?php } ?><!----> 
</ul>
<a class="btn_a bg-base medium_btn full_width margin-top-20" href="<?php echo $category['href']; ?>">
                <span><i class="in_left fa fa-long-arrow-right"></i>
                <span><?php echo $text_view_all.$category['name']; ?></span>
                <i class="in_right fa fa-long-arrow-right"></i></span>
            </a>
</div>
  <?php } ?>  <!-- count--> 
  <?php } ?>  
  <?php } ?>  

