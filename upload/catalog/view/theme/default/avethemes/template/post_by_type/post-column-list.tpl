<?php if($articles) { ?>
    <div class="content_row">
            <h3 class="heading_title"><?php echo $heading_title; ?></h3>
            <ul class="recent_posts_list">
             <?php foreach ($articles as $article) { ?>
             <li class="clearfix">
                    <a href="<?php echo $article['href']; ?>">
                        <span class="recent_posts_img"><img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['thumb'];?>" ></span>
                   
                   
                        <span><?php echo $article['name']; ?></span>
                         </a>
                    <span class="recent_post_detail"><a href="<?php echo $article['author_href']; ?>" title="<?php echo $text_author;?> <?php echo $article['author']; ?>"><?php echo $article['author']; ?></a></span> 
                    <span class="recent_post_detail"><?php echo $article['date_added']; ?></span>
                   
                </li>
    <?php } ?><!--for article --> 
    </ul>
    <?php if($btn_more==1){?>
    <a class="btn_a bg-base medium_btn full_width margin-top-20" href="<?php echo $timeline;?>">
                    <span><i class="in_left fa fa-long-arrow-right"></i>
                    <span><?php echo $text_read_more_post;?></span>
                    <i class="in_right fa fa-long-arrow-right"></i></span>
                </a>
    </div>
    <?php } ?>
<?php } ?>
