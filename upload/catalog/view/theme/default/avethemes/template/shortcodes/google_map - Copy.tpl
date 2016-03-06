<?php if($sections['type']=='boxed'){?>
<div class="content content_spacer">
     <h3 class="heading_title"><?php echo $heading_title; ?></h3>
      <div class="bordered_content bordered">
                  <div id="map_wg_<?php echo $module;?>" class="gmaps" style="min-height:<?php echo str_replace('px','',$sections['height']);?>px;"></div>
       </div>
</div>
<?php }else if($sections['type']=='fullwidth'){?>
	<div class="section">
        <div class="title_banner bg-base upper centered">
			<div class="content">
				<h2><?php echo $heading_title; ?></h2>
			</div>
		</div>
		<div class="bordered_content">
			<div id="map_wg_<?php echo $module;?>" class="google_map" style="min-height:<?php echo str_replace('px','',$sections['height']);?>px;"></div>
		</div>
</div>
<?php }else{?>
<div class="content content_spacer">
      <a href="https://maps.google.com/maps?q=<?php echo $sections['latitude'];?>,<?php echo $sections['longitude'];?>" class="btn_a medium_btn popup-gmaps upper"><span><i class="in_left fa fa-map-marker"></i><span><?php echo $heading_title; ?></span><i class="in_right fa fa-map-marker"></i></span></a>

</div>	
<?php }?>
<script>	  
        $(document).ready(function(){
            if( $('#map_wg_<?php echo $module;?>').length )	{	
              map = new GMaps({
                div: '#map_wg_<?php echo $module;?>',
                lat: <?php echo $sections['latitude'];?>,
                lng: <?php echo $sections['longitude'];?>,
              });
               var marker = map.addMarker({
                    lat: <?php echo $sections['latitude'];?>,
                    lng: <?php echo $sections['longitude'];?>,
                    title: '<?php echo (!empty($sections['title']))?html_entity_decode($sections['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?>',
                    infoWindow: {
                        content: "<?php echo (!empty($sections['description']))?html_entity_decode($sections['description'][$language_id], ENT_QUOTES, 'UTF-8'):'';?>"
                    }
                });
               marker.infoWindow.open(map, marker);
            }
        });
    </script>