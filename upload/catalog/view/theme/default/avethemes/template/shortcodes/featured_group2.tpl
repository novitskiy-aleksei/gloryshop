  <!-- Features Group-->
    <div class="section bg_fixed <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
           <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
            <div class=" content large_spacer ">
             <?php if(!empty($heading_title)){?>
                <div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
                    <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
                </div>
              <?php } ?>
              
             <?php if(!empty($description)){?>
             <div class="main_desc half_desc centered">
				<p><?php echo $description;?></p>
			</div>
              <?php } ?>
            
              <span class="spacer30"></span>
              
                 <?php  foreach ($sections as $section) {?>
                 <div class="feature_icon_slide">
                		<ul class="tree_features clearfix">
                                 <?php foreach ($section['column_left'] as $column) { ?>
                                 <li data-bgcolor="<?php echo $column['color'];?>">
                                        <span class="leaf_icon"><i class="<?php echo $column['icon'];?>"></i></span>
                                        <div class="leaf_con">
                                           <?php if(!empty($column['href'])){?>
                    <a class="tree_features_t" href="<?php echo $column['href'];?>" target="<?php echo $column['target'];?>"><?php echo (isset($column['title'][$language_id]))?html_entity_decode($column['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></a>
                                            <?php }else{ ?> 
                    <a class="tree_features_t"><?php echo (isset($column['title'][$language_id]))?html_entity_decode($column['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></a>
                                             <?php } ?> 
                                            <span class="tree_features_d"><?php echo (isset($column['desc'][$language_id]))?html_entity_decode($column['desc'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                                        </div>
                                    </li>
                                   <?php } ?>  
                             
                                 <?php foreach ($section['column_right'] as $column) { ?>
                                 <li data-bgcolor="<?php echo $column['color'];?>">
                                        <span class="leaf_icon"><i class="<?php echo $column['icon'];?>"></i></span>
                                        <div class="leaf_con">
                                           <?php if(!empty($column['href'])){?>
                    <a class="tree_features_t" href="<?php echo $column['href'];?>" target="<?php echo $column['target'];?>"><?php echo (isset($column['title'][$language_id]))?html_entity_decode($column['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></a>
                                            <?php }else{ ?> 
                    <a class="tree_features_t"><?php echo (isset($column['title'][$language_id]))?html_entity_decode($column['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></a>
                                             <?php } ?> 
                                            <span class="tree_features_d"><?php echo (isset($column['desc'][$language_id]))?html_entity_decode($column['desc'][$language_id], ENT_QUOTES, 'UTF-8'):'';?></span>
                                        </div>
                                    </li>
                                   <?php } ?>  
                        
                         
						</ul>
                     <div class="centered">
                        <img class="tree_features_parent" src="<?php echo !empty($section['image'])?'image/'.$section['image']:''?>" alt="<?php echo (isset($column['title'][$language_id]))?html_entity_decode($column['title'][$language_id], ENT_QUOTES, 'UTF-8'):'';?>" style="max-width:200px;">
                    </div>
               
                    <!--feature_icon_slide end-->
                    </div>
                    <?php } ?>
                   
                
            </div>
            </div>
    <!-- End Features Group -->