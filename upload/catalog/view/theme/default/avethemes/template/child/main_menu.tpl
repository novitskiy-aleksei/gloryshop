<?php 
global $ave;
$header_style= $ave->get('header_style');?>
<nav id="main_nav">
    <div id="menu_navigation">
        <span class="mobile_menu_toggler">
            <a href="#" class="nav_trigger"><span></span></a>
        </span>		
        <ul id="navigation" class="clearfix">
<?php if ($widgets) { ?>
  <?php foreach ($widgets as $widget) { ?>
  <?php echo $widget; ?>
  <?php } ?>
<?php } ?>
        </ul>
    </div>
</nav>
<!-- End Nav -->