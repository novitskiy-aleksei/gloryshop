<?php global $config; echo $header; ?><?php echo $column_left; ?>
<div id="content" class="ave_area">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
 
<?php global $ave; if ($ave->validate()==false) { ?>
  <div style="min-height:400px;"><div class="warning"><?php echo $text_error_register; ?></div></div>
<?php } ?>  
</div>
<?php echo $footer; ?>