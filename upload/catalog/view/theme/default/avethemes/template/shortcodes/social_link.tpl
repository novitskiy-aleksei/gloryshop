<!-- Social Media -->
<div class="content_row">
    <h3 class="heading_title"><?php echo $heading_title;?></h3>
    <div class="social_links_widget clearfix">
        <?php foreach($sections as $section){?>
        <a href="<?php echo $section['href'];?>" target="<?php echo $section['target'];?>" class="twitter" data-toggle="tooltip" title="<?php echo $section['title'];?>"><i class="<?php echo $section['icon'];?>"></i></a>
        <?php } ?>
    </div>
</div>
<!-- End Social Media -->
