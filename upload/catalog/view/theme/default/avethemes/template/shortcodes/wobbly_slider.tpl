<div class="section">
		<div id="<?php echo $module;?>" class="wobbly_slide">
			<ul>
            
			<?php foreach($sections as $section){?>
				<li>
					<div class="wobbly_slide">
						<img class="icon" src="<?php echo !empty($section['image'])?'image/'.$section['image']:''?>" alt="<?php if(isset($section['title'][$language_id])){?><?php echo $section['title'][$language_id];?><?php } ?>"/>
						<h2 class="wobbly_title upper"><?php if(isset($section['title'][$language_id])){?><?php echo $section['title'][$language_id];?><?php } ?></h2>
						<p class="wobbly_desc"><?php if(isset($section['description'][$language_id])){?><?php echo $section['description'][$language_id];?><?php } ?></p>
						<a class="bordered_btn_white upper" href="<?php echo $section['btn_href'];?>" target="<?php echo $section['btn_target'];?>"><?php if(isset($section['btn_title'][$language_id])){?><?php echo $section['btn_title'][$language_id];?><?php } ?></a>
					</div>
				</li>
                <?php } ?>
			</ul>
		</div>
 <script type="text/javascript">
$(document).ready(function(){
    //=====> Wobbly Slider
		if (typeof SliderFx !== 'undefined' && $.isFunction(SliderFx)) {
			var slide_fx = new SliderFx( document.getElementById('<?php echo $module;?>'), {
				easing : 'cubic-bezier(.8,0,.2,1)',
			} );
		}
});
 </script>   
	</div>