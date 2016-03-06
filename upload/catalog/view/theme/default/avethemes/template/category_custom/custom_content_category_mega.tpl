<div class="box <?php echo $mobile_visible;?> with-shadow">
<?php if($heading_title){?><div class="box-heading with-bg fill-bg"><div><i class="fa fa-bars"></i> <?php echo $heading_title; ?></div></div><?php } ?>
    <div class="box-content">
<ul class="sidebar-menu list-group vertical-mega-menu">
  <?php foreach ($categories as $category) { 
  $icon = ($show_icon)?'<i class="menu-icon '.$category['icon'].'"></i>':'';
  $vcolumn = 'vcolumn-'.$category['vcolumn'];
  $arrow = ($category['level_1'])?' <i class="fa fa-angle-right"></i>':'';
  $active_class = ($category['content_id'] == $content_id)?'active':'';
  ?>
  
    <li class="<?php echo $active_class;?>"><a href="<?php echo $category['href']; ?>" class="vview" data-id="vcate<?php echo $category['content_id']; ?>"><?php echo $icon;?> <?php echo $category['name']; ?> <?php echo $category['count']; ?> <?php echo $arrow;?></a>
    
      <?php if ($category['level_1']) { ?>
      <div class="mega-menu <?php echo $vcolumn;?> <?php if($show_thumb){?>with-preview<?php } ?>">
      	<div class="clearfix">
          <?php if($show_thumb){?>
          <!-- header-navigation-preview--> 
          <div class="header-navigation-preview">
                            <div class="navigation-preview">         
                            <div class="gallery-item vcate<?php echo $category['content_id']; ?>" data-relate="vcate<?php echo $category['content_id']; ?>">
                             <a href="<?php echo $category['href']; ?>"><img src="assets/global/img/dot.png" data-src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['name']; ?>" class="img-responsive lazyload"/></a>
                                <p class="category_name"><a href="<?php echo $category['href']; ?>"><?php echo $category['description']; ?></a></p>
                            </div>     
                              <?php if ($category['level_1']) { ?>
                           <?php foreach ($category['level_1'] as $level_1) { ?>
                                     <div class="gallery-item vcate<?php echo $level_1['content_id']; ?>" data-relate="vcate<?php echo $level_1['content_id']; ?>">
                                        <a href="<?php echo $level_1['href']; ?>"><img src="assets/global/img/dot.png" data-src="<?php echo $level_1['thumb']; ?>" alt="<?php echo $level_1['name']; ?>" class="img-responsive lazyload"/></a>
                                        <p class="category_name"><a href="<?php echo $level_1['href']; ?>"><?php echo $level_1['description']; ?></a></p>
                                     </div>
                                     <?php if ($level_1['level_2']) { ?>
                                               <?php foreach ($level_1['level_2'] as $level_2) { ?>
                                                         <div class="gallery-item vcate<?php echo $level_2['content_id']; ?>" data-relate="vcate<?php echo $level_2['content_id']; ?>">
                                                            <a href="<?php echo $level_2['href']; ?>"><img src="assets/global/img/dot.png" data-src="<?php echo $level_2['thumb']; ?>" alt="<?php echo $level_2['name']; ?>" class="img-responsive lazyload"/></a>
                                                            <p class="category_name"><a href="<?php echo $level_2['href']; ?>"><?php echo $level_2['description']; ?></a></p>
                                                         </div>
                                               <?php } ?>  
                                        <?php } ?>
                           <?php } ?>  
                    <?php } ?>                     
                       </div><!--//navigation-preview --> 
          </div>
          <!--/header-navigation-preview --> 
          <?php } ?>                     
          <div class="content_row">
          <h4 class="top_parent vview" data-id="vcate<?php echo $category['content_id']; ?>"><?php echo $category['name']; ?></h4>
        <ul>
          <?php foreach ($category['level_1'] as $level_1) {
          $third_parent = ($level_1['level_2'])?'third_parent':'';
          ?>
              <li>
                <ul>
                  <li class="<?php echo $third_parent;?>"><a href="<?php echo $level_1['href']; ?>" class="vview vcate<?php echo $level_1['content_id']; ?>" data-id="vcate<?php echo $level_1['content_id']; ?>"><?php echo $level_1['name']; ?> <?php echo $level_1['count']; ?></a></li>
            <?php if($level_1['level_2']) { ?>
                  <?php foreach ($level_1['level_2'] as $level_2) { ?>
                    <li><a class="vview vcate<?php echo $level_2['content_id']; ?>" href="<?php echo $level_2['href']; ?>" data-id="vcate<?php echo $level_2['content_id']; ?>"><i class="fa fa-angle-right"></i> <?php echo $level_2['name'] ?>  <?php echo $level_2['count']; ?></a></li>
                  <?php } ?>
            <?php } ?>
                </ul>
              </li>
            <?php } ?>
        </ul>
        </div><!-- //row--> 
        </div><!-- //clearfix--> 
        </div>
      <?php } ?>
    </li> 
  <?php } ?>
</ul>
  </div>
</div>