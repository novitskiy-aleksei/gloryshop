		<div class="content large_spacer">	
        <?php if(!empty($heading_title)){?>
			<div class="heading_title <?php echo $heading_align;?> upper">
			    <h2><span class="line"></span><?php echo $heading_title;?></h2>
			</div>
       <?php } ?>
			<svg id="polygon_svg" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="0px" height="0px" viewBox="0 0 60 69.474" enable-background="new 0 0 60 69.474" xml:space="preserve">
				<defs>
					<g id="hex">
						<path d="M60.083,47.104c0,2.75-1.948,6.125-4.33,7.5L34.33,66.974c-2.382,1.375-6.279,1.375-8.66,0L4.247,54.604
									      c-2.382-1.375-4.33-4.75-4.33-7.5V22.369c0-2.75,1.948-6.125,4.33-7.5L25.67,2.5c2.381-1.375,6.278-1.375,8.659,0l21.422,12.369
									      c2.382,1.375,4.33,4.75,4.33,7.5L60.083,47.104z"></path>
					</g>
				</defs>
			</svg>

			<div class="content_row clearfix">
<?php foreach($sections as $section){?>
				<div class="col-md-<?php echo $grid_limit;?> col-sm-<?php echo $grid_md;?> col-xs-12">
					<div class="plan_col plan_column1  <?php echo $section['state'];?>_plan">
						<h6>
							<span class="plan_price_block">
								<span class="plan_price_in">
									<span class="price"><?php echo $section['price'];?></span>
									<span class="plan_per"><?php echo $section['currency_code'];?><?php echo $section['period'];?></span>
								</span>
							</span>
							<span class="polygon_con">
<svg viewBox="0 0 70 70" xml:space="preserve" enable-background="" height="100px" width="100px" y="0px" x="0px" xmlns="http://www.w3.org/2000/svg">
  <use y="0px" x="5px" xlink:href="#hex" class="polygon_fill" stroke-width="1"/>
</svg>

							</span>
							<span class="plan_price_name"><?php echo $section['title'];?></span>
						</h6>
						<ul>
						 <?php if(!empty($section['feature1'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature1'];?></li><?php } ?>
                       <?php if(!empty($section['feature2'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature2'];?></li><?php } ?>
                      <?php if(!empty($section['feature3'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature3'];?></li><?php } ?>
                       <?php if(!empty($section['feature4'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature4'];?></li><?php } ?>
                       <?php if(!empty($section['feature5'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature5'];?></li><?php } ?>
                      <?php if(!empty($section['feature6'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature6'];?></li><?php } ?>
                      <?php if(!empty($section['feature7'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature7'];?></li><?php } ?>
                       <?php if(!empty($section['feature8'])){?><li><i class="fa fa-angle-right"></i> <?php echo $section['feature8'];?></li><?php } ?>
						</ul>
                   <div class="price_desc">
                       <?php echo $section['more_desc'];?> &nbsp;
                      </div>
						<a class="plan_price_btn" href="<?php echo $section['href'];?>" target="<?php echo $section['target'];?>"><?php echo $section['btn_title'];?></a>
					</div>
				</div><!-- Grid -->
  <?php } ?>
                
			</div>
		</div>