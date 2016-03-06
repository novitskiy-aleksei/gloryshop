function scrollTo(el, offeset) {
	var pos = ($(el) && $(el).size() > 0) ? $(el).offset().top : 0;
	if ($(el)) {
		if ($('body').hasClass('page-header-fixed')) {
			pos = pos - $('.header').height(); 
		}            
		pos = pos + (offeset ? offeset : -1 * $(el).height());
	}
	jQuery('html,body').animate({
		scrollTop: pos
	}, 'slow');
}
function getURLVar(key) {
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
function activeObj(obj,val) {
	$('.'+obj).hide();
	$('.'+obj+'.otp-'+val).show();
}
// Autocomplete */
(function($) {
	$.fn.autocomplete = function(option) {
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
	
				value = $(event.target).parent().attr('data-value');
	
				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}
			
			// Show
			this.show = function() {
				var pos = $(this).position();
	
				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});
	
				$(this).siblings('ul.dropdown-menu').show();
			}
			
			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
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
				$(this).siblings('ul.dropdown-menu').remove();
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
			
			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));	
			
		});
	}
})(window.jQuery);

$(document).ready(function() {
	

	// Highlight any found errors
	$('.text-danger').each(function() {
		var element = $(this).parent().parent();
		
		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});
		
	// Currency
	$('body').on('click touchstart', '#currency .currency-select',function(e) {
		e.preventDefault();

		$('#currency input[name=\'code\']').attr('value', $(this).attr('href'));

		$('#currency').submit();
	});

	// Language
	$('body').on('click touchstart', '#language a',function(e) {	
		e.preventDefault();

		$('#language input[name=\'code\']').attr('value', $(this).attr('href'));

		$('#language').submit();
	});
	$('.nav_search.active input[name=\'search\']').on('keydown', function(e) {
		if (e.keyCode == 13) {
			$('header input[name=\'search\']').parent().find('.nav_search_handle').trigger('click');
		}
	});
	$('.nav_search.active .nav_search_handle').on('click touchstart', function() {
			url = 'index.php?route=product/search';
			
			var filter_name = $('.nav_search input[name=\'search\']').val();
			
			if (filter_name) {
				url += '&search=' + encodeURIComponent(filter_name);
			}
			location = url;
	});
	
	// Product List
	$('body').on('click touchstart', '#list-view',function() {
		$(this).attr('class','btn btn-primary');
		$('#grid-view').attr('class','btn btn-default');
		
		$('#content div.clearfix.clear_row').remove();
		$('#content #product-layout').removeClass('row elem_item_grid').addClass('elem_item_list');
		$('#content #product-layout > div').attr('class','item_list_block');	
		$('#content #product-layout> div> div').attr('class','clearfix');	
		$('#product-layout > div').each(function(index, element) {			
			var desc = $(element).find('.desc').html();
						$(element).find('.desc').remove();	
						$(element).find('.item_desc').attr('class','item_desc');
						$(element).find('.button-group').attr('class','button-group');
						$(element).find('.button-group').find('.btn').addClass('btn-primary');
			$(element).find('.item_price_group').after('<p class="desc">'+desc+'</p>');
			
		});
		
		localStorage.setItem('display', 'list');
	});

	// Product Grid
	$('#grid-view').click(function() {
		$(this).attr('class','btn btn-primary');
		$('#list-view').attr('class','btn btn-default');
		$('#content div.clearfix.clear_row').remove();
		$('#content #product-layout').removeClass('elem_item_list').addClass('row elem_item_grid');
		$('#content #product-layout > div > div').attr('class','item_list_block');	

		$('#product-layout > div').each(function(index, element) {			
			var desc = $(element).find('.desc').html();			
						$(element).find('.desc').remove();		
						$(element).find('.item_desc').attr('class','item_desc clearfix');
						$(element).find('.button-group').attr('class','button-group btn-cart-group');
						$(element).find('.button-group').find('.btn').removeClass('btn-primary');
			var href = $(element).find('.item_product_name').attr('href');				
			$(element).find('img').before('<a href="'+href+'" class="desc">'+desc+'</a>');
		});
		// What a shame bootstrap does not take into account dynamically loaded columns
		cols = $('#column-right, #column-left').length;

		if (cols == 2) {
			$('#content #product-layout>div').attr('class', 'col-lg-6 col-md-6 col-sm-12 col-xs-12');
		} else if (cols == 1) {
			$('#content #product-layout>div').attr('class', 'col-lg-4 col-md-4 col-sm-6 col-xs-12');
		} else {
			$('#content #product-layout>div').attr('class', 'col-lg-3 col-md-3 col-sm-6 col-xs-12');
		}
		// Adding the clear Fix
		cols1 = $('#column-right, #column-left').length;
		
		if (cols1 == 2) {
			$('#content #product-layout>div:nth-child(2n+2)').after('<div class="clearfix clear_row visible-md visible-sm"></div>');
		} else if (cols1 == 1) {
			$('#content #product-layout>div:nth-child(3n+3)').after('<div class="clearfix clear_row visible-lg"></div>');
		} else {
			$('#content #product-layout>div:nth-child(4n+4)').after('<div class="clearfix clear_row"></div>');
		}
		 localStorage.setItem('display', 'grid');
	});

	if (localStorage.getItem('display') == 'list') {
		$('#list-view').trigger('click');
	} else {
		$('#grid-view').trigger('click');
	}

	// tooltips on hover
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});

	// Makes tooltips work on ajax generated content
	$(document).ajaxStop(function() {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	});
});

// Cart add remove functions
var cart = {
	'add': function(product_id, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function() {
				//$('#cart > button').button('loading');
			},
			complete: function() {
				//$('#cart > button').button('reset');
			},			
			success: function(json) {
				$('.alert, .text-danger').remove();

				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					if ($('.notification').length) {
						$('.notification').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('.notification').find('a').attr('target','_parent');//modify frame target
					}else{					
						$('.notify').remove();
					$('#page_wrapper').append('<div class="notify"><div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
						$('.notify').addClass('active');
					}

					$('#cart').load('index.php?route=common/cart/info');
				}
			}
		});
	},
	'update': function(key, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/edit',
			type: 'post',
			data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function() {
				//$('#cart > button').button('loading');
			},
			complete: function() {
				//$('#cart > button').button('reset');
			},			
			success: function(json) {

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart').load('index.php?route=common/cart/info');
				}
			}
		});
	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				//$('#cart > button').button('loading');
			},
			complete: function() {
				//$('#cart > button').button('reset');
			},			
			success: function(json) {
					
				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart').load('index.php?route=common/cart/info');
				}
			}
		});
	}
}

var voucher = {
	'add': function() {

	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart').load('index.php?route=common/cart/info');
				}
			}
		});
	}
}

var wishlist = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$('.alert').remove();
				if (json['success']) {
					if ($('.notification').length) {
						$('.notification').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('.notification').find('a').attr('target','_parent');//modify frame target
					}else{
					$('.notify').remove();
					$('#page_wrapper').append('<div class="notify"><div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
					$('.notify').addClass('active');
					}
					
				}

				if (json['info']) {
					if ($('.notification').length) {
						$('.notification').html('<div class="notify"><div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['info'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
						$('.notification').find('a').attr('target','_parent');//modify frame target
					}else{
					$('.notify').remove();
					$('#page_wrapper').append('<div class="notify"><div class="alert alert-info"><i class="fa fa-info-circle"></i> ' + json['info'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
					$('.notify').addClass('active');
					}
				}

				
				$('#wishlist-total span').html(json['total']);
				$('#wishlist-total').attr('title', json['total']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}
		});
	},
	'remove': function() {

	}
}

var compare = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$('.alert').remove();

				if (json['success']) {
					if ($('.notification').length) {
						$('.notification').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('.notification').find('a').attr('target','_parent');//modify frame target
					}else{
						$('.notify').remove();
						$('#page_wrapper').append('<div class="notify"><div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div></div>');
						$('.notify').addClass('active');
					}
					$('#compare-total').html(json['total']);

					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}
			}
		});
	},
	'remove': function() {

	}
}

var isRTL = false;
var site_dark = ( $("body").hasClass("body_dark") ? "yes" : "no" );
var text_direction = "ltr";
if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
	text_direction = "rtl";
	isRTL = true;
};

var Ave = function () {
		
    var handleInit = function() { 
		/* Ajax header - help reduce the number of cached pages. */		
		$('#cart').load('index.php?route=common/cart/info');
		$.ajax({
			url: 'index.php?route=avethemes/common/ajax_header',
			dataType: 'json',
			success: function(json) {
				if (json['whistlist']) {
					$("#top-wishlist").html(json['whistlist']);
				}
				if (json['account']) {
					$("#top-account").html(json['account']);
				}
			}
		}); 
		handleModalbox();
		handleTabs();
		handleAccordion();
	}
	var handleModalbox = function(){	
			/* Modal */
			$(document).delegate('.agree,.colorbox,.modalbox', 'click', function(e) {
				e.preventDefault();
				$('#modal-box').remove(); 
				
				var element = this;
				var href = $(element).attr('href');
				var title = $(element).attr('data-title');
				if (title == ''||title == null) {
					title = $(element).attr('title');
				}
				if (title == ''||title == null) {
					title = $(element).text();
				}
				if ($(element).attr('data-type') != undefined) {
					type = $(element).attr('data-type');
				} else if($(element).hasClass('colorbox')||$(element).hasClass('modalbox')){
					type='html';
				}else{
					type='iframe';
				}
				if(type=='iframe'){
					html  = '<div id="modal-box" class="modal-box modal fade">';
					html += '  <div class="modal-dialog modal-lg">';
					html += '    <div class="modal-content">';
					html += '      <div class="modal-header">'; 
					html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
					html += '        <h4 class="modal-title">' + title + '&nbsp;</h4>';
					html += '      </div>';
					html += '      <div class="modal-body modal-iframe"><iframe frameborder="0" src="'+href+'"></iframe></div>';
					html += '    </div';
					html += '  </div>';
					html += '</div>';	
					$('body').append(html);				
					$('#modal-box').modal('show');		
				}else{
					$.ajax({
						url:href,
						type: 'get',
						dataType: 'html',
						success: function(data) {	
							html  = '<div id="modal-box" class="modal-box modal fade">';
							html += '  <div class="modal-dialog modal-lg">';
							html += '    <div class="modal-content">';
							html += '      <div class="modal-header">'; 
							html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
							html += '        <h4 class="modal-title">' + title + '&nbsp;</h4>';
							html += '      </div>';
							html += '      <div class="modal-body modal-html">' + data + '</div>';	
							html += '    </div';
							html += '  </div>';
							html += '</div>';	
							$('body').append(html);				
							$('#modal-box').modal('show');
						}
					});		
				}
			
			});
			$('.modal-header .close').on('click touchstart', function() {		
				$('.modal-backdrop').remove(); 
				$('body').removeClass('modal-open'); 
			});
					
	}
// Handles Bootstrap Tabs.
    var handleTabs = function () {
        //activate tab if tab id provided in the URL
        if (location.hash) {
            var tabid = location.hash.substr(1);
            $('a[href="#' + tabid + '"]').click();
        }
    }
   	
    var handleAccordion = function() {
		$(".elem_accordion").each(function(index, element) {
            var its_type = $(this).attr("data-type");
			var its_item = $(this).find(".elem_accordion_container");
			var its_item_lenth = its_item.length;
			
			its_item.each(function(index, element) {
				var item_item = $(this);				
				var item_item_title = $(this).find(".elem_accordion_title");
				var item_title_height = $(this).find(".elem_accordion_title").outerHeight();
                var item_expanded = item_item.attr("data-expanded");  //false - true
				var item_item_content = $(this).find(".elem_accordion_content");
				var item_item_height = item_item_content.find(".acc_content").outerHeight();
				
				if(item_expanded == "true"){//accordion_expanded
					item_item.addClass("accordion_expanded");
					item_item_content.stop(true, true).animate({
					   height : item_item_height+'px',
					}, 300 );
				}
				item_item_title.unbind();
				item_item_title.click(function(event){
					if(item_item.hasClass("accordion_expanded")){
						item_item.removeClass("accordion_expanded");
						item_item_content.stop(true, true).animate({
						   height : '0px',
					  	}, 300 );
						item_item_content.closest('.content_filter_item').stop(true, true).animate({
						   height : item_title_height+10+'px',
					  	}, 300 );
						
					}else{
						item_item.addClass("accordion_expanded");
						item_item_content.stop(true, true).animate({
						   height : item_item_height+'px',
					  	}, 300 );
						item_item_content.closest('.content_filter_item').stop(true, true).animate({
						   height : item_item_height+item_title_height+10+'px',
					  	}, 300 );
						//--------> Accordion Type
						if(its_type == "accordion"){
							item_item.siblings().removeClass("accordion_expanded");
							item_item.siblings().find(".elem_accordion_content").stop(true, true).animate({
							   height : '0px',
							}, 300 );
						}
					}
				});
				
            });

        });
	}
    return {
		handleQuickview: function(){
			$('.with-quickview .btn-quick-view').on('click touchstart', function(e) {
					e.preventDefault();
					var element = this;
					var href = 'index.php?route=avethemes/widget/quickview&product_id='+$(element).attr('data-id');
		
					$('#modal-box').remove(); 
					
					var element = this;
					var title = $(element).attr('data-text');
					if (title == ''||title == null) {
						title = $(element).attr('title');
					}
					$.ajax({
						url:href,
						type: 'get',
						dataType: 'html',
						success: function(data) {	
							html  = '<div id="modal-box" class="modal-box modal fade">';
							html += '  <div class="modal-dialog modal-lg">';
							html += '    <div class="modal-content">';
							html += '      <div class="modal-header">'; 
							html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
							html += '        <h4 class="modal-title">' + title + '&nbsp;</h4>';
							html += '      </div>';
							html += '      <div class="modal-body modal-html">' + data + '</div>';	
							html += '    </div';
							html += '  </div>';
							html += '</div>';	
							$('body').append(html);				
							$('#modal-box').modal('show');
						}
					});
				
			});
			$('.modal-header .close').on('click touchstart', function() {		
				$('.modal-backdrop').remove(); 
				$('body').removeClass('modal-open'); 
			});
	
	},
		handleSlimScroll: function(scroll_elem){
					$(scroll_elem).slimScroll({
						allowPageScroll: true, // allow page scroll when the element scroll is ended
						size: '10px',
						color: ($(scroll_elem).attr("data-handle-color")  ? $(this).attr("data-handle-color") : '#bbb'),
						wrapperClass: ($(scroll_elem).attr("data-wrapper-class")  ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
						railColor: ($(scroll_elem).attr("data-rail-color")  ? $(this).attr("data-rail-color") : '#eaeaea'),
						position: isRTL ? 'left' : 'right',
						//height: $(scroll_elem).css('height'),
						height: ($(scroll_elem).css('height')>0)?$(scroll_elem).css('height'):300,
						distance: '2px',
						alwaysVisible: ($(scroll_elem).attr("data-always-visible") == "1" ? true : false),
						railVisible: ($(scroll_elem).attr("data-rail-visible") == "1" ? true : false),
						disableFadeOut: true
					});
					$(scroll_elem).attr("data-initialized", "1");
		},
		handleElevateZoom: function (el,otps) {
				$(".zoomContainer").remove();	
				wwidth=$(window).width();	
				if(wwidth>992){
						$(el).elevateZoom(otps['desktop']); 
				}
				if(wwidth>768&&wwidth<992){
					$(el).elevateZoom(otps['tablet']); 		
				}
				if(wwidth<768){
					$(el).elevateZoom(otps['mobile']); 	
				}
				$(window).resize(function() {
					$(".zoomContainer").remove();	
					$('#additional_images a:first').click();
					var win_width=$(window).width();
					if(win_width>992){
						$(el).elevateZoom(otps['desktop']); 
					}
					if(win_width>768&&win_width<992){
						$(el).elevateZoom(otps['tablet']); 	
					}
					if(win_width<768){
						$(el).elevateZoom(otps['mobile']); 
					}
				});
	},
	init: function () {
			handleInit();
			Ave.handleQuickview();
				if($(".image_menu_slide").length > 0){
				var image_menu_slide =  $(".image_menu_slide");
				var navigation_aside = "navigation_aside";
				var side_menu_res_a = $("body").hasClass(navigation_aside) ? 1 : 3;
				var side_menu_res_b = $("body").hasClass(navigation_aside) ? 1 : 4;
		
				image_menu_slide.owlCarousel({
					 rtl: isRTL,
					margin: 10,
					 items:side_menu_res_b,
					 autoplay: false,
					autoplayTimeout:3000,
					 stopOnHover : true,
					 responsive: {
						0: {items: 1},
						479: {items: 2},
						768: {items: side_menu_res_a},
						979: {items: side_menu_res_b}
					},
					 nav:true,
					 navText: [
						"<i class='menu_img_prev fa fa-navigate-before'></i>",
						"<i class='menu_img_next fa fa-navigate-next'></i>"
					],
				});
			}
        }

    };//return
}();
// End Ave	

//----------> Site Preloader	
$(window).load(function() {	
	$('body>#preloader').fadeOut(500, function(){
	 }); 
});	
$(document).ready(function(){
	//-----------> handleNavigation	
		Ave.init();
			
		//----------> Top Bar Expand
		$(".top_expande").on("click", function(){ 
			var $thiss = $(this);
			var $conta = $thiss.siblings(".content");
			if($thiss.hasClass("not_expanded")){
				$($conta).stop().slideDown(300, function(){
					$thiss.removeClass("not_expanded");
				});
			}else{
				$($conta).stop().slideUp(300, function(){
					$thiss.addClass("not_expanded");
				});
			}
		});
		
		$("ul.sitemap li").each(function(index, element) {
            $(this).has( "ul" ).addClass( "has_child_sitmap" );
			if($(this).hasClass("has_child_sitmap")){
				var num_child = $(this).find(" > ul > li").length;
				$(this).append('<span class="sitemap_count">' + num_child +'</span>');
			}
			
        });
		//-----------> Parallax 
		if ( $.isFunction($.fn.parallax) ) {
			$('.ave_parallax,.ave_parallax1').parallax("50%", 0.1);
			$('.ave_parallax2').parallax("50%", 0.2);
			$('.ave_parallax3').parallax("50%", 0.3);
			$('.ave_parallax4').parallax("50%", 0.4);
			$('.ave_parallax5').parallax("50%", 0.5);
			$('.ave_parallax6').parallax("50%", 0.6);
			$('.ave_parallax7').parallax("50%", 0.7);
			$('.ave_parallax8').parallax("50%", 0.8);
			$('.ave_parallax9').parallax("50%", 0.9);
		}
		//-----------> Tree Features
		$(".tree_features li").each(function(index, element) {
            var bg_color = $(this).attr("data-bgcolor");
			$(this).append("<span class='tree_curv'></span>");
			$(this).css({"background-color" : bg_color});
			$(this).find(".tree_curv").css({"background-color" : bg_color});
        });
		//=====> Four Boxes Slider
		if (typeof BoxesFx !== 'undefined' && $.isFunction(BoxesFx)) {
			var boxesfx_gall = new BoxesFx( document.getElementById( 'boxgallery' ) );
		}
		
		//=====> scattered Slider
		if (typeof Photostack !== 'undefined' && $.isFunction(Photostack)) {
			// [].slice.call( document.querySelectorAll( '.photostack' ) ).forEach( function( el ) { new Photostack( el ); } );
			var photostack_a = new Photostack( document.getElementById( 'photostack-1' ), {
				callback : function( item ) {
					//console.log(item)
				}
			} );
			var photostack_b = new Photostack( document.getElementById( 'photostack-2' ), {
				callback : function( item ) {
					//console.log(item)
				}
			} );
			var photostack_c = new Photostack( document.getElementById( 'photostack-3' ), {
				callback : function( item ) {
					//console.log(item)
				}
			} );
		}
		//=====> Camera Slider
		if ( $.isFunction($.fn.camera) ) {
			$("#camera_wrap_1").each(function(){
					var c1 = $(this);
					c1.camera({
						thumbnails: true,
					});
			});
			
			$("#camera_wrap_2").each(function(){
					var c2 = $(this);
					c2.camera({
						height: '550px',
						loader: 'bar',
						loaderColor:"#0dc0c0",
						loaderBgColor:"none",
						loaderOpacity:0.7,
						loaderPadding:0,
						loaderStroke:5,
						dots: false,
						thumbnails: true
					});
			});
		}
		
		//=====> Back To Top
		var to_top_offset = 300,
		to_top_offset_opacity = 1200,
		scroll_top_duration = 900,
		$back_to_top = $('.back_to_top');
		$(window).scroll(function(){
			if($(this).scrollTop() > to_top_offset ){
				$back_to_top.addClass('back_top_is-visible');
			} else{
				$back_to_top.removeClass('back_top_is-visible back_top_fade-out');
			}
			if( $(this).scrollTop() > to_top_offset_opacity ) { 
				$back_to_top.addClass('back_top_fade-out');
			}
			return false;
		});
		$back_to_top.on('click touchstart', function(event){
			event.preventDefault();
			$('body,html').animate({
				scrollTop: 0,
				//easing : "easeOutElastic"
				}, {queue:false, duration: scroll_top_duration, easing:"easeInOutExpo"}
			);
		});
	    
		$(window).scroll(function(){
			if($(this).scrollTop() > 30 && $("body").hasClass("body_boxed") && $("body").hasClass("navigation_aside") ){
				$("#side_header").addClass("start_side_offset");
			}else{
				$("#side_header").removeClass("start_side_offset");
			}
		});
		
		//=====> heading_title icon
		$(".section:not(.bg_gray)").each(function(index, element) {
			var color = '';
            var section_bg = $(this).css('backgroundColor');
			var parts = section_bg.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
			if ( parts !== null ){
				delete(parts[0]);
				for (var i = 1; i <= 3; ++i) {
					parts[i] = parseInt(parts[i]).toString(16);
					if (parts[i].length == 1) parts[i] = '0' + parts[i];
				}
				color = '#' + parts.join('');
				$(this).find(".heading_title .line i").css({"background-color" : color});
				$(this).find(".heading_title .line .dot").css({"background-color" : color});
			}
			
        });
		//=====> Dialog Lightbox
		$("[data-dialog]").each(function(index, element) {
            var dialog_btn = element,
				dialog_name = document.getElementById( dialog_btn.getAttribute( 'data-dialog' ) ),
			    my_dlg = new DialogFx( dialog_name );
				dialog_btn.addEventListener( 'click', my_dlg.toggle.bind(my_dlg) );
        });
		/**/ 
		//=====> Portfolio hoverdir
		
		$('.ave_full_desc .isotope_filter_wrapper_con > .filter_item_block ').each( function() { 
			$(this).hoverdir({
				hoverElem : '.ave_desc'
			}); 
		});
		$('.has_hoverdir .featured_slide_block').each( function() { 
			$(this).hoverdir({
				hoverElem : '.hoverdir_con'
			}); 
		});
			
		//=====> Counter
		$('.counter').appear(function() {
			$(this).children('.value').countTo();
		});
		
		//=====> Masonry Blogs
		$(".masonry_posts.colored_masonry .item_list_block").each(function(index, element) {
			var bg_color = $(this).data("bg");
			$(this).find(".blog_grid_desc, .blog_grid_format i").css({ "background" : bg_color});
		});
		
		//=====> Animation Progress Bars
		$("[data-progress-val]").each(function() {
		
			var $this = $(this);
			
			$this.appear(function() {
				var con_width = $this.width();
				var title_width = $this.find(".title").width();
				var value_width = $this.find(".value").width();
				var fill_percent = $this.attr("data-progress-val");
				var fill_width = con_width*(fill_percent/100);
				//alert(fill_width);
				
				if(fill_width <= value_width + title_width){
					$this.find(".fill").addClass("small_line_bar");
					$this.find(".value").css({"opacity" : 0, "right" : - title_width});
				}
							
				var delay = ($this.attr("data-progress-delay") ? $this.attr("data-progress-delay") : 1);
				var animation_type = ($this.attr("data-progress-animation") ? $this.attr("data-progress-animation") : "easeOutBounce");
			    var bg_color = ($this.attr("data-progress-color") ? $this.attr("data-progress-color") : "");
				$this.find(".fill").css({"background" : bg_color});
				
				if(delay > 1) $this.css("animation-delay", delay + "ms");
				$this.find(".fill").addClass($this.attr("data-appear-animation"));
			
				setTimeout(function() {
					if(fill_width <= value_width + title_width){
						$this.find(".value").animate({ opacity: 1 });
					}
					
					$this.find(".fill").animate({
							width: $this.attr("data-progress-val")+'%',
						}, 1500, animation_type, function() {
                            if(text_direction == "ltr"){							
								$this.find(".title").animate({
									opacity: 1,
									left: 0
								}, 1500, animation_type);
							}else{
								$this.find(".title").animate({
									opacity: 1,
									right: 0
								}, 1500, animation_type);
							}
					});
					
					$this.find(".value .num").countTo({
						from: 0,
						to: $this.attr("data-progress-val"),
						speed: 1500,
						refreshInterval: 50,
					});
			
				}, delay);
												
			}, {accX: 0, accY: -50});
		
		}); 
		//=====> Team Boxes 3
		$('.item_block3').each(function() {
			var num = 0;
            $('.team-col').each(function(index) {
				var bg_color = $(this).attr("data-color");
				num += 1;
				if(num == 3 || num == 4){
					$(this).addClass("team_col_on_right");
				}
				if(num == 4 ){
					num = 0;
				}
				//=====> Set Background Color
				if (typeof bg_color !== typeof undefined && bg_color !== false) {
					$(this).css({ "background" : bg_color});
					$(this).find(".arrow").css({ "background" : bg_color});
				}
			});
        });
		//=====> Price Filters
		
		
	    //=====> Animated
		$('.with-animated .animated').appear(function() {
			var elem = $(this);
			var animation = elem.data('animation');
			if ( !elem.hasClass('visible') ) {
				var animationDelay = elem.data('animation-delay');
				if ( animationDelay ) {
	
					setTimeout(function(){
						elem.addClass( animation + " visible" );
						elem.removeClass('hiding');
					}, animationDelay);
	
				} else {
					elem.addClass( animation + " visible" );
					elem.removeClass('hiding');
				}
			}
		});
		
		//=====> Scroll Easing
		$('.scroll').on('click touchstart', function(event) {
			var $anchor = $(this);
			var headerH = $('#navigation_bar').outerHeight();
			var my_offset = 0;
			
			if($(this).hasClass("reviews_navigate")){
				var rev_tab = $("a[data-content='reviews']");
				$(rev_tab).click(); 
			}
			if($(this).hasClass("onepage")){
				my_offset = headerH - 2;
			}
			$('html, body').stop().animate({
				scrollTop : $($anchor.attr('href')).offset().top - my_offset + "px"
			}, 1200, 'easeInOutExpo');
			event.preventDefault();
		});
		
		//----=====> Single Product Number Of Items
		$(".quantity_controll").on("click", function() {
			
			var $button = $(this);
			var oldValue = $button.siblings('.input-text').val();
			var newVal;
			
			if ($button.hasClass('plus')) {
				newVal = parseFloat(oldValue) + 1;
			} else {
				if (oldValue > 1) {
			  		newVal = parseFloat(oldValue) - 1;
					
				} else {
			  		newVal = 1;
				}
			}
			$button.siblings('.input-text').val(newVal);
		});
		
		$('.comment-form-rating .stars a').on("click", function() {
			var data_rel = $(this).attr("data-rate");
        	$(this).addClass('active').siblings().removeClass('active');
			$("select#rating").val(data_rel);
			return false;
        });	
			
		$('a.remove').on("click", function() {
        	$(this).closest('tr').fadeOut();
			return false;
        });	
		//=====> End Single Product
		
		//=====> Tabs
		$('.elem-tabs').each(function(index) {
			var allparent = $(this);
			var all_width = allparent.width();
						
			var tabItems = allparent.find('.tabs-navi a'),
			tabContentWrapper = allparent.find('.tabs-body');
	        
			tabItems.on('click touchstart', function(event){
				event.preventDefault();
				
				var selectedItem = $(this);
				var parentlist = selectedItem.parent();
				
				if(parentlist.index() === 0){
				    selectedItem.parent().siblings("li").removeClass('prev_selected');
				}else{
					selectedItem.parent().prev().addClass('prev_selected').siblings("li").removeClass('prev_selected');
				}
				
				if( !selectedItem.hasClass('selected') ) {
					var selectedTab = selectedItem.data('content'),
						selectedContent = tabContentWrapper.find('li[data-content="'+selectedTab+'"]'),
						slectedContentHeight = selectedContent.innerHeight();
					
					tabItems.removeClass('selected');
					selectedItem.addClass('selected');
					selectedContent.addClass('selected').siblings('li').removeClass('selected');
					//animate tabContentWrapper height when content changes 
					tabContentWrapper.animate({
						'height': 'auto'
					}, 200);
				}
			});
		
			//hide the .elem-tabs::after element when tabbed navigation has scrolled to the end (mobile version)
			checkScrolling($('.elem-tabs nav'));
			$(window).on('resize', function(){
				checkScrolling($('.elem-tabs nav'));
				tabContentWrapper.css('height', 'auto');
			});
			$('.elem-tabs nav').on('scroll', function(){ 
				checkScrolling($(this));
			});
			
			function checkScrolling(tabs){
				var totalTabWidth = parseInt(tabs.children('.tabs-navi').width()),
					tabsViewport = parseInt(tabs.width());
				if( tabs.scrollLeft() >= totalTabWidth - tabsViewport) {
					tabs.parent('.elem-tabs').addClass('is-ended');
				} else {
					tabs.parent('.elem-tabs').removeClass('is-ended');
				}
			}
		
		});
		
		//=====> /* Ajax Cart*/
		$('body').on('click touchstart', '.nav_cart_toggle', function (event) {
				var parent = $(this).parent();
				event.preventDefault();
				event.stopPropagation();
				
				if(parent.hasClass('active')){
					$('.nav_cart_content').fadeOut();
					parent.removeClass('active');
				}else{
					$.ajax({
						url: 'index.php?route=common/cart/info',
						type: 'get',
						dataType: 'html',
						beforeSend: function() {				
						},
						success: function(html) {							
							parent.html(html);
						},
						complete: function() {	
							Ave.handleSlimScroll('.nav_cart_block');
						}
					});//ajax
					$('#page_header .search-widget').removeClass('active');
					parent.addClass('active');
					$('.nav_cart_content').fadeIn();
				}
				$('body').on('click touchstart', '.nav_cart_header', function () {
					parent.removeClass('active');
					$('.nav_cart_content').fadeOut();
				});
				//var scroll_elem = parent.find('.nav_cart_block');
		});
		//=====> Circle Progress Bars
				
		$(".elem_circle_progressbar").each(function(index, element) {
			var $this_this = $(this);
			//if ( $.isFunction($.fn.ProgressBar) ) {
				$(this).appear(function() {
					var elem_delay = ($(this).attr("data-delay") ? $(this).attr("data-delay") : 1);
					var elem_percenty = $(this).attr("data-percentag") ? $(this).attr("data-percentag") : 100;
					var elem_startColor = $(this).attr("data-start-color") ? $(this).attr("data-start-color") : '#0dc0c0';
					var elem_endColor = $(this).attr("data-end-color") ? $(this).attr("data-end-color") : '#0dc0c0';
					var elem_animation = $(this).attr("data-animation") ? $(this).attr("data-animation") : 'easeInOut';
					var elem_days_nums = $(this).attr("data-event") ? $(this).attr("data-event") : "";
					
					//-------> Days
					function showDays(firstDate,secondDate){
						  var startDay = new Date(firstDate);
						  var endDay = new Date(secondDate);
						  var millisecondsPerDay = 1000 * 60 * 60 * 24;
						  var millisBetween = startDay.getTime() - endDay.getTime();
						  var days = millisBetween / millisecondsPerDay;
						  return Math.floor(days);
					}
					var tdate = new Date();
					var dd = tdate.getDate(); //yields day
					var MM = tdate.getMonth(); //yields month
					var yyyy = tdate.getFullYear(); //yields year
					var today_is = ( MM+1) + "/" + dd + "/" + yyyy;
					var days = showDays(elem_days_nums,today_is);
					//------->
					
					var elem_percenty_color = '#666';
					var elem_progress_type = '';
					var circle;
					var iii;
					//-------->
					if($(this).hasClass("square") && $(this).closest(".white_section").length !== 0){
						elem_percenty_color = '#fff';
					}else if(site_dark == "yes" && $(this).hasClass("style1") && $(this).closest(".white_section").length !== 0){
						elem_percenty_color = '#666';
					}else if(site_dark == "no" && $(this).hasClass("style1") && $(this).closest(".white_section").length !== 0){
						elem_percenty_color = '#666';
					}else if(site_dark == "yes" || $(this).hasClass("square") || $(this).closest(".white_section").length !== 0 ){
						elem_percenty_color = '#fff';
						
					}else {
						elem_percenty_color = '#666';
					}
					
					//-------->
					if($(this).hasClass("path")){
						var scene = document.getElementsByTagName('object');
						var lengh_heart = scene.length;
						var path = new ProgressBar.Path(scene[0].contentDocument.querySelector('.heart-path'), {
							duration: 2000,
							easing: 'easeInOut', 
							step: function(state, path) {
								
							}
						});
												
						var $path_val = $this_this.find('.path_val .num');
						$path_val.countTo({
							from: 0,
							to: elem_percenty,
							speed: 2000,
						});
						path.animate(elem_percenty / 100);
						
					}else if($(this).hasClass("square")){
							circle = new ProgressBar.Square(element , {
							color: elem_startColor,
							trailColor: 'rgba(0,0,0,.07)',
							strokeWidth: 3.5,
							duration: 2000,
							easing: elem_animation, 
							
							from: { color: elem_startColor, width: 3.5 },
							to: { color: elem_endColor, width: 3.5 },
							text: {
								value: '0',
								color: elem_percenty_color,
							},
							step: function(state, circle) {
								circle.setText((circle.value() * 100).toFixed(0) + " %");
								circle.path.setAttribute('stroke', state.color);
								circle.path.setAttribute('stroke-width', state.width);
							}
							
						});
					}else if( $this_this.hasClass("seconds") ){
						    circle = new ProgressBar.Circle(element , {
							color: elem_startColor,
							trailColor: 'rgba(255,255,255,.1)',
							strokeWidth: 10,
							trailWidth: 2,
							duration: 200,
							easing: elem_animation, 
							
							from: { color: elem_startColor, width: 2 },
							to: { color: elem_endColor, width: 2 },
							text: {
								value: ' ',
								color: elem_percenty_color,
							},
							step: function(state, circle) {
								circle.path.setAttribute('stroke', state.color);
								circle.path.setAttribute('stroke-width', state.width);
							}
							
						});
						setInterval(function() {
							var second = new Date().getSeconds();
							var second_minus = 60 - second;
							circle.animate(second_minus / 60, function() {
								if (second === 0){
									second = 60;
									circle.setText(second_minus);
								}else{
									circle.setText(second_minus);
								}
								
							});
						}, 1000);
					}else if( $this_this.hasClass("minutes") ){
						    circle = new ProgressBar.Circle(element , {
							color: elem_startColor,
							trailColor: 'rgba(255,255,255,.1)',
							strokeWidth: 10,
							trailWidth: 2,
							duration: 800,
							easing: elem_animation, 
							
							from: { color: elem_startColor, width:2 },
							to: { color: elem_endColor, width: 2 },
							text: {
								value: ' ',
								color: elem_percenty_color,
							},
							step: function(state, circle) {
								circle.path.setAttribute('stroke', state.color);
								circle.path.setAttribute('stroke-width', state.width);
							}
							
						});
						iii = 0;
						setInterval(function() {
							var minutes = new Date().getMinutes();
							var minutes_minus = 60 - minutes;
							
							var $path_val = $this_this.find('.progressbar-text');
							if(iii === 0){
								$path_val.countTo({
									from: 0,
									to: minutes_minus,
									speed: 800,
								});
							}
							iii = 1;
							
							circle.animate(minutes_minus / 60, function() {
								if (minutes === 0){
									minutes = 60;
									circle.setText(minutes_minus);
								}else{
									circle.setText(minutes_minus);
								}
							});
						}, 1000);
					}else if( $this_this.hasClass("hours") ){
							circle = new ProgressBar.Circle(element , {
							color: elem_startColor,
							trailColor: 'rgba(255,255,255,.1)',
							strokeWidth: 10,
							trailWidth: 2,
							duration: 800,
							easing: elem_animation, 
							
							from: { color: elem_startColor, width: 2 },
							to: { color: elem_endColor, width: 2 },
							text: {
								value: ' ',
								color: elem_percenty_color,
							},
							step: function(state, circle) {
								circle.path.setAttribute('stroke', state.color);
								circle.path.setAttribute('stroke-width', state.width);
							}
							
						});
						iii = 0;
						setInterval(function() {
							var hours = new Date().getHours();
							var hours_minus = 24 - hours;
							
							var $path_val = $this_this.find('.progressbar-text');
							if(iii === 0){
								$path_val.countTo({
									from: 0,
									to: hours_minus,
									speed: 800,
								});
							}
							iii = 1;
							circle.animate(hours_minus / 24, function() {
								if (hours === 0){
									hours = 24;
									circle.setText(hours_minus);
								}else{
									circle.setText(hours_minus);
								}
							});
						}, 1000);
					}else if( $this_this.hasClass("days") ){
							circle = new ProgressBar.Circle(element , {
							color: elem_startColor,
							trailColor: 'rgba(255,255,255,.1)',
							strokeWidth: 10,
							trailWidth: 2,
							duration: 800,
							easing: elem_animation, 
							
							from: { color: elem_startColor, width: 2 },
							to: { color: elem_endColor, width: 2 },
							text: {
								value: "0",
								color: elem_percenty_color,
							},
							step: function(state, circle) {
								circle.path.setAttribute('stroke', state.color);
								circle.path.setAttribute('stroke-width', state.width);
							}
							
						});
						iii = 0;
						setInterval(function() {
							var $path_val = $this_this.find('.progressbar-text');
							if(iii === 0){
								$path_val.countTo({
									from: 0,
									to: days,
									speed: 800,
								});
							}
							iii = 1;
							
							circle.animate(days / 365, function() {
								circle.setText(days);
							});
						}, 1000);
					}else{
							circle = new ProgressBar.Circle(element , {
							color: elem_startColor,
							trailColor: 'rgba(0,0,0,.07)',
							strokeWidth: 10,
							trailWidth: 3,
							duration: 2000,
							easing: elem_animation, 
							
							from: { color: elem_startColor, width: 3 },
							to: { color: elem_endColor, width: 3 },
							text: {
								value: '0',
								color: elem_percenty_color,
							},
							step: function(state, circle) {
								circle.setText((circle.value() * 100).toFixed(0) + " %");
								circle.path.setAttribute('stroke', state.color);
								circle.path.setAttribute('stroke-width', state.width);
							}
							
						});
					}
					
					setTimeout(function() {
						$this_this.animate({
									opacity: 1,
						}, 1000 );
						
						$this_this.find(".progressbar-text").animate({
									opacity: 1,
						}, elem_delay);
						if($this_this.hasClass("path")){ 
						
						}else if ($this_this.hasClass("seconds") || $this_this.hasClass("minutes") || $this_this.hasClass("hours") || $this_this.hasClass("days") ){
							
						} else{
							circle.animate(elem_percenty / 100, function() {
								
							});
						}
						
					}, elem_delay);
				});
		});
});
$(document).ready(function(){
		// Review Scroll
		$('a[href=\'#tab-review\']').on('click touchstart', function() {
			scrollTo('#tabs_info', -50);
		});
		//----------> Owl Single Product Start   
		if($(".thumbs_gall_slider_con").length > 0){ 
				var item_thumbs = $(".gall_thumbs .item").length;
				var direction_nav = false;
				
				if(item_thumbs > 1){
					direction_nav = true;
				}
				/*
				if(item_thumbs > 0){
					$(".gall_thumbs").owlCarousel({
						rtl: isRTL,
						slideSpeed : 1000,
						autoplay: true,
						autoplayTimeout:4000,
						autoHeight : true,
						items:4,
						stopOnHover : true,
						nav : false,
						dots: true,
					});
				}*/
				$(".thumbs_gall_slider_larg").owlCarousel({
						rtl: isRTL,
						loop:false,
						slideSpeed : 1000,
						autoplay: false,
						autoplayTimeout:4000,
						autoHeight : false,
						items:1,
						stopOnHover : true,
						nav : direction_nav,
						navText : [
							"<span class='elem_owl_prev'><i class='fa fa-angle-left'></i></span>",
							"<span class='elem_owl_next'><i class='fa fa-angle-right'></i></span>"],
						dotsContainer: '.gall_thumbs',
						dots: true,
				});
				
		}
		//----------> Owl End
		//----------------------------------> Magnific Popup Lightbox
		if ( $.isFunction($.fn.magnificPopup) ) {
			/**/ 
			$('.expand_image').each(function(index, element) {
				$(this).click(function() {								
					$(this).parent().siblings("a").click();
					$(this).parent().siblings(".ave_galla").find("a:first").click();
					$(this).parent().siblings(".embed-container").find("a").click();
					return false;
				});
			});
			$('.featured_slide_block').each(function(index, element) {
				var gall_con = $(this);
				var expander = $(this).find("a.expand_img");
				expander.click(function() {								
					gall_con.find("a:first").click();
					return false;
				});
			});
			$('.ave_block').each(function(index, element) {
				var gall_con = $(this);
				var expander = $(this).find("a.expand_img");
				var expander_b = $(this).find("a.icon_expand");
				expander.click(function() {								
					gall_con.find("a:first").click();
					return false;
				});
				expander_b.click(function() {								
					gall_con.find("a:first").click();
					return false;
				});
			});
			$(".magnific-popup, a[data-rel^='magnific-popup']").magnificPopup({ 
				type: 'image',
				mainClass: 'mfp-with-zoom', // this class is for CSS animation below
				
				zoom: {
					enabled: true,
					duration: 300,
					easing: 'ease-in-out',
					// The "opener" function should return the element from which popup will be zoomed in
					// and to which popup will be scaled down
					// By defailt it looks for an image tag:
					opener: function(openerElement) {
						// openerElement is the element on which popup was initialized, in this case its <a> tag
						// you don't need to add "opener" option if this code matches your needs, it's defailt one.
						return openerElement.is('img') ? openerElement : openerElement.find('img');
					}
				}
				
			});
			
			$('.magnific-gallery, .thumbs_gall_slider_larg, .ave_galla').magnificPopup({
				delegate: 'a',
				type: 'image',
				
				gallery: {
					enabled: true
				},
				removalDelay: 500,
				callbacks: {
					beforeOpen: function() {
						this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
						this.st.mainClass = /*this.st.el.attr('data-effect')*/ "mfp-zoom-in";
					}
				},
				closeOnContentClick: true,
				// allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source
				midClick: true ,	  
				retina: {
					ratio: 1,
					replaceSrc: function(item, ratio) {
					  //return item.src.replace(/\.\w+$/, function(m) { return '@2x' + m; });
					  return item.src.replace(/\.\w+$/, function(m) { return m; });
					} 
				}
			  
			});
			
			$('.popup-youtube, .popup-vimeo, .popup-gmaps, .vid_con').magnificPopup({
				disableOn:700,
				type:'iframe',
				mainClass:'mfp-fade',
				removalDelay:160,
				preloader:false,
				fixedContentPos:false
			});
			
			$('.ajax-popup-link').magnificPopup({
				type: 'ajax',
				removalDelay: 500,
				mainClass: 'mfp-fade',
				callbacks: {
					beforeOpen: function() {
						this.st.mainClass = "mfp-fade elem_script_loaded";
					},
					parseAjax: function(mfpResponse) {
						
					},
					ajaxContentAdded: function() {
						$(".ajax_content_container").on("click", function(event){
							var target = $(event.target);
							if (target.hasClass("mfp-close")) {
								
							}else{
								event.stopPropagation();
							}
							
						});
						$.getScript('js/functions.js', function( data, textStatus, jqxhr ) { 
							$(".elem_script_loaded .ajax_content_container").css({"opacity" : "1"});
						});
					}
				},
				
			});
			
			$('.popup-with-zoom-anim').magnificPopup({
				type:'inline',
				fixedContentPos:false,
				fixedBgPos:true,
				overflowY:'auto',
				closeBtnInside:true,
				preloader:false,
				midClick:true,
				removalDelay:300,
				mainClass:'my-mfp-zoom-in'
			});
			$('.popup-with-move-anim').magnificPopup({
				type:'inline',
				fixedContentPos:false,
				fixedBgPos:true,
				overflowY:'auto',
				closeBtnInside:true,
				preloader:false,
				midClick:true,
				removalDelay:300,
				mainClass:'my-mfp-slide-bottom'
			});
		}
});
/**/ 

function handleSlimScroll(scroll_elem){
					$(scroll_elem).slimScroll({
						allowPageScroll: true, // allow page scroll when the element scroll is ended
						size: '10px',
						color: ($(scroll_elem).attr("data-handle-color")  ? $(this).attr("data-handle-color") : '#bbb'),
						wrapperClass: ($(scroll_elem).attr("data-wrapper-class")  ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
						railColor: ($(scroll_elem).attr("data-rail-color")  ? $(this).attr("data-rail-color") : '#eaeaea'),
						position: isRTL ? 'left' : 'right',
						//height: $(scroll_elem).css('height'),
						height: ($(scroll_elem).css('height')>0)?$(scroll_elem).css('height'):300,
						distance: '2px',
						alwaysVisible: ($(scroll_elem).attr("data-always-visible") == "1" ? true : false),
						railVisible: ($(scroll_elem).attr("data-rail-visible") == "1" ? true : false),
						disableFadeOut: true
					});
					$(scroll_elem).attr("data-initialized", "1");
}
//----------> sticky menu	
function nav_sticky(){
	if ($("body").hasClass('header-fixed')&&$.isFunction($.fn.sticky)) {
		var $navigation_bar = $("#navigation_bar");
		$navigation_bar.unstick();
		var mobile_menu_len = $navigation_bar.find(".mobile_menu").length;
		var side_header = $(".navigation_aside").length;
		if( mobile_menu_len === 0 && side_header === 0){
			$navigation_bar.sticky({
				topSpacing : 0,
				className : "sticky_menu",
				getWidthFrom : "body"
			});
		}else{
			$navigation_bar.unstick();
		}
	}
}

function getScreenWidth(){
	return document.documentElement.clientWidth || document.body.clientWidth || window.innerWidth;
}
    //========> Menu
	$.fn.initTheme = function(options){
		var whatTheLastWidth = getScreenWidth();
		var ifisdescktop = false;
		var MqL = 1170;
		
		var settings = {
			 duration: 300,
			 delayOpen: 0,
			 menuType: "horizontal", // horizontal - vertical 
			 position: "right", // right - left
			 parentArrow: true,
			 hideClickOut: true,
			 submenuTrigger: "hover",
			 backText: "Back to ",
			 clickToltipText: "Click",
		};
		$.extend( settings, options );	
		var nav_con = $(this);
		var $nav_con_parent = nav_con.parent("#main_nav");	
		var menu = $(this).find('#navigation');
		
		//=====> Mega Menu Top Space
		function megaMenuTop(){
			$(menu).find('.elem_mega_menu').each(function() {
                var top_space = $(this).parent('li').outerHeight();
				$(this).find(' > .mega_menu').css({"top" : top_space+"px", "width" : "100%"});
            });
		}
		megaMenuTop();
		
		//=====> Vertical and Horizontal	
		if(settings.menuType == "vertical"){
			$(menu).addClass("vertical_menu");
			if(settings.position == "right"){
				$(menu).addClass("position_right");
			}else{
				$(menu).addClass("position_left");
			}
		}else{
			$(menu).addClass("horizontal_menu");
		}
		
		//=====> Add Arrows To Parent li
		if(settings.parentArrow === true){
			$(menu).find("li.elem_menu li, li.elem_image_menu").each(function(){
				if($(this).children("ul").length > 0){
					$(this).children("a").append("<span class='parent_arrow elem_menu_arrow'></span>");
				}
			});
			
			$(menu).find("ul.mega_menu li ul li, .tab_menu_list > li").each(function(){
				if($(this).children("ul").length > 0){
					$(this).children("a").append("<span class='parent_arrow mega_arrow'></span>");
				}
			});
		}
		
		function handleNavSearch(){
			
		//Handle Search 
			if($('body.with-ajax_search #page_header input[name=\'search\']').length){
				$('body.with-ajax_search #page_header input[name=\'search\']').autocomplete({
					delay: 250,
					source: function(request, response) {
						if(encodeURIComponent(request).length>0){	
							$.ajax({
								url: 'index.php?route=avethemes/widget/quicksearch&search=' +  encodeURIComponent(request),
								dataType: 'html',
								success: function(data) {	
									if(data.length>0){	
										$('#page_header .nav_cart').removeClass('active');	
										$('#page_header .nav_search').addClass('active');	
										$('#page_header .search-widget').html(data).addClass('active');
											handleSlimScroll('.nav_cart_block');
										$('.nav_search').on('mouseleave', function() {
											$('body.with-ajax_search .header input[name=\'search\']').blur();
										});			
									}
								}
							});		
						}		
					}
					
				});
			}
			
		$('.btn-search').bind('click', function() {
			url = $('base').attr('href') + 'index.php?route=product/search';
					 
			var search =  $('.nav_search input[name=\'search\']').val();
			
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			var filter_category_id = $('.header select[name=\'filter_category_id\']').attr('value');
			
			if (filter_category_id) {
				url += '&category_id=' + encodeURIComponent(filter_category_id);
			}
			
			location = url;
		});
		$('.nav_search input[name=\'search\']').bind('keydown', function(e) {
			if (e.keyCode == 13) {
				url = $('base').attr('href') + 'index.php?route=product/search';
				 
				var ksearch = $('.nav_search input[name=\'search\']').val();
				
				if (ksearch) {
					url += '&search=' + encodeURIComponent(ksearch);
				}
				location = url;
			}
		});
        $('.nav_search_handle').on('click mouseover touchstart', function(){			
            if($('.menu-search').hasClass('active')==false){ 
				$('.menu-search').addClass('active');	    			
			}else{
				$('.menu-search').removeClass('active');	    	
			}
        });
		$('.menu-search.with-leave .search-box-wrapper').on('mouseleave', function() {
			$('.menu-search').removeClass('active');
			 $('.menu-search input').blur();
		});	
		$('.menu-search .btn-close').on('click touchstart', function() {
			$('.search-widget').removeClass('active');
			 $('.menu-search input').blur();
		});
		
			$(".nav_search").each(function(index, element) {
				var nav_search = $(this);
				$(".nav_search_handle").on("click", function(event){ 
				//nav_search.submit(function(event){
					event.stopPropagation();
					if(nav_search.hasClass("nav_search_small")){
						nav_search.removeClass("nav_search_small");
						nav_search.addClass("nav_search_large");
						if(getScreenWidth() <= 315 ){
							nav_search.siblings("#cart").animate({opacity: 0});
						}
						nav_search.siblings("#menu_navigation:not(.mobile_menu), .logo_container").animate({opacity: 0});
						return false;
					}
					
				});
				
				$(nav_search).on("click touchstart", function(e){
					e.stopPropagation();
				});
				$(document).on("click touchstart", function(e){
					if(nav_search.hasClass("nav_search_large")){
						nav_search.removeClass("nav_search_large");
						nav_search.addClass("nav_search_small");
						if(getScreenWidth() <= 315 ){
							nav_search.siblings("#cart").animate({opacity: 1});
						}
						nav_search.siblings("#menu_navigation:not(.mobile_menu), .logo_container").animate({opacity: 1});
					}
				});
			});
			if(getScreenWidth() < 1190){
				$("#navigation_bar").find(".nav_search").addClass("nav_search_small");
			}else{
				$("#navigation_bar").find(".nav_search").removeClass("nav_search_small");
			}
			$('.nav_search_close').on('click touchstart', function() {
				$(".nav_search").removeClass("nav_search_large").addClass("nav_search_small");
			});
		}
		var nav_search_func = new handleNavSearch();
		
		$(window).resize(function() {
			nav_search_func = new handleNavSearch();
			megaMenuTop();
			if( whatTheLastWidth > 992 && getScreenWidth() <= 992 && $("body").hasClass("navigation_aside")){
				$(menu).slideUp();
			}
			if( whatTheLastWidth <= 992 && getScreenWidth() > 992 && $("body").hasClass("navigation_aside")){
				$(menu).slideDown();
			}
			
			if(whatTheLastWidth <= 992 && getScreenWidth() > 992 && !$("body").hasClass("navigation_aside") ){
				resizeTabsMenu();
				removeTrigger();
                playMenuEvents();
			}
			if(whatTheLastWidth > 992 && getScreenWidth() <= 992){
				releaseTrigger();
				playMobileEvents();
				resizeTabsMenu();
				$(menu).slideUp();
			} 
			whatTheLastWidth = getScreenWidth(); 
			return false;
		});
		
		//======> After Refresh
		function ActionAfterRefresh(){
			if(getScreenWidth() <= 992 || $("body").hasClass("navigation_aside") ){
				releaseTrigger();
				playMobileEvents();
				resizeTabsMenu();
				
			} else {
				resizeTabsMenu();
				removeTrigger();
                playMenuEvents();
			}
		}
		
		var action_after_ref = new ActionAfterRefresh();
		
		//======> Mobile Menu
		function playMobileEvents(){
			$(".nav_trigger").removeClass("nav-is-visible");
			$(menu).find("li, a").unbind();
			if($(nav_con).hasClass("mobile_menu")){
				$(nav_con).find("li.elem_menu").each(function(){
					if($(this).children("ul").length > 0){
						$(this).children("a").not(':has(.parent_arrow)').append("<span class='parent_arrow elem_menu_arrow'></span>");
					}
				});
			}
			megaMenuEvents();
		    			
			$(menu).find("li:not(.has-children):not(.go-back)").each(function(){
				$(this).removeClass("opened_menu");
				if($(this).children("ul").length > 0){
					var $li_li_li = $(this);
					$(this).children("a").on("click", function(event){
						var curr_act = $(this);

						if(!$(this).parent().hasClass("opened_menu")){
							$(this).parent().addClass("opened_menu");
							$(this).parent().siblings("li").removeClass("opened_menu");
							if($(this).parent().hasClass("tab_menu_item")){
								$(this).parent().addClass("active");
								$(this).parent().siblings("li").removeClass("active");
							}
							$(this).siblings("ul").slideDown(settings.duration);
							$(this).parent("li").siblings("li").children("ul").slideUp(settings.duration);
							setTimeout(function(){ 
								var curr_position = curr_act.offset().top;
								$('body,html').animate({
									//scrollTop: curr_position ,
									}, {queue:false, duration: 900, easing:"easeInOutExpo"}
								);
							}, settings.duration);
							
							return false;
						}
						else{
							$(this).parent().removeClass("opened_menu");
							$(this).siblings("ul").slideUp(settings.duration);
							if($li_li_li.hasClass("mobile_menu_toggle") || $li_li_li.hasClass("tab_menu_item")){
								return false;
							}
						}
					});
				}
			});
		}
	
		function megaMenuEvents(){
			$(menu).find('li.elem_mega_menu ul').removeClass("moves-out");
			$(menu).find('.go-back, .mega_toltip').remove();
			$(menu).find('li.elem_mega_menu > ul').hover(function() {
				
				$(this).find(".mega_menu_in ul").each(function(index, element) {
					var $mega_ul = $(this);
                    var its_height = 0;
										
					$mega_ul.children('li').each(function(index, element) {
						var ul_li_num = $(this).innerHeight();
						its_height += ul_li_num;
					});
					$mega_ul.attr("data-height", its_height);
                });
			});
			$(menu).find('ul.mega_menu li li').each(function(index, element) {
                var $mega_element = $(this);
				if($mega_element.children('ul').length > 0){
					$mega_element.addClass("has-children");
					$mega_element.children('ul').addClass("is-hidden");
				}
			});
			$(menu).find('ul.mega_menu li.has-children').children('ul').each(function(index, element) {
				var $mega_ul = $(this);
				var its_height = 0;
				$mega_ul.children('li').each(function(index, element) {
					var ul_li_num = $(this).innerHeight();
					its_height += ul_li_num;
				});
                $mega_ul.attr("data-height", its_height);
				
				var $mega_link = $mega_ul.parent('li').children('a');
				var $mega_title = $mega_ul.parent('li').children('a').text();
				$("<span class='mega_toltip'>" + settings.clickToltipText +"</span>").prependTo($mega_link);
				
				if(!$mega_link.find('.go-back').length){
					$("<li class='go-back'><a href='#'>" + settings.backText + $mega_title +"</a></li>").prependTo($mega_ul);
				}
				
			});
			
			$(menu).find('ul.mega_menu li.has-children').children('a').on('click touchstart', function(event){
                event.preventDefault();
				var selected = $(this);
				
				if( selected.next('ul').hasClass('is-hidden') ) {
					var ul_height = parseInt(selected.next('ul').attr("data-height"));
					var link_height = parseInt(selected.innerHeight());
					var all_height = ul_height + link_height;
					
					selected.addClass('selected').next('ul').removeClass('is-hidden').end().parent('.has-children').parent('ul').addClass('moves-out');
					selected.closest('.mega_menu_in').animate({height: all_height});
					
					selected.parent('.has-children').siblings('.has-children').children('ul').addClass('is-hidden').end().children('a').removeClass('selected');
					//====> if is mobile
					if(selected.closest('#menu_navigation').hasClass("mobile_menu")){
						selected.parent('.has-children').removeClass("mega_parent_hidden").prevAll('li').slideUp(settings.duration);
					}
					
				}
				
			});
			
			//submenu items - go back link
			$('.go-back').on('click touchstart', function(){
				var link_height = parseInt($(this).parent("ul").parent("li").parent("ul").attr("data-height"));
					
				$(this).parent('ul').addClass('is-hidden').parent('.has-children').parent('ul').removeClass('moves-out');
				$(this).closest('.mega_menu_in').animate({height: link_height});
				//====> if is mobile
				if($(this).closest('#menu_navigation').hasClass("mobile_menu")){
					$(this).parent('ul').parent('li').removeClass("mega_parent_hidden").prevAll('li').slideDown(settings.duration);
				}
				
                return false;
			});
		}
		
		
		//======> Desktop Menu
		function playMenuEvents(){
			$(menu).children('li').children('ul').hide(0);
			$(menu).find("li, a").unbind();
			$(menu).slideDown(settings.duration);
			$(menu).find('ul.tab_menu_list').each(function(index, element) {
				var tab_link = $(this).children('li').children('a');
				$("<span class='mega_toltip'>" + settings.clickToltipText +"</span>").prependTo(tab_link);
                $(this).children('li').on('mouseover', function(){
					if(!$(this).hasClass('active')){
						$(this).children('ul').stop().fadeIn();
						$(this).siblings().children('ul').stop().fadeOut();
						$(this).addClass('active');
						$(this).siblings().removeClass('active');
					}
				});
			});
			
			megaMenuEvents();
			
			$(menu).find('li.elem_menu, > li').hover(function() {
				var li_link = $(this).children('a');
				$(this).children('ul').stop().fadeIn(settings.duration);
			}, function() {
				$(this).children('ul').stop().fadeOut(settings.duration);
			});
		}
		
		//======> Trigger Button Mobile Menu
		function releaseTrigger(){
			$(nav_con).find(".nav_trigger").unbind();
			$(nav_con).addClass('mobile_menu');
			$nav_con_parent.addClass('has_mobile_menu');
			
			$(nav_con).find('.nav_trigger').each(function(index, element) {
				var $trigger_mob = $(this);
                $trigger_mob.on('click touchstart', function(e){
					e.preventDefault();
					if($(this).hasClass('nav-is-visible')){
						$(this).removeClass('nav-is-visible');
						$(menu).slideUp(settings.duration);
						
					}else{
						$(this).addClass('nav-is-visible');
						$(menu).slideDown(settings.duration, function(){
						});
					}
				});
				
            });
			
		}
		
		//=====> get tabs menu height
		function resizeTabsMenu(){	
			function thisHeight(){
                /*jshint validthis:true */
				return $(this).outerHeight();
			}
		    $.fn.sandbox = function(fn) {
				var element = $(this).clone(), result;
				element.css({visibility: 'hidden', display: 'block'}).insertAfter(this);
				element.attr('style', element.attr('style').replace('block', 'block !important'));
				var thisULMax = Math.max.apply(Math, $(element).find("ul:not(.image_menu)").map(thisHeight));
				result = fn.apply(element);
				element.remove();
				return thisULMax;
			};
		    $(".tab_menu").each(function() {
				$(this).css({"height" : "inherit"});
				if(!$(nav_con).hasClass("mobile_menu")){
					var height = $(this).sandbox(function(){ return this.height(); });
					$(this).height(height);
				}
				
			});		
		}
		resizeTabsMenu();
		//=====> End get tabs menu height
		
		function removeTrigger(){
			$(nav_con).removeClass('mobile_menu');
			$nav_con_parent.removeClass('has_mobile_menu');
		}
		
		//----------> sticky menu
		nav_sticky();
		
	};
	
	//-----------> Menu
$("#menu_navigation").initTheme({});