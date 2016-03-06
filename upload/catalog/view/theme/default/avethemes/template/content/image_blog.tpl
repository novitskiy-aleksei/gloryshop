<!-- Gallery -->
    <div class="thumbs_gall_slider_con content_thumbs_gall gall_full_width clearfix">
        <div class="thumbs_gall_slider_larg owl-carousel" data-transition="fadeUp">
          <?php foreach($banners as $banner){?>
             <?php if($banner['thumb']){?>
            <div class="item">
                <a href="<?php echo $banner['thumb']; ?>">
                    <img class="img-responsive" src="<?php echo $banner['thumb']; ?>" alt="<?php echo $banner['title']; ?>">
                </a>
            </div>
        <?php }  ?>	
      <?php }  ?>	
        </div>
        <div class="gall_thumbs owl-carousel">
          <?php foreach($banners as $banner){?>
             <?php if($banner['thumb']){?>
            <div class="item"><img class="img-responsive" src="<?php echo $banner['thumb']; ?>" alt="<?php echo $banner['title']; ?>"></div>
<?php }  ?>	
<?php }  ?>	
        </div>
    </div>
    <!-- End Gallery -->
