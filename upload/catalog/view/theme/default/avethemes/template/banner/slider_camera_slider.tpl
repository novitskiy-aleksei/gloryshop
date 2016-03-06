	<!-- Camera- Slider -->
	<div class="camera_slider_container">
		<div class="camera_wrap camera_azure_skin without_thumbs" id="<?php echo $module;?>">
  <?php foreach ($banners as $banner) { ?>	
            <div data-thumb="<?php echo $banner['thumb']; ?>" data-src="<?php echo $banner['image']; ?>">
				<div class="camera_caption fadeFromBottom">
				   <?php echo $banner['title']; ?>
				</div>
			</div>
  <?php } ?>
		</div><!-- #camera_wrap_1 -->
        <script type="text/javascript"><!--
		$(document).ready(function(){
			$("#<?php echo $module;?>").camera({
				thumbnails: true,
			});
        });
--></script>
	</div>
	<!-- End Camera Slider -->