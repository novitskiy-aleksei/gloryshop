<?php if ($articles) { ?>
<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?>
<?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
    <div class="content large_spacer">

      <?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>

    <?php if(!empty($description)){?><p class="main_desc centered"><?php echo $description;?></p><?php } ?>
    <div class="content_row elem_item_grid clearfix">
    
    <?php foreach ($articles as $article) { ?>
    <div class="col-md-<?php echo $grid_limit;?> col-sm-12 col-xs-12">
    <div class="item_list_block animated" data-animation-delay="300" data-animation="<?php echo $animation;?>">
            <div class="item_image">
                <div class="item_image_corners">
                    <div class="item_image_btns">
                        <a href="<?php echo $article['popup'];?>" class="expand_image"><i class="fa fa-external-link"></i></a>
                        <a href="<?php echo $article['href'];?>" class="icon_link"><i class="fa fa-link"></i></a>
                    </div>
                    <a href="<?php echo $article['popup'];?>" class="item_image_ling" data-rel="magnific-popup">
                        <img class="img-responsive" src="<?php echo $article['thumb'];?>" alt="<?php echo $article['name'];?>">
                    </a>
                </div>
            </div>
            
        </div>
        </div>
    <?php } ?><!--for article --> 
    </div>
</div>
</div>
<?php } ?>