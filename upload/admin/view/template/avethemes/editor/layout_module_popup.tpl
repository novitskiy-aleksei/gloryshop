<?php global $config; 
echo $header;?>
<div id="content" class="form-horizontal">  
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-body layout-builder"> 
      <div class="ds_accordion">
              <?php foreach ($extensions as $module) { ?>
          		<div class="ds_heading"><i class="fa fa-puzzle-piece"></i> <?php echo strip_tags($module['name']); ?>
                <div class="btn-group">
                 <?php if($module['add']){?>
                <a class="btn btn-xs btn-edit" href="<?php echo $module['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($module['name']); ?>" data-toggle="tooltip" title="<?php echo $text_add_module;?>"><i class="fa fa-plus"></i></a>
                <?php }else{?>
                <a class="btn btn-xs btn-edit" href="<?php echo $module['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($module['name']); ?>" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"><i class="fa fa-edit"></i></a>
                <?php } ?>
                </div> 
                </div>
                <div class="ds_content drag_area">
    <?php foreach ($module['module'] as $module) { ?>       
                <div class="module-block" data-code="<?php echo $module['code']; ?>">
               <span><i class="fa fa-th-list"></i> <?php echo strip_tags($module['name']); ?></span>
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

<script>
// Call template init (optional, but faster if called manually)
$(document).ready(function() { 
	$('.drag_area>div').on('click', function() {
		var code = $(this).attr('data-code');
		var data_href = $(this).find('a').attr('href');
		var module_label = $(this).text();
		var position = '<?php echo $position;?>';
		parent.MCP.addModule(code,position,module_label,data_href);			
		parent.$('.modal-backdrop').hide(); 		
		parent.$('.modal-box').modal('hide');	
	});	
	$('#modal-iframe').contents().find('form').on('submit', function(event) {
		$('#modal-iframe').removeClass('loading');
	});
	$(document).on('click', '.modulebox', function(event) {
            event.preventDefault();
            var data_href = $(this).attr('href');
            $('#modal-iframe').attr('src',data_href);
                $('#module-modal').modal('show');
    });
	$('#modal-iframe').on('load', function(event) {	
			event.preventDefault();
			var iframe = $('#modal-iframe');
			var current_url = document.getElementById("modal-iframe").contentWindow.location.href;

			iframe.contents().find('[href]').on('click', function(event) {
				iframe.addClass('loading');
			});

			iframe.contents().find('form').on('submit', function(event) {
				iframe.addClass('loading');
			});
			if (current_url.indexOf('extension/module') > -1) {
					 $('#module-modal').modal('hide');
					$('body').removeClass('modal-open');
					iframe.removeClass('loading');
			} else {
				iframe.contents().find('html,body').css({height: 'auto'});
				iframe.contents().find('#header,#content .page-header .breadcrumb,#column-left,#footer').hide();
				iframe.contents().find('body').addClass('modulebox');
				iframe.contents().find('#content').css({padding: '10px 0 0 0',margin: '0 0 0 0'});
				iframe.removeClass('loading');
			}
	});	
});/**/ 
</script>