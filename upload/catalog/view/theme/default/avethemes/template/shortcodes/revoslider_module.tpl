<?php 
	$configs['hideThumbs'] = $configs['show_navigator']?0:$configs['hideThumbs'];
	$class 	   = $configs['fullwidth'];
	$fullwidth = ($configs['fullwidth']=='fullwidth')?"on":"off";
	$fullscreen = ($configs['fullwidth']=='fullscreen')?"on":"off";
 
?>
<?php if( $class =="boxed") { ?>
<div class="layerslider-wrapper" style="width:100%; max-width:<?php echo $configs['startwidth'];?>px; margin: 0 auto;">
<?php } ?>
<div class="tp-banner-container clearfix" style=" padding: <?php echo $configs['padding'];?>;margin: <?php echo $configs['margin'];?>;">

					<div id="<?php echo $module; ?>" class="tp-banner-<?php echo trim($class);?>" style="display:none;width:100%;height:<?php echo $configs['startheight'];?>px; " >
						
						 
        <ul>
           <?php foreach( $sliders as $_key => $slider )  { ?>
           <li data-saveperformance="on" <?php foreach($slider['group_setting'] as $key=>$value){ echo (strpos($key,'data-')!== false&&!empty($value))?$key.'="'.$value.'" ':''; } ?>>
                <?php if( $slider['group_setting']['slider_usevideo'] == 'youtube' || $slider['group_setting']['slider_usevideo'] == 'vimeo' ) { ?>
				<!-- Video Background-->
                <?php 
                    $vi_url  = 'http://player.vimeo.com/video/'.$slider['group_setting']['slider_videoid'].'/';
                    if(  $slider['group_setting']['slider_usevideo'] == 'youtube' ){
                        $vi_url  = 'http://www.youtube.com/embed/'.$slider['group_setting']['slider_videoid'].'/';
                    }
                ?>
                    <div class="tp-caption fade fullscreenvideo" data-autoplay="true" data-x="0" data-y="0" data-speed="500" data-start="10" data-easing="<?php echo $layer['data-easing']; ?>"><iframe src="<?php echo $vi_url;?>?title=0&amp;byline=0&amp;portrait=0;api=1" frameborder="0" width="100%" height="100%" style="<?php echo $layer['style'];?>"></iframe></div>
                            
                            <?php }elseif( $slider['main_image'] ) { ?>
				<!-- Image Background-->    
                                <img src="<?php echo $slider['main_image']; ?>"  alt="Image <?php echo $_key; ?>" data-duration="<?php echo $configs['delay'];?>"  <?php foreach($slider['group_setting'] as $key=>$value){ echo (strpos($key,'dataimg-')!== false&&!empty($value))?str_replace('dataimg-','data-',$key).'="'.$value.'" ':''; } ?>/>
                            <?php } ?>
                            <?php                                  
                             foreach ( $slider['layers_data'] as $i => $layer )  {
                                $layer_tag = ($layer['link_enable']==1)?'a':'div'; 
                                $type = $layer['layer_type'];
                                    
    $layer_link = ($layer['link_enable']==1&&!empty($layer['link_href']))?' href="'.$layer['link_href'].'" target="'.$layer['link_target'].'"':'';
                             ?>	
                           <!-- SLIDE CAPTION-->
<<?php echo $layer_tag.$layer_link;?> class="tp-caption <?php echo $layer['class-layer'].' '.$layer['class-animation'].' '.$layer['data-easing'].' '.$layer['class-endanimation'].' '.$layer['class-parallax'];?>" <?php foreach($layer as $key=>$value){ echo (strpos($key,'data-')!== false&&!empty($value))?"\n".$key.'="'.$value.'" ':''; } ?> style="<?php echo $layer['style'];?>">
                                 
                             <?php
   $layer_caption = html_entity_decode(str_replace( '_apos_', '\'',str_replace( '_ASM_', '&', $layer['layer_caption'])) , ENT_QUOTES, 'UTF-8');
                                  if( $type=='image') { ?> 
                                    	<img src="<?php echo $url."image/".$layer['layer_content'];?>" alt="<?php echo htmlentities ($layer_caption); ?>"/>
                                   <?php } else if( $type == 'video' ) { ?>
                                            <?php if( $layer['layer_video_type'] == 'vimeo')  { ?>
                                            <iframe src="http://player.vimeo.com/video/<?php echo $layer['layer_video_id'];?>?wmode=transparent&amp;title=0&amp;byline=0&amp;portrait=0;api=1" frameborder="0" width="<?php echo $layer['layer_video_width'];?>" height="<?php echo $layer['layer_video_height'];?>"></iframe>
                                   			<?php } else { ?>
                                                <iframe width="<?php echo $layer['layer_video_width'];?>" height="<?php echo $layer['layer_video_height'];?>" src="http://www.youtube.com/embed/<?php echo $layer['layer_video_id'];?>?wmode=transparent" frameborder="0" allowfullscreen="1"></iframe>
                                        <?php } ?>
                                 <?php	} else { 
                                    echo $layer_caption;
                                  } ?>

                                </<?php echo $layer_tag;?>>
                            
                            <?php } ?>		
                </li>			
                             
             
                <?php } ?>	
            </ul>
						<?php if( $configs['show_time_line']  ) { ?> 
						<div class="tp-bannertimer tp-<?php echo $configs['time_line_position']; ?>"></div>
						<?php } ?>
					</div>
 
			
			<script type="text/javascript">
jQuery(document).ready(function() {	
		if ( $.isFunction($.fn.revolution) ) {

       jQuery('#<?php echo $module; ?>').show().revolution({
       
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
				lazyLoad:"on",
				
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
    };

});
			</script>

				</div>
<?php if( $class =="boxed") { ?>
 </div>
<?php } ?>
 