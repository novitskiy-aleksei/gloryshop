<!-- Four Boxes Slider -->
<div class="section">
    <div class="boxgallery_con">
        <div class="boxgallery_desc">
            <div class="four_boxes_block">
                <span class="four_boxes_title"><?php echo $heading_title;?></span>
                <span class="four_boxes_desc"><?php echo $description;?></span>
            </div>
        </div>
        
        <div id="boxgallery" class="boxgallery" data-effect="effect-2">
  <?php foreach ($banners as $banner) { ?>
            <div class="panel"><img class="img-responsive" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>"/></div>
  <?php } ?>
          

        </div>
    </div>
    
<script type="text/javascript"><!--
$(document).ready(function(){
//=====> Four Boxes Slider
	if (typeof BoxesFx !== 'undefined' && $.isFunction(BoxesFx)) {
		var boxesfx_gall = new BoxesFx( document.getElementById('boxgallery'));
	}
});
--></script>
</div>
<!-- End Four Boxes Slider -->
