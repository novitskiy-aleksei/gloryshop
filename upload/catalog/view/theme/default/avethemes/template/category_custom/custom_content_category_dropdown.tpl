<?php if($categories) { ?>
<div class="box <?php echo $mobile_visible;?> with-shadow">
      <?php if($heading_title){?><div class="box-heading with-bg fill-bg"><div><i class="fa fa-bars"></i> <?php echo $heading_title; ?></div></div><?php } ?>
    <div class="box-content">
    <div class="box-category">
    <ul class="list-group sidebar-menu">
     <?php foreach ($categories as $category) { ?>
              <?php
                $dropdown_li=($category['level_1'])?'dropdown':' ';
                $dropdown_angle=($category['level_1'])?'<i class="fa fa-angle-down"></i>':' '; 
                $dropdown_u=($category['content_id'] == $content_id)?'display:block;':' ';
                
                ?>
                <?php 
                $category_active = ($category['content_id'] == $content_id)?'active':'';
                $link_active = ($category['content_id'] == $content_id)?'collapsed':'';
                 ?>
                <li class="list-group-item dropdown <?php echo $category_active;?> <?php echo $dropdown_li;?>"><a href="<?php echo $category['href']; ?>" class="<?php echo $link_active;?>"><i class="fa fa-angle-right"></i><?php echo $category['name']; ?><?php echo $dropdown_angle;?> <?php echo $category['count']; ?></a>
                <?php if ($category['level_1']) { ?>
                <ul class="dropdown-menu" style="<?php echo $dropdown_u;?>">                  
                  <?php foreach ($category['level_1'] as $level_1) {?>
                    <?php
                     $li_1_active= ($level_1['content_id'] == $child_id)?'active':''; 
                     $link_1_active= ($level_1['content_id'] == $child_id)?'collapsed':''; 
                     $child_1_active= ($level_1['content_id'] == $child_id)?'active':''; 
                    ?>
     	<?php $level_1_with_angle_down =($level_1['level_2'])?'<i class="fa fa-angle-down"></i>':''; ?>
            <li class="list-group-item dropdown <?php echo $li_1_active;?>">
                <a href="<?php echo $level_1['href']; ?>" class="<?php echo $link_1_active;?>"> <i class="fa fa-angle-right"></i><?php echo $level_1['name']; ?> 
                <?php echo $level_1_with_angle_down;?>
                <?php echo $level_1['count']; ?>
                </a> 
                    <?php if ($level_1['level_2']) { ?> 
                          <ul class="dropdown-menu <?php echo $child_1_active;?>">
                          <?php foreach ($level_1['level_2'] as $level_2) {?> 
                                 <?php
                                     $li_2_active= ($level_2['content_id'] == $child_2_id)?'active':''; 
                                     $link_2_active= ($level_2['content_id'] == $child_2_id)?'collapsed':''; 
                                     $child_2_active= ($level_2['content_id'] == $child_2_id)?'active':''; 
                                    ?>
                          		<?php $level_2_with_class =($level_2['level_3'])?'list-group-item dropdown':'';  ?>
                          		<?php $level_2_with_angle_down =($level_2['level_3'])?'<i class="fa fa-angle-down"></i>':'';  ?>
                                <li class="<?php echo $level_2_with_class;?> <?php echo $li_2_active;?> ">
                                    <a href="<?php echo $level_2['href']; ?>">
                                    <i class="fa fa-angle-right"></i><?php echo $level_2['name']; ?> 
                                    <?php echo $level_2_with_angle_down;?>
                                    <?php echo $level_2['count']; ?>
                                    </a> 
                                        <?php if ($level_2['level_3']) { ?> 
                                        
                                              <ul class="dropdown-menu <?php echo $child_2_active;?>">
                                              <?php foreach ($level_2['level_3'] as $level_3) {?> 
                                              <?php
                                                 $li_3_active= ($level_3['content_id'] == $child_3_id)?'active':''; 
                                                ?>
                                                <li class="<?php echo $li_3_active;?>"><a href="<?php echo $level_3['href']; ?>"><i class="fa fa-angle-right"></i><?php echo $level_3['name']; ?> <?php echo $level_3['count']; ?></a></li>
                                                <?php } ?>
                                              </ul>
                                        <?php } ?>
                              </li>
                          
                            <?php } ?>
                          </ul>
                    <?php } ?>
          </li>
      <?php } ?>
                </ul>
                <?php } ?>
              </li>
      <?php } ?>
    </ul>
  </div>
  </div>
</div>
 <?php } ?>