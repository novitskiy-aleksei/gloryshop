<?php global $ave;
 echo $header; ?>
<div class="section">
  <div class="content clearfix">
<div class="content_row clearfix">
<?php echo $column_left; ?>
        <div id="content" class="<?php echo $ave->layout('content');?>">
        <?php echo $content_top; ?><?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div><!-- //content row--> 
    </div><!-- //content spacer--> 
</div><!-- //main section--> 
<?php echo $footer; ?>