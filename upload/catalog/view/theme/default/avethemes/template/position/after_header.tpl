<?php if(!empty($modules)){?>
    <div class="section <?php echo $ave->layout('after_header');?> after_header clearfix">
            <?php foreach ($modules as $module) { ?>
            <?php echo $module; ?>
            <?php } ?>
    </div><!-- after-header--> 
<?php } ?>
<?php if(!empty($top_left)||!empty($top_right)){?>
   <div class="section <?php echo $ave->layout('top');?> clearfix">
   			<div class="content">
   			<div class="content_row">
                <?php echo $top_left; ?>
                <?php echo $top_right; ?>
           </div>
           </div>
    </div><!--top-left-right container --> 
<?php } ?>
<?php if(!empty($extra_top)){?>
    <div class="section <?php echo $ave->layout('extra_top');?> extra_top clearfix">
                <?php echo $extra_top; ?>
    </div><!--extra-top container --> 
<?php } ?>