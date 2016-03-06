
var isRTL = false;
var site_dark = ( $("body").hasClass("body_dark") ? "yes" : "no" );
var text_direction = "ltr";
if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
	text_direction = "rtl";
	var isRTL = true;
};
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
					 
			var search = $('.header input[name=\'search\']').attr('value');
			
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
				 
				var search = $('input[name=\'search\']').attr('value');
				
				if (search) {
					url += '&search=' + encodeURIComponent(search);
				}
				
				location = url;
			}
		});
        $('.nav_search_handle').on('click mouseover', function(){			
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
		$('.menu-search .btn-close').on('click', function() {
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
			
			$(menu).find('ul.mega_menu li.has-children').children('a').on('click', function(event){
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
			$('.go-back').on('click', function(){
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