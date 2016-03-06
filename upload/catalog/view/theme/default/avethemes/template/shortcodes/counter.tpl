<div class="section centered <?php echo $bgmode;?> <?php echo $paralax_class;?>">
      <?php if(!empty($icon)){?>
<span class="section_icon"><i class="<?php echo $icon;?>"></i></span>
             <?php } ?>
    <div class="content large_spacer">
      <?php if(!empty($heading_title)){?>
		<div class="heading_title <?php echo $heading_align;?> upper <?php echo $heading_size;?>">
		    <h2><span class="line"><span class="dot"></span></span><?php echo $heading_title;?></h2>
		</div>
      <?php } ?>
        <div class="counter_<?php echo ($display=='counter')?'a':'b';?> clearfix">
         <?php  foreach($sections as $section){?>
            <div class="col-md-<?php echo $grid_limit;?> col-sm-6 col-xs-12">
                <div class="counter animated fadeInDown visible" data-animation="fadeInDown" data-animation-delay="1200"> <span class="icon"><i class="<?php echo $section['icon'];?>"></i></span> <span class="value" data-speed="4000" data-from="0" data-to="<?php echo $section['num'];?>"><?php echo $section['num'];?></span> <span class="title">
                <?php if($section['btn_href']){?>
                <a href="<?php echo $section['btn_href'];?>" target="<?php echo $section['btn_target'];?>">
                <?php echo (isset($section['title'][$language_id]))?str_replace('../image/','image/',html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8')):'';?>
                </a>
                <?php }else{ ?>
                <?php echo (isset($section['title'][$language_id]))?str_replace('../image/','image/',html_entity_decode($section['title'][$language_id], ENT_QUOTES, 'UTF-8')):'';?>
                
                <?php } ?>
                </span> </div>
            </div>
      <?php } ?>
        </div>
    </div>
</div>