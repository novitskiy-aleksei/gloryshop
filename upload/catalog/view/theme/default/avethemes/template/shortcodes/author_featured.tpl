<div class="content_row">
    <h3 class="heading_title"><?php echo $heading_title;?></h3>
    <div class="featured_author clearfix">
        <a href="<?php echo $href;?>" class="about_author_link"> <img class="img-responsive" src="<?php echo $thumb;?>" alt="<?php echo $author;?>"> <span><?php echo $author;?></span> </a>
          <?php if(!empty($socials)){?>
										<div class="social_media">
                <?php foreach($socials as $social){?>
											<a href="<?php echo $social['href'];?>" target="<?php echo $social['target'];?>">
												<i class="<?php echo $social['social'];?>"></i>
											</a>
            	<?php } ?>
										</div>
            <?php } ?>
    </div>
</div>