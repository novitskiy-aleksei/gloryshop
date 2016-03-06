<?php if($display=='fan_box'){?>
<div class="content_row">
<div id="fb-root"></div>
<script type="text/javascript">(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php echo $sections['locale']; ?>/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <?php if($heading_title){?><h3 class="heading_title"><?php echo $heading_title; ?></h3><?php } ?>
  <div class="fb-page" data-href="https://www.facebook.com/<?php echo $sections['page_url']; ?>" data-width="<?php echo $sections['width']; ?>" data-height="<?php echo $sections['height']; ?>" data-hide-cover="<?php echo $sections['show_cover']; ?>" data-show-facepile="<?php echo $sections['show_faces']; ?>" data-show-posts="<?php echo $sections['show_posts']; ?>"></div>
</div>
<?php } ?>


<?php if($display=='chat_box'){?>
<div class="fb_chat <?php echo $sections['position']; ?>" style="width:<?php echo $sections['cwidth']; ?>px;">
	<div>
		<div id="fb_title" class="fb_title"><span><?php echo $heading_title; ?></span> <button class="fb_close close">×</button></div>
		<div id="fb-root"></div>
		<div class="fb-page" data-href="https://www.facebook.com/<?php echo $sections['page_url']; ?>" data-small-header="true" data-adapt-container-width="false" data-height="<?php echo $sections['cheight']; ?>" data-width="<?php echo $sections['cwidth']; ?>" data-hide-cover="<?php echo $sections['show_cover']; ?>" data-show-facepile="<?php echo $sections['show_faces']; ?>" data-show-posts="false" data-tabs="messages"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/<?php echo $sections['page_url']; ?>"><a href="https://www.facebook.com/<?php echo $sections['page_url']; ?>"></a></blockquote></div></div>
        </div>
<script type="text/javascript">
$(document).ready(function() { 
if($('.fb_chat.bottom_left,.fb_chat.bottom_right').length){
	var fb_chat = $('.fb_chat').clone();
	 $('.fb_chat').remove();
	$('#footer').after(fb_chat);
}
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php echo $sections['locale']; ?>/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

		if(localStorage.getItem("fb_chat_status") == 1){
			$('.fb_chat').toggleClass('on_hide');
		}
		$('#fb_title').click(function(){
			jQuery('.fb_chat').toggleClass('on_hide');
			if(jQuery('.fb_chat').hasClass('on_hide')){
				localStorage.setItem("fb_chat_status", 1);
			}else{
				localStorage.setItem("fb_chat_status", 0);
			}
		});
});
</script>
	</div>
    
<?php } ?>