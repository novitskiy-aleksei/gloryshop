<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
            

             <div class="content content_spacer">
           <?php if(!empty($heading_title)){?>
			<div class="heading_title <?php echo $heading_align;?> upper">
			    <h2><span class="line"><?php if(!empty($icon)){?><i class="<?php echo $icon;?>"></i><?php } ?></span><?php echo $heading_title;?></h2>
			</div>
       <?php } ?>
<script src="https://apis.google.com/js/plusone.js"></script>
<style type="text/css">
#gplus_comments,
#gplus_comments iframe {
  width: 100% !important;
  max-width: 100% !important;
  max-height: 100% !important;
}
</style>
<div id="gplus_comments" style="height:300px;"></div>
<script>
gapi.comments.render('gplus_comments', {
    href: window.location,
    first_party_property: 'BLOGGER',
    view_type: 'FILTERED_POSTMOD'
});
</script>
</div>
</div>