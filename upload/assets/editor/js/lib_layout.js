var Layout = function () {	
	var token = getURLVar('token');
	var text_confirm = 'Are you sure?';
	var text_edit = 'Edit module';
	 // initializes main settings
    var handleInit = function() {    
		Layout.handleDraggable();
		modulesBarHeight = parseInt($('.drop_area').height());	
		$('.module_list').height(modulesBarHeight-20);	
		$(document).on('click', '#edit_layout', function(event) {
				event.preventDefault();
				$('#layout-modal').modal('show');
		});
		$(document).on('click', '#edit_setting', function(event) {
				event.preventDefault();
				$('#layout-setting').modal('show');
		});
		$(document).on('click', '.btn-edit', function(event) {
				event.preventDefault();
				var iframe = $('#modal-iframe');
				iframe.addClass('loading');
				var data_href = $(this).attr('href');
				$('#modal-iframe').attr('src',data_href);
					$('#module-modal').modal('show');
				iframe.removeClass('loading');
		});
		$(document).on('click', '.btn-remove', function(event) {
				event.preventDefault();
					$(this).parents('.mblock').remove();
					Layout.apply();
		});
    };
	
    return {
		refresh_module_list: function (){
			$.ajax({
				url: 'index.php?route=feed/visual_layout_builder/module_refresh&token='+token,
				dataType: 'html',		
				success: function(html) {
					$('.module_accordion').html(html);
					Plus.handleAccordion();
					Layout.handleDraggable();
					Layout.handleThumbview();
				}
			});
		},
		apply:function (){
			$.ajax({
					url: 'index.php?route=feed/visual_layout_builder/apply&token='+token,
					type: 'post',
					dataType: 'json',
					data: $('#form-buildlayout input[type=\'text\'], #form-buildlayout input[type=\'hidden\'], #form-buildlayout input[type=\'radio\']:checked, #form-buildlayout input[type=\'checkbox\']:checked, #form-buildlayout select, #form-buildlayout textarea'),
					beforeSend: function() {
					},
					complete: function() {					
					},
					success: function(json) {				
						if (json['error']) {
								$('.message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						} 
						if (json['success']) {	
							$('.message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i>' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');					
							
						}
						if (json['redirect']) {
							location = json['redirect'];
						}	
					}
				});
		},
		saveOption:function (){
			$.ajax({
				url: 'index.php?route=feed/visual_layout_builder/saveoption&token='+token,
				type: 'post',
				dataType: 'json',
				data: $('#layout-setting input[type=\'text\'], #layout-setting input[type=\'hidden\'], #layout-setting input[type=\'radio\']:checked, #layout-setting input[type=\'checkbox\']:checked, #layout-setting select, #layout-setting textarea'),
				beforeSend: function() {
				},
				complete: function() {					
				},
				success: function(json) {				
					if (json['error']) {
							$('.message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					} 
					if (json['success']) {	
						$('.message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i>' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');					
						
					}
					if (json['redirect']) {
						location = json['redirect'];
					}	
				}
			});
		},
		handleDraggable: function() {			
			$(".module-block").draggable({
				appendTo: document.body,
				helper: "clone",
				cursor: "move",
				zIndex: 9999,
				cancel: '.btn-remove, .btn-edit',
				stop: function( event, ui ) {},
				distance: 2,
				cursorAt: {
					left: 10,
					top: 10
				}
			});
			 $(".dashed").droppable({
				activeClass: "activeDroppable",
				hoverClass: "hoverDroppable",
				tolerance: "pointer",
				forceHelperSize: false,
				forcePlaceholderSize: false,
				accept: ".module-block",
				cancel: '.btn-remove, .btn-edit',
				drop: function(event, ui) {
					var ui_elem = this;
						var data_sort = 0;
					var data_code = $(ui.draggable).attr("data-code");
					var data_title = $(ui.draggable).attr("data-title");
					var data_position = $(ui_elem).attr("data-position");
					var data_index = $('#data_index').attr("data-index");
					var text_edit = $('#module_list').attr("data-text-edit");
					
						if(data_code!='0'){
								var success = true;
								var data_href = $(ui.draggable).find('a').attr("href");
								data_sort = $(ui_elem).find('.mblock').length;
								var html = '<div class="mblock" data-code="'+data_code+'">';
								html += '<div class="module_label">'+data_title+'</div>';
								html += '<div class="btn-group">';
								html += '<a class="btn btn-xs btn-edit" href="'+data_href+'" data-toggle="tooltip" title="'+text_edit+'"><i class="fa fa-edit"></i> '+ui.draggable.text()+'</a>';
								html += '<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>';
								html += '</div>';
								html += '<input type="hidden" name="layout_module['+data_index+'][code]" value="'+data_code+'"/>';
								html += '<input type="hidden" name="layout_module['+data_index+'][position]" class="layout_position" value="'+data_position+'"/>';
								html += '<input type="hidden" name="layout_module['+data_index+'][sort_order]" value="'+(parseInt(data_sort)+1)+'" class="sort"/>';
								html += '</div>';
								$(".drop_area").find(ui.draggable).remove();
								$(ui_elem).append(html);
								$('#data_index').attr("data-index",parseInt(data_index)+1);
								Layout.apply();
								$('#modal-iframe').attr('src',data_href);
								$('#module-modal.show_module_option').modal('show');
				
						}else{
							var quick_href = $(ui.draggable).attr("data-href");
							$.ajax({
								url: quick_href,
								type: 'post',
								dataType: 'json',
								data: 'status=true',
								success: function(json) {	
										if (json['error']) {
											var success = false;	
											$('.message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
										} 
										if (json['success']) {	
											var success = true;
											$('.message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i>' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');	
											 data_code = json['code'];
											 data_href = json['href'];
											 data_text = json['text'];
											data_sort = $(ui_elem).find('.mblock').length;
											var html = '<div class="mblock" data-code="'+data_code+'">';
											 html += '<div class="module_label">'+data_title+'</div>';
											html += '<div class="btn-group">';
											html += '<a class="btn btn-xs btn-edit" href="'+data_href+'" data-toggle="tooltip" title="'+text_edit+'"> '+data_text+'</a>';
											html += '<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>';
											html += '</div>';
											html += '<input type="hidden" name="layout_module['+data_index+'][code]" value="'+data_code+'"/>';
											html += '<input type="hidden" name="layout_module['+data_index+'][position]" class="layout_position" value="'+data_position+'"/>';
											html += '<input type="hidden" name="layout_module['+data_index+'][sort_order]" value="'+(parseInt(data_sort)+1)+'" class="sort"/>';
											html += '</div>';
											
											$(".drop_area").find(ui.draggable).remove();
											$(ui_elem).append(html);
											$('#data_index').attr("data-index",parseInt(data_index)+1);
											Layout.apply();
											$('#modal-iframe').attr('src',data_href);
											$('#module-modal.show_module_option').modal('show');
											
										}
								}
							});
						}
					
			
				}
			}).sortable({
				appendTo: document.body,
				helper: "clone",
				placeholder: "mblock sortable-place-holder",
				zIndex: 10000,
				tolerance: "pointer",
				dropOnEmpty: true,
				connectWith: ".dashed",
				items: ".mblock",
				forceHelperSize: false,
				forcePlaceholderSize: false,
				cancel: '.btn-edit, .btn-remove',
				distance: 2,
				update: function( event, ui ) {		
						$(this).find('.layout_position').attr("value",$(this).attr("data-position"));	
						var sort_order = 0;
						 $(this).find('.mblock').each(function() {    
							sort_order += 1;       
							$(this).find('input.sort').attr('value',sort_order);
						});		
						Layout.apply();
					},
				cursorAt: {
					left: 10,
					top: 10
				}
			}).disableSelection();
		},
		addModule:function(code,position,module_label,module_title,data_href){
			var data_index = $('#data_index').attr("data-index");
			var html = '<div class="mblock" data-code="'+code+'">';
			var text_edit = $('#module_list').attr("data-text-edit");

			html += '<div class="module_label">'+module_title+'</div>';
			html += '<div class="btn-group">';
			html += '<a class="btn btn-xs btn-edit" href="'+data_href+'" data-toggle="tooltip" title="'+text_edit+'"><i class="fa fa-edit"></i> '+module_label+'</a>';
			html += '<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>';
			html += '</div>';
			html += '<input type="hidden" name="layout_module['+data_index+'][code]" value="'+code+'"/>';
			html += '<input type="hidden" name="layout_module['+data_index+'][position]" class="layout_position" value="'+position+'"/>';
			html += '<input type="hidden" name="layout_module['+data_index+'][sort_order]" value="999" class="sort"/>';
			html += '</div>';
			$('div[data-position=\''+position+'\']').append(html);
			Layout.apply();
		},
		 handleThumbview:function() {
			/* CONFIG */
				
				xOffset = -30;
				yOffset = -30;
				
				// these 2 variable determine popup's distance from the cursor
				// you might want to adjust to get the right result
				
			/* END CONFIG */
			$(".module_list .module-block").hover(function(e){
				this.t = $(this).text();
				var c = (this.t != "") ? "<br/>" + this.t : "";
				var thumb = $(this).attr('data-thumb');
				if(typeof thumb != 'undefined' && thumb != null){
					$("body").append("<p id='thumb-preview'><img src='"+ thumb +"' alt='Thumb preview' /><span>"+ c +"<span></p>");								 
					$("#thumb-preview").css({"top":(e.pageY - xOffset) + "px","left":(e.pageX + yOffset) + "px"}).fadeIn("fast");	
				}					
			},
			function(){
				$("#thumb-preview").remove();
			});	
			$(".module-block").mousemove(function(e){
				$("#preview")
					.css("top",(e.pageY - xOffset) + "px")
					.css("left",(e.pageX + yOffset) + "px");
			});			
		 },
        init: function () {
            // init core variables
			handleInit();
			Layout.handleThumbview();
        }

    };//return
}();
$(document).ready(function() {
        $('#modal-iframe').on('load', function(event) {
            event.preventDefault();		
            var iframe = $('#modal-iframe');
            iframe.addClass('loading');
            var current_url = document.getElementById("modal-iframe").contentWindow.location.href;

            iframe.contents().find('[href]').on('click', function(event) {
                iframe.addClass('loading');
            });

            iframe.contents().find('form').on('submit', function(event) {
                iframe.addClass('loading');
            });
            if (current_url.indexOf('extension/module') > -1) {
				Layout.refresh_module_list();
                $('#module-modal').modal('hide');               
            } else {
                iframe.addClass('loading');
                iframe.contents().find('#header,#content .page-header .breadcrumb,#column-left,#footer').hide();
                iframe.contents().find('#content').css({ padding: '10px 0 0 0',margin: '0 0 0 0'});
               	iframe.removeClass('loading');
            }
        });
});