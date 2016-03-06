<?php $custom_js_status = $ave->get('custom_js_status');?>
<?php echo ($custom_js_status==1)?html_entity_decode($ave->get('custom_js')):'';?>