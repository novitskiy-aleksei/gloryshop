		<?php if(!empty($heading_title)){?>
		<div class="content content_spacer">	
			<div class="heading_title <?php echo $heading_align;?> upper">
			    <h2><span class="line"></span><?php echo $heading_title;?></h2>
			</div>
       </div>
       <?php } ?>
		<div class="elem-pricing-container elem-full-width elem-secondary-theme">
				<div id="<?php echo $module;?>" class="elem-pricing-list">
<?php foreach($sections as $section){?>
				<div class="elem-pricing-item <?php echo ($section['state']=='active')?'elem-popular':'';?>" style="background:<?php echo !empty($bgcolor)?$bgcolor:'#fff'?>;">
                            <header class="elem-pricing-header">
                                <h2><?php echo $section['title'];?></h2>
                                <div class="elem-price">
                                    <span class="elem-currency"><?php echo $section['currency_code'];?></span>
                                    <span class="elem-value"><?php echo $section['price'];?></span>
                                    <span class="elem-duration"><?php echo $section['period'];?></span>
                                </div>
                            </header> <!-- .elem-pricing-header -->
            
                            <div class="elem-pricing-body">
                                <ul class="elem-pricing-features">
						 <?php if(!empty($section['feature1'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature1'];?></li><?php } ?>
                       <?php if(!empty($section['feature2'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature2'];?></li><?php } ?>
                      <?php if(!empty($section['feature3'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature3'];?></li><?php } ?>
                       <?php if(!empty($section['feature4'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature4'];?></li><?php } ?>
                       <?php if(!empty($section['feature5'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature5'];?></li><?php } ?>
                      <?php if(!empty($section['feature6'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature6'];?></li><?php } ?>
                      <?php if(!empty($section['feature7'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature7'];?></li><?php } ?>
                       <?php if(!empty($section['feature8'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature8'];?></li><?php } ?>
                                </ul>
                            </div> <!-- .elem-pricing-body -->
            
                            <footer class="elem-pricing-footer">
                   <div class="price_desc">
                       <?php echo $section['more_desc'];?> &nbsp;
                      </div>
                                <a class="elem-select" href="<?php echo $section['href'];?>" target="<?php echo $section['target'];?>"><?php echo $section['btn_title'];?></a>
                            </footer> <!-- .elem-pricing-footer -->
				</div><!-- Owl item -->
  <?php } ?>
              </div> <!-- .elem-pricing-list -->
			</div> <!-- .elem-pricing-container -->
    <script type="text/javascript">
var rtl_direction = false;
	if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
		rtl_direction = true;
	};

$('#<?php echo $module;?>').owlCarousel({
		rtl: rtl_direction,
		margin: 0,
		loop: false,
		items: <?php echo $carousel_limit;?>, 
		autoHeight: true,
		dots: true,
		nav: true,
		navText: ["<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>","<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
		responsive: {
			0: {items: 1},
			479: {items: 1},
			768: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
			979: {items: <?php echo ($carousel_limit>1)?'3':'1';?>},
			1199: {items: <?php echo $carousel_limit;?>}
		}
	});
</script>