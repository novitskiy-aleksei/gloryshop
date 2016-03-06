<?php if ($modules) { ?>
    <div id="top_right" class="top_right <?php echo $ave->layout('top_right');?>">
        <?php foreach ($modules as $module) { ?>
        <?php echo $module; ?>
        <?php } ?>
    </div>
<?php } ?>