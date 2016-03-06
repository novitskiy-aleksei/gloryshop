<?php if(!empty($extra_bottom)){?>
    <div class="section <?php echo $ave->layout('extra_bottom');?> extra_bottom clearfix">
                <?php echo $extra_bottom; ?>
    </div><!--extra-top container --> 
<?php } ?>
<?php if(!empty($bottom_left)||!empty($bottom_right)){?>
    <div class="section <?php echo $ave->layout('bottom');?> clearfix">
    	<div class="content">
    	<div class="content_row">
            <?php echo $bottom_left; ?>
            <?php echo $bottom_right; ?>
            </div>
            </div>
    	</div><!--extra-top container --> 
<?php } ?>
<?php if(!empty($modules)){?>
    <div class="section <?php echo $ave->layout('pre_footer');?> pre_footer clearfix">
                <?php foreach ($modules as $module) { ?>
                <?php echo $module; ?>
                <?php } ?>
    </div><!-- pre_footer--> 
<?php } ?>