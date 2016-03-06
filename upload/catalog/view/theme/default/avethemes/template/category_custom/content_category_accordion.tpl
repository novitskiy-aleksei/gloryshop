<?php if($categories) {?>
    <div class="content_row">
          <?php if($heading_title){?><h3 class="heading_title"><?php echo $heading_title; ?></h3><?php } ?>
          
 		<!--  Accordion -->
				<div class="elem_accordion plus_minus" data-type="accordion"> <!-- accordion - toggle -->
         <?php foreach ($categories as $category) {
                $category_active = ($category['content_id'] == $content_id)?'true':'';
          ?>
					<div class="elem_accordion_container" data-expanded="<?php echo $category_active;?>">
           <?php if ($category['level_1']) { ?>
						<span class="elem_accordion_title"><a href="<?php echo $category['href']; ?>"><i class="fa fa-angle-right"></i> <?php echo $category['name']; ?> </a></span>
                        
						<div class="elem_accordion_content">
							<div class="acc_content">
                <ul class="cat_list_widget">   
                  <?php foreach ($category['level_1'] as $level_1) {?>
                <li>
                    <a href="<?php echo $level_1['href']; ?>"><i class="fa fa-angle-right"></i> <?php echo $level_1['name']; ?> 
                    </a><?php echo $level_1['count']; ?>
              </li>
             <?php } ?>
                </ul>
							</div>
						</div>
        <?php }else{ ?>
        <a class="elem_accordion_title" href="<?php echo $category['href']; ?>"><i class="fa fa-angle-right"></i> <?php echo $category['name']; ?> </a>
          <?php } ?>
					</div><!-- elem_accordion_container--> 
        
                <?php } ?>
				</div>
				<!--Accordion -->


       
    </div>
 <?php } ?>