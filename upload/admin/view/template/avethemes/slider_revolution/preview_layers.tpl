<?php 
	$class 	   = $configs['fullwidth'];
	$fullwidth = ($configs['fullwidth']=='fullwidth')?"on":"off";
	$fullscreen = ($configs['fullwidth']=='fullscreen')?"on":"off";
 
?>
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="../assets/plugins/revolution-slider/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="../assets/plugins/revolution-slider/jquery.themepunch.revolution.min.js"></script>
	<link rel="stylesheet" href="../assets/global/css/typography.css" type="text/css"/>
    <link rel="stylesheet" href="../assets/plugins/revolution-slider/settings.css" type="text/css"/>
    <?php echo $custom_css;?>
	<style>
        .rev_slider{ position: relative; overflow: hidden; }
        .bannercontainer { position: relative;margin: 0 auto; }
    </style>
<!-- START THE BODY LAYER SLIDER -->
<?php if( $class =="boxed") { ?>
<div class="layerslider-wrapper" style="width:100%; max-width:<?php echo $configs['startwidth'];?>px; margin: 0 auto;">
<?php } ?>
<div class="tp-banner-container" style="padding: <?php echo $configs['padding'];?>;margin: <?php echo $configs['margin'];?>;">
	<div id="layer_preview" class="tp-banner-<?php echo trim($class);?>" style="width:100%;height:<?php echo $configs['startheight'];?>px; " >	
		<ul>
			<!-- THE FIRST SLIDE -->
            <li <?php foreach($slider['group_setting'] as $key=>$value){ echo (strpos($key,'data-')!== false&&!empty($value))?$key.'="'.$value.'" ':''; } ?>>
					
						<?php
						 foreach ( $slider['layers'] as $i => $layer)  {
							$type = $layer['layer_type'];
						 ?>	
						
						 
								<!-- THE MAIN IMAGE IN THE SLIDE -->
							<img src="<?php echo HTTP_CATALOG."image/".$slider['image']; 	?>" >
						<div class="tp-caption <?php echo $layer['class-layer'].' '.$layer['class-animation'].' '.$layer['data-easing'].' '.$layer['class-endanimation'].' '.$layer['class-parallax'];?>"  <?php foreach($layer as $key=>$value){ echo (strpos($key,'data-')!== false&&!empty($value))?"\n".$key.'="'.$value.'" ':''; } ?> style="<?php echo $layer['style'];?>">
							 	<?php if( $type=='image') { ?> 
							 	<img src="<?php echo HTTP_CATALOG."image/".$layer['layer_content'];?>">
								 	<?php } else if( $type == 'video' ) { ?>
									 	<?php if( $layer['layer_video_type'] == 'vimeo')  { ?>
								 		<iframe src="http://player.vimeo.com/video/<?php echo $layer['layer_video_id'];?>?title=0&amp;byline=0&amp;portrait=0;api=1" width="<?php echo $layer['layer_video_width'];?>" height="<?php echo $layer['layer_video_height'];?>"></iframe>
								 		<?php } else { ?>
								 			<iframe width="<?php echo $layer['layer_video_width'];?>" height="<?php echo $layer['layer_video_height'];?>" src="http://www.youtube.com/embed/<?php echo $layer['layer_video_id'];?>" frameborder="0" allowfullscreen></iframe>
							 		<?php } ?>
							 <?php	} else { ?>
							 	<?php $layer_caption = str_replace( '_apos_', '\'',str_replace( '_ASM_', '&', $layer['layer_caption']));
                                 echo html_entity_decode($layer_caption, ENT_QUOTES, 'UTF-8');?>
                                 
							 	<?php } ?>

							</div>
						
						<?php } ?>		
			</li>			
            
					<li <?php foreach($slider['group_setting'] as $key=>$value){ echo (strpos($key,'data-')!== false&&!empty($value))?$key.'="'.$value.'" ':''; } ?>>
					
						<?php
						 foreach ( $slider['layers'] as $i => $layer)  {
							$type = $layer['layer_type'];
						 ?>	
						
						 
								<!-- THE MAIN IMAGE IN THE SLIDE -->
							<img src="<?php echo HTTP_CATALOG."image/".$slider['image']; 	?>" >
						<div class="tp-caption <?php echo $layer['class-layer'].' '.$layer['class-animation'].' '.$layer['data-easing'].' '.$layer['class-endanimation'].' '.$layer['class-parallax'];?>"  <?php foreach($layer as $key=>$value){ echo (strpos($key,'data-')!== false&&!empty($value))?"\n".$key.'="'.$value.'" ':''; } ?> style="<?php echo $layer['style'];?>">
							 	<?php if( $type=='image') { ?> 
							 	<img src="<?php echo HTTP_CATALOG."image/".$layer['layer_content'];?>">
								 	<?php } else if( $type == 'video' ) { ?>
									 	<?php if( $layer['layer_video_type'] == 'vimeo')  { ?>
								 		<iframe src="http://player.vimeo.com/video/<?php echo $layer['layer_video_id'];?>?title=0&amp;byline=0&amp;portrait=0;api=1" width="<?php echo $layer['layer_video_width'];?>" height="<?php echo $layer['layer_video_height'];?>"></iframe>
								 		<?php } else { ?>
								 			<iframe width="<?php echo $layer['layer_video_width'];?>" height="<?php echo $layer['layer_video_height'];?>" src="http://www.youtube.com/embed/<?php echo $layer['layer_video_id'];?>" frameborder="0" allowfullscreen></iframe>
							 		<?php } ?>
							 <?php	} else { ?>
							 	<?php $layer_caption = str_replace( '_apos_', '\'',str_replace( '_ASM_', '&', $layer['layer_caption']));
                                 echo html_entity_decode($layer_caption, ENT_QUOTES, 'UTF-8');?>
                                 
							 	<?php } ?>

							</div>
						
						<?php } ?>		
			</li>			
						 
		 
			 
		</ul>

		<div class="tp-bannertimer tp-bottom"></div>
	</div>
</div>
<?php if( $class =="boxed") { ?>
 </div>
<?php } ?>
<!-- END THE BODY LAYER SLIDER -->





<!--
##############################
 - ACTIVATE THE BANNER HERE -
##############################
-->
<script type="text/javascript">

	var tpj=jQuery;
	tpj.noConflict();

	tpj(document).ready(function() {

	if (tpj.fn.cssOriginal!=undefined)
		tpj.fn.css = tpj.fn.cssOriginal;
		tpj('#layer_preview').show().revolution({
                                dottedOverlay:"none",
                                delay:<?php echo $configs['delay'];?>,
                                startwidth:<?php echo $configs['startwidth'];?>,
                                startheight:<?php echo $configs['startheight'];?>,
                                hideThumbs:<?php echo (int)$configs['hideThumbs'];?>,
                                hideTimerBar:"off",
                                thumbWidth:<?php echo (int)$configs['thumbWidth'];?>,
                                thumbHeight:<?php echo (int)$configs['thumbHeight'];?>,
                                thumbAmount:<?php echo (int)$configs['thumbAmount'];?>,
                                spinned:"spinner4", //"spinner1" , "spinner2", "spinner3" , "spinner4", "spinner5"
                                navigationType:"<?php echo $configs['navigationType'];?>",
                                navigationArrows:"<?php echo $configs['navigationArrows'];?>",			
                                <?php if( $configs['navigationStyle'] != 'none' ) {   ?>
                                navigationStyle:"<?php echo $configs['navigationStyle'];?>",			 
                                <?php } ?>
                                
                                touchenabled:"<?php echo ($configs['touchenabled']?'on':'off') ?>",
                                onHoverStop:"<?php echo ($configs['onHoverStop']?'on':'off') ?>",
                                lazyLoad:"off",
                                
                                swipe_velocity: 0.7,
                                swipe_min_touches: 1,
                                swipe_max_touches: 1,
                                drag_block_vertical: false,
                                                        
                                parallax:"scroll",
                                parallaxBgFreeze:"off",
                                parallaxLevels:[10,20,30,40,50,60,70,80,90,100],
                                                        
                                keyboardNavigation:"off",
                                
                                navigationHAlign:"center",
                                navigationVAlign:"bottom",
                                navigationHOffset:0,
                                navigationVOffset:20,
                    
                                soloArrowLeftHalign:"left",
                                soloArrowLeftValign:"center",
                                soloArrowLeftHOffset:20,
                                soloArrowLeftVOffset:0,
                    
                                soloArrowRightHalign:"right",
                                soloArrowRightValign:"center",
                                soloArrowRightHOffset:20,
                                soloArrowRightVOffset:0,
                                        
                                shadow:<?php echo (int)$configs['shadow'];?>, //0,1,2,3  (0 == no Shadow, 1,2,3 - Different Shadow Types)
                                fullWidth:"<?php echo $fullwidth; ?>",
                                fullScreen:"<?php echo ($fullwidth=='on')?'off':'on'; ?>",
                    
                                spinner:"spinner4",
                                
                                stopLoop:"off",
                                stopAfterLoops:-1,
                                stopAtSlide:-1,
                    
                                shuffle:"<?php echo ($configs['shuffle']?'on':'off') ?>",
                                
                                autoHeight:"off",						
                                forceFullWidth:"off",						
                                                        
                                hideThumbsOnMobile:"off",
                                hideNavDelayOnMobile:1500,						
                                hideBulletsOnMobile:"off",
                                hideArrowsOnMobile:"off",
                                hideThumbsUnderResolution:0,
                                
                                hideSliderAtLimit:0,
                                hideCaptionAtLimit:0,
                                hideAllCaptionAtLilmit:0,
                                startWithSlide:0,
                                fullScreenOffsetContainer: ""	
                        }); 
	});
</script>