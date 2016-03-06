<div class="content_row">
    <h3 class="heading_title"><?php echo $heading_title; ?></h3>
    <div class="flickr_box clearfix lightbox_gallery">
    <?php foreach ($banners as $banner) { ?>
        <span class="flickr_badge_image">
            <a href="<?php echo $banner['popup']; ?>" data-source="<?php echo $banner['popup']; ?>" data-caption="<?php echo $banner['title'];?>" title="<?php echo $banner['title'];?>"><img src="<?php echo $banner['image']; ?>" class="img-responsive" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title'];?>"/></a>
        </span>
    <?php } ?><!--for article --> 
    </div>
</div>