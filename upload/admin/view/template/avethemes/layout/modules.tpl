<?php global $config; echo $header; ?>
<div id="content" class="form-horizontal">  
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-body layout-builder">         
          <div class="ds_accordion">
              <?php foreach ($extensions as $extension) { ?>
          		<div class="ds_heading"><i class="fa fa-bars"></i> <?php echo strip_tags($extension['name']); ?>
                <div class="btn-group">
                 <?php if($extension['add']){?>
                <a class="btn btn-xs btn-edit" href="<?php echo $extension['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($extension['name']); ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                <?php }else{?>
                <a class="btn btn-xs btn-edit" href="<?php echo $extension['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($extension['name']); ?>" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"><i class="fa fa-edit"></i></a>
                <?php } ?>
                </div> 
                </div>
                <div class="ds_content drag_area">
    <?php foreach ($extension['module'] as $module) { ?>       
                <div class="module-block" data-code="<?php echo $module['code']; ?>" data-title="<?php echo strip_tags($extension['name']); ?>">
               <span><?php echo strip_tags($module['name']); ?> </span>   
           <a class="btn btn-sm btn-edit" href="<?php echo $module['edit']; ?>"><i class="fa fa-edit" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"></i></a>   
           		</div>                 
    <?php } ?>   
                </div><!--ds_content --> 
              <?php } ?>                
          </div><!--//ds_accordion --> 
      </div>
    </div>
  </div>
</div>
<script>// Call template init (optional, but faster if called manually)
	$(document).ready(function() { 
		$('.drag_area>div').on('click', function() {
			var code = $(this).attr('data-code');
			var module_title = $(this).attr('data-title');
			var data_href = $(this).find('a').attr('href');
			var module_label = $(this).text();
			var position = '<?php echo $position;?>';
			parent.Layout.addModule(code,position,module_label,module_title,data_href);			
			parent.$('.modal-backdrop').hide(); 		
			parent.$('.modal-box').modal('hide');	
		});	
		$('#modal-iframe').contents().find('form').on('submit', function(event) {
			$('#modal-iframe').removeClass('loading');
		});
	});
</script>