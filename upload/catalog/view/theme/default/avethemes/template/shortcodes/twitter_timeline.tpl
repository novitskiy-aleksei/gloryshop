<?php global $ave;?>
<div class="content_row">
      <?php if(!empty($heading_title)){?>
    <h3 class="heading_title"><?php echo $heading_title;?></h3>
       <?php } ?>
    <div class="clearfix">
    <style type="text/css">
#twitter_widget,
#twitter_widget iframe {
  width: 100% !important;
  max-width: 100% !important;
}
</style>
    <div class="twitter_widget">
         
    <?php if($sections['twitter_button']){?>   <a href="https://twitter.com/<?php echo $sections['twitter_username'];?>" class="twitter-follow-button f-right" data-show-count="false" data-lang="<?php echo $sections['twitter_lang'];?>" data-show-screen-name="false"><?php echo $sections['twitter_username'];?></a><?php } ?>
    <div id="twitter_widget">
                 <a class="twitter-timeline" data-dnt="true" data-theme="<?php echo $sections['twitter_style'];?>" data-link-color="<?php echo $ave->get('skin_color');?>" data-chrome="transparent noheader nofooter noborders noscrollbar" data-border-color="#ffffff" lang="<?php echo $sections['twitter_lang'];?>" data-tweet-limit="<?php echo $sections['twitter_shown'];?>" data-show-replies="true" href="https://twitter.com/<?php echo $twitter_username;?>" data-widget-id="<?php echo $sections['twitter_widget_id'];?>">@<?php echo $sections['twitter_username'];?></a> 
                 
         </div>       
	</div>
<script>
!function(d,s,id){
	var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
	if(!d.getElementById(id)){
		js=d.createElement(s);
		js.id=id;
		js.src=p+"://platform.twitter.com/widgets.js";
		fjs.parentNode.insertBefore(js,fjs);
	}
}(document,"script","twitter-wjs");
</script>
      </div>
</div>