<?php if($modules) { ?>
        <div class="pre_header <?php echo $ave->layout('pre_header');?> clearfix">
            <?php foreach ($modules as $module) { ?>
            <?php echo $module; ?>
            <?php } ?>
        </div>
<?php } ?>