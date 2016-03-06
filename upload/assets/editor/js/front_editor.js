
// Autocomplete */
(function($) {
	$.fn.auto_complete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();
	
			$.extend(this, option);
	
			$(this).attr('autocomplete', 'off');
			
			// Focus
			$(this).on('focus', function() {
				this.request();
			});
			
			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);				
			});
			
			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}				
			});
			
			// Click
			this.click = function(event) {
				event.preventDefault();
	
				value = $(event.target).parent().data('value');
	
				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}
			
			// Show
			this.show = function() {
				var pos = $(this).position();
			}
			
			// Hide
			this.hide = function() {
			}		
			
			// Request
			this.request = function() {
				clearTimeout(this.timer);
		
				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}
			
			// Response
			this.response = function(json) {
				html = '';
	
				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}
	
					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}
	
					// Get all the ones with a categories
					var category = new Array();
	
					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}
	
							category[json[i]['category']]['item'].push(json[i]);
						}
					}
	
					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';
	
						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}
	
				if (html) {
					this.show();
				} else {
					this.hide();
				}
	
				$(this).siblings('ul.dropdown-menu').html(html);
			}
			
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));	
			
		});
	}
})(window.jQuery);

var MCP = function () {	
    // IE mode
    var isRTL = false;
    var isIE8 = false;
    var isIE9 = false;
    var isIE10 = false;
	var doc = document;
	var $body=$('body');

	var ajax_registry = new Array('carousel_autoplay','carousel_autoplay','carousel_limit','grid_limit','text_align','heading_title','text_transform','border_radius','block_shadow','box_shadow','bg_position','bg_repeat','bg_size','bg_attachment','column_position','setfont','font_weight','font_style','set_overcolor','setcolor','setbgcolor','flang','tlang','section_class');
	
	var languages_query='index.php?route=avethemes/editor/syslang';
	var lquery='index.php?route=avethemes/editor/lquery';
	var no_image = 'image/no_image.png';
	var label_column_left ='Column Left';
	var label_column_right='Column Right';
	var label_main_content='Main Content';
	var text_edit = 'Edit module';
	var editor_css ={
	  "custom_footer_css": "assets/editor/css/custom_footer.css",
	  "summernote_css": "admin/view/javascript/summernote/summernote.css",
	  "chosen_css": "assets/editor/plugins/jquery-chosen/chosen.css",
	  "slider_css": "assets/editor/css/slider.css",
	  "spectrum_css": "assets/editor/plugins/spectrum/spectrum.css"
	}
	var editor_js ={
	  "custom_footer_js": "assets/editor/js/custom_footer.js",
	  "summernote_js": "admin/view/javascript/summernote/summernote.js",
	  "chosen_js": "assets/editor/plugins/jquery-chosen/chosen.js",
	  "spectrum_js": "assets/editor/plugins/spectrum/spectrum.js",
	  "ace_js": "assets/editor/plugins/code_editor/ace.js"
	}
				
 	var resizeHandlers = [];
	/*GENERAL HANDLE*/ 
	var _runResizeHandlers = function() {
        // reinitialize other subscribed elements
        for (var i = 0; i < resizeHandlers.length; i++) {
            var each = resizeHandlers[i];
            each.call();
        }
    };
	// handle the layout reinitialization on window resize
    var handleOnResize = function() {
        var resize;
        if (isIE8) {
            var currheight;
            $(window).resize(function() {
                if (currheight == document.documentElement.clientHeight) {
                    return; //quite event since only body resized not window.
                }
                if (resize) {
                    clearTimeout(resize);
                }
                resize = setTimeout(function() {
                    _runResizeHandlers();
                }, 50); // wait 50ms until window resize finishes.                
                currheight = document.documentElement.clientHeight; // store last body client height
            });
        } else {
            $(window).resize(function() {
                if (resize) {
                    clearTimeout(resize);
                }
                resize = setTimeout(function() {
                    _runResizeHandlers();
                }, 50); // wait 50ms until window resize finishes.
            });
        }
    };							
	/*EDITOR HANDLE*/ 
	var handleDataSet = function() {
        if ($body.css('direction') === 'rtl') {
            isRTL = true;
        }
		if($('#body_elem').length){/**/ 
			 $.each(editor_css, function(css_id, css_url ) {
				$('head #'+css_id).remove();
				$('head').append('<l'+'ink href="'+css_url+'" id="'+css_id+'" rel="stylesheet" type="text/css">');	
			  });
			 $.each(editor_js, function(js_id, js_url ) {
				$('head #'+js_id).remove();
				$('head').append('<sc'+'ript src="'+js_url+'" id="'+js_id+'" type="text/javascript"></sc'+'ript>');	
			  });
			
		var frontend_status =  $('.design_content-toggler').data('status');
		var editor_status = true;
		if(self!==top){
			var parentsrc = String(window.parent.location);
   			if (parentsrc.indexOf('ave/skin')!= -1||parentsrc.indexOf('visual_layout_builder')!= -1) {
				editor_status = false;
			 	$('.design_content-toggler.top').remove();
			}
			if (parentsrc.indexOf('ave/skin/editor')!= -1) {
				editor_status = true;
			}
		}
		if(self==top&&frontend_status==false){
			editor_status = false;
			 $('.design_content-toggler.top').remove();
		}
		if(editor_status == true){	
			var date=new Date();
			$.ajax({
				url: 'index.php?route=avethemes/editor/editor&current_time=' + date.getTime(),
				type: 'get',
				dataType: 'html',
				beforeSend: function() {
				},
				success: function(html) {
					$('body').append(html);
					handleFormData();	
				},
				complete: function() {
					
			if (localStorage.getItem('data_action')!==null){
				data_action = localStorage.getItem('data_action');
				$('#editor-menu ul li').removeClass('active');
				$('#editor-menu a[data-action=\''+data_action+'\']').parent('li').addClass('active');
			}	
			/*Reversed Bar*/ 	
			if (localStorage.getItem('reversed_bar')!==null){
				MCP.reversedDesignBar(localStorage.getItem('reversed_bar'));
			}
			if (localStorage.getItem('design_content_size')!==null){
				var cookie_size = localStorage.getItem('design_content_size');
				$('body').addClass(cookie_size);
			}else{
				localStorage.setItem('design_content_size','editor-size-sm');
				$('body').addClass('editor-size-sm');
			}				
			// quick sidebar toggler
			$('.design_content-toggler').on('click', function() {
					$('.modal-backdrop').hide();
					$('body').toggleClass('designbar_open'); 				
					if($('body').hasClass('designbar_open')){
						localStorage.setItem('designcp_open','true');		
					}else{
						localStorage.setItem('designcp_open','false');		
					}
					
			});
			//Deault form data
						$('body').on('dragstart.spectrum', '#profile_color',function(e, color) {	
											var replace_color = color.toHexString();
							 $('input[name=\'skin_color\']').attr('value',replace_color);
							$('#custom_style').attr('href','index.php?route=avethemes/common/style&profile_color='+ encodeURIComponent(replace_color));	
						});
						//.modal-form
						
						//edit-section
						$('body').on('click', '.modal-form',function() {		
							$('.design_loader').hide(); 
							var elem = this;
							
							var href = $(elem).data('action');
							if (typeof href == 'undefined' && href == null) {
								href = 'general';
							}
								localStorage.setItem('data_action',href);
								$('#editor-menu ul li').removeClass('active');
								$(elem).parent('li').addClass('active');
			
							var title = $(elem).data('title');
							if (title == ''||title == null) {
								title = $(elem).text();
							}	
							localStorage.setItem('design_title',title);	
							var skin_id = $('#design_editor').data('skin-id');
									$.ajax({						
										url:'index.php?route=avethemes/editor/editor&skin_id='+skin_id+'&action_cp='+href+'&action_title='+encodeURIComponent(title),
										type: 'get',
										dataType: 'html',
										beforeSend: function() {	
										},
										complete: function() {
										},
										success: function(data) {
											$('#active_section').html(title);
											$('#design_bar .design_content').html(data);
											handleFormData();
											$('#editor-menu a[data-action=\''+href+'\']').parent('li').addClass('active');
											$('.design_loader').hide(); 
										}
									});	//$.ajax
						});	//.modal-form
						$('body').on('click', '.change-skin',function() {	
							var elem = this;
							var switch_skin_id= $(elem).data('id');
									$.ajax({						
										url:'index.php?route=avethemes/editor/switch_skin&skin_id='+switch_skin_id,
										dataType: 'json',
										beforeSend: function() {	
										},
										complete: function() {
										},
										success: function(json) {																
											if (json['redirect']) {
												location = json['redirect'];
											}				
										}
									});	//$.ajax
						});	//.modal-form
						$('body').on('click', '.delete-skin',function() {	
							var elem = this;
							var delete_skin_id= $(elem).data('id');
									$.ajax({						
										url:'index.php?route=avethemes/editor/delete_skin&skin_id='+delete_skin_id,
										dataType: 'json',
										beforeSend: function() {},
										complete: function() {},
										success: function(json) {	
											if (json['error']) {
												$('.design_message.message').html('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
											}	
											if (json['success']) {
												$('.design_message.message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
											}													
											if (json['redirect']) {
												location = json['redirect'];
											}				
										}
									});	//$.ajax
						});	//.modal-form
						$('body').on('click', '#active-skin',function() {	
							var elem = this;
							var active_skin_id= $(elem).data('id');
									$.ajax({						
										url:'index.php?route=avethemes/editor/active_skin&skin_id='+active_skin_id,
										dataType: 'json',
										beforeSend: function() {},
										complete: function() {},
										success: function(json) {	
											if (json['error']) {
												$('.design_message.message').html('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
											}	
											if (json['success']) {
												$('.design_message.message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
											}													
											if (json['redirect']) {
												location = json['redirect'];
											}				
										}
									});	//$.ajax
						});	//.modal-form
						$('body').on('click','.add-skin',function() {
									$.ajax({						
										url:'index.php?route=avethemes/editor/add_skin',
										dataType: 'json',
										beforeSend: function() {},
										complete: function() {},
										success: function(json) {
											if (json['success']) {
												localStorage.setItem('data_action','general');
												var design_title = $('#general_href').data('title');
												localStorage.setItem('data_action',design_title);
												$('.design_message.message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
											}
											if (json['error']) {
												$('.design_message.message').html('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
											}
											if (json['redirect']) {
												location = json['redirect'];
											}				
										}
									});	//$.ajax
						});	//.modal-form
						
       					$('body').find('.file-browse').after('<i class="fa fa-trash-o clear-img"></i>');
					
		
				}
			});
		}
		}
    }
	var handleFormData = function() {
		$('.nav_table').bind('sortupdate', function(event, ui) {
			var sort_order = 0;
			 $('.nav_table tbody').each(function() {    
				sort_order += 1;       
				var so = $(this).find('.nav_sort');
				so.val(sort_order);
			});
		});		
		$('.nav_table').sortable({ 
					items: 'tbody.nav_row',  
				   cursor: "move", 
				   helper: function(event) {
					   return $('<div class="drag-row nav_drag"><table></table></div>').find('table').append($(event.target).closest('tbody').clone()).end();},
				   scroll: true,
				   scrollSensitivity: 30,
				   scrollSpeed: 30
		});
		/*Open Bar*/ 	
		if (localStorage.getItem('designcp_open')!=='false'){
			$('body').addClass('designbar_open');
		}
		$('#design_bar').on('click', '.nav-tabs li a[data-toggle=\'tab\']',function() {
			localStorage.setItem('active_tab',$(this).attr("href"));
		});

		if (localStorage.getItem('active_tab')!==null){
			$('#design_bar .nav-tabs li a[data-toggle=\'tab\']').each( function(){ 
				if( $(this).attr("href") ==  localStorage.getItem('active_tab')){
					$(this).click();
					return ;
				}
			});
		}
		$.ajax({
			url: 'index.php?route=avethemes/editor/getdata',
			type: 'get',
			dataType: 'json',
			beforeSend: function() {				
			},
			success: function(json) {
				$('#design_bar .data_set').each(function(index, element){
					var obj				=$(element);
					var data_set		=$(element).data('set');
					var data_action		=$(element).data('action');
					var data_id			=$(element).attr('id');
								
					var data_selected	=$(element).data('selected');
					var data_trigger	=$(element).data('trigger');
					
					var set_prefix	=$(element).data('set-prefix');
					var set_suffix	=$(element).data('set-suffix');
					
					if (typeof set_prefix == 'undefined' && set_prefix == null) {
						set_prefix='';	
					}
					if (typeof set_suffix == 'undefined' && set_suffix == null) {
						set_suffix='';
					}			
					if (typeof data_set !== 'undefined' && data_set !== null&&$.inArray(data_set,ajax_registry)!==-1) {			
							if (json[data_set]!= '') {								
								html='';
								for (i = 0; i < json[data_set].length; i++) {
									html += '<option value="' + set_prefix +json[data_set][i]['value'] +set_suffix+ '"';
									
									if (set_prefix +json[data_set][i]['value'] +set_suffix == data_selected) {
										html += ' selected="selected"';
									}
					
									html += '>' + json[data_set][i]['label'] + '</option>';
								}
							} 							
							obj.html(html);
							if(data_trigger=='change'){
								obj.trigger('change');
							}				
					}
				});
			},
			complete: function() {	
				//init customfooter
				if ($('#footer-builder').length ) {
					CustomLayout.init("#footer-builder");
				}					
				//jscolor.install();
				handleNav();
				handleColorpicker();
				handleChangePattern();
				handleFilterProduct();
				handleFilterDownload();
				MCP.checkMenuCount();
				colorpickerRemove();
				handlePreviewFrame();			
				handleSortable();	
				MCP.handleAccordion();	
				MCP.handleLayoutModules();
				MCP.handleThumbview();
				handleFileBrowser();
				
						
				$('body .tr_change').each(function(index, element){
					$(element).trigger('change');		
				});					
				$('body .tr_click').each(function(index, element){
					$(element).trigger('click');		
				});				
				$('.chosen-select').chosen({height:"120px",width:"100%"});	
				
				var path = "assets/editor/plugins/code_editor";
				var editorconfig = ace.require("ace/config");
				editorconfig.set("basePath", path);
				editorconfig.set("workerPath", path);
				editorconfig.set("themePath", path); 
				
				if ($('#custom_js').length ) {
					var js_editor = ace.edit("custom_js");
					js_editor.setTheme("ace/theme/jsplus");
					js_editor.getSession().setMode("ace/mode/javascript");	
					$('#custom_js').fadeIn();
				}
				if ($('#custom_css').length ) {
					var css_editor = ace.edit("custom_css");
					css_editor.setTheme("ace/theme/cssplus");
					css_editor.getSession().setMode("ace/mode/css");
					$('#custom_css').fadeIn();
				}	
				$('.to_editor').summernote({height: 300});
													
				$('.design_loader').hide(); 	
				$('.design_content .loading').fadeOut(250);	
				MCP.initTooltip();
				var wrapper = $('.design_content-wrapper');
					var designBarWrapper = wrapper.find('.design_content');
					var initDesignSlimScroll = function () {
						var designBar = wrapper.find('.design_content');
						var designBarHeight;
			
						designBarHeight = wrapper.height() - wrapper.find('.design_header').outerHeight();
			
						// alerts list 
						MCP.destroySlimScroll(designBar);
						designBar.attr("data-height", designBarHeight);
						MCP.initSlimScroll(designBar);
					};
					initDesignSlimScroll();
					MCP.addResizeHandler(initDesignSlimScroll); // reinitialize on window resize
			}
		});//ajax
		
	};
	var handleFileBrowser = function() {
		$('body').on('click', '.clear-img',function() {	
			$(this).parent().find('input').attr('value','');
			$(this).parent().find('.file-browse>img').attr('src','image/placeholder.png');
		});
		$('body').on('click', '.clear-ico',function() {	
			$(this).parent().parent().find('input').attr('value','');
			$(this).parent().find('.icon-preview>i').attr('class','');
		});
		$('body').on('click', '.file-browse',function() {	
			$('#modal-image-editor,.modal-backdrop').remove();
			var field = $(this).parent().find('input').attr('id');
			var thumb = $(this).attr('id');
			var previewsrc = $(this).data('previewsrc');
			var filemanager_path = 'index.php?route=avethemes/editor/filemanager' + '&field=' + field + '&thumb=' + thumb;
			
			if (previewsrc != 'undefined') {
				filemanager_path += '&previewsrc=' + encodeURIComponent(previewsrc);
			}
			var fhtml  = '<div id="modal-image-editor" class="modal-box modal">';
			fhtml += '  <div class="modal-dialog modal-lg">';
			fhtml += '    <div class="modal-content">';
			fhtml += '      <div class="modal-header">'; 
			fhtml += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			fhtml += '        <h4 class="modal-title">Filemanager</h4>';
			fhtml += '      </div>';
			fhtml += '      <div class="modal-body modal-iframe"><iframe id="modal-iframe" frameborder="0" src="'+filemanager_path+'"></iframe></div>';	
			fhtml += '    </div';
			fhtml += '  </div>';
			fhtml += '</div>';	
			$('body').append(fhtml);
			$('#modal-iframe').show();
			$('#modal-image-editor').modal('show');
		});
	}
	var handleNav = function() {
        $('body input.colorpicker:not(.no_clear)').each(function(index, element) {
					$(element).wrap('<div class="input-group"></div>');
					$(element).parent().children('.input-group-addon.remove_color').remove();
					var picker_html ='<a class="input-group-addon remove_color"><i class="fa fa-eraser"></i></a>';
				$(element).after(picker_html);
		});	
        $('body .with-nav').each(function(index, element) {
				var data_id=$(this).attr('id');
				if (typeof data_id !== 'undefined' && data_id !== null&& data_id !== false) {					
					$('#'+data_id).wrap('<div class="input-group"></div>');					
					$('#'+data_id).parent().children('.input-group-addon').remove();
					var nav_html ='<a class="input-group-addon" onclick="MCP.navSelect(\'prev\',\'#'+data_id+'\')"><i class="fa fa-chevron-left"></i></a>';
						nav_html +='<a class="input-group-addon" onclick="MCP.navSelect(\'next\',\'#'+data_id+'\')"><i class="fa fa-chevron-right"></i></a>';
				$('#'+data_id).after(nav_html);
				}
		});	
        $('body .with-val').each(function(index, element) {
				var data_id=$(this).attr('id');			
				var data_min=$(this).data('min');			
				var data_max=$(this).data('max');
				if (typeof data_min == 'undefined' && data_min == null) {
					var data_min='0';	
				}
				if (typeof data_max == 'undefined' && data_max == null) {
					var data_max='999';
				}
				if (typeof data_id !== 'undefined' && data_id !== null&& data_id !== false) {					
					$('#'+data_id).wrap('<div class="input-group"></div>');							
					$('#'+data_id).parent().children('.input-group-addon').remove();
					var nav_html ='<a class="input-group-addon" onclick="MCP.navVal(\'#'+data_id+'\',\'prev\',\''+data_min+'\')"><i class="fa fa-minus"></i></a>';
						nav_html +='<a class="input-group-addon" onclick="MCP.navVal(\'#'+data_id+'\',\'next\',\''+data_max+'\')"><i class="fa fa-plus"></i></a>';
				$('#'+data_id).after(nav_html);
				}
		});	
    };
	
    var colorpickerRemove = function() {		
		if ($('.remove_color').length ) {	
			$('.remove_color').on("click", function() {
				var $input=$(this).parent().children('input');
					$input.attr({'value':'','style':''});
				/*Destroy*/ 
				var obj_id			=$input.attr('id');
				var obj_selector	=$input.data('selector');	
				var obj_attr		=$input.data('attr');	
				var obj_suffix		=$input.data('suffix');	
				var obj_type		=$input.data('type');	
					
				if(obj_suffix==null){
					var obj_suffix='';
				}	
				$($input.data('selector')).css($input.data('attr'),'');
					
				if (typeof obj_type !== 'undefined' && obj_type !== false&& obj_type=='css') {
					var css_class=obj_id+"_head_css";	
						if($('.'+css_class).length){
							$('.'+css_class).remove();
						}				
				}	
			});	
		}
    }
	var handleColorpicker = function() {
		$('input.colorpicker').attr('readonly',true).spectrum({
					showInput: true,
					showAlpha: true,
					preferredFormat: "hex",
					allowEmpty: true,
					move: function(color) {
						$(this).val(color).trigger('change'); 
					},
					change: function(color) {
						$(this).val(color).trigger('change');
					}
	});
	$(document).on('change', 'input.colorpicker',function() {	
					var $obj=$(this);					
					var $value=$obj.attr('value');
					//finish task
					var obj_id=$obj.attr('id');
					var obj_selector=$obj.data('selector');	
					var obj_attr=$obj.data('attr');	
					var obj_suffix=$obj.data('suffix');	
					var obj_type=$obj.data('type');
					var css_media=$obj.data('css-media');	
						
					if(css_media==null){
						var css_media='all';
					}	
					if(obj_suffix==null){
						var obj_suffix='';
					}
					if(obj_selector!=null&&obj_attr!=null&&obj_type!='css'){
						$($obj.data('selector')).css($obj.data('attr'),$value+obj_suffix);
					}					
					if (typeof obj_type !== 'undefined' && obj_type !== false&&obj_type=='css') {
						var css_class=obj_id+"_head_css";
						var css='<style type="text/css" class="'+css_class+'" media="'+css_media+'">';
							css+=obj_selector+'{'+obj_attr+':'+$value+obj_suffix+';}';
							css+='</style>';				
							if($('.'+css_class).length){
								$('.'+css_class).remove();
							}				
							$('head').append(css);	
					}	
	 });
	}
	var handlePreviewFrame = function() {
		$("body").ready(function(){ 
		$('#design_bar select,#design_bar input').change(function(){
					var obj=$(this);	
					var obj_value=$(this).val();	
					var obj_text =obj_value.replace(/\+/g," ");
					var obj_id=obj.attr('id');
					var obj_selector=obj.data('selector');
					var obj_attr=obj.data('attr');
					var obj_prefix=obj.data('prefix');						
					var obj_type=obj.data('type');	
					var css_media=obj.data('css-media');	
						
					if(css_media==null){
						var css_media='all';
					}
					if(obj_prefix==null){	var obj_prefix='';	}
					
					var obj_suffix=obj.data('suffix');					
					if(obj_suffix==null){	var obj_suffix='';	}
					
					if(obj_selector!=null&&obj_attr!=null&&obj_attr!='src'&&obj_type!='css'){
						$(obj_selector).css(obj_attr,obj_prefix+obj_value+obj_suffix);
					}
					if(obj_selector!=null&&obj_attr!=null&&obj_type=='css'){						
						var css_class=obj_id+"_head_css";
						var css='<style type="text/css" class="'+css_class+'" media="'+css_media+'">';
						if(obj_attr=='font-family'){
							css+=obj_selector+'{'+obj_attr+':\''+obj_text+'\''+obj_suffix+';}';
						}else{
							css+=obj_selector+'{'+obj_attr+':'+obj_prefix+obj_value+obj_suffix+';}';
						}
							css+='</style>';				
							if($('.'+css_class).length){
								$('.'+css_class).remove();
							}				
							$('head').append(css);	
							
					}
			 });
		});
    }
	var handleFilterProduct = function() {	
			$('input[name=\'filter_product\']').auto_complete({
				delay: 500,
				source: function(request, response){
					$.ajax({
						url: 'index.php?route=avethemes/editor/product_autocomplete&filter_name=' +  encodeURIComponent(request),
						dataType: 'json',
						success: function(data){		
								var from='products';
								var tobox='skin_pin_product';
								var field='skin_pin_product';
								$('#'+from+' div').remove();			
							for (i = 0; i < data.length; i++){
								var id=data[i]['product_id'] ;
								var name=data[i]['name'] ;
								$("#"+from).append('<div id="div'+from+id+'"><input id="'+from + id + '" type="hidden" value="' + name + '"/>' + name +'<img src="assets/theme/img/add.png" onclick="MCP.addObject(\''+from+'\',\''+tobox+'\',\''+id+'\',\''+field+'\')" title="Add"/></div>');										
								$('#'+from+' div:odd').attr('class', 'even');
								$('#'+from+' div:even').attr('class', 'odd');	
							}
						}
					});
					
				}
			});
	}
	var handleFilterDownload = function() {
			$('input[name=\'filter_download\']').auto_complete({
				delay: 500,
				source: function(request, response){
					$.ajax({
						url: 'index.php?route=avethemes/editor/download_autocomplete&filter_name=' +  encodeURIComponent(request),
						dataType: 'json',
						success: function(data){		
								var from='downloads';
								var tobox='skin_pin_download';//Scrollbox ID
								var field='skin_pin_download';
								$('#'+from+' div').remove();			
							for (i = 0; i < data.length; i++){
								var id=data[i]['download_id'] ;
								var name=data[i]['name'] ;
								$("#"+from).append('<div id="div'+from+id+'"><input id="'+from + id + '" type="hidden" value="' + name + '"/>' + name +'<img src="assets/theme/img/add.png" onclick="MCP.addObject(\''+from+'\',\''+tobox+'\',\''+id+'\',\''+field+'\')" title="Add"/></div>');										
								$('#'+from+' div:odd').attr('class', 'even');
								$('#'+from+' div:even').attr('class', 'odd');	
							}
						}
					});
					
				}
			});
	}
	var handleChangePattern = function() {
		if ($('.ave_pattern>div').length ) {
			$('.ave_pattern>div').on('click', function() {
				$('.ave_pattern>div').removeClass('active');
				$(this).addClass('active');
				$(this).children('input').attr('checked','checked');
				var style =$(this).attr('style');
				$('.body_bg_image_preview').attr('style',style);
			});
		}
    }
	var handleSortable = function() {		
		if ($('.widget_sort').length ) {
			$('.widget_sort').each(function(index, elem) {
				var data_id= $(elem).attr('id');
				if (data_id!=''||data_id!=null){			
					$(elem).sortable({cursor: "move"});				
					$('.widget_sort').bind('sortupdate', function(event, ui) {						 
							data = $.map($('#'+data_id+' .sort_order'), function(element){
								return $(element).attr('value');
							});					
							$('input[name=\'theme_setting['+data_id+']\']').attr('value', data.join());	
					});
				}
			});
		}
		
		if ($('.colslider.desktop').length ) {	
			$('.colslider.desktop').sortable({cursor: "move"});
			$('.colslider').bind('sortupdate', function(event, ui) {
					var dataid=$(this).data('id');
					data = $.map($(this).children().children().children('input.sort'), function(element){
						return $(element).attr('value');
					});					
					var joindata=data.join();
					var joindata=joindata.replace(/,/g,"");		
					$(dataid).attr("selected","");
					$(dataid+' option').attr("selected", "");
					$(dataid+' option[value="'+joindata+'"]').attr("selected", "selected");
					$(dataid).trigger('change');
			});		
		}
		
		if ($('#skin_pin_download').length ) {	
			$('#skin_pin_download').sortable({cursor: "move"});
			$('#skin_pin_download').bind('sortupdate', function(event, ui){
					$('#skin_pin_download div:even').attr('class', 'odd');	
					$('#skin_pin_download div:odd').attr('class', 'even');													
			});	
			$('#skin_pin_download div img').on('click', function(){
				$(this).parent().remove();
				$('#skin_pin_download div:odd').attr('class', 'odd');
				$('#skin_pin_download div:even').attr('class', 'even');
			});	
		}		
		if ($('#skin_pin_product').length ) {	
			$('#skin_pin_product').sortable({cursor: "move"});
			$('#skin_pin_product').bind('sortupdate', function(event, ui){
					$('#skin_pin_product div:even').attr('class', 'odd');	
					$('#skin_pin_product div:odd').attr('class', 'even');	
			});	
			$('#skin_pin_product div img').on('click', function(){
				$(this).parent().remove();
				
				$('#skin_pin_product div:odd').attr('class', 'odd');
				$('#skin_pin_product div:even').attr('class', 'even');
			
				data = $.map($('#skin_pin_product input'), function(element){
					return $(element).attr('value');
				});
			});
		}
    }
    return {
		decode_base64: function (data) {
					  var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
					  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,ac = 0,dec = "",tmp_arr = [];
					  if (!data) {return data;}
					  data += '';
					  do { // unpack four hexets into three octets using index points in b64
						h1 = b64.indexOf(data.charAt(i++));
						h2 = b64.indexOf(data.charAt(i++));
						h3 = b64.indexOf(data.charAt(i++));
						h4 = b64.indexOf(data.charAt(i++));
						bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;
						o1 = bits >> 16 & 0xff;
						o2 = bits >> 8 & 0xff;
						o3 = bits & 0xff;
					
						if (h3 == 64) {
						  tmp_arr[ac++] = String.fromCharCode(o1);
						} else if (h4 == 64) {
						  tmp_arr[ac++] = String.fromCharCode(o1, o2);
						} else {
						  tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
						}
					  } while (i < data.length);
					  dec = tmp_arr.join('');
					  return dec;
        },
        addObject: function (from,to,value) {
			var html = $('#'+from+' #div'+from+value).html();
			$('#'+from+' #div'+from+value).remove();
			$('#'+from+' div:even').attr('class', 'odd');	
			$('#'+from+' div:odd').attr('class', 'even');	
			
			$('#'+to+' div#'+to+value).remove();				
			$('#'+to).append('<div id="'+to+value+'">'+html+'</div>');
				
			var name = $('#'+to+value +' input').data('name');
			$('#'+to+value +' input').attr('name',name).removeAttr('data-name');
			$('#'+to+value +' img').attr({'src':'assets/theme/img/delete.png','onclick':'$(this).parent().remove();','title':'Remove'});
			
			$('#'+to+' div:even').attr('class', 'odd');	
			$('#'+to+' div:odd').attr('class', 'even');/*
			$('#'+to).sortable({cursor: "move"});
			$('#'+to).bind('sortupdate', function(event, ui) {
					$('#'+to).children('div:even').attr('class','odd');	
					$('#'+to).children('div:odd').attr('class','even');															
			});	*/ 
			
        },
		activeObj: function(obj,val) {
			$('.'+obj).hide();
			$('.'+obj+'.otp-'+val).show();
		},
		 deactiveObj: function(obj,val) {
			$('.'+obj).show();
			$('.'+obj+'.dotp-'+val).hide();
		},
		navSelect:function(nav,obj) {
			if (nav=='prev') {	
				if($(obj+' option:selected').prev().length){
					$(obj+' option:selected').removeAttr('selected').prev().attr('selected', 'selected');	
				}else{
					$(obj+' option:selected').removeAttr('selected');
					$(obj+' option').last().attr('selected', 'selected');	
				}
			}
			if (nav=='next') {	
				if($(obj+' option:selected').next().length){
					$(obj+' option:selected').removeAttr('selected').next().attr('selected', 'selected');
				}else{
					$(obj+' option:selected').removeAttr('selected');
					$(obj+' option').first().attr('selected', 'selected');	
				}
			}
			$(obj).trigger('change');
		},
		navVal:function(obj,nav,lim) {
				var lim=parseFloat(lim);
				var val=parseFloat($(obj).attr('value'));
			if (nav=='prev') {	
				var newval=val-0.5;
				$(obj).attr('value',(newval>lim)?newval:lim);
			}else{	
				var newval=val+0.5;
				$(obj).attr('value',(newval<lim)?newval:lim);
			}
			$(obj).trigger('change');
		},
        changeGridItem: function (numitem) {
			$("body").ready(function(){  
			 $('a.btn-grid').trigger('click');  
			 $('.page-items').attr({'data-grid':'col-lg-'+numitem+' col-md-'+numitem+' col-sm-'+numitem});
			 $('.page-items>div').attr({'class':'col-lg-'+numitem+' col-md-'+numitem+' col-sm-'+numitem});
			}); 
        },
        clearCache: function () {
			$.ajax({
				url: 'index.php?route=avethemes/editor/clearcache',
				type: 'post',
				dataType: 'json',
				data: $('#design_editor input[type=\'hidden\']'),
				beforeSend: function() {},
				success: function(json) {	
						if (json['error']) {
							$('.design_message.message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						} 
						if (json['success']) {	
							$('.design_message.message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');					
						}
						if (json['redirect']) {
							location = json['redirect'];
						}
				}
			});
        },
        changeTitleDisplay: function () {
			var display = $('input[name=\'theme_setting[category_title_display]\']:checked').val();	
			if (display=='1') {
				$('.title-wrapper').removeClass('hide').addClass('show');
				$('.category_description').removeClass('show').addClass('hide');
			} else {
				$('.category_description').removeClass('hide').addClass('show');
				$('.title-wrapper').removeClass('show').addClass('hide');
			}		
        },
        checkMenuCount: function () {		
			var menu_count = $('input[name=\'theme_setting[menu_count_item]\']:checked').val();		
											
			if (menu_count=='1') {
				$('.list_count_select').show();	
				$('.header-navigation .badge').css('display','');
			} else {
				$('.list_count_select').hide();
				$('.header-navigation .badge').css('display','none');
			}	
        },		
        addObject: function (from,to,id,fieldname) {	
			var name = $('#'+from+' #'+from+id).attr('value');
			$('#'+from+' #div'+from+id).remove();			
			$('#'+from+' div:even').attr('class', 'odd');	
			$('#'+from+' div:odd').attr('class', 'even');			
			$('#'+to+' div#'+to+id).remove();					
			$('#'+to).append('<div id="'+to+id+'"><input type="hidden" name="'+fieldname+'[]" value="' + id + '" />' + name  +'<img src="assets/theme/img/delete.png"/></div>');
			$('#'+to+' div:even').attr('class', 'odd');	
			$('#'+to+' div:odd').attr('class', 'even');
			
        },
        showObj: function (obj) {			
			if($('#'+obj).is(':checked')){
				 $('div.'+obj).addClass('show_obj');
			} else {
				 $('div.'+obj).removeClass('show_obj');
			}	
        },
        switchStatus: function (obj) {			
			var obj_value = $('input.'+obj).attr('value');		
											
			if (obj_value=='1') {
				 $('input.'+obj).attr('value','0');
				 $('div.'+obj).removeClass('show_obj');
			} else {
				 $('input.'+obj).attr('value','1');
				 $('div.'+obj).addClass('show_obj');
			}	
        },
        switchClass: function (obj,oldclass,newclass) {
				$(obj).removeClass(oldclass);
				//pre-action	
				var cookie_name= obj.replace(/!|@|\$|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\'| |\"|\&|\#|\[|\]|~/g,"")+'_'+oldclass;
				var cookie_val=localStorage.getItem(cookie_name);
				if (cookie_val!=''||cookie_val!=null){
					var oldclass=cookie_val;	
				}		
				localStorage.setItem(cookie_name,newclass);
				$(obj).removeClass(oldclass).addClass(newclass);	
        },
        activeObj: function (obj,val) {
				$('.'+obj).hide();
				$('.'+obj+'.otp-'+val).show();
        },
        deactiveObj: function (obj,val) {
				$('.'+obj).show();
				$('.'+obj+'.otp-'+val).hide();
        },
        changeFontFamily: function (obj,font) {
				if ($('.'+obj+'_head_font').length){ $('head .'+obj+'_head_font').remove();}	
					var ignore = new Array('','Arial','Verdana','Helvetica','Lucida Grande','Trebuchet MS','Times New Roman','Tahoma','Georgia','Open Sans', 'Open Sans Light','Open Sans Semibold','Open Sans Extrabold');
				if($.inArray(font, ignore)<0){
					$.ajax({
						url: 'index.php?route=avethemes/editor/connect',
						dataType: 'json',
						success: function(json){		
							if (json['error']) {
								$('#notification>.alert').remove();
								$('#notification').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							} 
							if (json['success']) {
									$('#content>.attention').remove();
									if($('.'+obj+'_head_font').hasClass(obj+'_head_font')){
										$('.'+obj+'_head_font').remove();
									}	
									$('head').append("<link href=\"http://fonts.googleapis.com/css?family="+font+"&subset=all\" class=\""+obj+"_head_font\" rel=\"stylesheet\" type=\"text/css\">");	
									
									$('head').append("<link href=\"http://fonts.googleapis.com/css?family="+font+"&subset=all\" class=\""+obj+"_head_font\" rel=\"stylesheet\" type=\"text/css\">");	
							} 	
					}
					});
				}
        },
        addSocialRow: function () {				
			var social_row=$('#add_social').children('tfoot').data('row');
			$.ajax({
						url: languages_query,
						dataType: 'json',		
						success: function(languages) {
						
			html  = '<tbody class="social-row" id="social-row' + social_row + '">';
			
	html += '<tr><td colspan="3"><div class="heading-bar text-center">Social #' + social_row +'</div></td></tr>';		
		
	html += '<td colspan="3">';								
	for (i = 0; i < languages.length; i++) {
		html += '<div class="form-group"><label class="control-label" for="">Title</label>';
		html += '<div class="lang-field">';
		html += '<input type="text" name="skin_social_data['+social_row + '][title]['+languages[i]['language_id']+']" class="add_social'+social_row + ' form-control" value=""/>';
		html += '<img src="image/flags/'+languages[i]['image']+'" title="'+languages[i]['name']+'"/>';
		html += '    </div>';
		html += '    </div>';
		
	}//for
			html += '<div class="form-group"><label class="control-label" for="">Link</label>';
			html += '<input type="text" name="skin_social_data[' + social_row + '][link]" value="http://www." class="form-control"/>';
			html += '    </div>';
			html += '<div class="form-group">';
			html += '<label>Open new tab: <input type="checkbox" name="skin_social_data[' + social_row + '][target]" checked="checked"/></label>';
			html += '    </div>';
			html += '    <input class="sort_order" type="hidden" name="skin_social_data[' + social_row + '][sort_order]" value="' + social_row + '"/>';	
			html += '    </td>';
			html += '  </tr>';	
			html += '  <tr>';
	html += '<td>';
	html += '<div class="form-group"><label class="control-label" for="">Icon</label></div>';     
	html += '<a class="icon-preview">';
	html += '<i id="social_icon' + social_row + '_thumb" class="">&nbsp;</i>';
	html += '<input type="hidden" name="skin_social_data[' + social_row + '][icon]" value="" id="social_icon' + social_row + '" />';
	html += '</a><i class="fa fa-trash-o clear-ico"></i>';
	
	html += '   </td>';
		  
	html += '    <td><a class="btn btn-xs btn-primary pull-right" onclick="$(\'#social-row' + social_row + '\').remove();" class="button">Remove</a></td>';
	html += '  </tr>';
	
	html += '<tr>';	
			
			
			html += '</tbody>';			
			$('#add_social tfoot').before(html);
			social_row++;
			$('#add_social').children('tfoot').data('row',social_row);			
				}//success
			});//ajax
			
        },
        addPayment: function () {
				var payment_row=$('#add_payment_icons').children('tfoot').data('row');
				$.ajax({
					url: languages_query,
					dataType: 'json',		
					success: function(languages) {				
				phtml  = '<tbody class="payment_icons-row" id="payment_icons-row' + payment_row + '">';
				phtml += '  <tr>';
				
				phtml += '<td>';
				phtml += '<a id="payment_image' + payment_row + '_thumb" data-toggle="imagex" class="img-thumbnail file-browse">';
				phtml += '<img src="" data-placeholder="" alt=""/></a><i class="fa fa-trash-o clear-img"></i>';
				phtml += '<input type="hidden" name="skin_payment_icons_data[' + payment_row + '][image]" value="" id="payment_image' + payment_row + '"/>';
				
				phtml += '    </td>';
				
				phtml += '    <td>';	
				var languages_length = languages.length;
						for (i = 0; i < languages_length; i++) {	
				phtml += '    <div class="lang-field">';
				phtml += '    <input type="text" name="skin_payment_icons_data['+payment_row + '][title]['+languages[i]['language_id'] + ']" class="form-control add_payment_icons'+payment_row + '" value=""/><img src="image/flags/'+languages[i]['image'] + '" title="'+languages[i]['name'] + '"/>';
				phtml += '    </div>';										
						}//for	
									
				phtml += '    </td>';						  
				phtml += '    <td><a onclick="$(\'#payment_icons-row' + payment_row + '\').remove();" class="btn btn-primary btn-xs pull-right">Remove</a></td>';
				phtml += '  </tr>';
				phtml += '</tbody>';		
					$('#add_payment_icons tfoot').before(phtml);
							}//success
				});//ajax				
				payment_row++;
				$('#add_payment_icons').children('tfoot').data('row',payment_row);
        },
        addContact: function (obj) {	
				var contact_row=$('#add_contact').children('tfoot').data('row');	
				$.ajax({
							url: languages_query,
							dataType: 'json',		
							success: function(languages) {
				html  = '<tbody class="contact_icons-row" id="add_contact-row' + contact_row + '">';
				html += '  <tr>';
				
			   html += '<td>  ';       
			   html += '<a class="icon-preview">'; 
               html += '<i class="" id="contact_icon' + contact_row + '_thumb"></i>'; 
               html += '<input type="hidden" name="skin_contact_data[' + contact_row + '][icon]" value="" id="contact_icon'+contact_row+'" />';
               html += '</a><i class="fa fa-trash-o clear-ico"></i>';  
			  html += '   </td>';
				html += '    <td>';
				var languages_length = languages.length;
									for (i = 0; i < languages_length; i++) {
				html += '    <div class="lang-field">';
				html += '    <input type="text" name="skin_contact_data['+contact_row + '][title]['+languages[i]['language_id']+']" class="form-control add_contact'+contact_row + '" value="Title"/><img src="image/flags/'+languages[i]['image']+'" title="'+languages[i]['name']+'"/>';
				html += '</div><div class="lang-field">';			
				html += '  <input type="text" name="skin_contact_data['+contact_row + '][content]['+languages[i]['language_id']+']" class="form-control add_contact'+contact_row + '" value="Content"/><img src="image/flags/'+languages[i]['image']+'" title="'+languages[i]['name']+'"/>';
				html += '    </div>';									
									}//for		
				html += '    </td>';
				
						  
						  
				html += '    <td class="right"><a onclick="$(\'#add_contact-row' + contact_row + '\').remove();" class="btn btn-xs btn-primary">Remove</a></td>';
				html += '  </tr>';
				html += '</tbody>';
				
				$('#add_contact tfoot').before(html);
							}//success
				});//ajax
				contact_row++;
				$('#add_contact').children('tfoot').data('row',contact_row);	
        },
        changeTwoColumn: function (prefix,id,layout) {	
					var label_column_left=$('#'+prefix+id).data('text-left');	
					var label_column_right=$('#'+prefix+id).data('text-right');	
					var label_main_content=$('#'+prefix+id).data('text-content');	
				 if(layout!='default'){	
						$('#'+prefix+'slider_'+id).css('display','block');		
						$('.'+prefix+'row_'+id).css('display','block');
						 if (layout=='right') {
							$('#'+prefix+'left_'+id+' .col_label').html(label_column_right);
							$('#'+prefix+'left_'+id).css('float','right');
							MCP.twoSlider('#'+prefix+id,'#'+prefix+'right_'+id,'#'+prefix+'left_'+id,label_main_content);	
						 }else{		 
							$('#'+prefix+'left_'+id+' .col_label').html(label_column_left);	
							$('#'+prefix+'left_'+id).css('float','left');
							MCP.twoSlider('#'+prefix+id,'#'+prefix+'left_'+id,'#'+prefix+'right_'+id,label_column_left);
						 }
				}else{
					$('.'+prefix+'row_'+id).css('display','none');
				}
        },
        twoSlider: function (obj,firstval,lastval,text) {
				$(obj).slider({
						range: "min",
						animate: true,
						min: 0,
						max: 12,
						value: $(firstval+' input').val(),
						slide: function( event, ui ) {
							var oneval = ui.value;
							var twoval = 12 - oneval;
							var ttwoval;
							if(twoval==0){
								ttwoval=12;
							}else{
								ttwoval=twoval;
							}
							var ooneval;
							if(oneval==0){
								ooneval=12;
							}else{
								ooneval=oneval;
							}
							
							$(firstval).attr('class','col-md-'+ooneval);
							$(lastval).attr('class','col-md-'+ttwoval);
							$(firstval+' .value').html(ooneval+'/12');
							$(lastval+' .value').html(ttwoval+'/12');
							$(firstval+' input').val(ooneval);
							$(lastval+' input').val(ttwoval);	
						}
				});
				$(obj+' .ui-widget-header').html('<div title="'+text+'"></div>').addClass('black-bg gradient glossy with-tooltip');				
        },
        renderDesktopLayout: function (prefix,id,type) {	 
				 if(type=='custom'){
					 MCP.changeTwoColumn(prefix+'top_extra_',id,'left');
					 MCP.changeTwoColumn(prefix+'bottom_extra_',id,'left');
					 
					 MCP.changeTwoColumn(prefix+'top_position_',id,'left');
					 MCP.changeTwoColumn(prefix+'bottom_position_',id,'left');
				 
					$('.'+prefix+'row_'+id).css('display','block');
					$('#'+prefix+id).fadeIn(0);
					$('#'+prefix+'slider_'+id).fadeIn(0);	
							MCP.desktopSlider('#'+prefix+id,'#'+prefix+'left_'+id,'#'+prefix+'right_'+id,'#'+prefix+'content_'+id,label_main_content);
						
				}else{				
					$('.'+prefix+'row_'+id).css('display','none');	
					$('#'+prefix+id).fadeOut(0);
					$('#'+prefix+'slider_'+id).fadeOut(0);
				}
        },
        desktopSlider: function (obj,firstval,lastval,ortherval,text) {
				$(obj).slider({
					range: true,
					min: 0,
					max: 12,
					values: [$(firstval+' input.cval').val(),( 12 - $(lastval+' input.cval').val())],
					slide: function( event, ui ) {
						var oneval = ui.values[0];
						var twoval = 12 - ui.values[ 1];
						var threeval = 12 - twoval - oneval;
						
						$(firstval+' input.cval').val(oneval);
						$(lastval+' input.cval').val(twoval);
						$(ortherval+' input.cval').val(threeval);	
						
						$(firstval+' .value').html(oneval+'/12');
						$(lastval+' .value').html(twoval+'/12');
						$(ortherval+' .value').html(threeval+'/12');		
						
						$(firstval).attr('class','col-md-'+oneval);
						$(lastval).attr('class','col-md-'+twoval);
						$(ortherval).attr('class','col-md-'+threeval);	
					
					}
				});
				$(obj+' .ui-widget-header').html('<div title="'+text+'"></div>').addClass('black-bg gradient glossy with-tooltip');
        },
        bg_select: function (field,preview,thumb) {
				var $input=$('#' + field);
					$('#modal-bg-preset').remove();
					var href ='index.php?route=avethemes/editor/bg_preset&field=' + field + '&thumb=' + thumb +'&preview=' + encodeURIComponent(preview) ;
					html  = '<div id="modal-bg-preset" class="modal-box modal">';
					html += '  <div class="modal-dialog modal-lg">';
					html += '    <div class="modal-content">';
					html += '      <div class="modal-header">'; 
					html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
					html += '        <h4 class="modal-title">Preset Pattern</h4>';
					html += '      </div>';
					html += '      <div class="modal-body modal-iframe"><iframe id="modal-iframe" frameborder="0" src="'+href+'"></iframe></div>';	
					html += '    </div';
					html += '  </div>';
					html += '</div>';	
					$('body').append(html);		
					$('#modal-iframe').show();
					$('#modal-bg-preset').modal('show');
					$(document).on('hidden.bs.modal', function(event) {
							var $value=$input.val();
						if ($value!=''&&$value!=null) {
							var obj_selector=$input.data('selector');	
							var obj_attr=$input.data('attr');	
									
							$(preview).css('background-image','url(' + $value);
							$('#' + thumb).replaceWith('<img src="' + $value + '" alt="" id="' + thumb + '" style="max-width:180px;" />');
							
							if(obj_selector!=null&&obj_attr!=null){
								$(obj_selector).css(obj_attr,'url('+$value+')');	
							}
							
						}
					});		
        },
        destroyAttr: function (obj) {
				var obj_selector=$(obj).data('selector');	
				var obj_attr=$(obj).data('attr');	
				if(obj_selector!=null&&obj_attr!=null){
					$(obj_selector).css(obj_attr,'');	
				}
				if(obj_selector!=null&&obj_attr=='src'&&obj_attr!=null){
					var skin_store_logo = $('input[name=\'skin_store_logo\']').val();
					$(obj_selector).attr('src','image/'+skin_store_logo);	
				}
				$(obj).attr('value', '');
        },
        getPreviewUrl: function (layout_id) {	
				$.ajax({
					url: 'index.php?route=avethemes/editor/layout_preview&layout_id='+layout_id,
					dataType: 'json',
					success: function(json) {
						if (json['preview']) {
							var preview_url = json['preview'];
							location = json['preview'];
						}
					}
				});
        },
		refresh_module_list: function (){
			$.ajax({
				url: 'index.php?route=avethemes/editor/module_refresh',
				dataType: 'html',		
				success: function(html) {
					$('.module_accordion').html(html);
					MCP.handleAccordion();
					MCP.handleDraggable();
					MCP.handleThumbview();
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
					var data_title = $(ui.draggable).attr("data-title");
					var data_code = $(ui.draggable).attr("data-code");
					var data_href = $(ui.draggable).find('a.btn-edit').attr("data-href");
					var data_position = $(ui_elem).attr("data-position");
					var data_index = $('#data_index').attr("data-index");
					var text_edit = $('#module_list').attr("data-text-edit");
					var data_sort = 0;
						data_sort = $(ui_elem).find('.mblock').length;
						
					if(data_code!='0'){
						var html = '<div class="mblock" data-code="'+data_code+'">';
							html += '<div class="module_label">'+data_title+'</div>';
							html += '<div class="btn-group">';
							html += '<a class="btn btn-xs btn-edit" data-href="'+data_href+'" data-toggle="tooltip" title="'+text_edit+'"><i class="fa fa-edit"></i> '+ui.draggable.text()+'</a>';
							html += '<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>';
							html += '</div>';
							html += '<input type="hidden" name="layout_module['+data_index+'][code]" value="'+data_code+'"/>';
							html += '<input type="hidden" name="layout_module['+data_index+'][position]" class="layout_position" value="'+data_position+'"/>';
							html += '<input type="hidden" name="layout_module['+data_index+'][sort_order]" value="'+(parseInt(data_sort)+1)+'" class="sort"/>';
							html += '</div>';
							$(".drop_area").find(ui.draggable).remove();
							$(ui_elem).append(html);
							$('#data_index').attr("data-index",parseInt(data_index)+1);
							MCP.applyLayout();
						
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
										$('.design_message.message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
									} 
									if (json['success']) {	
										var success = true;
										$('.design_message.message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i>' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');	
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
										MCP.applyLayout();
										
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
				items: "> .mblock",
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
						MCP.applyLayout();		
					},
				cursorAt: {
					left: 0,
					top: 0
				}
			}).disableSelection();
		},
		deleteModule:function(module_id){
			if (confirm("Are you sure?")) {
					$.ajax({
						url: 'index.php?route=avethemes/editor/delete_module&module_id='+module_id,
						dataType: 'json',		
						success: function(json) {
								if (json['success']) {
									MCP.refresh_module_list();
									$('.design_message.message').html('<div class="alert alert-success" ><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
								}	
								if (json['error']) {
									$('.design_message.message').html('<div class="alert alert-danger"><i class="fa fa-check-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
								}	
						}
					});//ajax
			}
		},
		addModule:function(code,position,module_title,module_label,data_href){
			var data_index = $('#data_index').attr("data-index");
			var html = '<div class="mblock" data-code="'+code+'">';
			var text_edit = $('#module_list').attr("data-text-edit");

			html += '<div class="module_label">'+module_title+'</div>';
			html += '<div class="btn-group">';
			html += '<a class="btn btn-xs btn-edit" data-href="'+data_href+'" data-toggle="tooltip" title="'+text_edit+'"><i class="fa fa-edit"></i>'+module_label+'</a>';
			html += '<a class="btn btn-xs btn-remove"><i class="fa fa-trash-o"></i></a>';
			html += '</div>';
			html += '<input type="hidden" name="layout_module['+data_index+'][code]" value="'+code+'"/>';
			html += '<input type="hidden" name="layout_module['+data_index+'][position]" class="layout_position" value="'+position+'"/>';
			html += '<input type="hidden" name="layout_module['+data_index+'][sort_order]" value="999" class="sort"/>';
			html += '</div>';
			$('div[data-position=\''+position+'\']').append(html);
			$('#data_index').attr("data-index",parseInt(data_index)+1);
					$.ajax({
						url: 'index.php?route=avethemes/editor/stoken',
						dataType: 'json',		
						success: function(json) {
							if (json['token']) {
								data_href+= '&token='+json['token'];
								$('#modal-iframe').attr('src',data_href).show();
								$('#module-modal.show_module_option').modal('show');
							}
						}
			});//ajax
			MCP.applyLayout();
		},
		handleLayoutModules:function (){
			MCP.handleDraggable();
			$('body').on('click','.btn-edit', function(event) {
						event.preventDefault();
						var iframe = $('#modal-iframe');
						var data_href = $(this).attr('data-href')
						iframe.addClass('loading');
						$.ajax({
							url: 'index.php?route=avethemes/editor/stoken',
							dataType: 'json',		
							success: function(json) {
								if (json['token']) {
									data_href+= '&token='+json['token'];
									iframe.attr('src',data_href).show();
									$('#module-modal').modal('show');
								}
							}
						});//ajax
			});
			$('body').on('click', '.btn-remove', function(event) {
					//event.preventDefault();
						$(this).parents('.mblock').remove();
						MCP.applyLayout();
						MCP.initTooltip();
			});
			$('#modal-iframe').on('load', function(event) {
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
					MCP.refresh_module_list();
					MCP.apply();
					$('#module-modal').modal('hide');         
				} else {
					iframe.addClass('loading');
					iframe.contents().find('#header,#content .page-header .breadcrumb,#column-left,#footer').hide();
					iframe.contents().find('#content').css({'padding': '0px 0px 0px 0px', 'margin': '0px 0px 0px 0px'});
					iframe.removeClass('loading').show();
				}
			});
			/*Popup Module*/ 
			$('body').on('click','.btn-add', function(event) {
					//event.preventDefault();
					var iframe = $('#modal-popup');
					var data_href = $(this).data('href')
					var data_position = $(this).data('position');
					localStorage.setItem('data_position',data_position);
					
					iframe.addClass('loading');
					iframe.attr('src',data_href).css('display','block');
					$('#module-popup').modal('show');
			});
			$('#modal-popup').on('load', function(event) {
			   // event.preventDefault();		
				var iframe = $('#modal-popup');
				iframe.addClass('loading');
				var current_url = document.getElementById("modal-popup").contentWindow.location.href;
	
				iframe.contents().find('[href]').on('click', function(event) {
					iframe.addClass('loading');
				});
	
				iframe.contents().find('form').on('submit', function(event) {
					iframe.addClass('loading');
				});
				if (current_url.indexOf('extension/module') > -1) {
					MCP.refresh_module_list();
					MCP.apply();
					var data_src = 'index.php?route=avethemes/editor/modules&position=';
					if (localStorage.getItem('data_position')!==null){
						data_src+= localStorage.getItem('data_position');
					}
					iframe.attr('src',data_src).css('display','block');             
				} else {
					iframe.addClass('loading');
					iframe.contents().find('#header,#content .page-header .breadcrumb,#column-left,#footer').hide();
					iframe.contents().find('#content').css({'padding': '0px 0px 0px 0px', 'margin': '0px 0px 0px 0px'});
					iframe.removeClass('loading').show();
				}
			});
		},
		applyLayout:function (){
			if (localStorage.getItem('applyLayout')==null){
				localStorage.setItem('applyLayout','true');
				$.ajax({
						url: 'index.php?route=avethemes/editor/applylayout',
						type: 'post',
						dataType: 'json',
						data: $('#layout_modules input[type=\'text\'], #layout_modules input[type=\'hidden\']'),
						beforeSend: function() {},
						complete: function() {					
						},
						success: function(json) {			
							if (json['error']) {
									$('.design_message.message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							} 
							if (json['success']) {	
								$('.design_message.message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');					
							}
							if (json['redirect']) {
								location = json['redirect'];
							}
							localStorage.removeItem('applyLayout');
							MCP.handleLayoutModules();
						}
					});
			}
		},
        apply: function (redirect) {	
			$('.to_editor').each(function () {
				var $textArea = $(this);
				$textArea.val($(this).code());
			});
			if ($('.footer-builder-wrapper').length ) {
				$(".footer-builder-wrapper").each( function(){
	 				var output = CustomLayout.getLayoutData($(this).find(".footer-builder") );
		 		    var j = JSON.stringify(output );  
		 		    $(".hidden-content-layout",this).html( j );
	 			});
			}
			if ($('#custom_js').length ) {
				var js_editor = ace.edit("custom_js");
				js_editor.setTheme("ace/theme/jsplus");
				js_editor.getSession().setMode("ace/mode/javascript");	
				$('#custom_js').fadeIn();
				$('#custom_js_code').html(js_editor.getValue());
			}
			if ($('#custom_css').length ) {
				var css_editor = ace.edit("custom_css");
				css_editor.setTheme("ace/theme/cssplus");
				css_editor.getSession().setMode("ace/mode/css");
				$('#custom_css').fadeIn();
				$('#custom_css_code').html(css_editor.getValue());
			}		
			$.ajax({
				url: 'index.php?route=avethemes/editor/apply',
				type: 'POST',
				dataType: 'json',
				data: $('#design_editor input[type=\'text\'], #design_cp_form input[type=\'hidden\'], #design_cp_form input[type=\'radio\']:checked, #design_cp_form input[type=\'checkbox\']:checked, #design_cp_form select, #design_cp_form textarea'),
				beforeSend: function() {
					$('#button-apply').attr('disabled', true);
				},
				complete: function() {	
					$('#button-apply').attr('disabled', false);				
				},
				success: function(json) {
					if (json['error']) {
							$('.design_message.message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					} 
					if (json['success']) {
						$('.design_message.message').html('<div class="alert alert-success" ><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}	
					if (json['redirect']&&redirect==1) {
						location = json['redirect'];
					}	
					$.ajax({
						url: lquery,
						dataType: 'json',		
						success: function(json) {
							if (json['html']=='rg') {
								$('#license_info').html('Registered');
							}else{
								$('#license_info').html('Unregistered');
							}
							$('.license_field').css('background',json['bg']);
						}
					});//ajax
				}
			});
        },
        editSkin: function () {
				var skin_id = $('#design_editor').data('skin-id');
				url = 'index.php?route=avethemes/editor/editor';	
				if (skin_id) {
					url += '&skin_id=' + encodeURIComponent(skin_id);
				}	
				location = url;
        },
        changeSkin: function (val) {
			var skin_active_id = $('input[name=\'skin_active_id\']').val();
			var skin_id = val;	
			$('input[name=skin_active_id]').attr('value',val);
			url = 'index.php?route=avethemes/editor/editor';
			if (skin_id!==skin_active_id) {
				url += '&skin_id=' + encodeURIComponent(skin_id);
			}
			location = url;
			
        },
		handleAccordion: function() {
			/* Handle Accordion */
			$(".ds_accordion>.ds_content").css("display", "none");
			$(".ds_accordion>h4,.ds_accordion>.ds_heading").click(function(){
				if(!$(this).hasClass("active")){
				$(this).addClass("active").siblings('h4,.ds_heading').removeClass("active");
				var next_box_content = $(this).next(".ds_content");
				$(next_box_content).slideDown(350).siblings(".ds_content").slideUp(350);		
				}
			});	
			$('.ds_accordion h4:first-child,.ds_accordion .ds_heading:first-child').each(function(index, element) {
				$(this).click();   
			});	
		},
        initUniform: function (obj) {
        },
		initSlimScroll: function(el) {
            $(el).each(function() {
                if ($(this).attr("data-initialized")) {
                    return; // exit
                }

                var height;

                if ($(this).attr("data-height")) {
                    height = $(this).attr("data-height");
                } else {
                    height = $(this).css('height');
                }

                $(this).slimScroll({
                    allowPageScroll: true, // allow page scroll when the element scroll is ended
                    distance: '3px',
                    size: '12px',
                    color: ($(this).attr("data-handle-color") ? $(this).attr("data-handle-color") : '#46b8da'),
                    wrapperClass: ($(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
                    railColor: ($(this).attr("data-rail-color") ? $(this).attr("data-rail-color") : '#eaeaea'),
                    position: isRTL ? 'left' : 'right',
                    height: height,
                    alwaysVisible: ($(this).attr("data-always-visible") == "1" ? true : false),
                    railVisible: ($(this).attr("data-rail-visible") == "1" ? true : false),
                    disableFadeOut: true
                });

                $(this).attr("data-initialized", "1");
            });
        },
		destroySlimScroll: function(el) {
            $(el).each(function() {
                if ($(this).attr("data-initialized") === "1") { // destroy existing instance before updating the height
                    $(this).removeAttr("data-initialized");
                    $(this).removeAttr("style");

                    var attrList = {};

                    // store the custom attribures so later we will reassign.
                    if ($(this).attr("data-handle-color")) {
                        attrList["data-handle-color"] = $(this).attr("data-handle-color");
                    }
                    if ($(this).attr("data-wrapper-class")) {
                        attrList["data-wrapper-class"] = $(this).attr("data-wrapper-class");
                    }
                    if ($(this).attr("data-rail-color")) {
                        attrList["data-rail-color"] = $(this).attr("data-rail-color");
                    }
                    if ($(this).attr("data-always-visible")) {
                        attrList["data-always-visible"] = $(this).attr("data-always-visible");
                    }
                    if ($(this).attr("data-rail-visible")) {
                        attrList["data-rail-visible"] = $(this).attr("data-rail-visible");
                    }

                    $(this).slimScroll({
                        wrapperClass: ($(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
                        destroy: true
                    });

                    var the = $(this);

                    // reassign custom attributes
                    $.each(attrList, function(key, value) {
                        the.attr(key, value);
                    });

                }
            });
        },
		//public function to add callback a function which will be called on window resize
        addResizeHandler: function(func) {
            resizeHandlers.push(func);
        },
        //public functon to call _runresizeHandlers
        runResizeHandlers: function() {
            _runResizeHandlers();
        },
        switchView: function (size) {
			var cookie_size=localStorage.getItem('design_content_size');
			if(cookie_size!==size){
				$('body').removeClass(cookie_size).addClass(size);
			}
			localStorage.setItem('design_content_size',size);	
        },
        viewPerformance: function () {			
			if ($('#body_elem').length ) {
				var query =$('#body_elem').data('q');	
						$.ajax({
							url: 'assets/cache/query/'+query+'.html',
							type: 'get',
							dataType: 'html',
							success: function(query_code) {
									if(query_code!==''||query_code!==null){
										var query_decode = MCP.decode_base64(query_code);
										if(query_decode.length>100){
											$('#performance_info').html(query_decode);
										}else{
											$('#performance_info').html('<p class="text-center">Log queries timeout expired!</p>'); 
										}
									}
							}
						});
			}else{
					$('#performance_info').html('<div class="mpadding"><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>This function is not enable!<button type="button" class="close" data-dismiss="alert">&times;</button></div></div>'); 
			}
			$('#system_performance').modal('show');
        },
        reversedDesignBar: function (position) {
			if (position=='bar_left') {
				$('body').removeClass('bar_right').addClass('bar_left');
				$('.reversedbar').attr('onclick','MCP.reversedDesignBar(\'bar_right\');');
					localStorage.setItem('reversed_bar','bar_left');	
			}
			if (position=='bar_right') {
				$('body').removeClass('bar_left').addClass('bar_right');
				$('.reversedbar').attr('onclick','MCP.reversedDesignBar(\'bar_left\');');
					localStorage.setItem('reversed_bar','bar_right');	
			}
        },
		 initTooltip:function() {
				$('.tooltip').remove();
				$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});
				$('[data-tooltip=\'bottom\']').tooltip({container: 'body', html: true,placement: 'bottom'});
				if(isRTL){
					$('[data-tooltip=\'right\']').tooltip({container: 'body', html: true,placement: 'left'});
					$('[data-tooltip=\'left\']').tooltip({container: 'body', html: true,placement: 'right'});
				}else{
					$('[data-tooltip=\'right\']').tooltip({container: 'body', html: true,placement: 'right'});
					$('[data-tooltip=\'left\']').tooltip({container: 'body', html: true,placement: 'left'});
				}
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
        register: function () {
			var regdomain = 'http://www.avethemes.com/';
			var rdomain =$('#skin_config_domain').val();
			var remail =$('#skin_config_email').val();
			var purchase_code =$('#skin_purchase_code').val();
			$.ajax({
				url: regdomain+'index.php?route=support/license/api',
				type: 'post',
				dataType: 'json',
				data: 'domain=' + rdomain +'&email=' + remail +'&purchase_code=' + purchase_code,
				beforeSend: function() {
					$('.register_message alert').fadeOut(350);
				},
				success: function(json) {	
						if (json['error']) {
							$('.register_message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						} 
						if (json['success']) {	
							$('.register_message').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['text_message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							$('#skin_lic_message').val(json['success']);
							$('#skin_lic_key').val(json['license']);
							MCP.apply(0);
						}
				}
			});
        },
        init: function () {
            // init core variables
			handleDataSet();
			handleOnResize(); 
        }

    };//return
}();
jQuery(document).ready(function() {	
	MCP.init();
	$('body').on('click', '.icon-preview',function() {	
		var field = $(this).find('input').attr('id');
		if (typeof field !== 'undefined' && field !== null&& field !== false) {	
			$('#modal-icon').remove();
			var href ='index.php?route=avethemes/editor/icon&field=' + field + '&thumb=' + $(this).find('i').attr('id');
			html  = '<div id="modal-icon" class="modal-box modal fade">';
			html += '  <div class="modal-dialog modal-lg">';
			html += '    <div class="modal-content">';
			html += '      <div class="modal-header">'; 
			html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			html += '        <h4 class="modal-title">Icon Manager</h4>';
			html += '      </div>';
			html += '      <div class="modal-body modal-iframe"><iframe id="modal-iframe" frameborder="0" src="'+href+'"></iframe></div>';	
			html += '    </div';
			html += '  </div>';
			html += '</div>';	
			$('body').append(html);		
			$('#modal-icon').modal('show');
		}	
	});
});