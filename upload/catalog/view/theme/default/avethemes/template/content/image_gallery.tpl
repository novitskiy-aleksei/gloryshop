<div class="magnific-gallery clearfix centered">
<div class="row">
        <?php foreach ($banners as $banner) { ?>
            <div class="col-md-<?php echo $grid_limit;?> col-sm-<?php echo $grid_limit;?> col-xs-12 margin-bottom-30">
                <!-- Single Image -->
                    <a class="img_popup" href="<?php echo $banner['popup']; ?>" data-effect="mfp-zoom-in" title="<?php echo $banner['title'];?>">
                        <img class="img-responsive" src="<?php echo $banner['thumb']; ?>">
                        <span>
                            <i class="fa fa-external-link"></i>
                        </span>
                    </a>
                <!-- End Single Image -->
            </div>
    <?php } ?><!--for banner --> 
  </div>
  </div>