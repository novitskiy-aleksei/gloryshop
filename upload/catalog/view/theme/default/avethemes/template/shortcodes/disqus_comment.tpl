<div class="section clearfix <?php echo $bgmode;?> <?php echo $paralax_class;?>" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
            

             <div class="content content_spacer">
           <?php if(!empty($heading_title)){?>
			<div class="heading_title <?php echo $heading_align;?> upper">
			    <h2><span class="line"><?php if(!empty($icon)){?><i class="<?php echo $icon;?>"></i><?php } ?></span><?php echo $heading_title;?></h2>
			</div>
       <?php } ?>
                  <div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = '<?php echo $sections['disqus_shortname'];?>';    
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = 'https://a.disquscdn.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
</div>
</div>