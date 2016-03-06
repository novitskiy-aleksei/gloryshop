<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $heading_title; ?></title>
<base href="<?php echo $base; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<link href="view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
<style>
body{padding:20px 20px;}
.with-pagination>div{margin: 10px 0px;}
.with-pagination .pagination{margin: 0px 0px;}
</style>
</head>
<body>
  <div>
      <div class="row with-pagination">
        <div class="col-sm-2">
        <a href="<?php echo $parent; ?>" data-toggle="tooltip" title="<?php echo $button_parent; ?>" id="button-parent" class="btn btn-default"><i class="fa fa-level-up"></i></a>
        <a href="<?php echo $refresh; ?>" data-toggle="tooltip" title="<?php echo $button_refresh; ?>" id="button-refresh" class="btn btn-default"><i class="fa fa-refresh"></i></a>
        </div>
        <div class="col-sm-4">
          <div class="input-group">
            <input type="text" name="search" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_search; ?>" class="form-control">
            <span class="input-group-btn">
            <button type="button" data-toggle="tooltip" title="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </span></div>
        </div>
        <div class="col-sm-6 text-right">
        <?php echo $pagination; ?>
        </div>
      </div>
      <hr />
      <?php foreach (array_chunk($images, 4) as $image) { ?>
      <div class="row">
        <?php foreach ($image as $image) { ?>
        <div class="col-sm-3 text-center">
          <?php if ($image['type'] == 'directory') { ?>
          <div class="text-center"><a href="<?php echo $image['href']; ?>" class="directory" style="vertical-align: middle;"><i class="fa fa-folder fa-5x"></i></a></div>
          <label>
            <input type="hidden" value="<?php echo $image['path']; ?>" />
            <?php echo $image['name']; ?></label>
          <?php } ?>
          <?php if ($image['type'] == 'image') { ?>
          <a href="<?php echo $image['href']; ?>" class="thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></a>
          <label>
            <input type="hidden" value="<?php echo $image['path']; ?>" />
            <?php echo $image['name']; ?></label>
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <br />
      <?php } ?>
       </div> 
  
<script type="text/javascript"><!--
$(document).ready(function() {
	// tooltips on hover
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});
		
		$('a.thumbnail').on('click', function(e) {
			e.preventDefault();
				   var $value = $(this).parent().find('input').attr('value');
				   var $src = $(this).find('img').attr('src');
		
			<?php if ($field) { ?>
					parent.$('#<?php echo $field;?>').val($value);
					var $input = parent.$('#<?php echo $field;?>');
					var obj_selector=$input.attr('data-selector');
					var obj_attr=$input.attr('data-attr');		
					if(obj_selector!=null&&obj_attr!='src'&&obj_attr!=null){
						parent.$("#preview_frame iframe").contents().find(obj_selector).css(obj_attr,'url(image/'+$value+')');	
					}
			<?php } ?>
			
			<?php if ($thumb) { ?>
			parent.$('#<?php echo $thumb; ?>>img').attr('src', $src);
			<?php } ?>
			<?php if (!empty($previewsrc)){ ?>
						parent.$('#<?php echo $previewsrc;?>').replaceWith('<img src="' + $value + '" alt="" id="<?php echo $previewsrc; ?>" />');<?php } ?>
			parent.$('#modal-image-editor').modal('hide');
		});
		
		$('a.directory').on('click', function(e) {
			e.preventDefault();
			
			$('body').load($(this).attr('href'));
		});
		
		$('.pagination a').on('click', function(e) {
			e.preventDefault();
			
			$('body').load($(this).attr('href'));
		});
		
		$('#button-parent').on('click', function(e) {
			e.preventDefault();
			
			$('body').load($(this).attr('href'));
		});
		
		$('#button-refresh').on('click', function(e) {
			e.preventDefault();
			
			$('body').load($(this).attr('href'));
		});
		
		$('#button-search').on('click', function() {
			var url = 'index.php?route=ave/image_manager_plus/filemanager&token=<?php echo $token; ?>&directory=<?php echo $directory; ?>';
				
			var filter_name = $('input[name=\'search\']').val();
			
			if (filter_name) {
				url += '&filter_name=' + encodeURIComponent(filter_name);
			}
			
			<?php if ($field) { ?>
			url += '&field=' + '<?php echo $field; ?>';
			<?php } ?>
									
			<?php if ($thumb) { ?>
			url += '&thumb=' + '<?php echo $thumb; ?>';
			<?php } ?>
					
			$('body').load(url);
		});
});
//--></script> 
</body>
</html>