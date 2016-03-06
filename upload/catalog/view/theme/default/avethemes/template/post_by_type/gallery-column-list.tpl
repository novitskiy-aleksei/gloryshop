<?php if ($articles) { ?>
<div class="content_row">
    <h3 class="heading_title"><?php echo $heading_title; ?></h3>
    <div class="flickr_box clearfix magnific-gallery">
        <?php foreach ($articles as $article) { ?>
            <span class="flickr_badge_image">
                <a href="<?php echo $article['popup'];?>" class="item_image_ling">
                    <img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name'];?>" title="<?php echo $article['name'];?>">
                </a>
            </span>
        <?php } ?><!--for article --> 
    </div>
</div>
<?php } ?>