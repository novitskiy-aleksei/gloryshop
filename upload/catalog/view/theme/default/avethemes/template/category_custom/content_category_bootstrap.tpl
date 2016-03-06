<?php if($categories) {?>
    <div class="content_row">
          <?php if($heading_title){?><h3 class="heading_title"><?php echo $heading_title; ?></h3><?php } ?>
       <div class="list-group">
      <?php foreach ($categories as $category) { ?>
      <?php if ($category['content_id'] == $content_id) { ?>
      <a href="<?php echo $category['href']; ?>" class="list-group-item active"><?php echo $category['name']; ?></a>
      <?php if ($category['level_1']) { ?>
      <?php foreach ($category['level_1'] as $child) { ?>
      <?php if ($child['content_id'] == $child_id) { ?>
      <a href="<?php echo $child['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
      <?php } else { ?>
      <a href="<?php echo $child['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
      <?php } ?>
      <?php } ?>
      <?php } ?>
      <?php } else { ?>
      <a href="<?php echo $category['href']; ?>" class="list-group-item"><?php echo $category['name']; ?></a>
      <?php } ?>
      <?php } ?>
    </div>
    </div>
 <?php } ?>