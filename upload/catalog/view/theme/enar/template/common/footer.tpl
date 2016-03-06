<?php global $ave;?>
<?php if(defined('ave_check')){ ?>    
<?php if($ave->getConfig('ave_installed')){?>
<?php echo (!empty($custom_footer))?$custom_footer:''; ?>
<?php } ?>
<?php }?>
<!-- this is where we put our custom functions -->
<script type="text/javascript" src="assets/theme/js/theme_init.js"></script>
</body>
</html>