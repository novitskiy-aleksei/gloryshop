$(document).ready(function(){
		// options
		var large_html = '<div class="theme_option"><div class="option_header"><h4>Style Options</h4><a href="#" class="open_options animate"><i class="fa fa-cog"></i></a></div><div class="option_block clearfix"><h4 class="option_title">Color Scheme</h4><ul class="option_color_list clearfix"><li><a class="color_scheme animate op_color_a" href="#" data-color="#CD2122" data-color-a="#3A2B2B" data-color-b="#2C1D1D"></a></li><li><a class="color_scheme animate op_color_b" href="#" data-color="#00AFB2" data-color-a="#2d414b" data-color-b="#22323A"></a></li><li><a class="color_scheme animate op_color_c" href="#" data-color="#009673" data-color-a="#334947" data-color-b="#203837"></a></li><li><a class="color_scheme animate op_color_d" href="#" data-color="#9854B3" data-color-a="#2A2A2A" data-color-b="#1A1A1A"></a></li><li><a class="color_scheme animate op_color_e" href="#" data-color="#F86923" data-color-a="#2F2E2E" data-color-b="#1F1E1E"></a></li><li><a class="color_scheme animate op_color_f" href="#" data-color="#D91897" data-color-a="#412E36" data-color-b="#322229"></a></li><li><a class="color_scheme animate" href="#" data-color="#374F99"></a></li><li><a class="color_scheme animate" href="#" data-color="#684035"></a></li><li><a class="color_scheme animate" href="#" data-color="#178E94"></a></li><li><a class="color_scheme animate" href="#" data-color="#973A4B"></a></li><li><a class="color_scheme animate" href="#" data-color="#F3605D"></a></li><li><a class="color_scheme animate" href="#" data-color="#79AF33"></a></li></ul></div><div class="option_block clearfix" data-show-hide=".header-top"><h4 class="option_title">Show Top Bar</h4><a class="option_button active" data-event="show" href="#">Show</a><a class="option_button" data-event="hide" href="#">Hide</a></div> <div class="option_block clearfix" data-toggle-class="header-top-colored" data-toggle-on="body"><h4 class="option_title">Top Bar Style</h4><a class="option_button active" data-event="class_remove" href="#">Default</a><a class="option_button" data-event="class_add" href="#">Colored</a></div> <div class="option_block clearfix" data-toggle-class="body_boxed" data-toggle-on="body"><h4 class="option_title">Layout</h4><a class="option_button active" data-event="class_remove" href="#">Wide</a><a class="option_button" data-event="class_add" href="#">Boxed</a></div> <div class="option_block clearfix" data-toggle-class="body_dark" data-toggle-on="body"><h4 class="option_title">Dark & Light</h4><a class="option_button active" data-event="class_remove" href="#">Light</a><a class="option_button" data-event="class_add" href="#">Dark</a></div> <div class="option_block clearfix" data-toggle-class="header_light" data-toggle-on="body"><h4 class="option_title">Navigation Color</h4><a class="option_button active" data-event="class_add" href="#">Light</a><a class="option_button" data-event="class_remove" href="#">Dark</a></div> <div class="option_block clearfix" data-toggle-class="sub_nav_dark" data-toggle-on="body"><h4 class="option_title">SupMenu Color</h4><a class="option_button" data-event="class_remove" href="#">Light</a><a class="option_button active" data-event="class_add" href="#">Dark</a></div></div>';
		
		$("body").append(large_html);
		$('.navigation .nav-menu ul li i, .mobile-drop ul li i').addClass('op_nav_icon_on').removeClass('op_nav_icon_off');
		$('#pagetop').addClass('op_show').removeClass('op_hide');
		
		//=============================================> open and close
	
		$('a.open_options').click(function(e) {
			
			if($(this).hasClass('opened')){
					
				$(".theme_option").animate({
					left: '-236px',
				}, 500, function () {
					$('a.open_options').removeClass("opened");
				});
				
			} else {
				
				$(".theme_option").animate({
					left: '0px',
				}, 500, function () {
					$('a.open_options').addClass("opened");
				});
				
			}
			e.preventDefault();
		});
		
		//=============================================> Opt Buttons
		$('ul.option_color_list li a').each(function() {
			var my_color_active = $(this).data('color');
			$(this).css('background-color', my_color_active);
		});
		
		$('ul.option_color_list li a').on('click', function(event) {
				   
			var my_color_active = $(this).data('color');
			var color_a = $(this).data('color-a');
			var color_b = $(this).data('color-b');
			
			$.ajax({
				type: 'GET',
				url: 'index.php?route=avethemes/common/style&profile_color='+ encodeURIComponent(my_color_active),				
				beforeSend: function() {},
				success: function(data){
					$('head').append('<style>'+data+'</style>');
					
				}
			});
			
			event.preventDefault();
					
		});	
		
		
		$('a.option_button').click(function(event) {
			var $this_btn = $(this);
			var show_hide = $this_btn.parent(".option_block").attr("data-show-hide") ? $this_btn.parent(".option_block").attr("data-show-hide") : "";	
			var toogle_class = $this_btn.parent(".option_block").attr("data-toggle-class") ? $this_btn.parent(".option_block").attr("data-toggle-class") : "";
			var toogle_on = $this_btn.parent(".option_block").attr("data-toggle-on") ? $this_btn.parent(".option_block").attr("data-toggle-on") : "";	
			
			var btn_event = $this_btn.attr("data-event");	
			
			$this_btn.addClass('active').siblings().removeClass('active');
			
			//=====> show_hide
			if(show_hide !== "" && btn_event == "show" ){
				$(show_hide).slideDown();	
						
			}else if(show_hide !== "" && btn_event == "hide" ){
				$(show_hide).slideUp();			
			}
			//=====> toogle_class
			if(toogle_class !== "" && btn_event == "class_add" ){
				$(toogle_on).addClass(toogle_class);	
						
			}else if(toogle_class !== "" && btn_event == "class_remove" ){
				$(toogle_on).removeClass(toogle_class);			
			}
			
			event.preventDefault();
		});
		//----------> end site demo
});