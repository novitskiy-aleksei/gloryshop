<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
            

             <div class="content content_spacer">
           <?php if(!empty($heading_title)){?>
			<div class="heading_title <?php echo $heading_align;?> upper">
			    <h2><span class="line"><?php if(!empty($icon)){?><i class="<?php echo $icon;?>"></i><?php } ?></span><?php echo $heading_title;?></h2>
			</div>
       <?php } ?>
    <?php 
//social configuration
$skin_fb_type	= $sections['fb_type'];
$skin_fb_color_scheme	= $sections['fb_color_scheme'];
$skin_fb_num_posts	= $sections['fb_num_posts'];
$skin_fb_order_by	= $sections['fb_order_by'];
$skin_fb_id	= $sections['fb_id'];
$fb_lang	= $sections['fb_lang'];
?>
<style type="text/css">
.fb_iframe_widget_fluid span,
.fb_iframe_widget iframe {
  width: 100% !important;
  max-width: 100% !important;
}
</style>

<meta property="fb:<?php echo $skin_fb_type;?>" content="<?php echo $skin_fb_id;?>"/>
<div class="fb-comments" 
data-href="<?php echo $ave->get('Current_URL'); ?>" 
data-colorscheme="<?php echo $skin_fb_color_scheme; ?>" 
data-numposts="<?php echo $skin_fb_num_posts; ?>" 
data-order-by="<?php echo $skin_fb_order_by; ?>" 
data-width="100%"></div>
<script>
!function(d,s,id){
	var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
	if(!d.getElementById(id)){
		js=d.createElement(s);
		js.id=id;
		js.src=p+"://connect.facebook.net/<?php echo $fb_lang;?>/sdk.js#xfbml=1&version=v2.3";
		fjs.parentNode.insertBefore(js,fjs);
	}
}(document,"script","facebook-jssdk");
</script>            
</div>
</div>