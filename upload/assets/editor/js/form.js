if (typeof rcookie == 'undefined') {
 jQuery.rcookie=function(key,value,options){if(arguments.length>1&&String(value)!=="[object Object]"){options=jQuery.extend({},options);if(value===null||value===undefined){options.expires=-1}if(typeof options.expires==="number"){var days=options.expires,t=options.expires=new Date();t.setDate(t.getDate()+days)}value=String(value);return(document.cookie=[encodeURIComponent(key),"=",options.raw?value:encodeURIComponent(value),options.expires?"; expires="+options.expires.toUTCString():"",options.path?"; path="+options.path:"",options.domain?"; domain="+options.domain:"",options.secure?"; secure":""].join(""))}options=value||{};var result,decode=options.raw?function(s){return s}:decodeURIComponent;return(result=new RegExp("(?:^|; )"+encodeURIComponent(key)+"=([^;]*)").exec(document.cookie))?decode(result[1]):null};
}
/*!
 * jQuery lockfixed plugin
 * http://www.directlyrics.com/code/lockfixed/
 *
 * Copyright 2012 Yvo Schaap
 * Released under the MIT license
 * http://www.directlyrics.com/code/lockfixed/license.txt
 *
 * Date: Sun Feb 9 2014 12:00:01 GMT
 */
 /**/ 
(function($, undefined){
	$.extend({
		"lockfixed": function(el, config){
			if (config && config.offset) {
				config.offset.bottom = parseInt(config.offset.bottom,10);
				config.offset.top = parseInt(config.offset.top,10);
			}else{
				config.offset = {bottom: 100, top: 0};	
			}
			var el = $(el);
			if(el && el.offset()){
				var el_position = el.css("position"),
					el_margin_top = parseInt(el.css("marginTop"),10),
					el_position_top = el.css("top"),
					el_top = el.offset().top,
					pos_not_fixed = false;
				if (config.forcemargin === true || navigator.userAgent.match(/\bMSIE (4|5|6)\./) || navigator.userAgent.match(/\bOS ([0-9])_/) || navigator.userAgent.match(/\bAndroid ([0-9])\./i)){
					pos_not_fixed = true;
				}

				$(window).on('scroll resize orientationchange load lockfixed:pageupdate',el,function(e){
					// if we have a input focus don't change this (for smaller screens)
					if(pos_not_fixed && document.activeElement && document.activeElement.nodeName === "INPUT"){
						return;	
					}

					var top = 0,
						el_height = el.outerHeight(),
						el_width = $('.module_list').outerWidth(),
						max_height = $(document).height() - config.offset.bottom,
						scroll_top = $(window).scrollTop();
 
					// if element is not currently fixed position, reset measurements ( this handles DOM changes in dynamic pages )
					if (el.css("position") !== "fixed" && !pos_not_fixed) {
						el_top = el.offset().top;
						el_position_top = el.css("top");
					}
					if (scroll_top >= (el_top-(el_margin_top ? el_margin_top : 0)-config.offset.top)){

						if(max_height < (scroll_top + el_height + el_margin_top + config.offset.top)){
							top = (scroll_top + el_height + el_margin_top + config.offset.top) - max_height;
						}else{
							top = 0;	
						}
						if (pos_not_fixed){
							el.css({'marginTop': (parseInt(scroll_top - el_top - top,10) + (2 * config.offset.top))+'px'});
						}else{
							el.css({'position': 'fixed','top':(config.offset.top-top)+'px','width':el_width +"px"});
						}
					}else{
						el.css({'position': el_position,'top': el_position_top, 'width':el_width +"px", 'marginTop': (el_margin_top && !pos_not_fixed ? el_margin_top : 0)+"px"});
					}
				});	
			}
		}
	});
})(jQuery);

function getURLVarKey(key) {
	var value = [];
	
	var query = String(document.location).split('?');
	
	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');
			
			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}
		
		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
} 
	/*GENERAL HANDLE*/
var Plus = function () {	
    var isRTL = false;
    var isIE8 = false;
    var isIE9 = false;
    var isIE10 = false;	
 	var resizeHandlers = [];
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
	
	 // initializes main settings
    var handleInit = function() {
        if ($('body').css('direction') === 'rtl') {
            isRTL = true;
        }

        isIE8 = !!navigator.userAgent.match(/MSIE 8.0/);
        isIE9 = !!navigator.userAgent.match(/MSIE 9.0/);
        isIE10 = !!navigator.userAgent.match(/MSIE 10.0/);

        if (isIE10) {
            $('html').addClass('ie10'); // detect IE10 version
        }

        if (isIE10 || isIE9 || isIE8) {
            $('html').addClass('ie'); // detect IE10 version
        }
		$('.scrollbox').sortable({cursor: "move"});		
		$('.scrollbox').bind('sortupdate', function(event, ui) {
				$(element).children('div:even').attr('class','odd');	
				$(element).children('div:odd').attr('class','even');															
		});
    };
	var handleNav = function() {
        $('body .with-nav').each(function(index, element) {
				var data_id=$(this).attr('id');
				if (typeof data_id !== 'undefined' && data_id !== null&& data_id !== false) {
					$('#'+data_id).wrap('<div class="input-group"></div>');
					var nav_html ='<a class="input-group-addon input-sm" onclick="Plus.navSelect(\'prev\',\'#'+data_id+'\')"><i class="fa fa-chevron-left"></i></a>';
						nav_html +='<a class="input-group-addon input-sm" onclick="Plus.navSelect(\'next\',\'#'+data_id+'\')"><i class="fa fa-chevron-right"></i></a>';
				$('#'+data_id).after(nav_html);
				}
		});	
    };
    return {	
	
		 handleColorpicker:function() {
			$('body input.colorpicker:not(.no_clear)').each(function(index, element) {
						$(element).wrap('<div class="input-group"></div>');
						$(element).parent().children('.input-group-addon.remove_color').remove();
						var picker_html ='<a class="input-group-addon remove_color"><i class="fa fa-eraser"></i></a>';
					$(element).after(picker_html);
			});	
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
					
			});	
		},
        addObject: function (from,to,value) {
			var html = $('#'+from+' #div'+from+value).html();
			$('#'+from+' #div'+from+value).remove();
			$('#'+from+' div:even').attr('class', 'odd');	
			$('#'+from+' div:odd').attr('class', 'even');	
			
			$('#'+to+' div#'+to+value).remove();				
			$('#'+to).append('<div id="'+to+value+'">'+html+'</div>');
				
			var name = $('#'+to+value +' input').attr('data-name');
			$('#'+to+value +' input').attr('name',name).removeAttr('data-name');
			$('#'+to+value +' img').attr({'src':'../assets/theme/img/delete.png','onclick':'$(this).parent().remove();','title':'Remove'});
			
			$('#'+to+' div:even').attr('class', 'odd');	
			$('#'+to+' div:odd').attr('class', 'even');
			$('#'+to).sortable({cursor: "move"});
			$('#'+to).bind('sortupdate', function(event, ui) {
					$('#'+to).children('div:even').attr('class','odd');	
					$('#'+to).children('div:odd').attr('class','even');															
			});
			
        },
		activeObj: function(obj,val) {
			$('.'+obj).hide();
			$('.'+obj+'.otp-'+val).show();
		},
		 deactiveObj: function(obj,val) {
			$('.'+obj).show();
			$('.'+obj+'.dotp-'+val).hide();
		},
		initNav: function(obj) {			
			$(obj +' .with-nav').each(function(index, element) {
				var data_id=$(this).attr('id');
				if (typeof data_id !== 'undefined' && data_id !== null&& data_id !== false) {
				$('#'+data_id).wrap('<div class="input-group"></div>');
				$('#'+data_id).after('<a onclick="Plus.navSelect(\'prev\',\'#'+data_id+'\')" class="input-group-addon input-sm"><i class="fa fa-chevron-left"></i></a><a onclick="Plus.navSelect(\'next\',\'#'+data_id+'\')" class="input-group-addon input-sm"><i class="fa fa-chevron-right"></i></a>');
				}
			});	
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
				var newval=val-1;
				$(obj).attr('value',(newval>lim)?newval:lim);
			}else{	
				var newval=val+1;
				$(obj).attr('value',(newval<lim)?newval:lim);
			}
			$(obj).trigger('change');
		},
		handleAccordion: function() {
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
                    size: '10px',
                    color: ($(this).attr("data-handle-color") ? $(this).attr("data-handle-color") : '#428bca'),
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
		handleThumbview:function() {
			/* CONFIG */
				
				xOffset = -30;
				yOffset = -30;
				
				// these 2 variable determine popup's distance from the cursor
				// you might want to adjust to get the right result
				
			/* END CONFIG */
			$("#module_list .module-block").hover(function(e){
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
			handleOnResize(); 
			handleNav();
			Plus.handleColorpicker();
			Plus.handleThumbview();
        }

    };//return
}(); 
$(document).ready(function() { 
	Plus.handleAccordion(); 
	
	$('a[data-toggle="image-upload"]').after('<i class="fa fa-trash-o clear-img"></i>');
								
	$('body').on('click', '.clear-img',function() {	
		$(this).parent().find('input').attr('value','');
		$(this).parent().find('a img').attr('src','../image/placeholder.png');
	});
	$('body').on('click', '.clear-ico',function() {	
		$(this).parent().parent().find('input').attr('value','');
		$(this).parent().find('.icon-preview>i').attr('class','');
	});
	$('.nav-tabs li:first-child a').each(function(index, element) {
		if(!$(element).parent('li').hasClass('active')){
			$(element).trigger('click');  
		}
	});	
			
	$('.tr_change').trigger('change');	
	$('.tr_click').trigger('click');
	
	$('.to_editor').each(function(index, element){
		var data_id=$(element).attr('id');	
		$('#' + data_id).summernote({height: 300});
	});
	 //Do stuff here
	$(document).on('hide.bs.modal','.modal-box', function () {
			$('body').removeClass('modal-open');
			parent.$('iframe').removeClass('loading');
	});
	$(document).delegate('.modalbox', 'click', function(element) {
				element.preventDefault();
							
				var element = this;
				
				var href = $(element).attr('href')+'&with_iframe=true';
				var title = $(element).attr('data-title');
				if (title == ''||title == null) {
					title = $(element).text();
				}
				
				var data_id ='modal-box';
				if ($(element).attr('data-id') != undefined) {
					data_id = $(element).attr('data-id');
				}else{
					data_id='modal-box';
				}
				
				var type ='modal-lg';
				if ($(element).attr('data-size') != undefined) {
					size = $(element).attr('data-size');
				}else{
					size='modal-lg';
				}
				var type ='html';
				if ($(element).attr('data-type') != undefined) {
					type = $(element).attr('data-type');
				} else if($(element).hasClass('modalbox')){
					type='html';
				}else{
					type='iframe';
				}
				if ($(element).attr('data-backdrop')=='false') {
					$('body').addClass('hidden-backdrop'); 				
				}else{
					$('body').removeClass('hidden-backdrop');
				}
				if ($(element).attr('data-sandbox') != undefined) {
					sandbox = true;
				}else{
					sandbox = false;
				}
				
				if(type=='iframe'){					
					$('#'+data_id).remove(); 				
					html  = '<div id="'+data_id+'" class="modal-box modal fade">';
					html += '  <div class="modal-dialog '+size+'">';
					html += '    <div class="modal-content">';		
					html += '<div class="modal-header">';	
					html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
					html += '<h4 class="modal-title">'+title+'</h4>';	
					html += '</div>';	
					html += '      <div class="modal-body modal-iframe"><iframe '+sandbox+' id="modal-iframe" frameborder="0" src=""></iframe></div>';		
					html += '    </div';
					html += '  </div>';
					html += '</div>';	
					$('body').append(html);				
					$('#modal-iframe').attr('src',href);	
					if(sandbox==true){
						$("iframe").load(function() {
							$("iframe").contents().find("a").each(function(index) {
								$(this).on("click", function(event) {
									event.preventDefault();
									event.stopPropagation();
								});
							});
						});
					}	
					$('#'+data_id).modal('show');
				}else{
					$('#'+data_id).remove(); 		
					$.ajax({
						url:href,
						type: 'get',
						dataType: 'html',
						success: function(data) {	
							html  = '<div id="'+data_id+'" class="modal-box modal fade">';
							html += '  <div class="modal-dialog '+size+'">';
							html += '    <div class="modal-content">';
							html += '<div class="modal-header">';	
							html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
							html += '<h4 class="modal-title">'+title+'</h4>';	
							html += '</div>';	
							html += '      <div class="modal-body modal-html">' + data + '</div>';			
							html += '    </div';
							html += '  </div>';
							html += '</div>';	
							$('body').append(html);				
							$('#'+data_id).modal('show');
						}
					});		
				}
				
	});
	$('body').on('click', '.icon-preview',function() {	
		var field = $(this).find('input').attr('id');
		if (typeof field !== 'undefined' && field !== null&& field !== false) {	
			$('#modal-icon').remove();
			var href ='../index.php?route=avethemes/editor/icon&field=' + field + '&thumb=' + $(this).find('i').attr('id');
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
	
	$('body').on('click', '.bg-preset',function() {	
		var field = $(this).find('input').attr('id');
		if (typeof field !== 'undefined' && field !== null&& field !== false) {	
			$('#modal-bg-preset').remove();
			var href ='../index.php?route=avethemes/editor/bg_preset&field=' + field + '&thumb=' + $(this).find('i').attr('id');
			html  = '<div id="modal-bg-preset" class="modal-box modal fade">';
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
			$('#modal-bg-preset').modal('show');
		}	
	}); 
});

function image_upload(field, thumb) {
			var filemanager_path = 'index.php?route=ave/image_manager_plus/filemanager' + '&field=' + field + '&thumb=' + thumb+'&token=' + getURLVar('token');
			$('#modal-image-editor').remove();
			var fhtml  = '<div id="modal-image-editor" class="modal-box modal fade">';
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
			$('#modal-image-editor').modal('show');
 }