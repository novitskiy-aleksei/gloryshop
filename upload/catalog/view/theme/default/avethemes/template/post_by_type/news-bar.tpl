<?php if ($articles) { ?>
<div class="section elem_new_con clearfix">
    <div class="content clearfix">
        <div class="elem_new_title_con">
            <h4>
                <i class="fa fa-bell-o"></i>
                <span><?php echo $heading_title; ?></span>
            </h4>
        </div>
        <div class="elem_new_bar">
            <div id="<?php echo $module;?>" class="elem_new_bar_slider">
<?php foreach ($articles as $article) { ?>
                <div class="news_item">
                    <i class="fa fa-angle-right"></i>
                    <a href="<?php echo $article['href'];?>"><span><?php echo $article['name']; ?></span></a>
                </div>
<?php } ?><!--for article --> 
            </div>
            <div class="elem_new_bar_controll">
                <a class="elem_new_bar_controll_btn play" href="#">
                    <i class="pause_news fa fa-pause"></i>
                    <i class="play_news fa fa-play"></i>
                </a>
            </div>
        </div>
    </div>
    <script type="text/javascript"><!--//
$(document).ready(function(){
	var rtl_direction = false;
		if( $("html").css('direction') == 'rtl' || $("html").attr('dir') == 'rtl') {
			rtl_direction = true;
		};
	$("#<?php echo $module;?>").owlCarousel({
				rtl: rtl_direction,
				loop:true,
				autoWidth:false,
					 responsive: {
					0: {items: 1},
					479: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
					768: {items: <?php echo ($carousel_limit>1)?'2':'1';?>},
					979: {items: <?php echo ($carousel_limit>1)?'3':'1';?>},
					1199: {items: <?php echo $carousel_limit;?>}
				},
				smartSpeed : 2000,
				autoplay: true,
				autoplayTimeout:3000,
				stopOnHover : true,
			});
		$('.elem_new_bar_controll_btn').on('click', function(event){
			event.preventDefault();
			if($(this).hasClass('pause')){
				$(this).removeClass("pause").addClass("play");
				owl_news.trigger('owl.play', 2000);
			}else{
				$(this).removeClass("play").addClass("pause");	
				owl_news.trigger('owl.stop', 2000);			
			}
		});
});
	//--> </script>
</div>
<?php } ?>