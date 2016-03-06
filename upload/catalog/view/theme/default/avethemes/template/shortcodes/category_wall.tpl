<!-- CAtegory wll -->
	<div class="section centered">
		<div class="content content_spacer clearfix">

	<?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h3><span class="line"><?php echo !empty($icon)?'<i class="'.$icon.'"></i>':'<span class="dot"></span>';?></span><?php echo $heading_title;?></h3>
		</div>
      <?php } ?>
      
<div class="content_row clearfix">
<?php if($display_type=='carousel'){?><div id="<?php echo $module;?>" class="carousel"><?php } ?>
<?php foreach($sections as $section){?>
				<?php if($display_type=='grid'){?><div id="<?php echo $module;?>" class="col-md-<?php echo $grid_limit;?> col-sm-<?php echo $grid_md;?> col-xs-12"><?php } ?>
					<div class="category-wall">
                    <img alt="" src="<?php echo 'image/'.$section['image'];?>">
                    <div class="category-wall-title text-center">
						<h6><span><?php echo $section['title'][$language_id];?></span></h6>
					<ul>
              <li><?php if(!empty($section['category_1'])){?><a href="<?php echo $section['href_1'];?>"><?php echo $section['category_1'][$language_id];?></a><?php } ?></li>
              <li><?php if(!empty($section['category_2'])){?><a href="<?php echo $section['href_2'];?>"><?php echo $section['category_2'][$language_id];?></a><?php } ?></li>
              <li><?php if(!empty($section['category_3'])){?><a href="<?php echo $section['href_3'];?>"><?php echo $section['category_3'][$language_id];?></a><?php } ?></li>
              <li><?php if(!empty($section['category_4'])){?><a href="<?php echo $section['href_4'];?>"><?php echo $section['category_4'][$language_id];?></a><?php } ?></li>
              <li><?php if(!empty($section['category_5'])){?><a href="<?php echo $section['href_5'];?>"><?php echo $section['category_5'][$language_id];?></a><?php } ?></li>
                    </ul>
                 </div>
					</div>
		<?php if($display_type=='grid'){?></div><!-- Grid --><?php } ?>
  <?php } ?>
<?php if($display_type=='carousel'){?></div><?php } ?>
			</div>
  
   <?php if($display_type=='carousel'){?>  
    <script type="text/javascript">
var rtl_direction = false;
	if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
		rtl_direction = true;
	};

$('#<?php echo $module;?>').owlCarousel({
		rtl: rtl_direction,
		margin: 20,
		loop: false,
		items: <?php echo $carousel_limit;?>, 
		autoHeight: true,
		dots: false,
		nav: true,
		navText: ["<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>","<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
		responsive: {
			0: {items: 1},
			479: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
			768: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
			979: {items: <?php echo ($carousel_limit>1)?'3':'1';?>},
			1199: {items: <?php echo $carousel_limit;?>}
		}
	});
</script>   
  <?php } ?>    
       
      
		</div>    
	</div>
	<!-- End Demos -->