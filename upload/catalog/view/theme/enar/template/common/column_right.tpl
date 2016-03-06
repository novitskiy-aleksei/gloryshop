<?php global $ave;?>
<?php if ($modules){?>
<?php
if(defined('ave_check')){?>
    <div id="column-right" class="<?php echo $ave->layout('column_right');?> aside_title">
    <?php foreach ($modules as $module) {?>
    	<?php echo $module;?>
    <?php } ?>
    </div>
<?php }else{ ?>
    <column id="column-right" class="col-sm-3 hidden-xs">
      <?php foreach ($modules as $module) { ?>
      	<?php echo $module; ?>
      <?php } ?>
    </column>
<?php } ?>
<?php } ?>