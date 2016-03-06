<?php if ($modules) { ?>
    <div id="top_left" class="top_left <?php echo $ave->layout('top_left');?>">
        <?php foreach ($modules as $module) { ?>
        <?php echo $module; ?>
        <?php } ?>
    </div>
<?php } ?>