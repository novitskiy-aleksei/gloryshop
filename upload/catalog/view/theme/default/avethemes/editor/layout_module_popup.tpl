<?php global $config; 
echo $header;?>
<div id="content" class="form-horizontal">  
  <div class="container-fluid" style="padding-top:15px;">
    <div class="panel panel-default">
      <div class="panel-body layout-builder"> 
      <div class="ds_accordion">
              <?php foreach ($extensions as $module) { ?>
          		<div class="ds_heading"> <?php echo strip_tags($module['name']); ?>
                <div class="btn-group">
                 <?php if($module['add']){?>
                <a class="btn btn-xs btn-edit" data-href="<?php echo $module['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($module['name']); ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                <?php }else{?>
                <a class="btn btn-xs btn-edit" data-href="<?php echo $module['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($module['name']); ?>" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"><i class="fa fa-edit"></i></a>
                <?php } ?>
                </div> 
                </div>
                <div class="ds_content drag_area">
    <?php foreach ($module['module'] as $module) { ?>       
                <div class="module-block" data-code="<?php echo $module['code']; ?>">
               <span data-code="<?php echo $module['code']; ?>" data-title="<?php echo strip_tags($module['title']); ?>"> <?php echo strip_tags($module['name']); ?></span>
           <a class="btn btn-sm btn-edit" data-href="<?php echo $module['edit']; ?>"><i class="fa fa-edit" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"></i></a>   
           		</div>                 
    <?php } ?>   
                </div><!--ds_content --> 
              <?php } ?>                
          </div><!--//ds_accordion --> 
      </div>
    </div>
  </div>
</div>

<script>
// Call template init (optional, but faster if called manually)
$(document).ready(function() { 
	$('.drag_area>div>span').on('click', function() {
		var code = $(this).attr('data-code');
		var data_href = $(this).next('a').attr('data-href');
		var module_title = $(this).attr('data-title');
		var module_label = $(this).text();
		var position = '<?php echo $position;?>';
		parent.MCP.addModule(code,position,module_title,module_label,data_href);	
		localStorage.setItem('data_position',null);
		parent.$('.modal-backdrop').hide(); 		
		parent.$('.modal-box').modal('hide');	
	});
});/**/ 
</script>