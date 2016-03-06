<div class="section bg_fixed" style="<?php echo !empty($bgcolor)?'background-color:'.$bgcolor.';':''?><?php echo !empty($bgimage)?'background-image: url(image/'.$bgimage.');':''?>">
            <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
             
	     <div class="content large_spacer">
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
		</div>
		<div class="elem-tabs tabs2 upper_title">
			<nav class="clearfix">
			    <ul class="tabs-navi">
<?php $i=0;
 foreach($sections as $section){?>
				<li><a data-content="<?php echo $module;?>-<?php echo $i;?>" class="<?php echo ($i==0)?'selected':'';?>" href="#"><span><i class="<?php echo $section['icon'];?>"></i></span><?php echo (isset($section['title'][$language_id]))?$section['title'][$language_id]:'';?></a></li>
<?php
$i++;
 } ?>
			    </ul> <!-- tabs-navi -->
			</nav>
		    
			<ul class="tabs-body">
<?php $i=0;
 foreach($sections as $section){?>
			    <li data-content="<?php echo $module;?>-<?php echo $i;?>" class="<?php echo ($i==0)?'selected':'';?> clearfix">
                <?php echo (isset($section['description'][$language_id]))?str_replace('../image/','image/',html_entity_decode($section['description'][$language_id], ENT_QUOTES, 'UTF-8')):'';?>
			    </li><?php
$i++;
 } ?>
		    
			</ul>
			<!-- Tabs Content -->
		</div> 
		<!-- End Tabs Container --> 
	    </div>

</div>