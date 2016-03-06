<?php if($categories) {?>
    <div class="content_row">
          <?php if($heading_title){?><h3 class="heading_title"><?php echo $heading_title; ?></h3><?php } ?>
        <ul class="cat_list_widget">
         <?php foreach ($categories as $category) { ?>
             <li><a href="<?php echo $category['href']; ?>"><i class="fa fa-angle-right"></i> <?php echo $category['name']; ?> </a><?php echo $category['count']; ?></li>
          <?php } ?>
        </ul>
    </div>
 <?php } ?>