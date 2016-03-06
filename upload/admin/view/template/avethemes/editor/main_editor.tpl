<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="row">
        <div class="container-fluid">   
         <div class="back-btn">
       	<a href="<?php echo $cancel;?>" data-tooltip="left" title="<?php echo $button_cancel; ?>" class="btn btn-danger btn-xs"><i class="fa fa-reply"></i></a></div>
    	</div>         
        <div id="preview_frame">
                   <iframe id="iframe" frameborder="0" src="<?php echo $store_url;?>?<?php echo $url;?>"></iframe>
            </div>
        </div>
        <!--//container-fluid-->
    </div>
    <!--//row-->
</div>
<!--//content-->
<script>
jQuery(document).ready(function() {	
	$('a[data-tooltip=\'right\']').tooltip({container: 'body', html: true,placement: 'right'});
	$('a[data-tooltip=\'left\']').tooltip({container: 'body', html: true,placement: 'left'});
});
</script>
</body></html>