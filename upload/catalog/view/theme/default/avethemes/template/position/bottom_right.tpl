<?php if ($modules) { ?>
<div id="bottom_right" class="bottom_right <?php echo $ave->layout('bottom_right');?>">
<?php foreach ($modules as $module) { ?>
<?php echo $module; ?>
<?php } ?>
</div>
<?php } ?>