<?php if ($modules) { ?>
<div id="bottom_left" class="bottom_left <?php echo $ave->layout('bottom_left');?>">
<?php foreach ($modules as $module) { ?>
<?php echo $module; ?>
<?php } ?>
</div>
<?php } ?>