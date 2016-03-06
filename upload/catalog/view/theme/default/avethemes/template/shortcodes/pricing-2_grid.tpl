<div class="content large_spacer">
        <?php if(!empty($heading_title)){?>
			<div class="heading_title <?php echo $heading_align;?> upper">
			    <h2><span class="line"></span><?php echo $heading_title;?></h2>
			</div>
       <?php } ?>
		<div class="elem-pricing-container">
				<div class="elem-pricing-list">
<?php foreach($sections as $section){?>
				<div class="col-md-<?php echo $grid_limit;?> col-sm-<?php echo $grid_md;?> col-xs-12 <?php echo ($section['state']=='active')?'elem-popular':'';?>">
                    <div class="fix-margin">
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
                    </div><!-- fix-margin -->
				</div><!-- Grid -->
  <?php } ?>
              </div> <!-- .elem-pricing-list -->
			</div> <!-- .elem-pricing-container -->
		</div>